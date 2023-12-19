<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('karyawan', function (Blueprint $table) {
            $table->string('jenis_pkwt')->nullable();
            $table->string('no_pkwt')->nullable();
            $table->date('tgl_pkwt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('karyawan', function (Blueprint $table) {
            $table->dropColumn(['jenis_pkwt', 'no_pkwt', 'tgl_pkwt']);
        });
    }
};
