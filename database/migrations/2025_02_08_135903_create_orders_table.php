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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('shipper_id');  //chua co de tam
            $table->decimal('total_amount');
            $table->string('status');
            $table->string('shipping_status');
            $table->string('payment_method');
            $table->decimal('shipping_fee');
            $table->foreignId('province_id')->constrained();
            $table->foreignId('district')->constrained();
            $table->foreignId('ward')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
