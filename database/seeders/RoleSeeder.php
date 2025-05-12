<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create roles
        DB::table('roles')->insert([
            [
                'id' => 1,
                'name' => 'admin',
                'description' => 'Administrator with full access',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'user',
                'description' => 'Regular user with limited access',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Create an admin user
        DB::table('users')->insert([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}