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
        Schema::create('site_homes', function (Blueprint $table) {
            $table->id();
            $table->string("companyLogo")->nullable();
            $table->string("backgroundImage")->nullable();
            $table->string("welcomeMessage")->nullable();
            $table->string("slogan")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_homes');
    }
};
