<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role_id', 100)->nullable()->change();
        });
        // Update specific users
        DB::table('users')->where('email', 'admin@gmail.com')->update(['role_id' => 'admin']);
        DB::table('users')->where('email', 'staff@example.com')->update(['role_id' => 'staff']);

        // Update rest of the users
        DB::table('users')
            ->whereNotIn('email', ['admin@gmail.com', 'staff@example.com'])
            ->update(['role_id' => 'customer']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
