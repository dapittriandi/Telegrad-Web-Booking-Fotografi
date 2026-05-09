<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('categories')->insertOrIgnore([
            [
                'name' => 'Wisuda',
                'slug' => 'wisuda',
                'description' => 'Paket fotografi wisuda',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Yudisium',
                'slug' => 'yudisium',
                'description' => 'Paket fotografi yudisium',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'After Sidang',
                'slug' => 'after-sidang',
                'description' => 'Paket fotografi after sidang',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}