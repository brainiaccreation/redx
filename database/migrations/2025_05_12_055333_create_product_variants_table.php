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
        Schema::create('product_variants', function (Blueprint $table) {
             $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('name');
            $table->string('sku', 100)->unique();
            $table->decimal('price', 12, 2);
            $table->string('region', 100)->nullable();
            $table->string('denomination', 100)->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->boolean('is_default')->default(false);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->index('product_id');
            $table->index('sku');
            $table->index('region');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
