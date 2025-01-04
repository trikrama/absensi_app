<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Inspection;
use App\Models\Instrument;
use App\Models\InstrumentTitle;
use App\Models\Jabatan;
use App\Models\UnitInstrument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstrumentController extends Controller
{
    //
    public function index(Request $req){
        $jabatan = Jabatan::all();
        // $instrumentTitles = InstrumentTitle::all();
        $instrumentTitles = InstrumentTitle::where('type', 'khusus')->get();
        $departements = Departemen::all();
        $pertanyaanUmum = Instrument::where('tipe', 'umum')->get();

        // Ambil pertanyaan khusus, termasuk relasi unit
        $pertanyaanKhusus = UnitInstrument::with('instrument')
            ->whereHas('instrument', function ($query) {
                $query->where('tipe', 'khusus');
            })
            ->get()
            ->groupBy('jabatan');  // Grup berdasarkan unit

        
        $pertanyaanUmum = $pertanyaanUmum->groupBy(function ($item) {
            return $item->title->title;
        });
        // dd($pertanyaanKhusus);
        $kCabang = DB::table('cabang')->get();
        return view('inspection.instrument.index', [
            'pertanyaanUmum' => $pertanyaanUmum,
            'pertanyaanKhusus' => $pertanyaanKhusus,
            'instrumentTitles' => $instrumentTitles,
            'jabatans' => $jabatan,
            'departements' => $departements,
            'kCabang' => $kCabang
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try{
            // $request->validate([
            //     'title' => 'required',
            //     'deskripsi' => 'required',
            // ]);

            $instrument = new Instrument();
            $instrument->instrument_title_id = $request->title;
            $instrument->deskripsi = $request->deskripsi;
            $instrument->tipe = $request->tipe;
            $instrument->save();

            if ($request->tipe === 'khusus' && $request->jabatan) {
                $unitInstrument = new UnitInstrument();
                // $unitInstrument->kode_dept = $request->kode_dept;
                $unitInstrument->id_jabatan = $request->jabatan;
                $unitInstrument->instrument_id = $instrument->id;
                $unitInstrument->save();
            }

            return redirect()->back()->with('success', 'Instrumen berhasil ditambahkan');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', 'Instrumen gagal ditambahkan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $jabatan = Jabatan::all();
        $instrument = Instrument::findOrFail($id); // Ambil data instrumen berdasarkan ID
        $instrumentTitles = InstrumentTitle::all(); // Semua title
        $departements = Departemen::all(); // Semua departemen

        return view('inspection.instrument.edit', [
            'instrument' => $instrument,
            'instrumentTitles' => $instrumentTitles,
            'departements' => $departements,
            'jabatans' => $jabatan
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            // 'title' => 'required',
            'deskripsi' => 'required',
        ]);

        $instrument = Instrument::findOrFail($id); // Ambil data instrumen berdasarkan ID
        // $instrument->instrument_title_id = $request->title;
        $instrument->deskripsi = $request->deskripsi;
        $instrument->tipe = $request->tipe;
        $instrument->save();

        // if ($request->tipe === 'khusus') {
        //     // Update atau buat UnitInstrument jika tipe adalah 'khusus'
        //     UnitInstrument::updateOrCreate(
        //         ['instrument_id' => $instrument->id],
        //         // ['kode_dept' => $request->kode_dept]
        //         ['id_jabatan' => $request->jabatan]
        //     );
        // } else {
        //     // Hapus UnitInstrument jika tipe diubah menjadi 'umum'
        //     UnitInstrument::where('instrument_id', $instrument->id)->delete();
        // }
        return redirect()->route('instrument.index')->with('success', 'Instrumen berhasil diperbarui');
    }

    public function destroyUmum($id)
    {
        $instrument = Instrument::findOrFail($id);
    
        $instrument->delete();

        return redirect()->back()->with('success', 'Instrumen berhasil dihapus');
    }
    public function destroyKhusus($id)
    {
        $unitInstrument = UnitInstrument::where('id', $id)->get();
        Instrument::where("id", $unitInstrument->first()->instrument_id)->delete();
    
        return redirect()->back()->with('success', 'Instrumen berhasil dihapus');
    }
}

