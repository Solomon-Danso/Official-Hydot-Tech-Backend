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
            $table->string("CompanyId")->nullable();
            $table->string("CompanyName")->nullable();
            $table->string("CompanyEmail")->nullable();
            $table->string("CompanyPhone")->nullable();
            $table->string("PaymentId")->nullable();
            $table->string("PaymentMethod")->nullable();
            $table->float("Amount")->nullable();
            $table->integer("SubscriptionPeriodInDays")->nullable();
            $table -> string("ProductId")->nullable();
            $table -> string("ProductName")->nullable();

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
