<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TelegradSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // =====================
        // KATEGORI
        // =====================
        $wisudaId = DB::table('categories')->insertGetId([
            'name' => 'Wisuda',
            'slug' => 'wisuda',
            'description' => 'Paket fotografi wisuda',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $yudisiumId = DB::table('categories')->insertGetId([
            'name' => 'Yudisium',
            'slug' => 'yudisium',
            'description' => 'Paket fotografi yudisium',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $sidangId = DB::table('categories')->insertGetId([
            'name' => 'After Sidang',
            'slug' => 'after-sidang',
            'description' => 'Paket fotografi setelah sidang',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

       

        // foreach ($wisudaPackages as $pkg) {
        //     DB::table('packages')->insert(array_merge($pkg, [
        //         'category_id' => $wisudaId,
        //         'created_at'  => $now,
        //         'updated_at' => $now,
        //     ]));
        // }

        

        // foreach ($yudisiumPackages as $pkg) {
        //     DB::table('packages')->insert(array_merge($pkg, [
        //         'category_id' => $yudisiumId,
        //         'created_at'  => $now,
        //         'updated_at' => $now,
        //     ]));
        // }

       

        // foreach ($sidangPackages as $pkg) {
        //     DB::table('packages')->insert(array_merge($pkg, [
        //         'category_id' => $sidangId,
        //         'created_at'  => $now,
        //         'updated_at' => $now,
        //     ]));
        // }

        // INSERT PACKAGE
        $this->insertPackages($wisudaId, $wisudaPackages, $now);
        $this->insertPackages($yudisiumId, $yudisiumPackages, $now);
        $this->insertPackages($sidangId, $sidangPackages, $now);
    }

    /**
     * Helper insert packages
     */
    private function insertPackages($categoryId, $packages, $now)
    {
        foreach ($packages as $pkg) {
            DB::table('packages')->insert(array_merge($pkg, [
                'category_id' => $categoryId,
                'created_at' => $now,
                'updated_at' => $now
            ]));
        }
    }

}
