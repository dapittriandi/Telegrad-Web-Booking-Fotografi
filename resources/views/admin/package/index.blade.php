@extends('base.base-admin-index')

@php
    $menu    = 'Paket';
    $submenu = 'Paket Foto';
    $subdesc = 'Kelola semua paket foto yang tersedia';
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
    color: var(--tg-text-3); margin-bottom: 10px; display: block;
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
    position: relative; overflow: hidden;
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
.stat-card-num.sm { font-size: 1.2rem; }
.stat-card-lbl {
    font-size: .65rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .08em; color: var(--tg-text-3);
}
.stat-card-accent {
    position: absolute; bottom: 0; left: 0; right: 0;
    height: 3px; border-radius: 0 0 14px 14px;
}

/* =============================================================
   PANEL CARD
   ============================================================= */
.panel-card {
    background: var(--tg-glass);
    backdrop-filter: var(--tg-blur);
    border: 1px solid var(--tg-glass-border);
    border-radius: 14px; overflow: hidden;
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

/* =============================================================
   BUTTONS
   ============================================================= */
.tg-btn {
    border-radius: 9px; font-weight: 700; font-size: .82rem;
    padding: 8px 15px; border: 1px solid transparent; cursor: pointer;
    transition: all .15s; display: inline-flex; align-items: center; gap: 6px;
    line-height: 1; white-space: nowrap; text-decoration: none;
}
.tg-btn .bi { font-size: .8rem !important; }
.tg-btn-primary { background: #2563EB; color: #fff; border-color: #2563EB; }
.tg-btn-primary:hover { background: #1D4ED8; border-color: #1D4ED8; color: #fff; }
.tg-btn-sm { padding: 5px 11px; font-size: .75rem; border-radius: 8px; }
.tg-btn-ghost-edit   { background: rgba(37,99,235,.08);  color: #2563EB; border-color: rgba(37,99,235,.2); }
.tg-btn-ghost-edit:hover   { background: rgba(37,99,235,.15); color: #2563EB; }
.tg-btn-ghost-danger { background: rgba(220,38,38,.07);  color: #DC2626; border-color: rgba(220,38,38,.18); }
.tg-btn-ghost-danger:hover { background: rgba(220,38,38,.14); color: #DC2626; }

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
   BADGES & TAGS
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
.tg-badge-cat {
    background: rgba(37,99,235,.1); color: #2563EB;
    font-size: .67rem; font-weight: 700;
    padding: 3px 9px; border-radius: 100px;
    display: inline-flex; align-items: center; gap: 4px;
    white-space: nowrap; line-height: 1.3;
}
.tg-badge-cat .bi { font-size: .65rem !important; }

[data-theme="dark"] .tg-badge-active   { background: rgba(209,250,229,.12); color: #6EE7B7; }
[data-theme="dark"] .tg-badge-inactive { background: rgba(255,255,255,.07); color: #9CA3AF; }
[data-theme="dark"] .tg-badge-cat      { background: rgba(37,99,235,.18); color: #93C5FD; }

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
   ALERT
   ============================================================= */
.tg-alert {
    border-radius: 10px; padding: 11px 15px; font-size: .84rem;
    margin-bottom: 18px; display: flex; align-items: center; gap: 9px; font-weight: 500;
}
.tg-alert .bi { font-size: .95rem !important; flex-shrink: 0; }
.tg-alert-success { background: #D1FAE5; color: #065F46; border: 1px solid #6EE7B7; }
.tg-alert-danger  { background: #FEE2E2; color: #991B1B; border: 1px solid #FCA5A5; }
</style>
@endsection

@section('content')

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
<span class="section-label">Statistik Paket</span>
<div class="stat-grid">

    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon" style="background:rgba(37,99,235,.12);">
                <i class="bi bi-box-seam" style="color:#2563EB;"></i>
            </div>
        </div>
        <div class="stat-card-num" data-count="{{ $packages->count() }}">{{ $packages->count() }}</div>
        <div class="stat-card-lbl">Total Paket</div>
        <div class="stat-card-accent" style="background:#3B82F6;"></div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon" style="background:rgba(5,150,105,.12);">
                <i class="bi bi-check-circle" style="color:#059669;"></i>
            </div>
        </div>
        <div class="stat-card-num" data-count="{{ $packages->where('is_active', true)->count() }}">{{ $packages->where('is_active', true)->count() }}</div>
        <div class="stat-card-lbl">Paket Aktif</div>
        <div class="stat-card-accent" style="background:#10B981;"></div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon" style="background:rgba(107,114,128,.1);">
                <i class="bi bi-dash-circle" style="color:#6B7280;"></i>
            </div>
        </div>
        <div class="stat-card-num" data-count="{{ $packages->where('is_active', false)->count() }}">{{ $packages->where('is_active', false)->count() }}</div>
        <div class="stat-card-lbl">Non-aktif</div>
        <div class="stat-card-accent" style="background:#9CA3AF;"></div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon" style="background:rgba(217,119,6,.12);">
                <i class="bi bi-tag" style="color:#D97706;"></i>
            </div>
        </div>
        <div class="stat-card-num sm">Rp {{ number_format($packages->min('price') ?? 0, 0, ',', '.') }}</div>
        <div class="stat-card-lbl">Harga Terendah</div>
        <div class="stat-card-accent" style="background:#F59E0B;"></div>
    </div>

</div>

{{-- ══════════════════════════════════════════
     TABLE
═══════════════════════════════════════════ --}}
<span class="section-label">Daftar Paket</span>
<div class="panel-card">
    <div class="panel-head">
        <h6><i class="bi bi-camera"></i> Paket Foto</h6>
        <a href="{{ route('packages.create') }}" class="tg-btn tg-btn-primary" style="font-size:.78rem; padding:6px 14px;">
            <i class="bi bi-plus-lg"></i> Tambah Paket
        </a>
    </div>
    <div style="overflow-x:auto;">
        <table class="dash-table">
            <thead>
                <tr>
                    <th style="padding-left:20px !important; width:36px;">#</th>
                    <th style="min-width:180px;">Nama Paket</th>
                    <th style="min-width:110px;">Kategori</th>
                    <th style="min-width:120px;">Harga</th>
                    <th style="min-width:80px;">Durasi</th>
                    <th style="min-width:130px;">Peserta</th>
                    <th style="text-align:center; min-width:90px;">Status</th>
                    <th style="text-align:center; padding-right:20px !important; min-width:90px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($packages as $item)
                <tr>
                    <td style="padding-left:20px !important;">
                        <span style="font-size:.68rem; font-weight:700; color:var(--tg-text-3);">
                            {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                        </span>
                    </td>
                    <td>
                        <div style="font-weight:700; font-size:.84rem; line-height:1.3; color:var(--tg-text);">{{ $item->name }}</div>
                        @if($item->features)
                        <div style="font-size:.72rem; color:var(--tg-text-3); margin-top:2px; line-height:1.3;">
                            {{ Str::limit(explode("\n", $item->features)[0] ?? '', 40) }}
                        </div>
                        @endif
                    </td>
                    <td>
                        <span class="tg-badge-cat">
                            <i class="bi bi-folder2"></i>
                            {{ $item->category->name ?? '-' }}
                        </span>
                    </td>
                    <td>
                        <span style="font-weight:700; font-size:.84rem; white-space:nowrap;">
                            Rp {{ number_format($item->price, 0, ',', '.') }}
                        </span>
                    </td>
                    <td>
                        <span style="font-size:.82rem; color:var(--tg-text-2);">{{ $item->duration }} mnt</span>
                    </td>
                    <td>
                        <span style="font-size:.78rem; color:var(--tg-text-3);">{{ Str::limit($item->participants ?? '-', 30) }}</span>
                    </td>
                    <td style="text-align:center;">
                        <span class="tg-badge {{ $item->is_active ? 'tg-badge-active' : 'tg-badge-inactive' }}">
                            <i class="bi {{ $item->is_active ? 'bi-check-circle' : 'bi-dash-circle' }}"></i>
                            {{ $item->is_active ? 'Aktif' : 'Non-aktif' }}
                        </span>
                    </td>
                    <td style="text-align:center; padding-right:20px !important;">
                        <div style="display:flex; gap:6px; justify-content:center;">
                            <a href="{{ route('packages.edit', $item->id) }}"
                               class="tg-btn tg-btn-sm tg-btn-ghost-edit" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form id="delete-form-{{ $item->id }}"
                                  action="{{ route('packages.destroy', $item->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="button"
                                        class="tg-btn tg-btn-sm tg-btn-ghost-danger"
                                        onclick="deleteData('{{ $item->id }}')" title="Hapus">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <i class="bi bi-box-seam"></i>
                            Belum ada paket tersedia
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('custom-js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.stat-card-num[data-count]').forEach(function (el) {
        var target = parseInt(el.getAttribute('data-count'));
        if (isNaN(target) || target === 0) return;
        var start = 0, step = Math.max(1, Math.ceil(target / 40));
        var timer = setInterval(function () {
            start = Math.min(start + step, target);
            el.textContent = start.toLocaleString('id-ID');
            if (start >= target) clearInterval(timer);
        }, 18);
    });
});

function deleteData(id) {
    if (confirm('Yakin hapus paket ini?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endsection