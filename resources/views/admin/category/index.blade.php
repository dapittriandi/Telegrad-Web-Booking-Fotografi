@extends('base.base-admin-index')

@php $menu = 'Kategori'; $submenu = 'Kategori'; $subdesc = 'Kelola kategori paket foto'; @endphp

@section('custom-css')
<style>
    @font-face { font-family:"Font Awesome 6 Free"; font-weight:900; font-display:block; src:url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/webfonts/fa-solid-900.woff2") format("woff2"); }
    .fa-solid,.fas{font-family:"Font Awesome 6 Free"!important;font-weight:900!important;}

    :root {
        --blue-50:#EFF6FF; --blue-100:#DBEAFE; --blue-600:#2563EB; --blue-700:#1D4ED8; --blue-800:#1E3A8A;
        --gray-50:#F9FAFB; --gray-100:#F3F4F6; --gray-200:#E5E7EB; --gray-400:#9CA3AF; --gray-600:#4B5563; --gray-700:#374151; --gray-900:#111827;
        --green-50:#ECFDF5; --green-100:#D1FAE5; --green-700:#065F46;
        --amber-50:#FFFBEB; --amber-100:#FEF3C7; --amber-700:#92400E;
        --red-50:#FFF5F5; --red-100:#FEE2E2; --red-700:#991B1B;
        --shadow-sm: 0 1px 2px rgba(0,0,0,.05); --shadow-md: 0 1px 3px rgba(0,0,0,.06), 0 4px 16px rgba(0,0,0,.05);
        --radius-sm:8px; --radius-md:12px; --radius-lg:16px;
    }

    /* Layout */
    body { background:#F8FAFC; }
    .page-wrapper { max-width:1200px; }

    /* Section label */
    .section-label { font-size:.67rem; font-weight:700; text-transform:uppercase; letter-spacing:.12em; color:var(--gray-400); margin-bottom:10px; display:block; }

    /* Stat cards */
    .stat-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(140px,1fr)); gap:12px; margin-bottom:28px; }
    .stat-card { background:#fff; border:1px solid var(--gray-200); border-radius:var(--radius-md); padding:14px 16px; display:flex; align-items:center; gap:12px; box-shadow:var(--shadow-sm); }
    .stat-icon { width:38px; height:38px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:.95rem; flex-shrink:0; }
    .stat-num { font-size:1.35rem; font-weight:800; color:var(--gray-900); line-height:1.1; }
    .stat-lbl { font-size:.67rem; color:var(--gray-400); text-transform:uppercase; letter-spacing:.07em; }

    /* Cards */
    .tg-card { background:#fff; border:1px solid var(--gray-200); border-radius:var(--radius-lg); box-shadow:var(--shadow-md); overflow:hidden; }
    .tg-card-header { background:#fff; border-bottom:1px solid var(--gray-100); padding:14px 20px; display:flex; align-items:center; gap:10px; }
    .tg-card-title { font-size:.9rem; font-weight:700; color:var(--gray-900); margin:0; }
    .tg-card-body { padding:20px; }

    /* Table */
    .tg-table { width:100%; border-collapse:collapse; }
    .tg-table thead th { font-size:.67rem; text-transform:uppercase; letter-spacing:.08em; color:var(--gray-400); background:#FAFAFA; border-bottom:1px solid var(--gray-100); padding:10px 14px; font-weight:700; white-space:nowrap; }
    .tg-table tbody td { padding:11px 14px; vertical-align:middle; font-size:.84rem; border-bottom:1px solid #F9FAFB; color:var(--gray-700); }
    .tg-table tbody tr:last-child td { border-bottom:none; }
    .tg-table tbody tr:hover td { background:var(--blue-50); transition:background .15s; }

    /* Badges */
    .badge-active   { background:var(--green-100); color:var(--green-700); }
    .badge-inactive { background:var(--gray-100); color:var(--gray-600); }
    .badge { font-size:.67rem; font-weight:700; padding:3px 10px; border-radius:100px; display:inline-block; }

    /* Form */
    .field-label { font-size:.8rem; font-weight:600; color:var(--gray-700); margin-bottom:5px; display:block; }
    .form-control { border:1px solid var(--gray-200); border-radius:var(--radius-sm); padding:8px 12px; font-size:.84rem; width:100%; transition:border-color .15s, box-shadow .15s; color:var(--gray-900); }
    .form-control:focus { border-color:var(--blue-600); box-shadow:0 0 0 3px rgba(37,99,235,.1); outline:none; }
    .form-control.is-invalid { border-color:#EF4444; }
    .invalid-feedback { font-size:.76rem; color:#EF4444; margin-top:4px; }

    /* Buttons */
    .btn { border-radius:var(--radius-sm); font-weight:600; font-size:.82rem; padding:7px 14px; border:1px solid transparent; cursor:pointer; transition:all .15s; display:inline-flex; align-items:center; gap:6px; }
    .btn-primary { background:var(--blue-600); color:#fff; border-color:var(--blue-600); }
    .btn-primary:hover { background:var(--blue-700); border-color:var(--blue-700); }
    .btn-sm { padding:5px 10px; font-size:.76rem; }
    .btn-outline-primary { background:transparent; color:var(--blue-600); border-color:var(--blue-200,#BFDBFE); }
    .btn-outline-primary:hover { background:var(--blue-50); }
    .btn-outline-warning { background:transparent; color:#D97706; border-color:#FDE68A; }
    .btn-outline-warning:hover { background:var(--amber-50); }
    .btn-outline-danger { background:transparent; color:#DC2626; border-color:#FECACA; }
    .btn-outline-danger:hover { background:var(--red-50); }
    .btn-outline-success { background:transparent; color:#059669; border-color:#A7F3D0; }
    .btn-outline-success:hover { background:var(--green-50); }
    .btn-outline-secondary { background:transparent; color:var(--gray-600); border-color:var(--gray-200); }
    .btn-outline-secondary:hover { background:var(--gray-50); }
    .btn-w100 { width:100%; justify-content:center; }

    /* Alert */
    .alert { border-radius:var(--radius-sm); padding:10px 14px; font-size:.84rem; margin-bottom:16px; display:flex; align-items:center; gap:8px; }
    .alert-success { background:var(--green-100); color:var(--green-700); border:1px solid #6EE7B7; }
    .alert-danger   { background:var(--red-100); color:var(--red-700); border:1px solid #FCA5A5; }

    /* Modal — fix z-index agar input dalam modal bisa diklik */
    .modal { z-index:1055 !important; }
    .modal-backdrop { z-index:1054 !important; }
    .modal-dialog { pointer-events:auto !important; }
    .modal-content { border:none !important; border-radius:var(--radius-lg) !important; pointer-events:auto !important; }
    .modal-body input, .modal-body textarea, .modal-body select, .modal-body .form-check-input { pointer-events:auto !important; position:relative; z-index:2; }
    .modal-header { border-bottom:1px solid var(--gray-100) !important; padding:16px 20px !important; }
    .modal-body   { padding:20px !important; }
    .modal-footer { border-top:1px solid var(--gray-100) !important; padding:12px 20px !important; }
    .modal-title  { font-size:.9rem; font-weight:700; color:var(--gray-900); }

    /* Code tag */
    .slug-tag { background:var(--gray-100); padding:2px 7px; border-radius:5px; font-size:.75rem; color:var(--gray-600); font-family:monospace; }

    /* Layout row */
    .row-2col { display:grid; grid-template-columns:1fr 2fr; gap:20px; }
    @media(max-width:768px){ .row-2col { grid-template-columns:1fr; } }
</style>
@endsection

@section('content')

@if(session('success'))
<div class="alert alert-success"><i class="fa-solid fa-check-circle"></i> {{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-danger"><i class="fa-solid fa-exclamation-triangle"></i> {{ session('error') }}</div>
@endif

{{-- Stats --}}
<span class="section-label">Ringkasan</span>
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:var(--blue-50);"><i class="fa-solid fa-folder" style="color:var(--blue-600);font-size:16px;"></i></div>
        <div><div class="stat-num">{{ $categories->count() }}</div><div class="stat-lbl">Kategori</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:var(--green-50);"><i class="fa-solid fa-box" style="color:#059669;font-size:16px;"></i></div>
        <div><div class="stat-num">{{ \App\Models\Package::count() }}</div><div class="stat-lbl">Paket</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:var(--blue-100);"><i class="fa-solid fa-images" style="color:var(--blue-600);font-size:16px;"></i></div>
        <div><div class="stat-num">{{ \App\Models\Portofolio::count() }}</div><div class="stat-lbl">Portofolio</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#FEF9C3;"><i class="fa-solid fa-star" style="color:#CA8A04;font-size:16px;"></i></div>
        <div><div class="stat-num">{{ \App\Models\Rating::count() }}</div><div class="stat-lbl">Rating</div></div>
    </div>
</div>

{{-- Main content --}}
<div class="row-2col">

    {{-- ===== FORM TAMBAH ===== --}}
    <div>
        <span class="section-label">Tambah Kategori</span>
        <div class="tg-card">
            <div class="tg-card-header">
                <i class="fa-solid fa-folder-plus" style="color:var(--blue-600);font-size:15px;"></i>
                <h5 class="tg-card-title">Kategori Baru</h5>
            </div>
            <div class="tg-card-body">
                {{--
                    FIX: Pastikan route 'categories.store' terdaftar di web.php:
                    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
                --}}
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="field-label">Nama Kategori <span style="color:#EF4444;">*</span></label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="Contoh: Wisuda, Prewedding..."
                               value="{{ old('name') }}" autocomplete="off">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="field-label">Deskripsi</label>
                        <textarea name="description"
                                  class="form-control @error('description') is-invalid @enderror"
                                  rows="3"
                                  placeholder="Deskripsi singkat kategori...">{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-w100">
                        <i class="fa-solid fa-plus" style="font-size:12px;"></i> Tambah Kategori
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ===== TABEL ===== --}}
    <div>
        <span class="section-label">Daftar Kategori</span>
        <div class="tg-card">
            <div class="tg-card-header">
                <i class="fa-solid fa-list" style="color:var(--blue-600);font-size:15px;"></i>
                <h5 class="tg-card-title">Semua Kategori</h5>
                <span style="font-size:.75rem;color:var(--gray-400);margin-left:auto;">{{ $categories->count() }} kategori</span>
            </div>
            <div style="overflow-x:auto;">
                <table class="tg-table">
                    <thead>
                        <tr>
                            <th style="padding-left:20px;">#</th>
                            <th>Nama</th>
                            <th>Slug</th>
                            <th>Deskripsi</th>
                            <th style="text-align:center;">Status</th>
                            <th style="text-align:center;padding-right:20px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $key => $item)
                        <tr>
                            <td style="padding-left:20px;color:var(--gray-400);font-size:.72rem;font-weight:700;">{{ ++$key }}</td>
                            <td style="font-weight:700;color:var(--gray-900);">{{ $item->name }}</td>
                            <td><span class="slug-tag">{{ $item->slug }}</span></td>
                            <td style="color:var(--gray-400);font-size:.8rem;">{{ Str::limit($item->description, 35) ?? '-' }}</td>
                            <td style="text-align:center;">
                                <span class="badge {{ $item->is_active ? 'badge-active' : 'badge-inactive' }}">
                                    {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td style="text-align:center;padding-right:20px;">
                                <div style="display:flex;gap:6px;justify-content:center;">
                                    {{--
                                        FIX: Tombol edit membuka modal. Pastikan data-bs-target
                                        sesuai dengan id modal di bawah.
                                    --}}
                                    <button class="btn btn-sm btn-outline-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $item->id }}"
                                            title="Edit">
                                        <i class="fa-solid fa-pen" style="font-size:11px;"></i>
                                    </button>
                                    {{--
                                        FIX: Route toggleStatus harus terdaftar:
                                        Route::post('/categories/{id}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggleStatus');
                                    --}}
                                    <form action="{{ route('categories.toggleStatus', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit"
                                                class="btn btn-sm {{ $item->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}"
                                                title="{{ $item->is_active ? 'Nonaktifkan' : 'Aktifkan' }}"
                                                onclick="return confirm('Ubah status kategori ini?')">
                                            <i class="fa-solid {{ $item->is_active ? 'fa-eye-slash' : 'fa-eye' }}" style="font-size:11px;"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('categories.destroy', $item->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Yakin hapus kategori \'{{ $item->name }}\'?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="fa-solid fa-trash" style="font-size:11px;"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="text-align:center;padding:48px 0;color:var(--gray-400);">
                                <i class="fa-solid fa-folder-open fa-2x d-block mb-2" style="opacity:.25;margin-bottom:8px;"></i>
                                Belum ada kategori
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- ===== MODAL EDIT =====
     FIX UTAMA:
     1. Modal diletakkan di LUAR loop tabel agar tidak konflik DOM
     2. Method PUT dengan @method('PUT') — penting untuk Laravel route update
     3. action="{{ route('categories.update', $item->id) }}" — pastikan route ini ada:
        Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
     4. Form berada langsung di dalam modal-content, bukan di dalam elemen lain
--}}
@foreach($categories as $item)
<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:460px;">
        <div class="modal-content">
            {{-- FIX: Form langsung wrap modal-content, bukan di dalam modal-body --}}
            <form action="{{ route('categories.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fa-solid fa-pen me-2" style="color:var(--blue-600);font-size:13px;"></i>Edit Kategori
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="field-label">Nama Kategori <span style="color:#EF4444;">*</span></label>
                        <input type="text" name="name" class="form-control"
                               value="{{ $item->name }}" required autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label class="field-label">Slug</label>
                        <input type="text" class="form-control" value="{{ $item->slug }}" disabled
                               style="background:var(--gray-50);color:var(--gray-400);">
                        <p style="font-size:.72rem;color:var(--gray-400);margin-top:4px;">Slug diperbarui otomatis saat nama diubah</p>
                    </div>
                    <div class="mb-3">
                        <label class="field-label">Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3">{{ $item->description }}</textarea>
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;">
                        {{-- FIX: Hidden input value=0 untuk handle unchecked checkbox --}}
                        <input type="hidden" name="is_active" value="0">
                        <input class="form-check-input" type="checkbox" name="is_active"
                               id="is_active_{{ $item->id }}" value="1"
                               {{ $item->is_active ? 'checked' : '' }}
                               style="width:18px;height:18px;cursor:pointer;">
                        <label for="is_active_{{ $item->id }}" style="font-size:.84rem;color:var(--gray-700);cursor:pointer;">
                            Tampilkan kategori (Aktif)
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-save" style="font-size:11px;"></i> Simpan Perubahan
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