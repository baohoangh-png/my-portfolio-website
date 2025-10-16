<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateProductsBrandidSeeder extends Seeder
{
    public function run(): void
    {
        $productIds = DB::table('products')->pluck('id');

        foreach ($productIds as $id) {
            DB::table('products')
                ->where('id', $id)
                ->update([
                    'brandid' => rand(1, 10),
                    'updated_at' => now(),
                ]);
        }
    }
}
