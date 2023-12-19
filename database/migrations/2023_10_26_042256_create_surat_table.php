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
        Schema::create('surat', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nik');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('pendidikan');
            $table->string('jabatan');
            $table->string('group_employee');
            $table->string('alamat');
            $table->string('no_surat');
            $table->date('tgl_awal_hubker');
            $table->date('tgl_akhir_hubker');
            $table->string('nama_pembuat');
            $table->string('kota_pembuat');
            $table->string('jabatan_ttd');
            $table->string('nama_ttd');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat');
    }
};
