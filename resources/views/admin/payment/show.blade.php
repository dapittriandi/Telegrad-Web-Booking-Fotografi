@extends('base.base-admin-index')

@php
    $menu    = 'Pembayaran';
    $submenu = 'Detail Pembayaran';
    $subdesc = 'Transaksi #' . str_pad($payment->id, 5, '0', STR_PAD_LEFT);
@endphp

@section('custom-css')
<style>
@font-face {
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
    font-display: block;
    src: url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/webfonts/fa-solid-900.woff2") format("woff2");
}
.fa-solid, .fas { font-family: "Font Awesome 6 Free" !important; font-weight: 900 !important; }

/* ── Section Label ── */
.section-label {
    font-size: .63rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .1em;
    color: var(--tg-text-3); margin-bottom: 10px;
}

/* ── Cards ── */
.det-card {
    border: 1px solid var(--tg-glass-border) !important;
    border-radius: 14px !important;
    box-shadow: var(--tg-sh-sm) !important;
    background: var(--tg-glass) !important;
    backdrop-filter: var(--tg-blur) !important;
    overflow: hidden;
}
.det-card-head {
    display: flex; align-items: center; gap: 10px;
    padding: 14px 20px;
    border-bottom: 1px solid var(--tg-border);
}
.det-card-head h6 {
    font-size: .88rem; font-weight: 700;
    color: var(--tg-text); margin: 0;
    display: flex; align-items: center; gap: 8px;
}
.det-card-body { padding: 20px; }

/* ── Info rows ── */
.info-label {
    font-size: .63rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .08em;
    color: var(--tg-text-3); margin-bottom: 5px;
}
.info-value {
    font-size: .88rem; font-weight: 600;
    color: var(--tg-text); margin: 0; line-height: 1.4;
}
.info-sub {
    font-size: .76rem; color: var(--tg-text-3);
    margin: 3px 0 0; line-height: 1.4;
}

/* ── Divider row ── */
.info-divider {
    border: none;
    border-top: 1px solid var(--tg-border);
    margin: 4px 0;
}

/* ── Badges ── */
.tg-badge {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: .72rem; font-weight: 700;
    padding: 4px 12px; border-radius: 100px;
    line-height: 1.3; white-space: nowrap;
}
.tg-badge-verified { background: #D1FAE5; color: #065F46; }
.tg-badge-rejected { background: #FEE2E2; color: #991B1B; }
.tg-badge-pending  { background: #FEF3C7; color: #92400E; }
.tg-badge-confirmed{ background: #DBEAFE; color: #1E40AF; }
.tg-badge-completed{ background: #D1FAE5; color: #065F46; }
.tg-badge-cancelled{ background: #FEE2E2; color: #991B1B; }

[data-theme="dark"] .tg-badge-verified  { background: rgba(209,250,229,.12); color: #6EE7B7; }
[data-theme="dark"] .tg-badge-rejected  { background: rgba(254,226,226,.12); color: #FCA5A5; }
[data-theme="dark"] .tg-badge-pending   { background: rgba(254,243,199,.15); color: #FCD34D; }
[data-theme="dark"] .tg-badge-confirmed { background: rgba(219,234,254,.12); color: #93C5FD; }

/* ── Proof image card ── */
.proof-img-wrap {
    padding: 16px;
    text-align: center;
}
.proof-img {
    max-width: 100%; max-height: 320px;
    object-fit: contain;
    border-radius: 12px;
    cursor: zoom-in;
    transition: transform .2s, box-shadow .2s;
    box-shadow: 0 2px 12px rgba(0,0,0,.1);
}
.proof-img:hover {
    transform: scale(1.02);
    box-shadow: 0 6px 24px rgba(0,0,0,.18);
}
.proof-hint {
    font-size: .71rem; color: var(--tg-text-3);
    margin-top: 8px;
    display: flex; align-items: center; justify-content: center; gap: 5px;
}
.proof-empty {
    padding: 40px 20px; text-align: center;
    color: var(--tg-text-3);
}
.proof-empty i { font-size: 2.2rem; opacity: .2; display: block; margin-bottom: 10px; }
.proof-empty span { font-size: .84rem; }

/* ── Action buttons ── */
.action-card-body {
    padding: 16px;
    display: flex; flex-direction: column; gap: 10px;
}
.btn-verify {
    background: linear-gradient(135deg, #059669, #10B981) !important;
    border: none !important;
    color: #fff !important;
    font-weight: 600 !important;
    font-size: .86rem !important;
    border-radius: 10px !important;
    padding: 10px 16px !important;
    width: 100%;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    transition: opacity .15s, transform .15s;
    cursor: pointer;
}
.btn-verify:hover { opacity: .9; transform: translateY(-1px); }

.btn-reject {
    background: none !important;
    border: 1.5px solid #EF4444 !important;
    color: #EF4444 !important;
    font-weight: 600 !important;
    font-size: .86rem !important;
    border-radius: 10px !important;
    padding: 10px 16px !important;
    width: 100%;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    transition: background .15s, color .15s, transform .15s;
    cursor: pointer;
}
.btn-reject:hover {
    background: #FEE2E2 !important;
    transform: translateY(-1px);
}

/* ── Timeline strip ── */
.timeline-strip {
    display: flex; align-items: center; gap: 0;
    margin: 0 0 20px;
    border-radius: 12px; overflow: hidden;
    border: 1px solid var(--tg-glass-border);
}
.timeline-step {
    flex: 1; padding: 10px 6px; text-align: center;
    font-size: .67rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em;
    color: var(--tg-text-3);
    background: var(--tg-glass);
    position: relative;
    transition: background .2s;
}
.timeline-step.done {
    background: rgba(5,150,105,.1);
    color: #059669;
}
.timeline-step.active {
    background: linear-gradient(135deg, rgba(37,99,235,.15), rgba(37,99,235,.08));
    color: #2563EB;
}
.timeline-step.danger {
    background: rgba(239,68,68,.08);
    color: #EF4444;
}
.timeline-step:not(:last-child)::after {
    content: '';
    position: absolute; right: 0; top: 50%; transform: translateY(-50%);
    width: 1px; height: 60%;
    background: var(--tg-border);
}

/* ── Amount highlight ── */
.amount-big {
    font-size: 1.4rem; font-weight: 800;
    color: #2563EB; letter-spacing: -.02em;
}

/* ── Back button ── */
.back-btn {
    display: inline-flex; align-items: center; gap: 7px;
    font-size: .78rem; font-weight: 600;
    color: var(--tg-text-2);
    background: var(--tg-glass);
    border: 1px solid var(--tg-glass-border);
    padding: 6px 14px;
    border-radius: 9px;
    text-decoration: none;
    transition: background .15s, transform .15s;
    box-shadow: var(--tg-sh-sm);
}
.back-btn:hover {
    background: var(--tg-glass-border);
    color: var(--tg-text);
    transform: translateX(-2px);
}
</style>
@endsection

@section('content')

@php
    $ps   = $payment->payment_status ?? 'pending';
    $pill = match($ps) {
        'verified' => ['cls'=>'tg-badge-verified', 'lbl'=>'Terverifikasi',       'ico'=>'fa-circle-check'],
        'rejected' => ['cls'=>'tg-badge-rejected', 'lbl'=>'Ditolak',             'ico'=>'fa-circle-xmark'],
        default    => ['cls'=>'tg-badge-pending',  'lbl'=>'Menunggu Verifikasi', 'ico'=>'fa-clock'],
    };
@endphp

{{-- ── Top bar ── --}}
<div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
    <div style="display:flex;align-items:center;gap:10px;">
        <span class="tg-badge {{ $pill['cls'] }}">
            <i class="fa-solid {{ $pill['ico'] }}"></i>
            {{ $pill['lbl'] }}
        </span>
        <span style="font-size:.8rem;color:var(--tg-text-3);">
            Transaksi #{{ str_pad($payment->id,5,'0',STR_PAD_LEFT) }}
        </span>
    </div>
    <a href="{{ route('payments.index') }}" class="back-btn">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
</div>

{{-- ── Timeline strip ── --}}
<div class="timeline-strip mb-4">
    <div class="timeline-step done">
        <i class="fa-solid fa-file-invoice" style="display:block;font-size:.9rem;margin-bottom:3px;"></i>
        Order Dibuat
    </div>
    <div class="timeline-step done">
        <i class="fa-solid fa-upload" style="display:block;font-size:.9rem;margin-bottom:3px;"></i>
        Bukti Dikirim
    </div>
    <div class="timeline-step {{ $ps === 'verified' ? 'done' : ($ps === 'rejected' ? 'danger' : 'active') }}">
        <i class="fa-solid {{ $ps === 'verified' ? 'fa-circle-check' : ($ps === 'rejected' ? 'fa-circle-xmark' : 'fa-spinner') }}"
           style="display:block;font-size:.9rem;margin-bottom:3px;"></i>
        {{ $ps === 'verified' ? 'Terverifikasi' : ($ps === 'rejected' ? 'Ditolak' : 'Review Admin') }}
    </div>
    <div class="timeline-step {{ $ps === 'verified' ? 'done' : '' }}">
        <i class="fa-solid fa-camera" style="display:block;font-size:.9rem;margin-bottom:3px;"></i>
        Sesi Foto
    </div>
</div>

<div class="row g-3">

    {{-- ══ KIRI: Detail ══ --}}
    <div class="col-lg-8">

        {{-- Order Info --}}
        <p class="section-label">Informasi Order</p>
        <div class="det-card mb-3">
            <div class="det-card-head">
                <h6>
                    <i class="fa-solid fa-cart-shopping" style="color:#2563EB;"></i>
                    Detail Order
                </h6>
            </div>
            <div class="det-card-body">
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
                    <div class="col-12"><hr class="info-divider"></div>
                    <div class="col-md-6">
                        <p class="info-label">Tanggal Booking</p>
                        <p class="info-value">
                            {{ $payment->order->booking_date
                                ? \Carbon\Carbon::parse($payment->order->booking_date)->isoFormat('dddd, D MMMM YYYY')
                                : '-' }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="info-label">Waktu Sesi</p>
                        <p class="info-value">
                            {{ $payment->order->start_time
                                ? \Carbon\Carbon::parse($payment->order->start_time)->format('H:i') . ' WIB'
                                : '-' }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p class="info-label">Lokasi</p>
                        <p class="info-value">{{ $payment->order->location ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="info-label">Status Order</p>
                        @php
                            $oc = match($payment->order->status ?? 'pending') {
                                'confirmed' => 'tg-badge-confirmed',
                                'completed' => 'tg-badge-completed',
                                'cancelled' => 'tg-badge-cancelled',
                                default     => 'tg-badge-pending',
                            };
                            $olbl = match($payment->order->status ?? 'pending') {
                                'confirmed' => 'Dikonfirmasi',
                                'completed' => 'Selesai',
                                'cancelled' => 'Dibatalkan',
                                default     => 'Pending',
                            };
                        @endphp
                        <span class="tg-badge {{ $oc }}">{{ $olbl }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Payment Info --}}
        <p class="section-label">Informasi Pembayaran</p>
        <div class="det-card">
            <div class="det-card-head">
                <h6>
                    <i class="fa-solid fa-credit-card" style="color:#059669;"></i>
                    Detail Transaksi
                </h6>
            </div>
            <div class="det-card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <p class="info-label">Jumlah Bayar</p>
                        <p class="amount-big">Rp {{ number_format($payment->amount ?? 0,0,',','.') }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="info-label">Metode Pembayaran</p>
                        <p class="info-value" style="text-transform:capitalize;">
                            {{ $payment->payment_method ?? '-' }}
                        </p>
                    </div>
                    <div class="col-12"><hr class="info-divider"></div>
                    <div class="col-md-6">
                        <p class="info-label">Status Pembayaran</p>
                        <span class="tg-badge {{ $pill['cls'] }}">
                            <i class="fa-solid {{ $pill['ico'] }}"></i>
                            {{ $pill['lbl'] }}
                        </span>
                    </div>
                    <div class="col-md-6">
                        <p class="info-label">Waktu Pembayaran</p>
                        <p class="info-value">
                            {{ \Carbon\Carbon::parse($payment->created_at)->isoFormat('D MMMM YYYY, HH:mm') }} WIB
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ══ KANAN: Bukti + Aksi ══ --}}
    <div class="col-lg-4 d-flex flex-column gap-3">

        {{-- Bukti --}}
        <div>
            <p class="section-label">Bukti Pembayaran</p>
            <div class="det-card">
                <div class="det-card-head">
                    <h6>
                        <i class="fa-solid fa-image" style="color:#2563EB;"></i>
                        Bukti Transfer
                    </h6>
                </div>
                @if($payment->payment_proof)
                <div class="proof-img-wrap">
                    <img src="{{ asset('storage/'.$payment->payment_proof) }}"
                         alt="Bukti Pembayaran"
                         class="proof-img"
                         onclick="window.open(this.src,'_blank')">
                    <p class="proof-hint">
                        <i class="fa-solid fa-magnifying-glass-plus"></i>
                        Klik untuk memperbesar
                    </p>
                </div>
                @else
                <div class="proof-empty">
                    <i class="fa-solid fa-image"></i>
                    <span>Belum ada bukti pembayaran</span>
                </div>
                @endif
            </div>
        </div>

        {{-- Aksi Verifikasi --}}
        @if($ps === 'pending')
        <div>
            <p class="section-label">Tindakan</p>
            <div class="det-card">
                <div class="det-card-head">
                    <h6>
                        <i class="fa-solid fa-bolt" style="color:#F59E0B;"></i>
                        Verifikasi Pembayaran
                    </h6>
                </div>
                <div class="action-card-body">
                    <form action="{{ route('admin.payments.verify', $payment->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-verify"
                                onclick="return confirm('Verifikasi pembayaran ini?')">
                            <i class="fa-solid fa-circle-check"></i>
                            Verifikasi
                        </button>
                    </form>
                    <form action="{{ route('admin.payments.reject', $payment->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-reject"
                                onclick="return confirm('Tolak pembayaran ini?')">
                            <i class="fa-solid fa-circle-xmark"></i>
                            Tolak Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif

        {{-- Info card kalau sudah diproses --}}
        @if($ps !== 'pending')
        <div class="det-card">
            <div class="det-card-body">
                <div style="text-align:center;padding:8px 0;">
                    @if($ps === 'verified')
                    <div style="width:52px;height:52px;border-radius:50%;background:rgba(5,150,105,.12);display:inline-flex;align-items:center;justify-content:center;margin-bottom:12px;">
                        <i class="fa-solid fa-circle-check" style="color:#059669;font-size:1.4rem;"></i>
                    </div>
                    <p class="info-value" style="color:#059669;">Pembayaran Terverifikasi</p>
                    <p class="info-sub">Transaksi ini telah disetujui oleh admin</p>
                    @else
                    <div style="width:52px;height:52px;border-radius:50%;background:rgba(239,68,68,.08);display:inline-flex;align-items:center;justify-content:center;margin-bottom:12px;">
                        <i class="fa-solid fa-circle-xmark" style="color:#EF4444;font-size:1.4rem;"></i>
                    </div>
                    <p class="info-value" style="color:#EF4444;">Pembayaran Ditolak</p>
                    <p class="info-sub">Transaksi ini telah ditolak oleh admin</p>
                    @endif
                </div>
            </div>
        </div>
        @endif

    </div>
</div>

@endsection