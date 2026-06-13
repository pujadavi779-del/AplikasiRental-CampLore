<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $Kategori_data = ['Kamera', 'Camping'];

        for ($i = 1; $i <= 30; $i++) {
            Product::create([
                'name' => 'Product ' . $i,
                'Kategori_data' => $Kategori_data[array_rand($Kategori_data)],
                'harga_per_hari' => rand(50000, 200000),
                'image' => 'https://picsum.photos/200?random=' . $i
            ]);
        }
    }
}
