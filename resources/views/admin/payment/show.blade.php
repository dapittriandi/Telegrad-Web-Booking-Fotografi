@extends('base.base-admin-index')

@php $menu = 'Pembayaran'; $submenu = 'Detail Pembayaran'; $subdesc = 'Transaksi #' . str_pad($payment->id, 5, '0', STR_PAD_LEFT); @endphp

@section('custom-css')
<style>
    @font-face { font-family:"Font Awesome 6 Free"; font-weight:900; font-display:block; src:url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/webfonts/fa-solid-900.woff2") format("woff2"); }
    .fa-solid,.fas{font-family:"Font Awesome 6 Free"!important;font-weight:900!important;}

    .tg-card { border:none!important; border-radius:14px!important; box-shadow:0 1px 3px rgba(0,0,0,.06),0 4px 16px rgba(0,0,0,.05)!important; }
    .tg-card .card-header { background:#fff!important; border-bottom:1px solid #F3F4F6!important; padding:15px 20px!important; }
    .tg-card .card-header .card-title { font-size:.95rem!important; font-weight:700!important; color:#111827!important; margin:0; }
    .tg-card .card-body { padding:20px!important; }

    .info-label { font-size:.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:#9CA3AF; margin-bottom:4px; }
    .info-value { font-size:.88rem; font-weight:600; color:#111827; margin:0; }
    .info-sub   { font-size:.76rem; color:#9CA3AF; margin:2px 0 0; }
    .section-label { font-size:.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.1em; color:#9CA3AF; margin-bottom:10px; }
</style>
@endsection

@section('content')

<div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
    @php
        $ps = $payment->payment_status ?? 'pending';
        $pill = match($ps) {
            'verified' => ['bg'=>'#D1FAE5','c'=>'#065F46','lbl'=>'Terverifikasi'],
            'rejected' => ['bg'=>'#FEE2E2','c'=>'#991B1B','lbl'=>'Ditolak'],
            default    => ['bg'=>'#FEF3C7','c'=>'#92400E','lbl'=>'Menunggu Verifikasi'],
        };
    @endphp
    <div class="d-flex align-items-center gap-2">
        <span style="background:{{ $pill['bg'] }};color:{{ $pill['c'] }};font-size:.76rem;font-weight:700;padding:4px 12px;border-radius:100px;">{{ $pill['lbl'] }}</span>
        <span style="font-size:.8rem;color:#9CA3AF;">Transaksi #{{ str_pad($payment->id,5,'0',STR_PAD_LEFT) }}</span>
    </div>
    <a href="{{ route('payments.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;font-size:.78rem;">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row g-3">

    <div class="col-lg-8">

        <p class="section-label">Informasi Order</p>
        <div class="card tg-card mb-3">
            <div class="card-header">
                <h5 class="card-title"><i class="fa-solid fa-cart-shopping me-2 text-primary"></i>Detail Order</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <p class="info-label">Customer</p>
                        <p class="info-value">{{ $payment->order->user->name ?? '-' }}</p>
                        <p class="info-sub">{{ $payment->order->user->email ?? '' }}</p>
                        <p class="info-sub">{{ $payment->order->user->phone ?? '' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="info-label">Paket</p>
                        <p class="info-value">{{ $payment->order->package->name ?? '-' }}</p>
                        <p class="info-sub">{{ $payment->order->package->category->name ?? '' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="info-label">Tanggal Booking</p>
                        <p class="info-value">{{ $payment->order->booking_date ? \Carbon\Carbon::parse($payment->order->booking_date)->isoFormat('dddd, D MMMM YYYY') : '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="info-label">Waktu Sesi</p>
                        <p class="info-value">{{ $payment->order->start_time ? \Carbon\Carbon::parse($payment->order->start_time)->format('H:i').' WIB' : '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="info-label">Lokasi</p>
                        <p class="info-value">{{ $payment->order->location ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="info-label">Status Order</p>
                        @php
                            $oc = match($payment->order->status ?? 'pending') {
                                'confirmed'=>['bg'=>'#DBEAFE','c'=>'#1E40AF'],
                                'completed'=>['bg'=>'#D1FAE5','c'=>'#065F46'],
                                'cancelled'=>['bg'=>'#FEE2E2','c'=>'#991B1B'],
                                default    =>['bg'=>'#FEF3C7','c'=>'#92400E'],
                            };
                        @endphp
                        <span style="background:{{ $oc['bg'] }};color:{{ $oc['c'] }};font-size:.72rem;font-weight:700;padding:3px 10px;border-radius:100px;">
                            {{ ucfirst($payment->order->status ?? 'pending') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <p class="section-label">Informasi Pembayaran</p>
        <div class="card tg-card">
            <div class="card-header">
                <h5 class="card-title"><i class="fa-solid fa-credit-card me-2" style="color:#059669;"></i>Detail Transaksi</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <p class="info-label">Jumlah Bayar</p>
                        <p class="info-value" style="font-size:1.2rem;color:#2563EB;">Rp {{ number_format($payment->amount ?? 0,0,',','.') }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="info-label">Metode Pembayaran</p>
                        <p class="info-value" style="text-transform:capitalize;">{{ $payment->payment_method ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="info-label">Status Pembayaran</p>
                        <span style="background:{{ $pill['bg'] }};color:{{ $pill['c'] }};font-size:.78rem;font-weight:700;padding:4px 14px;border-radius:100px;">{{ $pill['lbl'] }}</span>
                    </div>
                    <div class="col-md-6">
                        <p class="info-label">Tanggal Pembayaran</p>
                        <p class="info-value">{{ \Carbon\Carbon::parse($payment->created_at)->isoFormat('D MMMM YYYY, HH:mm') }} WIB</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="col-lg-4">

        <p class="section-label">Bukti Pembayaran</p>
        <div class="card tg-card mb-3">
            <div class="card-header">
                <h5 class="card-title"><i class="fa-solid fa-image me-2" style="color:#2563EB;"></i>Bukti Transfer</h5>
            </div>
            <div class="card-body text-center">
                @if($payment->payment_proof)
                    <img src="{{ asset('storage/'.$payment->payment_proof) }}"
                         alt="Bukti Pembayaran" class="img-fluid"
                         style="max-height:300px;object-fit:contain;border-radius:10px;cursor:pointer;"
                         onclick="window.open(this.src)">
                    <p style="font-size:.72rem;color:#9CA3AF;margin-top:8px;">Klik gambar untuk memperbesar</p>
                @else
                    <div style="padding:30px 0;color:#9CA3AF;">
                        <i class="fa-solid fa-image fa-3x d-block mb-3" style="opacity:.2;"></i>
                        <span style="font-size:.84rem;">Belum ada bukti pembayaran</span>
                    </div>
                @endif
            </div>
        </div>

        @if($ps === 'pending')
        <p class="section-label">Tindakan</p>
        <div class="card tg-card">
            <div class="card-header">
                <h5 class="card-title"><i class="fa-solid fa-bolt me-2 text-primary"></i>Verifikasi</h5>
            </div>
            <div class="card-body d-flex flex-column gap-2">
                <form action="{{ route('admin.payments.verify', $payment->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success w-100" style="border-radius:8px;font-size:.86rem;" onclick="return confirm('Verifikasi pembayaran ini?')">
                        <i class="fa-solid fa-check me-2"></i> Verifikasi Pembayaran
                    </button>
                </form>
                <form action="{{ route('admin.payments.reject', $payment->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100" style="border-radius:8px;font-size:.86rem;" onclick="return confirm('Tolak pembayaran ini?')">
                        <i class="fa-solid fa-times me-2"></i> Tolak Pembayaran
                    </button>
                </form>
            </div>
        </div>
        @endif

    </div>
</div>

@endsection