<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*** Run the migrations. */
    public function up(): void
    {
        Schema::table('flights', function (Blueprint $table) {
            $table->json('status')->change();
            $table->integer('personnel_300')->after('status')->default(0);
            $table->integer('personnel_200')->after('status')->default(0);
        });
    }
};
