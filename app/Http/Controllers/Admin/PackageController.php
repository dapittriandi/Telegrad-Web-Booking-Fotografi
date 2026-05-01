<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\Category;
use App\Models\WebSetting;

class PackageController extends Controller
{
    public function index()
    {
        $data['title']    = 'Telegrad - Paket';
        $data['menu']     = 'Paket';
        $data['submenu']  = 'Daftar Paket';
        $data['web']      = WebSetting::first();
        $data['packages'] = Package::with('category')->latest()->get();

        return view('admin.package.index', $data);
    }

    public function create()
    {
        $data['title']      = 'Telegrad - Tambah Paket';
        $data['menu']       = 'Paket';
        $data['submenu']    = 'Tambah Paket';
        $data['web']        = WebSetting::first();
        $data['categories'] = Category::where('is_active', true)->get();

        return view('admin.package.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id'            => 'required|exists:categories,id',
            'name'                   => 'required|string|max:255',
            'price'                  => 'required|numeric|min:0',
            'duration'               => 'required|integer|min:1',
            'participants'           => 'required|string|max:255',
            'min_participants'       => 'nullable|integer|min:1',
            'max_participants'       => 'nullable|integer|min:1',
            'unlimited_participants' => 'nullable|boolean',
            'features'               => 'nullable|string',
            'is_active'              => 'nullable|boolean',
        ]);

        Package::create([
            'category_id'            => $request->category_id,
            'name'                   => $request->name,
            'price'                  => $request->price,
            'duration'               => $request->duration,
            'participants'           => $request->participants,
            'min_participants'       => $request->min_participants,
            'max_participants'       => $request->max_participants,
            'unlimited_participants' => $request->boolean('unlimited_participants', false), // ← fix
            'features'               => $request->features,
            'is_active'              => $request->boolean('is_active', false), // ← fix
        ]);

        return redirect()->route('packages.index')
            ->with('success', 'Paket berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['title']      = 'Telegrad - Edit Paket';
        $data['menu']       = 'Paket';
        $data['submenu']    = 'Edit Paket';
        $data['web']        = WebSetting::first();
        $data['package']    = Package::findOrFail($id);
        $data['categories'] = Category::where('is_active', true)->get();

        return view('admin.package.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $package = Package::findOrFail($id);

        $request->validate([
            'category_id'            => 'required|exists:categories,id',
            'name'                   => 'required|string|max:255',
            'price'                  => 'required|numeric|min:0',
            'duration'               => 'required|integer|min:1',
            'participants'           => 'required|string|max:255',
            'min_participants'       => 'nullable|integer|min:1',
            'max_participants'       => 'nullable|integer|min:1',
            'unlimited_participants' => 'nullable|boolean',
            'features'               => 'nullable|string',
            'is_active'              => 'nullable|boolean',
        ]);

        $package->update([
            'category_id'            => $request->category_id,
            'name'                   => $request->name,
            'price'                  => $request->price,
            'duration'               => $request->duration,
            'participants'           => $request->participants,
            'min_participants'       => $request->min_participants,
            'max_participants'       => $request->max_participants,
            'unlimited_participants' => $request->boolean('unlimited_participants', false), // ← fix
            'features'               => $request->features,
            'is_active'              => $request->boolean('is_active', false), // ← fix
        ]);

        return back()->with('success', 'Paket berhasil diperbarui');
    }

    public function destroy($id)
    {
        Package::findOrFail($id)->delete();
        return back()->with('success', 'Paket berhasil dihapus');
    }
}