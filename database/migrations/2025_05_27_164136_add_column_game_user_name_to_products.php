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
            $table->boolean('game_user_id')->default(0)->after('status');
            $table->boolean('game_server_id')->default(0)->after('game_user_id');
            $table->boolean('game_user_name')->default(0)->after('game_server_id');
            $table->boolean('game_email')->default(0)->after('game_user_name');
            $table->boolean('no_info_required')->default(0)->after('game_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('game_user_id');
            $table->dropColumn('game_server_id');
            $table->dropColumn('game_user_name');
            $table->dropColumn('game_email');
            $table->dropColumn('no_info_required');
        });
    }
};
