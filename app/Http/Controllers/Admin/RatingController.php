<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\WebSetting;

class RatingController extends Controller
{
    public function index()
    {
        $data['title']   = 'Rating Customer';
        $data['menu']    = 'Review';
        $data['submenu'] = 'Daftar Rating';
        $data['subdesc'] = 'Kelola review dan rating dari customer';
        $data['web']     = WebSetting::latest()->first();

        $data['ratings'] = Rating::with(['user', 'order.package'])
                                 ->latest()->get();

        // FIX: view path yang benar
        return view('admin.rating.index', $data);
    }

    public function show($id)
    {
        $data['title']   = 'Detail Rating';
        $data['menu']    = 'Review';
        $data['submenu'] = 'Detail Rating';
        $data['subdesc'] = 'Detail ulasan customer';
        $data['web']     = WebSetting::latest()->first();

        $data['rating'] = Rating::with(['user', 'order.package'])
                                ->findOrFail($id);

        return view('admin.rating.show', $data);
    }

    public function destroy($id)
    {
        Rating::findOrFail($id)->delete();

        return back()->with('success', 'Rating berhasil dihapus');
    }
}