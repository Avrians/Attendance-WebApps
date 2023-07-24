<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Rekap Laporan!</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        @page {
            size: A3
        }

        #title {
            font-size: 16px;
            font-weight: bold;
            font-family: Arial, Arial, Helvetica, sans-serif;
        }

        .tabeldatakaryawan {
            margin-top: 40px;
        }

        .tabeldatakaryawan tr td {
            padding: 5px;
        }

        .tabelpresensi {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .tabelpresensi tr th {
            border: 1px solid #131212;
            padding: 8px;
            background-color: #dbdbdb;
            font-size: 10px;
        }

        .tabelpresensi tr td {
            border: 1px solid #131212;
            padding: 5px;
            font-size: 12px;
        }

        .foto {
            width: 40px;
            height: 30px;
        }
    </style>
</head>

<body class="A3 landscape">
    @php
        function selisih($jam_masuk, $jam_keluar)
        {
            [$h, $m, $s] = explode(':', $jam_masuk);
            $dtAwal = mktime($h, $m, $s, '1', '1', '1');
            [$h, $m, $s] = explode(':', $jam_keluar);
            $dtAkhir = mktime($h, $m, $s, '1', '1', '1');
            $dtSelisih = $dtAkhir - $dtAwal;
            $totalmenit = $dtSelisih / 60;
            $jam = explode('.', $totalmenit / 60);
            $sisamenit = $totalmenit / 60 - $jam[0];
            $sisamenit2 = $sisamenit * 60;
            $jml_jam = $jam[0];
            return $jml_jam . ':' . round($sisamenit2);
        }
    @endphp
    <section class="sheet padding-10mm">
        <table style="width: 100%">
            <tr>
                <td style="width: 30px">
                    <img src="{{ asset('assets/img/logoptwanasari.jpg') }}" width="70" height="70" alt=""
                        style="padding-right: 10px">
                </td>
                <td>
                    <span id="title">
                        REKAP ABSENSI KARYAWAN<br>
                        PERIODE {{ strtoupper($namabulan[$bulan]) }} {{ $tahun }}<br>
                        PT. WANASARI NUSANTARA<br>
                    </span>
                    <span><i>Jln. Wanasari Sungai Buluh, Singingi Hilir, Kuantan SIngingi, Riau 29563</i></span>
                </td>
            </tr>
        </table>
        <table class="" width="100%" style="margin-top: 20px; border-collapse: collapse; ">
            <tr>
                <th rowspan="2" style="border: 1px solid #131212; background-color: #dbdbdb; font-size: 13px">NIK
                </th>
                <th rowspan="2" style="border: 1px solid #131212; background-color: #dbdbdb; font-size: 13px">
                    Nama<br>
                    Karyawan</th>
                <th colspan="31" style="border: 1px solid #131212; background-color: #dbdbdb; font-size: 13px">Tanggal
                </th>
                <th rowspan="2" style="border: 1px solid #131212; background-color: #dbdbdb; font-size: 13px">TH</th>
                <th rowspan="2" style="border: 1px solid #131212; background-color: #dbdbdb; font-size: 13px">TT</th>
            </tr>
            <tr>
                <?php
                    for($i=1; $i<=31; $i++){
                ?>
                <th style="border: 1px solid #131212; background-color: #dbdbdb; font-size: 13px">{{ $i }}
                </th>
                <?php
                }
                ?>
            </tr>
            @foreach ($rekap as $d)
                <tr>
                    <td style="border: 1px solid #131212; font-size: 12px; padding: 2px; text-align: center">
                        {{ $d->nik }}</td>
                    <td style="border: 1px solid #131212; font-size: 12px; padding: 2px; text-align: center">
                        {{ $d->nama_lengkap }}</td>
                    <?php
                    $totalhadir = 0;
                    $totalterlambat = 0;
                    for($i=1; $i<=31; $i++){
                        $tgl = "tgl_".$i;
                        if(empty($d->$tgl)){
                            $hadir = ['',''];
                            $totalhadir += 0;
                            $totalterlambat += 0;

                        }else{
                            $hadir = explode("-", $d->$tgl);
                            $totalhadir += 1;
                            if($hadir[0] >= $d->jam_masuk){
                                $totalterlambat += 1;
                            }
                        }
                        ?>
                    <td style="border: 1px solid #131212; font-size: 12px; padding: 2px; text-align: center">
                        <span
                            style="font-size: 10px; color:{{ $hadir[0] >= $d->jam_masuk ? 'red' : '' }}">{{ $hadir[0] }}</span>
                        <br>
                        <span
                            style="font-size: 10px; color:{{ $hadir[1] <= $d->jam_pulang ? 'red' : '' }}">{{ $hadir[1] == '00:00:00' ? '-' : $hadir[1] }}</span>
                    </td>
                    <?php
                }
                ?>
                    <td style="border: 1px solid #131212; font-size: 12px; padding: 2px; text-align: center">
                        {{ $totalhadir }}</td>
                    <td style="border: 1px solid #131212; font-size: 12px; padding: 2px; text-align: center">
                        {{ $totalterlambat }}</td>

                </tr>
            @endforeach
        </table>

        <table width="100%" style="margin-top: 100px">
            <tr>
                <td></td>
                <td style="text-align: center">
                    Kuantan Singingi, {{ date('d-m-Y') }}
                </td>
            </tr>
            <tr>
                <td style="text-align: center; vertical-align: bottom" height="100px">
                    <u>Joko Priyanto</u><br>
                    <i><b>Estate Manajer</b></i>
                </td>
                <td style="text-align: center; vertical-align: bottom" height="100px">
                    <u>Martunus S.Ag</u><br>
                    <i><b>KTU</b></i>
                </td>
            </tr>
        </table>
    </section>

</body>

</html>
