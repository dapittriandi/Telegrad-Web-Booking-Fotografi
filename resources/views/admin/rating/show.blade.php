@extends('base.base-admin-index')

@php $menu = 'Rating'; $submenu = 'Detail Rating'; $subdesc = 'Detail ulasan dari customer'; @endphp

@section('custom-css')
<style>
/* ── Icon Fix ── */
@font-face { font-family:"Font Awesome 6 Free"; font-weight:900; font-display:block; src:url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/webfonts/fa-solid-900.woff2") format("woff2"); }
.fa-solid,.fas{font-family:"Font Awesome 6 Free"!important;font-weight:900!important;}

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
.rating-banner-title { font-size:1.1rem; font-weight:800; color:#fff; letter-spacing:-.02em; margin-bottom:6px; }
.banner-btn {
    display:inline-flex; align-items:center; gap:6px;
    font-size:.73rem; font-weight:600; color:rgba(255,255,255,.85);
    background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.18);
    padding:6px 14px; border-radius:8px; text-decoration:none;
    transition:background .15s, transform .15s; line-height:1;
}
.banner-btn:hover { background:rgba(255,255,255,.2); color:#fff; transform:translateY(-1px); text-decoration:none; }
.banner-meta { display:flex; gap:8px; flex-wrap:wrap; margin-top:12px; }
.banner-meta-pill {
    display:inline-flex; align-items:center; gap:5px;
    background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.15);
    color:rgba(255,255,255,.75); font-size:.7rem; font-weight:600;
    padding:3px 10px; border-radius:100px;
}

/* ── Detail Card ── */
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
    display:flex; align-items:center; gap:8px;
}
.tg-card-head h5 { color:#fff; font-size:.88rem; font-weight:700; margin:0; display:flex; align-items:center; gap:7px; line-height:1; }
.tg-card-body { padding:24px; }
.tg-card-footer {
    background:var(--tg-glass,#fff)!important;
    border-top:1px solid var(--tg-border,#F3F4F6)!important;
    padding:14px 24px!important;
    display:flex; align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap;
}

/* ── Info fields ── */
.info-label { font-size:.63rem; font-weight:700; text-transform:uppercase; letter-spacing:.09em; color:var(--tg-text-3,#9CA3AF); margin-bottom:5px; }
.info-value { font-size:.88rem; font-weight:700; color:var(--tg-text,#111827); margin:0; line-height:1.3; }
.info-sub   { font-size:.75rem; color:var(--tg-text-3,#9CA3AF); margin:3px 0 0; }

/* ── Info grid ── */
.info-group { padding:14px 0; border-bottom:1px solid var(--tg-border,#F3F4F6); }
.info-group:last-child { border-bottom:none; padding-bottom:0; }
.info-group:first-child { padding-top:0; }

/* ── Stars ── */
.star-filled { color:#F59E0B; }
.star-empty  { color:var(--tg-border,#D1D5DB); }

/* ── Review bubble ── */
.review-bubble {
    background:var(--tg-glass,#F9FAFB);
    border:1.5px solid var(--tg-border,#F3F4F6);
    border-left:4px solid #F59E0B;
    border-radius:0 10px 10px 0;
    padding:16px 18px;
}
.review-bubble p { font-size:.92rem; color:var(--tg-text,#374151); font-style:italic; margin:0; line-height:1.75; }

/* ── Big rating display ── */
.big-rating-wrap {
    display:flex; align-items:center; gap:14px;
    background:var(--tg-glass,#FFFBEB);
    border:1.5px solid rgba(245,158,11,.15);
    border-radius:12px; padding:14px 16px;
}
.big-rating-num { font-size:2.5rem; font-weight:800; color:#D97706; line-height:1; letter-spacing:-.03em; }

/* ── Section label ── */
.section-label { font-size:.63rem; font-weight:700; text-transform:uppercase; letter-spacing:.1em; color:var(--tg-text-3,#9CA3AF); margin-bottom:10px; }
</style>
@endsection

@section('content')

{{-- ── Banner ── --}}
<div class="rating-banner mb-4">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:12px;">
        <div>
            <h2 class="rating-banner-title">
                @for($i=1;$i<=5;$i++)
                    <i class="fa-solid fa-star" style="font-size:.85rem;color:{{ $i<=($rating->rating??0) ? '#FCD34D' : 'rgba(255,255,255,.2)' }};"></i>
                @endfor
                <span style="margin-left:8px;">Detail Ulasan</span>
            </h2>
            <p style="font-size:.78rem;color:rgba(255,255,255,.55);margin:0;">{{ $rating->user->name ?? 'Customer' }} · {{ \Carbon\Carbon::parse($rating->created_at)->isoFormat('D MMMM YYYY') }}</p>
        </div>
        <a href="{{ route('ratings.index') }}" class="banner-btn">
            <i class="fa-solid fa-arrow-left" style="font-size:.72rem;"></i> Kembali
        </a>
    </div>
    <div class="banner-meta">
        <span class="banner-meta-pill"><i class="fa-solid fa-hashtag" style="font-size:.62rem;"></i> ID #{{ $rating->id }}</span>
        <span class="banner-meta-pill"><i class="fa-solid fa-star" style="font-size:.62rem;color:#FCD34D;"></i> {{ $rating->rating ?? 0 }} Bintang</span>
        <span class="banner-meta-pill"><i class="fa-solid fa-clock" style="font-size:.62rem;"></i> {{ \Carbon\Carbon::parse($rating->created_at)->format('H:i') }} WIB</span>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <p class="section-label">Detail Ulasan</p>
        <div class="tg-card">
            <div class="tg-card-head">
                <h5><i class="fa-solid fa-star" style="font-size:.82rem;color:#FCD34D;"></i> Detail Rating</h5>
            </div>
            <div class="tg-card-body">

                <div class="row g-0">

                    {{-- Rating besar ── --}}
                    <div class="col-12 info-group">
                        <p class="info-label">Rating</p>
                        <div class="big-rating-wrap">
                            <div class="big-rating-num">{{ $rating->rating ?? 0 }}</div>
                            <div>
                                <div style="margin-bottom:5px;">
                                    @for($i=1;$i<=5;$i++)
                                        <i class="fa-solid fa-star {{ $i<=($rating->rating??0) ? 'star-filled' : 'star-empty' }}" style="font-size:1.1rem;"></i>
                                    @endfor
                                </div>
                                <p style="font-size:.75rem;color:var(--tg-text-3,#9CA3AF);margin:0;">dari 5 bintang</p>
                            </div>
                        </div>
                    </div>

                    {{-- Customer ── --}}
                    <div class="col-md-6 info-group" style="padding-right:20px;">
                        <p class="info-label">Customer</p>
                        <p class="info-value">{{ $rating->user->name ?? '-' }}</p>
                        <p class="info-sub">{{ $rating->user->email ?? '' }}</p>
                    </div>

                    {{-- Paket ── --}}
                    <div class="col-md-6 info-group">
                        <p class="info-label">Paket</p>
                        <p class="info-value">{{ $rating->order->package->name ?? '-' }}</p>
                        <p class="info-sub">{{ $rating->order->package->category->name ?? '' }}</p>
                    </div>

                    {{-- Tanggal ── --}}
                    <div class="col-12 info-group">
                        <p class="info-label">Tanggal Ulasan</p>
                        <p class="info-value">{{ \Carbon\Carbon::parse($rating->created_at)->isoFormat('dddd, D MMMM YYYY') }}</p>
                        <p class="info-sub">Pukul {{ \Carbon\Carbon::parse($rating->created_at)->format('H:i') }} WIB</p>
                    </div>

                    {{-- Ulasan ── --}}
                    <div class="col-12 info-group">
                        <p class="info-label">Ulasan Customer</p>
                        <div class="review-bubble">
                            <p>"{{ $rating->review ?? 'Tidak ada ulasan tertulis.' }}"</p>
                        </div>
                    </div>

                </div>

            </div>
            <div class="tg-card-footer">
                <span style="font-size:.76rem;color:var(--tg-text-3,#9CA3AF);">
                    <i class="fa-solid fa-circle-info" style="font-size:.7rem;margin-right:4px;"></i>
                    Hapus ulasan ini secara permanen?
                </span>
                <form id="delete-form-{{ $rating->id }}" action="{{ route('ratings.destroy', $rating->id) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="button" class="btn btn-outline-danger btn-sm"
                            style="border-radius:8px;font-size:.78rem;padding:6px 14px;display:inline-flex;align-items:center;gap:6px;"
                            onclick="deleteData({{ $rating->id }})">
                        <i class="fa-solid fa-trash" style="font-size:.72rem;"></i> Hapus Rating
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection