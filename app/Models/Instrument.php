<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
    use HasFactory;

    protected $fillable = ['instrument_title_id', 'deskripsi', 'tipe'];

    public function title()
    {
        return $this->belongsTo(InstrumentTitle::class, 'instrument_title_id');
    }
    // public function departemen()
    // {
    //     return $this->belongsTo(Departemen::class, 'kode_dept', 'kode_dept'); // foreign key dan primary key
    // }

    public function departemen()
    {
        return $this->belongsToMany(Departemen::class, 'kode_dept', 'kode_dept');
    }
}
