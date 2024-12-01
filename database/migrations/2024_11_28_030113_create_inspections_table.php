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
        Schema::create('inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->char('kode_dept', 3)
                ->charset('latin1') // Sesuaikan character set
                ->collation('latin1_swedish_ci'); // Sesuaikan collation
            $table->foreign('kode_dept')
                ->references('kode_dept')
                ->on('departemen')
                ->cascadeOnDelete();
            $table->string('lokasi');
            $table->date('tgl_pemeriksaan');
            $table->enum('status', ['BELUM', 'SELESAI'])->default('BELUM');
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('inspections');
    }
};
