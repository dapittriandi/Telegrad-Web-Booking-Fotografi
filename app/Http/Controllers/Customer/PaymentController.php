<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

// MODELS
use App\Models\Order;
use App\Models\Payment;
use App\Models\WebSetting;

class PaymentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN PAYMENT
    |--------------------------------------------------------------------------
    */
    public function create($orderId)
    {
        $order = Order::with('package')
            ->where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // kalau sudah ada payment
        if ($order->payment) {
            return redirect()
                ->route('customer.orders')
                ->with('error', 'Pembayaran sudah dikirim sebelumnya.');
        }

        return view('customer.payment.create', [
            'title' => 'Pembayaran',
            'submenu' => 'Pembayaran',
            'web' => WebSetting::latest()->first(),
            'order' => $order,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE PAYMENT
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'order_id'      => 'required|exists:orders,id',
            'payment_method' => 'required|in:transfer,qris,cash',
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $order = Order::where('id', $request->order_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // cegah double payment
        if ($order->payment) {
            return back()->with('error', 'Pembayaran sudah pernah dikirim.');
        }

        /*
        |----------------------------------------
        | UPLOAD FILE (LARAVEL STORAGE WAY)
        |----------------------------------------
        */
        $filePath = null;

        if ($request->hasFile('payment_proof')) {

            $file = $request->file('payment_proof');

            $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();

            $filePath = $file->storeAs(
                'payments',
                $filename,
                'public'
            );
        }

        /*
        |----------------------------------------
        | CREATE PAYMENT
        |----------------------------------------
        */
        Payment::create([
            'order_id'       => $order->id,
            'amount'         => $order->total_price,
            'payment_method' => $request->payment_method,
            'payment_proof'  => $filePath,
            'payment_status'         => 'pending',
        ]);

        /*
        |----------------------------------------
        | UPDATE ORDER STATUS
        |----------------------------------------
        */
        $order->update(['status' => 'pending']
        );
        

        return redirect()
            ->route('customer.orders')
            ->with('success', 'Pembayaran berhasil dikirim, menunggu verifikasi.');
    }
}