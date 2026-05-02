@extends('base.base-admin-index')

@php $menu = 'Portofolio'; $submenu = 'Portofolio'; $subdesc = 'Kelola galeri portofolio foto'; @endphp

@section('custom-css')
<style>
/* ── Icon Fix ── */
@font-face { font-family:"Font Awesome 6 Free"; font-weight:900; font-display:block; src:url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/webfonts/fa-solid-900.woff2") format("woff2"); }
.fa-solid,.fas{font-family:"Font Awesome 6 Free"!important;font-weight:900!important;}

/* ── Page Banner ── */
.porto-banner {
    background: linear-gradient(135deg, #0A1628 0%, #1E3A8A 55%, #2563EB 100%);
    border-radius: 16px;
    padding: 20px 24px;
    margin-bottom: 20px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 24px rgba(37,99,235,.22);
}
.porto-banner::before {
    content:''; position:absolute; top:-30px; right:-30px;
    width:180px; height:180px; border-radius:50%;
    background:rgba(255,255,255,.05);
}
.porto-banner::after {
    content:''; position:absolute; bottom:-40px; right:80px;
    width:120px; height:120px; border-radius:50%;
    background:rgba(255,255,255,.04);
}
.porto-banner-title {
    font-size:1.1rem; font-weight:800; color:#fff;
    letter-spacing:-.02em; margin-bottom:4px;
}
.porto-banner-sub { font-size:.78rem; color:rgba(255,255,255,.55); margin:0; }
.porto-banner-badge {
    background:rgba(255,255,255,.12); border:1px solid rgba(255,255,255,.2);
    color:#fff; font-size:.72rem; font-weight:700;
    padding:5px 14px; border-radius:100px; white-space:nowrap;
    display:inline-flex; align-items:center; gap:6px;
}

/* ── Card ── */
.tg-card {
    border:1px solid var(--tg-glass-border, #F3F4F6)!important;
    border-radius:14px!important;
    box-shadow:0 1px 3px rgba(0,0,0,.06),0 4px 16px rgba(0,0,0,.05)!important;
    overflow:hidden;
    background:var(--tg-glass, #fff);
    backdrop-filter:var(--tg-blur, none);
}

/* ── Table header gradient ── */
.tg-table-head {
    background: linear-gradient(135deg, #0A1628, #1E3A8A);
    padding: 14px 20px;
    display: flex; align-items: center; justify-content: space-between; gap: 10px;
}
.tg-table-head h5 {
    color:#fff; font-size:.92rem; font-weight:700; margin:0;
    display:flex; align-items:center; gap:8px; line-height:1;
}
.tg-table-head .count-pill {
    font-size:.7rem; font-weight:600; color:rgba(255,255,255,.6);
    background:rgba(255,255,255,.1); padding:3px 10px; border-radius:100px;
}

/* ── Add Button ── */
.btn-add-porto {
    display:inline-flex; align-items:center; gap:6px;
    font-size:.73rem; font-weight:700;
    background:#fff; color:#1E3A8A;
    padding:6px 14px; border-radius:8px; border:none;
    text-decoration:none; white-space:nowrap;
    transition:background .15s, transform .15s;
    line-height:1;
}
.btn-add-porto:hover { background:rgba(255,255,255,.88); color:#1E3A8A; transform:translateY(-1px); text-decoration:none; }

/* ── Table ── */
.tg-table thead th {
    font-size:.66rem!important; font-weight:700!important;
    text-transform:uppercase!important; letter-spacing:.07em!important;
    color:var(--tg-text-3, #9CA3AF)!important;
    background:var(--tg-glass, #FAFAFA)!important;
    border-bottom:1px solid var(--tg-border, #F3F4F6)!important;
    padding:10px 14px!important; white-space:nowrap; vertical-align:middle!important;
}
.tg-table tbody td {
    padding:11px 14px!important; vertical-align:middle!important;
    font-size:.83rem!important;
    border-bottom:1px solid var(--tg-border, #F9FAFB)!important;
    color:var(--tg-text, #111827)!important;
}
.tg-table tbody tr:last-child td { border-bottom:none!important; }
.tg-table tbody tr:hover td { background:rgba(37,99,235,.03)!important; }

/* ── Thumbnail ── */
.porto-thumb {
    width:52px; height:52px; object-fit:cover;
    border-radius:10px; border:2px solid rgba(37,99,235,.1);
    cursor:pointer; transition:transform .2s, box-shadow .2s;
}
.porto-thumb:hover { transform:scale(1.1); box-shadow:0 4px 12px rgba(0,0,0,.15); }
.porto-thumb-empty {
    width:52px; height:52px; border-radius:10px;
    background:var(--tg-glass, #F3F4F6);
    border:2px dashed var(--tg-border, #E5E7EB);
    display:flex; align-items:center; justify-content:center;
}

/* ── Badges ── */
.status-active   { background:#D1FAE5; color:#065F46; font-size:.68rem; font-weight:700; padding:3px 10px; border-radius:100px; display:inline-flex; align-items:center; gap:4px; }
.status-inactive { background:#F3F4F6; color:#6B7280; font-size:.68rem; font-weight:700; padding:3px 10px; border-radius:100px; display:inline-flex; align-items:center; gap:4px; }
.cat-badge { background:#EFF6FF; color:#1E40AF; font-size:.7rem; font-weight:700; padding:3px 10px; border-radius:100px; }

[data-theme="dark"] .status-active   { background:rgba(209,250,229,.15); color:#6EE7B7; }
[data-theme="dark"] .status-inactive { background:rgba(255,255,255,.07); color:#9CA3AF; }
[data-theme="dark"] .cat-badge       { background:rgba(219,234,254,.12); color:#93C5FD; }

/* ── Action Buttons ── */
.btn-act {
    padding:4px 10px; font-size:.73rem; border-radius:7px;
    display:inline-flex; align-items:center; gap:4px;
    transition:transform .15s;
}
.btn-act:hover { transform:translateY(-1px); }

/* ── Section label ── */
.section-label {
    font-size:.63rem; font-weight:700;
    text-transform:uppercase; letter-spacing:.1em;
    color:var(--tg-text-3, #9CA3AF); margin-bottom:10px;
}

/* ── Empty state ── */
.empty-state {
    text-align:center; padding:40px 12px;
    color:var(--tg-text-3, #9CA3AF); font-size:.85rem;
}
.empty-state i { font-size:2rem; opacity:.25; display:block; margin-bottom:10px; }

/* ── Alert ── */
.tg-alert {
    border-radius:10px; border:none; font-size:.84rem;
    display:flex; align-items:center; gap:8px;
    padding:10px 14px; margin-bottom:16px;
}
.tg-alert-success { background:#D1FAE5; color:#065F46; }
.tg-alert-danger  { background:#FEE2E2; color:#991B1B; }
[data-theme="dark"] .tg-alert-success { background:rgba(209,250,229,.15); color:#6EE7B7; }
[data-theme="dark"] .tg-alert-danger  { background:rgba(254,226,226,.12); color:#FCA5A5; }

/* ── Modal ── */
#imageModal .modal-content { border:none; border-radius:16px; overflow:hidden; }
#imageModal .modal-header { background:linear-gradient(135deg,#0A1628,#1E3A8A); border:none; padding:14px 20px; }
#imageModal .modal-title { color:#fff; font-size:.9rem; font-weight:700; }
#imageModal .btn-close { filter:invert(1) brightness(2); }
#imageModal .modal-body { padding:16px; background:var(--tg-glass,#fff); }
#imageModal img { border-radius:10px; width:100%; }
</style>
@endsection

@section('content')

{{-- ── Alerts ── --}}
@if(session('success'))
<div class="tg-alert tg-alert-success">
    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="tg-alert tg-alert-danger">
    <i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}
</div>
@endif

{{-- ── Banner ── --}}
<div class="porto-banner mb-4">
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
        <div>
            <h2 class="porto-banner-title"><i class="fa-solid fa-images me-2" style="opacity:.8;"></i>Galeri Portofolio</h2>
            <p class="porto-banner-sub">Kelola dan tampilkan karya terbaik studio Anda kepada pelanggan.</p>
        </div>
        <span class="porto-banner-badge">
            <i class="fa-solid fa-layer-group" style="font-size:.65rem;"></i>
            {{ $portofolios->count() }} Portofolio
        </span>
    </div>
</div>

{{-- ── Table Card ── --}}
<p class="section-label">Daftar Portofolio</p>
<div class="tg-card">
    <div class="tg-table-head">
        <h5>
            <i class="fa-solid fa-images" style="font-size:.88rem;"></i>
            Semua Portofolio
        </h5>
        <a href="{{ route('portfolios.create') }}" class="btn-add-porto">
            <i class="fa-solid fa-plus" style="font-size:.72rem;"></i> Tambah Baru
        </a>
    </div>

    <div class="table-responsive">
        <table class="table tg-table mb-0">
            <thead>
                <tr>
                    <th style="padding-left:20px!important;width:40px;">#</th>
                    <th style="width:70px;">Gambar</th>
                    <th>Judul & Deskripsi</th>
                    <th>Kategori</th>
                    <th class="text-center">Status</th>
                    <th class="text-center" style="padding-right:20px!important;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($portofolios as $key => $item)
                <tr>
                    <td style="padding-left:20px!important;">
                        <span style="font-size:.68rem;font-weight:700;color:var(--tg-text-3,#D1D5DB);">{{ ++$key }}</span>
                    </td>
                    <td>
                        @if($item->image)
                            <img src="{{ asset('storage/images/portofolio/'.$item->image) }}"
                                 class="porto-thumb" alt="{{ $item->title }}"
                                 onclick="showImage('{{ asset('storage/images/portofolio/'.$item->image) }}', '{{ addslashes($item->title) }}')">
                        @else
                            <div class="porto-thumb-empty">
                                <i class="fa-solid fa-image" style="color:var(--tg-text-3,#D1D5DB);font-size:.85rem;"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight:700;color:var(--tg-text,#111827);font-size:.87rem;line-height:1.3;">{{ $item->title }}</div>
                        @if($item->description)
                            <div style="font-size:.73rem;color:var(--tg-text-3,#9CA3AF);margin-top:2px;line-height:1.4;">{{ Str::limit($item->description, 60) }}</div>
                        @endif
                    </td>
                    <td><span class="cat-badge">{{ $item->category->name ?? '-' }}</span></td>
                    <td class="text-center">
                        @if($item->is_active)
                            <span class="status-active"><i class="fa-solid fa-circle" style="font-size:.45rem;"></i> Aktif</span>
                        @else
                            <span class="status-inactive"><i class="fa-solid fa-circle" style="font-size:.45rem;"></i> Nonaktif</span>
                        @endif
                    </td>
                    <td class="text-center" style="padding-right:20px!important;">
                        <div class="d-flex gap-1 justify-content-center">
                            <a href="{{ route('portfolios.edit', $item->id) }}"
                               class="btn btn-sm btn-outline-primary btn-act" title="Edit">
                                <i class="fa-solid fa-pen" style="font-size:.72rem;"></i>
                            </a>
                            <form id="delete-form-{{ $item->id }}" action="{{ route('portfolios.destroy', $item->id) }}" method="POST">
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
                    <td colspan="6">
                        <div class="empty-state">
                            <i class="fa-solid fa-images"></i>
                            Belum ada portofolio. <a href="{{ route('portfolios.create') }}" style="color:#2563EB;font-weight:600;">Tambah sekarang →</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ── Image Preview Modal ── --}}
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="image-modal-title"></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="image-modal-src" src="" alt="">
            </div>
        </div>
    </div>
</div>

@endsection

@section('custom-js')
<script>
function showImage(src, title) {
    document.getElementById('image-modal-src').src = src;
    document.getElementById('image-modal-title').textContent = title;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}
</script>
@endsection