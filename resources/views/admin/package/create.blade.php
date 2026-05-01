@extends('base.base-admin-index')

@php $menu = 'Paket'; $submenu = 'Tambah Paket'; $subdesc = 'Buat paket foto baru'; @endphp

@section('custom-css')
<style>
    @font-face { font-family:"Font Awesome 6 Free"; font-weight:900; font-display:block; src:url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/webfonts/fa-solid-900.woff2") format("woff2"); }
    .fa-solid,.fas{font-family:"Font Awesome 6 Free"!important;font-weight:900!important;}

    .tg-card { border:none!important; border-radius:14px!important; box-shadow:0 1px 3px rgba(0,0,0,.06),0 4px 16px rgba(0,0,0,.05)!important; }
    .tg-card .card-header { background:#fff!important; border-bottom:1px solid #F3F4F6!important; padding:15px 20px!important; }
    .tg-card .card-header .card-title { font-size:.95rem!important; font-weight:700!important; color:#111827!important; margin:0; }
    .tg-card .card-body { padding:20px!important; }

    .section-label { font-size:.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.1em; color:#9CA3AF; margin-bottom:10px; }
    .field-label { font-size:.8rem; font-weight:600; color:#374151; margin-bottom:5px; }

    .side-info-card { background:#F9FAFB; border-radius:12px; padding:16px; border:1px solid #F3F4F6; margin-bottom:12px; }
    .side-info-card h6 { font-size:.8rem; font-weight:700; color:#374151; margin-bottom:12px; }

    .features-hint { background:#EFF6FF; border-radius:8px; padding:10px 14px; border-left:3px solid #2563EB; font-size:.78rem; color:#1E40AF; margin-bottom:8px; }
</style>
@endsection

@section('content')

<form action="{{ route('packages.store') }}" method="POST">
    @csrf

    <div class="row g-3">

        {{-- Kolom Utama --}}
        <div class="col-lg-8">
            <p class="section-label">Informasi Paket</p>
            <div class="card tg-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title"><i class="fa-solid fa-camera me-2 text-primary"></i>Detail Paket</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('packages.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;font-size:.78rem;">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-sm btn-primary" style="border-radius:8px;font-size:.78rem;">
                            <i class="fa-solid fa-save me-1"></i> Simpan Paket
                        </button>
                    </div>
                </div>
                <div class="card-body">

                    @if($errors->any())
                    <div class="alert alert-danger mb-3" style="border-radius:10px;border:none;font-size:.84rem;">
                        <i class="fa-solid fa-exclamation-circle me-1"></i>
                        <strong>Ada kesalahan input:</strong>
                        <ul class="mb-0 mt-1 ps-3">
                            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="row g-3">

                        {{-- Nama --}}
                        <div class="col-12">
                            <label class="field-label">Nama Paket <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Contoh: Paket Wisuda Personal A"
                                   value="{{ old('name') }}">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Kategori --}}
                        <div class="col-lg-6">
                            <label class="field-label">Kategori <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                <option value="" disabled selected>Pilih kategori...</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Harga --}}
                        <div class="col-lg-6">
                            <label class="field-label">Harga (Rp) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white" style="font-size:.82rem;color:#6B7280;">Rp</span>
                                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                                       placeholder="250000" min="0" value="{{ old('price') }}">
                            </div>
                            @error('price')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        {{-- Durasi --}}
                        <div class="col-lg-6">
                            <label class="field-label">Durasi (menit) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="duration" class="form-control @error('duration') is-invalid @enderror"
                                       placeholder="60" min="1" value="{{ old('duration') }}">
                                <span class="input-group-text bg-white" style="font-size:.82rem;color:#6B7280;">menit</span>
                            </div>
                            @error('duration')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>

                        {{-- Peserta --}}
                        <div class="col-lg-6">
                            <label class="field-label">Keterangan Peserta <span class="text-danger">*</span></label>
                            <input type="text" name="participants" class="form-control @error('participants') is-invalid @enderror"
                                   placeholder="Contoh: Personal (1 orang)"
                                   value="{{ old('participants') }}">
                            @error('participants')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Fitur --}}
                        <div class="col-12">
                            <label class="field-label">Fitur Paket</label>
                            <div class="features-hint">
                                <i class="fa-solid fa-circle-info me-1"></i>
                                Pisahkan setiap fitur dengan Enter. Contoh: <em>30 foto edit, All file mentahan via drive</em>
                            </div>
                            <textarea name="features" class="form-control @error('features') is-invalid @enderror"
                                      rows="6"
                                      placeholder="Foto sepuasnya selama sesi&#10;30 foto edit&#10;All file mentahan kirim via drive&#10;Free revisi 1x">{{ old('features') }}</textarea>
                            @error('features')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan --}}
        <div class="col-lg-4">
            <p class="section-label">Pengaturan</p>

            {{-- Peserta --}}
            <div class="card tg-card mb-3">
                <div class="card-header">
                    <h5 class="card-title"><i class="fa-solid fa-users me-2" style="color:#2563EB;"></i>Batas Peserta</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="field-label">Min. Peserta</label>
                            <input type="number" name="min_participants" class="form-control @error('min_participants') is-invalid @enderror"
                                   value="{{ old('min_participants', 1) }}" min="1">
                            @error('min_participants')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-6">
                            <label class="field-label">Maks. Peserta</label>
                            <input type="number" name="max_participants" class="form-control @error('max_participants') is-invalid @enderror"
                                   placeholder="—" min="1" value="{{ old('max_participants') }}">
                            @error('max_participants')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <input type="hidden" name="unlimited_participants" value="0">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="unlimited_participants"
                                       id="unlimited" value="1" {{ old('unlimited_participants') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="unlimited" style="font-size:.82rem;">Peserta tidak terbatas</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Status --}}
            <div class="card tg-card">
                <div class="card-header">
                    <h5 class="card-title"><i class="fa-solid fa-toggle-on me-2" style="color:#059669;"></i>Status Paket</h5>
                </div>
                <div class="card-body">
                    <input type="hidden" name="is_active" value="0">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                               value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active" style="font-size:.84rem;font-weight:600;">
                            Paket aktif & tampil di website
                        </label>
                    </div>
                    <p style="font-size:.76rem;color:#9CA3AF;margin-top:8px;margin-bottom:0;">
                        Paket non-aktif tidak bisa dipesan oleh customer.
                    </p>
                </div>
            </div>
        </div>

    </div>
</form>

@endsection