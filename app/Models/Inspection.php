<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    use HasFactory;

    protected $fillable = ['nik','user_id', 'kode_dept', 'lokasi', 'tgl_pemeriksaan', 'tujuan', 'status', 'keterangan', 'foto_bukti'];

    public function answers()
    {
        return $this->hasMany(InspectionAnswer::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details() {
        return $this->hasMany(DetailInspection::class, 'id_pemeriksaan', 'id');
    }

    public function karyawan() {
        return $this->belongsTo(Karyawan::class, 'nik', 'nik');
    }

    // public function departemen()
    // {
    //     return $this->belongsTo(Departemen::class);
    // }
    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'kode_dept', 'kode_dept'); // foreign key dan primary key
    }

}
