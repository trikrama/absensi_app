<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    // Tentukan tabel yang digunakan (optional)
    protected $table = 'profil';

    // Tentukan kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'nama_ibu_kandung',
        'jenis_kelamin',
        'agama',
        'status_menikah',
        'alamat_ktp',
        'nomor_kk',
        'pendidikan_terakhir',
        'institusi',
        'masa_aktif_sim',
        'pendidikan_satpam',
        'tahun_pelatihan',
        'no_kta',
        'penerbit_kta',
        'masa_aktif_kta',
        'no_registrasi',
        'tmt_awal_penugasan',
        'nama_bank',
        'no_rekening',
        'no_bpjs_kesehatan',
        'no_bpjs_ketenagakerjaan',
        'no_npwp'
    ];

    // Relasi balik ke tabel karyawan
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'nik', 'nik');
    }
}
