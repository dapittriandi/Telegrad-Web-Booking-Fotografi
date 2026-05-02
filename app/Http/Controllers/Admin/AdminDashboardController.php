<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// MODELS
use App\Models\Order;
use App\Models\Payment;
use App\Models\Rating;
use App\Models\User;
use App\Models\WebSetting;

class AdminDashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD — statistik utama + data terbaru
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $web = WebSetting::latest()->first();

        // ── Stat Cards (4 kartu atas) ──────────────────────────────────────
        $pendingOrder   = Order::where('status', 'pending')->count();
        $completedOrder = Order::where('status', 'completed')->count();
        $totalIncome    = Payment::where('payment_status', 'verified')->sum('amount');
        $totalRating    = Rating::count();

        // ── Ringkasan (side card kiri) ─────────────────────────────────────
        $totalOrder     = Order::count();
        $totalCustomer  = User::where('role', 'customer')->count();
        $totalPayment   = Payment::count();
        $totalDelivery  = Order::where('status', 'completed')->count();

        // ── Tabel Pesanan Terbaru (10 data) ────────────────────────────────
        $latestOrder = Order::with(['user', 'package.category'])
                            ->latest()
                            ->take(10)
                            ->get();

        // ── Payment Terbaru (5 data) ───────────────────────────────────────
        $latestPayment = Payment::with(['order.user'])
                                ->latest()
                                ->take(5)
                                ->get();

        // ── Rating Terbaru (5 data) ────────────────────────────────────────
        $latestRatings = Rating::with('user')
                               ->latest()
                               ->take(5)
                               ->get();

        return view('admin.dashboard', compact(
            'web',

            // stat cards
            'pendingOrder',
            'completedOrder',
            'totalIncome',
            'totalRating',

            // ringkasan
            'totalOrder',
            'totalCustomer',
            'totalPayment',
            'totalDelivery',

            // tabel & lists
            'latestOrder',
            'latestPayment',
            'latestRatings',
        ));
    }
}