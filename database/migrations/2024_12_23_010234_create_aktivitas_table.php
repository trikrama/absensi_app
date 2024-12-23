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
        Schema::create('aktivitas', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('nik')->constrained()->onDelete('cascade');
            $table->char('nik', 18)->charset('latin1')->collation('latin1_swedish_ci')->notNullable();
            $table->date('tanggal_aktivitas');
            $table->time('waktu_aktivitas');
            $table->text('deskripsi');
            $table->string('foto')->nullable();
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
        Schema::dropIfExists('aktivitas');
    }
};
