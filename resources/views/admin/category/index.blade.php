@extends('base.base-admin-index')

@php
    $menu    = 'Kategori';
    $submenu = 'Kategori';
    $subdesc = 'Kelola kategori paket foto';
@endphp

@section('custom-css')
<style>
/* =============================================================
   GLOBAL ICON FIX
   ============================================================= */
.bi {
    font-family: "bootstrap-icons" !important;
    line-height: 1 !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    vertical-align: middle !important;
}

/* =============================================================
   SECTION LABEL
   ============================================================= */
.section-label {
    font-size: .63rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .1em;
    color: var(--tg-text-3); margin-bottom: 10px;
    display: block;
}

/* =============================================================
   STAT GRID
   ============================================================= */
.stat-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}
@media (max-width: 900px) { .stat-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 480px) { .stat-grid { grid-template-columns: 1fr 1fr; } }

.stat-card {
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
.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 28px rgba(37,99,235,.13);
}
.stat-card-top {
    display: flex; align-items: flex-start;
    justify-content: space-between; margin-bottom: 14px;
}
.stat-card-icon {
    width: 44px; height: 44px; border-radius: 11px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.stat-card-icon .bi { font-size: 1.1rem !important; }
.stat-card-num {
    font-size: 1.75rem; font-weight: 800; line-height: 1;
    color: var(--tg-text); margin-bottom: 5px; letter-spacing: -.03em;
}
.stat-card-lbl {
    font-size: .65rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .08em; color: var(--tg-text-3);
}
.stat-card-accent {
    position: absolute; bottom: 0; left: 0; right: 0;
    height: 3px; border-radius: 0 0 14px 14px;
}

/* =============================================================
   LAYOUT 2 COL
   ============================================================= */
.cat-layout {
    display: grid;
    grid-template-columns: 320px 1fr;
    gap: 20px;
    align-items: start;
}
@media (max-width: 900px) { .cat-layout { grid-template-columns: 1fr; } }

/* =============================================================
   PANEL CARD (form + table)
   ============================================================= */
.panel-card {
    background: var(--tg-glass);
    backdrop-filter: var(--tg-blur);
    border: 1px solid var(--tg-glass-border);
    border-radius: 14px;
    overflow: hidden;
    box-shadow: var(--tg-sh-sm);
}
.panel-head {
    background: linear-gradient(135deg, #0A1628, #1E3A8A);
    padding: 14px 20px;
    display: flex; align-items: center; justify-content: space-between;
    gap: 10px; flex-wrap: wrap;
}
.panel-head h6 {
    color: #fff; font-size: .92rem; font-weight: 700; margin: 0;
    display: flex; align-items: center; gap: 8px; line-height: 1;
}
.panel-head h6 .bi { font-size: .9rem !important; }
.panel-head-meta {
    font-size: .74rem; font-weight: 600; color: rgba(255,255,255,.65);
    background: rgba(255,255,255,.12); padding: 4px 12px;
    border-radius: 100px; border: 1px solid rgba(255,255,255,.2);
}
.panel-body { padding: 20px; }

/* =============================================================
   FORM FIELDS
   ============================================================= */
.field-label {
    font-size: .78rem; font-weight: 700; color: var(--tg-text-2);
    margin-bottom: 6px; display: block;
}
.field-label span { color: #EF4444; }

.tg-input {
    background: var(--tg-bg-2, rgba(255,255,255,.06));
    border: 1px solid var(--tg-border);
    border-radius: 9px;
    padding: 9px 13px;
    font-size: .84rem;
    width: 100%;
    color: var(--tg-text);
    transition: border-color .15s, box-shadow .15s;
}
.tg-input:focus {
    border-color: #2563EB;
    box-shadow: 0 0 0 3px rgba(37,99,235,.12);
    outline: none;
}
.tg-input.is-invalid { border-color: #EF4444; }
.tg-input::placeholder { color: var(--tg-text-3); }
textarea.tg-input { resize: vertical; min-height: 80px; }

.invalid-feedback { font-size: .74rem; color: #EF4444; margin-top: 4px; }

/* Toggle switch */
.tg-toggle-wrap {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 13px;
    background: var(--tg-glass);
    border: 1px solid var(--tg-border);
    border-radius: 9px;
}
.tg-toggle-wrap label { font-size: .84rem; color: var(--tg-text-2); cursor: pointer; margin: 0; }
.form-check-input {
    width: 18px !important; height: 18px !important;
    cursor: pointer; flex-shrink: 0;
}

/* =============================================================
   BUTTONS
   ============================================================= */
.tg-btn {
    border-radius: 9px; font-weight: 700; font-size: .82rem;
    padding: 9px 16px; border: 1px solid transparent; cursor: pointer;
    transition: all .15s; display: inline-flex; align-items: center; gap: 6px;
    line-height: 1; white-space: nowrap;
}
.tg-btn .bi { font-size: .8rem !important; }
.tg-btn-primary { background: #2563EB; color: #fff; border-color: #2563EB; }
.tg-btn-primary:hover { background: #1D4ED8; border-color: #1D4ED8; color: #fff; }
.tg-btn-w100 { width: 100%; justify-content: center; }
.tg-btn-sm { padding: 5px 11px; font-size: .75rem; border-radius: 8px; }

.tg-btn-ghost-edit    { background: rgba(37,99,235,.08);   color: #2563EB; border-color: rgba(37,99,235,.2); }
.tg-btn-ghost-edit:hover    { background: rgba(37,99,235,.15); }
.tg-btn-ghost-toggle-off { background: rgba(217,119,6,.08); color: #D97706; border-color: rgba(217,119,6,.2); }
.tg-btn-ghost-toggle-off:hover { background: rgba(217,119,6,.15); }
.tg-btn-ghost-toggle-on  { background: rgba(5,150,105,.08); color: #059669; border-color: rgba(5,150,105,.2); }
.tg-btn-ghost-toggle-on:hover  { background: rgba(5,150,105,.15); }
.tg-btn-ghost-danger  { background: rgba(220,38,38,.07);   color: #DC2626; border-color: rgba(220,38,38,.18); }
.tg-btn-ghost-danger:hover  { background: rgba(220,38,38,.14); }

/* =============================================================
   TABLE
   ============================================================= */
.dash-table { width: 100%; border-collapse: collapse; }
.dash-table thead th {
    font-size: .66rem !important; font-weight: 700 !important;
    text-transform: uppercase !important; letter-spacing: .07em !important;
    color: var(--tg-text-3) !important; background: var(--tg-glass) !important;
    border-bottom: 1px solid var(--tg-border) !important;
    padding: 10px 14px !important; white-space: nowrap; vertical-align: middle !important;
}
.dash-table tbody td {
    padding: 11px 14px !important; vertical-align: middle !important;
    font-size: .82rem !important; border-bottom: 1px solid var(--tg-border) !important;
    color: var(--tg-text) !important;
}
.dash-table tbody tr:last-child td { border-bottom: none !important; }
.dash-table tbody tr:hover td { background: rgba(59,130,246,.04) !important; }

/* =============================================================
   BADGES
   ============================================================= */
.tg-badge {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: .67rem; font-weight: 700;
    padding: 3px 9px; border-radius: 100px;
    white-space: nowrap; line-height: 1.3;
}
.tg-badge .bi { font-size: .65rem !important; }
.tg-badge-active   { background: #D1FAE5; color: #065F46; }
.tg-badge-inactive { background: #F3F4F6; color: #6B7280; }

[data-theme="dark"] .tg-badge-active   { background: rgba(209,250,229,.12); color: #6EE7B7; }
[data-theme="dark"] .tg-badge-inactive { background: rgba(255,255,255,.07); color: #9CA3AF; }

/* Slug tag */
.slug-tag {
    background: var(--tg-glass);
    border: 1px solid var(--tg-border);
    padding: 2px 8px; border-radius: 6px;
    font-size: .72rem; color: var(--tg-text-3); font-family: monospace;
}

/* =============================================================
   ALERT
   ============================================================= */
.tg-alert {
    border-radius: 10px; padding: 11px 15px; font-size: .84rem;
    margin-bottom: 18px; display: flex; align-items: center; gap: 9px;
    font-weight: 500;
}
.tg-alert .bi { font-size: .95rem !important; flex-shrink: 0; }
.tg-alert-success { background: #D1FAE5; color: #065F46; border: 1px solid #6EE7B7; }
.tg-alert-danger  { background: #FEE2E2; color: #991B1B; border: 1px solid #FCA5A5; }

/* =============================================================
   EMPTY STATE
   ============================================================= */
.empty-state {
    text-align: center; padding: 40px 12px;
    color: var(--tg-text-3); font-size: .84rem;
}
.empty-state .bi {
    font-size: 2rem !important; opacity: .2;
    display: block; margin-bottom: 10px;
}

/* =============================================================
   MODAL
   ============================================================= */
.modal { z-index: 1055 !important; }
.modal-backdrop { z-index: 1054 !important; }
.modal-dialog { pointer-events: auto !important; }
.modal-content {
    border: none !important;
    border-radius: 14px !important;
    pointer-events: auto !important;
    background: var(--tg-glass) !important;
    backdrop-filter: var(--tg-blur) !important;
    border: 1px solid var(--tg-glass-border) !important;
    box-shadow: 0 20px 60px rgba(0,0,0,.18) !important;
}
.modal-body input, .modal-body textarea, .modal-body select,
.modal-body .form-check-input { pointer-events: auto !important; position: relative; z-index: 2; }
.modal-header {
    background: linear-gradient(135deg, #0A1628, #1E3A8A) !important;
    border-bottom: none !important;
    padding: 15px 20px !important;
    border-radius: 14px 14px 0 0 !important;
}
.modal-header .modal-title { font-size: .9rem; font-weight: 700; color: #fff; }
.modal-header .btn-close { filter: invert(1) brightness(2); opacity: .7; }
.modal-header .btn-close:hover { opacity: 1; }
.modal-body   { padding: 20px !important; }
.modal-footer {
    border-top: 1px solid var(--tg-border) !important;
    padding: 12px 20px !important;
}

/* Divider */
.tg-divider { height: 1px; background: var(--tg-border); margin: 16px 0; }
</style>
@endsection

@section('content')

{{-- ── Alerts ── --}}
@if(session('success'))
<div class="tg-alert tg-alert-success">
    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="tg-alert tg-alert-danger">
    <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
</div>
@endif

{{-- ══════════════════════════════════════════
     STAT CARDS
═══════════════════════════════════════════ --}}
<span class="section-label">Ringkasan</span>
<div class="stat-grid">

    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon" style="background:rgba(37,99,235,.12);">
                <i class="bi bi-folder2-open" style="color:#2563EB;"></i>
            </div>
        </div>
        <div class="stat-card-num">{{ $categories->count() }}</div>
        <div class="stat-card-lbl">Total Kategori</div>
        <div class="stat-card-accent" style="background:#3B82F6;"></div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon" style="background:rgba(5,150,105,.12);">
                <i class="bi bi-check-circle" style="color:#059669;"></i>
            </div>
        </div>
        <div class="stat-card-num">{{ $categories->where('is_active', 1)->count() }}</div>
        <div class="stat-card-lbl">Kategori Aktif</div>
        <div class="stat-card-accent" style="background:#10B981;"></div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon" style="background:rgba(202,138,4,.12);">
                <i class="bi bi-box-seam" style="color:#CA8A04;"></i>
            </div>
        </div>
        <div class="stat-card-num">{{ \App\Models\Package::count() }}</div>
        <div class="stat-card-lbl">Total Paket</div>
        <div class="stat-card-accent" style="background:#FBBF24;"></div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon" style="background:rgba(124,58,237,.12);">
                <i class="bi bi-images" style="color:#7C3AED;"></i>
            </div>
        </div>
        <div class="stat-card-num">{{ \App\Models\Portofolio::count() }}</div>
        <div class="stat-card-lbl">Portofolio</div>
        <div class="stat-card-accent" style="background:#8B5CF6;"></div>
    </div>

</div>

{{-- ══════════════════════════════════════════
     MAIN LAYOUT
═══════════════════════════════════════════ --}}
<div class="cat-layout">

    {{-- ── Kiri: Form Tambah ── --}}
    <div>
        <span class="section-label">Tambah Kategori</span>
        <div class="panel-card">
            <div class="panel-head">
                <h6><i class="bi bi-folder-plus"></i> Kategori Baru</h6>
            </div>
            <div class="panel-body">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="field-label">Nama Kategori <span>*</span></label>
                        <input type="text" name="name"
                               class="tg-input @error('name') is-invalid @enderror"
                               placeholder="Contoh: Wisuda, Prewedding..."
                               value="{{ old('name') }}" autocomplete="off">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="field-label">Deskripsi</label>
                        <textarea name="description"
                                  class="tg-input @error('description') is-invalid @enderror"
                                  placeholder="Deskripsi singkat kategori...">{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="tg-divider"></div>

                    <button type="submit" class="tg-btn tg-btn-primary tg-btn-w100">
                        <i class="bi bi-plus-lg"></i> Tambah Kategori
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ── Kanan: Tabel ── --}}
    <div>
        <span class="section-label">Daftar Kategori</span>
        <div class="panel-card">
            <div class="panel-head">
                <h6><i class="bi bi-list-ul"></i> Semua Kategori</h6>
                <span class="panel-head-meta">{{ $categories->count() }} kategori</span>
            </div>
            <div style="overflow-x:auto;">
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th style="padding-left:20px !important; width:36px;">#</th>
                            <th style="min-width:130px;">Nama</th>
                            <th style="min-width:110px;">Slug</th>
                            <th style="min-width:160px;">Deskripsi</th>
                            <th style="text-align:center; min-width:90px;">Status</th>
                            <th style="text-align:center; padding-right:20px !important; min-width:110px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $key => $item)
                        <tr>
                            <td style="padding-left:20px !important;">
                                <span style="font-size:.68rem; font-weight:700; color:var(--tg-text-3);">
                                    {{ str_pad(++$key, 2, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                            <td style="font-weight:700;">{{ $item->name }}</td>
                            <td><span class="slug-tag">{{ $item->slug }}</span></td>
                            <td style="color:var(--tg-text-3); font-size:.78rem;">
                                {{ Str::limit($item->description, 40) ?? '-' }}
                            </td>
                            <td style="text-align:center;">
                                <span class="tg-badge {{ $item->is_active ? 'tg-badge-active' : 'tg-badge-inactive' }}">
                                    <i class="bi {{ $item->is_active ? 'bi-check-circle' : 'bi-dash-circle' }}"></i>
                                    {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td style="text-align:center; padding-right:20px !important;">
                                <div style="display:flex; gap:6px; justify-content:center;">

                                    {{-- Edit --}}
                                    <button class="tg-btn tg-btn-sm tg-btn-ghost-edit"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $item->id }}"
                                            title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    {{-- Toggle Status --}}
                                    <form action="{{ route('categories.toggleStatus', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit"
                                                class="tg-btn tg-btn-sm {{ $item->is_active ? 'tg-btn-ghost-toggle-off' : 'tg-btn-ghost-toggle-on' }}"
                                                title="{{ $item->is_active ? 'Nonaktifkan' : 'Aktifkan' }}"
                                                onclick="return confirm('Ubah status kategori ini?')">
                                            <i class="bi {{ $item->is_active ? 'bi-eye-slash' : 'bi-eye' }}"></i>
                                        </button>
                                    </form>

                                    {{-- Hapus --}}
                                    <form action="{{ route('categories.destroy', $item->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin hapus kategori \'{{ $item->name }}\'?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="tg-btn tg-btn-sm tg-btn-ghost-danger" title="Hapus">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="bi bi-folder2-open"></i>
                                    Belum ada kategori
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

{{-- ══════════════════════════════════════════
     MODAL EDIT (di luar loop tabel)
═══════════════════════════════════════════ --}}
@foreach($categories as $item)
<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:460px;">
        <div class="modal-content">
            <form action="{{ route('categories.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil-square" style="margin-right:7px;"></i>Edit Kategori
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="field-label">Nama Kategori <span style="color:#EF4444;">*</span></label>
                        <input type="text" name="name" class="tg-input"
                               value="{{ $item->name }}" required autocomplete="off">
                    </div>

                    <div class="mb-3">
                        <label class="field-label">Slug</label>
                        <input type="text" class="tg-input" value="{{ $item->slug }}" disabled
                               style="opacity:.5; cursor:not-allowed;">
                        <p style="font-size:.71rem; color:var(--tg-text-3); margin-top:4px;">
                            Slug diperbarui otomatis saat nama diubah
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="field-label">Deskripsi</label>
                        <textarea name="description" class="tg-input" rows="3">{{ $item->description }}</textarea>
                    </div>

                    <div class="tg-toggle-wrap">
                        <input type="hidden" name="is_active" value="0">
                        <input class="form-check-input" type="checkbox" name="is_active"
                               id="is_active_{{ $item->id }}" value="1"
                               {{ $item->is_active ? 'checked' : '' }}>
                        <label for="is_active_{{ $item->id }}">
                            Tampilkan kategori (Aktif)
                        </label>
                    </div>

                </div>

                <div class="modal-footer" style="justify-content:flex-end; gap:8px;">
                    <button type="button" class="tg-btn tg-btn-sm"
                            style="background:transparent; color:var(--tg-text-2); border-color:var(--tg-border);"
                            data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="tg-btn tg-btn-primary tg-btn-sm">
                        <i class="bi bi-save2"></i> Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endforeach

@endsection

@section('custom-js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Pindahkan semua modal edit ke body agar tidak terhalang overflow parent
    document.querySelectorAll('[id^="editModal"]').forEach(function(modal) {
        document.body.appendChild(modal);
    });

    // Bersihkan state saat modal ditutup
    document.querySelectorAll('[id^="editModal"]').forEach(function(modal) {
        modal.addEventListener('hidden.bs.modal', function () {
            document.body.classList.remove('modal-open');
            var backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove();
        });
    });

    // Counter animasi stat cards
    document.querySelectorAll('.stat-card-num[data-count]').forEach(function (el) {
        var target = parseInt(el.getAttribute('data-count'));
        if (isNaN(target) || target === 0) return;
        var start = 0;
        var step  = Math.max(1, Math.ceil(target / 40));
        var timer = setInterval(function () {
            start = Math.min(start + step, target);
            el.textContent = start.toLocaleString('id-ID');
            if (start >= target) clearInterval(timer);
        }, 18);
    });
});
</script>
@endsection