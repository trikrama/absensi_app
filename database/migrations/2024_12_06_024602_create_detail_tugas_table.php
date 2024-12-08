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
        Schema::create('detail_tugas', function (Blueprint $table) {
            $table->id(); // Primary key otomatis
            $table->char('tugas_id', 6)->charset('latin1')->collation('latin1_swedish_ci')->notNullable(); // Kolom tugas_id dengan tipe char(6)
            $table->char('nik', 18)->nullable()->collation('latin1_swedish_ci'); // Kolom nik dengan charset dan collation
            $table->timestamps(); // Kolom created_at dan updated_at

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_tugas');
    }
};
