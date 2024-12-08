<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\DetailInspection;
use App\Models\Inspection;
use App\Models\Instrument;
use App\Models\InstrumentTitle;
use App\Models\Karyawan;
use App\Models\RangeValue;
use App\Models\UnitInstrument;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InspectionController extends Controller
{
    //
    public function index(Request $req)
    {
        $query = Inspection::with('departemen')->orderBy('created_at', 'desc');

        if ($req->input('cari_tgl')) {
            $range = explode(',', $req->input('cari_tgl'));
            $query->whereBetween('tgl_pemeriksaan', $range);
        }
        if ($req->input('cari_user')) {
            $query->where('user_id', $req->input('cari_user'));
        }
        if ($req->input('cari_unit')) {
            $query->where('kode_dept', $req->input('cari_unit'));
        }

        // $userId = Auth::id();
        $userId = Auth::guard('user')->user()->id;
        $today = Carbon::today()->toDateString();

        $pemeriksaan = Inspection::where('user_id', $userId)
            ->whereDate('tgl_pemeriksaan', $today)
            ->first();

        $data = $query->paginate(10);
        // dd($data);
        $data_user = User::all();
        $departemen = Departemen::all();
        foreach ($departemen as $d) {
            $data_unit[$d->kode_dept] = $d->nama_dept;
        }

        $kCabang = DB::table('cabang')->orderBy('kode_cabang')->get();
        foreach ($kCabang as $k) {
            $data_cabang[$k->kode_cabang] = $k->nama_cabang;
        }
        $month = $req->get('month', Carbon::now()->month);
        $year = $req->get('year', Carbon::now()->year);
        $viewType = $req->get('view', 'monthly'); // 'monthly' or 'weekly'

        $date = Carbon::create($year, $month, 1);

        if ($viewType === 'weekly') {
            $startOfWeek = $date->startOfWeek();
            $endOfWeek = $date->endOfWeek();
            $pemeriksaans = Inspection::whereBetween('tgl_pemeriksaan', [$startOfWeek, $endOfWeek])
                ->get()
                ->groupBy('user_id');
            $daysInRange = $endOfWeek->diffInDays($startOfWeek) + 1;
        } else {
            $pemeriksaans = Inspection::whereMonth('tgl_pemeriksaan', $month)
                ->whereYear('tgl_pemeriksaan', $year)
                ->get()
                ->groupBy('user_id');
            $daysInRange = 31;
        }

        $users = User::whereIn('id', $pemeriksaans->keys())->get()->keyBy('id');

        return view('inspection.jadwal.index', compact('data', 'data_user', 'data_unit', 'pemeriksaan', 'pemeriksaans', 'daysInRange', 'month', 'year', 'viewType', 'date', 'users', 'data_cabang'));
    }

    public function store(request $req)
    {
        $req->validate([
            'pemeriksa' => 'required',
            'unit' => 'required',
            'lokasi' => 'required',
            'tgl_pemeriksaan' => 'required|date',
        ]);

        $user_id = $req->pemeriksa;
        $unit = $req->unit;
        $lokasi = $req->lokasi;
        $tgl_pemeriksaan = $req->tgl_pemeriksaan;

        try {
            DB::beginTransaction();
            $inspection = Inspection::create([
                'user_id' => $user_id,
                'kode_dept' => $unit,
                'lokasi' => $lokasi,
                'tgl_pemeriksaan' => $tgl_pemeriksaan
            ]);
            DB::commit();
            return redirect()->route('inspection.jadwal.index')->with('success', 'Pemeriksaan Berhasil Ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->back()->with('warning', 'Pemeriksaan Gagal Ditambahkan');
        }
    }

    public function edit($id)
    {
        $query = Inspection::find($id);
        $data_user = User::all();
        $departemen = Departemen::all();
        foreach ($departemen as $d) {
            $data_unit[$d->kode_dept] = $d->nama_dept;
        }

        $kCabang = DB::table('cabang')->orderBy('kode_cabang')->get();
        foreach ($kCabang as $k) {
            $data_cabang[$k->kode_cabang] = $k->nama_cabang;
        }
        $nama_cabang = DB::table('cabang')->where('kode_cabang', $query->lokasi)->first();

        $data = $query;
        // dd($data);


        return view('inspection.jadwal.edit', compact('data', 'data_user', 'data_unit', 'data_cabang', 'nama_cabang'));
    }

    public function update(Request $req, $id)
    {
        // $req->validate([
        //     'pemeriksa' => 'required',
        //     'unit' => 'required',
        //     'lokasi' => 'required',
        //     'tgl_pemeriksaan' => 'required|date',
        // ]);  
        // dd($req->all());

        $user_id = Inspection::where('id', $id)->first()->user_id;
        $unit = $req->unit;
        $lokasi = $req->lokasi;
        $tgl_pemeriksaan = $req->tgl_pemeriksaan;

        try {
            DB::beginTransaction();
            $inspection = Inspection::find($id);
            $inspection->update([
                'user_id' => $user_id,
                'kode_dept' => $unit,
                'lokasi' => $lokasi,
                'tgl_pemeriksaan' => $tgl_pemeriksaan
            ]);
            DB::commit();
            return redirect()->route('inspection.jadwal.index')->with('success', 'Pemeriksaan Berhasil Diubah');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('warning', 'Pemeriksaan Gagal Diubah');
        }
    }

    public function delete($id)
    {
        // $delete = DB::table('inspection')->where('id', $id)->delete();
        // if ($delete) {
        //     return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        // } else {
        //     return Redirect::back()->with(['warning' => 'Data Gagal Dihapus']);
        // }
        Inspection::where('id', $id)->delete();
        return redirect()->back()->with(['success' => 'Data Berhasil Dihapus']);
    }

    public function mulai($id)
    {

        $query = Inspection::find($id);
        $karyawans = Karyawan::all();
        $data = $query;
        $id_unit = $data->kode_dept;

        $pertanyaanUmum = Instrument::where('tipe', 'umum')->get();
        $semuaInstrumen = collect();
        // $pertanyaanKhusus = UnitInstrument::where('kode_dept', $id_unit)->get();
        $pertanyaanKhusus = UnitInstrument::where('kode_dept', $id_unit)->get();
        foreach ($pertanyaanKhusus as $item) {
            $instrumen = Instrument::where('id', $item->instrument_id)
                ->where('tipe', 'khusus')
                ->get(); // Mengakses setiap instrument_id
            $semuaInstrumen = $semuaInstrumen->merge($instrumen);
        }
        $semuaPertanyaan = $pertanyaanUmum->merge($semuaInstrumen);
        $semuaPertanyaan = $semuaPertanyaan->groupBy('title.title');
        $ranges = RangeValue::all();

        // dd($instrumen);

        // $data_detail = DetailInspection::where('id_pemeriksaan', $id)->where('indikator', 'BAIK')->pluck('id_instrumen')->toArray();

        // return view('inspection.jadwal.mulai', compact('data', 'data_instrumen', 'data_detail', 'semuaPertanyaan'));
        return view('inspection.jadwal.mulai', compact('data', 'semuaPertanyaan', 'ranges', 'karyawans'));
    }

    public function storeInspection(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'nik' => 'required|exists:karyawan,nik',
            'details.*.id_instrumen' => 'required|exists:instruments,id',
            'details.*.jawaban' => 'required|string',
            'details.*.foto' => 'nullable|image|max:2048',
        ]);

        $id = $request->id;
        $pemeriksa = $request->id_pemeriksa;
        // $pemeriksa2 = Auth::guard('user')->user()->id;
        // dd($pemeriksa1 . " -------- ". $pemeriksa2);

        // $lokasi = DB::table('cabang')->where('kode_cabang', $request->lokasi)->first()->nama_cabang;



        $inspection = Inspection::where('id', $id)->first();
        // Simpan data pemeriksaan utama
        // $inspection = Inspection::create([
        // $inspection = where('id', $request->nik)->update([
        //     'nik' => $request->nik,
        //     'user_id' => $pemeriksa,
        //     'kode_dept' => Karyawan::where('nik', $request->nik)->first()->kode_dept,
        //     // 'lokasi' => $lokasi,
        //     'lokasi' => $request->lokasi,
        //     'tgl_pemeriksaan' => now(),
        //     'status' => 'SELESAI',
        // ]);
        if ($inspection) {
            $inspection->update([
                'nik' => $request->nik,
                'user_id' => $pemeriksa,
                'kode_dept' => Karyawan::where('nik', $request->nik)->first()->kode_dept,
                'lokasi' => $request->lokasi,
                'tgl_pemeriksaan' => now(),
                'status' => 'SELESAI',
            ]);
        } else {
            // Opsional: Tangani jika data tidak ditemukan
            return redirect()->route('inspection.jadwal.index')->with('warning', 'Data Tidak di Temukan');
        }

        // Simpan detail pemeriksaan
        foreach ($request->details as $detail) {
            $fotoPath = null;
            if (isset($detail['foto'])) {
                $fotoPath = $detail['foto']->store('pemeriksaan_fotos', 'public');
            }

            DetailInspection::create([
                'id_pemeriksaan' => $inspection->id,
                'id_instrumen' => $detail['id_instrumen'],
                'indikator' => Instrument::find($detail['id_instrumen'])->deskripsi,
                'jawaban' => $detail['jawaban'],
                'keterangan' => $detail['keterangan'],
                'foto' => $fotoPath,
            ]);
        }

        return redirect()->route('inspection.jadwal.index')->with('success', 'Pemeriksaan berhasil disimpan');
    }

    public function detailInspection($id)
    {
        $data = Inspection::find($id);
        $dataDetail = DB::table('detail_inspections as di')
            ->join('instruments as i', 'di.id_instrumen', '=', 'i.id')
            ->join('instrument_titles as it', 'i.instrument_title_id', '=', 'it.id')
            ->where('di.id_pemeriksaan', $id)
            ->select('di.*', 'it.title as instrument_title')
            ->get();

        $groupedDetails = $dataDetail->groupBy('instrument_title');
        return view('inspection.jadwal.detail', compact('data', 'groupedDetails'));
    }
}
