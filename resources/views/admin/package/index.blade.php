@extends('base.base-admin-index')

@php $menu = 'Paket'; $submenu = 'Paket Foto'; $subdesc = 'Kelola semua paket foto yang tersedia'; @endphp

@section('custom-css')
<style>
    @font-face { font-family:"Font Awesome 6 Free"; font-weight:900; font-display:block; src:url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/webfonts/fa-solid-900.woff2") format("woff2"); }
    .fa-solid,.fas{font-family:"Font Awesome 6 Free"!important;font-weight:900!important;}

    .tg-stat { display:flex; align-items:center; gap:14px; padding:16px 20px; background:#fff; border-radius:12px; box-shadow:0 1px 3px rgba(0,0,0,.06),0 4px 16px rgba(0,0,0,.04); height:100%; }
    .tg-stat-icon { width:46px; height:46px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.1rem; flex-shrink:0; }
    .tg-stat-num { font-size:1.5rem; font-weight:800; line-height:1; color:#111827; }
    .tg-stat-lbl { font-size:.7rem; color:#9CA3AF; text-transform:uppercase; letter-spacing:.07em; margin-top:3px; }

    .tg-card { border:none!important; border-radius:14px!important; box-shadow:0 1px 3px rgba(0,0,0,.06),0 4px 16px rgba(0,0,0,.05)!important; }
    .tg-card .card-header { background:#fff!important; border-bottom:1px solid #F3F4F6!important; padding:15px 20px!important; }
    .tg-card .card-header .card-title { font-size:.95rem!important; font-weight:700!important; color:#111827!important; margin:0; }

    .tg-table thead th { font-size:.7rem!important; text-transform:uppercase!important; letter-spacing:.07em!important; color:#9CA3AF!important; background:#FAFAFA!important; border-bottom:1px solid #F3F4F6!important; padding:10px 14px!important; }
    .tg-table tbody td { padding:11px 14px!important; vertical-align:middle!important; font-size:.84rem!important; border-bottom:1px solid #F9FAFB!important; }
    .tg-table tbody tr:last-child td { border-bottom:none!important; }
    .tg-table tbody tr:hover td { background:#FAFBFF!important; }

    .pkg-name { font-weight:700; color:#111827; font-size:.88rem; }
    .pkg-sub  { font-size:.74rem; color:#9CA3AF; margin-top:1px; }
    .cat-badge { display:inline-flex; align-items:center; gap:5px; background:#EFF6FF; color:#1E40AF; font-size:.72rem; font-weight:600; padding:3px 10px; border-radius:100px; }
    .status-active   { background:#D1FAE5; color:#065F46; font-size:.7rem; font-weight:600; padding:3px 10px; border-radius:100px; }
    .status-inactive { background:#F3F4F6; color:#6B7280; font-size:.7rem; font-weight:600; padding:3px 10px; border-radius:100px; }
    .btn-act { padding:5px 11px; font-size:.75rem; border-radius:7px; }
    .price-val { font-weight:700; color:#111827; font-size:.88rem; }
    .section-label { font-size:.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.1em; color:#9CA3AF; margin-bottom:10px; }
</style>
@endsection

@section('content')

{{-- Stat Cards --}}
<p class="section-label">Statistik Paket</p>
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="tg-stat">
            <div class="tg-stat-icon" style="background:#EFF6FF;"><i class="fa-solid fa-box text-primary"></i></div>
            <div><div class="tg-stat-num">{{ $packages->count() }}</div><div class="tg-stat-lbl">Total Paket</div></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="tg-stat">
            <div class="tg-stat-icon" style="background:#D1FAE5;"><i class="fa-solid fa-circle-check" style="color:#059669;"></i></div>
            <div><div class="tg-stat-num">{{ $packages->where('is_active', true)->count() }}</div><div class="tg-stat-lbl">Aktif</div></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="tg-stat">
            <div class="tg-stat-icon" style="background:#F3F4F6;"><i class="fa-solid fa-circle-xmark" style="color:#9CA3AF;"></i></div>
            <div><div class="tg-stat-num">{{ $packages->where('is_active', false)->count() }}</div><div class="tg-stat-lbl">Non-aktif</div></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="tg-stat">
            <div class="tg-stat-icon" style="background:#FEF3C7;"><i class="fa-solid fa-tag" style="color:#D97706;"></i></div>
            <div>
                <div class="tg-stat-num" style="font-size:1.1rem;">
                    Rp {{ number_format($packages->min('price') ?? 0, 0, ',', '.') }}
                </div>
                <div class="tg-stat-lbl">Harga Terendah</div>
            </div>
        </div>
    </div>
</div>

{{-- Table --}}
<p class="section-label">Daftar Paket</p>
<div class="card tg-card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title">
            <i class="fa-solid fa-camera me-2 text-primary"></i>Paket Foto
        </h5>
        <a href="{{ route('packages.create') }}" class="btn btn-sm btn-primary" style="border-radius:8px;font-size:.78rem;font-weight:600;">
            <i class="fa-solid fa-plus me-1"></i> Tambah Paket
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table tg-table mb-0" id="table1">
                <thead>
                    <tr>
                        <th style="padding-left:20px!important;">#</th>
                        <th>Nama Paket</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Durasi</th>
                        <th>Peserta</th>
                        <th>Status</th>
                        <th class="text-center" style="padding-right:20px!important;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($packages as $item)
                    <tr>
                        <td style="padding-left:20px!important;color:#D1D5DB;font-size:.72rem;font-weight:700;">{{ $loop->iteration }}</td>
                        <td>
                            <div class="pkg-name">{{ $item->name }}</div>
                            @if($item->features)
                            <div class="pkg-sub">{{ Str::limit(explode("\n", $item->features)[0] ?? '', 40) }}</div>
                            @endif
                        </td>
                        <td>
                            <span class="cat-badge">
                                <i class="fa-solid fa-folder" style="font-size:.65rem;"></i>
                                {{ $item->category->name ?? '-' }}
                            </span>
                        </td>
                        <td><span class="price-val">Rp {{ number_format($item->price, 0, ',', '.') }}</span></td>
                        <td style="color:#6B7280;">{{ $item->duration }} mnt</td>
                        <td style="font-size:.82rem;color:#6B7280;">{{ Str::limit($item->participants ?? '-', 30) }}</td>
                        <td>
                            @if($item->is_active)
                                <span class="status-active">Aktif</span>
                            @else
                                <span class="status-inactive">Non-aktif</span>
                            @endif
                        </td>
                        <td class="text-center" style="padding-right:20px!important;">
                            <div class="d-flex gap-1 justify-content-center">
                                <a href="{{ route('packages.edit', $item->id) }}" class="btn btn-sm btn-outline-primary btn-act" title="Edit">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <form id="delete-form-{{ $item->id }}" action="{{ route('packages.destroy', $item->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-outline-danger btn-act" onclick="deleteData('{{ $item->id }}')" title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5" style="color:#9CA3AF;">
                            <i class="fa-solid fa-box-open fa-2x d-block mb-2" style="opacity:.3;"></i>
                            Belum ada paket tersedia
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection