<?php

namespace App\Http\Controllers;

use App\Models\Setjamkerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class KonfigurasiController extends Controller
{
    public function lokasikantor(){
        $lokasikantor = DB::table('konfig_lokasi')->where('id', 1)->first();

        return view('konfigurasi.lokasikantor', compact('lokasikantor'));
    }

    public function updatelokasikantor(Request $request){
        $lokasi_kantor = $request->lokasi_kantor;
        $radius = $request->radius;
        $keterangan = $request->keterangan;
        $data = [
            'lokasi_kantor' => $lokasi_kantor,
            'radius' => $radius,
            'keterangan' => $keterangan
        ];
        $update = DB::table('konfig_lokasi')->where('id', 1)->update($data);

        if($update){
            return Redirect::back()->with(['success'=> 'Data berhasil di ubah']);
        }else{
            return Redirect::back()->with(['error'=> 'Data Gagal di ubah']);
        }
    }

    public function jamkerja(){
        $jamkerja = DB::table('jam_kerja')->orderBy('kode_jamkerja')->get();
        return view('konfigurasi.jamkerja', compact('jamkerja'));
    }

    public function storejamkerja(Request $request){
        $kode_jamkerja = $request->kode_jamkerja;
        $nama_jamkerja = $request->nama_jamkerja;
        $awal_jammasuk = $request->awal_jammasuk;
        $jam_masuk = $request->jam_masuk;
        $akhir_jammasuk = $request->akhir_jammasuk;
        $jam_pulang = $request->jam_pulang;

        $data = [
            'kode_jamkerja' => $kode_jamkerja,
            'nama_jamkerja' => $nama_jamkerja,
            'awal_jammasuk' => $awal_jammasuk,
            'jam_masuk' => $jam_masuk,
            'akhir_jammasuk' => $akhir_jammasuk,
            'jam_pulang' => $jam_pulang
        ];

        try {
            DB::table('jam_kerja')->insert($data);
            return Redirect::back()->with(['success' => 'Data Berhasil disimpan']);
        } catch (\Exception $e) {
            if($e->getCode()==23000){
                $message = " Kode Jam Kerja ".$kode_jamkerja." Sudah digunakan";
            }
            return Redirect::back()->with(['warning'=>'Gagal menambahkan Data Jam Kerja karena '.$message]);
        }
    }

    public function editjamkerja(Request $request){
        $kode_jamkerja = $request->kode_jamkerja;
        $jamkerja = DB::table('jam_kerja')->where('kode_jamkerja', $kode_jamkerja)->first();

        return view('konfigurasi.editjamkerja', compact('jamkerja'));
    }

    public function update($kode_jamkerja, Request $request){
        $kode_jamkerja = $request->kode_jamkerja;
        $nama_jamkerja = $request->nama_jamkerja;
        $awal_jammasuk = $request->awal_jammasuk;
        $jam_masuk = $request->jam_masuk;
        $akhir_jammasuk = $request->akhir_jammasuk;
        $jam_pulang = $request->jam_pulang;

        try {
            $data = [
                'nama_jamkerja' => $nama_jamkerja,
                'awal_jammasuk' => $awal_jammasuk,
                'jam_masuk' => $jam_masuk,
                'akhir_jammasuk' => $akhir_jammasuk,
                'jam_pulang' => $jam_pulang
            ];

            DB::table('jam_kerja')->where('kode_jamkerja', $kode_jamkerja)->update($data);
            return Redirect::back()->with(['success'=>'Data Berhasil di ubah']);

        } catch (\Exception $e) {
            return Redirect::back()->with(['warning'=>'Data Gagal di ubah']);
        }
    }

    public function delete($kode_jamkerja){
        $delete = DB::table('jam_kerja')->where('kode_jamkerja', $kode_jamkerja)->delete();
        if($delete){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus']);
        }else{
            return Redirect::back()->with(['warning' => 'Data Gagal Di Hapus']);
        }
    }

    public function setjamkerja($nik){

        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        $jamkerja = DB::table('jam_kerja')->orderBy('nama_jamkerja')->get();
        $cek_jamkerja = DB::table('konfigurasi_jamkerja')->where('nik', $nik)->count();
        if($cek_jamkerja > 0){
            $set_jamkerja = DB::table('konfigurasi_jamkerja')->where('nik', $nik)->get();
            return view('konfigurasi.editsetjamkerja', compact('karyawan', 'jamkerja', 'set_jamkerja'));
        }else{
            return view('konfigurasi.setjamkerja', compact('karyawan', 'jamkerja'));
        }
    }

    public function storesetjamkerja(Request $request){
        $nik = $request->nik;
        $hari = $request->hari;
        $kode_jamkerja = $request->kode_jamkerja;

        for ($i=0; $i < count($hari); $i++) {
            $data[] = [
                'nik' => $nik,
                'hari' => $hari[$i],
                'kode_jamkerja' => $kode_jamkerja[$i]
            ];
        }

        try {
            Setjamkerja::insert($data);
            return redirect('/karyawan')->with(['success' => 'Jam Kerja Berhasil di Simpan']);

        } catch (\Exception $e) {
            return redirect('/karyawan')->with(['warning' => 'Jam Kerja Gagal di Simpan']);

        }
    }

    public function updatesetjamkerja(Request $request){
        $nik = $request->nik;
        $hari = $request->hari;
        $kode_jamkerja = $request->kode_jamkerja;

        for ($i=0; $i < count($hari); $i++) {
            $data[] = [
                'nik' => $nik,
                'hari' => $hari[$i],
                'kode_jamkerja' => $kode_jamkerja[$i]
            ];
        }
        DB::beginTransaction();
        try {
            DB::table('konfigurasi_jamkerja')->where('nik', $nik)->delete();
            Setjamkerja::insert($data);
            DB::commit();
            return redirect('/karyawan')->with(['success' => 'Jam Kerja Berhasil di Ubah']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/karyawan')->with(['warning' => 'Jam Kerja Gagal di Ubah']);

        }
    }
}