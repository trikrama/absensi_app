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


    // public function store(Request $request)
    // {
    //     $nama_jabatan = $request->nama_jabatan;
    //     $data = [
    //         'nama_jabatan' => $nama_jabatan
    //     ];

    //     $cek = DB::table('jabatan')->where('nama_jabatan', $nama_jabatan)->count();
    //     if ($cek > 0) {
    //         return Redirect::back()->with(['warning' => 'Data dengan Nama Jabatan.' . $nama_jabatan . ' Sudah Ada']);
    //     }
    //     $simpan = DB::table('jabatan')->insert($data);
    //     if ($simpan) {
    //         return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
    //     } else {
    //         return Redirect::back()->with(['warning' => 'Data Gagal Disimpan']);
    //     }
    // }
    public function store(Request $request)
    {
        $nama_jabatan = $request->nama_jabatan;
        $data = ['nama_jabatan' => $nama_jabatan];

        // Cek apakah nama jabatan sudah ada
        $cek = DB::table('jabatan')->where('nama_jabatan', $nama_jabatan)->count();
        if ($cek > 0) {
            return Redirect::back()->with(['warning' => 'Data dengan Nama Jabatan "' . $nama_jabatan . '" Sudah Ada']);
        }

        // Mulai transaksi
        DB::beginTransaction();
        try {
            // Simpan ke tabel jabatan
            $jabatanId = DB::table('jabatan')->insertGetId($data);

            // Simpan ke tabel instrument_title
            DB::table('instrument_titles')->insert([
                'title' => $nama_jabatan,
                // 'jabatan_id' => $jabatanId, // Jika ada relasi dengan tabel jabatan
            ]);

            DB::commit();
            return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan: ' . $e->getMessage()]);
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

            // Dapatkan nama_jabatan lama sebelum update
            $jabatanLama = DB::table('jabatan')->where('id', $id_jabatan)->value('nama_jabatan');

            $data = [
                'nama_jabatan' => $nama_jabatan
            ];

            // Mulai transaksi
            DB::beginTransaction();

            // Update data di tabel jabatan
            DB::table('jabatan')->where('id', $id_jabatan)->update($data);

            // Update data di tabel instrument_title berdasarkan kecocokan title
            DB::table('instrument_titles')->where('title', $jabatanLama)->update(['title' => $nama_jabatan]);

            DB::commit();
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update']);
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(['warning' => 'Data Gagal Di Update (' . $e->getMessage() . ')']);
        }
    }



    public function delete($id)
    {
        try {
            // Dapatkan nama_jabatan sebelum dihapus
            $namaJabatan = DB::table('jabatan')->where('id', $id)->value('nama_jabatan');

            // Mulai transaksi
            DB::beginTransaction();

            // Hapus data dari tabel instrument_title berdasarkan kecocokan title
            DB::table('instrument_titles')->where('title', $namaJabatan)->delete();

            // Hapus data dari tabel jabatan
            DB::table('jabatan')->where('id', $id)->delete();

            DB::commit();
            return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus']);
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(['warning' => 'Data Gagal Di Hapus (' . $e->getMessage() . ')']);
        }
    }
}
