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
        Schema::create('unit_instruments', function (Blueprint $table) {
            $table->id();
            $table->char('kode_dept', 3)
                ->charset('latin1') // Sesuaikan character set
                ->collation('latin1_swedish_ci'); // Sesuaikan collation
            $table->foreign('kode_dept')
                ->references('kode_dept')
                ->on('departemen')
                ->cascadeOnDelete();
            $table->foreignId('instrument_id')->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('unit_instruments');
    }
};
