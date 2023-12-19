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
        if (!Schema::hasColumn('karyawan', 'tgl_akhir_hubker')) {
            $table->date('tgl_akhir_hubker')->notNull();
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('karyawan', function (Blueprint $table) {
            //
        });
    }
};
