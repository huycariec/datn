<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->bigInteger('user_id')->change();
            $table->string('avatar')->nullable()->change();
            $table->tinyInteger('gender')->nullable()->change();
            $table->date('dob')->nullable()->change();
            $table->string('phone')->nullable()->change();
            $table->string('role')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->bigInteger('user_id')->change();
            $table->string('avatar')->nullable()->change();
            $table->tinyInteger('gender')->nullable(false)->change();
            $table->date('dob')->nullable(false)->change();
            $table->string('phone')->nullable(false)->change();
            $table->string('role')->nullable(false)->change();
        });
    }
};
