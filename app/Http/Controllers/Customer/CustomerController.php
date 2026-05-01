<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

// MODELS
use App\Models\Order;
use App\Models\Payment;
use App\Models\Delivery;
use App\Models\WebSetting;

class CustomerController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ORDER HISTORY
    |--------------------------------------------------------------------------
    */
    public function history()
    {
        $data['title'] = 'Riwayat Order';
        $data['menu']  = 'Order';
        $data['web']   = WebSetting::latest()->first();

        $data['orders'] = Order::with(['package.category', 'payment', 'delivery'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('customer.orders.history', $data);
    }

    /*
    |--------------------------------------------------------------------------
    | ORDER DETAIL
    |--------------------------------------------------------------------------
    */
    public function detail($id)
    {
        $data['title'] = 'Detail Order';
        $data['menu']  = 'Order Detail';
        $data['web']   = WebSetting::latest()->first();

        $data['order'] = Order::with(['package.category', 'payment', 'delivery', 'rating',])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('customer.orders.detail', $data);
    }

    /*
    |--------------------------------------------------------------------------
    | DELIVERY RESULT
    |--------------------------------------------------------------------------
    */
   public function delivery($orderId)
{
    $data['title']   = 'Hasil Foto';
    $data['menu']    = 'Delivery';
    $data['web']     = WebSetting::latest()->first();

    $order = Order::with([
            'package.category',
            'payment',
            'delivery',
            'rating',
        ])
        ->where('user_id', Auth::id())
        ->findOrFail($orderId);

    $data['delivery'] = $order->delivery ?? abort(404);
    $data['order']    = $order; // ← tambahkan ini

    return view('customer.delivery.detail', $data);
}

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */
    public function profile()
    {
        $data['title'] = 'Profil Saya';
        $data['menu']  = 'Profil';
        $data['web']   = WebSetting::latest()->first();

        return view('customer.profile.profile', $data);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE PROFILE
    |--------------------------------------------------------------------------
    */
    public function profileUpdate(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone'    => 'required|string|max:20',
            'photo'    => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        /*
        |----------------------------------------
        | UPLOAD FOTO
        |----------------------------------------
        */
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = storage_path('app/public/images/profile');

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            // Hapus foto lama jika bukan default
            if ($user->photo && $user->photo !== 'default.jpg') {
                File::delete($path . '/' . $user->photo);
            }

            $file->move($path, $filename);
            $user->photo = $filename;
        }

        /*
        |----------------------------------------
        | UPDATE DATA
        |----------------------------------------
        */
        $user->name  = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($request->filled('username')) {
            $user->username = $request->username;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}