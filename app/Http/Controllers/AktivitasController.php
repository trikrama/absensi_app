<?php

namespace App\Http\Controllers;

use App\Models\Aktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AktivitasController extends Controller
{
    //
    public function create(Request $request)
    {
        // Mendapatkan semua aktivitas untuk bulan ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $aktivitas = Aktivitas::whereMonth('tanggal_aktivitas', $currentMonth)
            ->whereYear('tanggal_aktivitas', $currentYear)
            ->get();

        // Jika ada filter tanggal
        if ($request->has('from_date') && $request->has('to_date')) {
            $fromDate = Carbon::parse($request->from_date);
            $toDate = Carbon::parse($request->to_date);

            // Mendapatkan aktivitas dalam rentang tanggal yang difilter
            $aktivitas = Aktivitas::whereBetween('tanggal_aktivitas', [$fromDate, $toDate])->get();
        }
        return view('aktivitas.create', compact('aktivitas'));
    }

    public function store(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'tanggal_aktivitas' => 'required|date',
                'waktu_aktivitas' => 'required',
                'deskripsi' => 'required|string|max:255',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

             // Mengonversi waktu ke format 24 jam
            $waktu_aktivitas = Carbon::createFromFormat('h:i A', $request->waktu_aktivitas)->format('H:i');
            // Simpan data aktivitas
            $aktivitas = new Aktivitas();
            $aktivitas->nik = Auth::id();
            $aktivitas->tanggal_aktivitas = $request->tanggal_aktivitas;
            $aktivitas->waktu_aktivitas = $waktu_aktivitas;
            $aktivitas->deskripsi = $request->deskripsi;

            // Proses upload foto jika ada
            if ($request->hasFile('foto')) {
                $foto_aktivitas = $request->file('foto');
                $folderPath = "public/uploads/aktivitas/";
                $fotoName = $foto_aktivitas->getClientOriginalName();
                $foto_aktivitas->storeAs($folderPath, $fotoName);
                $aktivitas->foto = $fotoName; // Simpan nama foto di database
            } else {
                $aktivitas->foto = null; // Jika tidak ada foto, set null
            }

            // Simpan aktivitas ke database
            $aktivitas->save();

            return redirect()->route('aktivitas.create')->with('success', 'Aktivitas berhasil dicatat.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            // Menangkap kesalahan dan mengembalikan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $aktivitas = Aktivitas::findOrFail($id);
        return view('aktivitas.edit', compact('aktivitas'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        try {
            // Validasi input
            $request->validate([
                'tanggal_aktivitas' => 'required|date',
                'waktu_aktivitas' => 'required|string',
                'deskripsi' => 'required|string|max:255',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $aktivitas = Aktivitas::findOrFail($id);
            $aktivitas->tanggal_aktivitas = $request->tanggal_aktivitas;
            // $aktivitas->waktu_aktivitas = Carbon::createFromFormat('H:i', $request->waktu_aktivitas)->format('H:i');
            // $aktivitas->waktu_aktivitas = Carbon::createFromFormat('H:i', trim($request->waktu_aktivitas));
            $aktivitas->waktu_aktivitas = Carbon::createFromFormat('H:i:s', trim($request->waktu_aktivitas))->format('H:i');
            $aktivitas->deskripsi = $request->deskripsi;

            // Proses upload foto jika ada
            if ($request->hasFile('foto')) {
                $foto_aktivitas = $request->file('foto');
                $folderPath = "public/uploads/aktivitas/";
                $foto_aktivitas->storeAs($folderPath, $foto_aktivitas->getClientOriginalName());
                $aktivitas->foto = $foto_aktivitas->getClientOriginalName();
            }

            $aktivitas->save();

            return redirect()->route('aktivitas.create')->with('success', 'Aktivitas berhasil diperbarui.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // public function index()
    // {
    //     $aktivitas = Aktivitas::where('nik', Auth::id())->get();
    //     return view('aktivitas.index', compact('aktivitas'));
    // }
}
