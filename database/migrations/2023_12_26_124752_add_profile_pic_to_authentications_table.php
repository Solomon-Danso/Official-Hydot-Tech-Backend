<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfilePicToAuthenticationsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('authentications', function (Blueprint $table) {
            $table->string('profilePic')->nullable()->after('IsBlocked');
            // 'profilePic' column will be added after 'IsBlocked' column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('authentications', function (Blueprint $table) {
            $table->dropColumn('profilePic');
        });
    }
}
