<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Tugas;
use App\Models\TugasDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TugasController extends Controller
{
    public function index()
    {
        $query = Tugas::query();
        $query->orderBy('tugas_id', 'desc');
        $tugas = $query->paginate(10);
        return view('tugas.index', compact('tugas'));
    }

    public function create()
    {
        return view('tugas.create');
    }

    public function store(Request $request)
    {
        $deadlineReq = $request->deadline;
        $deadlineSplit = explode(' ', $deadlineReq);
        try {
            // Menggunakan Eloquent untuk insert data
            Tugas::create([
                'tugas_id' => $request->tugas_id,
                'judul_tugas' => $request->judul_tugas,
                'deskripsi_tugas' => $request->deskripsi_tugas,
                'lampiran_tugas' => $request->lampiran,
                'status' => "belum",
                'deadline' => $deadlineSplit[0],
            ]);

            return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
        } catch (\Exception $e) {
            // Menangani error
            return Redirect::back()->with(['warning' => $e->getMessage()]);
        }
    }

    public function edit(Request $request)
    {
        $tugas_id = $request->tugas_id;
        $tugas = Tugas::where('tugas_id', $tugas_id)->first();
        return view('tugas.edit', compact('tugas'));
    }

    public function update(Request $request, $tugas_id)
    {
        $deadlineReq = $request->deadline;
        $deadlineSplit = explode(' ', $deadlineReq);
        try {
            // Mencari model berdasarkan kode_libur dan memperbarui data
            $tugas = Tugas::where('tugas_id', $tugas_id)->first();

            if ($tugas) {
                $tugas->tugas_id = $request->tugas_id;
                $tugas->judul_tugas = $request->judul_tugas;
                $tugas->deskripsi_tugas = $request->deskripsi_tugas;
                // Cek apakah lampiran diinput
                if ($request->hasFile('lampiran')) {
                    // Simpan lampiran baru
                    $tugas->lampiran_tugas = $request->file('lampiran')->store('lampiran'); // Atur folder penyimpanan sesuai kebutuhan
                }
                $tugas->deadline = $deadlineSplit[0];
                $tugas->save(); // Simpan perubahan
            }

            return Redirect::back()->with(['success' => 'Data Berhasil Diupdate']);
        } catch (\Exception $e) {
            //dd($e);
            return Redirect::back()->with(['warning' => 'Data Gagal Diupdate']);
        }
    }

    public function delete($tugas_id)
    {
        try {
            $tugas = Tugas::where('tugas_id', $tugas_id)->delete();
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => $e->getMessage()]);
        }
    }

    public function settugaskaryawan($tugas_id)
    {
        $tugas = Tugas::where('tugas_id', $tugas_id)->first();
        
        return view('tugas.setTugasKaryawan', compact('tugas'));
    }
    
    public function setlisttugaskaryawan($tugas_id)
    {
        // dd($tugas_id);
        return view('tugas.setListTugasKaryawan', compact('tugas_id'));
    }
    
    public function getsetlisttugaskaryawan($tugas_id)
    {
        $tugas = Tugas::where('tugas_id', $tugas_id)->first();
    
        $karyawan = Karyawan::select('karyawan.*')
            ->leftJoin('detail_tugas', function ($join) use ($tugas_id) {
                $join->on('karyawan.nik', '=', 'detail_tugas.nik')
                     ->where('detail_tugas.tugas_id', $tugas_id);
            })
            ->orderBy('nama_lengkap')
            ->get();

        // dd($karyawan);
    
        return view('tugas.getSetListTugasKaryawan', compact('karyawan', 'tugas_id', 'tugas'));
    }
    
    public function storetugaskaryawan(Request $request)
    {
        try {
            $cek = TugasDetail::where('tugas_id', $request->tugas_id)
                ->where('nik', $request->nik)
                ->count();
    
            if ($cek > 0) {
                return 1; // Data sudah ada
            }
    
            TugasDetail::create([
                'tugas_id' => $request->tugas_id,
                'nik' => $request->nik,
            ]);
    
            return 0; // Berhasil disimpan
        } catch (\Exception $e) {
            return $e->getMessage(); // Menangani kesalahan
        }
    }
    
    public function removetugaskaryawan(Request $request)
    {
        try {
            TugasDetail::where('tugas_id', $request->tugas_id)
                ->where('nik', $request->nik)
                ->delete();
            
            return 0; // Berhasil dihapus
        } catch (\Exception $e) {
            return $e->getMessage(); // Menangani kesalahan
        }
    }

    public function gettugaskaryawan($tugas_id)
    {
        $tugasKaryawan = TugasDetail::with('karyawan')
            ->where('tugas_id', $tugas_id)
            ->get();
        return view('tugas.getTugasKaryawan', compact('tugasKaryawan', 'tugas_id'));
    }
}
