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
        Schema::create('payment_histories', function (Blueprint $table) {
            $table->id();
            $table->longText("CompanyId")->nullable();
            $table->longText("CompanyName")->nullable();
            $table->longText("CompanyEmail")->nullable();
            $table->longText("CompanyPhone")->nullable();
            $table->longText("PaymentId")->nullable();
            $table->longText("PaymentMethod")->nullable();
            $table->float("Amount")->nullable();
            $table->integer("SubscriptionPeriodInDays")->nullable();
            $table -> longText("ProductId")->nullable();
            $table -> longText("ProductName")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_histories');
    }
};
