@extends('base.base-admin-index')

@php $menu = 'Portofolio'; $submenu = 'Portofolio'; $subdesc = 'Kelola galeri portofolio foto'; @endphp

@section('custom-css')
<style>
    @font-face { font-family:"Font Awesome 6 Free"; font-weight:900; font-display:block; src:url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/webfonts/fa-solid-900.woff2") format("woff2"); }
    .fa-solid,.fas{font-family:"Font Awesome 6 Free"!important;font-weight:900!important;}

    .tg-card { border:none!important; border-radius:14px!important; box-shadow:0 1px 3px rgba(0,0,0,.06),0 4px 16px rgba(0,0,0,.05)!important; overflow:hidden; }
    .tg-card .card-header { background:#fff!important; border-bottom:1px solid #F3F4F6!important; padding:15px 20px!important; }
    .tg-card .card-header .card-title { font-size:.95rem!important; font-weight:700!important; color:#111827!important; margin:0; }

    .tg-table thead th { font-size:.7rem!important; text-transform:uppercase!important; letter-spacing:.07em!important; color:#9CA3AF!important; background:#FAFAFA!important; border-bottom:1px solid #F3F4F6!important; padding:10px 14px!important; }
    .tg-table tbody td { padding:10px 14px!important; vertical-align:middle!important; font-size:.84rem!important; border-bottom:1px solid #F9FAFB!important; }
    .tg-table tbody tr:last-child td { border-bottom:none!important; }
    .tg-table tbody tr:hover td { background:#FAFBFF!important; }

    .porto-thumb { width:52px; height:52px; object-fit:cover; border-radius:9px; border:1px solid #F3F4F6; cursor:pointer; transition:transform .15s; }
    .porto-thumb:hover { transform:scale(1.08); }
    .status-active   { background:#D1FAE5; color:#065F46; font-size:.7rem; font-weight:600; padding:3px 10px; border-radius:100px; }
    .status-inactive { background:#F3F4F6; color:#6B7280; font-size:.7rem; font-weight:600; padding:3px 10px; border-radius:100px; }
    .cat-badge { background:#EFF6FF; color:#1E40AF; font-size:.72rem; font-weight:600; padding:3px 10px; border-radius:100px; }
    .btn-act { padding:4px 10px; font-size:.74rem; border-radius:6px; }
    .section-label { font-size:.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.1em; color:#9CA3AF; margin-bottom:10px; }
</style>
@endsection

@section('content')

@if(session('success'))
<div class="alert alert-success mb-3" style="border-radius:10px;border:none;font-size:.84rem;">
    <i class="fa-solid fa-check-circle me-1"></i> {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="alert alert-danger mb-3" style="border-radius:10px;border:none;font-size:.84rem;">
    <i class="fa-solid fa-exclamation-triangle me-1"></i> {{ session('error') }}
</div>
@endif

<p class="section-label">Daftar Portofolio</p>
<div class="card tg-card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div>
            <h5 class="card-title"><i class="fa-solid fa-images me-2 text-primary"></i>Galeri Portofolio</h5>
            <span style="font-size:.76rem;color:#9CA3AF;">{{ $portofolios->count() }} portofolio</span>
        </div>
        <a href="{{ route('portfolios.create') }}" class="btn btn-sm btn-primary" style="border-radius:8px;font-size:.78rem;">
            <i class="fa-solid fa-plus me-1"></i> Tambah
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table tg-table mb-0" id="table1">
                <thead>
                    <tr>
                        <th style="padding-left:20px!important;">#</th>
                        <th>Gambar</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="padding-right:20px!important;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($portofolios as $key => $item)
                    <tr>
                        <td style="padding-left:20px!important;font-size:.7rem;font-weight:700;color:#D1D5DB;">{{ ++$key }}</td>
                        <td>
                            @if($item->image)
                                <img src="{{ asset('storage/images/portofolio/'.$item->image) }}"
                                     class="porto-thumb" alt="{{ $item->title }}"
                                     onclick="showImage('{{ asset('storage/images/portofolio/'.$item->image) }}', '{{ $item->title }}')">
                            @else
                                <div style="width:52px;height:52px;border-radius:9px;background:#F3F4F6;display:flex;align-items:center;justify-content:center;">
                                    <i class="fa-solid fa-image" style="color:#D1D5DB;"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight:700;color:#111827;font-size:.88rem;">{{ $item->title }}</div>
                            @if($item->description)
                                <div style="font-size:.74rem;color:#9CA3AF;">{{ Str::limit($item->description, 55) }}</div>
                            @endif
                        </td>
                        <td><span class="cat-badge">{{ $item->category->name ?? '-' }}</span></td>
                        <td class="text-center">
                            @if($item->is_active)
                                <span class="status-active">Aktif</span>
                            @else
                                <span class="status-inactive">Nonaktif</span>
                            @endif
                        </td>
                        <td class="text-center" style="padding-right:20px!important;">
                            <div class="d-flex gap-1 justify-content-center">
                                <a href="{{ route('portfolios.edit', $item->id) }}" class="btn btn-sm btn-outline-primary btn-act" title="Edit">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <form id="delete-form-{{ $item->id }}" action="{{ route('portfolios.destroy', $item->id) }}" method="POST">
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
                        <td colspan="6" class="text-center py-5" style="color:#9CA3AF;">
                            <i class="fa-solid fa-images fa-2x d-block mb-2" style="opacity:.3;"></i>
                            Belum ada portofolio
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Image Preview Modal --}}
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border:none;border-radius:14px;">
            <div class="modal-header" style="border-bottom:1px solid #F3F4F6;padding:14px 20px;">
                <h6 class="modal-title" id="image-modal-title" style="font-weight:700;font-size:.9rem;"></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-3 text-center">
                <img id="image-modal-src" src="" alt="" style="max-width:100%;border-radius:10px;">
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