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
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('position');
            $table->integer('flight_number');
            $table->string('date');
            $table->string('time_start');
            $table->string('time_end');
            $table->string('target');
            $table->string('coordinates');
            $table->string('status');
            $table->json('ammunition');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flights');
    }
};
