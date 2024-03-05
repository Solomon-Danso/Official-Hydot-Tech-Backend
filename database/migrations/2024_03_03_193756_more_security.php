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
        Schema::table('authentications', function (Blueprint $table) {
            $table->longText("EncryptionKey")->nullable();
            $table->longText("ServerId")->nullable();
            $table->boolean("isLoggedIn")->default(false);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('authentications', function (Blueprint $table) {
            //
        });
    }
};
