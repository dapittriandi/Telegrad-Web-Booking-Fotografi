<?php

namespace App\Http\Controllers\Root;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Alert;

use App\Models\WebSetting;
use App\Models\Category;
use App\Models\Package;
use App\Models\Portofolio;
use App\Models\Rating;

class RootController extends Controller
{
    /*
    |----------------------------------------
    | HOMEPAGE
    | view: resources/views/root/index.blade.php
    |----------------------------------------
    */
    public function index()
    {
        $data['title']       = 'Telegrad';
        $data['web']         = WebSetting::first();
        $data['categories']  = Category::where('is_active', true)->get();
        $data['ratings']     = Rating::with('user', 'order.package')
                                    ->latest()->take(6)->get();
        // FIX: Ambil 5 paket per kategori agar semua filter di homepage bisa kerja.
        // Sebelumnya take(6) global menyebabkan 1 kategori mendominasi,
        // sehingga kategori lain tidak tampil saat di-filter.
        $data['packages']    = Package::with('category')
                                    ->where('is_active', true)
                                    ->get()
                                    ->groupBy('category_id')
                                    ->map(fn($group) => $group->take(5))
                                    ->flatten()
                                    ->values();
        $data['portofolios'] = Portofolio::with('category')
                                    ->where('is_active', true)
                                    ->latest()->take(6)->get();

        return view('root.index', $data);
    }

    /*
    |----------------------------------------
    | CONTACT PAGE
    | view: resources/views/root/contact.blade.php
    |----------------------------------------
    */
    public function contact()
    {
        $data['title'] = 'Telegrad';
        $data['web']   = WebSetting::first();

        return view('root.contact', $data);
    }

    public function contactStore(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Alert::success('Berhasil', 'Pesan kamu berhasil dikirim!');
        return back();
    }

    /*
    |----------------------------------------
    | PACKAGE - SEMUA KATEGORI
    | view: resources/views/root/package-categories.blade.php
    |----------------------------------------
    */
    public function packageCategories()
    {
        $data['title']      = 'Telegrad';
        $data['web']        = WebSetting::first();
        $data['categories'] = Category::where('is_active', true)
                                ->withCount(['packages' => fn($q) => $q->where('is_active', true)])
                                ->get();

        return view('root.package-categories', $data);
    }

    /*
    |----------------------------------------
    | PACKAGE - BY KATEGORI
    | view: resources/views/root/package-category.blade.php
    |----------------------------------------
    */
    public function packageByCategory($slug)
{
    $data['title']      = 'Telegrad';
    $data['web']        = WebSetting::first();

    // ✅ Fix: tambah withCount agar packages_count tersedia di sidebar/filter
    $data['categories'] = Category::where('is_active', true)
                            ->withCount(['packages' => fn($q) => $q->where('is_active', true)])
                            ->get();

    $data['category']   = Category::where('slug', $slug)
                            ->where('is_active', true)
                            ->firstOrFail();

    $data['packages']   = Package::where('category_id', $data['category']->id)
                            ->where('is_active', true)
                            ->latest()
                            ->get();

    return view('root.package-category', $data);
}

    /*
    |----------------------------------------
    | PACKAGE DETAIL
    | view: resources/views/root/package-detail.blade.php
    |----------------------------------------
    */
    public function packageDetail($id)
    {
        $data['title']   = 'Telegrad';
        $data['web']     = WebSetting::first();
        $data['package'] = Package::with('category')
                            ->where('is_active', true)
                            ->findOrFail($id);
        $data['related'] = Package::where('category_id', $data['package']->category_id)
                            ->where('id', '!=', $id)
                            ->where('is_active', true)
                            ->take(4)->get();

        return view('root.package-detail', $data);
    }

    /*
    |----------------------------------------
    | PORTFOLIO
    | view: resources/views/root/portfolio.blade.php
    |----------------------------------------
    */
    public function portfolio()
    {
        $data['title']       = 'Telegrad';
        $data['web']         = WebSetting::first();
        $data['categories']  = Category::where('is_active', true)->get();
        $data['portofolios'] = Portofolio::with('category')
                                ->where('is_active', true)
                                ->latest()->get();

        return view('root.portfolio', $data);
    }

    /*
    |----------------------------------------
    | PORTFOLIO DETAIL
    | view: resources/views/root/portfolio-detail.blade.php
    |----------------------------------------
    */
    public function portfolioDetail($id)
    {
        $data['title']      = 'Telegrad';
        $data['web']        = WebSetting::first();
        $data['portofolio'] = Portofolio::with('category')
                                ->where('is_active', true)
                                ->findOrFail($id);
        $data['related']    = Portofolio::where('category_id', $data['portofolio']->category_id)
                                ->where('id', '!=', $id)
                                ->where('is_active', true)
                                ->take(4)->get();

        return view('root.portfolio-detail', $data);
    }
}