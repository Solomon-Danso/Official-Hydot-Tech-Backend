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
        Schema::create('site_portfolios', function (Blueprint $table) {
            $table->id();
            $table->longText("Section")->nullable();
            $table->longText("Background")->nullable();
            $table->longText("Document")->nullable();
            $table->longText("Title")->nullable();
            $table->longText("Link")->nullable();

            $table->integer("Views")->nullable();
            $table->longText("ProductId")->nullable();
            $table->integer("Subscribers")->nullable();
            $table->float("Revenue")->nullable();
            $table->integer("PastUsers")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_portfolios');
    }
};
