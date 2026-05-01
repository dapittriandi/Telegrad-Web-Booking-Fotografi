<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use App\Models\WebSetting;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class WebSettingSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

       // =====================================================================
        // WEB SETTING
        // =====================================================================
        DB::table('web_settings')->insertOrIgnore([
            'slider_1'         => 'slider_1.jpg',
            'slider_2'         => 'slider_2.jpg',
            'slider_3'         => 'slider_3.jpg',
            'slider_4'         => 'slider_4.jpg',
            'slider_5'         => 'slider_5.jpg',
            'site_qris'        => 'site_qris.png',
            'site_logo'        => 'site_logo.png',
            'site_head'        => 'Abadikan Momen Wisudamu',
            'site_description' => 'Jasa foto & video wisuda profesional di Jambi',
            'site_name'        => 'Telegrad',
            'site_link'        => 'https://telegrad.id',
            'site_street'      => 'Jl. Contoh No. 1, Jambi',
            'site_poscod'      => '36111',
            'site_locate'      => '<iframe src="https://maps.google.com/maps?q=jambi&output=embed" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
            'site_email'       => 'telegrad@email.com',
            'site_phone'       => '08123456789',
            'instagram'        => 'https://instagram.com/telegrad__',
            'facebook'         => null,
            'tiktok'           => 'https://tiktok.com/@telegrad__',
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);
    }
}