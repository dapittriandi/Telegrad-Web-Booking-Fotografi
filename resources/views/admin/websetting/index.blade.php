@extends('base.base-admin-index')

@php $menu = 'Pengaturan'; $submenu = 'Pengaturan Website'; $subdesc = 'Kelola identitas, media, dan informasi website'; @endphp

@section('custom-css')
<style>
    @font-face { font-family:"Font Awesome 6 Free"; font-weight:900; font-display:block; src:url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/webfonts/fa-solid-900.woff2") format("woff2"); }
    @font-face { font-family:"Font Awesome 6 Brands"; font-weight:400; font-display:block; src:url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/webfonts/fa-brands-400.woff2") format("woff2"); }
    .fa-solid,.fas { font-family:"Font Awesome 6 Free"!important; font-weight:900!important; }
    .fa-brands,.fab { font-family:"Font Awesome 6 Brands"!important; font-weight:400!important; }

    /* ── Core card ── */
    .tg-card { border:none!important; border-radius:14px!important; box-shadow:0 1px 3px rgba(0,0,0,.06),0 4px 16px rgba(0,0,0,.05)!important; margin-bottom:16px; }
    .tg-card .card-header { background:#fff!important; border-bottom:1px solid #F3F4F6!important; padding:14px 20px!important; }
    .tg-card .card-header .card-title { font-size:.9rem!important; font-weight:700!important; color:#111827!important; margin:0; display:flex; align-items:center; gap:8px; }
    .tg-card .card-body { padding:20px!important; }

    /* ── Labels & inputs ── */
    .field-label { font-size:.79rem; font-weight:600; color:#374151; margin-bottom:5px; display:block; }
    .field-hint  { font-size:.72rem; color:#9CA3AF; margin-top:4px; }
    .section-label { font-size:.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.1em; color:#9CA3AF; margin-bottom:10px; }
    .form-control:focus, .form-select:focus { border-color:#2563EB; box-shadow:0 0 0 3px rgba(37,99,235,.1); }

    /* ── Image upload cards ── */
    .img-upload-box { border-radius:10px; overflow:hidden; background:#F9FAFB; border:1.5px dashed #E5E7EB; padding:12px; text-align:center; transition:border-color .2s; }
    .img-upload-box:hover { border-color:#2563EB; background:#EFF6FF; }
    .img-upload-box img { max-height:130px; object-fit:contain; border-radius:8px; display:block; margin:0 auto 10px; }

    /* ── Social media inputs ── */
    .social-row { display:flex; align-items:center; gap:10px; background:#F9FAFB; border-radius:10px; padding:10px 14px; border:1px solid #F3F4F6; margin-bottom:8px; }
    .social-icon { width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:.9rem; flex-shrink:0; }
    .social-row .form-control { background:#fff; border:1px solid #E5E7EB; font-size:.82rem; }

    /* ── Bank preview ── */
    .bank-preview { background:linear-gradient(135deg,#1E3A8A,#2563EB); border-radius:12px; padding:14px 16px; color:#fff; margin-top:12px; }
    .bank-preview .bp-label { font-size:.65rem; text-transform:uppercase; letter-spacing:.08em; opacity:.7; margin-bottom:2px; }
    .bank-preview .bp-value { font-size:.88rem; font-weight:700; }

    /* ── Slider grid ── */
    .slider-item { background:#F9FAFB; border-radius:10px; border:1.5px dashed #E5E7EB; padding:10px; text-align:center; transition:border-color .2s; }
    .slider-item:hover { border-color:#2563EB; background:#EFF6FF; }
    .slider-item img { width:100%; height:90px; object-fit:cover; border-radius:7px; display:block; margin-bottom:8px; }
    .slider-item .slider-num { font-size:.68rem; font-weight:700; color:#9CA3AF; text-transform:uppercase; letter-spacing:.06em; margin-bottom:6px; }

    /* ── Save button bar ── */
    .save-btn { border-radius:8px; font-size:.82rem; font-weight:600; padding:7px 20px; }

    /* ── Maps textarea ── */
    .maps-textarea { font-size:.78rem; font-family:monospace; background:#F9FAFB; }
</style>
@endsection

@section('content')

@if(session('success'))
<div class="alert alert-success mb-3" style="border-radius:10px;border:none;font-size:.84rem;">
    <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
</div>
@endif
@if($errors->any())
<div class="alert alert-danger mb-3" style="border-radius:10px;border:none;font-size:.84rem;">
    <i class="fa-solid fa-exclamation-circle me-1"></i>
    <ul class="mb-0 mt-1 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
</div>
@endif

<form action="{{ route('admin.websetting.update') }}" method="POST" enctype="multipart/form-data">
    @csrf @method('POST')

    <div class="row g-3">

        {{-- ════════════════════════════════════════
             KOLOM KIRI
        ════════════════════════════════════════ --}}
        <div class="col-lg-4">

            {{-- Logo --}}
            <p class="section-label">Media</p>
            <div class="card tg-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">
                        <i class="fa-solid fa-image text-primary"></i> Logo Website
                    </h5>
                    <button type="submit" class="btn btn-sm btn-primary save-btn">
                        <i class="fa-solid fa-save me-1"></i> Simpan
                    </button>
                </div>
                <div class="card-body">
                    <div class="img-upload-box" onclick="document.getElementById('site_logo').click()" style="cursor:pointer;">
                        <img id="preview-site_logo"
                             src="{{ asset('storage/images/default/'.($web->site_logo ?? 'site_logo.png')) }}"
                             alt="Logo">
                        <p style="font-size:.72rem;color:#9CA3AF;margin:0;">
                            <i class="fa-solid fa-cloud-arrow-up me-1"></i> Klik untuk ganti logo
                        </p>
                    </div>
                    <input type="file" name="site_logo" id="site_logo" class="form-control mt-2 form-control-sm"
                           accept="image/*" onchange="previewImage(event,'site_logo')">
                    @error('site_logo')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
            </div>

            {{-- QRIS --}}
            <div class="card tg-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">
                        <i class="fa-solid fa-qrcode text-primary"></i> QRIS Pembayaran
                    </h5>
                    <button type="submit" class="btn btn-sm btn-primary save-btn">
                        <i class="fa-solid fa-save me-1"></i> Simpan
                    </button>
                </div>
                <div class="card-body">
                    <div class="img-upload-box" onclick="document.getElementById('site_qris').click()" style="cursor:pointer;">
                        <img id="preview-site_qris"
                             src="{{ asset('storage/images/default/'.($web->site_qris ?? 'site_qris.png')) }}"
                             alt="QRIS" style="max-height:180px;">
                        <p style="font-size:.72rem;color:#9CA3AF;margin:0;">
                            <i class="fa-solid fa-cloud-arrow-up me-1"></i> Klik untuk ganti QRIS
                        </p>
                    </div>
                    <input type="file" name="site_qris" id="site_qris" class="form-control mt-2 form-control-sm"
                           accept="image/*" onchange="previewImage(event,'site_qris')">
                    @error('site_qris')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
            </div>

            {{-- Rekening Bank --}}
            <div class="card tg-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">
                        <i class="fa-solid fa-building-columns text-primary"></i> Rekening Bank
                    </h5>
                    <button type="submit" class="btn btn-sm btn-primary save-btn">
                        <i class="fa-solid fa-save me-1"></i> Simpan
                    </button>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="field-label">Nama Bank</label>
                        <input type="text" name="bank_name" class="form-control"
                               placeholder="Contoh: BCA, BRI, Mandiri..."
                               value="{{ old('bank_name', $web->bank_name) }}">
                    </div>
                    <div class="mb-3">
                        <label class="field-label">Nomor Rekening</label>
                        <input type="text" name="bank_account_number" class="form-control"
                               placeholder="1234567890"
                               value="{{ old('bank_account_number', $web->bank_account_number) }}">
                    </div>
                    <div class="mb-3">
                        <label class="field-label">Atas Nama</label>
                        <input type="text" name="bank_account_name" class="form-control"
                               placeholder="Nama pemilik rekening"
                               value="{{ old('bank_account_name', $web->bank_account_name) }}">
                    </div>

                    @if($web->bank_name && $web->bank_account_number)
                    <div class="bank-preview">
                        <p class="bp-label">Preview Info Rekening</p>
                        <p class="bp-value">{{ $web->bank_name }}</p>
                        <p style="font-size:.8rem;opacity:.85;margin:2px 0;">{{ $web->bank_account_number }}</p>
                        <p style="font-size:.76rem;opacity:.7;margin:0;">a/n {{ $web->bank_account_name }}</p>
                    </div>
                    @endif
                </div>
            </div>

        </div>

        {{-- ════════════════════════════════════════
             KOLOM KANAN
        ════════════════════════════════════════ --}}
        <div class="col-lg-8">

            {{-- Identitas Website --}}
            <p class="section-label">Identitas Website</p>
            <div class="card tg-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">
                        <i class="fa-solid fa-globe text-primary"></i> Informasi Website
                    </h5>
                    <button type="submit" class="btn btn-sm btn-primary save-btn">
                        <i class="fa-solid fa-save me-1"></i> Simpan
                    </button>
                </div>
                <div class="card-body">
                    <div class="row g-3">

                        <div class="col-lg-6">
                            <label class="field-label">Nama Website <span class="text-danger">*</span></label>
                            <input type="text" name="site_name" class="form-control"
                                   placeholder="Nama website..." value="{{ old('site_name', $web->site_name) }}">
                            @error('site_name')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>

                        <div class="col-lg-6">
                            <label class="field-label">Link Website</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white" style="font-size:.78rem;color:#9CA3AF;">https://</span>
                                <input type="text" name="site_link" class="form-control"
                                       placeholder="telegrad.id"
                                       value="{{ old('site_link', $web->site_link) }}">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <label class="field-label">Tag Line / Headline</label>
                            <input type="text" name="site_head" class="form-control"
                                   placeholder="Abadikan Momen Wisudamu"
                                   value="{{ old('site_head', $web->site_head) }}">
                        </div>

                        <div class="col-lg-6">
                            <label class="field-label">Deskripsi Website</label>
                            <input type="text" name="site_description" class="form-control"
                                   placeholder="Deskripsi singkat..."
                                   value="{{ old('site_description', $web->site_description) }}">
                        </div>

                        <div class="col-lg-6">
                            <label class="field-label">Alamat Jalan</label>
                            <input type="text" name="site_street" class="form-control"
                                   placeholder="Jl. Contoh No. 1"
                                   value="{{ old('site_street', $web->site_street) }}">
                        </div>

                        <div class="col-lg-6">
                            <label class="field-label">Kode Pos</label>
                            <input type="text" name="site_poscod" class="form-control"
                                   placeholder="36111"
                                   value="{{ old('site_poscod', $web->site_poscod) }}">
                        </div>

                        <div class="col-lg-6">
                            <label class="field-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white" style="font-size:.8rem;">
                                    <i class="fa-solid fa-envelope" style="color:#9CA3AF;"></i>
                                </span>
                                <input type="email" name="site_email" class="form-control"
                                       placeholder="telegrad@email.com"
                                       value="{{ old('site_email', $web->site_email) }}">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <label class="field-label">Nomor Telepon</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white" style="font-size:.8rem;">
                                    <i class="fa-solid fa-phone" style="color:#9CA3AF;"></i>
                                </span>
                                <input type="text" name="site_phone" class="form-control"
                                       placeholder="08123456789"
                                       value="{{ old('site_phone', $web->site_phone) }}">
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Sosial Media --}}
            <p class="section-label mt-2">Media Sosial</p>
            <div class="card tg-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">
                        <i class="fa-solid fa-share-nodes text-primary"></i> Akun Sosial Media
                    </h5>
                    <button type="submit" class="btn btn-sm btn-primary save-btn">
                        <i class="fa-solid fa-save me-1"></i> Simpan
                    </button>
                </div>
                <div class="card-body">

                    <div class="social-row">
                        <div class="social-icon" style="background:#EFF6FF;">
                            <i class="fa-brands fa-facebook" style="color:#2563EB;"></i>
                        </div>
                        <div style="flex:1;">
                            <label class="field-label" style="margin-bottom:3px;">Facebook</label>
                            <input type="url" name="facebook" class="form-control"
                                   placeholder="https://facebook.com/..."
                                   value="{{ old('facebook', $web->facebook) }}">
                        </div>
                    </div>

                    <div class="social-row">
                        <div class="social-icon" style="background:#FFF0F5;">
                            <i class="fa-brands fa-instagram" style="color:#E1306C;"></i>
                        </div>
                        <div style="flex:1;">
                            <label class="field-label" style="margin-bottom:3px;">Instagram</label>
                            <input type="url" name="instagram" class="form-control"
                                   placeholder="https://instagram.com/..."
                                   value="{{ old('instagram', $web->instagram) }}">
                        </div>
                    </div>

                    <div class="social-row" style="margin-bottom:0;">
                        <div class="social-icon" style="background:#F3F4F6;">
                            <i class="fa-brands fa-tiktok" style="color:#111827;"></i>
                        </div>
                        <div style="flex:1;">
                            <label class="field-label" style="margin-bottom:3px;">TikTok</label>
                            <input type="url" name="tiktok" class="form-control"
                                   placeholder="https://tiktok.com/@..."
                                   value="{{ old('tiktok', $web->tiktok) }}">
                        </div>
                    </div>

                </div>
            </div>

            {{-- Google Maps --}}
            <p class="section-label mt-2">Lokasi</p>
            <div class="card tg-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">
                        <i class="fa-solid fa-location-dot text-primary"></i> Embed Google Maps
                    </h5>
                    <button type="submit" class="btn btn-sm btn-primary save-btn">
                        <i class="fa-solid fa-save me-1"></i> Simpan
                    </button>
                </div>
                <div class="card-body">
                    <label class="field-label">Kode Embed iFrame</label>
                    <textarea name="site_locate" class="form-control maps-textarea" rows="4"
                              placeholder='<iframe src="https://maps.google.com/..." ...></iframe>'>{{ old('site_locate', $web->site_locate) }}</textarea>
                    <p class="field-hint"><i class="fa-solid fa-circle-info me-1"></i>Buka Google Maps → Share → Embed a map → salin kode &lt;iframe&gt;.</p>

                    @if($web->site_locate)
                    <div class="mt-3" style="border-radius:10px;overflow:hidden;border:1px solid #F3F4F6;">
                        {!! $web->site_locate !!}
                    </div>
                    @endif
                </div>
            </div>

        </div>

        {{-- ════════════════════════════════════════
             SLIDER IMAGES — Full width
        ════════════════════════════════════════ --}}
        <div class="col-12">
            <p class="section-label">Hero Slider</p>
            <div class="card tg-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title">
                        <i class="fa-solid fa-images text-primary"></i> Slider Beranda
                    </h5>
                    <button type="submit" class="btn btn-sm btn-primary save-btn">
                        <i class="fa-solid fa-save me-1"></i> Simpan Semua Slider
                    </button>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach(['slider_1','slider_2','slider_3','slider_4','slider_5'] as $slider)
                        <div class="col-lg col-md-4 col-6">
                            <div class="slider-item">
                                <p class="slider-num">Slider {{ $loop->iteration }}</p>
                                <img id="preview-{{ $slider }}"
                                     src="{{ asset('storage/images/default/'.($web->$slider ?? 'default.jpg')) }}"
                                     alt="Slider {{ $loop->iteration }}"
                                     onclick="document.getElementById('{{ $slider }}').click()"
                                     style="cursor:pointer;" title="Klik untuk ganti">
                                <input type="file" name="{{ $slider }}" id="{{ $slider }}"
                                       class="form-control form-control-sm" accept="image/*"
                                       onchange="previewImage(event,'{{ $slider }}')">
                                @error($slider)<small class="text-danger d-block mt-1">{{ $message }}</small>@enderror
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <p class="field-hint mt-3">
                        <i class="fa-solid fa-circle-info me-1"></i>
                        Klik gambar untuk memilih file baru. Rasio ideal: 16:9 atau 21:9. Maks 2MB per gambar.
                    </p>
                </div>
            </div>
        </div>

    </div>
</form>

@endsection

@section('custom-js')
<script>
function previewImage(event, id) {
    const reader = new FileReader();
    reader.onload = function() {
        const preview = document.getElementById('preview-' + id);
        if (preview) preview.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection
