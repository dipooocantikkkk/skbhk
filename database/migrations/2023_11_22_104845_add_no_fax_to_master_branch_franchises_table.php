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
            if (!Schema::hasColumn('master_branchfranchises', 'no_fax')) {
                $table->string('no_fax')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_branch_franchises', function (Blueprint $table) {
            //
        });
    }
};
