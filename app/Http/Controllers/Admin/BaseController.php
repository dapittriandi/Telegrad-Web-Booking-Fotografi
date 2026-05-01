<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// SUPPORT
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Alert;

// MODEL
use App\Models\User;
use App\Models\Order;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Delivery;
use App\Models\Rating;
use App\Models\Category;
use App\Models\Portofolio;
use App\Models\WebSetting;

class BaseController extends Controller
{
    /**
     * DASHBOARD ADMIN
     */
    public function index()
    {
        $data['title']   = 'Dashboard Admin';
        $data['menu']    = 'Dashboard';
        $data['submenu'] = 'Beranda';
        $data['subdesc'] = 'Halaman utama dashboard admin';
        $data['web']     = WebSetting::latest()->first();

        // Statistik User
        $data['totalCustomer'] = User::where('role', 'customer')->count();
        $data['totalAdmin']    = User::where('role', 'admin')->count();

        // Statistik Order
        $data['totalOrder']    = Order::count();
        $data['orderPending']  = Order::where('status', 'pending')->count();
        $data['orderProcess']  = Order::where('status', 'confirmed')->count();
        $data['orderFinished'] = Order::where('status', 'completed')->count();

        // Pendapatan
        $data['totalIncome'] = Order::where('status', 'completed')
                                    ->sum('total_price');

        // Payment
        $data['totalPayment'] = Payment::count();

        // Delivery
        $data['totalDelivery'] = Delivery::count();

        // Rating
        $data['totalRating'] = Rating::count();

        // Data terbaru
        $data['latestOrders'] = Order::with(['user', 'package'])
                                    ->latest()->take(5)->get();

        $data['latestPayment'] = Payment::with(['order.user'])
                                        ->latest()->take(5)->get();

        $data['latestRatings'] = Rating::with(['user'])
                                        ->latest()->take(5)->get();

        // FIX: return ke 'admin.dashboard' bukan 'admin.dash-index'
        return view('admin.dashboard', $data);
    }

    /**
     * PROFILE ADMIN
     */
    public function profile()
    {
        $data['title']   = 'Profile Admin';
        $data['menu']    = 'Profile';
        $data['submenu'] = 'Akun Saya';
        $data['subdesc'] = 'Kelola informasi akun admin';
        $data['web']     = WebSetting::latest()->first();

        return view('admin.profile', $data);
    }

    /**
     * UPDATE PROFILE ADMIN
     */
    public function profileUpdate(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'photo'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'phone'    => 'required|numeric',
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $name  = uniqid() . '.' . $image->getClientOriginalExtension();
            $path  = storage_path('app/public/images/profile');

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            // Hapus foto lama
            if ($user->photo && $user->photo !== 'default.jpg') {
                File::delete($path . '/' . $user->photo);
            }

            $image->move($path, $name);
            $user->photo = $name;
        }

        $user->name     = $request->name;
        $user->username = $request->username;
        $user->phone    = $request->phone;
        $user->email    = $request->email;
        $user->save();

        Alert::success('Berhasil', 'Profil berhasil diperbarui');
        return back();
    }
}