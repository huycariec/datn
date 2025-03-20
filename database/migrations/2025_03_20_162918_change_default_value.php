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
        Schema::table('profiles', function (Blueprint $table) {
            Schema::table('profiles', function (Blueprint $table) {
                $table->bigInteger('user_id')->nullable()->change();
                $table->boolean('gender')->nullable()->change();
                $table->date('dob')->nullable()->change();
                $table->string('phone')->nullable()->change();
                $table->string('role')->nullable()->change();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            Schema::table('profiles', function (Blueprint $table) {
                $table->bigInteger('user_id')->nullable(false)->change();
                $table->boolean('gender')->nullable(false)->change();
                $table->date('dob')->nullable(false)->change();
                $table->string('phone')->nullable(false)->change();
                $table->string('role')->nullable(false)->change();
            });
        });
    }
};
