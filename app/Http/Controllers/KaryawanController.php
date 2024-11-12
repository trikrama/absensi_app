<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Profile;
use App\Models\User;
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

        if (!empty($request->kode_dept)) {
            $query->where('karyawan.kode_dept', $request->kode_dept);
        }

        if (!empty($request->kode_cabang)) {
            $query->where('karyawan.kode_cabang', $request->kode_cabang);
        }

        if ($user->hasRole('admin departemen')) {
            $query->where('karyawan.kode_dept', $kode_dept);
            $query->where('karyawan.kode_cabang', $kode_cabang);
        }
        $karyawan = $query->paginate(10);

        $departemen = DB::table('departemen')->get();
        $cabang = DB::table('cabang')->orderBy('kode_cabang')->get();
        return view('karyawan.index', compact('karyawan', 'departemen', 'cabang'));
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

    public function store(Request $request)
    {

        $nik = $request->nik;
        $nama_lengkap = $request->nama_lengkap;
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

        // Mulai transaksi
        DB::beginTransaction();
        try {
            // Insert data ke tabel karyawan menggunakan Eloquent
            $karyawan = Karyawan::create([
                'nik' => $nik,
                'nama_lengkap' => $nama_lengkap,
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
                'no_npwp' => $request->no_npwp
            ]);


            // Simpan data profil terkait dengan karyawan
            $karyawan->profil()->save($profil);

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

    public function edit(Request $request)
    {
        $nik = $request->nik;
        $departemen = DB::table('departemen')->get();
        $cabang = DB::table('cabang')->orderBy('kode_cabang')->get();
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        return view('karyawan.edit', compact('departemen', 'karyawan', 'cabang'));
    }

    public function update($nik, Request $request)
    {
        $nik = Crypt::decrypt($nik);
        $nik_baru = $request->nik_baru;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $kode_dept = $request->kode_dept;
        $kode_cabang = $request->kode_cabang;
        $password = Hash::make('12345');
        $old_foto = $request->old_foto;
        if ($request->hasFile('foto')) {
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $old_foto;
        }


        $ceknik = DB::table('karyawan')
            ->where('nik', $nik_baru)
            ->where('nik', '!=', $nik)
            ->count();
        if ($ceknik > 0) {
            return Redirect::back()->with(['warning' => 'Nik Sudah Digunakan']);
        }
        try {
            $data =  [
                'nik' => $nik_baru,
                'nama_lengkap' => $nama_lengkap,
                'jabatan' => $jabatan,
                'no_hp' => $no_hp,
                'kode_dept' => $kode_dept,
                'foto' => $foto,
                'password' => $password,
                'kode_cabang' => $kode_cabang
            ];
            $update = DB::table('karyawan')->where('nik', $nik)->update($data);
            if ($update) {
                if ($request->hasFile('foto')) {
                    $folderPath = "public/uploads/karyawan/";
                    $folderPathOld = "public/uploads/karyawan/" . $old_foto;
                    Storage::delete($folderPathOld);
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success' => 'Data Berhasil Update']);
            }
        } catch (\Exception $e) {
            dd($e);
            return Redirect::back()->with(['warning' => 'Data Gagal Diupdate']);
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
