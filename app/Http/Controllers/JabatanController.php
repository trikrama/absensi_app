<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class JabatanController extends Controller
{
    public function index(Request $request)
    {
        $nama_jabatan = $request->nama_jabatan;
        $query = Jabatan::query();
        $query->select('*');
        if (!empty($nama_jabatan)) {
            $query->where('nama_jabatan', 'like', '%' . $nama_jabatan . '%');
        }
        $jabatan = $query->get();
        // $departemen = DB::table('departemen')->orderBy('kode_dept')->get();
        return view('jabatan.index', compact('jabatan'));
    }


    public function store(Request $request)
    {
        $nama_jabatan = $request->nama_jabatan;
        $data = [
            'nama_jabatan' => $nama_jabatan
        ];

        $cek = DB::table('jabatan')->where('nama_jabatan', $nama_jabatan)->count();
        if ($cek > 0) {
            return Redirect::back()->with(['warning' => 'Data dengan Nama Jabatan.' . $nama_jabatan . ' Sudah Ada']);
        }
        $simpan = DB::table('jabatan')->insert($data);
        if ($simpan) {
            return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan']);
        }
    }

    public function edit(Request $request)
    {
        $id_jabatan = $request->id_jabatan;
        $jabatan = DB::table('jabatan')->where('id', $id_jabatan)->first();
        return view('jabatan.edit', compact('jabatan'));
    }

    public function update($id_jabatan, Request $request)
    {
        try {
            $request->validate([
                'nama_jabatan' => 'required',
            ]);

            $nama_jabatan = $request->nama_jabatan;
            $data = [
                'nama_jabatan' => $nama_jabatan
            ];
    
            $update = DB::table('jabatan')->where('id', $id_jabatan)->update($data);
            // if ($update) {
                return Redirect::back()->with(['success' => 'Data Berhasil Di Update']);
            // } else {
                // return Redirect::back()->with(['warning' => 'Data Gagal Di Update']);
            // }
        }catch (\Exception $e) {
            dd($e->getMessage());
            return Redirect::back()->with(['warning' => 'Data Gagal Di Update (' . $e->getMessage().')']);
        }

    

    }

    public function delete($id)
    {
        $hapus = DB::table('jabatan')->where('id', $id)->delete();
        if ($hapus) {
            return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Di Hapus']);
        }
    }
}
