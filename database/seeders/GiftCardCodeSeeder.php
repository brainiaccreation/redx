<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\GiftCardCode;

class GiftCardCodeSeeder extends Seeder
{
    public function run()
    {
        $giftCardProducts = Product::where('type', 'gift_card')->get();

        foreach ($giftCardProducts as $product) {
            $variants = ProductVariant::where('product_id', $product->id)->get();

            foreach ($variants as $variant) {
                for ($i = 0; $i < 10; $i++) {
                    GiftCardCode::create([
                        'product_id' => $product->id,
                        'variant_id' => $variant->id,
                        'code' => strtoupper(Str::random(4)) . '-' .
                            strtoupper(Str::random(4)) . '-' .
                            strtoupper(Str::random(4)) . '-' .
                            strtoupper(Str::random(4)),
                        'status' => 'unused',
                    ]);
                }
            }
        }

        $this->command->info('Gift card codes seeded successfully.');
    }
}
