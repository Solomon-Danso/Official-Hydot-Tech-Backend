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
            $table->longText("Section")->nullable();
            $table->longText("Target")->nullable();
            $table->float("Amount")->nullable();
            $table->dateTime("Deadline")->nullable();
            $table->longText("Statuz")->nullable();
            $table->longText("Description")->nullable();
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
