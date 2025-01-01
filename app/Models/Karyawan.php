<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Karyawan extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // Tentukan tabel yang digunakan (optional)
    // public $timestamps = false;
    protected $table = "karyawan";
    protected $primaryKey = "nik";
    public $incrementing = false;

    // Tentukan kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'nik',
        'id_karyawan',
        'nama_lengkap',
        'username',
        'jabatan',
        'no_hp',
        'kode_dept',
        'foto',
        'password',
        'kode_cabang'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relasi satu ke satu dengan tabel profil
    public function profil()
    {
        return $this->hasOne(Profile::class, 'nik', 'nik');
    }

    public function inspection_answer(){
        return $this->hasMany(InspectionAnswer::class, 'nik', 'nik');
    }
}
