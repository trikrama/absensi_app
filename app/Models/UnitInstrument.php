<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitInstrument extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'departemen_id',
        'id_jabatan',
        'instrument_id',
    ];

    /**
     * Get the unit associated with the unit instrument.
     */
    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'kode_dept', 'kode_dept');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan', 'id');
    }   

    /**
     * Get the instrument associated with the unit instrument.
     */
    public function instrument()
    {
        return $this->belongsTo(Instrument::class);
    }
}
