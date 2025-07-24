<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users2', function (Blueprint $table) {
            $table->string('role')->default('user')->after('email');
        });
    }

    public function down()
    {
        Schema::table('users2', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
