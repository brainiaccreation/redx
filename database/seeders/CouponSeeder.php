<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Coupon::create([
            'code' => 'SAVE20',
            'type' => 'percentage',
            'value' => 20,
            'min_amount' => 100,
            'max_discount' => 50,
            'usage_limit' => 100,
            'used_count' => 25,
            'expiry_date' => '2025-12-31',
            'status' => 'active',
            'description' => 'Get 20% off on orders above $100',
        ]);

        Coupon::create([
            'code' => 'FLAT50',
            'type' => 'fixed',
            'value' => 50,
            'min_amount' => 200,
            'max_discount' => 50,
            'usage_limit' => 50,
            'used_count' => 10,
            'expiry_date' => '2025-08-15',
            'status' => 'active',
            'description' => 'Flat $50 off on orders above $200',
        ]);

        Coupon::create([
            'code' => 'WELCOME10',
            'type' => 'percentage',
            'value' => 10,
            'min_amount' => 50,
            'max_discount' => 25,
            'usage_limit' => 200,
            'used_count' => 150,
            'expiry_date' => '2025-06-01',
            'status' => 'expired',
            'description' => 'Welcome offer - 10% off',
        ]);
    }
}
