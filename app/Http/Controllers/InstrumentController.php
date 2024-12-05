<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Inspection;
use App\Models\Instrument;
use App\Models\InstrumentTitle;
use App\Models\UnitInstrument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstrumentController extends Controller
{
    //
    public function index(Request $req){
        $instrumentTitles = InstrumentTitle::all();
        $departements = Departemen::all();
        $pertanyaanUmum = Instrument::where('tipe', 'umum')->get();

        // Ambil pertanyaan khusus, termasuk relasi unit
        $pertanyaanKhusus = UnitInstrument::with('instrument')
            ->whereHas('instrument', function ($query) {
                $query->where('tipe', 'khusus');
            })
            ->get()
            ->groupBy('kode_dept');  // Grup berdasarkan unit

        
        $pertanyaanUmum = $pertanyaanUmum->groupBy(function ($item) {
            return $item->title->title;
        });
        $kCabang = DB::table('cabang')->get();
        return view('inspection.instrument.index', [
            'pertanyaanUmum' => $pertanyaanUmum,
            'pertanyaanKhusus' => $pertanyaanKhusus,
            'instrumentTitles' => $instrumentTitles,
            'departements' => $departements,
            'kCabang' => $kCabang
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'deskripsi' => 'required',
        ]);

        $instrument = new Instrument();
        $instrument->instrument_title_id = $request->title;
        $instrument->deskripsi = $request->deskripsi;
        $instrument->tipe = $request->tipe;
        $instrument->save();

        if ($request->tipe === 'khusus' && $request->kode_dept) {
            $unitInstrument = new UnitInstrument();
            $unitInstrument->kode_dept = $request->kode_dept;
            $unitInstrument->instrument_id = $instrument->id;
            $unitInstrument->save();
        }

        return redirect()->back()->with('success', 'Instrumen berhasil ditambahkan');
    }

    public function edit($id)
    {
        $instrument = Instrument::findOrFail($id); // Ambil data instrumen berdasarkan ID
        $instrumentTitles = InstrumentTitle::all(); // Semua title
        $departements = Departemen::all(); // Semua departemen

        return view('inspection.instrument.edit', [
            'instrument' => $instrument,
            'instrumentTitles' => $instrumentTitles,
            'departements' => $departements
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'deskripsi' => 'required',
        ]);

        $instrument = Instrument::findOrFail($id); // Ambil data instrumen berdasarkan ID
        $instrument->instrument_title_id = $request->title;
        $instrument->deskripsi = $request->deskripsi;
        $instrument->tipe = $request->tipe;
        $instrument->save();

        if ($request->tipe === 'khusus') {
            // Update atau buat UnitInstrument jika tipe adalah 'khusus'
            UnitInstrument::updateOrCreate(
                ['instrument_id' => $instrument->id],
                ['kode_dept' => $request->kode_dept]
            );
        } else {
            // Hapus UnitInstrument jika tipe diubah menjadi 'umum'
            UnitInstrument::where('instrument_id', $instrument->id)->delete();
        }

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

