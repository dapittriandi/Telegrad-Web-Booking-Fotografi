<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// MODELS
use App\Models\Order;
use App\Models\WebSetting;

class AdminOrderController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST SEMUA ORDER
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $data['title'] = 'Manajemen Order';
        $data['menu'] = 'Order';
        $data['submenu'] = 'Daftar Order';
        $data['subdesc'] = 'Kelola seluruh pesanan customer';

        $data['web'] = WebSetting::latest()->first();

        $data['orders'] = Order::with([
                'user',
                'package',
                'payment',
                'delivery'
            ])
            ->latest()
            ->get();

        return view('admin.order.index', $data);
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL ORDER
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $data['title'] = 'Detail Order';
        $data['menu'] = 'Order';
        $data['submenu'] = 'Detail Order';
        $data['subdesc'] = 'Detail pesanan customer';

        $data['web'] = WebSetting::latest()->first();

        $data['order'] = Order::with([
                'user',
                'package',
                'payment',
                'delivery'
            ])
            ->findOrFail($id);

        return view('admin.order.detail', $data);
    }

    /*
    |--------------------------------------------------------------------------
    | CONFIRM ORDER
    |--------------------------------------------------------------------------
    | digunakan setelah payment verified
    */
    public function confirm($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'pending') {
            return back()->with(
                'error',
                'Order tidak bisa dikonfirmasi'
            );
        }

        $order->update([
            'status' => 'confirmed'
        ]);

        return back()->with(
            'success',
            'Order berhasil dikonfirmasi'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | COMPLETE ORDER
    |--------------------------------------------------------------------------
    | setelah sesi foto selesai
    */
    public function complete($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'confirmed') {
            return back()->with(
                'error',
                'Order belum bisa diselesaikan'
            );
        }

        $order->update([
            'status' => 'completed'
        ]);

        return back()->with(
            'success',
            'Order berhasil diselesaikan'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CANCEL ORDER
    |--------------------------------------------------------------------------
    */
    public function cancel($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status === 'completed') {
            return back()->with(
                'error',
                'Order completed tidak bisa dibatalkan'
            );
        }

        $order->update([
            'status' => 'cancelled'
        ]);

        return back()->with(
            'success',
            'Order berhasil dibatalkan'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE ORDER
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        $order->delete();

        return back()->with(
            'success',
            'Order berhasil dihapus'
        );
    }
}