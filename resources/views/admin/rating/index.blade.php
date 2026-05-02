@extends('base.base-admin-index')

@php $menu = 'Rating'; $submenu = 'Rating & Ulasan'; $subdesc = 'Lihat semua rating dan ulasan dari customer'; @endphp

@section('custom-css')
<style>
/* ── Icon Fix ── */
@font-face { font-family:"Font Awesome 6 Free"; font-weight:900; font-display:block; src:url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/webfonts/fa-solid-900.woff2") format("woff2"); }
.fa-solid,.fas{font-family:"Font Awesome 6 Free"!important;font-weight:900!important;}
.fa-regular{font-family:"Font Awesome 6 Free"!important;font-weight:400!important;}

/* ── Page Banner ── */
.rating-banner {
    background: linear-gradient(135deg, #0A1628 0%, #1E3A8A 55%, #2563EB 100%);
    border-radius: 16px; padding: 20px 24px; margin-bottom: 20px;
    position: relative; overflow: hidden;
    box-shadow: 0 4px 24px rgba(37,99,235,.22);
}
.rating-banner::before {
    content:''; position:absolute; top:-30px; right:-30px;
    width:180px; height:180px; border-radius:50%; background:rgba(255,255,255,.05);
}
.rating-banner::after {
    content:''; position:absolute; bottom:-40px; right:80px;
    width:120px; height:120px; border-radius:50%; background:rgba(255,255,255,.04);
}
.rating-banner-title { font-size:1.1rem; font-weight:800; color:#fff; letter-spacing:-.02em; margin-bottom:4px; }
.rating-banner-sub   { font-size:.78rem; color:rgba(255,255,255,.55); margin:0; }

/* ── Stat Cards ── */
.stat-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:20px; }
@media(max-width:900px) { .stat-grid { grid-template-columns:repeat(2,1fr); } }
@media(max-width:480px) { .stat-grid { grid-template-columns:1fr 1fr; } }
.stat-card {
    background:var(--tg-glass,#fff);
    backdrop-filter:var(--tg-blur,none);
    border:1px solid var(--tg-glass-border,#F3F4F6);
    border-radius:14px; box-shadow:0 1px 3px rgba(0,0,0,.06),0 4px 16px rgba(0,0,0,.05);
    padding:18px 16px 14px; position:relative; overflow:hidden;
    transition:transform .2s, box-shadow .2s;
}
.stat-card:hover { transform:translateY(-3px); box-shadow:0 8px 28px rgba(37,99,235,.12); }
.stat-card-top { display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:12px; }
.stat-card-icon { width:42px; height:42px; border-radius:11px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.stat-card-num { font-size:1.65rem; font-weight:800; line-height:1; color:var(--tg-text,#111827); margin-bottom:4px; letter-spacing:-.03em; }
.stat-card-lbl { font-size:.63rem; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:var(--tg-text-3,#9CA3AF); }
.stat-card-accent { position:absolute; bottom:0; left:0; right:0; height:3px; border-radius:0 0 14px 14px; }

/* ── Cards ── */
.tg-card {
    border:1px solid var(--tg-glass-border,#F3F4F6)!important;
    border-radius:14px!important;
    box-shadow:0 1px 3px rgba(0,0,0,.06),0 4px 16px rgba(0,0,0,.05)!important;
    overflow:hidden;
    background:var(--tg-glass,#fff);
    backdrop-filter:var(--tg-blur,none);
}
.tg-card-head {
    background:linear-gradient(135deg,#0A1628,#1E3A8A);
    padding:13px 18px;
    display:flex; align-items:center; justify-content:space-between; gap:8px;
}
.tg-card-head h5 { color:#fff; font-size:.88rem; font-weight:700; margin:0; display:flex; align-items:center; gap:7px; line-height:1; }
.tg-card-head .count-pill { font-size:.68rem; font-weight:600; color:rgba(255,255,255,.65); background:rgba(255,255,255,.1); padding:3px 9px; border-radius:100px; }

/* ── Distribution Card ── */
.dist-card {
    border:1px solid var(--tg-glass-border,#F3F4F6)!important;
    border-radius:14px!important;
    box-shadow:0 1px 3px rgba(0,0,0,.06),0 4px 16px rgba(0,0,0,.05)!important;
    overflow:hidden;
    background:var(--tg-glass,#fff);
}
.dist-card-head {
    background:linear-gradient(135deg,#0A1628,#1E3A8A);
    padding:13px 18px;
}
.dist-card-head h5 { color:#fff; font-size:.88rem; font-weight:700; margin:0; display:flex; align-items:center; gap:7px; line-height:1; }
.dist-card-body { padding:16px 18px; }

/* ── Rating bars ── */
.rating-bar-wrap { display:flex; align-items:center; gap:8px; margin-bottom:7px; }
.rating-bar-label { font-size:.74rem; font-weight:700; color:var(--tg-text-2,#374151); width:16px; text-align:right; flex-shrink:0; }
.rating-bar { flex:1; height:7px; background:var(--tg-border,#F3F4F6); border-radius:100px; overflow:hidden; }
.rating-bar-fill { height:100%; background:linear-gradient(90deg,#F59E0B,#FCD34D); border-radius:100px; transition:width .6s cubic-bezier(.4,0,.2,1); }
.rating-bar-count { font-size:.7rem; color:var(--tg-text-3,#9CA3AF); width:22px; flex-shrink:0; text-align:right; }

/* ── Table ── */
.tg-table thead th {
    font-size:.66rem!important; font-weight:700!important;
    text-transform:uppercase!important; letter-spacing:.07em!important;
    color:var(--tg-text-3,#9CA3AF)!important;
    background:var(--tg-glass,#FAFAFA)!important;
    border-bottom:1px solid var(--tg-border,#F3F4F6)!important;
    padding:10px 14px!important; white-space:nowrap; vertical-align:middle!important;
}
.tg-table tbody td {
    padding:11px 14px!important; vertical-align:middle!important;
    font-size:.83rem!important;
    border-bottom:1px solid var(--tg-border,#F9FAFB)!important;
    color:var(--tg-text,#111827)!important;
}
.tg-table tbody tr:last-child td { border-bottom:none!important; }
.tg-table tbody tr:hover td { background:rgba(37,99,235,.03)!important; }

/* ── Stars ── */
.star-filled { color:#F59E0B; font-size:.8rem; }
.star-empty  { color:var(--tg-border,#D1D5DB); font-size:.8rem; }

/* ── Mini avatar ── */
.mini-avatar {
    width:30px; height:30px; border-radius:9px;
    background:linear-gradient(135deg,#0A1628,#2563EB);
    color:#fff; font-size:.66rem; font-weight:700;
    display:inline-flex; align-items:center; justify-content:center; flex-shrink:0;
}

/* ── Action buttons ── */
.btn-act { padding:4px 10px; font-size:.73rem; border-radius:7px; display:inline-flex; align-items:center; gap:4px; transition:transform .15s; }
.btn-act:hover { transform:translateY(-1px); }

/* ── Section label ── */
.section-label { font-size:.63rem; font-weight:700; text-transform:uppercase; letter-spacing:.1em; color:var(--tg-text-3,#9CA3AF); margin-bottom:10px; }

/* ── Empty state ── */
.empty-state { text-align:center; padding:40px 12px; color:var(--tg-text-3,#9CA3AF); font-size:.85rem; }
.empty-state i { font-size:2rem; opacity:.25; display:block; margin-bottom:10px; }

/* ── Review quote ── */
.review-quote { font-size:.81rem; color:var(--tg-text-2,#6B7280); font-style:italic; margin:0; }
</style>
@endsection

@section('content')

@php
    $total    = $ratings->count();
    $avg      = $ratings->avg('rating') ?? 0;
    $fiveStar = $ratings->where('rating',5)->count();
    $oneStar  = $ratings->where('rating',1)->count();
@endphp

{{-- ── Banner ── --}}
<div class="rating-banner mb-4">
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
        <div>
            <h2 class="rating-banner-title"><i class="fa-solid fa-star me-2" style="opacity:.8;color:#FCD34D;"></i>Rating & Ulasan</h2>
            <p class="rating-banner-sub">Pantau kepuasan customer berdasarkan ulasan yang masuk.</p>
        </div>
        <div style="text-align:center;">
            <div style="font-size:2.2rem;font-weight:800;color:#fff;line-height:1;letter-spacing:-.03em;">{{ number_format($avg,1) }}</div>
            <div style="margin:4px 0;">
                @for($i=1;$i<=5;$i++)
                    <i class="fa-solid fa-star" style="color:{{ $i<=round($avg) ? '#FCD34D' : 'rgba(255,255,255,.25)' }};font-size:.75rem;"></i>
                @endfor
            </div>
            <div style="font-size:.68rem;color:rgba(255,255,255,.5);">dari {{ $total }} ulasan</div>
        </div>
    </div>
</div>

{{-- ── Stat Cards ── --}}
<p class="section-label">Statistik Rating</p>
<div class="stat-grid">

    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon" style="background:rgba(37,99,235,.1);">
                <i class="fa-solid fa-star" style="color:#2563EB;font-size:1rem;"></i>
            </div>
            <span style="font-size:.62rem;font-weight:700;background:rgba(37,99,235,.1);color:#2563EB;padding:3px 9px;border-radius:100px;">Total</span>
        </div>
        <div class="stat-card-num">{{ $total }}</div>
        <div class="stat-card-lbl">Total Rating</div>
        <div class="stat-card-accent" style="background:#3B82F6;"></div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon" style="background:rgba(245,158,11,.1);">
                <i class="fa-solid fa-star-half-stroke" style="color:#F59E0B;font-size:1rem;"></i>
            </div>
            <span style="font-size:.62rem;font-weight:700;background:rgba(245,158,11,.1);color:#D97706;padding:3px 9px;border-radius:100px;">Avg</span>
        </div>
        <div class="stat-card-num">{{ number_format($avg,1) }}</div>
        <div class="stat-card-lbl">Rata-rata</div>
        <div class="stat-card-accent" style="background:#F59E0B;"></div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon" style="background:rgba(5,150,105,.1);">
                <i class="fa-solid fa-thumbs-up" style="color:#059669;font-size:1rem;"></i>
            </div>
            <span style="font-size:.62rem;font-weight:700;background:rgba(5,150,105,.1);color:#059669;padding:3px 9px;border-radius:100px;">Top</span>
        </div>
        <div class="stat-card-num">{{ $fiveStar }}</div>
        <div class="stat-card-lbl">Bintang 5</div>
        <div class="stat-card-accent" style="background:#10B981;"></div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon" style="background:rgba(239,68,68,.1);">
                <i class="fa-solid fa-thumbs-down" style="color:#EF4444;font-size:1rem;"></i>
            </div>
            <span style="font-size:.62rem;font-weight:700;background:rgba(239,68,68,.1);color:#EF4444;padding:3px 9px;border-radius:100px;">Low</span>
        </div>
        <div class="stat-card-num">{{ $oneStar }}</div>
        <div class="stat-card-lbl">Bintang 1</div>
        <div class="stat-card-accent" style="background:#EF4444;"></div>
    </div>

</div>

{{-- ── Main Content ── --}}
<div class="row g-3">

    {{-- Distribution ── --}}
    <div class="col-lg-3">
        <p class="section-label">Distribusi</p>
        <div class="dist-card">
            <div class="dist-card-head">
                <h5><i class="fa-solid fa-chart-bar" style="font-size:.82rem;"></i> Distribusi Bintang</h5>
            </div>
            <div class="dist-card-body">
                @for($star = 5; $star >= 1; $star--)
                @php $cnt = $ratings->where('rating',$star)->count(); $pct = $total > 0 ? ($cnt/$total*100) : 0; @endphp
                <div class="rating-bar-wrap">
                    <span class="rating-bar-label">{{ $star }}</span>
                    <i class="fa-solid fa-star star-filled" style="font-size:.65rem;flex-shrink:0;"></i>
                    <div class="rating-bar"><div class="rating-bar-fill" style="width:{{ $pct }}%;"></div></div>
                    <span class="rating-bar-count">{{ $cnt }}</span>
                </div>
                @endfor

                @if($total > 0)
                <div class="text-center mt-3 pt-3" style="border-top:1px solid var(--tg-border,#F3F4F6);">
                    <div style="font-size:2rem;font-weight:800;color:var(--tg-text,#111827);line-height:1;letter-spacing:-.03em;">{{ number_format($avg,1) }}</div>
                    <div style="margin:5px 0;">
                        @for($i=1;$i<=5;$i++)
                            <i class="fa-solid fa-star {{ $i<=round($avg) ? 'star-filled' : 'star-empty' }}" style="font-size:.78rem;"></i>
                        @endfor
                    </div>
                    <div style="font-size:.71rem;color:var(--tg-text-3,#9CA3AF);">dari {{ $total }} ulasan</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Table ── --}}
    <div class="col-lg-9">
        <p class="section-label">Daftar Ulasan</p>
        <div class="tg-card">
            <div class="tg-card-head">
                <h5><i class="fa-solid fa-comments" style="font-size:.82rem;"></i> Rating & Ulasan</h5>
                <span class="count-pill">{{ $total }} ulasan</span>
            </div>
            <div class="table-responsive">
                <table class="table tg-table mb-0">
                    <thead>
                        <tr>
                            <th style="padding-left:20px!important;width:40px;">#</th>
                            <th>Customer</th>
                            <th>Paket</th>
                            <th>Rating</th>
                            <th>Ulasan</th>
                            <th>Tanggal</th>
                            <th class="text-center" style="padding-right:20px!important;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ratings as $item)
                        <tr>
                            <td style="padding-left:20px!important;">
                                <span style="font-size:.68rem;font-weight:700;color:var(--tg-text-3,#D1D5DB);">{{ $loop->iteration }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="mini-avatar">{{ strtoupper(substr($item->user->name ?? 'U',0,1)) }}</div>
                                    <div>
                                        <div style="font-weight:700;font-size:.84rem;line-height:1.3;color:var(--tg-text,#111827);">{{ $item->user->name ?? '-' }}</div>
                                        <div style="font-size:.71rem;color:var(--tg-text-3,#9CA3AF);">{{ $item->user->email ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-size:.84rem;font-weight:600;color:var(--tg-text,#111827);line-height:1.3;">{{ $item->order->package->name ?? '-' }}</div>
                                <div style="font-size:.71rem;color:var(--tg-text-3,#9CA3AF);">{{ $item->order->package->category->name ?? '' }}</div>
                            </td>
                            <td>
                                <div>
                                    @for($i=1;$i<=5;$i++)
                                        <i class="fa-solid fa-star {{ $i<=($item->rating??0) ? 'star-filled' : 'star-empty' }}"></i>
                                    @endfor
                                </div>
                                <div style="font-size:.69rem;color:var(--tg-text-3,#9CA3AF);margin-top:2px;">{{ $item->rating ?? 0 }}/5</div>
                            </td>
                            <td style="max-width:220px;">
                                <p class="review-quote">"{{ Str::limit($item->review ?? '-', 65) }}"</p>
                            </td>
                            <td style="font-size:.8rem;color:var(--tg-text-2,#6B7280);">
                                {{ \Carbon\Carbon::parse($item->created_at)->isoFormat('D MMM YYYY') }}
                            </td>
                            <td class="text-center" style="padding-right:20px!important;">
                                <div class="d-flex gap-1 justify-content-center">
                                    <a href="{{ route('ratings.show', $item->id) }}" class="btn btn-sm btn-outline-primary btn-act" title="Detail">
                                        <i class="fa-solid fa-eye" style="font-size:.72rem;"></i>
                                    </a>
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('ratings.destroy', $item->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-act"
                                                onclick="deleteData({{ $item->id }})" title="Hapus">
                                            <i class="fa-solid fa-trash" style="font-size:.72rem;"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fa-solid fa-star"></i>
                                    Belum ada rating & ulasan masuk.
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

@endsection