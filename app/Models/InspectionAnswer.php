<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['inspection_id', 'instrument_id', 'jawaban'];

    public function inspection()
    {
        return $this->belongsTo(Inspection::class);
    }

    public function instrument()
    {
        return $this->belongsTo(Instrument::class);
    }
}
