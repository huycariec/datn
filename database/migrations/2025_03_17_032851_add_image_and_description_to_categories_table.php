<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('image')->nullable()->after('name'); // Cột ảnh có thể để trống
            $table->text('description')->nullable()->after('image'); // Cột mô tả có thể để trống
        });
    }

    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['image', 'description']);
        });
    }
};

