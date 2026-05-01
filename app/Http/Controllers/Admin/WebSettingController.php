<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WebSetting;

class WebSettingController extends Controller
{
    public function index()
    {
        $data['title']   = 'Pengaturan Website';
        $data['menu']    = 'Pengaturan';
        $data['submenu'] = 'Web Setting';
        $data['subdesc'] = 'Kelola identitas dan tampilan website';
        $data['web']     = WebSetting::first() ?? new WebSetting();

        return view('admin.websetting.index', $data);
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
        ]);

        $web = WebSetting::first() ?? new WebSetting();

        // Info dasar
        $web->site_name        = $request->site_name;
        $web->site_link        = $request->site_link;
        $web->site_head        = $request->site_head;
        // FIX: kolom DB adalah site_description
        $web->site_description = $request->site_description;
        $web->site_street      = $request->site_street;
        $web->site_poscod      = $request->site_poscod;
        $web->site_email       = $request->site_email;
        $web->site_phone       = $request->site_phone;
        $web->site_locate      = $request->site_locate;

        // FIX: kolom DB adalah facebook, instagram, tiktok
        $web->facebook         = $request->facebook;
        $web->instagram        = $request->instagram;
        $web->tiktok           = $request->tiktok;
        // Rekening Bank
        $web->bank_name           = $request->bank_name;
        $web->bank_account_number = $request->bank_account_number;
        $web->bank_account_name   = $request->bank_account_name;

        // Logo
        if ($request->hasFile('site_logo')) {
            $file     = $request->file('site_logo');
            $filename = 'site_logo_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/images/default'), $filename);
            $web->site_logo = $filename;
        }

        // QRIS
        if ($request->hasFile('site_qris')) {
            $file     = $request->file('site_qris');
            $filename = 'site_qris_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('storage/images/default'), $filename);
            $web->site_qris = $filename;
        }

        // Sliders
        for ($i = 1; $i <= 5; $i++) {
            $field = "slider_$i";
            if ($request->hasFile($field)) {
                $file     = $request->file($field);
                $filename = "slider_{$i}_" . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('storage/images/default'), $filename);
                $web->$field = $filename;
            }
        }

        $web->save();

        return back()->with('success', 'Pengaturan website berhasil diperbarui');
    }
}