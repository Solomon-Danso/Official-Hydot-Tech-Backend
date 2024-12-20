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
        Schema::table('company_tokens', function (Blueprint $table) {
            $table -> longText("ProductId")->nullable();
            $table -> longText("ProductName")->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_tokens', function (Blueprint $table) {
            //
        });
    }
};
