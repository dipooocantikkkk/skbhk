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
        Schema::table('master_branch_regulers', function (Blueprint $table) {
            if (!Schema::hasColumn('master_branch_regulers', 'status')) {
                $table->boolean('status')->default(true);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_branch_regulers', function (Blueprint $table) {
            //
        });
    }
};
