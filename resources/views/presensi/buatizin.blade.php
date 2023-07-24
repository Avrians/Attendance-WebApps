@extends('layouts.presensi')

@section('header')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
    <style>
        .datepicker-modal {
            max-height: 460px !important;
        }

        .datepicker-date-display {
            background-color: #0f3a7e !important;
        }
    </style>
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Pengajuan Izin</div>
        <div class="right"></div>
    </div>
@endsection

@section('content')
    <form method="POST" action="/presensi/storeizin" id="frmizin" style="margin-top: 70px" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <select name="status" id="status" class="form-control">
                        <option value="">-- Pilih Pengajuan --</option>
                        <option value="i">Izin</option>
                        <option value="s">Sakit</option>
                        <option value="c">Cuti</option>
                    </select>
                </div>

                <div class="form-group">
                    <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control" placeholder="Keterangan"></textarea>
                </div>

                {{--  UPLOAD FILE  --}}
                <div class="custom-file-upload" id="fileUpload1">
                    <input type="file" name="file" id="file"
                        accept=".text, .docx, .doc, .pdf, .xls, .png, .jpg, .jpeg">
                    <label for="file">
                        <span>
                            <strong>
                                <ion-icon name="cloud-upload-outline" role="file" class="md hydrated"
                                    aria-label="cloud upload outline"></ion-icon>
                                <i>Tap to Upload</i>
                            </strong>
                        </span>
                    </label>
                </div>

                <div class="form-group">
                    <button class="btn btn-primary w-100">Kirim</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('myscript')
    <script>
        var currYear = (new Date()).getFullYear();

        $(document).ready(function() {
            $(".datepicker").datepicker({
                format: "yyyy-mm-dd"
            });

            $("#tgl_pengajuan").change(function(e) {
                var tgl_pengajuan = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: '/presensi/cekpengajuanizin',
                    data: {
                        _token: "{{ csrf_token() }}",
                        tgl_pengajuan: tgl_pengajuan
                    },
                    cache: false,
                    success: function(respond) {
                        if (respond == 1) {
                            Swal.fire({
                                title: 'Oops !',
                                text: 'Anda sudah pernah melakukan pengajuan pada tanggal ini!',
                                icon: 'warning',
                            }).then((result) => {
                                $("#tgl_pengajuan").val("");
                            });
                        }
                    }
                });
            });

            $("#frmizin").submit(function() {
                var status = $("#status").val();
                var keterangan = $("#keterangan").val();
                var file = $("#file").val();
                if (status == "") {
                    Swal.fire({
                        title: 'Oops !',
                        text: 'Pilih Pengajuan',
                        icon: 'warning',
                    });
                    return false;
                } else if (keterangan == "") {
                    Swal.fire({
                        title: 'Oops !',
                        text: 'Keterangan Harus Diisi',
                        icon: 'warning',
                    });
                    return false;
                } else if (file == "") {
                    Swal.fire({
                        title: 'Oops !',
                        text: 'File Harus Diisi',
                        icon: 'warning',
                    });
                    return false;
                }
            });
        });
    </script>
@endpush
