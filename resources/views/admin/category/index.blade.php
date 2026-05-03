@extends('base.base-admin-index')

@php
    $menu    = 'Kategori';
    $submenu = 'Kategori';
    $subdesc = 'Kelola kategori paket foto';
@endphp

@section('custom-css')
<style>
/* =========================================================
   RESET & BASE
   ========================================================= */
.bi {
    font-family: "bootstrap-icons" !important;
    line-height: 1 !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    vertical-align: middle !important;
}

/* =========================================================
   SECTION LABEL
   ========================================================= */
.section-label {
    font-size: .60rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .14em;
    color: var(--tg-text-3);
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.section-label::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--tg-border);
    opacity: .5;
}

/* =========================================================
   ALERT — auto-dismiss
   ========================================================= */
.tg-alert {
    border-radius: 12px;
    padding: 12px 16px;
    font-size: .84rem;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 500;
    border: 1px solid transparent;
    animation: alertSlide .35s ease both;
    position: relative;
    overflow: hidden;
}
.tg-alert::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 4px;
    border-radius: 12px 0 0 12px;
}
.tg-alert .bi { font-size: .95rem !important; flex-shrink: 0; }
.tg-alert-close {
    margin-left: auto;
    background: none;
    border: none;
    cursor: pointer;
    opacity: .5;
    font-size: .9rem;
    padding: 0;
    color: inherit;
    transition: opacity .15s;
}
.tg-alert-close:hover { opacity: 1; }
.tg-alert-success { background: #D1FAE5; color: #065F46; border-color: #A7F3D0; }
.tg-alert-success::before { background: #10B981; }
.tg-alert-danger  { background: #FEE2E2; color: #991B1B; border-color: #FECACA; }
.tg-alert-danger::before  { background: #EF4444; }
[data-theme="dark"] .tg-alert-success { background: rgba(16,185,129,.1); color: #6EE7B7; border-color: rgba(16,185,129,.25); }
[data-theme="dark"] .tg-alert-danger  { background: rgba(239,68,68,.1);  color: #FCA5A5; border-color: rgba(239,68,68,.25); }

@keyframes alertSlide {
    from { opacity: 0; transform: translateY(-6px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* =========================================================
   STAT GRID
   ========================================================= */
.stat-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 28px;
}
@media (max-width: 900px) { .stat-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 480px) { .stat-grid { grid-template-columns: 1fr 1fr; } }

.stat-card {
    background: var(--tg-glass);
    backdrop-filter: var(--tg-blur);
    border: 1px solid var(--tg-glass-border);
    border-radius: 16px;
    box-shadow: var(--tg-sh-sm);
    padding: 18px 18px 14px;
    position: relative;
    overflow: hidden;
    transition: transform .22s cubic-bezier(.34,1.56,.64,1), box-shadow .22s ease;
    cursor: default;
}
.stat-card:hover {
    transform: translateY(-4px) scale(1.01);
    box-shadow: 0 12px 32px rgba(0,0,0,.12);
}
/* Decorative blob */
.stat-card::after {
    content: '';
    position: absolute;
    top: -20px; right: -20px;
    width: 80px; height: 80px;
    border-radius: 50%;
    opacity: .06;
    background: var(--sc-color, #2563EB);
    transition: transform .3s ease;
}
.stat-card:hover::after { transform: scale(1.4); }

.stat-card-icon {
    width: 42px; height: 42px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; margin-bottom: 14px;
    transition: transform .2s ease;
}
.stat-card:hover .stat-card-icon { transform: rotate(-6deg) scale(1.1); }
.stat-card-icon .bi { font-size: 1.05rem !important; }

.stat-card-num {
    font-size: 1.9rem; font-weight: 900; line-height: 1;
    color: var(--tg-text); margin-bottom: 4px; letter-spacing: -.04em;
    font-variant-numeric: tabular-nums;
}
.stat-card-lbl {
    font-size: .63rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .09em; color: var(--tg-text-3);
}
.stat-card-accent {
    position: absolute; bottom: 0; left: 0; right: 0;
    height: 3px; border-radius: 0 0 16px 16px;
    background: var(--sc-color, #2563EB);
}

/* =========================================================
   LAYOUT 2 COL
   ========================================================= */
.cat-layout {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 20px;
    align-items: start;
}
@media (max-width: 900px) { .cat-layout { grid-template-columns: 1fr; } }

/* =========================================================
   PANEL CARD
   ========================================================= */
.panel-card {
    background: var(--tg-glass);
    backdrop-filter: var(--tg-blur);
    border: 1px solid var(--tg-glass-border);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: var(--tg-sh-sm);
}
.panel-head {
    background: linear-gradient(135deg, #0A1628 0%, #1a3275 50%, #1E3A8A 100%);
    padding: 14px 18px;
    display: flex; align-items: center; justify-content: space-between;
    gap: 10px; flex-wrap: wrap;
}
.panel-head h6 {
    color: #fff; font-size: .88rem; font-weight: 700; margin: 0;
    display: flex; align-items: center; gap: 8px; line-height: 1;
}
.panel-head h6 .bi { font-size: .85rem !important; opacity: .85; }
.panel-head-meta {
    font-size: .72rem; font-weight: 700; color: rgba(255,255,255,.7);
    background: rgba(255,255,255,.1); padding: 3px 12px;
    border-radius: 100px; border: 1px solid rgba(255,255,255,.18);
    backdrop-filter: blur(8px);
}
.panel-body { padding: 18px; }

/* =========================================================
   FORM FIELDS
   ========================================================= */
.field-label {
    font-size: .76rem; font-weight: 700; color: var(--tg-text-2);
    margin-bottom: 6px; display: flex; align-items: center; gap: 4px;
}
.field-label .required { color: #EF4444; }
.field-label .optional {
    font-size: .65rem; font-weight: 500;
    color: var(--tg-text-3);
    background: var(--tg-glass);
    border: 1px solid var(--tg-border);
    padding: 1px 7px; border-radius: 100px;
}

.tg-input {
    background: var(--tg-bg-2, rgba(255,255,255,.05));
    border: 1.5px solid var(--tg-border);
    border-radius: 10px;
    padding: 9px 13px;
    font-size: .84rem;
    width: 100%;
    color: var(--tg-text);
    transition: border-color .15s, box-shadow .15s, background .15s;
}
.tg-input:focus {
    border-color: #3B82F6;
    box-shadow: 0 0 0 3.5px rgba(59,130,246,.14);
    outline: none;
    background: var(--tg-glass);
}
.tg-input.is-invalid {
    border-color: #EF4444;
    box-shadow: 0 0 0 3px rgba(239,68,68,.1);
}
.tg-input::placeholder { color: var(--tg-text-3); opacity: .7; }
textarea.tg-input { resize: vertical; min-height: 78px; line-height: 1.55; }

.invalid-feedback { font-size: .73rem; color: #EF4444; margin-top: 5px; display: flex; align-items: center; gap: 4px; }
.invalid-feedback::before { content: '⚠'; font-size: .7rem; }

/* Slug preview */
.slug-preview-wrap {
    background: var(--tg-bg-2, rgba(255,255,255,.04));
    border: 1.5px solid var(--tg-border);
    border-radius: 10px;
    padding: 8px 13px;
    font-size: .78rem;
    color: var(--tg-text-3);
    font-family: 'JetBrains Mono', 'Courier New', monospace;
    min-height: 36px;
    display: flex; align-items: center; gap: 6px;
}
.slug-prefix { opacity: .45; }
.slug-value { color: #3B82F6; font-weight: 600; }

/* Toggle switch */
.tg-toggle-wrap {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 13px;
    background: var(--tg-glass);
    border: 1.5px solid var(--tg-border);
    border-radius: 10px;
    transition: border-color .15s;
}
.tg-toggle-wrap:focus-within { border-color: #3B82F6; }
.tg-toggle-wrap label { font-size: .83rem; color: var(--tg-text-2); cursor: pointer; margin: 0; user-select: none; }
.form-check-input { width: 18px !important; height: 18px !important; cursor: pointer; flex-shrink: 0; }

/* =========================================================
   DIVIDER
   ========================================================= */
.tg-divider { height: 1px; background: var(--tg-border); margin: 16px 0; opacity: .5; }

/* =========================================================
   BUTTONS
   ========================================================= */
.tg-btn {
    border-radius: 10px; font-weight: 700; font-size: .81rem;
    padding: 9px 16px; border: 1.5px solid transparent; cursor: pointer;
    transition: all .15s cubic-bezier(.4,0,.2,1);
    display: inline-flex; align-items: center; gap: 6px;
    line-height: 1; white-space: nowrap;
    position: relative; overflow: hidden;
}
.tg-btn::after {
    content: '';
    position: absolute; inset: 0;
    background: rgba(255,255,255,0);
    transition: background .15s;
}
.tg-btn:hover::after { background: rgba(255,255,255,.06); }
.tg-btn:active { transform: scale(.97); }
.tg-btn .bi { font-size: .78rem !important; }

.tg-btn-primary {
    background: linear-gradient(135deg, #2563EB, #1D4ED8);
    color: #fff; border-color: #2563EB;
    box-shadow: 0 2px 8px rgba(37,99,235,.3);
}
.tg-btn-primary:hover {
    background: linear-gradient(135deg, #1D4ED8, #1e40af);
    box-shadow: 0 4px 14px rgba(37,99,235,.4);
    color: #fff;
}
.tg-btn-w100 { width: 100%; justify-content: center; }
.tg-btn-sm { padding: 5px 11px; font-size: .74rem; border-radius: 8px; gap: 5px; }
.tg-btn-sm .bi { font-size: .72rem !important; }

.tg-btn-ghost {
    background: transparent;
    color: var(--tg-text-2);
    border-color: var(--tg-border);
}
.tg-btn-ghost:hover { background: var(--tg-glass); }

.tg-btn-ghost-edit    { background: rgba(59,130,246,.08); color: #3B82F6; border-color: rgba(59,130,246,.22); }
.tg-btn-ghost-edit:hover    { background: rgba(59,130,246,.16); }
.tg-btn-ghost-toggle-off { background: rgba(245,158,11,.08); color: #D97706; border-color: rgba(245,158,11,.22); }
.tg-btn-ghost-toggle-off:hover { background: rgba(245,158,11,.16); }
.tg-btn-ghost-toggle-on  { background: rgba(16,185,129,.08); color: #059669; border-color: rgba(16,185,129,.22); }
.tg-btn-ghost-toggle-on:hover  { background: rgba(16,185,129,.16); }
.tg-btn-ghost-danger  { background: rgba(239,68,68,.07); color: #DC2626; border-color: rgba(239,68,68,.2); }
.tg-btn-ghost-danger:hover  { background: rgba(239,68,68,.14); }

/* =========================================================
   TABLE
   ========================================================= */
.dash-table { width: 100%; border-collapse: collapse; }
.dash-table thead th {
    font-size: .64rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: var(--tg-text-3);
    background: var(--tg-glass);
    border-bottom: 1.5px solid var(--tg-border);
    padding: 10px 14px;
    white-space: nowrap;
    vertical-align: middle;
}
.dash-table tbody td {
    padding: 12px 14px;
    vertical-align: middle;
    font-size: .83rem;
    border-bottom: 1px solid var(--tg-border);
    color: var(--tg-text);
    transition: background .12s;
}
.dash-table tbody tr:last-child td { border-bottom: none; }
.dash-table tbody tr { transition: background .12s; }
.dash-table tbody tr:hover td { background: rgba(59,130,246,.04); }

/* Row number */
.row-num {
    display: inline-flex; align-items: center; justify-content: center;
    width: 24px; height: 24px; border-radius: 7px;
    font-size: .66rem; font-weight: 800;
    background: var(--tg-glass); border: 1px solid var(--tg-border);
    color: var(--tg-text-3);
}

/* Category name cell */
.cat-name-cell { font-weight: 700; display: flex; align-items: center; gap: 8px; }
.cat-dot {
    width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0;
    background: #3B82F6;
}

/* =========================================================
   BADGES
   ========================================================= */
.tg-badge {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: .66rem; font-weight: 700;
    padding: 3.5px 10px; border-radius: 100px;
    white-space: nowrap; line-height: 1.3;
    border: 1px solid transparent;
}
.tg-badge .bi { font-size: .62rem !important; }
.tg-badge-active   { background: #ECFDF5; color: #065F46; border-color: #A7F3D0; }
.tg-badge-inactive { background: #F9FAFB; color: #6B7280; border-color: #E5E7EB; }
[data-theme="dark"] .tg-badge-active   { background: rgba(16,185,129,.1); color: #6EE7B7; border-color: rgba(16,185,129,.25); }
[data-theme="dark"] .tg-badge-inactive { background: rgba(255,255,255,.05); color: #9CA3AF; border-color: rgba(255,255,255,.1); }

/* Slug tag */
.slug-tag {
    background: var(--tg-glass);
    border: 1px solid var(--tg-border);
    padding: 2px 9px; border-radius: 6px;
    font-size: .71rem; color: var(--tg-text-3);
    font-family: 'JetBrains Mono', 'Courier New', monospace;
}

/* Description truncate */
.desc-cell { color: var(--tg-text-3); font-size: .78rem; max-width: 180px; }

/* Action group */
.action-group { display: flex; gap: 5px; justify-content: center; }

/* =========================================================
   EMPTY STATE
   ========================================================= */
.empty-state {
    text-align: center;
    padding: 56px 20px;
    color: var(--tg-text-3);
}
.empty-state-icon {
    font-size: 2.4rem !important;
    opacity: .15;
    display: block;
    margin-bottom: 12px;
}
.empty-state-text { font-size: .88rem; font-weight: 600; margin-bottom: 4px; }
.empty-state-sub  { font-size: .78rem; opacity: .6; }

/* =========================================================
   MODAL
   ========================================================= */
.modal { z-index: 1055 !important; }
.modal-backdrop { z-index: 1054 !important; }
.modal-dialog { pointer-events: auto !important; }
.modal-content {
    border: none !important;
    border-radius: 16px !important;
    pointer-events: auto !important;
    background: var(--tg-glass) !important;
    backdrop-filter: blur(24px) !important;
    border: 1px solid var(--tg-glass-border) !important;
    box-shadow: 0 24px 64px rgba(0,0,0,.22) !important;
    overflow: hidden;
}
.modal-header {
    background: linear-gradient(135deg, #0A1628 0%, #1a3275 50%, #1E3A8A 100%) !important;
    border-bottom: none !important;
    padding: 16px 20px !important;
    border-radius: 0 !important;
}
.modal-header .modal-title {
    font-size: .88rem; font-weight: 700; color: #fff;
    display: flex; align-items: center; gap: 8px;
}
.modal-header .modal-title .bi { font-size: .85rem !important; opacity: .8; }
.modal-header .btn-close { filter: invert(1) brightness(2); opacity: .6; }
.modal-header .btn-close:hover { opacity: 1; }
.modal-body   { padding: 20px !important; }
.modal-footer {
    border-top: 1px solid var(--tg-border) !important;
    padding: 12px 20px !important;
    display: flex; justify-content: flex-end; gap: 8px;
}
.modal-body input,
.modal-body textarea,
.modal-body select,
.modal-body .form-check-input { pointer-events: auto !important; position: relative; z-index: 2; }

/* Slug disabled field */
.slug-disabled-wrap {
    background: var(--tg-bg-2, rgba(255,255,255,.04));
    border: 1.5px solid var(--tg-border);
    border-radius: 10px;
    padding: 8px 13px;
    font-size: .78rem;
    color: var(--tg-text-3);
    font-family: 'JetBrains Mono', 'Courier New', monospace;
    opacity: .6;
}
.slug-hint { font-size: .70rem; color: var(--tg-text-3); margin-top: 5px; display: flex; align-items: center; gap: 5px; }
.slug-hint .bi { font-size: .65rem !important; }

/* =========================================================
   ANIMATIONS
   ========================================================= */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
}
.stat-card { animation: fadeUp .4s ease both; }
.stat-card:nth-child(1) { animation-delay: .05s; }
.stat-card:nth-child(2) { animation-delay: .10s; }
.stat-card:nth-child(3) { animation-delay: .15s; }
.stat-card:nth-child(4) { animation-delay: .20s; }
</style>
@endsection

@section('content')

{{-- ── Alerts ── --}}
@if(session('success'))
<div class="tg-alert tg-alert-success" id="tg-alert-success">
    <i class="bi bi-check-circle-fill"></i>
    <span>{{ session('success') }}</span>
    <button class="tg-alert-close" onclick="this.parentElement.remove()"><i class="bi bi-x-lg"></i></button>
</div>
@endif
@if(session('error'))
<div class="tg-alert tg-alert-danger" id="tg-alert-error">
    <i class="bi bi-exclamation-triangle-fill"></i>
    <span>{{ session('error') }}</span>
    <button class="tg-alert-close" onclick="this.parentElement.remove()"><i class="bi bi-x-lg"></i></button>
</div>
@endif

{{-- ══════════════════════════════════
     STAT CARDS
═══════════════════════════════════ --}}
<span class="section-label">Ringkasan</span>
<div class="stat-grid">

    <div class="stat-card" style="--sc-color:#3B82F6;">
        <div class="stat-card-icon" style="background:rgba(59,130,246,.12);">
            <i class="bi bi-folder2-open" style="color:#3B82F6;"></i>
        </div>
        <div class="stat-card-num" data-count="{{ $categories->count() }}">0</div>
        <div class="stat-card-lbl">Total Kategori</div>
        <div class="stat-card-accent"></div>
    </div>

    <div class="stat-card" style="--sc-color:#10B981;">
        <div class="stat-card-icon" style="background:rgba(16,185,129,.12);">
            <i class="bi bi-check-circle" style="color:#10B981;"></i>
        </div>
        <div class="stat-card-num" data-count="{{ $categories->where('is_active', 1)->count() }}">0</div>
        <div class="stat-card-lbl">Kategori Aktif</div>
        <div class="stat-card-accent"></div>
    </div>

    <div class="stat-card" style="--sc-color:#F59E0B;">
        <div class="stat-card-icon" style="background:rgba(245,158,11,.12);">
            <i class="bi bi-box-seam" style="color:#F59E0B;"></i>
        </div>
        <div class="stat-card-num" data-count="{{ \App\Models\Package::count() }}">0</div>
        <div class="stat-card-lbl">Total Paket</div>
        <div class="stat-card-accent"></div>
    </div>

    <div class="stat-card" style="--sc-color:#8B5CF6;">
        <div class="stat-card-icon" style="background:rgba(139,92,246,.12);">
            <i class="bi bi-images" style="color:#8B5CF6;"></i>
        </div>
        <div class="stat-card-num" data-count="{{ \App\Models\Portofolio::count() }}">0</div>
        <div class="stat-card-lbl">Portofolio</div>
        <div class="stat-card-accent"></div>
    </div>

</div>

{{-- ══════════════════════════════════
     MAIN LAYOUT
═══════════════════════════════════ --}}
<div class="cat-layout">

    {{-- ── Kiri: Form Tambah ── --}}
    <div>
        <span class="section-label">Tambah Kategori</span>
        <div class="panel-card">
            <div class="panel-head">
                <h6><i class="bi bi-folder-plus"></i> Kategori Baru</h6>
            </div>
            <div class="panel-body">
                <form action="{{ route('categories.store') }}" method="POST" id="formAddCategory">
                    @csrf

                    <div class="mb-3">
                        <label class="field-label">
                            Nama Kategori <span class="required">*</span>
                        </label>
                        <input type="text" name="name" id="inputName"
                               class="tg-input @error('name') is-invalid @enderror"
                               placeholder="Contoh: Wisuda, Prewedding…"
                               value="{{ old('name') }}" autocomplete="off">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="field-label">
                            Slug <span class="optional">otomatis</span>
                        </label>
                        <div class="slug-preview-wrap">
                            <span class="slug-prefix">slug/</span>
                            <span class="slug-value" id="slugPreview">…</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="field-label">
                            Deskripsi <span class="optional">opsional</span>
                        </label>
                        <textarea name="description"
                                  class="tg-input @error('description') is-invalid @enderror"
                                  placeholder="Deskripsi singkat kategori…">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
                            <th style="padding-left:18px; width:44px;">#</th>
                            <th style="min-width:130px;">Nama</th>
                            <th style="min-width:110px;">Slug</th>
                            <th style="min-width:150px;">Deskripsi</th>
                            <th style="text-align:center; min-width:90px;">Status</th>
                            <th style="text-align:center; padding-right:18px; min-width:110px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $key => $item)
                        <tr>
                            <td style="padding-left:18px;">
                                <span class="row-num">{{ str_pad(++$key, 2, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td>
                                <div class="cat-name-cell">
                                    <span class="cat-dot" style="background:{{ $item->is_active ? '#10B981' : '#9CA3AF' }};"></span>
                                    {{ $item->name }}
                                </div>
                            </td>
                            <td><span class="slug-tag">{{ $item->slug }}</span></td>
                            <td>
                                <span class="desc-cell" title="{{ $item->description }}">
                                    {{ $item->description ? Str::limit($item->description, 38) : '—' }}
                                </span>
                            </td>
                            <td style="text-align:center;">
                                <span class="tg-badge {{ $item->is_active ? 'tg-badge-active' : 'tg-badge-inactive' }}">
                                    <i class="bi {{ $item->is_active ? 'bi-check-circle' : 'bi-dash-circle' }}"></i>
                                    {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td style="text-align:center; padding-right:18px;">
                                <div class="action-group">

                                    {{-- Edit --}}
                                    <button class="tg-btn tg-btn-sm tg-btn-ghost-edit"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $item->id }}"
                                            title="Edit Kategori">
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
                                        <button type="submit" class="tg-btn tg-btn-sm tg-btn-ghost-danger" title="Hapus Kategori">
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
                                    <i class="bi bi-folder2-open empty-state-icon"></i>
                                    <div class="empty-state-text">Belum ada kategori</div>
                                    <div class="empty-state-sub">Tambahkan kategori pertama menggunakan form di sebelah kiri</div>
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


{{-- ══════════════════════════════════
     MODAL EDIT
═══════════════════════════════════ --}}
@foreach($categories as $item)
<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:460px;">
        <div class="modal-content">
            <form action="{{ route('categories.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil-square"></i> Edit Kategori
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="field-label">Nama Kategori <span class="required">*</span></label>
                        <input type="text" name="name" class="tg-input"
                               value="{{ $item->name }}" required autocomplete="off">
                    </div>

                    <div class="mb-3">
                        <label class="field-label">Slug <span class="optional">otomatis</span></label>
                        <div class="slug-disabled-wrap">{{ $item->slug }}</div>
                        <p class="slug-hint">
                            <i class="bi bi-info-circle"></i>
                            Slug diperbarui otomatis saat nama diubah
                        </p>
                    </div>

                    <div class="mb-3">
                        <label class="field-label">Deskripsi <span class="optional">opsional</span></label>
                        <textarea name="description" class="tg-input" rows="3">{{ $item->description }}</textarea>
                    </div>

                    <div class="tg-toggle-wrap">
                        <input type="hidden" name="is_active" value="0">
                        <input class="form-check-input" type="checkbox" name="is_active"
                               id="is_active_{{ $item->id }}" value="1"
                               {{ $item->is_active ? 'checked' : '' }}>
                        <label for="is_active_{{ $item->id }}">Tampilkan kategori (Aktif)</label>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="tg-btn tg-btn-ghost tg-btn-sm" data-bs-dismiss="modal">
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

    /* ── Pindah modal ke body ── */
    document.querySelectorAll('[id^="editModal"]').forEach(function(modal) {
        document.body.appendChild(modal);
        modal.addEventListener('hidden.bs.modal', function () {
            document.body.classList.remove('modal-open');
            var backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove();
        });
    });

    /* ── Counter animasi stat cards ── */
    document.querySelectorAll('.stat-card-num[data-count]').forEach(function (el) {
        var target = parseInt(el.getAttribute('data-count'));
        if (isNaN(target)) return;
        if (target === 0) { el.textContent = '0'; return; }
        var start = 0;
        var duration = 600;
        var startTime = null;
        function step(ts) {
            if (!startTime) startTime = ts;
            var progress = Math.min((ts - startTime) / duration, 1);
            var eased = 1 - Math.pow(1 - progress, 3); // easeOutCubic
            el.textContent = Math.round(eased * target).toLocaleString('id-ID');
            if (progress < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    });

    /* ── Slug preview realtime ── */
    var inputName   = document.getElementById('inputName');
    var slugPreview = document.getElementById('slugPreview');
    function toSlug(str) {
        return str.toLowerCase()
                  .trim()
                  .replace(/[^a-z0-9\s-]/g, '')
                  .replace(/\s+/g, '-')
                  .replace(/-+/g, '-');
    }
    if (inputName && slugPreview) {
        function updateSlug() {
            var val = toSlug(inputName.value);
            slugPreview.textContent = val || '…';
        }
        inputName.addEventListener('input', updateSlug);
        updateSlug();
    }

    /* ── Auto dismiss alert setelah 5s ── */
    ['tg-alert-success', 'tg-alert-error'].forEach(function(id) {
        var el = document.getElementById(id);
        if (!el) return;
        setTimeout(function() {
            el.style.transition = 'opacity .4s ease, transform .4s ease';
            el.style.opacity = '0';
            el.style.transform = 'translateY(-6px)';
            setTimeout(function() { el.remove(); }, 400);
        }, 5000);
    });

});
</script>
@endsection