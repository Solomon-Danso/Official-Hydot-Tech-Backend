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
        Schema::create('p_savings', function (Blueprint $table) {
            $table->id();
            $table->string("Section")->nullable();
            $table->string("Saving")->nullable();
            $table->float("Amount")->nullable();
            $table->dateTime("TheDate")->nullable();
            $table->string("Status")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('p_savings');
    }
};
