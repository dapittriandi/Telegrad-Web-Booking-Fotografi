@extends('base.base-root-index')

@push('css')
<style>
/* ─── DESIGN TOKENS ──────────────────────────────────────── */
:root {
    --gold:        #c8a96e;
    --gold-light:  #e2c98a;
    --gold-dim:    rgba(200,169,110,.10);
    --gold-border: rgba(200,169,110,.20);
    --bg-page:     #0b0c0e;
    --bg-card:     #111316;
    --bg-card-2:   #16181c;
    --text:        #f0ede8;
    --muted:       #6e6c68;
    --success:     #4caf82;
    --danger:      #e05c5c;
    --info:        #5b9bd5;
    --warning:     #e0a935;
    --radius:      12px;
    --radius-sm:   8px;
    --trans:       .22s cubic-bezier(.4,0,.2,1);
}

body { background: var(--bg-page); }

/* ─── Page header ────────────────────────────────────────── */
.page-header {
    background: var(--bg-card);
    border-bottom: 1px solid rgba(255,255,255,.05);
    padding-top: 72px; /* clearance navbar */
}
.page-header-inner {
    padding: 36px 0 28px;
    display: flex; align-items: flex-end; justify-content: space-between;
    flex-wrap: wrap; gap: 16px;
}
.page-header-eyebrow {
    font-size: .65rem; font-weight: 700; letter-spacing: .2em;
    text-transform: uppercase; color: var(--gold);
    display: inline-flex; align-items: center; gap: 6px;
    margin-bottom: 10px;
}
.page-header h1 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.4rem, 3vw, 1.9rem);
    color: var(--text); font-weight: 700; margin: 0 0 5px;
    letter-spacing: -.02em;
}
.page-header-sub { font-size: .875rem; color: var(--muted); margin: 0; }
.page-header-sub strong { color: var(--gold-light); font-weight: 600; }

.btn-new-order {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 10px 20px; border-radius: var(--radius-sm);
    font-size: .79rem; font-weight: 700;
    letter-spacing: .07em; text-transform: uppercase;
    color: #0d0d0d; background: var(--gold); text-decoration: none;
    transition: opacity var(--trans), transform var(--trans), box-shadow var(--trans);
}
.btn-new-order:hover {
    opacity: .88; color: #0d0d0d;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(200,169,110,.25);
}

/* ─── Main section ───────────────────────────────────────── */
.orders-section { padding: 32px 0 80px; }

/* ─── Stats ──────────────────────────────────────────────── */
.stat-row {
    display: grid; grid-template-columns: repeat(4,1fr);
    gap: 10px; margin-bottom: 28px;
}
@media(max-width:640px) { .stat-row { grid-template-columns: repeat(2,1fr); } }

.stat-card {
    background: var(--bg-card);
    border: 1px solid rgba(255,255,255,.06);
    border-radius: var(--radius); padding: 16px 14px;
    display: flex; align-items: center; gap: 12px;
    transition: border-color var(--trans), transform var(--trans), background var(--trans);
}
.stat-card:hover { border-color: var(--gold-border); transform: translateY(-2px); background: var(--bg-card-2); }

.stat-icon {
    width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center; font-size: 1rem;
}
.stat-icon.gold  { background: var(--gold-dim); color: var(--gold); border: 1px solid var(--gold-border); }
.stat-icon.blue  { background: rgba(91,155,213,.1); color: var(--info); border: 1px solid rgba(91,155,213,.18); }
.stat-icon.green { background: rgba(76,175,130,.1); color: var(--success); border: 1px solid rgba(76,175,130,.18); }
.stat-icon.red   { background: rgba(224,92,92,.1); color: var(--danger); border: 1px solid rgba(224,92,92,.18); }

.stat-val   { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 700; color: var(--text); line-height: 1; margin-bottom: 2px; }
.stat-label { font-size: .67rem; color: var(--muted); text-transform: uppercase; letter-spacing: .1em; }

/* ─── Filter bar ─────────────────────────────────────────── */
.filter-bar {
    display: flex; align-items: center; gap: 4px;
    flex-wrap: wrap; margin-bottom: 16px;
    background: var(--bg-card);
    border: 1px solid rgba(255,255,255,.06);
    border-radius: var(--radius); padding: 7px;
}
.filter-btn {
    padding: 6px 14px; font-size: .72rem; font-weight: 600;
    letter-spacing: .05em; text-transform: uppercase;
    color: var(--muted); border: none;
    border-radius: var(--radius-sm); background: transparent; cursor: pointer;
    transition: all var(--trans);
}
.filter-btn:hover  { color: var(--text); background: rgba(255,255,255,.05); }
.filter-btn.active { background: var(--gold-dim); color: var(--gold); }

/* ─── Order card ─────────────────────────────────────────── */
.order-card {
    background: var(--bg-card);
    border: 1px solid rgba(255,255,255,.06);
    border-radius: var(--radius); overflow: hidden;
    margin-bottom: 10px;
    transition: border-color var(--trans), box-shadow var(--trans), background var(--trans);
}
.order-card:hover {
    border-color: var(--gold-border);
    box-shadow: 0 6px 28px rgba(0,0,0,.22);
    background: var(--bg-card-2);
}

.order-card-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 10px 18px;
    border-bottom: 1px solid rgba(255,255,255,.04);
    background: rgba(255,255,255,.012);
    flex-wrap: wrap; gap: 8px;
}
.order-id   { font-size: .7rem; color: var(--muted); font-family: monospace; letter-spacing: .08em; }
.order-date { font-size: .71rem; color: var(--muted); display: flex; align-items: center; gap: 4px; }

.order-card-body {
    display: flex; align-items: center; gap: 14px;
    padding: 14px 18px; flex-wrap: wrap;
}
.order-pkg-thumb {
    width: 44px; height: 44px; border-radius: 10px; flex-shrink: 0;
    background: var(--gold-dim); border: 1px solid var(--gold-border);
    display: flex; align-items: center; justify-content: center;
    color: var(--gold); font-size: 1.05rem;
}
.order-pkg-info { flex: 1; min-width: 0; }
.order-pkg-name {
    font-family: 'Playfair Display', serif;
    font-size: .9rem; font-weight: 700; color: var(--text);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 2px;
}
.order-pkg-cat { font-size: .72rem; color: var(--muted); }
.order-price   { font-family: 'Playfair Display', serif; font-size: .98rem; font-weight: 700; color: var(--gold); white-space: nowrap; }

.order-card-footer {
    display: flex; align-items: center; justify-content: space-between;
    padding: 10px 18px;
    border-top: 1px solid rgba(255,255,255,.04);
    flex-wrap: wrap; gap: 8px;
}
.order-meta { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
.order-meta-item { font-size: .72rem; color: var(--muted); display: flex; align-items: center; gap: 4px; }
.order-meta-item i { color: var(--gold); font-size: .68rem; }

/* ─── Status badges ──────────────────────────────────────── */
.status-badge {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 3px 10px; border-radius: 100px;
    font-size: .66rem; font-weight: 700;
    letter-spacing: .05em; text-transform: uppercase;
}
.status-pending   { background: rgba(224,169,53,.1); border: 1px solid rgba(224,169,53,.2); color: var(--warning); }
.status-confirmed { background: rgba(91,155,213,.1); border: 1px solid rgba(91,155,213,.2); color: var(--info); }
.status-completed { background: rgba(76,175,130,.1); border: 1px solid rgba(76,175,130,.2); color: var(--success); }
.status-cancelled { background: rgba(224,92,92,.1);  border: 1px solid rgba(224,92,92,.2);  color: var(--danger); }
.status-paid      { background: rgba(139,92,246,.1); border: 1px solid rgba(139,92,246,.2); color: #a78bfa; }
.status-process   { background: rgba(249,115,22,.1); border: 1px solid rgba(249,115,22,.2); color: #fb923c; }

/* ─── Buttons ────────────────────────────────────────────── */
.btn-action-wrap { display: flex; gap: 6px; align-items: center; }

.btn-detail {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 6px 14px; border-radius: var(--radius-sm); font-size: .73rem; font-weight: 600;
    color: var(--gold); border: 1px solid var(--gold-border);
    background: var(--gold-dim); text-decoration: none;
    transition: background var(--trans), transform var(--trans);
}
.btn-detail:hover { background: rgba(200,169,110,.18); color: var(--gold-light); transform: translateY(-1px); }

.btn-pay {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 6px 14px; border-radius: var(--radius-sm); font-size: .73rem; font-weight: 700;
    color: #0d0d0d; background: var(--gold); text-decoration: none;
    transition: opacity var(--trans), transform var(--trans);
}
.btn-pay:hover { opacity: .85; color: #0d0d0d; transform: translateY(-1px); }

.btn-drive {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 6px 14px; border-radius: var(--radius-sm); font-size: .73rem; font-weight: 600;
    color: var(--success); border: 1px solid rgba(76,175,130,.22);
    background: rgba(76,175,130,.07); text-decoration: none;
    transition: background var(--trans), transform var(--trans);
}
.btn-drive:hover { background: rgba(76,175,130,.14); transform: translateY(-1px); }

/* ─── Empty state ────────────────────────────────────────── */
.empty-state {
    text-align: center; padding: 60px 24px;
    background: var(--bg-card);
    border: 1px solid rgba(255,255,255,.06);
    border-radius: var(--radius);
}
.empty-icon {
    width: 60px; height: 60px; border-radius: 14px; margin: 0 auto 16px;
    background: var(--gold-dim); border: 1px solid var(--gold-border);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem; color: var(--gold);
}
.empty-title { font-family: 'Playfair Display', serif; font-size: 1rem; color: var(--text); margin-bottom: 6px; }
.empty-desc  { font-size: .83rem; color: var(--muted); margin-bottom: 20px; line-height: 1.7; }

.no-result-msg {
    text-align: center; padding: 36px;
    font-size: .84rem; color: var(--muted); display: none;
}
</style>
@endpush

@section('content')
<main id="main">

{{-- PAGE HEADER --}}
<div class="page-header">
    <div class="container">
        <div class="page-header-inner">
            <div>
                <div class="page-header-eyebrow"><i class="bi bi-list-check"></i> Riwayat</div>
                <h1>Riwayat Order</h1>
                <p class="page-header-sub">
                    Halo, <strong>{{ Auth::user()->name }}</strong> — berikut semua pesanan kamu.
                </p>
            </div>
            <a href="{{ route('packages.categories') }}" class="btn-new-order">
                <i class="bi bi-plus-lg"></i> Pesan Baru
            </a>
        </div>
    </div>
</div>

<section class="orders-section">
<div class="container">

    {{-- Flash --}}
    @if(session('success'))
    <div style="background:rgba(76,175,130,.07);border:1px solid rgba(76,175,130,.2);border-radius:8px;padding:12px 16px;font-size:.84rem;color:#5dcaa5;display:flex;align-items:center;gap:10px;margin-bottom:20px;">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    </div>
    @endif

    {{-- Stats --}}
    @php
        $allOrders    = Auth::user()->orders();
        $totalAll     = (clone $allOrders)->count();
        $processAll   = (clone $allOrders)->whereIn('status', ['pending','confirmed'])->count();
        $completedAll = (clone $allOrders)->where('status', 'completed')->count();
        $cancelledAll = (clone $allOrders)->where('status', 'cancelled')->count();
    @endphp

    <div class="stat-row" data-aos="fade-up">
        <div class="stat-card">
            <div class="stat-icon gold"><i class="bi bi-bag-check"></i></div>
            <div><div class="stat-val">{{ $totalAll }}</div><div class="stat-label">Total Order</div></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue"><i class="bi bi-hourglass-split"></i></div>
            <div><div class="stat-val">{{ $processAll }}</div><div class="stat-label">Diproses</div></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class="bi bi-check-circle"></i></div>
            <div><div class="stat-val">{{ $completedAll }}</div><div class="stat-label">Selesai</div></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red"><i class="bi bi-x-circle"></i></div>
            <div><div class="stat-val">{{ $cancelledAll }}</div><div class="stat-label">Dibatalkan</div></div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="filter-bar" data-aos="fade-up">
        <button class="filter-btn active" data-filter="all">Semua</button>
        <button class="filter-btn" data-filter="pending">Menunggu</button>
        <button class="filter-btn" data-filter="confirmed">Dikonfirmasi</button>
        <button class="filter-btn" data-filter="completed">Selesai</button>
        <button class="filter-btn" data-filter="cancelled">Dibatalkan</button>
    </div>

    {{-- Order list --}}
    <div id="orderList" data-aos="fade-up">
        @forelse($orders as $order)
        @php
            $statusMap = [
                'pending'   => ['label' => 'Menunggu',       'class' => 'status-pending'],
                'confirmed' => ['label' => 'Dikonfirmasi',   'class' => 'status-confirmed'],
                'paid'      => ['label' => 'Sudah Dibayar',  'class' => 'status-paid'],
                'process'   => ['label' => 'Diproses',       'class' => 'status-process'],
                'completed' => ['label' => 'Selesai',        'class' => 'status-completed'],
                'cancelled' => ['label' => 'Dibatalkan',     'class' => 'status-cancelled'],
            ];
            $s  = $statusMap[$order->status] ?? ['label' => ucfirst($order->status), 'class' => 'status-pending'];
            $ps = $order->payment->payment_status ?? null;
        @endphp

        <div class="order-card" data-status="{{ $order->status }}">

            <div class="order-card-header">
                <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                    <span class="order-id">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                    <span class="status-badge {{ $s['class'] }}">{{ $s['label'] }}</span>
                </div>
                <span class="order-date">
                    <i class="bi bi-calendar3"></i>
                    {{ \Carbon\Carbon::parse($order->created_at)->isoFormat('D MMM YYYY') }}
                </span>
            </div>

            <div class="order-card-body">
                <div class="order-pkg-thumb"><i class="bi bi-camera2"></i></div>
                <div class="order-pkg-info">
                    <div class="order-pkg-name">{{ $order->package->name ?? 'Paket tidak ditemukan' }}</div>
                    <div class="order-pkg-cat">{{ $order->package->category->name ?? '' }}</div>
                </div>
                <div class="order-price">
                    Rp {{ number_format($order->package->price ?? 0, 0, ',', '.') }}
                </div>
            </div>

            <div class="order-card-footer">
                <div class="order-meta">
                    @if($order->booking_date)
                    <span class="order-meta-item">
                        <i class="bi bi-calendar-event"></i>
                        {{ \Carbon\Carbon::parse($order->booking_date)->isoFormat('D MMM YYYY') }}
                    </span>
                    @endif
                    @if($order->start_time)
                    <span class="order-meta-item">
                        <i class="bi bi-clock"></i>
                        {{ \Carbon\Carbon::parse($order->start_time)->format('H:i') }} WIB
                    </span>
                    @endif
                    @if($order->payment)
                    <span class="order-meta-item">
                        <i class="bi bi-credit-card"></i>
                        {{ $ps === 'verified' ? 'Lunas' : 'Menunggu Pembayaran' }}
                    </span>
                    @endif
                </div>

                <div class="btn-action-wrap">
                    @if($order->status === 'confirmed' && !$order->payment)
                    <a href="{{ route('customer.payment.create', $order->id) }}" class="btn-pay">
                        <i class="bi bi-credit-card"></i> Bayar
                    </a>
                    @endif
                    @if($order->delivery && $order->status === 'completed')
                    <a href="{{ route('customer.delivery', $order->id) }}" class="btn-drive">
                        <i class="bi bi-cloud-arrow-down"></i> Hasil
                    </a>
                    @endif
                    <a href="{{ route('customer.orders.detail', $order->id) }}" class="btn-detail">
                        Detail <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

        </div>
        @empty
        <div class="empty-state">
            <div class="empty-icon"><i class="bi bi-bag-x"></i></div>
            <div class="empty-title">Belum Ada Pesanan</div>
            <div class="empty-desc">Kamu belum pernah memesan paket foto.<br>Yuk mulai abadikan momenmu!</div>
            <a href="{{ route('packages.categories') }}" class="btn-new-order">
                <i class="bi bi-camera2"></i> Lihat Paket
            </a>
        </div>
        @endforelse
    </div>

    <div class="no-result-msg" id="noResult">
        <i class="bi bi-search" style="font-size:1.8rem;color:var(--gold-border);display:block;margin-bottom:10px;"></i>
        Tidak ada pesanan dengan filter ini.
    </div>

</div>
</section>
</main>
@endsection

@push('js')
<script>
(function () {
    var btns  = document.querySelectorAll('.filter-btn');
    var cards = document.querySelectorAll('.order-card');
    var noRes = document.getElementById('noResult');

    btns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            btns.forEach(function (b) { b.classList.remove('active'); });
            this.classList.add('active');
            var filter  = this.dataset.filter;
            var visible = 0;
            cards.forEach(function (card) {
                var show = filter === 'all' || card.dataset.status === filter;
                card.style.display = show ? '' : 'none';
                if (show) visible++;
            });
            noRes.style.display = (visible === 0 && cards.length > 0) ? 'block' : 'none';
        });
    });
}());
</script>
@endpush