<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    use HasFactory;
    protected $table = "departemen";

    public $timestamps = false;

    protected $fillable = [
        'kode_dept',
        'nama_dept',
    ];

    public function instruments()
    {
        return $this->hasMany(Instrument::class, 'kode_dept', 'id'); // foreign key dan primary key
    }

    public function inspection(){
        return $this->hasMany(Inspection::class, 'kode_dept', 'id');
    }

}
