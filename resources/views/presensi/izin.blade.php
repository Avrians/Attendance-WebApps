@extends('layouts.presensi')

@section('header')
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Izin - Sakit - Cuti</div>
        <div class="right"></div>
    </div>
@endsection

@section('content')
    <div class="row" style="margin-top: 70px">
        <div class="col">
            @php
                $messagesuccess = Session::get('success');
                $messageerror = Session::get('error');
                
            @endphp
            @if (Session::get('success'))
                <div class="alert alert-success">
                    {{ $messagesuccess }}
                </div>
            @endif
            @if (Session::get('error'))
                <div class="alert alert-danger">
                    {{ $messageerror }}
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col">
            @foreach ($dataizin as $d)
                <ul class="listview image-listview">
                    <li>
                        <div class="item">
                            {{--  @php
                                $path = Storage::url('uploads/izinsakit/' . $d->file);
                            @endphp
                            <img src="{{ url($path) }}" alt="file" class="" width="60px" height="60px"
                                style="margin-right: 10px">  --}}
                            <div class="in">
                                <div>
                                    <b>{{ date('d-M-Y', strtotime($d->tgl_pengajuan)) }}</b>
                                    <b>
                                        @if ($d->status == 'i')
                                            {{ '(Izin)' }}
                                        @elseif($d->status == 's')
                                            {{ '(Sakit)' }}
                                        @else
                                            {{ '(Cuti)' }}
                                        @endif
                                    </b><br>
                                    <small class="text-mute">{{ $d->keterangan }}</small>
                                </div>
                                @if ($d->status_approved == 0)
                                    <span class="badge bg-warning">Pending...</span>
                                @elseif($d->status_approved == 1)
                                    <span class="badge bg-success">Berhasil</span>
                                @elseif($d->status_approved == 2)
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </div>
                        </div>
                    </li>
                </ul>
            @endforeach
        </div>
    </div>
    <div class="fab-button bottom-right" style="margin-bottom: 70px">
        <a href="/presensi/buatizin" class="fab">
            <ion-icon name="add-outline"></ion-icon>
        </a>
    </div>
@endsection
