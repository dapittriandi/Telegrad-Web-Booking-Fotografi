@extends('base.base-admin-index')

@php $menu = 'Rating'; $submenu = 'Rating & Ulasan'; $subdesc = 'Lihat semua rating dan ulasan dari customer'; @endphp

@section('custom-css')
<style>
    @font-face { font-family:"Font Awesome 6 Free"; font-weight:900; font-display:block; src:url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/webfonts/fa-solid-900.woff2") format("woff2"); }
    .fa-solid,.fas{font-family:"Font Awesome 6 Free"!important;font-weight:900!important;}
    .fa-regular{font-family:"Font Awesome 6 Free"!important;font-weight:400!important;}

    .tg-stat { display:flex; align-items:center; gap:14px; padding:16px 20px; background:#fff; border-radius:12px; box-shadow:0 1px 3px rgba(0,0,0,.06),0 4px 16px rgba(0,0,0,.04); height:100%; }
    .tg-stat-icon { width:46px; height:46px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:1.1rem; flex-shrink:0; }
    .tg-stat-num { font-size:1.5rem; font-weight:800; line-height:1; color:#111827; }
    .tg-stat-lbl { font-size:.7rem; color:#9CA3AF; text-transform:uppercase; letter-spacing:.07em; margin-top:3px; }

    .tg-card { border:none!important; border-radius:14px!important; box-shadow:0 1px 3px rgba(0,0,0,.06),0 4px 16px rgba(0,0,0,.05)!important; overflow:hidden; }
    .tg-card .card-header { background:#fff!important; border-bottom:1px solid #F3F4F6!important; padding:15px 20px!important; }
    .tg-card .card-header .card-title { font-size:.95rem!important; font-weight:700!important; color:#111827!important; margin:0; }

    .tg-table thead th { font-size:.7rem!important; text-transform:uppercase!important; letter-spacing:.07em!important; color:#9CA3AF!important; background:#FAFAFA!important; border-bottom:1px solid #F3F4F6!important; padding:10px 14px!important; }
    .tg-table tbody td { padding:10px 14px!important; vertical-align:middle!important; font-size:.84rem!important; border-bottom:1px solid #F9FAFB!important; }
    .tg-table tbody tr:last-child td { border-bottom:none!important; }
    .tg-table tbody tr:hover td { background:#FAFBFF!important; }

    .star-filled { color:#F59E0B; font-size:.82rem; }
    .star-empty  { color:#D1D5DB; font-size:.82rem; }
    .review-text { font-size:.82rem; color:#6B7280; font-style:italic; }
    .btn-act { padding:4px 10px; font-size:.74rem; border-radius:6px; }
    .mini-avatar { width:28px; height:28px; border-radius:7px; background:linear-gradient(135deg,#1E3A8A,#3B82F6); color:#fff; font-size:.68rem; font-weight:700; display:inline-flex; align-items:center; justify-content:center; }
    .section-label { font-size:.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.1em; color:#9CA3AF; margin-bottom:10px; }

    .rating-bar-wrap { display:flex; align-items:center; gap:8px; margin-bottom:6px; }
    .rating-bar-label { font-size:.76rem; font-weight:600; color:#374151; width:20px; text-align:right; flex-shrink:0; }
    .rating-bar { flex:1; height:8px; background:#F3F4F6; border-radius:100px; overflow:hidden; }
    .rating-bar-fill { height:100%; background:linear-gradient(90deg,#F59E0B,#FCD34D); border-radius:100px; transition:width .4s ease; }
    .rating-bar-count { font-size:.72rem; color:#9CA3AF; width:24px; flex-shrink:0; }
</style>
@endsection

@section('content')

@php
    $total    = $ratings->count();
    $avg      = $ratings->avg('rating') ?? 0;
    $fiveStar = $ratings->where('rating',5)->count();
    $oneStar  = $ratings->where('rating',1)->count();
@endphp

<p class="section-label">Statistik Rating</p>
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="tg-stat">
            <div class="tg-stat-icon" style="background:#EFF6FF;"><i class="fa-solid fa-star text-primary"></i></div>
            <div><div class="tg-stat-num">{{ $total }}</div><div class="tg-stat-lbl">Total Rating</div></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="tg-stat">
            <div class="tg-stat-icon" style="background:#FFFBEB;"><i class="fa-solid fa-star-half-stroke text-warning"></i></div>
            <div><div class="tg-stat-num">{{ number_format($avg,1) }}</div><div class="tg-stat-lbl">Rata-rata</div></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="tg-stat">
            <div class="tg-stat-icon" style="background:#F0FDF4;"><i class="fa-solid fa-thumbs-up text-success"></i></div>
            <div><div class="tg-stat-num">{{ $fiveStar }}</div><div class="tg-stat-lbl">Bintang 5</div></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="tg-stat">
            <div class="tg-stat-icon" style="background:#FFF1F2;"><i class="fa-solid fa-thumbs-down text-danger"></i></div>
            <div><div class="tg-stat-num">{{ $oneStar }}</div><div class="tg-stat-lbl">Bintang 1</div></div>
        </div>
    </div>
</div>

<div class="row g-3">

    {{-- Rating Distribution --}}
    <div class="col-lg-3">
        <p class="section-label">Distribusi</p>
        <div class="card tg-card">
            <div class="card-header">
                <h5 class="card-title"><i class="fa-solid fa-chart-bar me-2 text-primary"></i>Distribusi Bintang</h5>
            </div>
            <div class="card-body" style="padding:16px 20px!important;">
                @for($star = 5; $star >= 1; $star--)
                @php $cnt = $ratings->where('rating',$star)->count(); $pct = $total > 0 ? ($cnt/$total*100) : 0; @endphp
                <div class="rating-bar-wrap">
                    <span class="rating-bar-label">{{ $star }}</span>
                    <i class="fa-solid fa-star star-filled" style="font-size:.7rem;flex-shrink:0;"></i>
                    <div class="rating-bar"><div class="rating-bar-fill" style="width:{{ $pct }}%;"></div></div>
                    <span class="rating-bar-count">{{ $cnt }}</span>
                </div>
                @endfor

                @if($total > 0)
                <div class="text-center mt-3 pt-3" style="border-top:1px solid #F3F4F6;">
                    <div style="font-size:2rem;font-weight:800;color:#111827;line-height:1;">{{ number_format($avg,1) }}</div>
                    <div style="margin:4px 0;">
                        @for($i=1;$i<=5;$i++)
                            <i class="fa-solid fa-star" style="color:{{ $i <= round($avg) ? '#F59E0B' : '#D1D5DB' }};font-size:.8rem;"></i>
                        @endfor
                    </div>
                    <div style="font-size:.72rem;color:#9CA3AF;">dari {{ $total }} ulasan</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="col-lg-9">
        <p class="section-label">Daftar Ulasan</p>
        <div class="card tg-card">
            <div class="card-header">
                <h5 class="card-title"><i class="fa-solid fa-comments me-2 text-primary"></i>Rating & Ulasan</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table tg-table mb-0" id="table1">
                        <thead>
                            <tr>
                                <th style="padding-left:20px!important;">#</th>
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
                                <td style="padding-left:20px!important;font-size:.7rem;font-weight:700;color:#D1D5DB;">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="mini-avatar">{{ strtoupper(substr($item->user->name ?? 'U',0,1)) }}</div>
                                        <div>
                                            <div style="font-weight:700;font-size:.84rem;">{{ $item->user->name ?? '-' }}</div>
                                            <div style="font-size:.72rem;color:#9CA3AF;">{{ $item->user->email ?? '' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-size:.84rem;font-weight:600;">{{ $item->order->package->name ?? '-' }}</div>
                                    <div style="font-size:.72rem;color:#9CA3AF;">{{ $item->order->package->category->name ?? '' }}</div>
                                </td>
                                <td>
                                    <div>
                                        @for($i=1;$i<=5;$i++)
                                            <i class="fa-solid fa-star {{ $i<=($item->rating??0) ? 'star-filled' : 'star-empty' }}"></i>
                                        @endfor
                                    </div>
                                    <div style="font-size:.7rem;color:#9CA3AF;">{{ $item->rating ?? 0 }}/5</div>
                                </td>
                                <td style="max-width:220px;">
                                    <p class="review-text mb-0">"{{ Str::limit($item->review ?? '-', 70) }}"</p>
                                </td>
                                <td style="font-size:.8rem;color:#6B7280;">
                                    {{ \Carbon\Carbon::parse($item->created_at)->isoFormat('D MMM YYYY') }}
                                </td>
                                <td class="text-center" style="padding-right:20px!important;">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <a href="{{ route('ratings.show', $item->id) }}" class="btn btn-sm btn-outline-primary btn-act" title="Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <form id="delete-form-{{ $item->id }}" action="{{ route('ratings.destroy', $item->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger btn-act" onclick="deleteData({{ $item->id }})" title="Hapus">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5" style="color:#9CA3AF;">
                                    <i class="fa-solid fa-star fa-2x d-block mb-2" style="opacity:.3;"></i>
                                    Belum ada rating
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection