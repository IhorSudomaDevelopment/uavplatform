<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /*** Run the migrations. */
    public function up(): void
    {
        Schema::create('drone_losts', function (Blueprint $table) {
            $table->id();
            $table->integer('drone_id');
            $table->string('drone_sn');
            $table->string('date');
            $table->string('time');
            $table->string('lost_coords');
            $table->string('lost_reason');
            $table->timestamps();
        });
    }

    /*** Reverse the migrations. */
    public function down(): void
    {
        Schema::dropIfExists('drone_losts');
    }
};
