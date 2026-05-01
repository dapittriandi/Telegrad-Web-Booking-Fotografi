<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Portofolio;
use App\Models\Category;

class PortofolioSeeder extends Seeder
{
    public function run(): void
    {
        $wisuda = Category::where('slug', 'wisuda')->first();
        $yudisium = Category::where('slug', 'yudisium')->first();
        $sidang = Category::where('slug', 'after-sidang')->first();

        Portofolio::create([
            'category_id' => $wisuda->id,
            'title' => 'Wisuda UIN 2026',
            'image' => 'portfolio1.jpg',
            'description' => 'Dokumentasi wisuda terbaik'
        ]);

        Portofolio::create([
            'category_id' => $yudisium->id,
            'title' => 'Yudisium Session',
            'image' => 'portfolio2.jpg',
            'description' => 'Dokumentasi yudisium mahasiswa'
        ]);

        Portofolio::create([
            'category_id' => $sidang->id,
            'title' => 'After Sidang Session',
            'image' => 'portfolio3.jpg',
            'description' => 'Dokumentasi after sidang'
        ]);
    }
}