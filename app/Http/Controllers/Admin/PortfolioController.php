<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Portofolio;
use App\Models\Category;
use App\Models\WebSetting;

class PortfolioController extends Controller
{
    public function index()
    {
        $data['title']       = 'Telegrad - Portofolio';
        $data['menu']        = 'Portofolio';
        $data['submenu']     = 'Daftar Portofolio';
        $data['web']         = WebSetting::first();
        $data['portofolios'] = Portofolio::with('category')->latest()->get();

        return view('admin.portfolio.index', $data);
    }

    public function create()
    {
        $data['title']      = 'Telegrad - Tambah Portofolio';
        $data['menu']       = 'Portofolio';
        $data['submenu']    = 'Tambah Portofolio';
        $data['web']        = WebSetting::first();
        $data['categories'] = Category::where('is_active', true)->get();

        return view('admin.portfolio.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'required|image|mimes:jpg,jpeg,png,webp|max:3048',
        ]);

        $filename = null;

        if ($request->hasFile('image')) {
            $image    = $request->file('image');
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $path     = storage_path('app/public/images/portofolio');

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $image->move($path, $filename);
        }

        Portofolio::create([
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'description' => $request->description,
            'image'       => $filename,
            'is_active'   => true,
        ]);

        return redirect()->route('portfolios.index')
            ->with('success', 'Portofolio berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['title']      = 'Telegrad - Edit Portofolio';
        $data['menu']       = 'Portofolio';
        $data['submenu']    = 'Edit Portofolio';
        $data['web']        = WebSetting::first();
        $data['portofolio'] = Portofolio::findOrFail($id);
        $data['categories'] = Category::where('is_active', true)->get();

        return view('admin.portfolio.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $portfolio = Portofolio::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3048',
            'is_active'   => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama
            $oldPath = storage_path('app/public/images/portofolio/' . $portfolio->image);
            if (file_exists($oldPath)) {
                File::delete($oldPath);
            }

            $image    = $request->file('image');
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(storage_path('app/public/images/portofolio'), $filename);

            $portfolio->image = $filename;
        }

        $portfolio->update([
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'description' => $request->description,
            'is_active'   => $request->boolean('is_active', true),
        ]);

        if ($request->hasFile('image')) {
            $portfolio->save();
        }

        return back()->with('success', 'Portofolio berhasil diperbarui');
    }

    public function destroy($id)
    {
        $portfolio = Portofolio::findOrFail($id);

        $path = storage_path('app/public/images/portofolio/' . $portfolio->image);
        if (file_exists($path)) {
            File::delete($path);
        }

        $portfolio->delete();

        return back()->with('success', 'Portofolio berhasil dihapus');
    }
}