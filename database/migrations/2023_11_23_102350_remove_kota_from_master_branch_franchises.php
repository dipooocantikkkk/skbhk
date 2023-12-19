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
        Schema::table('master_branch_franchises', function (Blueprint $table) {
            $table->dropColumn('kota');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('master_branch_franchises', function (Blueprint $table) {
            $table->string('kota')->nullable();
        });
    }
};
