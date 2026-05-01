<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Alert;

use App\Models\User;
use App\Models\WebSetting;

class CustomerAuthController extends Controller
{
    /*
    |----------------------------------------
    | LOGIN CUSTOMER
    |----------------------------------------
    */
    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required',
            'password' => 'required',
        ]);

        // Deteksi tipe login: email / phone / username
        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL)
            ? 'email'
            : (is_numeric($request->login) ? 'phone' : 'username');

        $credentials = [
            $loginType => $request->login,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {

            $user = Auth::user();

            // Admin tidak boleh login via customer login
            if ($user->role !== 'customer') {
                Auth::logout();
                return back()->withErrors([
                    'login' => 'Akun ini bukan akun customer.'
                ]);
            }

            if (!$user->is_verified) {
                Auth::logout();
                return back()->withErrors([
                    'login' => 'Akun belum diverifikasi.'
                ]);
            }

            return redirect()->route('home')
                ->with('success', 'Login berhasil. Selamat datang, ' . $user->name . '!');
        }

        return back()->withErrors([
            'login' => 'Email/username atau password salah.'
        ]);
    }

    /*
    |----------------------------------------
    | REGISTER CUSTOMER
    |----------------------------------------
    */
    public function register(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'phone'     => 'required|unique:users,phone',
            'email'     => 'required|email|unique:users,email',
            'username'  => 'nullable|string|unique:users,username',
            'password'  => 'required|min:6|confirmed',
        ]);

        User::create([
            'name'        => $request->name,
            'phone'       => $request->phone,
            'email'       => $request->email,
            'username'    => $request->username,
            'password'    => Hash::make($request->password),
            'role'        => 'customer',
            'is_verified' => true, // langsung aktif tanpa email verification
        ]);

        return redirect()->route('home')
            ->with('success', 'Registrasi berhasil! Silakan login.');
    }

    /*
    |----------------------------------------
    | LOGOUT CUSTOMER
    |----------------------------------------
    */
    public function logout()
    {
        Auth::logout();

        return redirect()->route('home')
            ->with('success', 'Logout berhasil.');
    }
}