<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailInspection extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'detail_inspections';

    // Kolom yang bisa diisi secara massal
    protected $fillable = [
        'id_pemeriksaan',
        'id_instrumen',
        'indikator',
        'jawaban',
        'keterangan',
        'foto'
    ];

    // Relasi ke tabel Pemeriksaan
    public function inspection()
    {
        return $this->belongsTo(Inspection::class, 'inspection_id');
    }

    

    // Relasi ke tabel Instrumen
    public function instrumen()
    {
        return $this->belongsTo(Instrument::class, 'instrument_id');
    }

    public function instrumentTitle(){
        return $this->belongsTo(InstrumentTitle::class, 'instrument_title_id', 'id');
    }
}
