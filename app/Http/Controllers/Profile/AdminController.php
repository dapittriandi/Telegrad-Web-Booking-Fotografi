<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
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

        if (Auth::attempt($credentials, $request->boolean('remember'))) {

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

            $request->session()->regenerate();

            Alert::success('Berhasil', 'Selamat datang, ' . $user->name . '!');
            return redirect()->route('admin.dashboard');
        }

        Alert::error('Gagal', 'Email/username atau password salah.');
        return back()->withInput($request->only('login'));
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
    | FORGOT PASSWORD — Kirim link reset
    |----------------------------------------
    | Route: POST /admin/forgot-password
    | Name:  admin.forgot-password.send
    */
    public function forgotPasswordSend(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Pastikan email adalah milik admin
        $user = User::where('email', $request->email)
                    ->where('role', 'admin')
                    ->first();

        if (!$user) {
            // Pesan generik agar tidak bocorkan info user
            return back()
                ->with('fp_error', 'Email tidak terdaftar sebagai akun admin.')
                ->withInput();
        }

        // Kirim link reset via Laravel Password Broker
        $status = Password::sendResetLink(
            ['email' => $request->email]
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('fp_success',
                'Link reset password telah dikirim ke ' . $request->email . '. Silakan cek inbox kamu.'
            );
        }

        return back()
            ->with('fp_error', 'Gagal mengirim email. Coba beberapa saat lagi.')
            ->withInput();
    }

    /*
    |----------------------------------------
    | RESET PASSWORD — Tampilkan form baru
    |----------------------------------------
    | Route: GET /admin/reset-password/{token}
    | Name:  admin.reset-password.form
    */
    public function resetPasswordForm(Request $request, string $token)
    {
        $data['title']   = 'Telegrad';
        $data['menu']    = 'Admin';
        $data['submenu'] = 'Reset Password';
        $data['subdesc'] = 'Buat password baru untuk akun kamu';
        $data['web']     = WebSetting::first();
        $data['token']   = $token;
        $data['email']   = $request->query('email', '');

        return view('base.auth.auth-reset-password', $data);
    }

    /*
    |----------------------------------------
    | RESET PASSWORD — Proses simpan password baru
    |----------------------------------------
    | Route: POST /admin/reset-password
    | Name:  admin.reset-password.update
    */
    public function resetPasswordUpdate(Request $request)
    {
        $request->validate([
            'token'                 => ['required'],
            'email'                 => ['required', 'email'],
            'password'              => ['required', 'confirmed', 'min:8'],
            'password_confirmation' => ['required'],
        ], [
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password'       => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()
                ->route('admin.login')
                ->with('success', 'Password berhasil direset! Silakan login dengan password baru kamu.');
        }

        return back()
            ->withErrors(['email' => __($status)])
            ->withInput($request->only('email'));
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

        if ($request->hasFile('photo')) {
            if ($user->photo && $user->photo !== 'default.jpg') {
                Storage::disk('public')->delete('images/profile/' . $user->photo);
            }

            $file     = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('images/profile', $filename, 'public');

            $updateData['photo'] = $filename;
        }

        $user->update($updateData);

        Alert::success('Berhasil', 'Profile berhasil diperbarui.');
        return back();
    }
}