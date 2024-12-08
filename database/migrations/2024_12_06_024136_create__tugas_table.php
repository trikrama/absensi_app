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
        Schema::create('tugas', function (Blueprint $table) {
            $table->char('tugas_id', 6)->charset('latin1')->collation('latin1_swedish_ci')->notNullable();
            $table->string('judul_tugas');
            $table->text('deskripsi_tugas');
            $table->string('lampiran_tugas')->nullable();
            $table->enum('status', ['selesai', 'belum'])->default('belum'); // Status tugas
            $table->dateTime('deadline');
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
        Schema::dropIfExists('tugas');
    }
};
