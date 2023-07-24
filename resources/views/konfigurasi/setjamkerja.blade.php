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
                        Jam Kerja <span class="badge bg-danger" style="margin-left: 8px">
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
                    <form action="/konfigurasi/storesetjamkerja" method="post">
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
                                <tr>
                                    <td>Senin
                                        <input type="hidden" name="hari[]" value="senin">
                                    </td>
                                    <td>
                                        <select name="kode_jamkerja[]" id="kode_jamkerja" class="form-select">
                                            <option value="">-- Pilih Jam Kerja --</option>
                                            @foreach ($jamkerja as $d)
                                                <option value="{{ $d->kode_jamkerja }}">{{ $d->nama_jamkerja }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Selasa</td>
                                    <input type="hidden" name="hari[]" value="selasa">

                                    <td>
                                        <select name="kode_jamkerja[]" id="kode_jamkerja" class="form-select">
                                            <option value="">-- Pilih Jam Kerja --</option>
                                            @foreach ($jamkerja as $d)
                                                <option value="{{ $d->kode_jamkerja }}">{{ $d->nama_jamkerja }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Rabu</td>
                                    <input type="hidden" name="hari[]" value="rabu">

                                    <td>
                                        <select name="kode_jamkerja[]" id="kode_jamkerja" class="form-select">
                                            <option value="">-- Pilih Jam Kerja --</option>
                                            @foreach ($jamkerja as $d)
                                                <option value="{{ $d->kode_jamkerja }}">{{ $d->nama_jamkerja }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Kamis</td>
                                    <input type="hidden" name="hari[]" value="kamis">

                                    <td>
                                        <select name="kode_jamkerja[]" id="kode_jamkerja" class="form-select">
                                            <option value="">-- Pilih Jam Kerja --</option>
                                            @foreach ($jamkerja as $d)
                                                <option value="{{ $d->kode_jamkerja }}">{{ $d->nama_jamkerja }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Jumat</td>
                                    <input type="hidden" name="hari[]" value="jumat">

                                    <td>
                                        <select name="kode_jamkerja[]" id="kode_jamkerja" class="form-select">
                                            <option value="">-- Pilih Jam Kerja --</option>
                                            @foreach ($jamkerja as $d)
                                                <option value="{{ $d->kode_jamkerja }}">{{ $d->nama_jamkerja }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>sabtu</td>
                                    <input type="hidden" name="hari[]" value="sabtu">

                                    <td>
                                        <select name="kode_jamkerja[]" id="kode_jamkerja" class="form-select">
                                            <option value="">-- Pilih Jam Kerja --</option>
                                            @foreach ($jamkerja as $d)
                                                <option value="{{ $d->kode_jamkerja }}">{{ $d->nama_jamkerja }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button class="btn btn-primary w-100" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"></path>
                                <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                                <path d="M14 4l0 4l-6 0l0 -4"></path>
                            </svg>
                            Simpan</button>
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
