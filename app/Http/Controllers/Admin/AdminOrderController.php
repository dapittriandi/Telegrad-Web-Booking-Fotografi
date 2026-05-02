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
    | LIST SEMUA ORDER — dengan pagination & filter status
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $web = WebSetting::latest()->first();

        // ── Stat counts: query count langsung, TIDAK load semua data ──
        $totalOrders    = Order::count();
        $totalPending   = Order::where('status', 'pending')->count();
        $totalConfirmed = Order::where('status', 'confirmed')->count();
        $totalCompleted = Order::where('status', 'completed')->count();
        $totalCancelled = Order::where('status', 'cancelled')->count();

        // ── Query utama: filter + search + pagination ──
        $query = Order::with(['user', 'package.category', 'payment', 'delivery'])
                      ->latest();

        // Filter by status (dari tab filter blade)
        $status = $request->input('status', 'all');
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        // Search by nama customer atau nama paket
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%")
                                                   ->orWhere('email', 'like', "%{$search}%"))
                  ->orWhereHas('package', fn($p) => $p->where('name', 'like', "%{$search}%"));
            });
        }

        $orders = $query->paginate(15)->withQueryString();

        return view('admin.order.index', compact(
            'web',
            'orders',
            'totalOrders',
            'totalPending',
            'totalConfirmed',
            'totalCompleted',
            'totalCancelled'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL ORDER
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $web   = WebSetting::latest()->first();
        $order = Order::with(['user', 'package.category', 'payment', 'delivery'])
                      ->findOrFail($id);

        return view('admin.order.show', compact('web', 'order'));
    }

    /*
    |--------------------------------------------------------------------------
    | CONFIRM ORDER
    |--------------------------------------------------------------------------
    */
    public function confirm($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'pending') {
            return back()->with('error', 'Order tidak bisa dikonfirmasi.');
        }

        $order->update(['status' => 'confirmed']);

        return back()->with('success', 'Order berhasil dikonfirmasi.');
    }

    /*
    |--------------------------------------------------------------------------
    | COMPLETE ORDER
    |--------------------------------------------------------------------------
    */
    public function complete($id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'confirmed') {
            return back()->with('error', 'Order belum bisa diselesaikan.');
        }

        $order->update(['status' => 'completed']);

        return back()->with('success', 'Order berhasil diselesaikan.');
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
            return back()->with('error', 'Order yang sudah selesai tidak bisa dibatalkan.');
        }

        if ($order->status === 'cancelled') {
            return back()->with('error', 'Order sudah berstatus dibatalkan.');
        }

        $order->update(['status' => 'cancelled']);

        return back()->with('success', 'Order berhasil dibatalkan.');
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

        return redirect()->route('orders.index')
                         ->with('success', 'Order berhasil dihapus.');
    }
}