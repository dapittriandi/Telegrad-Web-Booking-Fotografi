@extends('base.base-admin-index')

@php $menu = 'Portofolio'; $submenu = 'Edit Portofolio'; $subdesc = 'Edit: ' . $portofolio->title; @endphp

@section('custom-css')
<style>
    @font-face { font-family:"Font Awesome 6 Free"; font-weight:900; font-display:block; src:url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/webfonts/fa-solid-900.woff2") format("woff2"); }
    .fa-solid,.fas{font-family:"Font Awesome 6 Free"!important;font-weight:900!important;}

    .tg-card { border:none!important; border-radius:14px!important; box-shadow:0 1px 3px rgba(0,0,0,.06),0 4px 16px rgba(0,0,0,.05)!important; }
    .tg-card .card-header { background:#fff!important; border-bottom:1px solid #F3F4F6!important; padding:15px 20px!important; }
    .tg-card .card-header .card-title { font-size:.95rem!important; font-weight:700!important; color:#111827!important; margin:0; }
    .tg-card .card-body { padding:20px!important; }

    .field-label { font-size:.8rem; font-weight:600; color:#374151; margin-bottom:5px; display:block; }
    .section-label { font-size:.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.1em; color:#9CA3AF; margin-bottom:10px; }
    .form-control:focus, .form-select:focus { border-color:#2563EB; box-shadow:0 0 0 3px rgba(37,99,235,.1); }

    /* Upload zone */
    .upload-zone { height:190px; background:#F9FAFB; border:2px dashed #E5E7EB; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-direction:column; gap:8px; color:#9CA3AF; transition:border-color .2s; cursor:pointer; }
    .upload-zone:hover { border-color:#2563EB; background:#EFF6FF; }

    /* Current image wrapper */
    .current-img-wrap { position:relative; border-radius:10px; overflow:hidden; }
    .current-img-wrap img { width:100%; max-height:210px; object-fit:cover; border-radius:10px; display:block; }
    .current-img-overlay { position:absolute; inset:0; background:rgba(0,0,0,.35); display:flex; align-items:center; justify-content:center; opacity:0; transition:opacity .2s; border-radius:10px; cursor:pointer; }
    .current-img-wrap:hover .current-img-overlay { opacity:1; }

    /* Meta pill */
    .meta-pill { display:inline-flex; align-items:center; gap:5px; background:#F3F4F6; color:#374151; font-size:.74rem; font-weight:600; padding:3px 10px; border-radius:100px; }
</style>
@endsection

@section('content')

<form action="{{ route('portfolios.update', $portofolio->id) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')

    <div class="row g-3">

        {{-- Kolom Gambar --}}
        <div class="col-lg-4">
            <p class="section-label">Gambar Portofolio</p>
            <div class="card tg-card">
                <div class="card-header">
                    <h5 class="card-title"><i class="fa-solid fa-image me-2 text-primary"></i>Gambar</h5>
                </div>
                <div class="card-body">

                    <div class="mb-3">
                        @if($portofolio->image)
                        <div class="current-img-wrap" onclick="document.getElementById('image').click()">
                            <img id="image-preview"
                                 src="{{ asset('storage/images/portofolio/'.$portofolio->image) }}"
                                 alt="{{ $portofolio->title }}">
                            <div class="current-img-overlay">
                                <div style="text-align:center;color:#fff;">
                                    <i class="fa-solid fa-camera" style="font-size:1.4rem;display:block;margin-bottom:4px;"></i>
                                    <span style="font-size:.75rem;">Klik untuk ganti</span>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="upload-zone" onclick="document.getElementById('image').click()">
                            <i class="fa-solid fa-cloud-arrow-up" style="font-size:1.6rem;color:#DBEAFE;"></i>
                            <span style="font-size:.8rem;">Klik untuk upload gambar</span>
                            <span style="font-size:.72rem;color:#D1D5DB;">JPG, PNG, WebP — Maks 3MB</span>
                        </div>
                        <img id="image-preview" src="" alt="" class="img-fluid" style="border-radius:10px;display:none;max-height:210px;object-fit:cover;width:100%;margin-top:0;">
                        @endif
                    </div>

                    <div>
                        <label class="field-label">Ganti Gambar</label>
                        <input type="file" name="image" id="image"
                               class="form-control @error('image') is-invalid @enderror"
                               accept="image/jpg,image/jpeg,image/png,image/webp"
                               onchange="previewImage(event)">
                        <p style="font-size:.72rem;color:#9CA3AF;margin-top:5px;">
                            Kosongkan jika tidak ingin mengganti.
                        </p>
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Detail --}}
        <div class="col-lg-8">
            <p class="section-label">Detail Portofolio</p>
            <div class="card tg-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title"><i class="fa-solid fa-pen me-2 text-primary"></i>Edit Portofolio</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('portfolios.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;font-size:.78rem;">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-sm btn-primary" style="border-radius:8px;font-size:.78rem;">
                            <i class="fa-solid fa-save me-1"></i> Update
                        </button>
                    </div>
                </div>
                <div class="card-body">

                    @if($errors->any())
                    <div class="alert alert-danger mb-3" style="border-radius:10px;border:none;font-size:.84rem;">
                        <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                    @endif

                    {{-- Meta info --}}
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <span class="meta-pill"><i class="fa-solid fa-hashtag" style="font-size:.65rem;"></i> ID #{{ $portofolio->id }}</span>
                        <span class="meta-pill"><i class="fa-solid fa-clock" style="font-size:.65rem;"></i> Dibuat {{ \Carbon\Carbon::parse($portofolio->created_at)->isoFormat('D MMM YYYY') }}</span>
                        @if($portofolio->is_active)
                            <span style="background:#D1FAE5;color:#065F46;font-size:.7rem;font-weight:700;padding:3px 10px;border-radius:100px;">Aktif</span>
                        @else
                            <span style="background:#F3F4F6;color:#6B7280;font-size:.7rem;font-weight:700;padding:3px 10px;border-radius:100px;">Nonaktif</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="field-label">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                               placeholder="Judul portofolio..."
                               value="{{ old('title', $portofolio->title) }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="field-label">Kategori <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="" disabled>Pilih Kategori</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ old('category_id', $portofolio->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="field-label">Deskripsi</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                  rows="5" placeholder="Deskripsi portofolio...">{{ old('description', $portofolio->description) }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div style="background:#F9FAFB;border-radius:10px;padding:12px 14px;border:1px solid #F3F4F6;">
                        <input type="hidden" name="is_active" value="0">
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                                   {{ old('is_active', $portofolio->is_active ? '1' : '0') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active" style="font-size:.84rem;font-weight:600;">
                                Tampilkan di halaman publik
                            </label>
                        </div>
                        <p style="font-size:.74rem;color:#9CA3AF;margin:5px 0 0 28px;">
                            Portofolio nonaktif tidak tampil di website customer.
                        </p>
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
        preview.src = e.target.result;
        preview.style.display = 'block';
        const placeholder = document.querySelector('.upload-zone');
        if (placeholder) placeholder.style.display = 'none';
    };
    reader.readAsDataURL(file);
}
</script>
@endsection
