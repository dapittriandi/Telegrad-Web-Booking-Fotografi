@extends('base.base-admin-index')

@php $menu = 'Portofolio'; $submenu = 'Edit Portofolio'; $subdesc = 'Edit: ' . $portofolio->title; @endphp

@section('custom-css')
<style>
/* ── Icon Fix ── */
@font-face { font-family:"Font Awesome 6 Free"; font-weight:900; font-display:block; src:url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/webfonts/fa-solid-900.woff2") format("woff2"); }
.fa-solid,.fas{font-family:"Font Awesome 6 Free"!important;font-weight:900!important;}

/* ── Page Banner ── */
.porto-banner {
    background: linear-gradient(135deg, #0A1628 0%, #1E3A8A 55%, #2563EB 100%);
    border-radius: 16px; padding: 20px 24px; margin-bottom: 20px;
    position: relative; overflow: hidden;
    box-shadow: 0 4px 24px rgba(37,99,235,.22);
}
.porto-banner::before {
    content:''; position:absolute; top:-30px; right:-30px;
    width:180px; height:180px; border-radius:50%; background:rgba(255,255,255,.05);
}
.porto-banner::after {
    content:''; position:absolute; bottom:-40px; right:80px;
    width:120px; height:120px; border-radius:50%; background:rgba(255,255,255,.04);
}
.porto-banner-title { font-size:1.1rem; font-weight:800; color:#fff; letter-spacing:-.02em; margin-bottom:4px; }
.porto-banner-sub   { font-size:.78rem; color:rgba(255,255,255,.55); margin:0; }
.porto-banner-actions { display:flex; gap:8px; flex-wrap:wrap; margin-top:14px; padding-top:14px; border-top:1px solid rgba(255,255,255,.1); }
.banner-btn {
    display:inline-flex; align-items:center; gap:6px;
    font-size:.73rem; font-weight:600; color:rgba(255,255,255,.85);
    background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.18);
    padding:6px 14px; border-radius:8px; text-decoration:none;
    transition:background .15s, transform .15s; line-height:1;
}
.banner-btn:hover { background:rgba(255,255,255,.2); color:#fff; transform:translateY(-1px); text-decoration:none; }
.banner-btn-solid {
    background:#fff; color:#1E3A8A; border:1px solid transparent; font-weight:700;
}
.banner-btn-solid:hover { background:rgba(255,255,255,.9); color:#1E3A8A; }

/* ── Meta pills in banner ── */
.banner-meta { display:flex; gap:8px; flex-wrap:wrap; margin-top:12px; }
.banner-meta-pill {
    display:inline-flex; align-items:center; gap:5px;
    background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.15);
    color:rgba(255,255,255,.75); font-size:.7rem; font-weight:600;
    padding:3px 10px; border-radius:100px;
}
.banner-meta-pill.active  { background:rgba(209,250,229,.2); border-color:rgba(110,231,183,.3); color:#6EE7B7; }
.banner-meta-pill.inactive { background:rgba(255,255,255,.07); color:rgba(255,255,255,.45); }

/* ── Cards ── */
.tg-card {
    border:1px solid var(--tg-glass-border, #F3F4F6)!important;
    border-radius:14px!important;
    box-shadow:0 1px 3px rgba(0,0,0,.06),0 4px 16px rgba(0,0,0,.05)!important;
    background:var(--tg-glass, #fff);
    backdrop-filter:var(--tg-blur, none);
    overflow:hidden;
}
.tg-card-head {
    background:linear-gradient(135deg,#0A1628,#1E3A8A);
    padding:13px 18px;
    display:flex; align-items:center; gap:8px;
}
.tg-card-head h5 { color:#fff; font-size:.88rem; font-weight:700; margin:0; display:flex; align-items:center; gap:7px; line-height:1; }
.tg-card-body { padding:20px; }

/* ── Form fields ── */
.field-label { font-size:.78rem; font-weight:700; color:var(--tg-text-2,#374151); margin-bottom:6px; display:block; }
.field-label .req { color:#EF4444; }
.form-control, .form-select {
    font-size:.84rem; border-radius:9px;
    border:1.5px solid var(--tg-border, #E5E7EB);
    background:var(--tg-glass,#fff); color:var(--tg-text,#111827);
    padding:9px 12px; transition:border-color .2s, box-shadow .2s;
}
.form-control:focus, .form-select:focus {
    border-color:#2563EB; box-shadow:0 0 0 3px rgba(37,99,235,.1);
    background:var(--tg-glass,#fff);
}

/* ── Current image wrapper ── */
.img-current-wrap {
    position:relative; border-radius:12px; overflow:hidden; cursor:pointer;
}
.img-current-wrap img {
    width:100%; max-height:210px; object-fit:cover; display:block; border-radius:12px;
}
.img-current-overlay {
    position:absolute; inset:0;
    background:rgba(0,0,0,.4);
    display:flex; align-items:center; justify-content:center; flex-direction:column; gap:6px;
    opacity:0; transition:opacity .2s; border-radius:12px;
}
.img-current-wrap:hover .img-current-overlay { opacity:1; }
.img-current-overlay i { color:#fff; font-size:1.3rem; }
.img-current-overlay span { color:rgba(255,255,255,.9); font-size:.74rem; font-weight:600; }

/* ── Upload Zone ── */
.upload-zone {
    height:190px; background:var(--tg-glass,#F9FAFB);
    border:2px dashed var(--tg-border,#E5E7EB);
    border-radius:12px;
    display:flex; align-items:center; justify-content:center;
    flex-direction:column; gap:8px; color:var(--tg-text-3,#9CA3AF);
    cursor:pointer; transition:border-color .2s, background .2s;
}
.upload-zone:hover { border-color:#2563EB; background:#EFF6FF; }
.upload-zone .icon-wrap {
    width:48px; height:48px; border-radius:12px;
    background:linear-gradient(135deg,#DBEAFE,#EFF6FF);
    display:flex; align-items:center; justify-content:center;
}
.upload-zone .icon-wrap i { color:#2563EB; font-size:1.25rem; }

/* ── Toggle ── */
.toggle-wrap {
    background:var(--tg-glass,#F9FAFB);
    border:1.5px solid var(--tg-border,#F3F4F6);
    border-radius:10px; padding:12px 14px;
}

/* ── Section label ── */
.section-label { font-size:.63rem; font-weight:700; text-transform:uppercase; letter-spacing:.1em; color:var(--tg-text-3,#9CA3AF); margin-bottom:10px; }

/* ── Error alert ── */
.tg-alert-danger {
    background:#FEE2E2; color:#991B1B; border:none; border-radius:10px;
    font-size:.83rem; padding:10px 14px; margin-bottom:16px;
    display:flex; gap:8px; align-items:flex-start;
}
[data-theme="dark"] .tg-alert-danger { background:rgba(254,226,226,.12); color:#FCA5A5; }
</style>
@endsection

@section('content')

{{-- ── Banner ── --}}
<div class="porto-banner mb-4">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:12px;">
        <div style="flex:1;min-width:0;">
            <h2 class="porto-banner-title"><i class="fa-solid fa-pen-to-square me-2" style="opacity:.8;"></i>Edit Portofolio</h2>
            <p class="porto-banner-sub" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $portofolio->title }}</p>
        </div>
    </div>
    <div class="banner-meta">
        <span class="banner-meta-pill"><i class="fa-solid fa-hashtag" style="font-size:.62rem;"></i> ID #{{ $portofolio->id }}</span>
        <span class="banner-meta-pill"><i class="fa-solid fa-clock" style="font-size:.62rem;"></i> {{ \Carbon\Carbon::parse($portofolio->created_at)->isoFormat('D MMM YYYY') }}</span>
        @if($portofolio->is_active)
            <span class="banner-meta-pill active"><i class="fa-solid fa-circle" style="font-size:.42rem;"></i> Aktif</span>
        @else
            <span class="banner-meta-pill inactive"><i class="fa-solid fa-circle" style="font-size:.42rem;"></i> Nonaktif</span>
        @endif
    </div>
    <div class="porto-banner-actions">
        <a href="{{ route('portfolios.index') }}" class="banner-btn">
            <i class="fa-solid fa-arrow-left" style="font-size:.72rem;"></i> Kembali ke Daftar
        </a>
    </div>
</div>

<form action="{{ route('portfolios.update', $portofolio->id) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    <div class="row g-3">

        {{-- ── Gambar ── --}}
        <div class="col-lg-4">
            <p class="section-label">Gambar Portofolio</p>
            <div class="tg-card">
                <div class="tg-card-head">
                    <h5><i class="fa-solid fa-image" style="font-size:.82rem;"></i> Gambar</h5>
                </div>
                <div class="tg-card-body">

                    <div class="mb-3">
                        @if($portofolio->image)
                        <div class="img-current-wrap mb-2" onclick="document.getElementById('image').click()">
                            <img id="image-preview"
                                 src="{{ asset('storage/images/portofolio/'.$portofolio->image) }}"
                                 alt="{{ $portofolio->title }}">
                            <div class="img-current-overlay">
                                <i class="fa-solid fa-camera"></i>
                                <span>Klik untuk ganti</span>
                            </div>
                        </div>
                        @else
                        <div class="upload-zone mb-2" onclick="document.getElementById('image').click()">
                            <div class="icon-wrap">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                            </div>
                            <span style="font-size:.82rem;font-weight:600;color:var(--tg-text-2,#374151);">Klik untuk upload</span>
                            <span style="font-size:.72rem;">JPG, PNG, WebP — Maks 3MB</span>
                        </div>
                        <img id="image-preview" src="" alt="" class="img-fluid w-100"
                             style="border-radius:12px;display:none;max-height:210px;object-fit:cover;">
                        @endif
                    </div>

                    <div>
                        <label class="field-label">Ganti Gambar</label>
                        <input type="file" name="image" id="image"
                               class="form-control @error('image') is-invalid @enderror"
                               accept="image/jpg,image/jpeg,image/png,image/webp"
                               onchange="previewImage(event)">
                        <p style="font-size:.72rem;color:var(--tg-text-3,#9CA3AF);margin-top:6px;margin-bottom:0;">
                            <i class="fa-solid fa-circle-info" style="font-size:.65rem;"></i>
                            Kosongkan jika tidak ingin mengganti.
                        </p>
                        @error('image')<div class="invalid-feedback" style="font-size:.78rem;">{{ $message }}</div>@enderror
                    </div>

                </div>
            </div>
        </div>

        {{-- ── Detail ── --}}
        <div class="col-lg-8">
            <p class="section-label">Detail Portofolio</p>
            <div class="tg-card">
                <div class="tg-card-head">
                    <h5><i class="fa-solid fa-pen" style="font-size:.82rem;"></i> Edit Informasi</h5>
                </div>
                <div class="tg-card-body">

                    @if($errors->any())
                    <div class="tg-alert-danger">
                        <i class="fa-solid fa-triangle-exclamation" style="flex-shrink:0;margin-top:1px;"></i>
                        <ul class="mb-0 ps-2">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label class="field-label">Judul <span class="req">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                               placeholder="Judul portofolio..."
                               value="{{ old('title', $portofolio->title) }}" required>
                        @error('title')<div class="invalid-feedback" style="font-size:.78rem;">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="field-label">Kategori <span class="req">*</span></label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="" disabled>Pilih Kategori</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ old('category_id', $portofolio->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback" style="font-size:.78rem;">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="field-label">Deskripsi</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                  rows="5" placeholder="Deskripsi singkat portofolio...">{{ old('description', $portofolio->description) }}</textarea>
                        @error('description')<div class="invalid-feedback" style="font-size:.78rem;">{{ $message }}</div>@enderror
                    </div>

                    <div class="toggle-wrap">
                        <input type="hidden" name="is_active" value="0">
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                                   {{ old('is_active', $portofolio->is_active ? '1' : '0') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active" style="font-size:.84rem;font-weight:700;color:var(--tg-text,#111827);">
                                Tampilkan di halaman publik
                            </label>
                        </div>
                        <p style="font-size:.73rem;color:var(--tg-text-3,#9CA3AF);margin:5px 0 0 28px;">
                            Portofolio nonaktif tidak tampil di website customer.
                        </p>
                    </div>

                    <div class="d-flex gap-2 justify-content-end mt-4 pt-3" style="border-top:1px solid var(--tg-border,#F3F4F6);">
                        <a href="{{ route('portfolios.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;font-size:.78rem;padding:7px 16px;">
                            <i class="fa-solid fa-xmark me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-sm btn-primary" style="border-radius:8px;font-size:.78rem;padding:7px 16px;">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Update Portofolio
                        </button>
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