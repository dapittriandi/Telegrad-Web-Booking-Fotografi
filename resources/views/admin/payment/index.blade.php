@extends('base.base-admin-index')

@php $menu = 'Pembayaran'; $submenu = 'Pembayaran'; $subdesc = 'Kelola dan verifikasi semua transaksi pembayaran'; @endphp

@section('custom-css')
<style>
@font-face {
    font-family: "Font Awesome 6 Free";
    font-weight: 900;
    font-display: block;
    src: url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/webfonts/fa-solid-900.woff2") format("woff2");
}
.fa-solid, .fas { font-family: "Font Awesome 6 Free" !important; font-weight: 900 !important; }

/* ── Stat Cards ── */
.pay-stat-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}
@media (max-width: 900px) { .pay-stat-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 480px) { .pay-stat-grid { grid-template-columns: 1fr 1fr; } }

.pay-stat-card {
    background: var(--tg-glass);
    backdrop-filter: var(--tg-blur);
    border: 1px solid var(--tg-glass-border);
    border-radius: 14px;
    box-shadow: var(--tg-sh-sm);
    padding: 20px 18px 16px;
    position: relative;
    overflow: hidden;
    transition: transform .2s ease, box-shadow .2s ease;
}
.pay-stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 28px rgba(37,99,235,.13);
}
.pay-stat-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 14px;
}
.pay-stat-icon {
    width: 44px; height: 44px;
    border-radius: 11px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    font-size: 1.05rem;
}
.pay-stat-badge {
    font-size: .62rem; font-weight: 700;
    letter-spacing: .04em;
    padding: 3px 9px;
    border-radius: 100px;
    white-space: nowrap;
    align-self: flex-start;
}
.pay-stat-num {
    font-size: 1.75rem; font-weight: 800; line-height: 1;
    color: var(--tg-text);
    margin-bottom: 5px;
    letter-spacing: -.03em;
}
.pay-stat-num.income { font-size: 1.15rem; }
.pay-stat-lbl {
    font-size: .65rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .08em;
    color: var(--tg-text-3);
}
.pay-stat-accent {
    position: absolute; bottom: 0; left: 0; right: 0;
    height: 3px; border-radius: 0 0 14px 14px;
}

/* ── Section Label ── */
.section-label {
    font-size: .63rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .1em;
    color: var(--tg-text-3); margin-bottom: 10px;
}

/* ── Table Card ── */
.pay-table-card {
    border: 1px solid var(--tg-glass-border);
    border-radius: 14px;
    overflow: hidden;
    box-shadow: var(--tg-sh-sm);
    background: var(--tg-glass);
    backdrop-filter: var(--tg-blur);
}
.pay-table-head {
    background: linear-gradient(135deg, #0A1628, #1E3A8A);
    padding: 14px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    flex-wrap: wrap;
}
.pay-table-head h6 {
    color: #fff;
    font-size: .92rem; font-weight: 700;
    margin: 0;
    display: flex; align-items: center; gap: 8px;
    line-height: 1;
}
.pay-table-head-meta {
    font-size: .74rem;
    color: rgba(255,255,255,.5);
}

/* ── Filter Nav ── */
.pay-filter {
    display: flex; gap: 4px;
    list-style: none; margin: 0; padding: 0;
}
.pay-filter .nav-link {
    font-size: .73rem; font-weight: 600;
    color: rgba(255,255,255,.65);
    border: none;
    padding: 5px 13px;
    border-radius: 100px;
    transition: background .15s, color .15s;
    white-space: nowrap;
}
.pay-filter .nav-link.active {
    background: rgba(255,255,255,.2);
    color: #fff;
}
.pay-filter .nav-link:hover:not(.active) {
    background: rgba(255,255,255,.1);
    color: #fff;
}

/* ── Table Itself ── */
.pay-table { width: 100%; border-collapse: collapse; }
.pay-table thead th {
    font-size: .66rem !important; font-weight: 700 !important;
    text-transform: uppercase !important; letter-spacing: .07em !important;
    color: var(--tg-text-3) !important;
    background: var(--tg-glass) !important;
    border-bottom: 1px solid var(--tg-border) !important;
    padding: 10px 14px !important;
    white-space: nowrap;
    vertical-align: middle !important;
}
.pay-table tbody td {
    padding: 11px 14px !important;
    vertical-align: middle !important;
    font-size: .82rem !important;
    border-bottom: 1px solid var(--tg-border) !important;
    color: var(--tg-text) !important;
}
.pay-table tbody tr:last-child td { border-bottom: none !important; }
.pay-table tbody tr:hover td { background: rgba(59,130,246,.04) !important; }

/* ── Badges ── */
.tg-badge {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: .67rem; font-weight: 700;
    padding: 3px 10px; border-radius: 100px;
    white-space: nowrap; line-height: 1.3;
}
.tg-badge-verified { background: #D1FAE5; color: #065F46; }
.tg-badge-rejected { background: #FEE2E2; color: #991B1B; }
.tg-badge-pending  { background: #FEF3C7; color: #92400E; }

[data-theme="dark"] .tg-badge-verified { background: rgba(209,250,229,.12); color: #6EE7B7; }
[data-theme="dark"] .tg-badge-rejected { background: rgba(254,226,226,.12); color: #FCA5A5; }
[data-theme="dark"] .tg-badge-pending  { background: rgba(254,243,199,.15); color: #FCD34D; }

/* ── Mini Avatar ── */
.mini-av {
    width: 32px; height: 32px; border-radius: 9px;
    background: linear-gradient(135deg, #0A1628, #2563EB);
    color: #fff; font-size: .68rem; font-weight: 700;
    display: inline-flex; align-items: center; justify-content: center;
    flex-shrink: 0; line-height: 1;
}

/* ── Method pill ── */
.method-pill {
    background: var(--tg-glass-border, #F3F4F6);
    color: var(--tg-text-2, #374151);
    font-size: .70rem; font-weight: 600;
    padding: 3px 10px; border-radius: 100px;
    text-transform: capitalize;
    white-space: nowrap;
}

/* ── Proof thumb ── */
.proof-thumb {
    width: 44px; height: 44px;
    object-fit: cover; border-radius: 8px;
    border: 1px solid var(--tg-border, #F3F4F6);
    cursor: pointer;
    transition: transform .15s, box-shadow .15s;
}
.proof-thumb:hover { transform: scale(1.12); box-shadow: 0 4px 12px rgba(0,0,0,.15); }

/* ── Action buttons ── */
.btn-act {
    padding: 4px 10px !important;
    font-size: .73rem !important;
    border-radius: 7px !important;
    line-height: 1.4 !important;
}

/* ── Empty state ── */
.pay-empty {
    text-align: center; padding: 40px 20px;
    color: var(--tg-text-3);
}
.pay-empty i { font-size: 2rem; opacity: .2; display: block; margin-bottom: 8px; }
.pay-empty span { font-size: .84rem; }

/* ── ID cell ── */
.pay-id {
    font-size: .68rem; font-weight: 700;
    color: var(--tg-text-3); font-variant-numeric: tabular-nums;
}
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

{{-- ═══════════════════════════
     STAT CARDS
════════════════════════════ --}}
<p class="section-label">Statistik Pembayaran</p>
<div class="pay-stat-grid">

    {{-- Total --}}
    <div class="pay-stat-card">
        <div class="pay-stat-top">
            <div class="pay-stat-icon" style="background:rgba(37,99,235,.12);">
                <i class="fa-solid fa-money-bill" style="color:#2563EB;"></i>
            </div>
            <span class="pay-stat-badge" style="background:rgba(37,99,235,.12);color:#2563EB;">Semua</span>
        </div>
        <div class="pay-stat-num" data-count="{{ $total }}">{{ $total }}</div>
        <div class="pay-stat-lbl">Total Transaksi</div>
        <div class="pay-stat-accent" style="background:#3B82F6;"></div>
    </div>

    {{-- Menunggu --}}
    <div class="pay-stat-card">
        <div class="pay-stat-top">
            <div class="pay-stat-icon" style="background:rgba(217,119,6,.12);">
                <i class="fa-solid fa-clock" style="color:#D97706;"></i>
            </div>
            <span class="pay-stat-badge" style="background:rgba(217,119,6,.12);color:#D97706;">Aktif</span>
        </div>
        <div class="pay-stat-num" data-count="{{ $pending }}">{{ $pending }}</div>
        <div class="pay-stat-lbl">Menunggu Verifikasi</div>
        <div class="pay-stat-accent" style="background:#F59E0B;"></div>
    </div>

    {{-- Terverifikasi --}}
    <div class="pay-stat-card">
        <div class="pay-stat-top">
            <div class="pay-stat-icon" style="background:rgba(5,150,105,.12);">
                <i class="fa-solid fa-circle-check" style="color:#059669;"></i>
            </div>
            <span class="pay-stat-badge" style="background:rgba(5,150,105,.12);color:#059669;">Lunas</span>
        </div>
        <div class="pay-stat-num" data-count="{{ $verified }}">{{ $verified }}</div>
        <div class="pay-stat-lbl">Terverifikasi</div>
        <div class="pay-stat-accent" style="background:#10B981;"></div>
    </div>

    {{-- Pendapatan --}}
    <div class="pay-stat-card">
        <div class="pay-stat-top">
            <div class="pay-stat-icon" style="background:rgba(5,150,105,.12);">
                <i class="fa-solid fa-sack-dollar" style="color:#059669;"></i>
            </div>
            <span class="pay-stat-badge" style="background:rgba(5,150,105,.12);color:#059669;">IDR</span>
        </div>
        <div class="pay-stat-num income">Rp {{ number_format($income,0,',','.') }}</div>
        <div class="pay-stat-lbl">Total Pendapatan</div>
        <div class="pay-stat-accent" style="background:#34D399;"></div>
    </div>

</div>

{{-- ═══════════════════════════
     TABLE CARD
════════════════════════════ --}}
<p class="section-label">Daftar Pembayaran</p>
<div class="pay-table-card">

    {{-- Header --}}
    <div class="pay-table-head">
        <div style="display:flex;align-items:center;gap:10px;">
            <h6>
                <i class="fa-solid fa-list-check"></i>
                Daftar Pembayaran
            </h6>
            <span class="pay-table-head-meta">{{ $total }} transaksi</span>
        </div>
        <ul class="pay-filter" id="pay-filter">
            <li><a class="nav-link active" data-filter="all"      href="#">Semua</a></li>
            <li><a class="nav-link"        data-filter="pending"  href="#">Menunggu</a></li>
            <li><a class="nav-link"        data-filter="verified" href="#">Terverifikasi</a></li>
            <li><a class="nav-link"        data-filter="rejected" href="#">Ditolak</a></li>
        </ul>
    </div>

    {{-- Table --}}
    <div style="overflow-x:auto;">
        <table class="pay-table" id="payTable">
            <thead>
                <tr>
                    <th style="padding-left:20px!important;width:60px;">#</th>
                    <th style="min-width:160px;">Customer</th>
                    <th style="min-width:130px;">Paket</th>
                    <th style="min-width:120px;">Sesi</th>
                    <th style="min-width:110px;">Metode</th>
                    <th style="min-width:110px;">Jumlah</th>
                    <th style="min-width:60px;">Bukti</th>
                    <th style="min-width:100px;">Status</th>
                    <th style="text-align:center;padding-right:20px!important;min-width:120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                @php
                    $ps   = $payment->payment_status ?? 'pending';
                    $bcls = match($ps) { 'verified'=>'tg-badge-verified','rejected'=>'tg-badge-rejected',default=>'tg-badge-pending' };
                    $blbl = match($ps) { 'verified'=>'Terverifikasi','rejected'=>'Ditolak',default=>'Menunggu' };
                    $bico = match($ps) { 'verified'=>'fa-circle-check','rejected'=>'fa-circle-xmark',default=>'fa-clock' };
                @endphp
                <tr data-status="{{ $ps }}">

                    {{-- ID --}}
                    <td style="padding-left:20px!important;">
                        <span class="pay-id">#{{ str_pad($payment->id,5,'0',STR_PAD_LEFT) }}</span>
                    </td>

                    {{-- Customer --}}
                    <td>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div class="mini-av">{{ strtoupper(substr($payment->order->user->name ?? 'U',0,1)) }}</div>
                            <div>
                                <div style="font-weight:700;font-size:.83rem;line-height:1.3;color:var(--tg-text);">
                                    {{ $payment->order->user->name ?? '-' }}
                                </div>
                                <div style="font-size:.71rem;color:var(--tg-text-3);line-height:1.3;">
                                    {{ $payment->order->user->phone ?? '' }}
                                </div>
                            </div>
                        </div>
                    </td>

                    {{-- Paket --}}
                    <td>
                        <div style="font-weight:600;font-size:.83rem;line-height:1.3;color:var(--tg-text);">
                            {{ $payment->order->package->name ?? '-' }}
                        </div>
                        <div style="font-size:.71rem;color:var(--tg-text-3);">
                            {{ $payment->order->package->category->name ?? '' }}
                        </div>
                    </td>

                    {{-- Sesi --}}
                    <td>
                        @if($payment->order)
                            <div style="font-size:.82rem;color:var(--tg-text);line-height:1.3;">
                                {{ \Carbon\Carbon::parse($payment->order->booking_date)->isoFormat('D MMM YYYY') }}
                            </div>
                            <div style="font-size:.71rem;color:var(--tg-text-3);">
                                {{ \Carbon\Carbon::parse($payment->order->start_time)->format('H:i') }} WIB
                            </div>
                        @else
                            <span style="color:var(--tg-text-3);">-</span>
                        @endif
                    </td>

                    {{-- Metode --}}
                    <td>
                        <span class="method-pill">{{ $payment->payment_method ?? '-' }}</span>
                    </td>

                    {{-- Jumlah --}}
                    <td>
                        <span style="font-weight:700;font-size:.86rem;color:var(--tg-text);white-space:nowrap;">
                            Rp {{ number_format($payment->amount,0,',','.') }}
                        </span>
                    </td>

                    {{-- Bukti --}}
                    <td>
                        @if($payment->payment_proof)
                            <img src="{{ asset('storage/'.$payment->payment_proof) }}"
                                 class="proof-thumb" alt="Bukti"
                                 onclick="showProof('{{ asset('storage/'.$payment->payment_proof) }}')">
                        @else
                            <span style="color:var(--tg-text-3);font-size:.76rem;">—</span>
                        @endif
                    </td>

                    {{-- Status --}}
                    <td>
                        <span class="tg-badge {{ $bcls }}">
                            <i class="fa-solid {{ $bico }}"></i>
                            {{ $blbl }}
                        </span>
                    </td>

                    {{-- Aksi --}}
                    <td style="text-align:center;padding-right:20px!important;">
                        <div style="display:flex;gap:5px;justify-content:center;align-items:center;">

                            <a href="{{ route('payments.show', $payment->id) }}"
                               class="btn btn-sm btn-outline-primary btn-act"
                               title="Detail">
                                <i class="fa-solid fa-eye"></i>
                            </a>

                            @if($ps === 'pending')
                            <form action="{{ route('admin.payments.verify', $payment->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success btn-act"
                                        title="Verifikasi"
                                        onclick="return confirm('Verifikasi pembayaran ini?')">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.payments.reject', $payment->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger btn-act"
                                        title="Tolak"
                                        onclick="return confirm('Tolak pembayaran ini?')">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </form>
                            @endif

                            <form id="delete-form-{{ $payment->id }}"
                                  action="{{ route('payments.destroy', $payment->id) }}"
                                  method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="button"
                                        onclick="deleteData({{ $payment->id }})"
                                        class="btn btn-sm btn-outline-danger btn-act"
                                        title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="9">
                        <div class="pay-empty">
                            <i class="fa-solid fa-inbox"></i>
                            <span>Belum ada data pembayaran</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

{{-- ═══════════════════════════
     MODAL BUKTI
════════════════════════════ --}}
<div class="modal fade" id="proofModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content"
             style="border:none;border-radius:16px;background:var(--tg-glass);backdrop-filter:var(--tg-blur);border:1px solid var(--tg-glass-border);">
            <div class="modal-header"
                 style="border-bottom:1px solid var(--tg-border);padding:14px 20px;">
                <h6 class="modal-title"
                    style="font-weight:700;font-size:.9rem;color:var(--tg-text);display:flex;align-items:center;gap:8px;">
                    <i class="fa-solid fa-image" style="color:#2563EB;"></i>
                    Bukti Pembayaran
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-3">
                <img id="proof-modal-img" src="" alt="Bukti"
                     style="max-width:100%;border-radius:12px;box-shadow:0 4px 20px rgba(0,0,0,.15);">
            </div>
        </div>
    </div>
</div>

@endsection

@section('custom-js')
<script>
/* ── Filter tabs ── */
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

/* ── Proof modal ── */
function showProof(src) {
    document.getElementById('proof-modal-img').src = src;
    new bootstrap.Modal(document.getElementById('proofModal')).show();
}

/* ── Counter animation ── */
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.pay-stat-num[data-count]').forEach(function(el) {
        var target = parseInt(el.getAttribute('data-count'));
        if (isNaN(target) || target === 0) return;
        var start = 0;
        var step  = Math.max(1, Math.ceil(target / 40));
        var timer = setInterval(function() {
            start = Math.min(start + step, target);
            el.textContent = start.toLocaleString('id-ID');
            if (start >= target) clearInterval(timer);
        }, 18);
    });
});
</script>
@endsection