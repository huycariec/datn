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
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price_old', 10, 2)->nullable()->after('price');
        });
    
        Schema::table('product_variants', function (Blueprint $table) {
            $table->decimal('price_old', 10, 2)->nullable()->after('price');
        });
    }
    
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('price_old');
        });
    
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropColumn('price_old');
        });
    }
    
};
