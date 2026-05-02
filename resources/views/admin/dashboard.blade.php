@extends('base.base-admin-index')

@php
    $menu    = 'Dashboard';
    $submenu = 'Beranda';
    $subdesc = 'Halaman utama dashboard admin';
@endphp

@section('custom-css')
<style>
/* =============================================================
   GLOBAL ICON FIX
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
   WELCOME BANNER
   ============================================================= */
.welcome-banner {
    background: linear-gradient(135deg, #0A1628 0%, #1E3A8A 55%, #2563EB 100%);
    border-radius: 16px;
    padding: 22px 24px;
    margin-bottom: 24px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 24px rgba(37,99,235,.22);
}
.welcome-banner::before {
    content: '';
    position: absolute; top: -30px; right: -30px;
    width: 180px; height: 180px;
    border-radius: 50%;
    background: rgba(255,255,255,.05);
}
.welcome-banner::after {
    content: '';
    position: absolute; bottom: -40px; right: 80px;
    width: 120px; height: 120px;
    border-radius: 50%;
    background: rgba(255,255,255,.04);
}
.welcome-greeting {
    font-size: .72rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .1em;
    color: rgba(255,255,255,.5);
    margin-bottom: 6px;
}
.welcome-title {
    font-size: 1.25rem; font-weight: 800;
    color: #fff; margin-bottom: 6px;
    letter-spacing: -.02em; line-height: 1.2;
}
.welcome-sub {
    font-size: .78rem; color: rgba(255,255,255,.55);
}
.welcome-date {
    font-size: .73rem; font-weight: 600;
    color: rgba(255,255,255,.7);
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.15);
    padding: 5px 13px; border-radius: 100px;
    white-space: nowrap;
}
.welcome-quick-actions {
    display: flex; gap: 8px; flex-wrap: wrap;
    margin-top: 16px; padding-top: 16px;
    border-top: 1px solid rgba(255,255,255,.1);
}
.quick-btn {
    display: inline-flex; align-items: center; gap: 7px;
    font-size: .73rem; font-weight: 600;
    color: rgba(255,255,255,.8);
    background: rgba(255,255,255,.1);
    border: 1px solid rgba(255,255,255,.18);
    padding: 6px 14px; border-radius: 8px;
    text-decoration: none;
    transition: background .15s, color .15s, transform .15s;
    line-height: 1;
}
.quick-btn:hover {
    background: rgba(255,255,255,.2);
    color: #fff;
    transform: translateY(-1px);
    text-decoration: none;
}
.quick-btn .bi { font-size: .78rem !important; }

/* =============================================================
   STAT CARDS
   ============================================================= */
.stat-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}
@media (max-width: 900px) { .stat-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 480px) { .stat-grid { grid-template-columns: 1fr 1fr; } }

.stat-card {
    background: var(--tg-glass);
    backdrop-filter: var(--tg-blur);
    border: 1px solid var(--tg-glass-border);
    border-radius: 14px;
    box-shadow: var(--tg-sh-sm);
    padding: 20px 18px 16px;
    position: relative;
    overflow: hidden;
    text-decoration: none;
    display: block;
    transition: transform .2s ease, box-shadow .2s ease;
}
.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 28px rgba(37,99,235,.13);
    text-decoration: none;
}
.stat-card-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 14px;
}
.stat-card-icon {
    width: 44px; height: 44px;
    border-radius: 11px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.stat-card-icon .bi { font-size: 1.1rem !important; }
.stat-card-badge {
    font-size: .62rem; font-weight: 700;
    letter-spacing: .04em;
    padding: 3px 9px;
    border-radius: 100px;
    line-height: 1.3;
    white-space: nowrap;
    align-self: flex-start;
}
.stat-card-num {
    font-size: 1.75rem; font-weight: 800; line-height: 1;
    color: var(--tg-text); margin-bottom: 5px; letter-spacing: -.03em;
}
.stat-card-num.income { font-size: 1.2rem; }
.stat-card-lbl {
    font-size: .65rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .08em;
    color: var(--tg-text-3);
}
.stat-card-accent {
    position: absolute; bottom: 0; left: 0; right: 0;
    height: 3px; border-radius: 0 0 14px 14px;
}

/* =============================================================
   SECTION LABEL
   ============================================================= */
.section-label {
    font-size: .63rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .1em;
    color: var(--tg-text-3); margin-bottom: 10px;
}

/* =============================================================
   TABLE CARD
   ============================================================= */
.dash-table-card {
    border: 1px solid var(--tg-glass-border);
    border-radius: 14px;
    overflow: hidden;
    box-shadow: var(--tg-sh-sm);
    background: var(--tg-glass);
    backdrop-filter: var(--tg-blur);
}
.dash-table-head {
    background: linear-gradient(135deg, #0A1628, #1E3A8A);
    padding: 14px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    flex-wrap: wrap;
}
.dash-table-head h6 {
    color: #fff; font-size: .92rem; font-weight: 700;
    margin: 0;
    display: flex; align-items: center; gap: 8px;
    line-height: 1;
}
.dash-table-head h6 .bi { font-size: .9rem !important; }
.dash-table-head a {
    font-size: .74rem; font-weight: 600;
    color: rgba(255,255,255,.75);
    text-decoration: none;
    background: rgba(255,255,255,.12);
    padding: 5px 12px;
    border-radius: 7px;
    border: 1px solid rgba(255,255,255,.2);
    display: inline-flex; align-items: center; gap: 5px;
    line-height: 1;
    transition: background .15s;
}
.dash-table-head a:hover { background: rgba(255,255,255,.22); color: #fff; }
.dash-table-head a .bi { font-size: .75rem !important; }

.dash-table { width: 100%; border-collapse: collapse; }
.dash-table thead th {
    font-size: .66rem !important; font-weight: 700 !important;
    text-transform: uppercase !important; letter-spacing: .07em !important;
    color: var(--tg-text-3) !important;
    background: var(--tg-glass) !important;
    border-bottom: 1px solid var(--tg-border) !important;
    padding: 10px 14px !important;
    white-space: nowrap; vertical-align: middle !important;
}
.dash-table tbody td {
    padding: 11px 14px !important;
    vertical-align: middle !important;
    font-size: .82rem !important;
    border-bottom: 1px solid var(--tg-border) !important;
    color: var(--tg-text) !important;
}
.dash-table tbody tr:last-child td { border-bottom: none !important; }
.dash-table tbody tr:hover td { background: rgba(59,130,246,.04) !important; }

/* =============================================================
   BADGES
   ============================================================= */
.tg-badge {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: .67rem; font-weight: 700;
    padding: 3px 9px; border-radius: 100px;
    white-space: nowrap; line-height: 1.3;
}
.tg-badge .bi { font-size: .65rem !important; }
.tg-badge-pending   { background: #FEF3C7; color: #92400E; }
.tg-badge-confirmed { background: #DBEAFE; color: #1E40AF; }
.tg-badge-completed { background: #D1FAE5; color: #065F46; }
.tg-badge-cancelled { background: #FEE2E2; color: #991B1B; }
.tg-badge-verified  { background: #D1FAE5; color: #065F46; }
.tg-badge-rejected  { background: #FEE2E2; color: #991B1B; }
.tg-badge-default   { background: #F3F4F6; color: #6B7280; }

[data-theme="dark"] .tg-badge-pending   { background: rgba(254,243,199,.15); color: #FCD34D; }
[data-theme="dark"] .tg-badge-confirmed { background: rgba(219,234,254,.12); color: #93C5FD; }
[data-theme="dark"] .tg-badge-completed { background: rgba(209,250,229,.12); color: #6EE7B7; }
[data-theme="dark"] .tg-badge-cancelled { background: rgba(254,226,226,.12); color: #FCA5A5; }
[data-theme="dark"] .tg-badge-default   { background: rgba(255,255,255,.07); color: #9CA3AF; }

/* =============================================================
   MINI AVATAR
   ============================================================= */
.mini-av {
    width: 32px; height: 32px; border-radius: 9px;
    background: linear-gradient(135deg, #0A1628, #2563EB);
    color: #fff; font-size: .68rem; font-weight: 700;
    display: inline-flex; align-items: center; justify-content: center;
    flex-shrink: 0; line-height: 1;
}

/* =============================================================
   SIDE CARDS
   ============================================================= */
.side-card {
    border: 1px solid var(--tg-glass-border);
    border-radius: 14px; overflow: hidden;
    box-shadow: var(--tg-sh-sm);
    background: var(--tg-glass);
    backdrop-filter: var(--tg-blur);
}
.side-card-head {
    display: flex; align-items: center; justify-content: space-between;
    padding: 13px 16px;
    border-bottom: 1px solid var(--tg-border);
}
.side-card-head h6 {
    font-size: .85rem; font-weight: 700;
    color: var(--tg-text); margin: 0;
    display: flex; align-items: center; gap: 7px; line-height: 1;
}
.side-card-head h6 .bi { font-size: .9rem !important; }
.side-card-head a {
    font-size: .72rem; font-weight: 600;
    color: var(--tg-blue); text-decoration: none;
}
.side-card-head a:hover { text-decoration: underline; }
.side-card-body { padding: 4px 16px 8px; }

/* ── Summary rows with progress bar ── */
.sum-row {
    display: flex; flex-direction: column;
    padding: 9px 0;
    border-bottom: 1px solid var(--tg-border);
    gap: 6px;
}
.sum-row:last-child { border-bottom: none; }
.sum-row-top {
    display: flex; align-items: center;
    justify-content: space-between;
}
.sum-row-left {
    display: flex; align-items: center; gap: 9px;
}
.sum-icon {
    width: 30px; height: 30px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.sum-icon .bi { font-size: .85rem !important; }
.sum-label { font-size: .82rem; font-weight: 500; color: var(--tg-text-2); }
.sum-count { font-size: .92rem; font-weight: 800; color: var(--tg-text); }
.sum-bar-wrap {
    height: 3px; background: var(--tg-border);
    border-radius: 100px; overflow: hidden;
}
.sum-bar {
    height: 100%; border-radius: 100px;
    transition: width .8s cubic-bezier(.4,0,.2,1);
}

/* ── Mini rows ── */
.mini-row {
    display: flex; align-items: center;
    justify-content: space-between;
    padding: 9px 0;
    border-bottom: 1px solid var(--tg-border);
    gap: 8px;
}
.mini-row:last-child { border-bottom: none; }
.mini-name { font-size: .82rem; font-weight: 700; color: var(--tg-text); line-height: 1.3; }
.mini-sub  { font-size: .72rem; color: var(--tg-text-3); line-height: 1.3; margin-top: 2px; }

/* ── Stars ── */
.star-filled { color: #FBBF24 !important; font-size: .72rem !important; }
.star-empty  { color: #D1D5DB !important; font-size: .72rem !important; }

/* ── Empty state ── */
.empty-state {
    text-align: center; padding: 24px 12px;
    color: var(--tg-text-3); font-size: .82rem;
}
.empty-state .bi { font-size: 1.8rem !important; opacity: .25; display: block; margin-bottom: 8px; }

/* =============================================================
   COUNTER ANIMATION
   ============================================================= */
.stat-card-num { transition: none; }
</style>
@endsection

@section('content')

{{-- ══════════════════════════════════════════
     WELCOME BANNER
═══════════════════════════════════════════ --}}
<div class="welcome-banner mb-4">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:12px;">
        <div>
            <p class="welcome-greeting">Selamat datang kembali 👋</p>
            <h2 class="welcome-title">Dashboard Admin</h2>
            <p class="welcome-sub">Pantau semua aktivitas, pesanan, dan pembayaran studio Anda.</p>
        </div>
        <span class="welcome-date" id="live-date">—</span>
    </div>
    <div class="welcome-quick-actions">
        <a href="{{ route('orders.index') }}"   class="quick-btn"><i class="bi bi-bag"></i> Kelola Pesanan</a>
        <a href="{{ route('payments.index') }}" class="quick-btn"><i class="bi bi-cash-stack"></i> Kelola Pembayaran</a>
        <a href="{{ route('ratings.index') }}"  class="quick-btn"><i class="bi bi-star-fill"></i> Lihat Rating</a>
    </div>
</div>

{{-- ══════════════════════════════════════════
     STAT CARDS
═══════════════════════════════════════════ --}}
<p class="section-label">Statistik Utama</p>
<div class="stat-grid">

    {{-- Pesanan Pending --}}
    <a href="{{ route('orders.index', ['status' => 'pending']) }}" class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon" style="background:rgba(217,119,6,.12);">
                <i class="bi bi-clock" style="color:#D97706;"></i>
            </div>
            <span class="stat-card-badge" style="background:rgba(217,119,6,.12); color:#D97706;">Aktif</span>
        </div>
        <div class="stat-card-num" data-count="{{ $pendingOrder ?? 0 }}">{{ $pendingOrder ?? 0 }}</div>
        <div class="stat-card-lbl">Pesanan Pending</div>
        <div class="stat-card-accent" style="background:#F59E0B;"></div>
    </a>

    {{-- Pesanan Selesai --}}
    <a href="{{ route('orders.index', ['status' => 'completed']) }}" class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon" style="background:rgba(5,150,105,.12);">
                <i class="bi bi-camera" style="color:#059669;"></i>
            </div>
            <span class="stat-card-badge" style="background:rgba(5,150,105,.12); color:#059669;">Selesai</span>
        </div>
        <div class="stat-card-num" data-count="{{ $completedOrder ?? 0 }}">{{ $completedOrder ?? 0 }}</div>
        <div class="stat-card-lbl">Pesanan Selesai</div>
        <div class="stat-card-accent" style="background:#10B981;"></div>
    </a>

    {{-- Total Pendapatan --}}
    <a href="{{ route('payments.index') }}" class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon" style="background:rgba(37,99,235,.12);">
                <i class="bi bi-cash-coin" style="color:#2563EB;"></i>
            </div>
            <span class="stat-card-badge" style="background:rgba(37,99,235,.12); color:#2563EB;">IDR</span>
        </div>
        <div class="stat-card-num income">Rp {{ number_format($totalIncome ?? 0, 0, ',', '.') }}</div>
        <div class="stat-card-lbl">Total Pendapatan</div>
        <div class="stat-card-accent" style="background:#3B82F6;"></div>
    </a>

    {{-- Total Rating --}}
    <a href="{{ route('ratings.index') }}" class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon" style="background:rgba(202,138,4,.12);">
                <i class="bi bi-star-fill" style="color:#CA8A04;"></i>
            </div>
            <span class="stat-card-badge" style="background:rgba(202,138,4,.12); color:#CA8A04;">Review</span>
        </div>
        <div class="stat-card-num" data-count="{{ $totalRating ?? 0 }}">{{ $totalRating ?? 0 }}</div>
        <div class="stat-card-lbl">Total Rating</div>
        <div class="stat-card-accent" style="background:#FBBF24;"></div>
    </a>

</div>

{{-- ══════════════════════════════════════════
     MAIN CONTENT: TABLE + SIDE CARDS
═══════════════════════════════════════════ --}}
<div class="row g-3">

    {{-- ── Kiri: Tabel Pesanan Terbaru ── --}}
    <div class="col-lg-8">
        <p class="section-label">Pesanan Terbaru</p>
        <div class="dash-table-card">

            <div class="dash-table-head">
                <h6>
                    <i class="bi bi-receipt"></i> Daftar Pesanan
                </h6>
                <a href="{{ route('orders.index') }}">
                    <i class="bi bi-arrow-right"></i> Lihat Semua
                </a>
            </div>

            <div style="overflow-x:auto;">
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th style="padding-left:20px !important; width:40px;">#</th>
                            <th style="min-width:140px;">Customer</th>
                            <th style="min-width:120px;">Paket</th>
                            <th style="min-width:110px;">Tanggal</th>
                            <th style="min-width:100px;">Total</th>
                            <th style="padding-right:20px !important; min-width:100px;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestOrder as $order)
                        @php
                            $badgeCls = match($order->status) {
                                'pending'   => 'tg-badge-pending',
                                'confirmed' => 'tg-badge-confirmed',
                                'completed' => 'tg-badge-completed',
                                'cancelled' => 'tg-badge-cancelled',
                                default     => 'tg-badge-default',
                            };
                            $badgeIcon = match($order->status) {
                                'pending'   => 'bi-clock',
                                'confirmed' => 'bi-check-circle',
                                'completed' => 'bi-camera',
                                'cancelled' => 'bi-x-circle',
                                default     => 'bi-circle',
                            };
                            $statusLbl = match($order->status) {
                                'pending'   => 'Pending',
                                'confirmed' => 'Dikonfirmasi',
                                'completed' => 'Selesai',
                                'cancelled' => 'Dibatalkan',
                                default     => ucfirst($order->status),
                            };
                        @endphp
                        <tr>
                            <td style="padding-left:20px !important;">
                                <span style="font-size:.68rem; font-weight:700; color:var(--tg-text-3);">
                                    #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                            <td>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <div class="mini-av">{{ strtoupper(substr($order->user->name ?? 'U', 0, 1)) }}</div>
                                    <div>
                                        <div style="font-weight:700; font-size:.82rem; line-height:1.3;">{{ $order->user->name ?? '-' }}</div>
                                        <div style="font-size:.71rem; color:var(--tg-text-3); line-height:1.3;">{{ $order->user->email ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-weight:600; font-size:.82rem; line-height:1.3;">{{ $order->package->name ?? '-' }}</div>
                                <div style="font-size:.71rem; color:var(--tg-text-3);">{{ $order->package->category->name ?? '' }}</div>
                            </td>
                            <td>
                                <div style="font-size:.82rem; line-height:1.3;">{{ \Carbon\Carbon::parse($order->booking_date)->isoFormat('D MMM YYYY') }}</div>
                                <div style="font-size:.71rem; color:var(--tg-text-3);">{{ \Carbon\Carbon::parse($order->booking_date)->isoFormat('dddd') }}</div>
                            </td>
                            <td>
                                <span style="font-weight:700; font-size:.84rem; white-space:nowrap;">
                                    Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}
                                </span>
                            </td>
                            <td style="padding-right:20px !important;">
                                <span class="tg-badge {{ $badgeCls }}">
                                    <i class="bi {{ $badgeIcon }}"></i>{{ $statusLbl }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    Belum ada pesanan
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    {{-- ── Kanan: Side Cards ── --}}
    <div class="col-lg-4 d-flex flex-column gap-3">

        <p class="section-label">Ringkasan &amp; Aktivitas</p>

        {{-- Ringkasan dengan progress bar --}}
        <div class="side-card">
            <div class="side-card-head">
                <h6><i class="bi bi-pie-chart" style="color:#2563EB;"></i> Ringkasan</h6>
            </div>
            <div class="side-card-body">
                @php
                    $summaryRows = [
                        ['label' => 'Total Order',    'count' => $totalOrder    ?? 0, 'ic' => 'bi-bag',         'bg' => 'rgba(37,99,235,.1)',   'cl' => '#2563EB', 'bar' => '#3B82F6'],
                        ['label' => 'Total Customer', 'count' => $totalCustomer ?? 0, 'ic' => 'bi-people',      'bg' => 'rgba(5,150,105,.1)',   'cl' => '#059669', 'bar' => '#10B981'],
                        ['label' => 'Total Payment',  'count' => $totalPayment  ?? 0, 'ic' => 'bi-credit-card', 'bg' => 'rgba(217,119,6,.1)',   'cl' => '#D97706', 'bar' => '#F59E0B'],
                        ['label' => 'Total Delivery', 'count' => $totalDelivery ?? 0, 'ic' => 'bi-send',        'bg' => 'rgba(5,150,105,.1)',   'cl' => '#059669', 'bar' => '#34D399'],
                        ['label' => 'Total Rating',   'count' => $totalRating   ?? 0, 'ic' => 'bi-star-fill',   'bg' => 'rgba(202,138,4,.1)',   'cl' => '#CA8A04', 'bar' => '#FBBF24'],
                    ];
                    $maxCount = max(array_column($summaryRows, 'count')) ?: 1;
                @endphp
                @foreach($summaryRows as $row)
                <div class="sum-row">
                    <div class="sum-row-top">
                        <div class="sum-row-left">
                            <div class="sum-icon" style="background:{{ $row['bg'] }};">
                                <i class="bi {{ $row['ic'] }}" style="color:{{ $row['cl'] }};"></i>
                            </div>
                            <span class="sum-label">{{ $row['label'] }}</span>
                        </div>
                        <span class="sum-count">{{ $row['count'] }}</span>
                    </div>
                    <div class="sum-bar-wrap">
                        <div class="sum-bar"
                             style="width:{{ round(($row['count'] / $maxCount) * 100) }}%;background:{{ $row['bar'] }};"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Payment Terbaru --}}
        <div class="side-card">
            <div class="side-card-head">
                <h6><i class="bi bi-cash-stack" style="color:#059669;"></i> Payment Terbaru</h6>
                <a href="{{ route('payments.index') }}">Semua →</a>
            </div>
            <div class="side-card-body">
                @forelse($latestPayment as $payment)
                @php
                    $pcls = match($payment->payment_status ?? 'pending') {
                        'verified' => 'tg-badge-verified',
                        'rejected' => 'tg-badge-rejected',
                        default    => 'tg-badge-pending',
                    };
                    $plbl = match($payment->payment_status ?? 'pending') {
                        'verified' => 'Lunas',
                        'rejected' => 'Ditolak',
                        default    => 'Menunggu',
                    };
                @endphp
                <div class="mini-row">
                    <div style="display:flex; align-items:center; gap:8px; min-width:0;">
                        <div class="mini-av">{{ strtoupper(substr($payment->order->user->name ?? 'U', 0, 1)) }}</div>
                        <div style="min-width:0;">
                            <div class="mini-name">{{ $payment->order->user->name ?? '-' }}</div>
                            <div class="mini-sub">Rp {{ number_format($payment->amount ?? 0, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    <span class="tg-badge {{ $pcls }}" style="flex-shrink:0;">{{ $plbl }}</span>
                </div>
                @empty
                <div class="empty-state">
                    <i class="bi bi-receipt"></i>
                    Belum ada payment
                </div>
                @endforelse
            </div>
        </div>

        {{-- Rating Terbaru --}}
        <div class="side-card">
            <div class="side-card-head">
                <h6><i class="bi bi-star-fill" style="color:#CA8A04;"></i> Rating Terbaru</h6>
                <a href="{{ route('ratings.index') }}">Semua →</a>
            </div>
            <div class="side-card-body">
                @forelse($latestRatings as $rating)
                <div class="mini-row" style="align-items:flex-start;">
                    <div style="display:flex; align-items:flex-start; gap:8px; min-width:0; flex:1;">
                        <div class="mini-av" style="margin-top:2px;">{{ strtoupper(substr($rating->user->name ?? 'U', 0, 1)) }}</div>
                        <div style="min-width:0;">
                            <div class="mini-name">{{ $rating->user->name ?? '-' }}</div>
                            <div style="display:flex; align-items:center; gap:2px; margin:3px 0;">
                                @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star-fill {{ $i <= ($rating->rating ?? 0) ? 'star-filled' : 'star-empty' }}"></i>
                                @endfor
                                <span style="font-size:.68rem; color:var(--tg-text-3); margin-left:3px;">({{ $rating->rating ?? 0 }})</span>
                            </div>
                            @if($rating->review)
                            <div class="mini-sub" style="max-width:180px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                {{ Str::limit($rating->review, 50) }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <i class="bi bi-star"></i>
                    Belum ada rating
                </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

@endsection

@section('custom-js')
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── Live date di welcome banner ── */
    const dateEl = document.getElementById('live-date');
    if (dateEl) {
        const now  = new Date();
        const opts = { weekday:'long', year:'numeric', month:'long', day:'numeric' };
        dateEl.textContent = now.toLocaleDateString('id-ID', opts);
    }

    /* ── Counter animation ── */
    document.querySelectorAll('.stat-card-num[data-count]').forEach(function (el) {
        var target = parseInt(el.getAttribute('data-count'));
        if (isNaN(target) || target === 0) return;
        var start = 0;
        var step  = Math.max(1, Math.ceil(target / 40));
        var timer = setInterval(function () {
            start = Math.min(start + step, target);
            el.textContent = start.toLocaleString('id-ID');
            if (start >= target) clearInterval(timer);
        }, 18);
    });

    /* ── Progress bar animate on load ── */
    document.querySelectorAll('.sum-bar').forEach(function(bar) {
        var w = bar.style.width;
        bar.style.width = '0%';
        setTimeout(function() { bar.style.width = w; }, 200);
    });

});
</script>
@endsection