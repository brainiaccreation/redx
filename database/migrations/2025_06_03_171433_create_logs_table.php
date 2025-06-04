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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // e.g. login, update, delete, error
            $table->string('user_type')->nullable(); // e.g. admin, customer, staff
            $table->unsignedBigInteger('user_id')->nullable(); // related user ID
            $table->string('action'); // summary
            $table->text('details')->nullable(); // optional detail
            $table->string('ip')->nullable();
            $table->string('status')->default('success'); // success / failed
            $table->string('severity')->default('info'); // info / warning / error
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
