@extends('base.base-admin-index')

@php $menu = 'Pesanan'; $submenu = 'Pesanan'; $subdesc = 'Kelola semua pesanan masuk'; @endphp

@section('custom-css')
<style>
/* =============================================================
   RESET DASAR — pastikan icon Bootstrap tidak kena override
   ============================================================= */
.bi { font-family: "bootstrap-icons" !important; line-height: 1 !important; }

/* =============================================================
   STAT CARDS
   ============================================================= */
.stat-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 14px;
    margin-bottom: 24px;
}
@media (max-width: 900px) { .stat-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 560px) { .stat-grid { grid-template-columns: repeat(2, 1fr); } }

.stat-card {
    background: var(--tg-glass);
    backdrop-filter: var(--tg-blur);
    border: 1px solid var(--tg-glass-border);
    border-radius: 14px;
    box-shadow: var(--tg-sh-sm);
    padding: 18px 16px 14px;
    position: relative;
    overflow: hidden;
}
.stat-card-accent {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 3px;
    border-radius: 0 0 14px 14px;
}
.stat-card-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 12px;
}
.stat-card-icon {
    width: 40px; height: 40px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    font-size: 1.05rem;
    line-height: 1;
}
/* icon fix: pastikan tidak dipengaruhi font-family override */
.stat-card-icon .bi {
    font-family: "bootstrap-icons" !important;
    line-height: 1 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
}
.stat-card-badge {
    font-size: .62rem;
    font-weight: 700;
    letter-spacing: .04em;
    padding: 3px 8px;
    border-radius: 100px;
    line-height: 1.2;
    white-space: nowrap;
}
.stat-card-num {
    font-size: 1.75rem;
    font-weight: 800;
    line-height: 1;
    color: var(--tg-text);
    margin-bottom: 4px;
}
.stat-card-lbl {
    font-size: .63rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: var(--tg-text-3);
}

/* =============================================================
   TABLE CARD
   ============================================================= */
.orders-card {
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid var(--tg-glass-border);
    box-shadow: var(--tg-sh-sm);
}
.orders-card-head {
    background: linear-gradient(135deg, #0A1628 0%, #1E3A8A 100%);
    padding: 16px 20px 0;
}
.orders-card-title {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 12px;
}
.orders-card-title h5 {
    color: #fff;
    font-size: .92rem;
    font-weight: 700;
    margin: 0;
    line-height: 1;
}
.orders-card-title .total-pill {
    background: rgba(255,255,255,.15);
    color: rgba(255,255,255,.8);
    font-size: .7rem;
    font-weight: 700;
    padding: 2px 9px;
    border-radius: 100px;
    line-height: 1.4;
}

/* ── Search box (di dalam header gelap) ── */
.head-search {
    position: relative;
    margin-left: auto;
}
.head-search .bi {
    position: absolute;
    left: 10px; top: 50%;
    transform: translateY(-50%);
    color: rgba(255,255,255,.5);
    font-size: 13px;
    line-height: 1;
    pointer-events: none;
    font-family: "bootstrap-icons" !important;
}
.head-search input {
    background: rgba(255,255,255,.1);
    border: 1.5px solid rgba(255,255,255,.2);
    border-radius: 8px;
    color: #fff;
    font-size: .8rem;
    padding: 6px 12px 6px 30px;
    outline: none;
    width: 200px;
    transition: border-color .15s, width .2s;
}
.head-search input:focus {
    border-color: rgba(255,255,255,.5);
    width: 230px;
}
.head-search input::placeholder { color: rgba(255,255,255,.4); }

/* ── Filter tabs ── */
.filter-tabs {
    display: flex;
    gap: 2px;
    flex-wrap: wrap;
    border-top: 1px solid rgba(255,255,255,.1);
    padding-top: 2px;
}
.filter-tab {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: .75rem;
    font-weight: 600;
    color: rgba(255,255,255,.55);
    padding: 8px 14px;
    border-radius: 0;
    border: none;
    background: transparent;
    text-decoration: none;
    cursor: pointer;
    transition: color .15s, background .15s;
    border-bottom: 2px solid transparent;
    line-height: 1;
}
.filter-tab:hover { color: rgba(255,255,255,.85); }
.filter-tab.active {
    color: #fff;
    border-bottom-color: #60A5FA;
}
.filter-tab .cnt {
    background: rgba(255,255,255,.15);
    border-radius: 100px;
    padding: 1px 6px;
    font-size: .65rem;
    line-height: 1.4;
}
.filter-tab.active .cnt {
    background: #2563EB;
}

/* =============================================================
   TABLE
   ============================================================= */
.tg-table { border-collapse: collapse; width: 100%; }
.tg-table thead th {
    font-size: .66rem !important;
    font-weight: 700 !important;
    text-transform: uppercase !important;
    letter-spacing: .07em !important;
    color: var(--tg-text-3) !important;
    background: var(--tg-glass) !important;
    border-bottom: 1px solid var(--tg-border) !important;
    padding: 10px 14px !important;
    white-space: nowrap;
    vertical-align: middle !important;
}
.tg-table tbody td {
    padding: 12px 14px !important;
    vertical-align: middle !important;
    font-size: .82rem !important;
    border-bottom: 1px solid var(--tg-border) !important;
    color: var(--tg-text) !important;
}
.tg-table tbody tr:last-child td { border-bottom: none !important; }
.tg-table tbody tr:hover td { background: rgba(59,130,246,.04) !important; }

/* =============================================================
   BADGES
   ============================================================= */
.tg-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: .67rem;
    font-weight: 700;
    padding: 3px 9px;
    border-radius: 100px;
    white-space: nowrap;
    line-height: 1.3;
    vertical-align: middle;
}
/* pastikan icon di dalam badge tidak kena font override */
.tg-badge .bi {
    font-family: "bootstrap-icons" !important;
    font-size: .65rem !important;
    line-height: 1 !important;
    display: inline-flex !important;
    align-items: center !important;
}
.tg-badge-pending   { background: #FEF3C7; color: #92400E; }
.tg-badge-confirmed { background: #DBEAFE; color: #1E40AF; }
.tg-badge-completed { background: #D1FAE5; color: #065F46; }
.tg-badge-cancelled { background: #FEE2E2; color: #991B1B; }
.tg-badge-pay-ok    { background: #D1FAE5; color: #065F46; }
.tg-badge-pay-wait  { background: #FEF3C7; color: #92400E; }
.tg-badge-pay-rej   { background: #FEE2E2; color: #991B1B; }
.tg-badge-pay-none  { background: #F3F4F6; color: #9CA3AF; }

[data-theme="dark"] .tg-badge-pending   { background: rgba(254,243,199,.15); color: #FCD34D; }
[data-theme="dark"] .tg-badge-confirmed { background: rgba(219,234,254,.12); color: #93C5FD; }
[data-theme="dark"] .tg-badge-completed { background: rgba(209,250,229,.12); color: #6EE7B7; }
[data-theme="dark"] .tg-badge-cancelled { background: rgba(254,226,226,.12); color: #FCA5A5; }
[data-theme="dark"] .tg-badge-pay-none  { background: rgba(255,255,255,.07); color: #9CA3AF; }

/* =============================================================
   MINI AVATAR
   ============================================================= */
.tg-mini-av {
    width: 32px; height: 32px;
    border-radius: 9px;
    background: linear-gradient(135deg, #0A1628, #2563EB);
    color: #fff;
    font-size: .68rem; font-weight: 700;
    display: inline-flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    line-height: 1;
}

/* =============================================================
   WA BUTTON
   ============================================================= */
.btn-wa {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 7px;
    font-size: .74rem;
    font-weight: 600;
    background: #25D366;
    color: #fff;
    border: none;
    text-decoration: none;
    transition: background .15s, transform .1s;
    line-height: 1.3;
    white-space: nowrap;
}
.btn-wa:hover { background: #1ebe5d; color: #fff; transform: translateY(-1px); }
.btn-wa .bi {
    font-family: "bootstrap-icons" !important;
    font-size: .85rem !important;
    line-height: 1 !important;
}
.btn-wa-none {
    font-size: .72rem;
    color: var(--tg-text-3);
    font-style: italic;
}

/* =============================================================
   ACTION BUTTONS
   ============================================================= */
.tg-btn-act {
    padding: 4px 8px !important;
    font-size: .72rem !important;
    border-radius: 6px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 3px;
    line-height: 1 !important;
}
.tg-btn-act .bi {
    font-family: "bootstrap-icons" !important;
    font-size: .8rem !important;
    line-height: 1 !important;
}

/* =============================================================
   PAGINATION
   ============================================================= */
.tg-pagination {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
    padding: 12px 20px;
    border-top: 1px solid var(--tg-border);
    background: var(--tg-glass);
}
.tg-pag-info {
    font-size: .76rem;
    color: var(--tg-text-3);
}
.pagination { margin: 0 !important; gap: 3px; }
.pagination .page-link {
    font-size: .75rem !important;
    border-radius: 7px !important;
    border: 1px solid var(--tg-border) !important;
    color: var(--tg-text-2) !important;
    background: var(--tg-glass) !important;
    padding: 5px 11px !important;
    line-height: 1.3 !important;
    transition: all .15s;
}
.pagination .page-item.active .page-link {
    background: var(--tg-royal) !important;
    border-color: var(--tg-royal) !important;
    color: #fff !important;
}
.pagination .page-item.disabled .page-link { opacity: .4 !important; }

/* =============================================================
   EMPTY STATE
   ============================================================= */
.tg-empty {
    text-align: center; padding: 52px 20px;
    color: var(--tg-text-3);
}
.tg-empty .bi {
    font-family: "bootstrap-icons" !important;
    font-size: 2.5rem !important;
    line-height: 1 !important;
    opacity: .25;
    display: block;
    margin-bottom: 12px;
}
.tg-empty p { font-size: .84rem; margin: 0; }

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

{{-- ══════════════════════════════════════════
     STAT CARDS
═══════════════════════════════════════════ --}}
<p class="section-label">Statistik Pesanan</p>
<div class="stat-grid mb-4">

    @php
        $statCards = [
            [
                'label'  => 'Total Order',
                'val'    => $totalOrders ?? 0,
                'icon'   => 'bi-list-ul',
                'ic_bg'  => 'rgba(59,130,246,.12)',
                'ic_cl'  => '#2563EB',
                'badge'  => 'Semua',
                'bd_bg'  => 'rgba(59,130,246,.12)',
                'bd_cl'  => '#2563EB',
                'accent' => '#3B82F6',
            ],
            [
                'label'  => 'Pending',
                'val'    => $totalPending ?? 0,
                'icon'   => 'bi-clock',
                'ic_bg'  => 'rgba(217,119,6,.12)',
                'ic_cl'  => '#D97706',
                'badge'  => 'Perlu aksi',
                'bd_bg'  => 'rgba(217,119,6,.12)',
                'bd_cl'  => '#D97706',
                'accent' => '#F59E0B',
            ],
            [
                'label'  => 'Dikonfirmasi',
                'val'    => $totalConfirmed ?? 0,
                'icon'   => 'bi-check-circle',
                'ic_bg'  => 'rgba(37,99,235,.12)',
                'ic_cl'  => '#2563EB',
                'badge'  => 'Aktif',
                'bd_bg'  => 'rgba(37,99,235,.12)',
                'bd_cl'  => '#2563EB',
                'accent' => '#2563EB',
            ],
            [
                'label'  => 'Selesai',
                'val'    => $totalCompleted ?? 0,
                'icon'   => 'bi-camera',
                'ic_bg'  => 'rgba(5,150,105,.12)',
                'ic_cl'  => '#059669',
                'badge'  => 'Berhasil',
                'bd_bg'  => 'rgba(5,150,105,.12)',
                'bd_cl'  => '#059669',
                'accent' => '#10B981',
            ],
            [
                'label'  => 'Dibatalkan',
                'val'    => $totalCancelled ?? 0,
                'icon'   => 'bi-x-circle',
                'ic_bg'  => 'rgba(220,38,38,.12)',
                'ic_cl'  => '#DC2626',
                'badge'  => 'Dibatalkan',
                'bd_bg'  => 'rgba(220,38,38,.12)',
                'bd_cl'  => '#DC2626',
                'accent' => '#EF4444',
            ],
        ];
    @endphp

    @foreach($statCards as $s)
    <div class="stat-card">
        <div class="stat-card-top">
            {{-- Icon box --}}
            <div class="stat-card-icon" style="background:{{ $s['ic_bg'] }};">
                <i class="bi {{ $s['icon'] }}" style="color:{{ $s['ic_cl'] }};"></i>
            </div>
            {{-- Badge label --}}
            <span class="stat-card-badge"
                  style="background:{{ $s['bd_bg'] }}; color:{{ $s['bd_cl'] }};">
                {{ $s['badge'] }}
            </span>
        </div>
        <div class="stat-card-num">{{ $s['val'] }}</div>
        <div class="stat-card-lbl">{{ $s['label'] }}</div>
        {{-- Bottom accent line --}}
        <div class="stat-card-accent" style="background:{{ $s['accent'] }};"></div>
    </div>
    @endforeach

</div>

{{-- ══════════════════════════════════════════
     TABLE CARD
═══════════════════════════════════════════ --}}
<p class="section-label">Daftar Pesanan</p>
<div class="orders-card">

    {{-- ── Dark header: title + search + filter tabs ── --}}
    <div class="orders-card-head">
        <div class="orders-card-title">
            <span style="width:4px;height:18px;background:#60A5FA;border-radius:100px;flex-shrink:0;display:block;"></span>
            <h5>Daftar Pesanan</h5>
            <span class="total-pill">{{ $orders->total() }} total</span>

            {{-- Search --}}
            <div class="head-search">
                <i class="bi bi-search"></i>
                <input type="text" id="searchInput" placeholder="Cari customer / paket…">
            </div>
        </div>

        {{-- Filter tabs ── server-side by status --}}
        @php
            $filterTabs = [
                'all'       => ['Semua',       $totalOrders    ?? 0],
                'pending'   => ['Pending',      $totalPending   ?? 0],
                'confirmed' => ['Dikonfirmasi', $totalConfirmed ?? 0],
                'completed' => ['Selesai',      $totalCompleted ?? 0],
                'cancelled' => ['Batal',        $totalCancelled ?? 0],
            ];
            $activeTab = request('status', 'all');
        @endphp
        <div class="filter-tabs">
            @foreach($filterTabs as $key => [$lbl, $cnt])
            <a href="{{ request()->fullUrlWithQuery(['status' => $key, 'page' => 1]) }}"
               class="filter-tab {{ $activeTab === $key ? 'active' : '' }}">
                {{ $lbl }}
                <span class="cnt">{{ $cnt }}</span>
            </a>
            @endforeach
        </div>
    </div>

    {{-- ── Table ── --}}
    <div style="overflow-x:auto;">
        <table class="tg-table" id="ordersTable">
            <thead>
                <tr>
                    <th style="padding-left:20px !important; width:72px;">#</th>
                    <th style="min-width:160px;">Customer</th>
                    <th style="min-width:140px;">Paket</th>
                    <th style="min-width:120px;">Tanggal Sesi</th>
                    <th style="min-width:100px;">Waktu</th>
                    <th style="min-width:110px;">Total</th>
                    <th style="min-width:90px;">Pembayaran</th>
                    <th style="min-width:110px;">Status</th>
                    <th style="min-width:100px;">Hubungi</th>
                    <th class="text-center" style="padding-right:20px !important; min-width:120px;">Aksi</th>
                </tr>
            </thead>
            <tbody id="ordersBody">
                @forelse($orders as $order)
                @php
                    $badgeClass  = 'tg-badge-' . $order->status;
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
                    $ps = $order->payment->payment_status ?? 'none';
                    $payClass = match($ps) {
                        'verified' => 'tg-badge-pay-ok',
                        'rejected' => 'tg-badge-pay-rej',
                        'pending'  => 'tg-badge-pay-wait',
                        default    => 'tg-badge-pay-none',
                    };
                    $payLabel = match($ps) {
                        'verified' => 'Lunas',
                        'rejected' => 'Ditolak',
                        'pending'  => 'Menunggu',
                        default    => 'Belum Bayar',
                    };
                    // Format nomor WA: hilangkan karakter non-digit, ganti 0 awal dengan 62
                    $rawPhone = preg_replace('/\D/', '', $order->user->phone ?? '');
                    $waNumber = $rawPhone ? (str_starts_with($rawPhone, '0') ? '62' . substr($rawPhone, 1) : $rawPhone) : null;
                    $waMsg = urlencode('Halo ' . ($order->user->name ?? 'Kak') . ', kami dari Telegrad ingin mengkonfirmasi pesanan Anda Order #' . str_pad($order->id, 5, '0', STR_PAD_LEFT) . '.');
                @endphp
                <tr>
                    {{-- # --}}
                    <td style="padding-left:20px !important;">
                        <span style="font-size:.69rem; font-weight:700; color:var(--tg-text-3);">
                            #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                        </span>
                    </td>

                    {{-- Customer --}}
                    <td>
                        <div style="display:flex; align-items:center; gap:9px;">
                            <div class="tg-mini-av">{{ strtoupper(substr($order->user->name ?? 'U', 0, 1)) }}</div>
                            <div>
                                <div style="font-weight:700; font-size:.83rem; line-height:1.3;">{{ $order->user->name ?? '-' }}</div>
                                <div style="font-size:.71rem; color:var(--tg-text-3); line-height:1.3;">{{ $order->user->email ?? '' }}</div>
                            </div>
                        </div>
                    </td>

                    {{-- Paket --}}
                    <td>
                        <div style="font-weight:600; font-size:.83rem; line-height:1.3;">{{ $order->package->name ?? '-' }}</div>
                        <div style="font-size:.71rem; color:var(--tg-text-3); line-height:1.3;">{{ $order->package->category->name ?? '' }}</div>
                    </td>

                    {{-- Tanggal --}}
                    <td>
                        <div style="font-size:.83rem; line-height:1.3;">{{ \Carbon\Carbon::parse($order->booking_date)->isoFormat('D MMM YYYY') }}</div>
                        <div style="font-size:.71rem; color:var(--tg-text-3); line-height:1.3;">{{ \Carbon\Carbon::parse($order->booking_date)->isoFormat('dddd') }}</div>
                    </td>

                    {{-- Waktu --}}
                    <td>
                        <span style="font-size:.82rem; color:var(--tg-text-2); white-space:nowrap;">
                            {{ \Carbon\Carbon::parse($order->start_time)->format('H:i') }} – {{ \Carbon\Carbon::parse($order->end_time)->format('H:i') }}
                        </span>
                    </td>

                    {{-- Total --}}
                    <td>
                        <span style="font-weight:700; font-size:.86rem; white-space:nowrap; color:var(--tg-text);">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </span>
                    </td>

                    {{-- Pembayaran --}}
                    <td>
                        <span class="tg-badge {{ $payClass }}">{{ $payLabel }}</span>
                    </td>

                    {{-- Status --}}
                    <td>
                        <span class="tg-badge {{ $badgeClass }}">
                            <i class="bi {{ $statusIcon }}"></i>{{ $statusLabel }}
                        </span>
                    </td>

                    {{-- Hubungi via WA --}}
                    <td>
                        @if($waNumber)
                        <a href="https://wa.me/{{ $waNumber }}?text={{ $waMsg }}"
                           target="_blank" class="btn-wa" title="Hubungi via WhatsApp">
                            <i class="bi bi-whatsapp"></i> WA
                        </a>
                        @else
                        <span class="btn-wa-none">Tidak ada</span>
                        @endif
                    </td>

                    {{-- Aksi --}}
                    <td style="padding-right:20px !important;">
                        <div style="display:flex; align-items:center; gap:4px; justify-content:center; flex-wrap:wrap;">
                            {{-- Detail --}}
                            <a href="{{ route('orders.show', $order->id) }}"
                               class="btn btn-sm btn-outline-primary tg-btn-act" title="Lihat Detail">
                                <i class="bi bi-eye"></i>
                            </a>

                            {{-- Konfirmasi (pending) --}}
                            @if($order->status === 'pending')
                            <form action="{{ route('admin.orders.confirm', $order->id) }}" method="POST" class="d-inline m-0">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success tg-btn-act" title="Konfirmasi"
                                        onclick="return confirm('Konfirmasi order ini?')">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                            </form>
                            @endif

                            {{-- Selesaikan (confirmed) --}}
                            @if($order->status === 'confirmed')
                            <form action="{{ route('admin.orders.complete', $order->id) }}" method="POST" class="d-inline m-0">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-info tg-btn-act" title="Tandai Selesai"
                                        onclick="return confirm('Tandai order ini selesai?')">
                                    <i class="bi bi-camera"></i>
                                </button>
                            </form>
                            @endif

                            {{-- Batalkan --}}
                            @if(!in_array($order->status, ['completed', 'cancelled']))
                            <form action="{{ route('admin.orders.cancel', $order->id) }}" method="POST" class="d-inline m-0">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-warning tg-btn-act" title="Batalkan"
                                        onclick="return confirm('Batalkan order ini?')">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </form>
                            @endif

                            {{-- Hapus --}}
                            <form id="delete-form-{{ $order->id }}"
                                  action="{{ route('orders.destroy', $order->id) }}" method="POST" class="d-inline m-0">
                                @csrf @method('DELETE')
                                <button type="button" onclick="deleteData({{ $order->id }})"
                                        class="btn btn-sm btn-outline-danger tg-btn-act" title="Hapus">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10">
                        <div class="tg-empty">
                            <i class="bi bi-inbox"></i>
                            <p>Belum ada pesanan{{ $activeTab !== 'all' ? ' dengan status ini' : '' }}</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ── Pagination ── --}}
    @if($orders->hasPages())
    <div class="tg-pagination">
        <span class="tg-pag-info">
            Menampilkan <strong>{{ $orders->firstItem() }}</strong>–<strong>{{ $orders->lastItem() }}</strong>
            dari <strong>{{ $orders->total() }}</strong> pesanan
        </span>
        <div>
            {{ $orders->appends(request()->query())->links() }}
        </div>
    </div>
    @endif

</div>

@endsection

@section('custom-js')
<script>
/* Search client-side (dalam halaman ini).
   Untuk search lintas halaman, kirim via ?search= ke controller. */
document.getElementById('searchInput').addEventListener('input', function () {
    const q = this.value.toLowerCase().trim();
    document.querySelectorAll('#ordersBody tr').forEach(function (row) {
        if (!row.querySelector('td')) return;
        row.style.display = (!q || row.textContent.toLowerCase().includes(q)) ? '' : 'none';
    });
});
</script>
@endsection