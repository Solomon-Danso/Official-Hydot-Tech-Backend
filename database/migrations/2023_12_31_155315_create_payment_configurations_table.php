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
        Schema::create('payment_configurations', function (Blueprint $table) {
            $table->id();
            $table -> longText("ProductId")->nullable();
            $table -> longText("ProductName")->nullable();
            $table-> float("MarginalPrice")->nullable();
            $table -> integer("ActiveUsers")->nullable();
            $table -> integer("InActiveUsers")->nullable();
            $table -> integer("DormantUsers")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_configurations');
    }
};
