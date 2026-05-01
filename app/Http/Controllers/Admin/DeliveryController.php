<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Delivery;
use App\Models\Order;

class DeliveryController extends Controller
{
    /**
     * List delivery
     */
    public function index()
    {
        $deliveries = Delivery::with([
            'order.user',
            'order.package'
        ])->latest()->get();

        return view('admin.delivery.index', compact('deliveries'));
    }

    /**
     * Form upload hasil
     */
    public function create()
    {
        $orders = Order::where('status', 'confirmed')
            ->get();

        return view('admin.delivery.create', compact('orders'));
    }

    /**
     * Simpan hasil delivery
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'delivery_link' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $order = Order::findOrFail($request->order_id);

        Delivery::create([
            'order_id' => $request->order_id,
            'delivery_link' => $request->delivery_link,
            'delivery_date' => now(),
            'status' => 'delivered',
            'notes' => $request->notes,
        ]);

        // otomatis order selesai
        $order->update([
            'status' => 'completed'
        ]);

        return redirect()
            ->route('admin.delivery.index')
            ->with(
                'success',
                'Hasil foto berhasil dikirim'
            );
    }

    /**
     * Update revisi/status
     */
    public function update(Request $request, $id)
    {
        $delivery = Delivery::findOrFail($id);

        $request->validate([
            'status' => 'required',
            'notes' => 'nullable|string'
        ]);

        $delivery->update([
            'status' => $request->status,
            'notes' => $request->notes
        ]);

        return back()->with(
            'success',
            'Delivery berhasil diperbarui'
        );
    }

    public function destroy($id)
    {
        Delivery::findOrFail($id)->delete();

        return back()->with(
            'success',
            'Delivery berhasil dihapus'
        );
    }
}