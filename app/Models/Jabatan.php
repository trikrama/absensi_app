<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    // Nama tabel (opsional jika sesuai dengan konvensi Laravel)
    protected $table = 'jabatan';

    // Kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'nama_jabatan',
    ];

    public function instruments()
    {
        return $this->hasMany(Instrument::class, 'id', 'id'); // foreign key dan primary key
    }

    // Kolom yang tidak boleh diisi secara massal (optional)
    // protected $guarded = [];

    // Relasi ke model lain (jika ada)
    // Misalnya, jika jabatan berhubungan dengan karyawan:
    // public function karyawan()
    // {
    //     return $this->hasMany(Karyawan::class, 'jabatan_id');
    // }
}
