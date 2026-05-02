@extends('base.base-admin-index')

@php $menu = 'Pesanan'; $submenu = 'Detail Pesanan'; $subdesc = 'Order #' . str_pad($order->id, 5, '0', STR_PAD_LEFT); @endphp

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

    .badge-pending   { background:#FEF3C7; color:#92400E; font-size:.72rem; font-weight:700; padding:4px 12px; border-radius:100px; }
    .badge-confirmed { background:#DBEAFE; color:#1E40AF; font-size:.72rem; font-weight:700; padding:4px 12px; border-radius:100px; }
    .badge-completed { background:#D1FAE5; color:#065F46; font-size:.72rem; font-weight:700; padding:4px 12px; border-radius:100px; }
    .badge-cancelled { background:#FEE2E2; color:#991B1B; font-size:.72rem; font-weight:700; padding:4px 12px; border-radius:100px; }

    .timeline-dot { width:10px; height:10px; border-radius:50%; flex-shrink:0; margin-top:4px; }
    .feature-item { display:flex; align-items:flex-start; gap:8px; padding:6px 0; border-bottom:1px solid #F9FAFB; font-size:.82rem; color:#374151; }
    .feature-item:last-child { border-bottom:none; }
    .section-label { font-size:.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.1em; color:#9CA3AF; margin-bottom:10px; }
</style>
@endsection

@section('content')

<div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
    <div class="d-flex align-items-center gap-2">
        @php
            $cls = match($order->status) {
                'pending'   => 'badge-pending',
                'confirmed' => 'badge-confirmed',
                'completed' => 'badge-completed',
                'cancelled' => 'badge-cancelled',
                default     => 'badge-pending',
            };
            $lbl = match($order->status) {
                'pending'   => 'Pending',
                'confirmed' => 'Dikonfirmasi',
                'completed' => 'Selesai',
                'cancelled' => 'Dibatalkan',
                default     => ucfirst($order->status),
            };
        @endphp
        <span class="{{ $cls }}">{{ $lbl }}</span>
        <span style="font-size:.8rem;color:#9CA3AF;">Order #{{ str_pad($order->id,5,'0',STR_PAD_LEFT) }}</span>
    </div>
    <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;font-size:.78rem;">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row g-3">

    {{-- Kiri: Info Utama --}}
    <div class="col-lg-8">

        {{-- Customer & Paket --}}
        <p class="section-label">Informasi Pesanan</p>
        <div class="card tg-card mb-3">
            <div class="card-header">
                <h5 class="card-title"><i class="fa-solid fa-receipt me-2 text-primary"></i>Detail Pesanan</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <p class="info-label">Customer</p>
                        <p class="info-value">{{ $order->user->name ?? '-' }}</p>
                        <p class="info-sub">{{ $order->user->email ?? '' }}</p>
                        <p class="info-sub">{{ $order->user->phone ?? '' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="info-label">Paket</p>
                        <p class="info-value">{{ $order->package->name ?? '-' }}</p>
                        <p class="info-sub">{{ $order->package->category->name ?? '' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="info-label">Tanggal Sesi</p>
                        <p class="info-value">{{ \Carbon\Carbon::parse($order->booking_date)->isoFormat('dddd, D MMMM YYYY') }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="info-label">Waktu Sesi</p>
                        <p class="info-value">
                            {{ \Carbon\Carbon::parse($order->start_time)->format('H:i') }} –
                            {{ \Carbon\Carbon::parse($order->end_time)->format('H:i') }} WIB
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="info-label">Lokasi</p>
                        <p class="info-value">{{ $order->location ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="info-label">Total Harga</p>
                        <p class="info-value" style="font-size:1.1rem;color:#2563EB;">Rp {{ number_format($order->total_price ?? 0,0,',','.') }}</p>
                    </div>
                    @if($order->notes)
                    <div class="col-12">
                        <p class="info-label">Catatan Customer</p>
                        <div style="background:#F9FAFB;border-radius:8px;padding:10px 14px;font-size:.84rem;color:#374151;border-left:3px solid #DBEAFE;">
                            {{ $order->notes }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Fitur Paket --}}
        @if($order->package && $order->package->features)
        <div class="card tg-card mb-3">
            <div class="card-header">
                <h5 class="card-title"><i class="fa-solid fa-list-check me-2 text-primary"></i>Fitur Paket</h5>
            </div>
            <div class="card-body">
                @foreach(explode("\n", $order->package->features) as $feat)
                @if(trim($feat))
                <div class="feature-item">
                    <i class="fa-solid fa-circle-check" style="color:#059669;font-size:.8rem;margin-top:2px;"></i>
                    <span>{{ trim($feat) }}</span>
                </div>
                @endif
                @endforeach
            </div>
        </div>
        @endif

        {{-- Aksi --}}
        <div class="card tg-card">
            <div class="card-header">
                <h5 class="card-title"><i class="fa-solid fa-bolt me-2 text-primary"></i>Tindakan</h5>
            </div>
            <div class="card-body">
                <div class="d-flex gap-2 flex-wrap">
                    @if($order->status === 'pending')
                    <form action="{{ route('admin.orders.confirm', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success" style="border-radius:8px;font-size:.84rem;" onclick="return confirm('Konfirmasi order ini?')">
                            <i class="fa-solid fa-check me-1"></i> Konfirmasi Order
                        </button>
                    </form>
                    @endif
                    @if($order->status === 'confirmed')
                    <form action="{{ route('admin.orders.complete', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-info" style="border-radius:8px;font-size:.84rem;" onclick="return confirm('Tandai selesai?')">
                            <i class="fa-solid fa-camera me-1"></i> Tandai Selesai
                        </button>
                    </form>
                    <a href="{{ route('deliveries.create', ['order_id' => $order->id]) }}" class="btn btn-primary" style="border-radius:8px;font-size:.84rem;">
                        <i class="fa-solid fa-paper-plane me-1"></i> Kirim Hasil Foto
                    </a>
                    @endif
                    @if(!in_array($order->status, ['completed','cancelled']))
                    <form action="{{ route('admin.orders.cancel', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-warning" style="border-radius:8px;font-size:.84rem;" onclick="return confirm('Batalkan order ini?')">
                            <i class="fa-solid fa-ban me-1"></i> Batalkan
                        </button>
                    </form>
                    @endif
                    <form id="delete-form-{{ $order->id }}" action="{{ route('orders.destroy', $order->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="button" class="btn btn-outline-danger" style="border-radius:8px;font-size:.84rem;" onclick="deleteData({{ $order->id }})">
                            <i class="fa-solid fa-trash me-1"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Kanan: Ringkasan --}}
    <div class="col-lg-4">

        {{-- Status Pembayaran --}}
        <p class="section-label">Status Pembayaran</p>
        <div class="card tg-card mb-3">
            <div class="card-header">
                <h5 class="card-title"><i class="fa-solid fa-credit-card me-2" style="color:#059669;"></i>Pembayaran</h5>
            </div>
            <div class="card-body">
                @if($order->payment)
                @php
                    $ps = $order->payment->payment_status ?? 'pending';
                    $pcls = match($ps) {
                        'verified' => ['bg'=>'#D1FAE5','c'=>'#065F46','lbl'=>'Terverifikasi'],
                        'rejected' => ['bg'=>'#FEE2E2','c'=>'#991B1B','lbl'=>'Ditolak'],
                        default    => ['bg'=>'#FEF3C7','c'=>'#92400E','lbl'=>'Menunggu Verifikasi'],
                    };
                @endphp
                <div class="mb-3 p-3" style="background:{{ $pcls['bg'] }};border-radius:10px;text-align:center;">
                    <span style="font-size:.82rem;font-weight:700;color:{{ $pcls['c'] }};">{{ $pcls['lbl'] }}</span>
                </div>
                <div class="mb-2">
                    <p class="info-label">Jumlah</p>
                    <p class="info-value">Rp {{ number_format($order->payment->amount ?? 0,0,',','.') }}</p>
                </div>
                <div class="mb-2">
                    <p class="info-label">Metode</p>
                    <p class="info-value" style="text-transform:capitalize;">{{ $order->payment->payment_method ?? '-' }}</p>
                </div>
                <div>
                    <p class="info-label">Tanggal Bayar</p>
                    <p class="info-value" style="font-size:.82rem;">{{ \Carbon\Carbon::parse($order->payment->created_at)->isoFormat('D MMMM YYYY, HH:mm') }}</p>
                </div>
                @if($order->payment->payment_proof)
                <div class="mt-3 text-center">
                    <p class="info-label mb-2">Bukti Pembayaran</p>
                    <img src="{{ asset('storage/'.$order->payment->payment_proof) }}"
                         class="img-fluid rounded" style="max-height:160px;object-fit:contain;cursor:pointer;border-radius:8px!important;"
                         onclick="window.open(this.src)" alt="Bukti">
                    <p style="font-size:.72rem;color:#9CA3AF;margin-top:6px;">Klik untuk perbesar</p>
                </div>
                @endif
                @else
                <div style="text-align:center;padding:20px 0;color:#9CA3AF;">
                    <i class="fa-solid fa-receipt fa-2x d-block mb-2" style="opacity:.3;"></i>
                    <span style="font-size:.82rem;">Belum ada pembayaran</span>
                </div>
                @endif
            </div>
        </div>

        {{-- Hasil Foto --}}
        <div class="card tg-card">
            <div class="card-header">
                <h5 class="card-title"><i class="fa-solid fa-images me-2" style="color:#2563EB;"></i>Hasil Foto</h5>
            </div>
            <div class="card-body">
                @if($order->delivery)
                <div class="mb-2">
                    <p class="info-label">Status</p>
                    @php
                        $ds = $order->delivery->status ?? '-';
                        $dcls = match($ds) {
                            'delivered' => ['bg'=>'#DBEAFE','c'=>'#1E40AF','lbl'=>'Dikirim'],
                            'completed' => ['bg'=>'#D1FAE5','c'=>'#065F46','lbl'=>'Selesai'],
                            'editing'   => ['bg'=>'#FEF3C7','c'=>'#92400E','lbl'=>'Editing'],
                            default     => ['bg'=>'#F3F4F6','c'=>'#6B7280','lbl'=>ucfirst($ds)],
                        };
                    @endphp
                    <span style="background:{{ $dcls['bg'] }};color:{{ $dcls['c'] }};font-size:.72rem;font-weight:700;padding:3px 10px;border-radius:100px;">{{ $dcls['lbl'] }}</span>
                </div>
                @if($order->delivery->delivery_link)
                <a href="{{ $order->delivery->delivery_link }}" target="_blank" class="btn btn-success btn-sm w-100 mt-2" style="border-radius:8px;font-size:.82rem;">
                    <i class="fa-brands fa-google-drive me-1"></i> Buka Google Drive
                </a>
                @endif
                @else
                <div style="text-align:center;padding:16px 0;color:#9CA3AF;">
                    <i class="fa-solid fa-images fa-2x d-block mb-2" style="opacity:.3;"></i>
                    <span style="font-size:.82rem;">Belum ada pengiriman</span>
                </div>
                @if($order->status === 'confirmed')
                <a href="{{ route('deliveries.create', ['order_id' => $order->id]) }}" class="btn btn-primary btn-sm w-100 mt-2" style="border-radius:8px;font-size:.82rem;">
                    <i class="fa-solid fa-paper-plane me-1"></i> Kirim Hasil
                </a>
                @endif
                @endif
            </div>
        </div>
    </div>

</div>

@endsection