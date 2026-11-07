<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*** Run the migrations. */
    public function up(): void
    {
        Schema::table('ammunitions', function (Blueprint $table) {
            $table->float('box_weight')->after('description')->nullable();
            $table->float('weight')->after('description')->nullable();
        });
    }
};
