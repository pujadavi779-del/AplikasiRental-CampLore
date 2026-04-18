<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $categories = ['Kamera', 'Camping'];

        for ($i = 1; $i <= 30; $i++) {
            Product::create([
                'name' => 'Product ' . $i,
                'category' => $categories[array_rand($categories)],
                'price_per_day' => rand(50000, 200000),
                'image' => 'https://picsum.photos/200?random=' . $i
            ]);
        }
    }
}
