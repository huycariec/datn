<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWardIdToShippingFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipping_fees', function (Blueprint $table) {
            $table->unsignedBigInteger('ward_id')->nullable()->after('district_id'); // Thêm cột ward_id sau district_id
            $table->foreign('ward_id')->references('id')->on('wards')->onDelete('cascade'); // Thêm khóa ngoại tới bảng wards
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipping_fees', function (Blueprint $table) {
            $table->dropForeign(['ward_id']); // Xóa khóa ngoại
            $table->dropColumn('ward_id'); // Xóa cột ward_id
        });
    }
}
