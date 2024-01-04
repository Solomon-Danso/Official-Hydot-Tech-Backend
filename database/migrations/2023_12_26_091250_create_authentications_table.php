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
        Schema::create('authentications', function (Blueprint $table) {
            $table->id();
            $table->longText("FullName")->nullable();
            $table->longText("Contact")->nullable();
            $table->longText("Email")->nullable();
            $table->longText("Role")->nullable();
            $table->longText("Password")->nullable();
            $table->longText("Token")->nullable();
            $table->longText("UserId")->nullable();
            $table->longText("SToken")->nullable();
            $table->dateTime("TokenExpire")->nullable();
            $table->dateTime("STokenExpire")->nullable();
            $table->integer("LoginAttempt")->nullable();
            $table->boolean("IsBlocked")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authentications');
    }
};
