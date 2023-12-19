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
        Schema::table('master_branch_franchises', function (Blueprint $table) {
            $table->boolean('status')->default(1); // default(1) menandakan nilai default ketika kolom baru ditambahkan
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_branch_franchises', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
