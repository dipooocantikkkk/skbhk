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
    Schema::table('surat', function (Blueprint $table) {
        $table->foreignId('editor_id')->nullable()->constrained('users');
    });
}

public function down()
{
    Schema::table('surat', function (Blueprint $table) {
        $table->dropColumn('editor_id');
    });
}
};
