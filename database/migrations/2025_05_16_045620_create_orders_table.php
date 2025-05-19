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
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('guest_email')->nullable();
            $table->string('guest_phone')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'cancelled'])->default('pending');
            $table->decimal('total_amount', 12, 2);
            $table->string('currency', 3)->default('MYR');
            $table->string('payment_method')->nullable();
            $table->string('payment_id')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->decimal('wallet_amount_used', 12, 2)->default(0.00);
            $table->string('coupon_code', 50)->nullable();
            $table->decimal('discount_amount', 12, 2)->default(0.00);
            $table->text('notes')->nullable();
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
