<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Normal User',
            'email' => 'user@example.com',
            'password' => Hash::make('user123'),
            'role_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
