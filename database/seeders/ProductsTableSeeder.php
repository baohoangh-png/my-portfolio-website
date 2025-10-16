<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('products')->insert([
                'id' => $i,
                'proname' => "Sản phẩm $i",
                'price'=>rand(500000,1000000),
                'description' => "Mô tả $i",
                'cateid'=>rand(1,10),
                'brandid'=>rand(1,10)

            ]);
        }
    }
}
