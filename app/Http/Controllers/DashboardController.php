<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $hariini = date('Y-m-d');
        $bulanini = date('m') * 1;
        $tahunini = date('Y');
        $nik = Auth::guard('karyawan')->user()->nik;
        $presensihariini = DB::table('presensi')->where('nik', $nik)->where('tgl_presensi', $hariini)->first();

        $historibulanini = DB::table('presensi')
        ->where('nik', $nik)
        ->whereRaw('MONTH(tgl_presensi)="'. $bulanini.'"')
        ->whereRaw('YEAR(tgl_presensi)="'.$tahunini.'"')
        ->orderBy('tgl_presensi', 'desc')
        ->get();

        $rekappresensi = DB::table('presensi')
        ->selectRaw('COUNT(nik) as jmlhadir, SUM(IF(jam_in > jam_masuk,1,0)) as jmlterlambat')
        ->leftJoin('jam_kerja', 'presensi.kode_jamkerja', '=', 'jam_kerja.kode_jamkerja')
        ->where('nik', $nik)
        ->whereRaw('MONTH(tgl_presensi)="'. $bulanini.'"')
        ->whereRaw('YEAR(tgl_presensi)="'.$tahunini.'"')
        ->first();

        $leaderboard = DB::table('presensi')
        ->join('karyawan','presensi.nik', '=', 'karyawan.nik')
        ->where('tgl_presensi', $hariini)
        ->orderBy('jam_in')
        ->get();

        $namabulan = ["", "Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];

        $rekapizin = DB::table('pengajuan_izin')
        ->selectRaw('SUM(IF(status = "i",1,0)) as jmlizin, SUM(IF(status = "s",1,0)) as jmlsakit, SUM(IF(status = "c",1,0)) as jmlcuti')
        ->where('nik', $nik)
        ->whereRaw('MONTH(tgl_pengajuan)="'. $bulanini.'"')
        ->whereRaw('YEAR(tgl_pengajuan)="'.$tahunini.'"')
        ->where('status_approved', 1)
        ->first();

        return view('dashboard.dashboard', compact('presensihariini','historibulanini','namabulan','bulanini','tahunini','rekappresensi','leaderboard', 'rekapizin'));
    }

    public function dashboardadmin(){

        $hariini = date('Y-m-d');

        $rekappresensi = DB::table('presensi')
        ->selectRaw('COUNT(nik) as jmlhadir, SUM(IF(jam_in > jam_masuk,1,0)) as jmlterlambat')
        ->leftJoin('jam_kerja', 'presensi.kode_jamkerja', '=', 'jam_kerja.kode_jamkerja')
        ->where('tgl_presensi', $hariini)
        ->first();

        $rekapizin = DB::table('pengajuan_izin')
        ->selectRaw('SUM(IF(status = "i",1,0)) as jmlizin, SUM(IF(status = "s",1,0)) as jmlsakit, SUM(IF(status = "c",1,0)) as jmlcuti')
        ->where('tgl_pengajuan', $hariini)
        ->where('status_approved', 1)
        ->first();

        return view('dashboard.dashboardadmin', compact('rekappresensi','rekapizin'));
    }

}