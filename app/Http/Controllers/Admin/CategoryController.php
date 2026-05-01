<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

// MODELS
use App\Models\Category;
use App\Models\WebSetting;
use App\Models\Package;
use App\Models\Portofolio;

class CategoryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST CATEGORY
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $data['title']      = 'Kategori';
        $data['menu']       = 'Kategori';
        $data['submenu']    = 'Daftar Kategori';
        $data['subdesc']    = 'Kelola kategori layanan fotografi';
        $data['web']        = WebSetting::latest()->first();
        $data['categories'] = Category::latest()->get();

        return view('admin.category.index', $data);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE CATEGORY
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        Category::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'is_active'   => true,
        ]);

        return back()->with('success', 'Kategori berhasil ditambahkan');
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE CATEGORY
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string',
        ]);

        $category->update([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
            'is_active'   => $request->boolean('is_active', false), // ← fix
        ]);

        return back()->with('success', 'Kategori berhasil diupdate');
    }

    /*
    |--------------------------------------------------------------------------
    | TOGGLE STATUS ACTIVE/NONACTIVE
    |--------------------------------------------------------------------------
    */
    public function toggleStatus($id)
    {
        $category = Category::findOrFail($id);

        $category->update([
            'is_active' => !$category->is_active,
        ]);

        return back()->with('success', 'Status kategori berhasil diperbarui');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE CATEGORY
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        $packageUsed   = Package::where('category_id', $category->id)->exists();
        $portfolioUsed = Portofolio::where('category_id', $category->id)->exists();

        if ($packageUsed || $portfolioUsed) {
            return back()->with('error', 'Kategori masih digunakan package/portfolio, tidak bisa dihapus');
        }

        $category->delete();

        return back()->with('success', 'Kategori berhasil dihapus');
    }
}