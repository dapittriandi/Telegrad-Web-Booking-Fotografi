@extends('base.base-admin-index')

@php $menu = 'Pembayaran'; $submenu = 'Pembayaran'; $subdesc = 'Kelola dan verifikasi semua transaksi pembayaran'; @endphp

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

    .badge-verified { background:#D1FAE5; color:#065F46; font-size:.68rem; font-weight:700; padding:3px 10px; border-radius:100px; }
    .badge-rejected { background:#FEE2E2; color:#991B1B; font-size:.68rem; font-weight:700; padding:3px 10px; border-radius:100px; }
    .badge-pending  { background:#FEF3C7; color:#92400E; font-size:.68rem; font-weight:700; padding:3px 10px; border-radius:100px; }

    .proof-thumb { width:50px; height:50px; object-fit:cover; border-radius:8px; border:1px solid #F3F4F6; cursor:pointer; transition:transform .15s; }
    .proof-thumb:hover { transform:scale(1.1); }

    .nav-filter .nav-link { font-size:.76rem; font-weight:600; color:#6B7280; border:none; padding:5px 14px; border-radius:100px; }
    .nav-filter .nav-link.active { background:rgba(255,255,255,.2); color:#fff; }
    .nav-filter .nav-link:hover:not(.active) { background:rgba(255,255,255,.1); color:#fff; }

    .btn-act { padding:4px 10px; font-size:.74rem; border-radius:6px; }
    .accent-bar { width:4px; height:18px; background:#60A5FA; border-radius:100px; flex-shrink:0; }
    .mini-avatar { width:28px; height:28px; border-radius:7px; background:linear-gradient(135deg,#1E3A8A,#3B82F6); color:#fff; font-size:.68rem; font-weight:700; display:inline-flex; align-items:center; justify-content:center; }
    .section-label { font-size:.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.1em; color:#9CA3AF; margin-bottom:10px; }
</style>
@endsection

@section('content')

@php
    $total    = $payments->count();
    $pending  = $payments->where('payment_status','pending')->count();
    $verified = $payments->where('payment_status','verified')->count();
    $rejected = $payments->where('payment_status','rejected')->count();
    $income   = $payments->where('payment_status','verified')->sum('amount');
@endphp

<p class="section-label">Statistik Pembayaran</p>
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="tg-stat">
            <div class="tg-stat-icon" style="background:#EFF6FF;"><i class="fa-solid fa-money-bill text-primary"></i></div>
            <div><div class="tg-stat-num">{{ $total }}</div><div class="tg-stat-lbl">Total</div></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="tg-stat">
            <div class="tg-stat-icon" style="background:#FEF3C7;"><i class="fa-solid fa-clock" style="color:#D97706;"></i></div>
            <div><div class="tg-stat-num">{{ $pending }}</div><div class="tg-stat-lbl">Menunggu</div></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="tg-stat">
            <div class="tg-stat-icon" style="background:#D1FAE5;"><i class="fa-solid fa-circle-check text-success"></i></div>
            <div><div class="tg-stat-num">{{ $verified }}</div><div class="tg-stat-lbl">Terverifikasi</div></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="tg-stat">
            <div class="tg-stat-icon" style="background:#ECFDF5;"><i class="fa-solid fa-sack-dollar text-success"></i></div>
            <div>
                <div class="tg-stat-num" style="font-size:1.05rem;">Rp {{ number_format($income,0,',','.') }}</div>
                <div class="tg-stat-lbl">Pendapatan</div>
            </div>
        </div>
    </div>
</div>

<p class="section-label">Daftar Pembayaran</p>
<div class="card tg-card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <div class="accent-bar"></div>
            <h5>Daftar Pembayaran</h5>
            <span style="font-size:.75rem;color:rgba(255,255,255,.6);">{{ $total }} transaksi</span>
        </div>
        <ul class="nav nav-filter gap-1 mb-0" id="pay-filter">
            <li class="nav-item"><a class="nav-link active" data-filter="all" href="#">Semua</a></li>
            <li class="nav-item"><a class="nav-link" data-filter="pending" href="#">Menunggu</a></li>
            <li class="nav-item"><a class="nav-link" data-filter="verified" href="#">Terverifikasi</a></li>
            <li class="nav-item"><a class="nav-link" data-filter="rejected" href="#">Ditolak</a></li>
        </ul>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table tg-table mb-0" id="payTable">
                <thead>
                    <tr>
                        <th style="padding-left:20px!important;">#</th>
                        <th>Customer</th>
                        <th>Paket</th>
                        <th>Sesi</th>
                        <th>Metode</th>
                        <th>Jumlah</th>
                        <th>Bukti</th>
                        <th>Status</th>
                        <th class="text-center" style="padding-right:20px!important;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                    @php
                        $ps = $payment->payment_status ?? 'pending';
                        $bcls = match($ps) { 'verified'=>'badge-verified','rejected'=>'badge-rejected',default=>'badge-pending' };
                        $blbl = match($ps) { 'verified'=>'Terverifikasi','rejected'=>'Ditolak',default=>'Menunggu' };
                    @endphp
                    <tr data-status="{{ $ps }}">
                        <td style="padding-left:20px!important;font-size:.7rem;font-weight:700;color:#D1D5DB;">
                            #{{ str_pad($payment->id,5,'0',STR_PAD_LEFT) }}
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="mini-avatar">{{ strtoupper(substr($payment->order->user->name ?? 'U',0,1)) }}</div>
                                <div>
                                    <div style="font-weight:700;font-size:.84rem;">{{ $payment->order->user->name ?? '-' }}</div>
                                    <div style="font-size:.72rem;color:#9CA3AF;">{{ $payment->order->user->phone ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-size:.84rem;font-weight:600;">{{ $payment->order->package->name ?? '-' }}</div>
                            <div style="font-size:.72rem;color:#9CA3AF;">{{ $payment->order->package->category->name ?? '' }}</div>
                        </td>
                        <td style="font-size:.82rem;">
                            @if($payment->order)
                                {{ \Carbon\Carbon::parse($payment->order->booking_date)->isoFormat('D MMM YYYY') }}<br>
                                <span style="color:#9CA3AF;">{{ \Carbon\Carbon::parse($payment->order->start_time)->format('H:i') }} WIB</span>
                            @else - @endif
                        </td>
                        <td>
                            <span style="background:#F3F4F6;color:#374151;font-size:.72rem;font-weight:600;padding:3px 9px;border-radius:100px;text-transform:capitalize;">
                                {{ $payment->payment_method ?? '-' }}
                            </span>
                        </td>
                        <td style="font-weight:700;font-size:.86rem;">Rp {{ number_format($payment->amount,0,',','.') }}</td>
                        <td>
                            @if($payment->payment_proof)
                                <img src="{{ asset('storage/'.$payment->payment_proof) }}"
                                     class="proof-thumb" alt="Bukti"
                                     onclick="showProof('{{ asset('storage/'.$payment->payment_proof) }}')">
                            @else
                                <span style="color:#9CA3AF;font-size:.76rem;">-</span>
                            @endif
                        </td>
                        <td><span class="{{ $bcls }}">{{ $blbl }}</span></td>
                        <td class="text-center" style="padding-right:20px!important;">
                            <div class="d-flex gap-1 justify-content-center">
                                <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-sm btn-outline-primary btn-act" title="Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                @if($ps === 'pending')
                                <form action="{{ route('admin.payments.verify', $payment->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success btn-act" title="Verifikasi" onclick="return confirm('Verifikasi pembayaran ini?')">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.payments.reject', $payment->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger btn-act" title="Tolak" onclick="return confirm('Tolak pembayaran ini?')">
                                        <i class="fa-solid fa-times"></i>
                                    </button>
                                </form>
                                @endif
                                <form id="delete-form-{{ $payment->id }}" action="{{ route('payments.destroy', $payment->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="deleteData({{ $payment->id }})" class="btn btn-sm btn-outline-danger btn-act" title="Hapus">
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
                            Belum ada pembayaran
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Bukti --}}
<div class="modal fade" id="proofModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border:none;border-radius:14px;">
            <div class="modal-header" style="border-bottom:1px solid #F3F4F6;padding:14px 20px;">
                <h6 class="modal-title" style="font-weight:700;font-size:.9rem;">Bukti Pembayaran</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-3">
                <img id="proof-modal-img" src="" alt="Bukti" style="max-width:100%;border-radius:10px;">
            </div>
        </div>
    </div>
</div>

@endsection

@section('custom-js')
<script>
document.querySelectorAll('#pay-filter .nav-link').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelectorAll('#pay-filter .nav-link').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        const f = this.dataset.filter;
        document.querySelectorAll('#payTable tbody tr[data-status]').forEach(row => {
            row.style.display = (f === 'all' || row.dataset.status === f) ? '' : 'none';
        });
    });
});
function showProof(src) {
    document.getElementById('proof-modal-img').src = src;
    new bootstrap.Modal(document.getElementById('proofModal')).show();
}
</script>
@endsection