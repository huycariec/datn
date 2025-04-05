<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Thêm cột mô tả ngắn
            $table->text('short_description')->nullable()->after('description');
            
            // Sửa cột description thành TEXT nếu cần
            $table->text('description')->change();
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Xóa cột short_description khi rollback
            $table->dropColumn('short_description');
            
            // Chuyển description về VARCHAR(255) nếu cần
            $table->string('description', 255)->change();
        });
    }
};

