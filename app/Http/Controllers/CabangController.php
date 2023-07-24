<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CabangController extends Controller
{
    public function index(){
        $cabang = DB::table('cabang')->orderBy('kode_cabang')->get();
        return view('cabang.index', compact('cabang'));
    }

    public function store(Request $request){
        $kode_cabang = $request->kode_cabang;
        $nama_cabang = $request->nama_cabang;
        $lokasi_cabang = $request->lokasi_cabang;
        $radius = $request->radius;

        try {
            $data = [
                'kode_cabang' => $kode_cabang,
                'nama_cabang' => $nama_cabang,
                'lokasi_cabang' => $lokasi_cabang,
                'radius' => $radius
            ];
            DB::table('cabang')->insert($data);
            return Redirect::back()->with(['success' => 'Data Berhasil di simpan']);
        } catch (\Exception $e) {
            if($e->getCode()==23000){
                $message = " Kode Lokasi ".$kode_cabang." Sudah digunakan";
            }
            return Redirect::back()->with(['warning' => 'Gagal menambahkan Lokasi baru karena '.$message]);

        }
    }

    public function edit(Request $request){
        $kode_cabang = $request->kode_cabang;
        $cabang = DB::table('cabang')->where('kode_cabang', $kode_cabang)->first();
        return view('cabang.edit', compact('cabang'));
    }

    public function update($kode_cabang, Request $request){
        $nama_cabang = $request->nama_cabang;
        $lokasi_cabang = $request->lokasi_cabang;
        $radius = $request->radius;
        $data = [
            'nama_cabang' => $nama_cabang,
            'lokasi_cabang' => $lokasi_cabang,
            'radius' => $radius
        ];
        $update = DB::table('cabang')->where('kode_cabang', $kode_cabang)->update($data);
        if($update){
            return Redirect::back()->with(['success' => 'Data berhasil di ubah']);
        }else{
            return Redirect::back()->with(['warning' => 'Data Gagal di ubah']);
        }
    }

    public function delete($kode_cabang){
        $delete = DB::table('cabang')->where('kode_cabang', $kode_cabang)->delete();
        if($delete){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus']);
        }else{
            return Redirect::back()->with(['warning' => 'Data Gagal Di Hapus']);
        }
    }
}