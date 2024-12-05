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
        Schema::table('inspections', function (Blueprint $table) {
            //
            $table->char('nik', 18)
                ->charset('latin1')
                ->collation('latin1_swedish_ci')
                ->after('id') // Sesuaikan kolom ini jika ingin menempatkan `nik` setelah kolom tertentu
                ->nullable(false)
                ->comment('NIK of the person');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inspections', function (Blueprint $table) {
            //
            $table->dropColumn('nik');
        });
    }
};
