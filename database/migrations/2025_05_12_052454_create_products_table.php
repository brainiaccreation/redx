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
         Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('short_description', 500)->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('featured_image')->nullable();
            $table->json('gallery_images')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_digital')->default(true);
            $table->boolean('requires_shipping')->default(false);
            $table->enum('status', ['active', 'inactive', 'draft'])->default('active');
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->index('slug');
            $table->index('category_id');
            $table->index('status');
            $table->index('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
