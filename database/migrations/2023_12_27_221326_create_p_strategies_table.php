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
        Schema::create('p_strategies', function (Blueprint $table) {
            $table->id();
            $table->string("Section")->nullable();
            $table->string("Target")->nullable();
            $table->float("Amount")->nullable();
            $table->dateTime("Deadline")->nullable();
            $table->string("Statuz")->nullable();
            $table->string("Description")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('p_strategies');
    }
};
