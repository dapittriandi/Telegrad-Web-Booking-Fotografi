@extends('base.base-root-index')

@push('css')
<style>
:root {
    --gold:        #c8a96e;
    --gold-light:  #e2c98a;
    --gold-dim:    rgba(200,169,110,.12);
    --gold-border: rgba(200,169,110,.22);
    --bg-page:     #0b0c0e;
    --bg-card:     #16181c;
    --text:        #f0ede8;
    --muted:       #8a8880;
    --success:     #4caf82;
    --danger:      #e05c5c;
    --warning:     #e0a935;
    --info:        #5b9bd5;
    --radius:      14px;
    --trans:       .26s cubic-bezier(.4,0,.2,1);
}

body { background: var(--bg-page); }

/* ─── Page header ───────────────────────────────────────── */
.page-header {
    background: var(--bg-card);
    border-bottom: 1px solid rgba(255,255,255,.06);
    padding: 48px 0 28px;
}
.page-header-nav {
    display: flex; align-items: center; gap: 8px;
    font-size: .78rem; color: var(--muted); margin-bottom: 16px; flex-wrap: wrap;
}
.page-header-nav a { color: var(--muted); text-decoration: none; transition: color var(--trans); }
.page-header-nav a:hover { color: var(--gold); }
.page-header-nav i { font-size: .65rem; color: rgba(255,255,255,.2); }
.page-header-bottom {
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 12px;
}
.page-header-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.2rem, 2.5vw, 1.6rem);
    color: var(--text); font-weight: 700; margin: 0 0 4px;
}
.page-header-sub { font-size: .82rem; color: var(--muted); margin: 0; }

/* ─── Detail section ────────────────────────────────────── */
.detail-section { background: var(--bg-page); padding: 40px 0 80px; }

/* ─── Order header card ─────────────────────────────────── */
.order-header-card {
    background: var(--bg-card);
    border: 1px solid var(--gold-border);
    border-radius: var(--radius); overflow: hidden; margin-bottom: 20px;
}
.order-header-top {
    background: linear-gradient(135deg, #1a1408, #111);
    border-bottom: 1px solid var(--gold-border);
    padding: 22px 28px;
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 12px;
}
.order-num {
    font-family: 'Playfair Display', serif;
    font-size: 1.25rem; font-weight: 700; color: var(--text);
}
.order-created { font-size: .78rem; color: var(--muted); margin-top: 3px; display: flex; align-items: center; gap: 5px; }
.order-created i { color: var(--gold); }

/* ─── Progress timeline ─────────────────────────────────── */
.progress-track {
    padding: 24px 28px;
    display: flex; align-items: flex-start; gap: 0;
    overflow-x: auto; /* scroll di mobile agar tidak tumpang tindih */
}
.prog-step {
    flex: 1; min-width: 80px; text-align: center;
    display: flex; flex-direction: column; align-items: center;
    position: relative;
}
.prog-step::before {
    content: ''; position: absolute; top: 14px; left: calc(50% + 16px);
    width: calc(100% - 32px); height: 2px;
    background: rgba(255,255,255,.08);
}
.prog-step:last-child::before { display: none; }
.prog-step.done::before { background: var(--gold-border); }
.prog-icon {
    width: 30px; height: 30px; border-radius: 50%;
    border: 2px solid rgba(255,255,255,.1);
    background: #111; display: flex; align-items: center; justify-content: center;
    font-size: .8rem; color: var(--muted);
    position: relative; z-index: 1; margin-bottom: 8px;
    transition: all var(--trans);
}
.prog-step.done   .prog-icon { border-color: var(--success); background: rgba(76,175,130,.15); color: var(--success); }
.prog-step.active .prog-icon { border-color: var(--gold); background: var(--gold-dim); color: var(--gold); }
.prog-label { font-size: .67rem; font-weight: 600; letter-spacing: .06em; text-transform: uppercase; color: var(--muted); }
.prog-step.done   .prog-label { color: var(--success); }
.prog-step.active .prog-label { color: var(--gold-light); }

/* ─── Info cards ────────────────────────────────────────── */
.info-card {
    background: var(--bg-card);
    border: 1px solid rgba(255,255,255,.07);
    border-radius: var(--radius); overflow: hidden; margin-bottom: 20px;
    transition: border-color var(--trans);
}
.info-card:hover { border-color: var(--gold-border); }
.info-card-head {
    padding: 16px 22px; border-bottom: 1px solid rgba(255,255,255,.06);
    display: flex; align-items: center; gap: 10px;
}
.info-card-icon {
    width: 34px; height: 34px;
    background: var(--gold-dim); border: 1px solid var(--gold-border);
    border-radius: 9px; display: flex; align-items: center; justify-content: center;
    color: var(--gold); font-size: .85rem; flex-shrink: 0;
}
.info-card-head h5 {
    font-family: 'Playfair Display', serif;
    font-size: .95rem; font-weight: 700; color: var(--text); margin: 0;
}
.info-card-body { padding: 18px 22px; }

.detail-row {
    display: flex; justify-content: space-between; align-items: flex-start;
    gap: 12px; padding: 10px 0;
    border-bottom: 1px solid rgba(255,255,255,.05); font-size: .84rem;
}
.detail-row:last-child { border-bottom: none; padding-bottom: 0; }
.detail-key { color: var(--muted); display: flex; align-items: center; gap: 7px; flex-shrink: 0; }
.detail-key i { color: var(--gold); width: 14px; }
.detail-val { color: var(--text); font-weight: 500; text-align: right; }

/* ─── Status badges ─────────────────────────────────────── */
.status-badge {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: .68rem; font-weight: 700;
    padding: 4px 12px; border-radius: 100px;
    text-transform: uppercase; letter-spacing: .06em;
}
.s-pending   { background: rgba(224,169,53,.1); border: 1px solid rgba(224,169,53,.25); color: var(--warning); }
.s-confirmed { background: rgba(91,155,213,.1); border: 1px solid rgba(91,155,213,.25); color: var(--info); }
.s-completed { background: rgba(76,175,130,.1); border: 1px solid rgba(76,175,130,.25); color: var(--success); }
.s-cancelled { background: rgba(224,92,92,.1);  border: 1px solid rgba(224,92,92,.25);  color: var(--danger); }
.pay-verified{ background: rgba(76,175,130,.1); border: 1px solid rgba(76,175,130,.25); color: var(--success); }
.pay-rejected{ background: rgba(224,92,92,.1);  border: 1px solid rgba(224,92,92,.25);  color: var(--danger); }
.pay-pending { background: rgba(224,169,53,.1); border: 1px solid rgba(224,169,53,.25); color: var(--warning); }

/* ─── Sidebar summary ───────────────────────────────────── */
.sidebar-summary {
    background: var(--bg-card);
    border: 1px solid var(--gold-border);
    border-radius: var(--radius); overflow: hidden;
    position: sticky; top: 90px;
}
@media(max-width:992px) { .sidebar-summary { position: static; } }

.ss-head {
    background: linear-gradient(135deg, #1a1408, #111);
    border-bottom: 1px solid var(--gold-border);
    padding: 20px 22px; text-align: center;
}
.ss-label { font-size: .67rem; font-weight: 700; letter-spacing: .15em; text-transform: uppercase; color: var(--muted); margin-bottom: 4px; }
.ss-name  { font-family: 'Playfair Display', serif; font-size: 1.05rem; font-weight: 700; color: var(--text); line-height: 1.3; }
.ss-cat   { font-size: .75rem; color: var(--gold); margin-top: 4px; }
.ss-body  { padding: 18px 22px; }

.ss-row {
    display: flex; justify-content: space-between;
    gap: 10px; padding: 9px 0;
    border-bottom: 1px solid rgba(255,255,255,.05); font-size: .82rem;
}
.ss-row:last-of-type { border-bottom: none; }
.ss-key { color: var(--muted); display: flex; align-items: center; gap: 7px; }
.ss-key i { color: var(--gold); width: 14px; }
.ss-val { color: var(--text); font-weight: 500; text-align: right; }

.ss-total {
    background: rgba(200,169,110,.06); border: 1px solid var(--gold-border);
    border-radius: 10px; padding: 14px 18px;
    display: flex; justify-content: space-between; align-items: center;
    margin-top: 14px;
}
.ss-total-label { font-size: .72rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--muted); }
.ss-total-price { font-family: 'Playfair Display', serif; font-size: 1.3rem; font-weight: 800; color: var(--gold-light); }

.btn-action-gold {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    width: 100%; padding: 12px 0; font-size: .82rem; font-weight: 700;
    letter-spacing: .07em; text-transform: uppercase;
    color: #0d0d0d; background: var(--gold);
    border-radius: 10px; text-decoration: none; border: none; cursor: pointer;
    transition: background var(--trans), transform var(--trans); margin-top: 12px;
}
.btn-action-gold:hover { background: var(--gold-light); color: #0d0d0d; transform: translateY(-2px); }

.btn-action-outline {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    width: 100%; padding: 11px 0; font-size: .82rem; font-weight: 600;
    color: var(--gold); border: 1px solid var(--gold-border);
    border-radius: 10px; text-decoration: none;
    transition: background var(--trans); margin-top: 8px;
}
.btn-action-outline:hover { background: var(--gold-dim); color: var(--gold-light); }

/* ─── Notes / Delivery / Misc ───────────────────────────── */
.notes-box {
    background: rgba(255,255,255,.03); border: 1px solid rgba(255,255,255,.08);
    border-radius: 10px; padding: 14px 18px;
    font-size: .84rem; color: var(--muted); line-height: 1.7; font-style: italic;
}
.delivery-box {
    background: rgba(76,175,130,.06); border: 1px solid rgba(76,175,130,.2);
    border-radius: 10px; padding: 18px 20px;
    display: flex; align-items: flex-start; gap: 14px;
}
.delivery-box i { color: var(--success); font-size: 1.3rem; flex-shrink: 0; margin-top: 2px; }
.d-title { font-weight: 700; color: var(--text); margin-bottom: 4px; font-size: .9rem; }
.d-link {
    display: inline-flex; align-items: center; gap: 6px;
    color: var(--success); text-decoration: none; font-size: .84rem; font-weight: 600;
    transition: color var(--trans);
}
.d-link:hover { color: #6fdfaa; }

/* ─── Proof image ───────────────────────────────────────── */
.proof-img-wrap {
    border-radius: 10px; overflow: hidden;
    border: 1px solid var(--gold-border); background: #0a0a0a; margin-top: 14px;
}
.proof-img-wrap img { width: 100%; max-height: 300px; object-fit: contain; display: block; }

/* ─── Rating ────────────────────────────────────────────── */
.star-input { display: flex; flex-direction: row-reverse; gap: 6px; justify-content: flex-end; }
.star-input input { display: none; }
.star-input label { font-size: 1.8rem; color: rgba(255,255,255,.15); cursor: pointer; transition: color var(--trans); }
.star-input input:checked ~ label,
.star-input label:hover,
.star-input label:hover ~ label { color: var(--gold); }
.rating-display { display: flex; gap: 4px; }
.rating-display i { font-size: 1.1rem; }
.star-filled { color: var(--gold); }
.star-empty  { color: rgba(255,255,255,.15); }
.review-text {
    background: rgba(255,255,255,.03); border: 1px solid rgba(255,255,255,.08);
    border-radius: 10px; padding: 14px 18px;
    font-size: .85rem; color: var(--muted); line-height: 1.7; font-style: italic; margin-top: 12px;
}
.rating-submitted-box {
    background: rgba(76,175,130,.06); border: 1px solid rgba(76,175,130,.2); border-radius: 10px; padding: 20px;
}
.rating-form-textarea {
    width: 100%; background: rgba(255,255,255,.04);
    border: 1px solid rgba(255,255,255,.1); border-radius: 10px;
    padding: 12px 16px; font-size: .875rem; color: var(--text);
    outline: none; resize: vertical; min-height: 90px;
    transition: border-color var(--trans); margin-top: 16px;
}
.rating-form-textarea::placeholder { color: var(--muted); }
.rating-form-textarea:focus { border-color: var(--gold-border); }
.btn-rating-submit {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 11px 28px; font-size: .82rem; font-weight: 700;
    letter-spacing: .07em; text-transform: uppercase;
    color: #0d0d0d; background: var(--gold);
    border: none; border-radius: 10px; cursor: pointer;
    transition: background var(--trans), transform var(--trans);
}
.btn-rating-submit:hover { background: var(--gold-light); transform: translateY(-2px); }
.skip-rating-link { font-size: .78rem; color: var(--muted); text-decoration: none; transition: color var(--trans); }
.skip-rating-link:hover { color: var(--gold); }
</style>
@endpush

@section('content')
<main id="main">

{{-- ─── PAGE HEADER (tanpa background gambar) ─────────────── --}}
<div class="page-header">
    <div class="container">
        <div class="page-header-nav">
            <a href="{{ route('home') }}">Beranda</a>
            <i class="bi bi-chevron-right"></i>
            <a href="{{ route('customer.orders') }}">My Orders</a>
            <i class="bi bi-chevron-right"></i>
            <span style="color:var(--text);">Detail Pesanan</span>
        </div>
        <div class="page-header-bottom">
            <div>
                <div class="page-header-title">Detail Pesanan</div>
                <div class="page-header-sub">
                    Order #{{ str_pad($order->id,5,'0',STR_PAD_LEFT) }}
                    &nbsp;·&nbsp;
                    {{ \Carbon\Carbon::parse($order->created_at)->isoFormat('D MMMM YYYY') }}
                </div>
            </div>
            <a href="{{ route('customer.orders') }}"
               style="display:inline-flex;align-items:center;gap:7px;padding:9px 20px;border-radius:10px;font-size:.8rem;font-weight:600;color:var(--muted);border:1px solid rgba(255,255,255,.1);text-decoration:none;transition:all var(--trans);"
               onmouseover="this.style.borderColor='var(--gold-border)';this.style.color='var(--gold)'"
               onmouseout="this.style.borderColor='rgba(255,255,255,.1)';this.style.color='var(--muted)'">
                <i class="bi bi-arrow-left" style="font-size:13px;"></i> Kembali
            </a>
        </div>
    </div>
</div>

<section class="detail-section">
    <div class="container">

        {{-- Flash --}}
        @if(session('success'))
        <div style="background:rgba(76,175,130,.08);border:1px solid rgba(76,175,130,.25);border-radius:10px;padding:12px 18px;font-size:.82rem;color:#5dcaa5;display:flex;align-items:center;gap:10px;margin-bottom:24px;">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            <button onclick="this.parentElement.remove()" style="margin-left:auto;background:none;border:none;color:inherit;cursor:pointer;font-size:1rem;">&times;</button>
        </div>
        @endif
        @if(session('error'))
        <div style="background:rgba(224,92,92,.08);border:1px solid rgba(224,92,92,.25);border-radius:10px;padding:12px 18px;font-size:.82rem;color:#f08080;display:flex;align-items:center;gap:10px;margin-bottom:24px;">
            <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
            <button onclick="this.parentElement.remove()" style="margin-left:auto;background:none;border:none;color:inherit;cursor:pointer;font-size:1rem;">&times;</button>
        </div>
        @endif

        <div class="row g-4 align-items-start">

            {{-- ─── LEFT col ─── --}}
            <div class="col-lg-8">

                {{-- Order header + progress --}}
                @php
                    $statusMap = [
                        'pending'   => ['class'=>'s-pending',   'icon'=>'bi-hourglass-split', 'label'=>'Menunggu'],
                        'confirmed' => ['class'=>'s-confirmed', 'icon'=>'bi-check-circle',    'label'=>'Dikonfirmasi'],
                        'completed' => ['class'=>'s-completed', 'icon'=>'bi-camera-fill',     'label'=>'Selesai'],
                        'cancelled' => ['class'=>'s-cancelled', 'icon'=>'bi-x-circle',        'label'=>'Dibatalkan'],
                    ];
                    $st     = $statusMap[$order->status] ?? $statusMap['pending'];
                    $steps  = ['pending','confirmed','completed'];
                    $curIdx = array_search($order->status, $steps);
                    if ($curIdx === false) $curIdx = -1;
                @endphp

                <div class="order-header-card" data-aos="fade-right">
                    <div class="order-header-top">
                        <div>
                            <div class="order-num">Order #{{ str_pad($order->id,5,'0',STR_PAD_LEFT) }}</div>
                            <div class="order-created">
                                <i class="bi bi-calendar3"></i>
                                Dipesan {{ \Carbon\Carbon::parse($order->created_at)->isoFormat('D MMMM YYYY, HH:mm') }} WIB
                            </div>
                        </div>
                        <span class="status-badge {{ $st['class'] }}">
                            <i class="bi {{ $st['icon'] }}"></i> {{ $st['label'] }}
                        </span>
                    </div>

                    @if($order->status !== 'cancelled')
                    <div class="progress-track">
                        @foreach(['pending'=>'Dipesan','confirmed'=>'Dikonfirmasi','completed'=>'Selesai'] as $key => $lbl)
                        @php
                            $idx = array_search($key, $steps);
                            $cls = $idx < $curIdx ? 'done' : ($idx == $curIdx ? 'active' : '');
                        @endphp
                        <div class="prog-step {{ $cls }}">
                            <div class="prog-icon">
                                @if($cls == 'done') <i class="bi bi-check"></i>
                                @elseif($key == 'pending') <i class="bi bi-hourglass-split"></i>
                                @elseif($key == 'confirmed') <i class="bi bi-check-circle"></i>
                                @else <i class="bi bi-camera-fill"></i>
                                @endif
                            </div>
                            <div class="prog-label">{{ $lbl }}</div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                {{-- Detail Booking --}}
                <div class="info-card" data-aos="fade-up">
                    <div class="info-card-head">
                        <div class="info-card-icon"><i class="bi bi-calendar-event"></i></div>
                        <h5>Detail Booking</h5>
                    </div>
                    <div class="info-card-body">
                        <div class="detail-row">
                            <span class="detail-key"><i class="bi bi-box"></i> Paket</span>
                            <span class="detail-val">{{ $order->package->name ?? '-' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-key"><i class="bi bi-tag"></i> Kategori</span>
                            <span class="detail-val">{{ $order->package->category->name ?? '-' }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-key"><i class="bi bi-calendar3"></i> Tanggal</span>
                            <span class="detail-val">{{ \Carbon\Carbon::parse($order->booking_date)->isoFormat('dddd, D MMMM YYYY') }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-key"><i class="bi bi-clock"></i> Waktu</span>
                            <span class="detail-val">
                                {{ \Carbon\Carbon::parse($order->start_time)->format('H:i') }} –
                                {{ \Carbon\Carbon::parse($order->end_time)->format('H:i') }} WIB
                            </span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-key"><i class="bi bi-hourglass"></i> Durasi</span>
                            <span class="detail-val">{{ $order->package->duration ?? '-' }} menit</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-key"><i class="bi bi-geo-alt"></i> Lokasi</span>
                            <span class="detail-val">{{ $order->location ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Catatan --}}
                @if($order->notes)
                <div class="info-card" data-aos="fade-up">
                    <div class="info-card-head">
                        <div class="info-card-icon"><i class="bi bi-chat-text"></i></div>
                        <h5>Catatan / Request</h5>
                    </div>
                    <div class="info-card-body">
                        <div class="notes-box">{{ $order->notes }}</div>
                    </div>
                </div>
                @endif

                {{-- Pembayaran --}}
                <div class="info-card" data-aos="fade-up">
                    <div class="info-card-head">
                        <div class="info-card-icon"><i class="bi bi-credit-card"></i></div>
                        <h5>Informasi Pembayaran</h5>
                    </div>
                    <div class="info-card-body">
                        @if($order->payment)
                            @php
                                $ps      = $order->payment->payment_status;
                                $psCls   = match($ps) { 'verified'=>'pay-verified','rejected'=>'pay-rejected',default=>'pay-pending' };
                                $psLabel = match($ps) { 'verified'=>'Terverifikasi','rejected'=>'Ditolak',default=>'Menunggu Verifikasi' };
                                $psIcon  = match($ps) { 'verified'=>'bi-check-circle-fill','rejected'=>'bi-x-circle-fill',default=>'bi-clock-history' };
                            @endphp
                            <div class="detail-row">
                                <span class="detail-key"><i class="bi bi-wallet2"></i> Metode</span>
                                <span class="detail-val" style="text-transform:capitalize;">{{ $order->payment->payment_method ?? '-' }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-key"><i class="bi bi-calendar-check"></i> Tgl. Bayar</span>
                                <span class="detail-val">
                                    {{ $order->payment->payment_date
                                        ? \Carbon\Carbon::parse($order->payment->payment_date)->isoFormat('D MMMM YYYY')
                                        : \Carbon\Carbon::parse($order->payment->created_at)->isoFormat('D MMMM YYYY') }}
                                </span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-key"><i class="bi bi-flag"></i> Status</span>
                                <span class="detail-val">
                                    <span class="status-badge {{ $psCls }}">
                                        <i class="bi {{ $psIcon }}"></i> {{ $psLabel }}
                                    </span>
                                </span>
                            </div>
                            @if($order->payment->payment_proof)
                            <div style="margin-top:4px;">
                                <div style="font-size:.72rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--muted);margin-bottom:8px;">Bukti Pembayaran</div>
                                <div class="proof-img-wrap">
                                    <img src="{{ asset('storage/' . $order->payment->payment_proof) }}" alt="Bukti pembayaran">
                                </div>
                            </div>
                            @endif
                            @if($ps === 'rejected')
                            <div style="margin-top:14px;background:rgba(224,92,92,.06);border:1px solid rgba(224,92,92,.2);border-radius:10px;padding:14px 18px;font-size:.82rem;color:#f08080;">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                Pembayaran kamu ditolak. Silakan upload ulang bukti pembayaran yang valid.
                                <a href="{{ route('customer.payment.create', $order->id) }}" style="color:var(--gold);display:inline-flex;align-items:center;gap:5px;margin-top:10px;font-weight:700;text-decoration:none;">
                                    <i class="bi bi-arrow-repeat"></i> Upload Ulang
                                </a>
                            </div>
                            @endif
                        @else
                            <div style="text-align:center;padding:28px 0;color:var(--muted);font-size:.85rem;">
                                <i class="bi bi-credit-card" style="font-size:2rem;color:var(--gold-border);display:block;margin-bottom:10px;"></i>
                                Belum ada pembayaran.
                                @if($order->status !== 'cancelled')
                                <div style="margin-top:14px;">
                                    <a href="{{ route('customer.payment.create', $order->id) }}"
                                       style="display:inline-flex;align-items:center;gap:7px;color:#0d0d0d;background:var(--gold);padding:10px 22px;border-radius:10px;font-size:.8rem;font-weight:700;text-decoration:none;letter-spacing:.07em;text-transform:uppercase;">
                                        <i class="bi bi-credit-card"></i> Bayar Sekarang
                                    </a>
                                </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Hasil Foto --}}
                @if($order->delivery ?? null)
                <div class="info-card" data-aos="fade-up">
                    <div class="info-card-head">
                        <div class="info-card-icon"><i class="bi bi-cloud-check"></i></div>
                        <h5>Hasil Foto</h5>
                    </div>
                    <div class="info-card-body">
                        <div class="delivery-box">
                            <i class="bi bi-cloud-arrow-down-fill"></i>
                            <div>
                                <div class="d-title">File foto siap diunduh!</div>
                                <p style="font-size:.82rem;color:var(--muted);line-height:1.6;margin-bottom:10px;">
                                    {{ $order->delivery->notes ?? 'File foto kamu sudah dikirim. Klik tombol di bawah untuk membuka link Google Drive.' }}
                                </p>
                                @if($order->delivery->delivery_link ?? null)
                                <a href="{{ $order->delivery->delivery_link }}" target="_blank" class="d-link">
                                    <i class="bi bi-box-arrow-up-right"></i> Buka Google Drive
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Rating --}}
                @if($order->status === 'completed')
                <div class="info-card" data-aos="fade-up">
                    <div class="info-card-head">
                        <div class="info-card-icon"><i class="bi bi-star-fill"></i></div>
                        <h5>Rating & Ulasan</h5>
                    </div>
                    <div class="info-card-body">
                        @if($order->rating)
                            <div class="rating-submitted-box">
                                <div style="font-size:.72rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--muted);margin-bottom:10px;">Ulasan Kamu</div>
                                <div class="rating-display mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star-fill {{ $i <= $order->rating->rating ? 'star-filled' : 'star-empty' }}"></i>
                                    @endfor
                                    <span style="font-size:.82rem;color:var(--muted);margin-left:8px;">{{ $order->rating->rating }}/5</span>
                                </div>
                                @if($order->rating->review)
                                    <div class="review-text">"{{ $order->rating->review }}"</div>
                                @endif
                                <div style="font-size:.74rem;color:var(--muted);margin-top:10px;">
                                    <i class="bi bi-clock me-1"></i>
                                    Dikirim {{ \Carbon\Carbon::parse($order->rating->created_at)->isoFormat('D MMMM YYYY') }}
                                </div>
                            </div>
                        @else
                            <div style="font-size:.85rem;color:var(--muted);margin-bottom:16px;line-height:1.7;">
                                Bagaimana pengalaman sesi foto kamu? Berikan rating untuk membantu kami berkembang.
                            </div>
                            <form action="{{ route('customer.rating.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <div style="font-size:.72rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--muted);margin-bottom:10px;">
                                    Pilih Bintang <span style="color:var(--danger);">*</span>
                                </div>
                                <div class="star-input">
                                    @for($i = 5; $i >= 1; $i--)
                                        <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" {{ old('rating') == $i ? 'checked' : '' }}>
                                        <label for="star{{ $i }}" title="{{ $i }} bintang"><i class="bi bi-star-fill"></i></label>
                                    @endfor
                                </div>
                                @error('rating')<div style="font-size:.74rem;color:var(--danger);margin-top:6px;">{{ $message }}</div>@enderror
                                <textarea name="review" class="rating-form-textarea"
                                          placeholder="Tulis ulasan kamu... (opsional)">{{ old('review') }}</textarea>
                                @error('review')<div style="font-size:.74rem;color:var(--danger);margin-top:4px;">{{ $message }}</div>@enderror
                                <div style="display:flex;align-items:center;flex-wrap:wrap;gap:8px;margin-top:14px;">
                                    <button type="submit" class="btn-rating-submit">
                                        <i class="bi bi-send-fill"></i> Kirim Rating
                                    </button>
                                    <a href="{{ route('customer.orders') }}" class="skip-rating-link">Lewati &rarr;</a>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
                @endif

            </div>{{-- /col-lg-8 --}}

            {{-- ─── RIGHT: Sidebar ─── --}}
            <div class="col-lg-4" data-aos="fade-left">
                <div class="sidebar-summary">
                    <div class="ss-head">
                        <div class="ss-label">Ringkasan Paket</div>
                        <div class="ss-name">{{ $order->package->name ?? 'Paket dihapus' }}</div>
                        @if($order->package->category ?? null)
                            <div class="ss-cat">{{ $order->package->category->name }}</div>
                        @endif
                    </div>
                    <div class="ss-body">
                        <div class="ss-row">
                            <span class="ss-key"><i class="bi bi-clock"></i> Durasi</span>
                            <span class="ss-val">{{ $order->package->duration ?? '-' }} menit</span>
                        </div>
                        <div class="ss-row">
                            <span class="ss-key"><i class="bi bi-calendar3"></i> Sesi</span>
                            <span class="ss-val">{{ \Carbon\Carbon::parse($order->booking_date)->isoFormat('D MMM YYYY') }}</span>
                        </div>
                        <div class="ss-row">
                            <span class="ss-key"><i class="bi bi-clock-history"></i> Waktu</span>
                            <span class="ss-val">
                                {{ \Carbon\Carbon::parse($order->start_time)->format('H:i') }}–{{ \Carbon\Carbon::parse($order->end_time)->format('H:i') }} WIB
                            </span>
                        </div>
                        <div class="ss-row">
                            <span class="ss-key"><i class="bi bi-geo-alt"></i> Lokasi</span>
                            <span class="ss-val" style="max-width:150px;">{{ Str::limit($order->location, 30) ?? '-' }}</span>
                        </div>
                        <div class="ss-row">
                            <span class="ss-key"><i class="bi bi-person"></i> Pemesan</span>
                            <span class="ss-val">{{ Auth::user()->name }}</span>
                        </div>

                        <div class="ss-total">
                            <div class="ss-total-label">Total</div>
                            <div class="ss-total-price">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                        </div>

                        @if(!$order->payment && $order->status !== 'cancelled')
                        <a href="{{ route('customer.payment.create', $order->id) }}" class="btn-action-gold">
                            <i class="bi bi-credit-card"></i> Bayar Sekarang
                        </a>
                        @endif

                        <a href="{{ route('packages.detail', $order->package_id) }}" class="btn-action-outline">
                            <i class="bi bi-arrow-repeat"></i> Pesan Lagi
                        </a>

                        <div style="text-align:center;margin-top:14px;">
                            <a href="{{ route('customer.orders') }}"
                               style="font-size:.75rem;color:var(--muted);text-decoration:none;transition:color var(--trans);"
                               onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='var(--muted)'">
                                <i class="bi bi-list-ul me-1"></i> Semua Pesanan
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

</main>
@endsection