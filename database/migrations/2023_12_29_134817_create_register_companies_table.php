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
        Schema::create('register_companies', function (Blueprint $table) {
            $table->id();
            $table->string("CompanyId")->nullable();
            $table->string("CompanyLogo")->nullable();
            $table->string("CompanyName")->nullable();
            $table->string("Location")->nullable();
            $table->string("ContactPerson")->nullable();
            $table->string("CompanyPhone")->nullable();
            $table->string("CompanyEmail")->nullable();
            $table->string("ContactPersonPhone")->nullable();
            $table->string("ContactPersonEmail")->nullable();
            $table->string("CompanyStatus")->nullable();
            $table->string("Token")->nullable();
            $table->integer("Subcriptions")->nullable();
            $table->dateTime("StartDate")->nullable();
            $table->dateTime("SystemDate")->nullable();
            $table->dateTime("CurrentDate")->nullable();
            $table->dateTime("ExpireDate")->nullable();
            $table->string("TokenStatus")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('register_companies');
    }
};
