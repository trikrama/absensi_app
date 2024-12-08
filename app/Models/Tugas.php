<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;
     // Jika primary key bukan 'id', tentukan sebagai berikut:
     protected $primaryKey = 'tugas_id';

     // Jika primary key bukan auto-increment, tambahkan ini
     public $incrementing = false;
 
     // Jika primary key adalah string, tambahkan ini
     protected $keyType = 'string';
    protected $fillable = ['tugas_id','judul_tugas', 'deskripsi_tugas', 'lampiran_tugas', 'status', 'deadline']; // Field yang dapat diisi

    // Relasi satu ke banyak dengan DetailTugas
    public function tugasDetail()
    {
        return $this->hasMany(TugasDetail::class);
    }
}
