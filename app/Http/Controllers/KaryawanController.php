<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Jabatan;
use App\Models\Profile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $kode_dept = Auth::guard('user')->user()->kode_dept;
        $kode_cabang = Auth::guard('user')->user()->kode_cabang;
        $user = User::find(Auth::guard('user')->user()->id);

        $query = Karyawan::query();
        $query->select('karyawan.*', 'nama_dept');
        $query->join('departemen', 'karyawan.kode_dept', '=', 'departemen.kode_dept');
        $query->orderBy('nama_lengkap');
        if (!empty($request->nama_karyawan)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_karyawan . '%');
        }

        if (!empty($request->jabatan)) {
            $query->where('karyawan.jabatan', $request->jabatan);
        }

        if (!empty($request->kode_cabang)) {
            $query->where('karyawan.kode_cabang', $request->kode_cabang);
        }

        if ($user->hasRole('admin departemen')) {
            $query->where('karyawan.kode_dept', $kode_dept);
            $query->where('karyawan.kode_cabang', $kode_cabang);
        }
        $karyawan = $query->paginate(10);
        $jabatan = Jabatan::all();
        $departemen = DB::table('departemen')->get();
        $cabang = DB::table('cabang')->orderBy('kode_cabang')->get();
        return view('karyawan.index', compact('karyawan', 'departemen', 'cabang', 'jabatan'));
    }

    public function show($nik)
    {
        // Mengambil data karyawan berdasarkan NIK
        $karyawan = Karyawan::with('profil')->where('nik', $nik)->first();

        // Cek apakah data karyawan ditemukan
        if (!$karyawan) {
            // return redirect()->view('karyawan.index')->with('error', 'Karyawan tidak ditemukan.');
            return view('karyawan.index')->with('error', 'Karyawan tidak ditemukan.');
        }

        // Mengembalikan tampilan dengan data karyawan
        return view('karyawan.detail', compact('karyawan'));
    }

    // Validasi input
    // $request->validate([
    //     'nik' => 'required|unique:karyawan,nik',
    //     'nama_lengkap' => 'required',
    //     'jabatan' => 'required',
    //     'no_hp' => 'required|numeric',
    //     'kode_dept' => 'required',
    //     'kode_cabang' => 'required',
    //     'foto' => 'image|mimes:png,jpg|max:1024',
    // ]);
    // $request->validate([
    //     'tahun_pelatihan' => 'required|digits:4|integer|min:1901|max:2155',
    // ]);

    // Generate ID Karyawan
    private function generateIdKaryawan($tahun, $bulan)
    {
        // Ambil nilai auto increment terakhir untuk bulan dan tahun yang sama
        $lastId = Karyawan::whereRaw('LEFT(id_karyawan, 4) = ?', [$tahun . $bulan])
            ->orderBy('id_karyawan', 'desc')
            ->first();

        // Jika belum ada ID sebelumnya, mulai dari 1
        $increment = $lastId ? intval(substr($lastId->id_karyawan, -4)) + 1 : 1;

        // Format auto increment dengan leading zero
        $incrementFormatted = str_pad($increment, 4, '0', STR_PAD_LEFT);

        // Gabungkan tahun, bulan, dan increment
        return $tahun . $bulan . $incrementFormatted;
    }
    public function store(Request $request)
    {
        
        $nik = $request->nik;
        $nama_lengkap = $request->nama_lengkap;
        $username = strtolower(strtok($nama_lengkap, ' '));
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $kode_dept = $request->kode_dept;
        $password = Hash::make('12345');
        $kode_cabang = $request->kode_cabang;
        $foto = null;

        // Proses foto jika ada
        if ($request->hasFile('foto')) {
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        }

        // Dapatkan waktu sekarang
        $now = Carbon::now();

        // Ambil 2 digit terakhir tahun dan 2 digit bulan
        $tahun = $now->format('y'); // 2 digit tahun terakhir, contoh: '24' untuk 2024
        $bulan = $now->format('m'); // Bulan dalam format 2 digit, contoh: '09' untuk September

        $id_karyawan = $this->generateIdKaryawan($tahun, $bulan);

        // Mulai transaksi
        DB::beginTransaction();
        try {
            // Insert data ke tabel karyawan menggunakan Eloquent
            $karyawan = Karyawan::create([
                'nik' => $nik,
                'id_karyawan' => $id_karyawan,
                'nama_lengkap' => $nama_lengkap,
                'username' => $username,
                'jabatan' => $jabatan,
                'no_hp' => $no_hp,
                'foto' => $foto,
                'kode_dept' => $kode_dept,
                'kode_cabang' => $kode_cabang,
                'password' => $password
            ]);

            // Simpan foto jika ada
            if ($request->hasFile('foto')) {
                $folderPath = "public/uploads/karyawan/";
                $request->file('foto')->storeAs($folderPath, $foto);
            }

            // Insert data ke tabel profil menggunakan Eloquent
            // $profil = new Profile([
            //     'nik' => $nik,
            //     'tempat_lahir' => $request->tempat_lahir,
            //     'tanggal_lahir' => $request->tanggal_lahir,
            //     'nama_ibu_kandung' => $request->nama_ibu_kandung,
            //     'jenis_kelamin' => $request->jenis_kelamin,
            //     'agama' => $request->agama,
            //     'status_menikah' => $request->status_menikah,
            //     'alamat_ktp' => $request->alamat_ktp,
            //     'nomor_kk' => $request->nomor_kk,
            //     'pendidikan_terakhir' => $request->pendidikan_terakhir,
            //     'institusi' => $request->institusi,
            //     'masa_aktif_sim' => $request->masa_aktif_sim,
            //     'pendidikan_satpam' => $request->pendidikan_satpam,
            //     'tahun_pelatihan' => $request->tahun_pelatihan,
            //     'no_kta' => $request->no_kta,
            //     'penerbit_kta' => $request->penerbit_kta,
            //     'masa_aktif_kta' => $request->masa_aktif_kta,
            //     'no_registrasi' => $request->no_registrasi,
            //     'tmt_awal_penugasan' => $request->tmt_awal_penugasan,
            //     'nama_bank' => $request->nama_bank,
            //     'no_rekening' => $request->no_rekening,
            //     'no_bpjs_kesehatan' => $request->no_bpjs_kesehatan,
            //     'no_bpjs_ketenagakerjaan' => $request->no_bpjs_ketenagakerjaan,
            //     'no_npwp' => $request->no_npwp
            // ]);


            // // Simpan data profil terkait dengan karyawan
            // $karyawan->profil()->save($profil);

            // Commit transaksi jika berhasil
            DB::commit();
            return Redirect::back()->with(['success' => 'Data Karyawan dan Profil Berhasil Disimpan']);
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();
            dd($e->getMessage());

            if ($e->getCode() == 23000) {
                $message = "Data dengan Nik " . $nik . " Sudah Ada";
            } else {
                $message = "Hubungi IT";
            }
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan ' . $message]);
        }
    }

    public function storeProfile(Request $request, $nik)
    {

        // dd($request->all());
        // Validasi data input
        // $request->validate([
        //     'tempat_lahir' => 'required|string|max:255',
        //     'tanggal_lahir' => 'required|date',
        //     // Tambahkan validasi untuk kolom lainnya
        // ]);

        DB::beginTransaction();
        try {
            // Cari karyawan berdasarkan ID
            $karyawan = Karyawan::findOrFail($nik);

            $profil = Profile::where('nik', $nik)->first();
            // Jika data profil sudah ada, lakukan update
            if ($profil) {
                $profil->update([
                    'tempat_lahir' => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'nama_ibu_kandung' => $request->nama_ibu_kandung,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'agama' => $request->agama,
                    'status_menikah' => $request->status_menikah,
                    'alamat_ktp' => $request->alamat_ktp,
                    'nomor_kk' => $request->nomor_kk,
                    'pendidikan_terakhir' => $request->pendidikan_terakhir,
                    'institusi' => $request->institusi,
                    'masa_aktif_sim' => $request->masa_aktif_sim,
                    'pendidikan_satpam' => $request->pendidikan_satpam,
                    'tahun_pelatihan' => $request->tahun_pelatihan,
                    'no_kta' => $request->no_kta,
                    'penerbit_kta' => $request->penerbit_kta,
                    'masa_aktif_kta' => $request->masa_aktif_kta,
                    'no_registrasi' => $request->no_registrasi,
                    'tmt_awal_penugasan' => $request->tmt_awal_penugasan,
                    'nama_bank' => $request->nama_bank,
                    'no_rekening' => $request->no_rekening,
                    'no_bpjs_kesehatan' => $request->no_bpjs_kesehatan,
                    'no_bpjs_ketenagakerjaan' => $request->no_bpjs_ketenagakerjaan,
                    'no_npwp' => $request->no_npwp,
                ]);
                $message = 'Profil Karyawan Berhasil Diperbarui';
            } else {
                // Jika data profil belum ada, buat baru
                $profil = new Profile([
                    'nik' => $nik,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'nama_ibu_kandung' => $request->nama_ibu_kandung,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'agama' => $request->agama,
                    'status_menikah' => $request->status_menikah,
                    'alamat_ktp' => $request->alamat_ktp,
                    'nomor_kk' => $request->nomor_kk,
                    'pendidikan_terakhir' => $request->pendidikan_terakhir,
                    'institusi' => $request->institusi,
                    'masa_aktif_sim' => $request->masa_aktif_sim,
                    'pendidikan_satpam' => $request->pendidikan_satpam,
                    'tahun_pelatihan' => $request->tahun_pelatihan,
                    'no_kta' => $request->no_kta,
                    'penerbit_kta' => $request->penerbit_kta,
                    'masa_aktif_kta' => $request->masa_aktif_kta,
                    'no_registrasi' => $request->no_registrasi,
                    'tmt_awal_penugasan' => $request->tmt_awal_penugasan,
                    'nama_bank' => $request->nama_bank,
                    'no_rekening' => $request->no_rekening,
                    'no_bpjs_kesehatan' => $request->no_bpjs_kesehatan,
                    'no_bpjs_ketenagakerjaan' => $request->no_bpjs_ketenagakerjaan,
                    'no_npwp' => $request->no_npwp,
                ]);

                // Simpan data profil terkait dengan karyawan
                $karyawan->profil()->save($profil);
                $message = 'Profil Karyawan Berhasil Disimpan';
            }
           
            // Commit transaksi
            DB::commit();
            return Redirect::back()->with(['success' => $message]);
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();
            dd($e->getMessage());
            return Redirect::back()->with(['error' => 'Data Gagal Disimpan: ' . $e->getMessage()]);
        }
    }


    public function edit(Request $request)
    {
        $nik = $request->nik;
        $departemen = DB::table('departemen')->get();
        $cabang = DB::table('cabang')->orderBy('kode_cabang')->get();
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        $profil = DB::table('profil')->where('nik', $nik)->first();
        $jabatan = Jabatan::all();
        return view('karyawan.edit', compact('departemen', 'karyawan', 'cabang', 'profil', 'jabatan'));
    }

    public function update($nik, Request $request)
    {
        $nik = Crypt::decrypt($nik);  // Dekripsi NIK
        $nik_baru = $request->nik_baru;

        // Pengecekan apakah NIK baru sudah digunakan oleh karyawan lain
        $cekNik = Karyawan::where('nik', $nik_baru)->where('nik', '!=', $nik)->count();
        if ($cekNik > 0) {
            return redirect()->back()->with(['warning' => 'NIK sudah digunakan']);
        }

        // Mulai transaksi
        DB::beginTransaction();
        try {
            // Cari data karyawan berdasarkan NIK yang didekripsi
            $karyawan = Karyawan::where('nik', $nik)->firstOrFail();

            // Proses foto baru jika ada, atau gunakan foto lama
            $foto = $request->hasFile('foto') ? $nik . "." . $request->file('foto')->getClientOriginalExtension() : $request->old_foto;

            $nama_lengkap = $request->nama_lengkap;
            $username = strtolower(strtok($nama_lengkap, ' '));

            // Update data karyawan
            $karyawan->update([
                'nik' => $nik_baru,
                'nama_lengkap' =>  $nama_lengkap,
                'username' => $username,
                'jabatan' => $request->jabatan,
                'no_hp' => $request->no_hp,
                'kode_dept' => $request->kode_dept,
                'kode_cabang' => $request->kode_cabang,
                'foto' => $foto,
                'password' => Hash::make($request->filled('password') ? $request->password : '12345'),
            ]);

            // Update atau buat profil baru jika belum ada
            $profil = $karyawan->profil ?? new Profile(['nik' => $nik_baru]);
            $profil->fill([
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'nama_ibu_kandung' => $request->nama_ibu_kandung,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'status_menikah' => $request->status_menikah,
                'alamat_ktp' => $request->alamat_ktp,
                'nomor_kk' => $request->nomor_kk,
                'pendidikan_terakhir' => $request->pendidikan_terakhir,
                'institusi' => $request->institusi,
                'masa_aktif_sim' => $request->masa_aktif_sim,
                'pendidikan_satpam' => $request->pendidikan_satpam,
                'tahun_pelatihan' => $request->tahun_pelatihan,
                'no_kta' => $request->no_kta,
                'penerbit_kta' => $request->penerbit_kta,
                'masa_aktif_kta' => $request->masa_aktif_kta,
                'no_registrasi' => $request->no_registrasi,
                'tmt_awal_penugasan' => $request->tmt_awal_penugasan,
                'nama_bank' => $request->nama_bank,
                'no_rekening' => $request->no_rekening,
                'no_bpjs_kesehatan' => $request->no_bpjs_kesehatan,
                'no_bpjs_ketenagakerjaan' => $request->no_bpjs_ketenagakerjaan,
                'no_npwp' => $request->no_npwp,
            ]);
            $karyawan->profil()->save($profil);

            // Proses simpan foto jika ada file baru yang diunggah
            if ($request->hasFile('foto')) {
                $folderPath = "public/uploads/karyawan/";
                $folderPathOld = "public/uploads/karyawan/" . $request->old_foto;

                // Hapus foto lama jika ada
                Storage::delete($folderPathOld);

                // Simpan foto baru
                $request->file('foto')->storeAs($folderPath, $foto);
            }

            // Commit transaksi jika berhasil
            DB::commit();
            return redirect()->back()->with(['success' => 'Data Karyawan dan Profil berhasil diupdate']);
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            DB::rollBack();
            return redirect()->back()->with(['warning' => 'Data gagal diupdate. Hubungi IT']);
        }
    }

    public function delete($nik)
    {
        $delete = DB::table('karyawan')->where('nik', $nik)->delete();
        if ($delete) {
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Dihapus']);
        }
    }

    public function resetpassword($nik)
    {
        $nik = Crypt::decrypt($nik);
        $password = Hash::make('12345');
        $reset = DB::table('karyawan')->where('nik', $nik)->update([
            'password' => $password
        ]);

        if ($reset) {
            return Redirect::back()->with(['success' => 'Data Password Berhasil di Reset']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Password Gagal di Reset']);
        }
    }

    public function lockandunlocklocation($nik)
    {
        try {
            $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
            $status_location = $karyawan->status_location;
            if ($status_location == '1') {
                DB::table('karyawan')->where('nik', $nik)->update([
                    'status_location' => '0'
                ]);
            } else {
                DB::table('karyawan')->where('nik', $nik)->update([
                    'status_location' => '1'
                ]);
            }

            return Redirect::back()->with(['success' => 'Status Location Berhasil Diupdate']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => 'Status Location Gagal Diupdate']);
        }
    }

    public function lockandunlockjamkerja($nik)
    {
        try {
            $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
            $status_jam_kerja = $karyawan->status_jam_kerja;
            if ($status_jam_kerja == '1') {
                DB::table('karyawan')->where('nik', $nik)->update([
                    'status_jam_kerja' => '0'
                ]);
            } else {
                DB::table('karyawan')->where('nik', $nik)->update([
                    'status_jam_kerja' => '1'
                ]);
            }

            return Redirect::back()->with(['success' => 'Status Jam Kerja Berhasil Diupdate']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => 'Status Jam Kerja Gagal Diupdate']);
        }
    }
}
