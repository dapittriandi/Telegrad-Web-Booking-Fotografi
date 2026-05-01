<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST PAYMENT
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $payments = Payment::with(['order.user', 'order.package'])
            ->latest()
            ->get();

        return view('admin.payment.index', [
            'title'    => 'Payment Management',
            'menu'     => 'Transaksi',
            'submenu'  => 'Pembayaran',
            'subdesc'  => 'Kelola semua data pembayaran',
            'payments' => $payments,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL PAYMENT
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $payment = Payment::with(['order.user', 'order.package'])
            ->findOrFail($id);

        return view('admin.payment.show', [
            'title'   => 'Detail Payment',
            'menu'    => 'Transaksi',
            'submenu' => 'Detail Pembayaran',
            'subdesc' => 'Detail data pembayaran',
            'payment' => $payment,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | VERIFY PAYMENT
    | FIX: kolom adalah 'status' bukan 'payment_status'
    |--------------------------------------------------------------------------
    */
   public function verify($id)
    {
        return DB::transaction(function () use ($id) {

            $payment = Payment::with('order')->findOrFail($id);

            if ($payment->payment_status === 'verified') {
                return back()->with('error', 'Payment sudah diverifikasi.');
            }

            if ($payment->payment_status === 'rejected') {
                return back()->with('error', 'Payment sudah ditolak, tidak bisa diverifikasi.');
            }

            $payment->update(['payment_status' => 'verified']); // ← FIX

            $payment->order->update(['status' => 'confirmed']);

            return back()->with('success', 'Pembayaran berhasil diverifikasi.');
        });
    }

    public function reject($id)
    {
        return DB::transaction(function () use ($id) {

            $payment = Payment::with('order')->findOrFail($id);

            if ($payment->payment_status === 'rejected') {
                return back()->with('error', 'Payment sudah ditolak.');
            }

            $payment->update(['payment_status' => 'rejected']); // ← FIX

            $payment->order->update(['status' => 'cancelled']);

            return back()->with('success', 'Pembayaran ditolak.');
        });
    }

    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {

            $payment = Payment::with('order')->findOrFail($id);

            $payment->order->update(['status' => 'pending']);
            $payment->delete();

            return back()->with('success', 'Data payment berhasil dihapus.');
        });
    }
   
}