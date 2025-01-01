<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['inspection_id', 'instrument_id', 'nik', 'cabang','jawaban', 'nilai', 'jabatan'];

    // public function inspection()
    // {
    //     return $this->belongsTo(Inspection::class);
    // }

    public function inspection()
    {
        return $this->belongsTo(Inspection::class, 'inspection_id', 'id');
    }

    public function instrument()
    {
        return $this->belongsTo(Instrument::class);
    }

    public function karyawan() {
        return $this->belongsTo(Karyawan::class, 'nik', 'nik');
    }
}
