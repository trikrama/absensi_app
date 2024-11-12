<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profil', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('nik', 18)->charset('latin1')->collation('latin1_swedish_ci')->notNullable();
            $table->string('tempat_lahir', 50)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('nama_ibu_kandung', 100)->nullable();
            $table->char('jenis_kelamin', 1)->nullable();
            $table->string('agama', 20)->nullable();
            $table->boolean('status_menikah')->nullable();
            $table->string('alamat_ktp', 255)->nullable();
            $table->char('nomor_kk', 16)->nullable();
            $table->string('pendidikan_terakhir', 50)->nullable();
            $table->string('institusi', 100)->nullable();
            $table->date('masa_aktif_sim')->nullable();
            $table->string('pendidikan_satpam', 50)->nullable();
            $table->year('tahun_pelatihan')->nullable();
            $table->string('no_kta', 30)->nullable();
            $table->string('penerbit_kta', 50)->nullable();
            $table->date('masa_aktif_kta')->nullable();
            $table->string('no_registrasi', 30)->nullable();
            $table->date('tmt_awal_penugasan')->nullable();
            $table->string('nama_bank', 50)->nullable();
            $table->string('no_rekening', 20)->nullable();
            $table->string('no_bpjs_kesehatan', 30)->nullable();
            $table->string('no_bpjs_ketenagakerjaan', 30)->nullable();
            $table->string('no_npwp', 30)->nullable();
            $table->timestamps();
            
            // Foreign key referencing 'karyawan' table
            $table->foreign('nik')->references('nik')->on('karyawan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profil');
    }
};
