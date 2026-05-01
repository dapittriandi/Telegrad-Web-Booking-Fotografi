@extends('base.base-admin-index')

@php $menu = 'Pesanan'; $submenu = 'Pesanan'; $subdesc = 'Kelola semua pesanan masuk'; @endphp

@section('custom-css')
<style>
    @font-face { font-family:"Font Awesome 6 Free"; font-weight:900; font-display:block; src:url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/webfonts/fa-solid-900.woff2") format("woff2"); }
    .fa-solid,.fas{font-family:"Font Awesome 6 Free"!important;font-weight:900!important;}

    .tg-stat { display:flex; align-items:center; gap:14px; padding:16px 20px; background:#fff; border-radius:12px; box-shadow:0 1px 3px rgba(0,0,0,.06),0 4px 16px rgba(0,0,0,.04); height:100%; }
    .tg-stat-icon { width:46px; height:46px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.1rem; flex-shrink:0; }
    .tg-stat-num { font-size:1.5rem; font-weight:800; line-height:1; color:#111827; }
    .tg-stat-lbl { font-size:.7rem; color:#9CA3AF; text-transform:uppercase; letter-spacing:.07em; margin-top:3px; }

    .tg-card { border:none!important; border-radius:14px!important; box-shadow:0 1px 3px rgba(0,0,0,.06),0 4px 16px rgba(0,0,0,.05)!important; overflow:hidden; }
    .tg-card .card-header { background:linear-gradient(135deg,#1E3A8A,#2563EB)!important; border:none!important; padding:15px 20px!important; }
    .tg-card .card-header h5 { color:#fff!important; font-weight:600!important; font-size:.95rem!important; margin:0; }

    .tg-table thead th { font-size:.7rem!important; text-transform:uppercase!important; letter-spacing:.07em!important; color:#9CA3AF!important; background:#FAFAFA!important; border-bottom:1px solid #F3F4F6!important; padding:10px 14px!important; }
    .tg-table tbody td { padding:10px 14px!important; vertical-align:middle!important; font-size:.84rem!important; border-bottom:1px solid #F9FAFB!important; }
    .tg-table tbody tr:last-child td { border-bottom:none!important; }
    .tg-table tbody tr:hover td { background:#FAFBFF!important; }

    .badge-pending   { background:#FEF3C7; color:#92400E; font-size:.68rem; font-weight:700; padding:3px 10px; border-radius:100px; }
    .badge-confirmed { background:#DBEAFE; color:#1E40AF; font-size:.68rem; font-weight:700; padding:3px 10px; border-radius:100px; }
    .badge-completed { background:#D1FAE5; color:#065F46; font-size:.68rem; font-weight:700; padding:3px 10px; border-radius:100px; }
    .badge-cancelled { background:#FEE2E2; color:#991B1B; font-size:.68rem; font-weight:700; padding:3px 10px; border-radius:100px; }

    .pay-verified { background:#D1FAE5; color:#065F46; font-size:.66rem; font-weight:700; padding:2px 8px; border-radius:100px; }
    .pay-pending  { background:#FEF3C7; color:#92400E; font-size:.66rem; font-weight:700; padding:2px 8px; border-radius:100px; }
    .pay-rejected { background:#FEE2E2; color:#991B1B; font-size:.66rem; font-weight:700; padding:2px 8px; border-radius:100px; }
    .pay-none     { background:#F3F4F6; color:#9CA3AF; font-size:.66rem; font-weight:700; padding:2px 8px; border-radius:100px; }

    .nav-filter .nav-link { font-size:.76rem; font-weight:600; color:#6B7280; border:none; padding:5px 14px; border-radius:100px; }
    .nav-filter .nav-link.active { background:#1E3A8A; color:#fff; }
    .nav-filter .nav-link:hover:not(.active) { background:#F3F4F6; }

    .btn-act { padding:4px 10px; font-size:.74rem; border-radius:6px; }
    .mini-avatar { width:28px; height:28px; border-radius:7px; background:linear-gradient(135deg,#1E3A8A,#3B82F6); color:#fff; font-size:.68rem; font-weight:700; display:inline-flex; align-items:center; justify-content:center; }
    .section-label { font-size:.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.1em; color:#9CA3AF; margin-bottom:10px; }
    .accent-bar { width:4px; height:18px; background:#60A5FA; border-radius:100px; flex-shrink:0; }
</style>
@endsection

@section('content')

<p class="section-label">Statistik Pesanan</p>
<div class="row g-3 mb-4">
    @php
        $stats = [
            ['label'=>'Total Order',  'val'=>$orders->count(),                             'bg'=>'#EFF6FF','ic'=>'fa-list','tc'=>'#3B82F6'],
            ['label'=>'Pending',      'val'=>$orders->where('status','pending')->count(),   'bg'=>'#FEF3C7','ic'=>'fa-clock','tc'=>'#D97706'],
            ['label'=>'Dikonfirmasi', 'val'=>$orders->where('status','confirmed')->count(), 'bg'=>'#DBEAFE','ic'=>'fa-circle-check','tc'=>'#2563EB'],
            ['label'=>'Selesai',      'val'=>$orders->where('status','completed')->count(), 'bg'=>'#D1FAE5','ic'=>'fa-camera','tc'=>'#059669'],
            ['label'=>'Dibatalkan',   'val'=>$orders->where('status','cancelled')->count(), 'bg'=>'#FEE2E2','ic'=>'fa-ban','tc'=>'#DC2626'],
        ];
    @endphp
    @foreach($stats as $s)
    <div class="col-6 col-md">
        <div class="tg-stat">
            <div class="tg-stat-icon" style="background:{{ $s['bg'] }};"><i class="fa-solid {{ $s['ic'] }}" style="color:{{ $s['tc'] }};"></i></div>
            <div><div class="tg-stat-num">{{ $s['val'] }}</div><div class="tg-stat-lbl">{{ $s['label'] }}</div></div>
        </div>
    </div>
    @endforeach
</div>

<p class="section-label">Daftar Pesanan</p>
<div class="card tg-card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <div class="accent-bar"></div>
            <h5>Daftar Pesanan</h5>
            <span style="font-size:.75rem;color:rgba(255,255,255,.6);">{{ $orders->count() }} total</span>
        </div>
        <ul class="nav nav-filter gap-1 mb-0" id="order-filter">
            <li class="nav-item"><a class="nav-link active" data-filter="all" href="#">Semua</a></li>
            <li class="nav-item"><a class="nav-link" data-filter="pending" href="#">Pending</a></li>
            <li class="nav-item"><a class="nav-link" data-filter="confirmed" href="#">Konfirmasi</a></li>
            <li class="nav-item"><a class="nav-link" data-filter="completed" href="#">Selesai</a></li>
            <li class="nav-item"><a class="nav-link" data-filter="cancelled" href="#">Batal</a></li>
        </ul>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table tg-table mb-0" id="ordersTable">
                <thead>
                    <tr>
                        <th style="padding-left:20px!important;">#</th>
                        <th>Customer</th>
                        <th>Paket</th>
                        <th>Tanggal Sesi</th>
                        <th>Waktu</th>
                        <th>Total</th>
                        <th>Pembayaran</th>
                        <th>Status</th>
                        <th class="text-center" style="padding-right:20px!important;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    @php
                        $badgeClass = match($order->status) {
                            'pending'   => 'badge-pending',
                            'confirmed' => 'badge-confirmed',
                            'completed' => 'badge-completed',
                            'cancelled' => 'badge-cancelled',
                            default     => 'badge-pending',
                        };
                        $statusLabel = match($order->status) {
                            'pending'   => 'Pending',
                            'confirmed' => 'Dikonfirmasi',
                            'completed' => 'Selesai',
                            'cancelled' => 'Dibatalkan',
                            default     => ucfirst($order->status),
                        };
                        $ps = $order->payment->payment_status ?? 'none';
                        $payClass = match($ps) {
                            'verified' => 'pay-verified',
                            'rejected' => 'pay-rejected',
                            'pending'  => 'pay-pending',
                            default    => 'pay-none',
                        };
                        $payLabel = match($ps) {
                            'verified' => 'Lunas',
                            'rejected' => 'Ditolak',
                            'pending'  => 'Menunggu',
                            default    => 'Belum Bayar',
                        };
                    @endphp
                    <tr data-status="{{ $order->status }}">
                        <td style="padding-left:20px!important;">
                            <span style="font-size:.7rem;font-weight:700;color:#D1D5DB;">#{{ str_pad($order->id,5,'0',STR_PAD_LEFT) }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="mini-avatar">{{ strtoupper(substr($order->user->name ?? 'U',0,1)) }}</div>
                                <div>
                                    <div style="font-weight:700;font-size:.84rem;color:#111827;">{{ $order->user->name ?? '-' }}</div>
                                    <div style="font-size:.73rem;color:#9CA3AF;">{{ $order->user->email ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight:600;font-size:.84rem;">{{ $order->package->name ?? '-' }}</div>
                            <div style="font-size:.73rem;color:#9CA3AF;">{{ $order->package->category->name ?? '' }}</div>
                        </td>
                        <td>
                            <div style="font-size:.84rem;">{{ \Carbon\Carbon::parse($order->booking_date)->isoFormat('D MMM YYYY') }}</div>
                            <div style="font-size:.73rem;color:#9CA3AF;">{{ \Carbon\Carbon::parse($order->booking_date)->isoFormat('dddd') }}</div>
                        </td>
                        <td style="font-size:.82rem;color:#6B7280;">
                            {{ \Carbon\Carbon::parse($order->start_time)->format('H:i') }} – {{ \Carbon\Carbon::parse($order->end_time)->format('H:i') }}
                        </td>
                        <td style="font-weight:700;font-size:.86rem;">Rp {{ number_format($order->total_price,0,',','.') }}</td>
                        <td><span class="{{ $payClass }}">{{ $payLabel }}</span></td>
                        <td><span class="{{ $badgeClass }}">{{ $statusLabel }}</span></td>
                        <td class="text-center" style="padding-right:20px!important;">
                            <div class="d-flex gap-1 justify-content-center flex-wrap">
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary btn-act" title="Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                @if($order->status === 'pending')
                                <form action="{{ route('admin.orders.confirm', $order->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success btn-act" title="Konfirmasi" onclick="return confirm('Konfirmasi order ini?')">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                </form>
                                @endif
                                @if($order->status === 'confirmed')
                                <form action="{{ route('admin.orders.complete', $order->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-info btn-act" title="Selesaikan" onclick="return confirm('Tandai order ini selesai?')">
                                        <i class="fa-solid fa-camera"></i>
                                    </button>
                                </form>
                                @endif
                                @if(!in_array($order->status, ['completed','cancelled']))
                                <form action="{{ route('admin.orders.cancel', $order->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-warning btn-act" title="Batalkan" onclick="return confirm('Batalkan order ini?')">
                                        <i class="fa-solid fa-ban"></i>
                                    </button>
                                </form>
                                @endif
                                <form id="delete-form-{{ $order->id }}" action="{{ route('orders.destroy', $order->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="deleteData({{ $order->id }})" class="btn btn-sm btn-outline-danger btn-act" title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5" style="color:#9CA3AF;">
                            <i class="fa-solid fa-inbox fa-2x d-block mb-2" style="opacity:.3;"></i>
                            Belum ada pesanan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('custom-js')
<script>
document.querySelectorAll('#order-filter .nav-link').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelectorAll('#order-filter .nav-link').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        const f = this.dataset.filter;
        document.querySelectorAll('#ordersTable tbody tr[data-status]').forEach(row => {
            row.style.display = (f === 'all' || row.dataset.status === f) ? '' : 'none';
        });
    });
});
</script>
@endsection