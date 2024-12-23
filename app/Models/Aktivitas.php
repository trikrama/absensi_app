<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aktivitas extends Model
{
    use HasFactory;

    protected $fillable = ['nik', 'tanggal_aktivitas', 'waktu_aktivitas', 'deskripsi', 'foto'];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
