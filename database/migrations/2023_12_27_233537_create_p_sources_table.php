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
        Schema::create('p_sources', function (Blueprint $table) {
            $table->id();
            $table->longText("Section")->nullable();
            $table->longText("Source")->nullable();
            $table->float("Amount")->nullable();
            $table->dateTime("StartDate")->nullable();
            $table->longText("Status")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('p_sources');
    }
};
