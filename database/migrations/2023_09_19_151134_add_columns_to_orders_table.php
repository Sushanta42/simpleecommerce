<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('coupon_discount', 10, 2)->default(0);
            $table->decimal('subtotal', 10, 2)->default(0.00);
            $table->decimal('discount_amount', 10, 2)->default(0.00);
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('coupon_discount');
            $table->dropColumn('subtotal');
            $table->dropColumn('discount_amount');
        });
    }
};
