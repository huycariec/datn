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
        Schema::table('discounts', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive'])->default('active')->after('type');
            $table->dropColumn('use_for');

            $table->dropColumn('min_purchase_amount');
            $table->dropColumn('max_purchase_amount');

            $table->integer('min_order_amount')->after('status');
            $table->integer('max_discount_value')->after('min_order_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('discounts', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('min_order_amount');
            $table->dropColumn('max_discount_value');

            $table->integer('min_purchase_amount');
            $table->integer('max_purchase_amount');
        });
    }
};
