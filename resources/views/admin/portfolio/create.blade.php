@extends('base.base-admin-index')

@php $menu = 'Portofolio'; $submenu = 'Tambah Portofolio'; $subdesc = 'Upload foto portofolio baru'; @endphp

@section('custom-css')
<style>
    @font-face { font-family:"Font Awesome 6 Free"; font-weight:900; font-display:block; src:url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/webfonts/fa-solid-900.woff2") format("woff2"); }
    .fa-solid,.fas{font-family:"Font Awesome 6 Free"!important;font-weight:900!important;}

    .tg-card { border:none!important; border-radius:14px!important; box-shadow:0 1px 3px rgba(0,0,0,.06),0 4px 16px rgba(0,0,0,.05)!important; }
    .tg-card .card-header { background:#fff!important; border-bottom:1px solid #F3F4F6!important; padding:15px 20px!important; }
    .tg-card .card-header .card-title { font-size:.95rem!important; font-weight:700!important; color:#111827!important; margin:0; }
    .tg-card .card-body { padding:20px!important; }

    .field-label { font-size:.8rem; font-weight:600; color:#374151; margin-bottom:5px; }
    .upload-zone { height:180px; background:#F9FAFB; border:2px dashed #E5E7EB; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-direction:column; gap:8px; color:#9CA3AF; transition:border-color .2s; cursor:pointer; }
    .upload-zone:hover { border-color:#2563EB; background:#EFF6FF; }
    .section-label { font-size:.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.1em; color:#9CA3AF; margin-bottom:10px; }
</style>
@endsection

@section('content')

<form action="{{ route('portfolios.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row g-3">

        {{-- Gambar --}}
        <div class="col-lg-4">
            <p class="section-label">Gambar</p>
            <div class="card tg-card">
                <div class="card-header">
                    <h5 class="card-title"><i class="fa-solid fa-image me-2 text-primary"></i>Upload Gambar</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3 text-center">
                        <img id="image-preview" src="" alt="Preview" class="img-fluid"
                             style="max-height:200px;object-fit:cover;border-radius:10px;display:none;">
                        <div id="preview-placeholder" class="upload-zone" onclick="document.getElementById('image').click()">
                            <i class="fa-solid fa-cloud-arrow-up" style="font-size:1.6rem;color:#DBEAFE;"></i>
                            <span style="font-size:.8rem;">Klik untuk upload gambar</span>
                            <span style="font-size:.72rem;color:#D1D5DB;">JPG, PNG, WebP — Maks 3MB</span>
                        </div>
                    </div>
                    <div>
                        <label class="field-label">File Gambar <span class="text-danger">*</span></label>
                        <input type="file" name="image" id="image"
                               class="form-control @error('image') is-invalid @enderror"
                               accept="image/jpg,image/jpeg,image/png,image/webp"
                               onchange="previewImage(event)">
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Detail --}}
        <div class="col-lg-8">
            <p class="section-label">Detail Portofolio</p>
            <div class="card tg-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title"><i class="fa-solid fa-pencil me-2 text-primary"></i>Tambah Portofolio</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('portfolios.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;font-size:.78rem;">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-sm btn-primary" style="border-radius:8px;font-size:.78rem;">
                            <i class="fa-solid fa-save me-1"></i> Simpan
                        </button>
                    </div>
                </div>
                <div class="card-body">

                    @if($errors->any())
                    <div class="alert alert-danger mb-3" style="border-radius:10px;border:none;font-size:.84rem;">
                        <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label class="field-label">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                               placeholder="Contoh: Prewedding di Pantai Losari..."
                               value="{{ old('title') }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="field-label">Kategori <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="" disabled selected>Pilih Kategori</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="field-label">Deskripsi</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                  rows="5" placeholder="Deskripsi portofolio...">{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <input type="hidden" name="is_active" value="0">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                                   {{ old('is_active','1') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active" style="font-size:.84rem;font-weight:600;">
                                Tampilkan di halaman publik
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@section('custom-js')
<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const preview = document.getElementById('image-preview');
        const placeholder = document.getElementById('preview-placeholder');
        preview.src = e.target.result;
        preview.style.display = 'block';
        placeholder.style.display = 'none';
    };
    reader.readAsDataURL(file);
}
</script>
@endsection