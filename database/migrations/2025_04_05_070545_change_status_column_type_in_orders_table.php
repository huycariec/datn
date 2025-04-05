<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeStatusColumnTypeInOrdersTable extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status')->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Ví dụ khôi phục lại enum cũ nếu cần
            // $table->enum('status', ['pending', 'confirmed', 'shipping', 'completed', 'cancelled'])->change();
        });
    }
}
