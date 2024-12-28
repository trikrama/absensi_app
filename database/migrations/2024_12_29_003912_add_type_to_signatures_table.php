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
        Schema::table('signatures', function (Blueprint $table) {
            $table->string('type')->nullable()->after('id'); // TTD1 atau TTD2
        });
    }
    
    public function down()
    {
        Schema::table('signatures', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
