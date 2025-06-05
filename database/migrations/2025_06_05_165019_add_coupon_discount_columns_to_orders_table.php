<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('coupon_id')->nullable()->after('payment_method');
            $table->decimal('discount_applied', 10, 2)->default(0)->after('total_amount');
            $table->decimal('grand_total', 10, 2)->default(0)->after('discount_applied');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['coupon_id', 'discount_applied', 'grand_total']);
        });
    }
};
