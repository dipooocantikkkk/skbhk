<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('master_branch_franchises', function (Blueprint $table) {
            $table->string('nama_toko'); 
            $table->string('alamat_toko'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_branch_franchises', function (Blueprint $table) {
            $table->dropColumn('nama_toko');
            $table->dropColumn('alamat_toko');
        });
    }
};
