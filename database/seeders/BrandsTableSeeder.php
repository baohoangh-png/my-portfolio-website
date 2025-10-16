<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('brands')->insert([
                'id' => $i,
                'brandname' => "Thương hiệu $i",
                'description' => "Mô tả $i"
            ]);
        }
    }
}
