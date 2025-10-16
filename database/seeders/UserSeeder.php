<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo admin
        DB::table('users')->insert([
            'fullname' => 'Admin System',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'email' => 'admin@gmail.com',
            'role' => 0, // admin
        ]);

        // Tạo 9 khách hàng
        for ($i = 1; $i <= 9; $i++) {
            DB::table('users')->insert([
                'fullname' => 'Nguyen Van A' . $i,
                'username' => 'user' . $i,
                'password' => Hash::make('123456'),
                'email' => 'user' . $i . '@gmail.com',
                'role' => 1, // khách hàng
            ]);
        }
    }
}
