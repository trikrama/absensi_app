<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Departemen;
use App\Models\DetailInspection;
use App\Models\Inspection;
use App\Models\InspectionAnswer;
use App\Models\Instrument;
use App\Models\InstrumentTitle;
use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\RangeValue;
use App\Models\UnitInstrument;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class InspectionController extends Controller
{
    //
    public function index(Request $req)
    {
        // $query = Inspection::with('departemen')->orderBy('created_at', 'desc');
        $query = Inspection::with('user') // Pastikan relasi dengan user sudah ada
            ->withCount(['inspectionAnswers as jml_personel' => function ($query) {
                $query->whereDate('created_at', Carbon::today());
            }])
            ->orderBy('created_at', 'desc');

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

        $jmlPersonel = Inspection::withCount(['inspectionAnswers as jml_personel' => function ($query) {
            $query->whereDate('created_at', Carbon::today());
        }])->get();


        $users = User::whereIn('id', $pemeriksaans->keys())->get()->keyBy('id');

        return view('inspection.jadwal.index', compact('data', 'data_user', 'data_unit', 'pemeriksaan', 'pemeriksaans', 'daysInRange', 'month', 'year', 'viewType', 'date', 'users', 'data_cabang', 'jmlPersonel'));
    }

    public function create()
    {
        $user_id = Auth::guard('user')->user()->id;
        $koordinator = User::where('id', $user_id)->first();
        return view('inspection.jadwal.create', compact('koordinator'));
    }

    // dd($req->all());
    // $req->validate([
    // 'pemeriksa' => 'required',
    // 'unit' => 'required',
    //     'lokasi' => 'required',
    //     'tgl_pemeriksaan' => 'required|date',
    // ]);

    // $user_id = $req->pemeriksa;
    // $unit = $req->unit;

    // dd($req->all());
    public function store(request $req)
    {
        try {
            $user_id = Auth::guard('user')->user()->id;
            $lokasi = $req->lokasi;
            $tujuan = $req->tujuan_kegiatan;
            $tgl_pemeriksaan = $req->tanggal;
            $waktu_mulai = $req->waktu_mulai;
            $foto_bukti = $req->foto_kunjungan;
            $deskripsi = $req->wysiwyg;


            DB::beginTransaction();
            $inspection = Inspection::create([
                'user_id' => $user_id,
                // 'kode_dept' => $unit,
                'lokasi' => $lokasi,
                'tujuan' => $tujuan,
                'foto_bukti' => $foto_bukti->getClientOriginalName(),
                'tgl_pemeriksaan' => $tgl_pemeriksaan,
                'waktu_mulai' => $waktu_mulai,
                'keterangan' => $deskripsi

            ]);

            if ($req->hasFile('foto_kunjungan')) {
                $foto_bukti = $req->file('foto_kunjungan');
                $folderPath = "public/uploads/inspection/";
                $foto_bukti->storeAs($folderPath, $foto_bukti->getClientOriginalName());
            }
            DB::commit();
            return redirect()->route('inspection.jadwal.index')->with('success', 'Pemeriksaan Berhasil Ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->back()->with('warning', 'Pemeriksaan Gagal Ditambahkan');
        }
    }
    // return redirect()->route('inspection.jadwal.index')->with('success', 'Pemeriksaan Berhasil Ditambahkan');
    // return redirect()->action(
    //     [self::class, 'mulai'], // Nama controller dan metode
    //     ['id' => $inspection->id] // Parameter untuk metode mulai
    // );

    public function edit($id)
    {
        $inspection = Inspection::findOrFail($id); // Ambil data berdasarkan ID
        return view('inspection.jadwal.edit', compact('inspection')); // Tampilkan view edit
    }

    public function update(Request $req, $id)
    {
        try {
            $inspection = Inspection::findOrFail($id); // Temukan data
            $user_id = Auth::guard('user')->user()->id;
            $lokasi = $req->lokasi;
            $tujuan = $req->tujuan_kegiatan;
            $tgl_pemeriksaan = $req->tanggal;
            $waktu_mulai = $req->waktu_mulai;
            $deskripsi = $req->wysiwyg;

            DB::beginTransaction();
            $inspection->update([
                'user_id' => $user_id,
                'lokasi' => $lokasi,
                'tujuan' => $tujuan,
                'tgl_pemeriksaan' => $tgl_pemeriksaan,
                'waktu_mulai' => $waktu_mulai,
                'keterangan' => $deskripsi
            ]);

            if ($req->hasFile('foto_kunjungan')) {
                $foto_bukti = $req->file('foto_kunjungan');
                $folderPath = "public/uploads/inspection/";
                $foto_bukti->storeAs($folderPath, $foto_bukti->getClientOriginalName());
                $inspection->update(['foto_bukti' => $foto_bukti->getClientOriginalName()]);
            }
            DB::commit();

            return redirect()->route('inspection.jadwal.index')->with('success', 'Pemeriksaan Berhasil Diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->back()->with('warning', 'Pemeriksaan Gagal Diupdate');
        }
    }

    public function delete($id)
    {
        try {
            $inspection = Inspection::findOrFail($id);
            $folderPath = "public/uploads/inspection/";

            // Hapus file jika ada
            if ($inspection->foto_bukti && Storage::exists($folderPath . $inspection->foto_bukti)) {
                Storage::delete($folderPath . $inspection->foto_bukti);
            }

            $inspection->delete();
            return redirect()->route('inspection.jadwal.index')->with('success', 'Pemeriksaan Berhasil Dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', 'Pemeriksaan Gagal Dihapus');
        }
    }



    // public function edit($id)
    // {
    //     $query = Inspection::find($id);
    //     $data_user = User::all();
    //     $departemen = Departemen::all();
    //     foreach ($departemen as $d) {
    //         $data_unit[$d->kode_dept] = $d->nama_dept;
    //     }

    //     $kCabang = DB::table('cabang')->orderBy('kode_cabang')->get();
    //     foreach ($kCabang as $k) {
    //         $data_cabang[$k->kode_cabang] = $k->nama_cabang;
    //     }
    //     $nama_cabang = DB::table('cabang')->where('kode_cabang', $query->lokasi)->first();

    //     $data = $query;
    //     // dd($data);


    //     return view('inspection.jadwal.edit', compact('data', 'data_user', 'data_unit', 'data_cabang', 'nama_cabang'));
    // }

    // public function update(Request $req, $id)
    // {
    //     // $req->validate([
    //     //     'pemeriksa' => 'required',
    //     //     'unit' => 'required',
    //     //     'lokasi' => 'required',
    //     //     'tgl_pemeriksaan' => 'required|date',
    //     // ]);  
    //     // dd($req->all());

    //     $user_id = Inspection::where('id', $id)->first()->user_id;
    //     $unit = $req->unit;
    //     $lokasi = $req->lokasi;
    //     $tgl_pemeriksaan = $req->tgl_pemeriksaan;

    //     try {
    //         DB::beginTransaction();
    //         $inspection = Inspection::find($id);
    //         $inspection->update([
    //             'user_id' => $user_id,
    //             'kode_dept' => $unit,
    //             'lokasi' => $lokasi,
    //             'tgl_pemeriksaan' => $tgl_pemeriksaan
    //         ]);
    //         DB::commit();
    //         return redirect()->route('inspection.jadwal.index')->with('success', 'Pemeriksaan Berhasil Diubah');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->back()->with('warning', 'Pemeriksaan Gagal Diubah');
    //     }
    // }

    // public function delete($id)
    // {
    //     // $delete = DB::table('inspection')->where('id', $id)->delete();
    //     // if ($delete) {
    //     //     return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
    //     // } else {
    //     //     return Redirect::back()->with(['warning' => 'Data Gagal Dihapus']);
    //     // }
    //     Inspection::where('id', $id)->delete();
    //     return redirect()->back()->with(['success' => 'Data Berhasil Dihapus']);
    // }

    // public function mulai()
    // {
    //     $departemen = Departemen::all();
    //     foreach ($departemen as $d) {
    //         $data_unit[$d->kode_dept] = $d->nama_dept;
    //     }
    //     $kCabang = DB::table('cabang')->orderBy('kode_cabang')->get();
    //     foreach ($kCabang as $k) {
    //         $data_cabang[$k->kode_cabang] = $k->nama_cabang;
    //     }
    //     $query = Inspection::find($id);
    //     $karyawans = Karyawan::where('kode_dept', $query->kode_dept)->get();
    //     $data = $query;
    //     $id_unit = $data->kode_dept;

    //     $pertanyaanUmum = Instrument::where('tipe', 'umum')->get();
    //     $semuaInstrumen = collect();
    //     // $pertanyaanKhusus = UnitInstrument::where('kode_dept', $id_unit)->get();
    //     $pertanyaanKhusus = UnitInstrument::where('kode_dept', $id_unit)->get();
    //     foreach ($pertanyaanKhusus as $item) {
    //         $instrumen = Instrument::where('id', $item->instrument_id)
    //             ->where('tipe', 'khusus')
    //             ->get(); // Mengakses setiap instrument_id
    //         $semuaInstrumen = $semuaInstrumen->merge($instrumen);
    //     }
    //     $semuaPertanyaan = $pertanyaanUmum->merge($semuaInstrumen);
    //     $semuaPertanyaan = $semuaPertanyaan->groupBy('title.title');
    //     $ranges = RangeValue::all();
    //     return view('inspection.jadwal.mulai', compact('data', 'semuaPertanyaan', 'ranges', 'karyawans', 'data_unit', 'data_cabang'));
    // } iniiii

    public function mulai($id)
    {
        $data_jabatan = Jabatan::pluck('id', 'nama_jabatan'); // Mengambil nama dan kode departemen/unit

        $data = Inspection::find($id);

        // Kirim data ke view
        return view('inspection.jadwal.mulai', compact('data_jabatan', 'data'));
    }
    public function detail_kunjungan($id)
    {
        $data = Inspection::find($id);
        $detail_kunjungan = InspectionAnswer::where('inspection_id', $id)->get();
        return view('inspection.jadwal.detail_kunjungan', compact('data', 'detail_kunjungan'));
    }

    // public function mulai($id)
    // public function mulai(Request $request, $id)
    // {
    //     $departemen = Departemen::all();
    //     foreach ($departemen as $d) {
    //         $data_unit[$d->kode_dept] = $d->nama_dept;
    //     }
    //     $kCabang = DB::table('cabang')->orderBy('kode_cabang')->get();
    //     foreach ($kCabang as $k) {
    //         $data_cabang[$k->kode_cabang] = $k->nama_cabang;
    //     }
    //     $query = Inspection::find($id);
    //     $karyawans = Karyawan::where('kode_dept', $query->kode_dept)->get();
    //     $data = $query;
    //     $id_unit = $data->kode_dept;

    //     $pertanyaanUmum = Instrument::where('tipe', 'umum')->get();
    //     $semuaInstrumen = collect();
    //     // $pertanyaanKhusus = UnitInstrument::where('kode_dept', $id_unit)->get();
    //     $pertanyaanKhusus = UnitInstrument::where('kode_dept', $id_unit)->get();
    //     foreach ($pertanyaanKhusus as $item) {
    //         $instrumen = Instrument::where('id', $item->instrument_id)
    //             ->where('tipe', 'khusus')
    //             ->get(); // Mengakses setiap instrument_id
    //         $semuaInstrumen = $semuaInstrumen->merge($instrumen);
    //     }
    //     $semuaPertanyaan = $pertanyaanUmum->merge($semuaInstrumen);
    //     $semuaPertanyaan = $semuaPertanyaan->groupBy('title.title');
    //     $ranges = RangeValue::all();
    //     return view('inspection.jadwal.mulai', compact('data', 'semuaPertanyaan', 'ranges', 'karyawans', 'data_unit', 'data_cabang'));
    // }

    // public function mulai(Request $request)
    // {
    //     $departemen = Departemen::all();
    //     foreach ($departemen as $d) {
    //         $data_unit[$d->kode_dept] = $d->nama_dept;
    //     }
    //     $kCabang = DB::table('cabang')->orderBy('kode_cabang')->get();
    //     foreach ($kCabang as $k) {
    //         $data_cabang[$k->kode_cabang] = $k->nama_cabang;
    //     }
    //     // $query = Inspection::find($id);
    //     // $data = $query;
    //     // $id_unit = $data->kode_dept;
    //     $id_unit = 'SKM';

    //     $karyawans = Karyawan::where('kode_dept', $id_unit)->get(); // Data awal berdasarkan kode_dept

    //     $pertanyaanUmum = Instrument::where('tipe', 'umum')->get();
    //     $semuaInstrumen = collect();
    //     $pertanyaanKhusus = UnitInstrument::where('kode_dept', $id_unit)->get();
    //     foreach ($pertanyaanKhusus as $item) {
    //         $instrumen = Instrument::where('id', $item->instrument_id)
    //             ->where('tipe', 'khusus')
    //             ->get(); // Mengakses setiap instrument_id
    //         $semuaInstrumen = $semuaInstrumen->merge($instrumen);
    //     }
    //     $semuaPertanyaan = $pertanyaanUmum->merge($semuaInstrumen);
    //     $semuaPertanyaan = $semuaPertanyaan->groupBy('title.title');
    //     $ranges = RangeValue::all();

    //     // Return dengan data default
    //     return view('inspection.jadwal.mulai', compact(
    //         // 'data',
    //         'semuaPertanyaan',
    //         'ranges',
    //         // 'karyawans',
    //         'data_unit',
    //         'data_cabang'
    //     ));
    // }

    public function getKaryawanByDept(Request $request)
    {
        $kode_dept = $request->kode_dept;

        $jabatan = Jabatan::where('id', $kode_dept)->first();
        // Ambil karyawan berdasarkan kode_dept
        $karyawans = Karyawan::where('jabatan', $jabatan->nama_jabatan)->get();

        return response()->json($karyawans);
    }

    public function getInstrumentsByDept(Request $request)
    {
        $id_unit = $request->input('kode_dept');

        // Validasi kode_dept
        $departemen = Jabatan::where('id', $id_unit)->first();
        if (!$departemen) {
            return response()->json(['error' => 'ID Jabatan tidak valid.'], 400);
        }
        // $departemen = Departemen::where('kode_dept', $id_unit)->first();
        // if (!$departemen) {
        //     return response()->json(['error' => 'Kode departemen tidak valid.'], 400);
        // }

        // Ambil data instrumen
        $pertanyaanUmum = Instrument::where('tipe', 'umum')->get();
        $semuaInstrumen = collect();

        $pertanyaanKhusus = UnitInstrument::where('id_jabatan', $id_unit)->get();
        foreach ($pertanyaanKhusus as $item) {
            $instrumen = Instrument::where('id', $item->instrument_id)
                ->where('tipe', 'khusus')
                ->get();
            $semuaInstrumen = $semuaInstrumen->merge($instrumen);
        }

        $semuaPertanyaan = $pertanyaanUmum->merge($semuaInstrumen);
        $semuaPertanyaan = $semuaPertanyaan->groupBy('title.title');

        return response()->json($semuaPertanyaan);
    }

    public function getPertanyaan(Request $request)
    {
        $kodeDept = $request->kode_dept;
        $pertanyaanUmum = Instrument::where('tipe', 'umum')->get();
        $pertanyaanKhusus = UnitInstrument::where('kode_dept', $kodeDept)->get();

        $semuaInstrumen = collect();
        foreach ($pertanyaanKhusus as $item) {
            $instrumen = Instrument::where('id', $item->instrument_id)
                ->where('tipe', 'khusus')
                ->get();
            $semuaInstrumen = $semuaInstrumen->merge($instrumen);
        }

        $semuaPertanyaan = $pertanyaanUmum->merge($semuaInstrumen);
        $semuaPertanyaan = $semuaPertanyaan->groupBy('title');

        return view('inspection.partials.pertanyaan', compact('semuaPertanyaan'))->render();
    }



    public function storeInspection(Request $request)
    {
        //     $req->validate([
        //         // 'pemeriksa' => 'required',
        //         'unit' => 'required',
        //         'lokasi' => 'required',
        //         'tgl_pemeriksaan' => 'required|date',
        //     ]);

        //     // $user_id = $req->pemeriksa;
        //     $user_id = Auth::guard('user')->user()->id;
        //     $unit = $req->unit;
        //     $lokasi = $req->lokasi;
        //     $tgl_pemeriksaan = $req->tgl_pemeriksaan;

        //     try {
        //         DB::beginTransaction();
        //         $inspection = Inspection::create([
        //             'user_id' => $user_id,
        //             'kode_dept' => $unit,
        //             'lokasi' => $lokasi,
        //             'tgl_pemeriksaan' => $tgl_pemeriksaan
        //         ]);
        //         DB::commit();
        //         // return redirect()->route('inspection.jadwal.index')->with('success', 'Pemeriksaan Berhasil Ditambahkan');
        //         return redirect()->action(
        //             [self::class, 'mulai'], // Nama controller dan metode
        //             ['id' => $inspection->id] // Parameter untuk metode mulai
        //         );
        //     } catch (\Exception $e) {
        //         DB::rollBack();
        //         dd($e->getMessage());
        //         return redirect()->back()->with('warning', 'Pemeriksaan Gagal Ditambahkan');
        //     }

        // dd($request->all());
        // $request->validate([
        //     'pemeriksa' => 'required',
        //     'unit' => 'required',
        //     'lokasi' => 'required',
        //     'tgl_pemeriksaan' => 'required|date',
        //     'nik' => 'required|exists:karyawan,nik',
        //     'details.*.id_instrumen' => 'required|exists:instruments,id',
        //     'details.*.jawaban' => 'required|string',
        //     'details.*.foto' => 'nullable|image|max:2048',
        // ]);

        // $pemeriksa = Auth::guard('user')->user()->id;
        // $id = $request->id;

        // $status = $request->has('submit') ? 'SELESAI' : 'BELUM'; // Status berdasarkan tombol
        // // $pemeriksa = $request->id_pemeriksa;
        // $unit = $request->unit;
        // $lokasi = $request->lokasi;
        // $tgl_pemeriksaan = $request->tgl_pemeriksaan;

        // try {
        //     DB::beginTransaction();
        //     $inspection = Inspection::create([
        //         'user_id' => $pemeriksa,
        //         'kode_dept' => $unit,
        //         'lokasi' => $lokasi,
        //         'tgl_pemeriksaan' => $tgl_pemeriksaan,
        //         'status' => 'SELESAI',
        //     ]);
        //     DB::commit();
        //     // return redirect()->route('inspection.jadwal.index')->with('success', 'Pemeriksaan Berhasil Ditambahkan');
        //     return redirect()->action(
        //         [self::class, 'mulai'], // Nama controller dan metode
        //         ['id' => $inspection->id] // Parameter untuk metode mulai
        //     );
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     dd($e->getMessage());
        //     return redirect()->back()->with('warning', 'Pemeriksaan Gagal Ditambahkan');
        // }



        // $inspection = Inspection::where('id', $id)->first();
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
        // if ($inspection) {
        //     $inspection->update([
        //         'nik' => $request->nik,
        //         'user_id' => $pemeriksa,
        //         'kode_dept' => Karyawan::where('nik', $request->nik)->first()->kode_dept,
        //         'lokasi' => $request->lokasi,
        //         'tgl_pemeriksaan' => now(),
        //         'status' => 'SELESAI',
        //     ]);
        // } else {
        //     // Opsional: Tangani jika data tidak ditemukan
        //     return redirect()->route('inspection.jadwal.index')->with('warning', 'Data Tidak di Temukan');
        // }

        // Simpan detail pemeriksaan
        // foreach ($request->details as $detail) {
        //     $fotoPath = null;
        //     if (isset($detail['foto'])) {
        //         $fotoPath = $detail['foto']->store('pemeriksaan_fotos', 'public');
        //     }

        //     DetailInspection::create([
        //         'id_pemeriksaan' => $inspection->id,
        //         'id_instrumen' => $detail['id_instrumen'],
        //         'indikator' => Instrument::find($detail['id_instrumen'])->deskripsi,
        //         'jawaban' => $detail['jawaban'],
        //         'keterangan' => isset($detail['keterangan']) ? $detail['keterangan'] : '',
        //         'foto' => $fotoPath,
        //     ]);
        // }

        // return redirect()->route('inspection.jadwal.index')->with('success', 'Pemeriksaan berhasil disimpan');
        // dd($request->all());
        // 'details.*.id_instrumen' => [
        //     'required',
        //     'exists:instruments,id',
        //     Rule::unique('detail_inspections', 'id_instrumen')
        //         ->where('id_pemeriksaan', $request->id),
        // ],
        // 'pemeriksa' => 'required',
        // 'unit' => 'required',
        // 'lokasi' => 'required',
        // 'tgl_pemeriksaan' => 'required|date',
        //     $request->validate([
        //     'nik' => 'required|exists:karyawan,nik',
        //     'details.*.id_instrumen' => 'required|exists:instruments,id',
        //     'details.*.jawaban' => 'required|string',
        //     'details.*.foto' => 'nullable|image|max:2048',
        // ]);

        try {
            $pemeriksa = Auth::guard('user')->user()->id;
            $karyawan = Karyawan::where('nik', $request->nama_karyawan)->first();
            $cabang = DB::table('cabang')->where('kode_cabang', $karyawan->kode_cabang)->first();
            $status = $request->has('submit') ? 'SELESAI' : 'BELUM'; // Status berdasarkan tombol
            $inspection = null;
            DB::beginTransaction();

            // Buat atau perbarui data inspection
            $inspection = InspectionAnswer::updateOrCreate(
                ['id' => $request->id_inspection], // Jika ID ada, update data
                [
                    'inspection_id' => $request->id_inspection,
                    'nik' => $karyawan->nik,
                    'user_id' => $pemeriksa,
                    'cabang' => $cabang->nama_cabang,
                    'jabatan' => $karyawan->jabatan,
                ]
            );

            $totalNilai = 0;

            // Simpan detail pemeriksaan
            foreach ($request->details as $detail) {
                $fotoPath = null;
                if (isset($detail['foto'])) {
                    $fotoPath = $detail['foto']->store('pemeriksaan_fotos', 'public');
                }

                $jawaban = $detail['jawaban'];
                $totalNilai += $jawaban; // Tambahkan jawaban ke total nilai

                DetailInspection::updateOrCreate(
                    [
                        'id_pemeriksaan_perorang' => $karyawan->nik,
                        'id_pemeriksaan' => $inspection->id,
                        'id_instrumen' => $detail['id_instrumen'],
                    ],
                    [
                        'indikator' => Instrument::find($detail['id_instrumen'])->deskripsi,
                        'jawaban' => $jawaban,
                        'keterangan' => $detail['keterangan'] ?? '',
                        'foto' => $fotoPath,
                    ]
                );
            }

            // Update total nilai di tabel InspectionAnswer
            $inspection->update(['nilai' => $totalNilai]);

            $inspectionRecord = Inspection::find($inspection->inspection_id);
            if ($inspectionRecord) {
                $inspectionRecord->increment('jml_personel', 1);
            }

            DB::commit();

            // if ($status === 'SELESAI') {
            // return redirect()->route('inspection.detail_kunjungan')
            //     ->with('success', 'Pemeriksaan berhasil diselesaikan.');
            return redirect()->route('inspection.detail_kunjungan', ['id' => $request->id_inspection])
                ->with('success', 'Pemeriksaan berhasil diselesaikan.');

            // } else {
            // return redirect()->route('inspection.jadwal.index')
            //     ->with('success', 'Pemeriksaan disimpan sebagai pending.');
            // }
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->back()
                ->with('warning', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function detailInspection($id)
    {
        $data = InspectionAnswer::find($id);
        $dataDetail = DB::table('detail_inspections as di')
            ->join('instruments as i', 'di.id_instrumen', '=', 'i.id')
            ->join('instrument_titles as it', 'i.instrument_title_id', '=', 'it.id')
            ->where('di.id_pemeriksaan', $id)
            ->select('di.*', 'it.title as instrument_title')
            ->get();

        $groupedDetails = $dataDetail->groupBy('instrument_title');
        return view('inspection.jadwal.detail', compact('data', 'groupedDetails'));
    }

    public function detailInspectionEdit($id)
    {
        $data = InspectionAnswer::findOrFail($id); // Cari data berdasarkan ID
        $data_jabatan = Jabatan::pluck('id', 'nama_jabatan'); // Pilihan dropdown

        // Query menggunakan alias untuk penamaan properti yang lebih jelas
        $dataDetail = DB::table('detail_inspections as di')
            ->join('instruments as i', 'di.id_instrumen', '=', 'i.id')
            ->join('instrument_titles as it', 'i.instrument_title_id', '=', 'it.id')
            ->where('di.id_pemeriksaan', $id)
            ->select('di.*', 'it.title as instrument_title', 'i.deskripsi') // Gunakan alias untuk deskripsi
            ->get();

        // Grouping berdasarkan title instrumen
        $groupedDetails = $dataDetail->groupBy('instrument_title');

        return view('inspection.jadwal.detail_kunjungan_edit', compact('data', 'data_jabatan', 'groupedDetails'));
    }

    // public function detailInspectionUpdate(Request $request, $id)
    // {
    //     try {
    //         DB::beginTransaction();

    //         $inspection = Inspection::findOrFail($id);
    //         $inspection->update([
    //             'departemen' => $request->departemen,
    //             'nama_karyawan' => $request->nama_karyawan,
    //             'updated_at' => now(),
    //         ]);

    //         foreach ($request->details as $detail) {
    //             DetailInspection::updateOrCreate(
    //                 ['id_pemeriksaan' => $id, 'id_instrumen' => $detail['id_instrumen']],
    //                 [
    //                     'jawaban' => $detail['jawaban'],
    //                     'keterangan' => $detail['keterangan'] ?? '',
    //                 ]
    //             );
    //         }

    //         DB::commit();
    //         return redirect()->route('inspection.index')->with('success', 'Pemeriksaan berhasil diperbarui.');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->back()->with('warning', 'Terjadi kesalahan: ' . $e->getMessage());
    //     }
    // }

    public function detailInspectionUpdate(Request $request)
    {
        // dd($request->all());
        try {
            $pemeriksa = Auth::guard('user')->user()->id;
            $karyawan = Karyawan::where('nik', $request->nama_karyawan)->first();
            $cabang = DB::table('cabang')->where('kode_cabang', $karyawan->kode_cabang)->first();
            $inspectionId = $request->id_inspection;

            DB::beginTransaction();

            // Perbarui atau buat data inspection
            $inspection = InspectionAnswer::updateOrCreate(
                ['id' => $inspectionId], // Jika ID ada, update data
                [
                    'inspection_id' => $request->inspection_id,
                    'nik' => $karyawan->nik,
                    'user_id' => $pemeriksa,
                    'cabang' => $cabang->nama_cabang,
                    'jabatan' => $karyawan->jabatan,
                ]
            );

            $totalNilai = 0;

            // Simpan atau perbarui detail pemeriksaan
            foreach ($request->details as $detail) {
                $fotoPath = null;
                if (isset($detail['foto'])) {
                    $fotoPath = $detail['foto']->store('pemeriksaan_fotos', 'public');
                }

                $jawaban = $detail['jawaban'];
                $totalNilai += $jawaban; // Hitung total nilai

                
                // dd($karyawan->nik, "-", $inspection->id, "-", $detail['id_instrumen'], "-", $indikator, "-", $jawaban, "-", $detail['keterangan'], "-", $fotoPath);
                
                $existingDetail = DetailInspection::where([
                    'id' => $detail['id_instrumen'],
                    'id_pemeriksaan_perorang' => $karyawan->nik,
                    'id_pemeriksaan' => $inspection->id,
                ])->first();
                    
                $instrument = Instrument::find($existingDetail->id_instrumen);
                $indikator = $instrument ? $instrument->deskripsi : 'Deskripsi tidak ditemukan'; // Berikan default value jika null
                // dd($existingDetail);
                
                // dd($indikator);
                // Jika data ditemukan, lakukan update
                if ($existingDetail) {
                    $existingDetail->update([
                        'indikator' => $indikator,
                        'jawaban' => $jawaban,
                        'keterangan' => $detail['keterangan'] ?? '',
                        'foto' => $fotoPath,
                    ]);
                } else {
                    // Jika tidak ditemukan, Anda bisa memberi peringatan atau melakukan log jika perlu
                    // Contoh log:
                    // Log::warning('Detail inspection tidak ditemukan untuk update dengan ID pemeriksaan: ' . $inspection->id);
                    dd('Detail inspection tidak ditemukan untuk update dengan ID pemeriksaan: ' . $inspection->id);
                }
            }

            // Update total nilai pada tabel InspectionAnswer
            $inspection->update(['nilai' => $totalNilai]);

            // Update jumlah personel di tabel Inspection
            // $inspectionRecord = Inspection::find($inspection->inspection_id);
            // if ($inspectionRecord) {
            //     $inspectionRecord->increment('jml_personel', 1);
            // }

            DB::commit();
    
            return redirect()->route('inspection.detail_kunjungan', ['id' => $request->inspection_id])
                ->with('success', 'Data pemeriksaan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->back()
                ->with('warning', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function detailInspectionDelete($id)
    {
        try {
            DB::beginTransaction();

            // Cari data pemeriksaan berdasarkan ID
            $inspection = InspectionAnswer::find($id);

            if (!$inspection) {
                return redirect()->back()
                    ->with('warning', 'Pemeriksaan tidak ditemukan.');
            }

            // Hapus detail pemeriksaan yang terkait
            DetailInspection::where('id_pemeriksaan', $inspection->id)->delete();

            // Hapus data pemeriksaan itu sendiri
            $inspection->delete();

            // Decrement jumlah personel pada tabel Inspection jika ada
            $inspectionRecord = Inspection::find($inspection->inspection_id);
            if ($inspectionRecord) {
                $inspectionRecord->decrement('jml_personel', 1);
            }

            DB::commit();

            return redirect()->route('inspection.detail_kunjungan', ['id' => $inspection->inspection_id])
                ->with('success', 'Pemeriksaan berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('warning', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
