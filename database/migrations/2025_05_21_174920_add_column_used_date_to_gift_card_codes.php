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
        Schema::table('gift_card_codes', function (Blueprint $table) {
            $table->timestamp('used_date')->nullable()->after('assigned_order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gift_card_codes', function (Blueprint $table) {
            $table->dropColumn('used_date');
        });
    }
};
