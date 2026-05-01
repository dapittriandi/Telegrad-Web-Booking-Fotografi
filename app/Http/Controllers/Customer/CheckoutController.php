<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

// MODELS
use App\Models\Package;
use App\Models\Order;
use App\Models\WebSetting;

class CheckoutController extends Controller
{
    /*
    |----------------------------------------
    | HALAMAN CHECKOUT
    |----------------------------------------
    */
    public function checkout($packageId)
    {
        $package = Package::with('category')->findOrFail($packageId);

        return view('customer.checkout.index', [
            'title' => 'Checkout Package',
            'menu' => 'Checkout',
            'submenu' => 'Checkout',
            'web' => WebSetting::latest()->first(),
            'package' => $package,
        ]);
    }

    /*
    |----------------------------------------
    | STORE ORDER + VALIDASI + UPLOAD READY
    |----------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'package_id'    => 'required|exists:packages,id',
            'booking_date'  => 'required|date',
            'start_time'    => 'required',
            'location'     => 'required|string|max:255',
            'phone'        => 'required|string|max:20',
            'notes'        => 'nullable|string',

            // optional payment proof (kalau langsung upload di checkout)
            // 'payment_proof' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $package = Package::findOrFail($request->package_id);

        return DB::transaction(function () use ($request, $package) {

            /*
            |----------------------------------------
            | HITUNG WAKTU BOOKING
            |----------------------------------------
            */
            $duration = $package->duration ?? 60;

            $start = Carbon::parse($request->booking_date . ' ' . $request->start_time);
            $end   = (clone $start)->addMinutes($duration);

            /*
            |----------------------------------------
            | CEK KONFLIK JADWAL
            |----------------------------------------
            */
            $conflict = Order::where('booking_date', $request->booking_date)
                ->whereIn('status', ['pending', 'confirmed', 'completed'])
                ->where(function ($q) use ($start, $end) {
                    $q->where('start_time', '<', $end->format('H:i:s'))
                      ->where('end_time', '>', $start->format('H:i:s'));
                })
                ->exists();

            if ($conflict) {
                return back()->with('error', 'Jadwal sudah terisi, silakan pilih waktu lain.');
            }

            /*
            |----------------------------------------
            | UPLOAD PAYMENT PROOF (OPTIONAL)
            |----------------------------------------
            */
            // $paymentPath = null;

            // if ($request->hasFile('payment_proof')) {
            //     $file = $request->file('payment_proof');
            //     $filename = time() . '_' . $file->getClientOriginalName();
            //     $file->storeAs('public/payment', $filename);
            //     $paymentPath = $filename;
            // }

            /*
            |----------------------------------------
            | CREATE ORDER
            |----------------------------------------
            */
            $order = Order::create([
                'user_id'        => Auth::id(),
                'package_id'     => $package->id,
                'booking_date'   => $request->booking_date,
                'start_time'     => $start->format('H:i:s'),
                'end_time'       => $end->format('H:i:s'),
                'location'       => $request->location,
                'notes'          => $request->notes,
                'phone'        => $request->phone,
                'total_price'    => $package->price,
                'status'         => 'pending',
            ]);

            
            /*
            |----------------------------------------
            | REDIRECT KE PAYMENT PAGE
            |----------------------------------------
            */
            return redirect()
                ->route('customer.payment.create', $order->id)
                ->with('success', 'Booking berhasil dibuat, lanjut pembayaran.');
        });
    }
}