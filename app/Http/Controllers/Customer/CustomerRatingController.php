<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Rating;
use App\Models\Order;

class CustomerRatingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | STORE RATING
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'rating'   => 'required|integer|min:1|max:5',
            'review'   => 'nullable|string|max:1000',
        ]);

        $order = Order::where('id', $request->order_id)
            ->where('user_id', Auth::id())
            ->where('status', 'completed') // hanya order completed
            ->firstOrFail();

        // cegah double rating
        if ($order->rating) {
            return back()->with('error', 'Kamu sudah memberikan rating untuk order ini.');
        }

        Rating::create([
            'order_id' => $order->id,
            'user_id'  => Auth::id(),
            'rating'   => $request->rating,
            'review'   => $request->review,
        ]);

        return back()->with('success', 'Terima kasih! Rating kamu sudah berhasil dikirim.');
    }
}