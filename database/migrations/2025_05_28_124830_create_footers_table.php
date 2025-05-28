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
        Schema::create('footers', function (Blueprint $table) {
            $table->id();
            $table->string('section')->nullable(); // e.g., "Our Studio", "Services"
            $table->string('link_text')->nullable(); // e.g., "About Us", "Game Design"
            $table->string('link_url')->nullable(); // e.g., "/about-us", "/game-design"
            $table->integer('order')->default(0); // For sorting links within sections
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('footers');
    }
};
