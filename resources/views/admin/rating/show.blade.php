@extends('base.base-admin-index')

@php $menu = 'Rating'; $submenu = 'Detail Rating'; $subdesc = 'Detail ulasan dari customer'; @endphp

@section('custom-css')
<style>
    @font-face { font-family:"Font Awesome 6 Free"; font-weight:900; font-display:block; src:url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/webfonts/fa-solid-900.woff2") format("woff2"); }
    .fa-solid,.fas{font-family:"Font Awesome 6 Free"!important;font-weight:900!important;}

    .tg-card { border:none!important; border-radius:14px!important; box-shadow:0 1px 3px rgba(0,0,0,.06),0 4px 16px rgba(0,0,0,.05)!important; }
    .tg-card .card-header { background:#fff!important; border-bottom:1px solid #F3F4F6!important; padding:15px 20px!important; }
    .tg-card .card-header .card-title { font-size:.95rem!important; font-weight:700!important; color:#111827!important; margin:0; }
    .tg-card .card-body { padding:24px!important; }

    .info-label { font-size:.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:#9CA3AF; margin-bottom:4px; }
    .info-value { font-size:.88rem; font-weight:600; color:#111827; margin:0; }
    .info-sub   { font-size:.76rem; color:#9CA3AF; margin:2px 0 0; }
    .section-label { font-size:.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.1em; color:#9CA3AF; margin-bottom:10px; }
    .star-filled { color:#F59E0B; }
    .star-empty  { color:#D1D5DB; }
</style>
@endsection

@section('content')

<div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
    <div class="d-flex align-items-center gap-2">
        @for($i=1;$i<=5;$i++)
            <i class="fa-solid fa-star {{ $i<=($rating->rating??0) ? 'star-filled' : 'star-empty' }}" style="font-size:1rem;"></i>
        @endfor
        <span style="font-size:.8rem;color:#9CA3AF;margin-left:4px;">{{ $rating->rating ?? 0 }} bintang</span>
    </div>
    <a href="{{ route('ratings.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;font-size:.78rem;">
        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <p class="section-label">Detail Ulasan</p>
        <div class="card tg-card">
            <div class="card-header">
                <h5 class="card-title"><i class="fa-solid fa-star me-2" style="color:#F59E0B;"></i>Detail Rating</h5>
            </div>
            <div class="card-body">
                <div class="row g-4">

                    <div class="col-md-6">
                        <p class="info-label">Customer</p>
                        <p class="info-value">{{ $rating->user->name ?? '-' }}</p>
                        <p class="info-sub">{{ $rating->user->email ?? '' }}</p>
                    </div>

                    <div class="col-md-6">
                        <p class="info-label">Paket</p>
                        <p class="info-value">{{ $rating->order->package->name ?? '-' }}</p>
                        <p class="info-sub">{{ $rating->order->package->category->name ?? '' }}</p>
                    </div>

                    <div class="col-md-6">
                        <p class="info-label">Rating</p>
                        <div style="font-size:1.5rem;line-height:1;">
                            @for($i=1;$i<=5;$i++)
                                <i class="fa-solid fa-star {{ $i<=($rating->rating??0) ? 'star-filled' : 'star-empty' }}"></i>
                            @endfor
                        </div>
                        <p class="info-sub" style="margin-top:4px;">{{ $rating->rating ?? 0 }} dari 5 bintang</p>
                    </div>

                    <div class="col-md-6">
                        <p class="info-label">Tanggal Ulasan</p>
                        <p class="info-value">{{ \Carbon\Carbon::parse($rating->created_at)->isoFormat('dddd, D MMMM YYYY') }}</p>
                        <p class="info-sub">{{ \Carbon\Carbon::parse($rating->created_at)->format('H:i') }} WIB</p>
                    </div>

                    <div class="col-12">
                        <p class="info-label">Ulasan</p>
                        <div style="background:#F9FAFB;border-radius:10px;padding:16px;border-left:3px solid #FEF3C7;">
                            <p style="font-size:.9rem;color:#374151;font-style:italic;margin:0;line-height:1.7;">
                                "{{ $rating->review ?? 'Tidak ada ulasan.' }}"
                            </p>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-footer" style="background:#fff!important;border-top:1px solid #F3F4F6!important;padding:14px 24px!important;">
                <form id="delete-form-{{ $rating->id }}" action="{{ route('ratings.destroy', $rating->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="button" class="btn btn-outline-danger btn-sm" style="border-radius:8px;" onclick="deleteData({{ $rating->id }})">
                        <i class="fa-solid fa-trash me-1"></i> Hapus Rating
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection