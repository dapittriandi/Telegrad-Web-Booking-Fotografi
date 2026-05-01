<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // =========================
        // AMBIL CATEGORY (WAJIB ADA)
        // =========================
        $wisudaId = DB::table('categories')->where('slug', 'wisuda')->value('id');
        $yudisiumId = DB::table('categories')->where('slug', 'yudisium')->value('id');
        $sidangId = DB::table('categories')->where('slug', 'after-sidang')->value('id');

        // ❗ CEK AMAN (INI PENTING)
        if (!$wisudaId || !$yudisiumId || !$sidangId) {
            throw new \Exception("Category belum ada. Jalankan CategorySeeder dulu.");
        }

        // =========================
        // LOAD DATA FILE
        // =========================
        $wisudaPackages = include database_path('seeders/data/wisuda.php');
        $yudisiumPackages = include database_path('seeders/data/yudisium.php');
        $sidangPackages = include database_path('seeders/data/sidang.php');

        // =========================
        // INSERT
        // =========================
        $this->insertPackages($wisudaId, $wisudaPackages, $now);
        $this->insertPackages($yudisiumId, $yudisiumPackages, $now);
        $this->insertPackages($sidangId, $sidangPackages, $now);
    }

    private function insertPackages($categoryId, $packages, $now)
    {
        foreach ($packages as $pkg) {
            DB::table('packages')->insert([
                'category_id' => $categoryId,
                'name' => $pkg['name'],
                'price' => $pkg['price'],
                'duration' => $pkg['duration'], // HARUS INTEGER
                'participants' => $pkg['participants'],
                'features' => $pkg['features'],

                'min_participants' => null,
                'max_participants' => null,
                'unlimited_participants' => false,
                'is_active' => true,

                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}