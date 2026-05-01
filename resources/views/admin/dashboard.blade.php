@extends('base.base-admin-index')

{{-- Variable untuk page-heading di base layout (tidak perlu header lagi di content) --}}
@php
    $menu    = 'Dashboard';
    $submenu = 'Beranda';
    $subdesc = 'Halaman utama dashboard admin';
@endphp

@section('custom-css')
<style>
    /* ── Fix Font Awesome: override path lokal ke CDN FA 6 ── */
    @font-face {
        font-family: "Font Awesome 6 Free";
        font-style: normal;
        font-weight: 900;
        font-display: block;
        src: url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/webfonts/fa-solid-900.woff2") format("woff2");
    }
    @font-face {
        font-family: "Font Awesome 6 Brands";
        font-style: normal;
        font-weight: 400;
        font-display: block;
        src: url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/webfonts/fa-brands-400.woff2") format("woff2");
    }
    .fa-solid, .fas { font-family: "Font Awesome 6 Free" !important; font-weight: 900 !important; }
    .fa-brands, .fab { font-family: "Font Awesome 6 Brands" !important; font-weight: 400 !important; }
    .fa-regular, .far { font-family: "Font Awesome 6 Free" !important; font-weight: 400 !important; }

    /* ── Stat Cards ── */
    .tg-stat-card {
        border: none !important;
        border-radius: 14px !important;
        box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.05) !important;
        overflow: hidden;
        transition: transform .2s ease, box-shadow .2s ease !important;
        background: #fff !important;
    }
    .tg-stat-card:hover {
        transform: translateY(-3px) !important;
        box-shadow: 0 6px 24px rgba(37,99,235,.13) !important;
    }
    .tg-stat-card .card-body { padding: 20px 22px !important; }

    .stat-icon-wrap {
        width: 46px; height: 46px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem;
        flex-shrink: 0;
    }
    .stat-icon-wrap.pending { background: #FEF3C7; color: #D97706; }
    .stat-icon-wrap.done    { background: #D1FAE5; color: #059669; }
    .stat-icon-wrap.income  { background: #DBEAFE; color: #2563EB; }
    .stat-icon-wrap.rating  { background: #FEF9C3; color: #CA8A04; }

    .stat-value {
        font-size: 1.7rem;
        font-weight: 800;
        letter-spacing: -.04em;
        line-height: 1;
        color: #111827;
        margin: 12px 0 4px;
    }
    .stat-value.income-val { font-size: 1.15rem; }
    .stat-label {
        font-size: .72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: #9CA3AF;
    }
    .stat-badge {
        font-size: .67rem;
        font-weight: 700;
        padding: 3px 9px;
        border-radius: 100px;
    }
    .stat-card-link { text-decoration: none !important; display: block; height: 100%; }

    /* ── Section label ── */
    .section-label {
        font-size: .68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .1em;
        color: #9CA3AF;
        margin-bottom: 10px;
    }

    /* ── Table Card ── */
    .tg-table-card {
        border: none !important;
        border-radius: 14px !important;
        box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.05) !important;
        overflow: hidden;
    }
    .tg-table-card .card-header {
        background: linear-gradient(135deg, #1E3A8A, #2563EB) !important;
        padding: 15px 20px !important;
        border: none !important;
    }
    .tg-table-card .card-header .card-title {
        color: #fff !important;
        font-weight: 600;
        font-size: .95rem;
    }
    .tg-table-card .card-header .btn-outline-light {
        font-size: .72rem;
        border-color: rgba(255,255,255,.35) !important;
        color: rgba(255,255,255,.9) !important;
        background: rgba(255,255,255,.1) !important;
        padding: 4px 12px;
        border-radius: 8px;
    }
    .tg-table-card .card-header .btn-outline-light:hover {
        background: rgba(255,255,255,.22) !important;
        color: #fff !important;
    }
    .tg-table-card .table thead th {
        font-size: .7rem !important;
        background: #FAFAFA !important;
        color: #9CA3AF !important;
        border-bottom: 1px solid #F3F4F6 !important;
        padding: 10px 14px !important;
    }
    .tg-table-card .table tbody td {
        padding: 10px 14px !important;
        vertical-align: middle;
        border-bottom: 1px solid #F9FAFB !important;
        font-size: .82rem;
    }
    .tg-table-card .table tbody tr:last-child td { border-bottom: none !important; }
    .tg-table-card .table tbody tr:hover td { background: #F9FAFB; }

    /* ── Mini Avatar ── */
    .mini-avatar {
        width: 30px; height: 30px;
        border-radius: 8px;
        background: linear-gradient(135deg, #1E3A8A, #3B82F6);
        color: #fff;
        font-size: .7rem;
        font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    /* ── Status Badges ── */
    .badge-pending   { background: #FEF3C7 !important; color: #92400E !important; }
    .badge-confirmed { background: #DBEAFE !important; color: #1E40AF !important; }
    .badge-completed { background: #D1FAE5 !important; color: #065F46 !important; }
    .badge-cancelled { background: #FEE2E2 !important; color: #991B1B !important; }
    .badge-verified  { background: #D1FAE5 !important; color: #065F46 !important; }
    .badge-rejected  { background: #FEE2E2 !important; color: #991B1B !important; }
    .badge-default   { background: #F3F4F6 !important; color: #6B7280 !important; }

    /* ── Side Cards ── */
    .side-card {
        border: none !important;
        border-radius: 14px !important;
        box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.05) !important;
    }
    .side-card .card-header {
        background: #fff !important;
        border-bottom: 1px solid #F3F4F6 !important;
        padding: 13px 18px !important;
    }
    .side-card .card-header .card-title {
        font-size: .88rem !important;
        font-weight: 700 !important;
        color: #111827 !important;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .side-card .card-body { padding: 10px 18px !important; }

    /* Summary rows */
    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 9px 0;
        border-bottom: 1px solid #F9FAFB;
    }
    .summary-row:last-child { border-bottom: none; }
    .summary-icon {
        width: 28px; height: 28px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: .72rem;
        flex-shrink: 0;
        margin-right: 10px;
    }
    .summary-label { font-size: .78rem; color: #6B7280; }
    .summary-count { font-size: .82rem; font-weight: 700; color: #111827; }

    /* Mini rows */
    .mini-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 9px 0;
        border-bottom: 1px solid #F9FAFB;
    }
    .mini-row:last-child { border-bottom: none; }
    .mini-name { font-size: .81rem; font-weight: 600; color: #111827; line-height: 1.2; }
    .mini-sub  { font-size: .72rem; color: #6B7280; }

    /* Stars */
    .star-filled { color: #F59E0B; font-size: .7rem; }
    .star-empty  { color: #D1D5DB; font-size: .7rem; }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 20px 0;
        color: #9CA3AF;
        font-size: .8rem;
    }
    .empty-state i { font-size: 1.4rem; display: block; margin-bottom: 6px; opacity: .35; }

    .accent-bar {
        width: 4px; height: 18px;
        background: #60A5FA;
        border-radius: 100px;
        flex-shrink: 0;
    }
</style>
@endsection

@section('content')

{{-- ── Stat Cards ── --}}
<p class="section-label">Statistik Utama</p>
<div class="row g-3 mb-4">

    <div class="col-lg-3 col-md-6">
        <a href="{{ route('orders.index') }}" class="stat-card-link">
            <div class="card tg-stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="stat-icon-wrap pending">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <span class="stat-badge" style="background:#FEF3C7;color:#92400E;">Aktif</span>
                    </div>
                    <div class="stat-value mt-3">{{ $orderPending ?? 0 }}</div>
                    <div class="stat-label">Pesanan Pending</div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-3 col-md-6">
        <a href="{{ route('orders.index') }}" class="stat-card-link">
            <div class="card tg-stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="stat-icon-wrap done">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <span class="stat-badge" style="background:#D1FAE5;color:#065F46;">Selesai</span>
                    </div>
                    <div class="stat-value mt-3">{{ $orderFinished ?? 0 }}</div>
                    <div class="stat-label">Pesanan Selesai</div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-3 col-md-6">
        <a href="{{ route('payments.index') }}" class="stat-card-link">
            <div class="card tg-stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="stat-icon-wrap income">
                            <i class="fa-solid fa-arrow-trend-up"></i>
                        </div>
                        <span class="stat-badge" style="background:#DBEAFE;color:#1E40AF;">IDR</span>
                    </div>
                    <div class="stat-value income-val mt-3">
                        Rp {{ number_format($totalIncome ?? 0, 0, ',', '.') }}
                    </div>
                    <div class="stat-label">Total Pendapatan</div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-3 col-md-6">
        <a href="{{ route('ratings.index') }}" class="stat-card-link">
            <div class="card tg-stat-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="stat-icon-wrap rating">
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <span class="stat-badge" style="background:#FEF9C3;color:#92400E;">Review</span>
                    </div>
                    <div class="stat-value mt-3">{{ $totalRating ?? 0 }}</div>
                    <div class="stat-label">Total Rating</div>
                </div>
            </div>
        </a>
    </div>

</div>

{{-- ── Tabel + Sidebar ── --}}
<div class="row g-3">

    {{-- Tabel Pesanan --}}
    <div class="col-lg-8">
        <p class="section-label">Pesanan Terbaru</p>
        <div class="card tg-table-card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <div class="accent-bar"></div>
                    <h5 class="card-title mb-0">Daftar Pesanan</h5>
                </div>
                <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-light">
                    <i class="fa-solid fa-arrow-right me-1"></i>Lihat Semua
                </a>
            </div>
            <div class="card-body p-0" style="padding:0!important;">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th style="padding-left:20px!important;">#</th>
                                <th>Customer</th>
                                <th>Paket</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th style="padding-right:20px!important;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestOrders as $order)
                            <tr>
                                <td style="padding-left:20px!important;">
                                    <span style="font-size:.7rem;font-weight:700;color:#D1D5DB;">{{ $loop->iteration }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="mini-avatar" style="width:28px;height:28px;font-size:.68rem;">
                                            {{ strtoupper(substr($order->user->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <span style="font-weight:600;">{{ $order->user->name ?? '-' }}</span>
                                    </div>
                                </td>
                                <td>{{ $order->package->name ?? '-' }}</td>
                                <td style="color:#9CA3AF;">
                                    {{ \Carbon\Carbon::parse($order->booking_date)->format('d M Y') }}
                                </td>
                                <td><span style="font-weight:600;">Rp {{ number_format($order->total_price ?? 0, 0, ',', '.') }}</span></td>
                                <td style="padding-right:20px!important;">
                                    @php
                                        $cls = match($order->status) {
                                            'pending'   => 'badge-pending',
                                            'confirmed' => 'badge-confirmed',
                                            'completed' => 'badge-completed',
                                            'cancelled' => 'badge-cancelled',
                                            default     => 'badge-default',
                                        };
                                    @endphp
                                    <span class="badge {{ $cls }}">{{ ucfirst($order->status) }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="fa-solid fa-inbox"></i>
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
    </div>

    {{-- Kolom Kanan --}}
    <div class="col-lg-4 d-flex flex-column gap-3">

        <p class="section-label mb-1">Ringkasan & Aktivitas</p>

        {{-- Ringkasan --}}
        <div class="card side-card">
            <div class="card-header">
                <h6 class="card-title">
                    <i class="fa-solid fa-chart-pie" style="color:#2563EB;"></i>
                    Ringkasan
                </h6>
            </div>
            <div class="card-body">
                <div class="summary-row">
                    <div class="d-flex align-items-center">
                        <div class="summary-icon" style="background:#DBEAFE;color:#2563EB;"><i class="fa-solid fa-cart-shopping"></i></div>
                        <span class="summary-label">Total Order</span>
                    </div>
                    <span class="summary-count">{{ $totalOrder ?? 0 }}</span>
                </div>
                <div class="summary-row">
                    <div class="d-flex align-items-center">
                        <div class="summary-icon" style="background:#D1FAE5;color:#059669;"><i class="fa-solid fa-users"></i></div>
                        <span class="summary-label">Total Customer</span>
                    </div>
                    <span class="summary-count">{{ $totalCustomer ?? 0 }}</span>
                </div>
                <div class="summary-row">
                    <div class="d-flex align-items-center">
                        <div class="summary-icon" style="background:#FEF3C7;color:#D97706;"><i class="fa-solid fa-credit-card"></i></div>
                        <span class="summary-label">Total Payment</span>
                    </div>
                    <span class="summary-count">{{ $totalPayment ?? 0 }}</span>
                </div>
                <div class="summary-row">
                    <div class="d-flex align-items-center">
                        <div class="summary-icon" style="background:#D1FAE5;color:#059669;"><i class="fa-solid fa-paper-plane"></i></div>
                        <span class="summary-label">Total Delivery</span>
                    </div>
                    <span class="summary-count">{{ $totalDelivery ?? 0 }}</span>
                </div>
                <div class="summary-row">
                    <div class="d-flex align-items-center">
                        <div class="summary-icon" style="background:#FEF9C3;color:#CA8A04;"><i class="fa-solid fa-star"></i></div>
                        <span class="summary-label">Total Rating</span>
                    </div>
                    <span class="summary-count">{{ $totalRating ?? 0 }}</span>
                </div>
            </div>
        </div>

        {{-- Payment Terbaru --}}
        <div class="card side-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="card-title">
                    <i class="fa-solid fa-money-bill-wave" style="color:#059669;"></i>
                    Payment Terbaru
                </h6>
                <a href="{{ route('payments.index') }}" style="font-size:.72rem;color:#2563EB;text-decoration:none;font-weight:600;">Semua →</a>
            </div>
            <div class="card-body">
                @forelse($latestPayment as $payment)
                <div class="mini-row">
                    <div class="d-flex align-items-center gap-2">
                        <div class="mini-avatar">{{ strtoupper(substr($payment->order->user->name ?? 'U', 0, 1)) }}</div>
                        <div>
                            <div class="mini-name">{{ $payment->order->user->name ?? '-' }}</div>
                            <div class="mini-sub">Rp {{ number_format($payment->amount ?? 0, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    @php
                        $pcls = match($payment->status ?? 'pending') {
                            'verified' => 'badge-verified',
                            'rejected' => 'badge-rejected',
                            default    => 'badge-pending',
                        };
                    @endphp
                    <span class="badge {{ $pcls }}">{{ ucfirst($payment->status ?? 'pending') }}</span>
                </div>
                @empty
                <div class="empty-state">
                    <i class="fa-solid fa-receipt"></i>
                    Belum ada payment
                </div>
                @endforelse
            </div>
        </div>

        {{-- Rating Terbaru --}}
        <div class="card side-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="card-title">
                    <i class="fa-solid fa-star" style="color:#CA8A04;"></i>
                    Rating Terbaru
                </h6>
                <a href="{{ route('ratings.index') }}" style="font-size:.72rem;color:#2563EB;text-decoration:none;font-weight:600;">Semua →</a>
            </div>
            <div class="card-body">
                @forelse($latestRatings as $rating)
                <div class="mini-row">
                    <div class="d-flex align-items-center gap-2">
                        <div class="mini-avatar">{{ strtoupper(substr($rating->user->name ?? 'U', 0, 1)) }}</div>
                        <div>
                            <div class="mini-name">{{ $rating->user->name ?? '-' }}</div>
                            <div style="line-height:1;margin:2px 0;">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa-solid fa-star {{ $i <= ($rating->rating ?? 0) ? 'star-filled' : 'star-empty' }}"></i>
                                @endfor
                            </div>
                            <div class="mini-sub" style="max-width:140px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                {{ Str::limit($rating->review ?? '', 45) }}
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <i class="fa-solid fa-star"></i>
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
document.addEventListener('DOMContentLoaded', () => {
    // Counter animation
    document.querySelectorAll('.stat-value').forEach(el => {
        const raw = el.textContent.trim();
        if (raw.includes('Rp')) return;
        const num = parseInt(raw.replace(/[^0-9]/g, ''));
        if (isNaN(num) || num === 0) return;
        let start = 0;
        const step = Math.ceil(num / 50);
        const timer = setInterval(() => {
            start = Math.min(start + step, num);
            el.textContent = start.toLocaleString('id-ID');
            if (start >= num) clearInterval(timer);
        }, 16);
    });
});
</script>
@endsection