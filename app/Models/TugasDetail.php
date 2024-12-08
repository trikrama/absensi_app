<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasDetail extends Model
{
    use HasFactory;

    protected $table = 'detail_tugas';
    protected $fillable = ['tugas_id', 'nik']; // Field yang dapat diisi


    // Relasi balik ke Tugas
    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'nik', 'nik');
    }
}
