@extends('base.base-root-index')

@push('css')
<style>
/* ─── history.blade — theme-aware ───────────────────────── */
.page-header {
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    padding-top: 72px;
}
.page-header-inner {
    padding: 36px 0 28px;
    display: flex; align-items: flex-end;
    justify-content: space-between;
    flex-wrap: wrap; gap: 16px;
}
.page-header-eyebrow {
    font-size: .65rem; font-weight: 700;
    letter-spacing: .2em; text-transform: uppercase;
    color: var(--gold);
    display: inline-flex; align-items: center; gap: 6px;
    margin-bottom: 10px;
}
.page-header-eyebrow::before {
    content:''; display:inline-block;
    width:18px; height:1px; background:var(--gold);
}
.page-header h1 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.4rem, 3vw, 1.9rem);
    color: var(--text); font-weight: 700;
    margin: 0 0 5px; letter-spacing: -.02em;
}
.page-header-sub { font-size: .875rem; color: var(--muted); margin: 0; }
.page-header-sub strong { color: var(--gold-light); font-weight: 600; }

.btn-new-order {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 10px 20px; border-radius: 8px;
    font-size: .78rem; font-weight: 700;
    letter-spacing: .07em; text-transform: uppercase;
    color: #0d0d0d; background: var(--gold);
    text-decoration: none;
    transition: opacity .22s, transform .22s, box-shadow .22s;
}
.btn-new-order:hover {
    opacity:.88; color:#0d0d0d;
    transform:translateY(-2px);
    box-shadow:0 8px 24px rgba(200,169,110,.28);
}

.orders-section { padding: 32px 0 80px; }

/* Stats */
.stat-row {
    display:grid; grid-template-columns:repeat(4,1fr);
    gap:10px; margin-bottom:28px;
}
@media(max-width:640px){ .stat-row{ grid-template-columns:repeat(2,1fr); } }

.stat-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 12px; padding: 16px 14px;
    display: flex; align-items: center; gap: 12px;
    transition: border-color .22s, transform .22s,
                background .3s, box-shadow .22s;
}
.stat-card:hover {
    border-color: var(--gold-border);
    transform: translateY(-2px);
    background: var(--card-hover);
    box-shadow: var(--shadow-sm);
}
.stat-icon {
    width:40px; height:40px; border-radius:10px; flex-shrink:0;
    display:flex; align-items:center; justify-content:center; font-size:1rem;
}
.stat-icon.gold  { background:var(--gold-dim); color:var(--gold); border:1px solid var(--gold-border); }
.stat-icon.blue  { background:rgba(91,155,213,.1); color:#5b9bd5; border:1px solid rgba(91,155,213,.2); }
.stat-icon.green { background:rgba(76,175,130,.1); color:var(--success); border:1px solid rgba(76,175,130,.2); }
.stat-icon.red   { background:rgba(224,92,92,.1); color:var(--danger); border:1px solid rgba(224,92,92,.2); }

.stat-val   { font-family:'Playfair Display',serif; font-size:1.5rem; font-weight:700; color:var(--text); line-height:1; margin-bottom:2px; }
.stat-label { font-size:.67rem; color:var(--muted); text-transform:uppercase; letter-spacing:.1em; }

/* Filter */
.filter-bar {
    display:flex; align-items:center; gap:4px;
    flex-wrap:wrap; margin-bottom:16px;
    background:var(--card); border:1px solid var(--border);
    border-radius:12px; padding:7px;
    transition: background .3s, border-color .3s;
}
.filter-btn {
    padding:6px 14px; font-size:.72rem; font-weight:600;
    letter-spacing:.05em; text-transform:uppercase;
    color:var(--muted); border:none;
    border-radius:8px; background:transparent; cursor:pointer;
    transition: all .2s;
}
.filter-btn:hover  { color:var(--text); background:var(--border); }
.filter-btn.active { background:var(--gold-dim); color:var(--gold); }

/* Order card */
.order-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 12px; overflow:hidden;
    margin-bottom: 10px;
    transition: border-color .22s, box-shadow .22s,
                background .3s, transform .22s;
}
.order-card:hover {
    border-color:var(--gold-border);
    box-shadow:var(--shadow-sm);
    background:var(--card-hover);
    transform:translateY(-1px);
}

.order-card-header {
    display:flex; align-items:center; justify-content:space-between;
    padding:10px 18px;
    border-bottom:1px solid var(--border);
    background:rgba(0,0,0,.018);
    flex-wrap:wrap; gap:8px;
}
[data-theme="light"] .order-card-header { background:rgba(0,0,0,.025); }

.order-id   { font-size:.7rem; color:var(--muted); font-family:monospace; letter-spacing:.08em; }
.order-date { font-size:.71rem; color:var(--muted); display:flex; align-items:center; gap:4px; }

.order-card-body {
    display:flex; align-items:center; gap:14px;
    padding:14px 18px; flex-wrap:wrap;
}
.order-pkg-thumb {
    width:44px; height:44px; border-radius:10px; flex-shrink:0;
    background:var(--gold-dim); border:1px solid var(--gold-border);
    display:flex; align-items:center; justify-content:center;
    color:var(--gold); font-size:1.05rem;
}
.order-pkg-info  { flex:1; min-width:0; }
.order-pkg-name  {
    font-family:'Playfair Display',serif;
    font-size:.9rem; font-weight:700; color:var(--text);
    white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin-bottom:2px;
}
.order-pkg-cat { font-size:.72rem; color:var(--muted); }
.order-price   { font-family:'Playfair Display',serif; font-size:.98rem; font-weight:700; color:var(--gold); white-space:nowrap; }

.order-card-footer {
    display:flex; align-items:center; justify-content:space-between;
    padding:10px 18px; border-top:1px solid var(--border);
    flex-wrap:wrap; gap:8px;
}
.order-meta { display:flex; align-items:center; gap:12px; flex-wrap:wrap; }
.order-meta-item { font-size:.72rem; color:var(--muted); display:flex; align-items:center; gap:4px; }
.order-meta-item i { color:var(--gold); font-size:.68rem; }

/* Status badges */
.status-badge {
    display:inline-flex; align-items:center; gap:4px;
    padding:3px 10px; border-radius:100px;
    font-size:.65rem; font-weight:700;
    letter-spacing:.05em; text-transform:uppercase;
}
.s-pending   { background:rgba(224,169,53,.12); border:1px solid rgba(224,169,53,.25); color:#e0a935; }
.s-confirmed { background:rgba(91,155,213,.12); border:1px solid rgba(91,155,213,.25); color:#5b9bd5; }
.s-completed { background:rgba(76,175,130,.12); border:1px solid rgba(76,175,130,.25); color:var(--success); }
.s-cancelled { background:rgba(224,92,92,.12);  border:1px solid rgba(224,92,92,.25);  color:var(--danger); }

/* Action buttons */
.btn-action-wrap { display:flex; gap:6px; align-items:center; flex-wrap:wrap; }

.btn-detail {
    display:inline-flex; align-items:center; gap:5px;
    padding:6px 14px; border-radius:8px; font-size:.73rem; font-weight:600;
    color:var(--gold); border:1px solid var(--gold-border);
    background:var(--gold-dim); text-decoration:none;
    transition: background .2s, transform .2s;
}
.btn-detail:hover { background:rgba(200,169,110,.2); color:var(--gold-light); transform:translateY(-1px); }

.btn-pay {
    display:inline-flex; align-items:center; gap:5px;
    padding:6px 14px; border-radius:8px; font-size:.73rem; font-weight:700;
    color:#0d0d0d; background:var(--gold); text-decoration:none;
    transition: opacity .2s, transform .2s;
}
.btn-pay:hover { opacity:.85; color:#0d0d0d; transform:translateY(-1px); }

.btn-drive {
    display:inline-flex; align-items:center; gap:5px;
    padding:6px 14px; border-radius:8px; font-size:.73rem; font-weight:600;
    color:var(--success); border:1px solid rgba(76,175,130,.25);
    background:rgba(76,175,130,.08); text-decoration:none;
    transition: background .2s, transform .2s;
}
.btn-drive:hover { background:rgba(76,175,130,.16); transform:translateY(-1px); }

/* Empty / no-result */
.empty-state {
    text-align:center; padding:60px 24px;
    background:var(--card); border:1px solid var(--border);
    border-radius:12px;
    transition: background .3s, border-color .3s;
}
.empty-icon {
    width:60px; height:60px; border-radius:14px; margin:0 auto 16px;
    background:var(--gold-dim); border:1px solid var(--gold-border);
    display:flex; align-items:center; justify-content:center;
    font-size:1.5rem; color:var(--gold);
}
.empty-title { font-family:'Playfair Display',serif; font-size:1rem; color:var(--text); margin-bottom:6px; }
.empty-desc  { font-size:.83rem; color:var(--muted); margin-bottom:20px; line-height:1.7; }

.no-result-msg {
    text-align:center; padding:36px;
    font-size:.84rem; color:var(--muted); display:none;
}

/* Flash */
.flash-msg {
    border-radius:8px; padding:12px 16px;
    font-size:.84rem; display:flex; align-items:center; gap:10px;
    margin-bottom:20px;
}
.flash-success { background:rgba(76,175,130,.08); border:1px solid rgba(76,175,130,.22); color:var(--success); }
.flash-error   { background:rgba(224,92,92,.08);  border:1px solid rgba(224,92,92,.22);  color:var(--danger); }
</style>
@endpush

@section('content')
<main id="main">

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

    @if(session('success'))
    <div class="flash-msg flash-success">
        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="flash-msg flash-error">
        <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
    </div>
    @endif

    @php
        $userOrders   = Auth::user()->orders();
        $totalAll     = (clone $userOrders)->count();
        $processAll   = (clone $userOrders)->whereIn('status', ['pending','confirmed'])->count();
        $completedAll = (clone $userOrders)->where('status', 'completed')->count();
        $cancelledAll = (clone $userOrders)->where('status', 'cancelled')->count();
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

    <div class="filter-bar" data-aos="fade-up">
        <button class="filter-btn active" data-filter="all">Semua</button>
        <button class="filter-btn" data-filter="pending">Menunggu</button>
        <button class="filter-btn" data-filter="confirmed">Dikonfirmasi</button>
        <button class="filter-btn" data-filter="completed">Selesai</button>
        <button class="filter-btn" data-filter="cancelled">Dibatalkan</button>
    </div>

    <div id="orderList" data-aos="fade-up">
        @forelse($orders as $order)
        @php
            $statusMap = [
                'pending'   => ['label'=>'Menunggu',     'class'=>'s-pending'],
                'confirmed' => ['label'=>'Dikonfirmasi', 'class'=>'s-confirmed'],
                'completed' => ['label'=>'Selesai',      'class'=>'s-completed'],
                'cancelled' => ['label'=>'Dibatalkan',   'class'=>'s-cancelled'],
            ];
            $st = $statusMap[$order->status] ?? ['label'=>ucfirst($order->status),'class'=>'s-pending'];
            $ps = $order->payment->payment_status ?? null;
        @endphp

        <div class="order-card" data-status="{{ $order->status }}">
            <div class="order-card-header">
                <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                    <span class="order-id">#{{ str_pad($order->id,5,'0',STR_PAD_LEFT) }}</span>
                    <span class="status-badge {{ $st['class'] }}">{{ $st['label'] }}</span>
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
                <div class="order-price">Rp {{ number_format($order->package->price ?? 0,0,',','.') }}</div>
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
            <p class="empty-desc">Kamu belum pernah memesan paket foto.<br>Yuk mulai abadikan momenmu!</p>
            <a href="{{ route('packages.categories') }}" class="btn-new-order">
                <i class="bi bi-camera2"></i> Lihat Paket
            </a>
        </div>
        @endforelse
    </div>

    <div class="no-result-msg" id="noResult">
        <i class="bi bi-search" style="font-size:1.8rem;color:var(--gold-border);display:block;margin-bottom:10px;"></i>
        Tidak ada pesanan dengan status ini.
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
            var filter = this.dataset.filter, visible = 0;
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