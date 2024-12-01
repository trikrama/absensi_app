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
        Schema::create('detail_inspections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pemeriksaan'); // Foreign key ke tabel pemeriksaan
            $table->unsignedBigInteger('id_instrumen');   // Foreign key ke tabel instrumen
            $table->string('indikator');                    // Menyimpan indikator
            $table->text('keterangan');                     // Menyimpan keterangan
            $table->string('foto')->nullable();             // Menyimpan nama file foto (opsional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_inspections');
    }
};
