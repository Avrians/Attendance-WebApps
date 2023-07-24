<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class DepartemenController extends Controller
{
    public function index(Request $request){
        $nama_dept = $request->nama_dept;
        $query = Departemen::query();
        $query->select('*');
        if(!empty($nama_dept)){
            $query->where('nama_dept', 'like', '%'. $nama_dept . '%');
        }
        $departemen = $query->get();

        return view('departemen.index', compact('departemen'));
    }

    public function store(Request $request){
        $kode_dept = $request->kode_dept;
        $nama_dept = $request->nama_dept;
        $data = [
            'kode_dept' => $kode_dept,
            'nama_dept' => $nama_dept
        ];

        $cek = DB::table('departemen')->where('kode_dept',$kode_dept)->count();
        if($cek>0){
            return Redirect::back()->with(['warning' => 'Gagal Simpan Data Karena Kode Lokasi '.$kode_dept.' Sudah Digunakan']);
        }
        $simpan = DB::table('departemen')->insert($data);
        if($simpan){
            return Redirect::back()->with(['success' => 'Data berhasil disimpan']);
        }else {
            return Redirect::back()->with(['warning' => 'Data gagal disimpan']);

        }
    }

    public function edit(Request $request){
        $kode_dept = $request->kode_dept;
        $departemen = DB::table('departemen')->where('kode_dept', $kode_dept)->first();
        return view('departemen.edit', compact('departemen'));
    }

    public function update($kode_dept, Request $request){
        $nama_dept = $request->nama_dept;
        $data = [
            'nama_dept' => $nama_dept
        ];
        $update = DB::table('departemen')->where('kode_dept', $kode_dept)->update($data);
        if($update){
            return Redirect::back()->with(['success' => 'Data berhasil di ubah']);
        }else{
            return Redirect::back()->with(['warning' => 'Data Gagal di ubah']);
        }
    }

    public function delete($kode_dept){
        $delete = DB::table('departemen')->where('kode_dept', $kode_dept)->delete();
        if($delete){
            return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus']);
        }else{
            return Redirect::back()->with(['warning' => 'Data Gagal Di Hapus']);
        }
    }
}