@extends('base.base-admin-index')

@php $menu = 'Paket'; $submenu = 'Edit Paket'; $subdesc = 'Ubah informasi paket: ' . $package->name; @endphp

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
    .features-hint { background:#EFF6FF; border-radius:8px; padding:10px 14px; border-left:3px solid #2563EB; font-size:.78rem; color:#1E40AF; margin-bottom:8px; }

    .meta-pill { display:inline-flex; align-items:center; gap:6px; background:#F3F4F6; color:#374151; font-size:.76rem; font-weight:600; padding:4px 12px; border-radius:100px; }
</style>
@endsection

@section('content')

<form action="{{ route('packages.update', $package->id) }}" method="POST">
    @csrf @method('PUT')

    <div class="row g-3">

        {{-- Kolom Utama --}}
        <div class="col-lg-8">
            <p class="section-label">Informasi Paket</p>
            <div class="card tg-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title"><i class="fa-solid fa-pen me-2 text-primary"></i>Edit: {{ $package->name }}</h5>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('packages.index') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px;font-size:.78rem;">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-sm btn-primary" style="border-radius:8px;font-size:.78rem;">
                            <i class="fa-solid fa-save me-1"></i> Update Paket
                        </button>
                    </div>
                </div>
                <div class="card-body">

                    @if(session('success'))
                    <div class="alert alert-success mb-3" style="border-radius:10px;border:none;font-size:.84rem;">
                        <i class="fa-solid fa-check-circle me-1"></i> {{ session('success') }}
                    </div>
                    @endif
                    @if($errors->any())
                    <div class="alert alert-danger mb-3" style="border-radius:10px;border:none;font-size:.84rem;">
                        <i class="fa-solid fa-exclamation-circle me-1"></i>
                        <ul class="mb-0 mt-1 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                    @endif

                    {{-- Meta info --}}
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <span class="meta-pill"><i class="fa-solid fa-hashtag" style="font-size:.65rem;"></i> ID #{{ $package->id }}</span>
                        <span class="meta-pill"><i class="fa-solid fa-clock" style="font-size:.65rem;"></i> Dibuat {{ \Carbon\Carbon::parse($package->created_at)->isoFormat('D MMM YYYY') }}</span>
                    </div>

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="field-label">Nama Paket <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $package->name) }}" placeholder="Nama paket...">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-lg-6">
                            <label class="field-label">Kategori <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                <option value="" disabled>Pilih kategori...</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $package->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-lg-6">
                            <label class="field-label">Harga (Rp) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white" style="font-size:.82rem;color:#6B7280;">Rp</span>
                                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                                       value="{{ old('price', $package->price) }}" min="0">
                            </div>
                            @error('price')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-lg-6">
                            <label class="field-label">Durasi (menit) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" name="duration" class="form-control @error('duration') is-invalid @enderror"
                                       value="{{ old('duration', $package->duration) }}" min="1">
                                <span class="input-group-text bg-white" style="font-size:.82rem;color:#6B7280;">menit</span>
                            </div>
                            @error('duration')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-lg-6">
                            <label class="field-label">Keterangan Peserta <span class="text-danger">*</span></label>
                            <input type="text" name="participants" class="form-control @error('participants') is-invalid @enderror"
                                   value="{{ old('participants', $package->participants) }}" placeholder="Contoh: Personal (1 orang)">
                            @error('participants')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="field-label">Fitur Paket</label>
                            <div class="features-hint">
                                <i class="fa-solid fa-circle-info me-1"></i> Pisahkan setiap fitur dengan Enter.
                            </div>
                            <textarea name="features" class="form-control @error('features') is-invalid @enderror" rows="6">{{ old('features', $package->features) }}</textarea>
                            @error('features')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan --}}
        <div class="col-lg-4">
            <p class="section-label">Pengaturan</p>

            <div class="card tg-card mb-3">
                <div class="card-header">
                    <h5 class="card-title"><i class="fa-solid fa-users me-2" style="color:#2563EB;"></i>Batas Peserta</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="field-label">Min. Peserta</label>
                            <input type="number" name="min_participants" class="form-control"
                                   value="{{ old('min_participants', $package->min_participants) }}" min="1">
                        </div>
                        <div class="col-6">
                            <label class="field-label">Maks. Peserta</label>
                            <input type="number" name="max_participants" class="form-control"
                                   value="{{ old('max_participants', $package->max_participants) }}" placeholder="—" min="1">
                        </div>
                        <div class="col-12">
                            <input type="hidden" name="unlimited_participants" value="0">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="unlimited_participants"
                                       id="unlimited" value="1"
                                       {{ old('unlimited_participants', $package->unlimited_participants ? '1' : '0') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="unlimited" style="font-size:.82rem;">Peserta tidak terbatas</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card tg-card">
                <div class="card-header">
                    <h5 class="card-title"><i class="fa-solid fa-toggle-on me-2" style="color:#059669;"></i>Status Paket</h5>
                </div>
                <div class="card-body">
                    <input type="hidden" name="is_active" value="0">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                               {{ old('is_active', $package->is_active ? '1' : '0') == '1' ? 'checked' : '' }}>
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