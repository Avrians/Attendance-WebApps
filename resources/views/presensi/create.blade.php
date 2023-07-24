@extends('layouts.presensi')
@section('header')
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">E-Presensi</div>
        <div class="right">
            <p id="jam"></p>
        </div>
    </div>


    <style>
        .webcam-capture,
        .webcam-capture video {
            display: inline-block;
            width: 100% !important;
            margin: auto;
            height: auto !important;
            border-radius: 15px;
        }

        #map {
            height: 200px;
        }

        .jam-digital-malasngoding {
            background-color: #27272783;
            position: absolute;
            top: 65px;
            right: 13px;
            z-index: 9999;
            width: 130px;
            border-radius: 10px;
            padding: 5px;
        }

        .jam-digital-malasngoding p {
            color: #fff;
            font-size: 16px;
            text-align: left;
            margin-top: 0;
            margin-bottom: 0;
        }

        .right {
            position: fixed;
            padding-right: 14px;
        }

        .right p {
            color: #fff;
            font-size: 16px;
            text-align: center;
            margin-top: 0;
            margin-bottom: 0;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
@endsection

@section('content')
    <div class="row" style="margin-top: 60px">
        <div class="col">
            <input type="hidden" id="lokasi">
            <div class="webcam-capture"></div>
        </div>
    </div>
    <div class="jam-digital-malasngoding">
        <p>{{ date('d-m-Y') }}</p>

        <p>{{ $jamkerja->nama_jamkerja }}</p>
        <p>Mulai : {{ date('H:i', strtotime($jamkerja->awal_jammasuk)) }}</p>
        <p>Masuk : {{ date('H:i', strtotime($jamkerja->jam_masuk)) }}</p>
        <p>Akhir : {{ date('H:i', strtotime($jamkerja->akhir_jammasuk)) }}</p>
        <p>Pulang : {{ date('H:i', strtotime($jamkerja->jam_pulang)) }}</p>
    </div>
    <div class="row">
        <div class="col">

            @if ($cek > 0)
                <button id="takeabsen" class="btn btn-danger btn-block">
                    <ion-icon name="camera-outline"></ion-icon>Absen Pulang
                </button>
            @else
                <button id="takeabsen" class="btn btn-primary btn-block">
                    <ion-icon name="camera-outline"></ion-icon>Absen Masuk
                </button>
            @endif

        </div>
    </div>
    <div class="row mt-2">
        <div class="col">
            <div id="map"></div>
        </div>
    </div>

    <audio id="notifikasi_in1">
        <source src="{{ asset('assets/sound/in1.mp3') }}" type="audio/mpeg">
    </audio>
    <audio id="notifikasi_in2">
        <source src="{{ asset('assets/sound/in2.mp3') }}" type="audio/mpeg">
    </audio>
    <audio id="notifikasi_out1">
        <source src="{{ asset('assets/sound/out1.mp3') }}" type="audio/mpeg">
    </audio>
    <audio id="notifikasi_out2">
        <source src="{{ asset('assets/sound/out2.mp3') }}" type="audio/mpeg">
    </audio>
    <audio id="notifikasi_diluarRadius">
        <source src="{{ asset('assets/sound/diluarRadius.mp3') }}" type="audio/mpeg">
    </audio>
@endsection

@push('myscript')
    <script type="text/javascript">
        window.onload = function() {
            jam();
        }

        function jam() {
            var e = document.getElementById('jam'),
                d = new Date(),
                h, m, s;
            h = d.getHours();
            m = set(d.getMinutes());
            s = set(d.getSeconds());

            e.innerHTML = h + ':' + m + ':' + s;

            setTimeout('jam()', 1000);

        }

        function set(e) {
            e = e < 10 ? '0' + e : e;
            return e;
        }
    </script>
    <script>
        var notifikasi_in1 = document.getElementById('notifikasi_in1');
        var notifikasi_in2 = document.getElementById('notifikasi_in2');
        var notifikasi_out1 = document.getElementById('notifikasi_out1');
        var notifikasi_out2 = document.getElementById('notifikasi_out2');
        var notifikasi_diluarRadius = document.getElementById('notifikasi_diluarRadius');

        Webcam.set({
            height: 480,
            width: 640,
            image_format: 'jpeg',
            jpeg_quality: 80
        });

        Webcam.attach('.webcam-capture');

        var lokasi = document.getElementById('lokasi');
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        }

        function successCallback(position) {
            lokasi.value = position.coords.latitude + ", " + position.coords.longitude;
            var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 16);
            var lokasikantor = "{{ $lokasikantor->lokasi_cabang }}";
            var lok = lokasikantor.split(",");
            var latkantor = lok[0];
            var longkantor = lok[1];
            var radius = "{{ $lokasikantor->radius }}";

            L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }).addTo(map);

            var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);

            //Lokasi yang di pakai untuk absensi berdasarkan tabel cabang
            var circle = L.circle([latkantor, longkantor], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: radius
            }).addTo(map);

            //PT Wanasari
            var circle1 = L.circle([-0.2864155, 101.4696525], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 100
            }).addTo(map);
            //divisi 1
            var circle2 = L.circle([-0.277005, 101.457203], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 20
            }).addTo(map);
            //divisi 2
            var circle3 = L.circle([-0.303376, 101.454769], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 20
            }).addTo(map);
            //divisi 3
            var circle4 = L.circle([-0.294790, 101.450597], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 20
            }).addTo(map);

        }

        function errorCallback() {

        }

        $("#takeabsen").click(function(e) {
            Webcam.snap(function(uri) {
                image = uri;
            });

            var lokasi = $("#lokasi").val();

            $.ajax({
                type: 'POST',
                url: '/presensi/store',
                data: {
                    _token: "{{ csrf_token() }}",
                    image: image,
                    lokasi: lokasi
                },
                cache: false,
                success: function(respond) {
                    var status = respond.split("|");
                    if (status[0] == "success") {
                        if (status[2] == "in1") {
                            notifikasi_in1.play();
                        } else {
                            notifikasi_in2.play();
                        }
                        Swal.fire({
                            title: 'Berhasil!',
                            text: status[1],
                            icon: 'success',
                        })
                        setTimeout("location.href='/dashboard'", 4000);
                    } else {
                        if (status[2] == "radius") {
                            notifikasi_diluarRadius.play();
                        } else if (status[2] == "out1") {
                            notifikasi_out1.play();
                        } else {
                            notifikasi_out2.play();
                        }
                        Swal.fire({
                            title: 'Gagal!',
                            text: status[1],
                            icon: 'error',
                        })
                    }
                }
            });
        });
    </script>
@endpush
