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
            $table->string("FullName")->nullable();
            $table->string("Contact")->nullable();
            $table->string("Email")->nullable();
            $table->string("Role")->nullable();
            $table->string("Password")->nullable();
            $table->string("Token")->nullable();
            $table->string("UserId")->nullable();
            $table->string("SToken")->nullable();
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
