@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Konfigurasi
                    </div>
                    <h2 class="page-title">
                        Edit Jam Kerja <span class="badge bg-danger" style="margin-left: 8px">
                            {{ $karyawan->nama_lengkap }}</span>
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <table class="table">
                        <tr>
                            <th width="200">NIK</th>
                            <td width="20">:</td>
                            <td>{{ $karyawan->nik }}</td>
                        </tr>
                        <tr>
                            <th width="200">Nama Karyawan</th>
                            <td width="20">:</td>
                            <td>{{ $karyawan->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <th width="200">Jabatan</th>
                            <td width="20">:</td>
                            <td>{{ $karyawan->jabatan }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <form action="/konfigurasi/updatesetjamkerja" method="post">
                        @csrf
                        <input type="hidden" name="nik" value="{{ $karyawan->nik }}">

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Hari</th>
                                    <th>Jam Kerja</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($set_jamkerja as $dd)
                                    <tr>
                                        <td>{{ $dd->hari }}
                                            <input type="hidden" name="hari[]" value="{{ $dd->hari }}">
                                        </td>
                                        <td>
                                            <select name="kode_jamkerja[]" id="kode_jamkerja" class="form-select">
                                                <option value="">-- Pilih Jam Kerja --</option>
                                                @foreach ($jamkerja as $d)
                                                    <option {{ $d->kode_jamkerja == $dd->kode_jamkerja ? 'selected' : '' }}
                                                        value="{{ $d->kode_jamkerja }}">{{ $d->nama_jamkerja }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button class="btn btn-primary w-100" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24"
                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                <path d="M16 5l3 3"></path>
                            </svg>
                            Edit</button>
                    </form>
                </div>

                <div class="col-6">
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="6">Konfigurasi Jam Kerja Karyawan</th>
                            </tr>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Awal Masuk</th>
                                <th>Jam Masuk</th>
                                <th>Akhir Masuk</th>
                                <th>Jam Pulang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jamkerja as $d)
                                <tr>
                                    <td>{{ $d->kode_jamkerja }}</td>
                                    <td>{{ $d->nama_jamkerja }}</td>
                                    <td>{{ $d->awal_jammasuk }}</td>
                                    <td>{{ $d->jam_masuk }}</td>
                                    <td>{{ $d->akhir_jammasuk }}</td>
                                    <td>{{ $d->jam_pulang }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
