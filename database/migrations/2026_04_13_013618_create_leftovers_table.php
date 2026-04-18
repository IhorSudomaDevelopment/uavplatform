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
        Schema::create('leftovers', function (Blueprint $table) {
            $table->id();
            $table->integer('position_id');
            $table->string('title');
            $table->integer('quantity')->default(0);
            $table->string('unit')->default('шт');
            $table->string('leftover_on');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leftovers');
    }
};
