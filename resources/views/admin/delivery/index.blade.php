@extends('base.base-admin-index')

@php $menu = 'Pengiriman'; $submenu = 'Pengiriman Hasil'; $subdesc = 'Kelola pengiriman hasil foto ke customer'; @endphp

@section('custom-css')
<style>
    @font-face { font-family:"Font Awesome 6 Free"; font-weight:900; font-display:block; src:url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/webfonts/fa-solid-900.woff2") format("woff2"); }
    @font-face { font-family:"Font Awesome 6 Brands"; font-weight:400; font-display:block; src:url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/webfonts/fa-brands-400.woff2") format("woff2"); }
    .fa-solid,.fas{font-family:"Font Awesome 6 Free"!important;font-weight:900!important;}
    .fa-brands,.fab{font-family:"Font Awesome 6 Brands"!important;font-weight:400!important;}

    .tg-stat { display:flex; align-items:center; gap:14px; padding:16px 20px; background:#fff; border-radius:12px; box-shadow:0 1px 3px rgba(0,0,0,.06),0 4px 16px rgba(0,0,0,.04); height:100%; }
    .tg-stat-icon { width:46px; height:46px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:1.1rem; flex-shrink:0; }
    .tg-stat-num { font-size:1.5rem; font-weight:800; line-height:1; color:#111827; }
    .tg-stat-lbl { font-size:.7rem; color:#9CA3AF; text-transform:uppercase; letter-spacing:.07em; margin-top:3px; }

    .tg-card { border:none!important; border-radius:14px!important; box-shadow:0 1px 3px rgba(0,0,0,.06),0 4px 16px rgba(0,0,0,.05)!important; overflow:hidden; }
    .tg-card .card-header { background:linear-gradient(135deg,#1E3A8A,#2563EB)!important; border:none!important; padding:15px 20px!important; }
    .tg-card .card-header h5 { color:#fff!important; font-weight:600!important; font-size:.95rem!important; margin:0; }

    .tg-table thead th { font-size:.7rem!important; text-transform:uppercase!important; letter-spacing:.07em!important; color:#9CA3AF!important; background:#FAFAFA!important; border-bottom:1px solid #F3F4F6!important; padding:10px 14px!important; }
    .tg-table tbody td { padding:10px 14px!important; vertical-align:middle!important; font-size:.84rem!important; border-bottom:1px solid #F9FAFB!important; }
    .tg-table tbody tr:last-child td { border-bottom:none!important; }
    .tg-table tbody tr:hover td { background:#FAFBFF!important; }

    .badge-editing   { background:#FEF3C7; color:#92400E; font-size:.68rem; font-weight:700; padding:3px 10px; border-radius:100px; }
    .badge-delivered { background:#DBEAFE; color:#1E40AF; font-size:.68rem; font-weight:700; padding:3px 10px; border-radius:100px; }
    .badge-revision  { background:#FEE2E2; color:#991B1B; font-size:.68rem; font-weight:700; padding:3px 10px; border-radius:100px; }
    .badge-completed { background:#D1FAE5; color:#065F46; font-size:.68rem; font-weight:700; padding:3px 10px; border-radius:100px; }

    .btn-act { padding:4px 10px; font-size:.74rem; border-radius:6px; }
    .mini-avatar { width:28px; height:28px; border-radius:7px; background:linear-gradient(135deg,#1E3A8A,#3B82F6); color:#fff; font-size:.68rem; font-weight:700; display:inline-flex; align-items:center; justify-content:center; }
    .accent-bar { width:4px; height:18px; background:#60A5FA; border-radius:100px; flex-shrink:0; }
    .section-label { font-size:.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.1em; color:#9CA3AF; margin-bottom:10px; }
</style>
@endsection

@section('content')

@php
    $total     = $deliveries->count();
    $editing   = $deliveries->where('status','editing')->count();
    $delivered = $deliveries->where('status','delivered')->count();
    $completed = $deliveries->where('status','completed')->count();
@endphp

<p class="section-label">Statistik Pengiriman</p>
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="tg-stat">
            <div class="tg-stat-icon" style="background:#EFF6FF;"><i class="fa-solid fa-paper-plane text-primary"></i></div>
            <div><div class="tg-stat-num">{{ $total }}</div><div class="tg-stat-lbl">Total</div></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="tg-stat">
            <div class="tg-stat-icon" style="background:#FEF3C7;"><i class="fa-solid fa-pen" style="color:#D97706;"></i></div>
            <div><div class="tg-stat-num">{{ $editing }}</div><div class="tg-stat-lbl">Editing</div></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="tg-stat">
            <div class="tg-stat-icon" style="background:#DBEAFE;"><i class="fa-solid fa-share text-primary"></i></div>
            <div><div class="tg-stat-num">{{ $delivered }}</div><div class="tg-stat-lbl">Dikirim</div></div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="tg-stat">
            <div class="tg-stat-icon" style="background:#D1FAE5;"><i class="fa-solid fa-circle-check text-success"></i></div>
            <div><div class="tg-stat-num">{{ $completed }}</div><div class="tg-stat-lbl">Selesai</div></div>
        </div>
    </div>
</div>

<p class="section-label">Daftar Pengiriman</p>
<div class="card tg-card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <div class="accent-bar"></div>
            <h5>Pengiriman Hasil Foto</h5>
        </div>
        <a href="{{ route('deliveries.create') }}" class="btn btn-sm" style="background:rgba(255,255,255,.15);color:#fff;border:1px solid rgba(255,255,255,.3);border-radius:8px;font-size:.78rem;">
            <i class="fa-solid fa-plus me-1"></i> Kirim Hasil Baru
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table tg-table mb-0">
                <thead>
                    <tr>
                        <th style="padding-left:20px!important;">#</th>
                        <th>Customer</th>
                        <th>Paket</th>
                        <th>Tgl. Sesi</th>
                        <th>Drive Link</th>
                        <th>Tgl. Kirim</th>
                        <th>Status</th>
                        <th>Catatan</th>
                        <th class="text-center" style="padding-right:20px!important;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deliveries as $delivery)
                    @php
                        $ds = $delivery->status ?? 'editing';
                        $dbadge = match($ds) {
                            'editing'   => 'badge-editing',
                            'delivered' => 'badge-delivered',
                            'revision'  => 'badge-revision',
                            'completed' => 'badge-completed',
                            default     => 'badge-editing',
                        };
                        $dlbl = match($ds) {
                            'editing'   => 'Editing',
                            'delivered' => 'Dikirim',
                            'revision'  => 'Revisi',
                            'completed' => 'Selesai',
                            default     => ucfirst($ds),
                        };
                    @endphp
                    <tr>
                        <td style="padding-left:20px!important;font-size:.7rem;font-weight:700;color:#D1D5DB;">
                            #{{ str_pad($delivery->id,5,'0',STR_PAD_LEFT) }}
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="mini-avatar">{{ strtoupper(substr($delivery->order->user->name ?? 'U',0,1)) }}</div>
                                <div>
                                    <div style="font-weight:700;font-size:.84rem;">{{ $delivery->order->user->name ?? '-' }}</div>
                                    <div style="font-size:.72rem;color:#9CA3AF;">{{ $delivery->order->user->phone ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div style="font-size:.84rem;font-weight:600;">{{ $delivery->order->package->name ?? '-' }}</div>
                            <div style="font-size:.72rem;color:#9CA3AF;">{{ $delivery->order->package->category->name ?? '' }}</div>
                        </td>
                        <td style="font-size:.82rem;">
                            {{ $delivery->order ? \Carbon\Carbon::parse($delivery->order->booking_date)->isoFormat('D MMM YYYY') : '-' }}
                        </td>
                        <td>
                            @if($delivery->delivery_link)
                                <a href="{{ $delivery->delivery_link }}" target="_blank" class="btn btn-sm btn-outline-success btn-act">
                                    <i class="fa-brands fa-google-drive me-1"></i> Drive
                                </a>
                            @else
                                <span style="color:#9CA3AF;font-size:.76rem;">-</span>
                            @endif
                        </td>
                        <td style="font-size:.82rem;color:#6B7280;">
                            {{ $delivery->delivery_date ? \Carbon\Carbon::parse($delivery->delivery_date)->isoFormat('D MMM YYYY') : '-' }}
                        </td>
                        <td><span class="{{ $dbadge }}">{{ $dlbl }}</span></td>
                        <td style="max-width:150px;font-size:.78rem;color:#6B7280;">{{ Str::limit($delivery->notes, 35) ?? '-' }}</td>
                        <td class="text-center" style="padding-right:20px!important;">
                            <div class="d-flex gap-1 justify-content-center">
                                <button type="button" class="btn btn-sm btn-outline-primary btn-act"
                                        onclick="openEditModal({{ $delivery->id }}, '{{ $delivery->status }}', '{{ addslashes($delivery->notes ?? '') }}')"
                                        title="Update Status">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <form id="delete-form-{{ $delivery->id }}" action="{{ route('deliveries.destroy', $delivery->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="deleteData({{ $delivery->id }})" class="btn btn-sm btn-outline-danger btn-act" title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5" style="color:#9CA3AF;">
                            <i class="fa-solid fa-inbox fa-2x d-block mb-2" style="opacity:.3;"></i>
                            Belum ada data pengiriman
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Edit Status --}}
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border:none;border-radius:14px;">
            <form id="edit-delivery-form" method="POST">
                @csrf @method('PUT')
                <div class="modal-header" style="border-bottom:1px solid #F3F4F6;padding:15px 20px;">
                    <h6 class="modal-title" style="font-weight:700;">Update Status Pengiriman</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="padding:20px;">
                    <div class="mb-3">
                        <label style="font-size:.8rem;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Status</label>
                        <select name="status" id="edit-status" class="form-select" required>
                            <option value="editing">Editing</option>
                            <option value="delivered">Dikirim</option>
                            <option value="revision">Revisi</option>
                            <option value="completed">Selesai</option>
                        </select>
                    </div>
                    <div>
                        <label style="font-size:.8rem;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Catatan</label>
                        <textarea name="notes" id="edit-notes" class="form-control" rows="3" placeholder="Catatan tambahan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid #F3F4F6;padding:12px 20px;">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal" style="border-radius:8px;">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm" style="border-radius:8px;">
                        <i class="fa-solid fa-save me-1"></i> Simpan
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
</script>

<script>
/*
 * FIX modal tidak bisa diklik:
 * Masalah umum: Bootstrap modal muncul tapi input tidak responsif karena
 * elemen parent memiliki overflow:hidden atau z-index yang menghalangi.
 *
 * Solusi: saat modal dibuka, pindahkan ke document.body agar tidak
 * terpengaruh oleh overflow atau stacking context parent manapun.
 */
document.addEventListener('DOMContentLoaded', function () {
    // Pindahkan semua modal edit ke body agar tidak terhalang overflow parent
    document.querySelectorAll('[id^="editModal"]').forEach(function(modal) {
        document.body.appendChild(modal);
    });
 
    // Pastikan setiap kali modal ditutup, state-nya bersih
    document.querySelectorAll('[id^="editModal"]').forEach(function(modal) {
        modal.addEventListener('hidden.bs.modal', function () {
            document.body.classList.remove('modal-open');
            var backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove();
        });
    });
});
</script>

@endsection
