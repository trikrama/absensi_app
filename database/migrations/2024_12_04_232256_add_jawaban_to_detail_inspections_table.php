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
        Schema::table('detail_inspections', function (Blueprint $table) {
            Schema::table('detail_inspections', function (Blueprint $table) {
                $table->string('jawaban', 255)
                      ->after('indikator') // Menentukan kolom ini berada setelah kolom 'indikator'
                      ->nullable(false)    // Kolom tidak boleh bernilai NULL
                      ->comment('');       // Menambahkan komentar (kosong dalam kasus ini)
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_inspections', function (Blueprint $table) {
            $table->dropColumn('jawaban');
        });
    }
};
