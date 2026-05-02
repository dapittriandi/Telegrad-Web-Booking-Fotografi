@extends('base.base-admin-index')

@php
    $menu    = 'Pesanan';
    $submenu = 'Detail Pesanan';
    $subdesc = 'Order #' . str_pad($order->id, 5, '0', STR_PAD_LEFT);
@endphp

@section('custom-css')
<style>
/* =============================================================
   GLOBAL ICON FIX — wajib ada di setiap blade yang pakai icon
   ============================================================= */
.bi {
    font-family: "bootstrap-icons" !important;
    line-height: 1 !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    vertical-align: middle !important;
}

/* =============================================================
   TOPBAR: status badge + back button
   ============================================================= */
.show-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 18px;
}
.show-topbar-left {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}
.order-id-text {
    font-size: .8rem;
    font-weight: 600;
    color: var(--tg-text-3);
    letter-spacing: .02em;
}

/* =============================================================
   STATUS BADGE
   ============================================================= */
.tg-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: .72rem;
    font-weight: 700;
    padding: 5px 13px;
    border-radius: 100px;
    white-space: nowrap;
    line-height: 1;
}
.tg-badge .bi {
    font-size: .72rem !important;
}
.tg-badge-pending   { background: #FEF3C7; color: #92400E; }
.tg-badge-confirmed { background: #DBEAFE; color: #1E40AF; }
.tg-badge-completed { background: #D1FAE5; color: #065F46; }
.tg-badge-cancelled { background: #FEE2E2; color: #991B1B; }

[data-theme="dark"] .tg-badge-pending   { background: rgba(254,243,199,.15); color: #FCD34D; }
[data-theme="dark"] .tg-badge-confirmed { background: rgba(219,234,254,.12); color: #93C5FD; }
[data-theme="dark"] .tg-badge-completed { background: rgba(209,250,229,.12); color: #6EE7B7; }
[data-theme="dark"] .tg-badge-cancelled { background: rgba(254,226,226,.12); color: #FCA5A5; }

/* =============================================================
   TIMELINE
   ============================================================= */
.tg-timeline {
    display: flex;
    align-items: flex-start;
    padding: 8px 0 4px;
}
.tg-tl-step {
    flex: 1;
    text-align: center;
    position: relative;
}
/* connector line */
.tg-tl-step::after {
    content: '';
    position: absolute;
    top: 17px;
    left: calc(50% + 20px);
    width: calc(100% - 40px);
    height: 2px;
    background: var(--tg-border);
    border-radius: 2px;
    transition: background .3s;
}
.tg-tl-step:last-child::after { display: none; }
.tg-tl-step.done::after       { background: #059669; }

.tg-tl-icon {
    width: 36px; height: 36px;
    border-radius: 50%;
    border: 2px solid var(--tg-border);
    background: var(--tg-glass);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 8px;
    position: relative; z-index: 1;
    transition: all .25s;
}
/* icon di dalam circle */
.tg-tl-icon .bi {
    font-size: .88rem !important;
    color: var(--tg-text-3);
    line-height: 1 !important;
}
.tg-tl-step.done   .tg-tl-icon { border-color: #059669; background: #D1FAE5; }
.tg-tl-step.done   .tg-tl-icon .bi { color: #059669 !important; }
.tg-tl-step.active .tg-tl-icon { border-color: #2563EB; background: #DBEAFE; }
.tg-tl-step.active .tg-tl-icon .bi { color: #2563EB !important; }

.tg-tl-label {
    font-size: .63rem;
    font-weight: 700;
    letter-spacing: .06em;
    text-transform: uppercase;
    color: var(--tg-text-3);
    line-height: 1.3;
}
.tg-tl-step.done   .tg-tl-label { color: #059669; }
.tg-tl-step.active .tg-tl-label { color: #2563EB; }

/* =============================================================
   CARD GENERIC
   ============================================================= */
.detail-card {
    border: 1px solid var(--tg-glass-border);
    border-radius: 14px;
    background: var(--tg-glass);
    backdrop-filter: var(--tg-blur);
    box-shadow: var(--tg-sh-sm);
    overflow: hidden;
    margin-bottom: 16px;
}
.detail-card:last-child { margin-bottom: 0; }

.detail-card-head {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 14px 18px;
    border-bottom: 1px solid var(--tg-border);
}
.detail-card-head-dark {
    background: linear-gradient(135deg, #0A1628, #1E3A8A);
    padding: 14px 18px;
    border-bottom: none;
}
.detail-card-title {
    font-size: .85rem;
    font-weight: 700;
    color: var(--tg-text);
    margin: 0;
    line-height: 1;
}
.detail-card-title-white {
    font-size: .88rem;
    font-weight: 700;
    color: #fff;
    margin: 0;
    line-height: 1;
}
.detail-card-head .bi {
    font-size: .95rem !important;
    flex-shrink: 0;
}
.detail-card-body { padding: 18px; }
.detail-card-body-sm { padding: 14px 18px; }
.detail-card-foot {
    padding: 14px 18px;
    border-top: 1px solid var(--tg-border);
}

/* =============================================================
   INFO GRID (label + value)
   ============================================================= */
.info-label {
    font-size: .63rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: var(--tg-text-3);
    margin: 0 0 4px;
    line-height: 1.2;
}
.info-value {
    font-size: .875rem;
    font-weight: 600;
    color: var(--tg-text);
    margin: 0;
    line-height: 1.4;
}
.info-sub {
    font-size: .74rem;
    color: var(--tg-text-3);
    margin: 2px 0 0;
    line-height: 1.4;
}

/* =============================================================
   NOTES BLOCK
   ============================================================= */
.tg-notes {
    background: rgba(59,130,246,.06);
    border-left: 3px solid #3B82F6;
    border-radius: 0 8px 8px 0;
    padding: 10px 14px;
    font-size: .84rem;
    color: var(--tg-text-2);
    line-height: 1.6;
}

/* =============================================================
   FEATURE LIST
   ============================================================= */
.feature-item {
    display: flex;
    align-items: flex-start;
    gap: 9px;
    padding: 8px 0;
    border-bottom: 1px solid var(--tg-border);
    font-size: .83rem;
    color: var(--tg-text-2);
    line-height: 1.5;
}
.feature-item:last-child { border-bottom: none; padding-bottom: 0; }
.feature-item .bi {
    font-size: .75rem !important;
    color: #059669;
    margin-top: 3px;
    flex-shrink: 0;
}

/* =============================================================
   SUMMARY LIST (ringkasan kanan)
   ============================================================= */
.summary-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 9px 0;
    border-bottom: 1px solid var(--tg-border);
    font-size: .83rem;
    gap: 8px;
}
.summary-row:last-child { border-bottom: none; padding-bottom: 0; }
.summary-row .s-lbl { color: var(--tg-text-2); flex-shrink: 0; }
.summary-row .s-val { font-weight: 700; color: var(--tg-text); text-align: right; }

/* =============================================================
   PAYMENT STATUS BOX
   ============================================================= */
.pay-status-box {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    padding: 10px 14px;
    border-radius: 10px;
    margin-bottom: 16px;
}
.pay-status-box .bi { font-size: 1rem !important; }
.pay-status-box span { font-size: .82rem; font-weight: 700; }

/* =============================================================
   PROOF IMAGE
   ============================================================= */
.proof-img {
    width: 100%;
    max-height: 200px;
    object-fit: contain;
    border-radius: 10px;
    border: 1px solid var(--tg-border);
    background: var(--tg-blue-lt);
    cursor: zoom-in;
    display: block;
    transition: opacity .15s;
}
.proof-img:hover { opacity: .88; }

/* =============================================================
   ACTION BUTTONS
   ============================================================= */
.action-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: .83rem;
    font-weight: 600;
    cursor: pointer;
    line-height: 1;
    border: none;
    text-decoration: none;
    transition: opacity .15s, transform .1s;
}
.action-btn:hover { opacity: .88; transform: translateY(-1px); }
.action-btn .bi { font-size: .8rem !important; }

.action-btn-success  { background: #059669; color: #fff; }
.action-btn-info     { background: #0EA5E9; color: #fff; }
.action-btn-primary  { background: #2563EB; color: #fff; }
.action-btn-warn-ol  { background: transparent; color: #D97706; border: 1.5px solid #D97706; }
.action-btn-danger-ol{ background: transparent; color: #DC2626; border: 1.5px solid #DC2626; }
.action-btn-back     { background: transparent; color: var(--tg-text-2); border: 1.5px solid var(--tg-border); }
.action-btn-back:hover { border-color: var(--tg-blue); color: var(--tg-blue); }

/* =============================================================
   WA BUTTON (hubungi customer)
   ============================================================= */
.btn-wa-full {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 16px;
    border-radius: 8px;
    background: #25D366;
    color: #fff;
    font-size: .83rem;
    font-weight: 600;
    text-decoration: none;
    line-height: 1;
    transition: background .15s;
}
.btn-wa-full:hover { background: #1ebe5d; color: #fff; }
.btn-wa-full .bi { font-size: .9rem !important; }

/* =============================================================
   DELIVERY STATUS BADGE
   ============================================================= */
.delivery-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: .72rem;
    font-weight: 700;
    padding: 4px 11px;
    border-radius: 100px;
    line-height: 1.2;
}

/* =============================================================
   EMPTY STATES
   ============================================================= */
.empty-box {
    text-align: center;
    padding: 24px 16px;
    color: var(--tg-text-3);
}
.empty-box .bi { font-size: 2rem !important; opacity: .25; display: block; margin-bottom: 10px; }
.empty-box span { font-size: .82rem; }

/* =============================================================
   SECTION LABEL
   ============================================================= */
.section-label {
    font-size: .63rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .1em;
    color: var(--tg-text-3); margin-bottom: 10px;
}
</style>
@endsection

@section('content')

@php
    $statusLabel = match($order->status) {
        'pending'   => 'Pending',
        'confirmed' => 'Dikonfirmasi',
        'completed' => 'Selesai',
        'cancelled' => 'Dibatalkan',
        default     => ucfirst($order->status),
    };
    $statusIcon = match($order->status) {
        'pending'   => 'bi-clock',
        'confirmed' => 'bi-check-circle',
        'completed' => 'bi-camera',
        'cancelled' => 'bi-x-circle',
        default     => 'bi-circle',
    };
    // Format nomor WA
    $rawPhone = preg_replace('/\D/', '', $order->user->phone ?? '');
    $waNumber = $rawPhone ? (str_starts_with($rawPhone, '0') ? '62' . substr($rawPhone, 1) : $rawPhone) : null;
    $waMsg    = urlencode('Halo ' . ($order->user->name ?? 'Kak') . ', kami dari Telegrad ingin menghubungi Anda terkait Order #' . str_pad($order->id, 5, '0', STR_PAD_LEFT) . '.');
@endphp

{{-- ══ TOP BAR ══ --}}
<div class="show-topbar">
    <div class="show-topbar-left">
        <span class="tg-badge tg-badge-{{ $order->status }}">
            <i class="bi {{ $statusIcon }}"></i>{{ $statusLabel }}
        </span>
        <span class="order-id-text">Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
        @if($waNumber)
        <a href="https://wa.me/{{ $waNumber }}?text={{ $waMsg }}" target="_blank" class="btn-wa-full">
            <i class="bi bi-whatsapp"></i> Hubungi Customer
        </a>
        @endif
    </div>
    <a href="{{ route('orders.index') }}" class="action-btn action-btn-back">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row g-3">

{{-- ══════════════ LEFT COL ══════════════ --}}
<div class="col-lg-8">

    {{-- ── Timeline / Cancelled alert ── --}}
    @if($order->status !== 'cancelled')
    @php
        $tlSteps = [
            ['key' => 'pending',   'lbl' => 'Dipesan',      'ic' => 'bi-inbox'],
            ['key' => 'confirmed', 'lbl' => 'Dikonfirmasi', 'ic' => 'bi-check-circle'],
            ['key' => 'completed', 'lbl' => 'Selesai',      'ic' => 'bi-camera'],
        ];
        $statusOrder = ['pending' => 0, 'confirmed' => 1, 'completed' => 2];
        $curIdx = $statusOrder[$order->status] ?? 0;
    @endphp
    <div class="detail-card">
        <div class="detail-card-body" style="padding: 16px 24px;">
            <div class="tg-timeline">
                @foreach($tlSteps as $step)
                @php
                    $stepIdx = $statusOrder[$step['key']] ?? 0;
                    $cls = $stepIdx < $curIdx ? 'done' : ($stepIdx === $curIdx ? 'active' : '');
                @endphp
                <div class="tg-tl-step {{ $cls }}">
                    <div class="tg-tl-icon">
                        @if($cls === 'done')
                            <i class="bi bi-check-lg"></i>
                        @else
                            <i class="bi {{ $step['ic'] }}"></i>
                        @endif
                    </div>
                    <div class="tg-tl-label">{{ $step['lbl'] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @else
    <div style="background:#FEE2E2; border:1px solid #FECACA; border-radius:10px; padding:12px 16px; margin-bottom:16px; display:flex; align-items:center; gap:9px;">
        <i class="bi bi-x-octagon-fill" style="color:#DC2626; font-size:1rem; flex-shrink:0;"></i>
        <span style="font-size:.84rem; color:#991B1B; font-weight:600;">Pesanan ini telah dibatalkan.</span>
    </div>
    @endif

    {{-- ── Detail Pesanan ── --}}
    <p class="section-label">Informasi Pesanan</p>
    <div class="detail-card">
        <div class="detail-card-head">
            <i class="bi bi-receipt" style="color:#2563EB;"></i>
            <h5 class="detail-card-title">Detail Pesanan</h5>
        </div>
        <div class="detail-card-body">
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
                    <p class="info-value" style="font-size:1.05rem; color:#2563EB;">
                        Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}
                    </p>
                </div>
                @if($order->notes)
                <div class="col-12">
                    <p class="info-label">Catatan Customer</p>
                    <div class="tg-notes">{{ $order->notes }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ── Fitur Paket ── --}}
    @if($order->package && $order->package->features)
    <div class="detail-card">
        <div class="detail-card-head">
            <i class="bi bi-check2-all" style="color:#2563EB;"></i>
            <h5 class="detail-card-title">Fitur Paket</h5>
        </div>
        <div class="detail-card-body" style="padding-top:8px; padding-bottom:8px;">
            @foreach(explode("\n", $order->package->features) as $feat)
                @if(trim($feat))
                <div class="feature-item">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>{{ trim($feat) }}</span>
                </div>
                @endif
            @endforeach
        </div>
    </div>
    @endif

    {{-- ── Tindakan ── --}}
    <div class="detail-card">
        <div class="detail-card-head">
            <i class="bi bi-lightning-charge" style="color:#2563EB;"></i>
            <h5 class="detail-card-title">Tindakan</h5>
        </div>
        <div class="detail-card-body">
            <div style="display:flex; flex-wrap:wrap; gap:8px;">

                @if($order->status === 'pending')
                <form action="{{ route('admin.orders.confirm', $order->id) }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="action-btn action-btn-success"
                            onclick="return confirm('Konfirmasi order ini?')">
                        <i class="bi bi-check-lg"></i> Konfirmasi Order
                    </button>
                </form>
                @endif

                @if($order->status === 'confirmed')
                <form action="{{ route('admin.orders.complete', $order->id) }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="action-btn action-btn-info"
                            onclick="return confirm('Tandai order ini selesai?')">
                        <i class="bi bi-camera"></i> Tandai Selesai
                    </button>
                </form>
                @if(!$order->delivery)
                <a href="{{ route('deliveries.create', ['order_id' => $order->id]) }}"
                   class="action-btn action-btn-primary">
                    <i class="bi bi-send"></i> Kirim Hasil Foto
                </a>
                @endif
                @endif

                @if(!in_array($order->status, ['completed', 'cancelled']))
                <form action="{{ route('admin.orders.cancel', $order->id) }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="action-btn action-btn-warn-ol"
                            onclick="return confirm('Batalkan order ini?')">
                        <i class="bi bi-x-lg"></i> Batalkan
                    </button>
                </form>
                @endif

                <form id="delete-form-{{ $order->id }}"
                      action="{{ route('orders.destroy', $order->id) }}" method="POST" class="m-0">
                    @csrf @method('DELETE')
                    <button type="button" class="action-btn action-btn-danger-ol"
                            onclick="deleteData({{ $order->id }})">
                        <i class="bi bi-trash3"></i> Hapus
                    </button>
                </form>

            </div>
        </div>
    </div>

</div>

{{-- ══════════════ RIGHT COL ══════════════ --}}
<div class="col-lg-4">

    {{-- ── Ringkasan Pesanan ── --}}
    <p class="section-label">Ringkasan</p>
    <div class="detail-card">
        <div class="detail-card-head-dark">
            <h5 class="detail-card-title-white">Ringkasan Pesanan</h5>
        </div>
        <div class="detail-card-body-sm">
            <div class="summary-row">
                <span class="s-lbl">Paket</span>
                <span class="s-val" style="font-size:.8rem; max-width:58%; text-align:right;">{{ $order->package->name ?? '-' }}</span>
            </div>
            @if($order->package && $order->package->duration)
            <div class="summary-row">
                <span class="s-lbl">Durasi</span>
                <span class="s-val">{{ $order->package->duration }} menit</span>
            </div>
            @endif
            <div class="summary-row">
                <span class="s-lbl">Tanggal</span>
                <span class="s-val">{{ \Carbon\Carbon::parse($order->booking_date)->isoFormat('D MMM YYYY') }}</span>
            </div>
            <div class="summary-row">
                <span class="s-lbl">Waktu</span>
                <span class="s-val">
                    {{ \Carbon\Carbon::parse($order->start_time)->format('H:i') }}–{{ \Carbon\Carbon::parse($order->end_time)->format('H:i') }}
                </span>
            </div>
            <div class="summary-row" style="border-top: 2px solid var(--tg-border); margin-top: 4px; padding-top: 12px;">
                <span class="s-lbl" style="font-weight:700; color:var(--tg-text);">Total</span>
                <span class="s-val" style="color:#2563EB; font-size:1.05rem;">
                    Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}
                </span>
            </div>
        </div>
    </div>

    {{-- ── Status Pembayaran ── --}}
    <p class="section-label">Pembayaran</p>
    <div class="detail-card">
        <div class="detail-card-head">
            <i class="bi bi-credit-card" style="color:#059669;"></i>
            <h5 class="detail-card-title">Status Pembayaran</h5>
        </div>
        <div class="detail-card-body">
            @if($order->payment)
            @php
                $ps    = $order->payment->payment_status ?? 'pending';
                $pData = match($ps) {
                    'verified' => ['#D1FAE5', '#065F46', 'Terverifikasi', 'bi-check-circle-fill'],
                    'rejected' => ['#FEE2E2', '#991B1B', 'Ditolak',       'bi-x-circle-fill'],
                    default    => ['#FEF3C7', '#92400E', 'Menunggu',      'bi-clock-fill'],
                };
            @endphp
            <div class="pay-status-box" style="background:{{ $pData[0] }};">
                <i class="bi {{ $pData[3] }}" style="color:{{ $pData[1] }};"></i>
                <span style="color:{{ $pData[1] }};">{{ $pData[2] }}</span>
            </div>
            <div class="row g-2">
                <div class="col-6">
                    <p class="info-label">Jumlah</p>
                    <p class="info-value">Rp {{ number_format($order->payment->amount ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="col-6">
                    <p class="info-label">Metode</p>
                    <p class="info-value" style="text-transform:capitalize;">{{ $order->payment->payment_method ?? '-' }}</p>
                </div>
                <div class="col-12">
                    <p class="info-label">Tanggal Bayar</p>
                    <p class="info-value" style="font-size:.8rem;">
                        {{ \Carbon\Carbon::parse($order->payment->created_at)->isoFormat('D MMMM YYYY, HH:mm') }}
                    </p>
                </div>
            </div>
            @if($order->payment->payment_proof)
            <div style="margin-top:14px;">
                <p class="info-label" style="margin-bottom:7px;">Bukti Pembayaran</p>
                <img src="{{ asset('storage/' . $order->payment->payment_proof) }}"
                     class="proof-img" alt="Bukti Bayar"
                     onclick="window.open(this.src)">
                <p style="font-size:.7rem; color:var(--tg-text-3); margin-top:5px; text-align:center;">
                    Klik untuk perbesar
                </p>
            </div>
            @endif
            @else
            <div class="empty-box">
                <i class="bi bi-receipt"></i>
                <span>Belum ada pembayaran</span>
            </div>
            @endif
        </div>
    </div>

    {{-- ── Hasil Foto ── --}}
    <div class="detail-card">
        <div class="detail-card-head">
            <i class="bi bi-images" style="color:#2563EB;"></i>
            <h5 class="detail-card-title">Hasil Foto</h5>
        </div>
        <div class="detail-card-body">
            @if($order->delivery)
            @php
                $ds    = $order->delivery->status ?? '-';
                $dData = match($ds) {
                    'delivered' => ['#DBEAFE', '#1E40AF', 'Dikirim'],
                    'completed' => ['#D1FAE5', '#065F46', 'Selesai'],
                    'editing'   => ['#FEF3C7', '#92400E', 'Editing'],
                    default     => ['#F3F4F6', '#6B7280', ucfirst($ds)],
                };
            @endphp
            <div style="margin-bottom:12px;">
                <p class="info-label">Status Pengiriman</p>
                <span class="delivery-badge" style="background:{{ $dData[0] }}; color:{{ $dData[1] }};">
                    {{ $dData[2] }}
                </span>
            </div>
            @if($order->delivery->delivery_date)
            <div style="margin-bottom:12px;">
                <p class="info-label">Tanggal Kirim</p>
                <p class="info-value" style="font-size:.83rem;">
                    {{ \Carbon\Carbon::parse($order->delivery->delivery_date)->isoFormat('D MMMM YYYY') }}
                </p>
            </div>
            @endif
            @if($order->delivery->delivery_link)
            <a href="{{ $order->delivery->delivery_link }}" target="_blank"
               class="action-btn action-btn-success" style="width:100%; justify-content:center;">
                <i class="bi bi-google"></i> Buka Google Drive
            </a>
            @endif
            @else
            <div class="empty-box">
                <i class="bi bi-images"></i>
                <span>Belum ada pengiriman</span>
            </div>
            @if($order->status === 'confirmed')
            <a href="{{ route('deliveries.create', ['order_id' => $order->id]) }}"
               class="action-btn action-btn-primary" style="width:100%; justify-content:center; margin-top:10px;">
                <i class="bi bi-send"></i> Kirim Hasil
            </a>
            @endif
            @endif
        </div>
    </div>

</div>
</div>

@endsection