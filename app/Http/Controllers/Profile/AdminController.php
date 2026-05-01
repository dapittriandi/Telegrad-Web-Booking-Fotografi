<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Alert;

use App\Models\User;
use App\Models\WebSetting;

class AdminController extends Controller
{
    /*
    |----------------------------------------
    | LOGIN FORM
    |----------------------------------------
    */
    public function LoginForm()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $data['title']   = 'Telegrad';
        $data['menu']    = 'Admin';
        $data['submenu'] = 'Login Admin';
        $data['subdesc'] = 'Masukkan kredensial admin kamu';
        $data['web']     = WebSetting::first();

        return view('base.auth.auth-signin', $data);
    }

    /*
    |----------------------------------------
    | LOGIN PROCESS
    |----------------------------------------
    */
    public function LoginPost(Request $request)
    {
        $request->validate([
            'login'    => 'required',
            'password' => 'required',
        ]);

        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL)
            ? 'email'
            : (is_numeric($request->login) ? 'phone' : 'username');

        $credentials = [
            $loginType => $request->login,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            if ($user->role !== 'admin') {
                Auth::logout();
                Alert::error('Akses Ditolak', 'Halaman ini hanya untuk admin.');
                return back();
            }

            if (!$user->is_verified) {
                Auth::logout();
                Alert::error('Belum Terverifikasi', 'Akun belum diverifikasi.');
                return back();
            }

            Alert::success('Berhasil', 'Selamat datang, ' . $user->name . '!');
            return redirect()->route('admin.dashboard');
        }

        Alert::error('Gagal', 'Email/username atau password salah.');
        return back();
    }

    /*
    |----------------------------------------
    | LOGOUT
    |----------------------------------------
    */
    public function logout()
    {
        Auth::logout();
        Alert::success('Berhasil', 'Logout berhasil.');
        return redirect()->route('admin.login');
    }

    /*
    |----------------------------------------
    | PROFILE PAGE
    |----------------------------------------
    */
    public function profile()
    {
        $data['title']   = 'Telegrad';
        $data['menu']    = 'Admin';
        $data['submenu'] = 'Edit Profile';
        $data['web']     = WebSetting::first();

        return view('admin.profile', $data);
    }

    /*
    |----------------------------------------
    | PROFILE UPDATE
    |----------------------------------------
    */
    public function profileUpdate(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|unique:users,username,' . $user->id,
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'phone'    => 'required|unique:users,phone,' . $user->id,
            'photo'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $updateData = $request->only('name', 'username', 'email', 'phone');

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika bukan default
            if ($user->photo && $user->photo !== 'default.jpg') {
                Storage::disk('public')->delete('images/profile/' . $user->photo);
            }

            $file     = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('images/profile', $filename, 'public');
            // File tersimpan di: storage/app/public/images/profile/{filename}
            // Akses via:         asset('storage/images/profile/{filename}')

            $updateData['photo'] = $filename;
        }

        $user->update($updateData);

        Alert::success('Berhasil', 'Profile berhasil diperbarui.');
        return back();
    }
}