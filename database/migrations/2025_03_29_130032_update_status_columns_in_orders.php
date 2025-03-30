<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Đổi cột status thành ENUM với các giá trị: paid, unpaid, pending
            DB::statement("ALTER TABLE orders CHANGE COLUMN status status ENUM('paid', 'unpaid', 'pending') NOT NULL DEFAULT 'pending'");

            // Đổi cột shipping_status thành ENUM với các giá trị: pending_confirmation, confirmed, shipping, cancelled, refunded
            DB::statement("ALTER TABLE orders CHANGE COLUMN shipping_status shipping_status ENUM('pending', 'confirmed', 'shipping', 'cancelled', 'return') NOT NULL DEFAULT 'pending'");
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Nếu rollback, chuyển cột về kiểu VARCHAR(255)
            DB::statement("ALTER TABLE orders CHANGE COLUMN status status VARCHAR(255) NOT NULL");
            DB::statement("ALTER TABLE orders CHANGE COLUMN shipping_status shipping_status VARCHAR(255) NOT NULL");
        });
    }
};

