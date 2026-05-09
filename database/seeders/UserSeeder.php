<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


class UserSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        User::firstOrCreate([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'phone' => '089712345678',
            'username' => 'admin',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
            'is_verified' => true,
            'created_at'   => $now,
            'updated_at'   => $now,
        ]);

        User::firstOrCreate([
            'name' => 'Customer',
            'email' => 'customer@gmail.com',
            'phone' => '089612345679',
            'username' => 'customer',
            'role' => 'customer',
            'password' => Hash::make('customer123'),
            'is_verified' => true,
            'created_at'   => $now,
            'updated_at'   => $now,
        ]);
    }
}