<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;

class UpdateCategoryUniqueIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        foreach ($categories as $category) {
            if (empty($category->unique_id)) {
                $category->unique_id = $this->generateUniqueCategoryId();
                $category->save();
            }
        }

        echo "All categories have been updated with a unique_id.\n";
    }

    private function generateUniqueCategoryId($length = 8)
    {
        do {
            $id = Str::random($length);
        } while (Category::where('unique_id', $id)->exists());

        return $id;
    }
}
