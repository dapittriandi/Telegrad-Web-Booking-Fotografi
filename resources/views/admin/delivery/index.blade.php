@extends('base.base-admin-index')

@php
    $menu    = 'Pengiriman';
    $submenu = 'Pengiriman Hasil';
    $subdesc = 'Kelola pengiriman hasil foto ke customer';
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
    gap: 16px; margin-bottom: 24px;
}
@media (max-width: 900px) { .stat-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 480px) { .stat-grid { grid-template-columns: 1fr 1fr; } }

.stat-card {
    background: var(--tg-glass);
    backdrop-filter: var(--tg-blur);
    border: 1px solid var(--tg-glass-border);
    border-radius: 14px; box-shadow: var(--tg-sh-sm);
    padding: 20px 18px 16px;
    position: relative; overflow: hidden;
    transition: transform .2s ease, box-shadow .2s ease;
}
.stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 28px rgba(37,99,235,.13); }
.stat-card-top { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 14px; }
.stat-card-icon {
    width: 44px; height: 44px; border-radius: 11px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.stat-card-icon .bi { font-size: 1.1rem !important; }
.stat-card-num { font-size: 1.75rem; font-weight: 800; line-height: 1; color: var(--tg-text); margin-bottom: 5px; letter-spacing: -.03em; }
.stat-card-lbl { font-size: .65rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--tg-text-3); }
.stat-card-accent { position: absolute; bottom: 0; left: 0; right: 0; height: 3px; border-radius: 0 0 14px 14px; }

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
.tg-badge-editing   { background: #FEF3C7; color: #92400E; }
.tg-badge-delivered { background: #DBEAFE; color: #1E40AF; }
.tg-badge-revision  { background: #FEE2E2; color: #991B1B; }
.tg-badge-completed { background: #D1FAE5; color: #065F46; }

[data-theme="dark"] .tg-badge-editing   { background: rgba(254,243,199,.15); color: #FCD34D; }
[data-theme="dark"] .tg-badge-delivered { background: rgba(219,234,254,.12); color: #93C5FD; }
[data-theme="dark"] .tg-badge-revision  { background: rgba(254,226,226,.12); color: #FCA5A5; }
[data-theme="dark"] .tg-badge-completed { background: rgba(209,250,229,.12); color: #6EE7B7; }

/* =============================================================
   MINI AVATAR
   ============================================================= */
.mini-av {
    width: 32px; height: 32px; border-radius: 9px;
    background: linear-gradient(135deg, #0A1628, #2563EB);
    color: #fff; font-size: .68rem; font-weight: 700;
    display: inline-flex; align-items: center; justify-content: center;
    flex-shrink: 0; line-height: 1;
}

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
.tg-btn-sm { padding: 5px 11px; font-size: .75rem; border-radius: 8px; }
.tg-btn-primary { background: #2563EB; color: #fff; border-color: #2563EB; }
.tg-btn-primary:hover { background: #1D4ED8; border-color: #1D4ED8; color: #fff; }
.tg-btn-ghost-add    { background: rgba(255,255,255,.12); color: rgba(255,255,255,.9); border-color: rgba(255,255,255,.25); font-size: .78rem; }
.tg-btn-ghost-add:hover    { background: rgba(255,255,255,.22); color: #fff; }
.tg-btn-ghost-edit   { background: rgba(37,99,235,.08);  color: #2563EB; border-color: rgba(37,99,235,.2); }
.tg-btn-ghost-edit:hover   { background: rgba(37,99,235,.15); color: #2563EB; }
.tg-btn-ghost-green  { background: rgba(5,150,105,.08);  color: #059669; border-color: rgba(5,150,105,.2); }
.tg-btn-ghost-green:hover  { background: rgba(5,150,105,.15); color: #059669; }
.tg-btn-ghost-danger { background: rgba(220,38,38,.07);  color: #DC2626; border-color: rgba(220,38,38,.18); }
.tg-btn-ghost-danger:hover { background: rgba(220,38,38,.14); color: #DC2626; }

/* =============================================================
   MODAL
   ============================================================= */
.modal { z-index: 1055 !important; }
.modal-backdrop { z-index: 1054 !important; }
.modal-dialog { pointer-events: auto !important; }
.modal-content {
    border: none !important; border-radius: 14px !important;
    pointer-events: auto !important;
    background: var(--tg-glass) !important;
    backdrop-filter: var(--tg-blur) !important;
    border: 1px solid var(--tg-glass-border) !important;
    box-shadow: 0 20px 60px rgba(0,0,0,.18) !important;
}
.modal-body input, .modal-body textarea, .modal-body select { pointer-events: auto !important; position: relative; z-index: 2; }
.modal-header {
    background: linear-gradient(135deg, #0A1628, #1E3A8A) !important;
    border-bottom: none !important; padding: 15px 20px !important;
    border-radius: 14px 14px 0 0 !important;
}
.modal-header .modal-title { font-size: .9rem; font-weight: 700; color: #fff; }
.modal-header .btn-close { filter: invert(1) brightness(2); opacity: .7; }
.modal-header .btn-close:hover { opacity: 1; }
.modal-body { padding: 20px !important; }
.modal-footer { border-top: 1px solid var(--tg-border) !important; padding: 12px 20px !important; justify-content: flex-end; gap: 8px; }

.tg-input {
    background: var(--tg-bg-2, rgba(255,255,255,.06));
    border: 1px solid var(--tg-border); border-radius: 9px;
    padding: 9px 13px; font-size: .84rem; width: 100%; color: var(--tg-text);
    transition: border-color .15s, box-shadow .15s;
}
.tg-input:focus { border-color: #2563EB; box-shadow: 0 0 0 3px rgba(37,99,235,.12); outline: none; }
.tg-input::placeholder { color: var(--tg-text-3); }
textarea.tg-input { resize: vertical; }
select.tg-input { cursor: pointer; }
.field-label { font-size: .78rem; font-weight: 700; color: var(--tg-text-2); margin-bottom: 6px; display: block; }

/* =============================================================
   ALERT & EMPTY
   ============================================================= */
.tg-alert {
    border-radius: 10px; padding: 11px 15px; font-size: .84rem;
    margin-bottom: 18px; display: flex; align-items: center; gap: 9px; font-weight: 500;
}
.tg-alert .bi { font-size: .95rem !important; flex-shrink: 0; }
.tg-alert-success { background: #D1FAE5; color: #065F46; border: 1px solid #6EE7B7; }
.tg-alert-danger  { background: #FEE2E2; color: #991B1B; border: 1px solid #FCA5A5; }

.empty-state { text-align: center; padding: 40px 12px; color: var(--tg-text-3); font-size: .84rem; }
.empty-state .bi { font-size: 2rem !important; opacity: .2; display: block; margin-bottom: 10px; }
</style>
@endsection

@section('content')

@php
    $total     = $deliveries->count();
    $editing   = $deliveries->where('status', 'editing')->count();
    $delivered = $deliveries->where('status', 'delivered')->count();
    $completed = $deliveries->where('status', 'completed')->count();
@endphp

@if(session('success'))
<div class="tg-alert tg-alert-success"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
@endif
@if(session('error'))
<div class="tg-alert tg-alert-danger"><i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}</div>
@endif

{{-- ══════════════════════════════════
     STAT CARDS
═══════════════════════════════════ --}}
<span class="section-label">Statistik Pengiriman</span>
<div class="stat-grid">

    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon" style="background:rgba(37,99,235,.12);">
                <i class="bi bi-send" style="color:#2563EB;"></i>
            </div>
        </div>
        <div class="stat-card-num" data-count="{{ $total }}">{{ $total }}</div>
        <div class="stat-card-lbl">Total Pengiriman</div>
        <div class="stat-card-accent" style="background:#3B82F6;"></div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon" style="background:rgba(217,119,6,.12);">
                <i class="bi bi-pencil-square" style="color:#D97706;"></i>
            </div>
        </div>
        <div class="stat-card-num" data-count="{{ $editing }}">{{ $editing }}</div>
        <div class="stat-card-lbl">Sedang Editing</div>
        <div class="stat-card-accent" style="background:#F59E0B;"></div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon" style="background:rgba(37,99,235,.08);">
                <i class="bi bi-share" style="color:#3B82F6;"></i>
            </div>
        </div>
        <div class="stat-card-num" data-count="{{ $delivered }}">{{ $delivered }}</div>
        <div class="stat-card-lbl">Sudah Dikirim</div>
        <div class="stat-card-accent" style="background:#60A5FA;"></div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-icon" style="background:rgba(5,150,105,.12);">
                <i class="bi bi-check-circle" style="color:#059669;"></i>
            </div>
        </div>
        <div class="stat-card-num" data-count="{{ $completed }}">{{ $completed }}</div>
        <div class="stat-card-lbl">Selesai</div>
        <div class="stat-card-accent" style="background:#10B981;"></div>
    </div>

</div>

{{-- ══════════════════════════════════
     TABLE
═══════════════════════════════════ --}}
<span class="section-label">Daftar Pengiriman</span>
<div class="panel-card">
    <div class="panel-head">
        <h6><i class="bi bi-send-check"></i> Pengiriman Hasil Foto</h6>
        <a href="{{ route('deliveries.create') }}" class="tg-btn tg-btn-sm tg-btn-ghost-add">
            <i class="bi bi-plus-lg"></i> Kirim Hasil Baru
        </a>
    </div>
    <div style="overflow-x:auto;">
        <table class="dash-table">
            <thead>
                <tr>
                    <th style="padding-left:20px !important; width:60px;">#</th>
                    <th style="min-width:150px;">Customer</th>
                    <th style="min-width:140px;">Paket</th>
                    <th style="min-width:110px;">Tgl. Sesi</th>
                    <th style="min-width:90px;">Drive</th>
                    <th style="min-width:110px;">Tgl. Kirim</th>
                    <th style="text-align:center; min-width:100px;">Status</th>
                    <th style="min-width:140px;">Catatan</th>
                    <th style="text-align:center; padding-right:20px !important; min-width:90px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($deliveries as $delivery)
                @php
                    $ds = $delivery->status ?? 'editing';
                    $badgeCls = match($ds) {
                        'editing'   => 'tg-badge-editing',
                        'delivered' => 'tg-badge-delivered',
                        'revision'  => 'tg-badge-revision',
                        'completed' => 'tg-badge-completed',
                        default     => 'tg-badge-editing',
                    };
                    $badgeIcon = match($ds) {
                        'editing'   => 'bi-pencil',
                        'delivered' => 'bi-share',
                        'revision'  => 'bi-arrow-counterclockwise',
                        'completed' => 'bi-check-circle',
                        default     => 'bi-circle',
                    };
                    $badgeLbl = match($ds) {
                        'editing'   => 'Editing',
                        'delivered' => 'Dikirim',
                        'revision'  => 'Revisi',
                        'completed' => 'Selesai',
                        default     => ucfirst($ds),
                    };
                @endphp
                <tr>
                    <td style="padding-left:20px !important;">
                        <span style="font-size:.68rem; font-weight:700; color:var(--tg-text-3);">
                            #{{ str_pad($delivery->id, 5, '0', STR_PAD_LEFT) }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <div class="mini-av">{{ strtoupper(substr($delivery->order->user->name ?? 'U', 0, 1)) }}</div>
                            <div>
                                <div style="font-weight:700; font-size:.82rem; line-height:1.3;">{{ $delivery->order->user->name ?? '-' }}</div>
                                <div style="font-size:.71rem; color:var(--tg-text-3);">{{ $delivery->order->user->phone ?? '' }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style="font-weight:600; font-size:.82rem; line-height:1.3;">{{ $delivery->order->package->name ?? '-' }}</div>
                        <div style="font-size:.71rem; color:var(--tg-text-3);">{{ $delivery->order->package->category->name ?? '' }}</div>
                    </td>
                    <td style="font-size:.82rem; color:var(--tg-text-2);">
                        {{ $delivery->order ? \Carbon\Carbon::parse($delivery->order->booking_date)->isoFormat('D MMM YYYY') : '-' }}
                    </td>
                    <td>
                        @if($delivery->delivery_link)
                            <a href="{{ $delivery->delivery_link }}" target="_blank"
                               class="tg-btn tg-btn-sm tg-btn-ghost-green">
                                <i class="bi bi-google"></i> Drive
                            </a>
                        @else
                            <span style="color:var(--tg-text-3); font-size:.76rem;">—</span>
                        @endif
                    </td>
                    <td style="font-size:.80rem; color:var(--tg-text-3);">
                        {{ $delivery->delivery_date ? \Carbon\Carbon::parse($delivery->delivery_date)->isoFormat('D MMM YY') : '—' }}
                    </td>
                    <td style="text-align:center;">
                        <span class="tg-badge {{ $badgeCls }}">
                            <i class="bi {{ $badgeIcon }}"></i>{{ $badgeLbl }}
                        </span>
                    </td>
                    <td style="font-size:.78rem; color:var(--tg-text-3); max-width:150px;">
                        {{ Str::limit($delivery->notes, 35) ?? '—' }}
                    </td>
                    <td style="text-align:center; padding-right:20px !important;">
                        <div style="display:flex; gap:6px; justify-content:center;">
                            <button type="button"
                                    class="tg-btn tg-btn-sm tg-btn-ghost-edit"
                                    onclick="openEditModal({{ $delivery->id }}, '{{ $delivery->status }}', '{{ addslashes($delivery->notes ?? '') }}')"
                                    title="Update Status">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <form id="delete-form-{{ $delivery->id }}"
                                  action="{{ route('deliveries.destroy', $delivery->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="button"
                                        class="tg-btn tg-btn-sm tg-btn-ghost-danger"
                                        onclick="deleteData({{ $delivery->id }})"
                                        title="Hapus">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">
                        <div class="empty-state">
                            <i class="bi bi-inbox"></i>
                            Belum ada data pengiriman
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ══════════════════════════════════
     MODAL UPDATE STATUS
═══════════════════════════════════ --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:440px;">
        <div class="modal-content">
            <form id="edit-delivery-form" method="POST">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-arrow-repeat" style="margin-right:7px;"></i>Update Status Pengiriman
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="field-label">Status</label>
                        <select name="status" id="edit-status" class="tg-input" required>
                            <option value="editing">Editing</option>
                            <option value="delivered">Dikirim</option>
                            <option value="revision">Revisi</option>
                            <option value="completed">Selesai</option>
                        </select>
                    </div>
                    <div>
                        <label class="field-label">Catatan</label>
                        <textarea name="notes" id="edit-notes" class="tg-input"
                                  rows="3" placeholder="Catatan tambahan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="tg-btn tg-btn-sm"
                            style="background:transparent; color:var(--tg-text-2); border-color:var(--tg-border);"
                            data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="tg-btn tg-btn-primary tg-btn-sm">
                        <i class="bi bi-save2"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('custom-js')
<script>
function openEditModal(id, status, notes) {
    document.getElementById('edit-delivery-form').action = '/admin/deliveries/' + id;
    document.getElementById('edit-status').value = status;
    document.getElementById('edit-notes').value  = notes;
    new bootstrap.Modal(document.getElementById('editModal')).show();
}

function deleteData(id) {
    if (confirm('Yakin hapus data pengiriman ini?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}

document.addEventListener('DOMContentLoaded', function () {
    // Pindahkan modal ke body agar tidak terhalang overflow parent
    document.querySelectorAll('[id^="editModal"]').forEach(function(modal) {
        document.body.appendChild(modal);
    });

    document.querySelectorAll('[id^="editModal"]').forEach(function(modal) {
        modal.addEventListener('hidden.bs.modal', function () {
            document.body.classList.remove('modal-open');
            var backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove();
        });
    });

    // Counter animasi
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
</script>
@endsection