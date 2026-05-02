@extends('base.base-admin-index')

@php
    $menu    = 'Paket';
    $submenu = 'Edit Paket';
    $subdesc = 'Ubah informasi paket: ' . $package->name;
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
   SHARED
   ============================================================= */
.section-label {
    font-size: .63rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .1em;
    color: var(--tg-text-3); margin-bottom: 10px; display: block;
}
.tg-divider { height: 1px; background: var(--tg-border); margin: 18px 0; }

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
.panel-head-actions { display: flex; gap: 8px; align-items: center; }
.panel-body { padding: 22px; }

/* =============================================================
   META PILLS
   ============================================================= */
.meta-pills { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 20px; }
.meta-pill {
    display: inline-flex; align-items: center; gap: 6px;
    background: var(--tg-glass); border: 1px solid var(--tg-border);
    color: var(--tg-text-3); font-size: .74rem; font-weight: 600;
    padding: 4px 12px; border-radius: 100px;
}
.meta-pill .bi { font-size: .7rem !important; }

/* =============================================================
   FORM
   ============================================================= */
.field-label {
    font-size: .78rem; font-weight: 700; color: var(--tg-text-2);
    margin-bottom: 6px; display: block;
}
.field-label span { color: #EF4444; }

.tg-input {
    background: var(--tg-bg-2, rgba(255,255,255,.06));
    border: 1px solid var(--tg-border);
    border-radius: 9px; padding: 9px 13px;
    font-size: .84rem; width: 100%;
    color: var(--tg-text);
    transition: border-color .15s, box-shadow .15s;
}
.tg-input:focus {
    border-color: #2563EB;
    box-shadow: 0 0 0 3px rgba(37,99,235,.12);
    outline: none;
}
.tg-input.is-invalid { border-color: #EF4444; }
.tg-input::placeholder { color: var(--tg-text-3); }
textarea.tg-input { resize: vertical; min-height: 90px; }
select.tg-input { cursor: pointer; }

.input-prefix-wrap, .input-suffix-wrap {
    display: flex; align-items: stretch;
}
.input-prefix-wrap .tg-input { border-radius: 0 9px 9px 0; }
.input-suffix-wrap .tg-input { border-radius: 9px 0 0 9px; }
.input-affix {
    display: flex; align-items: center; padding: 0 13px;
    background: var(--tg-glass); border: 1px solid var(--tg-border);
    font-size: .8rem; font-weight: 600; color: var(--tg-text-3);
    white-space: nowrap; flex-shrink: 0;
}
.input-prefix-wrap .input-affix { border-right: none; border-radius: 9px 0 0 9px; }
.input-suffix-wrap .input-affix { border-left: none; border-radius: 0 9px 9px 0; }

.invalid-feedback { font-size: .74rem; color: #EF4444; margin-top: 4px; }

/* Hint box */
.field-hint {
    background: rgba(37,99,235,.07);
    border-left: 3px solid #2563EB;
    border-radius: 0 8px 8px 0;
    padding: 9px 13px; font-size: .78rem;
    color: #2563EB; margin-bottom: 8px;
    display: flex; align-items: flex-start; gap: 7px;
}
.field-hint .bi { margin-top: 1px; flex-shrink: 0; }

/* Toggle wrap */
.tg-toggle-wrap {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 13px;
    background: var(--tg-glass);
    border: 1px solid var(--tg-border);
    border-radius: 9px;
}
.tg-toggle-wrap label { font-size: .84rem; color: var(--tg-text-2); cursor: pointer; margin: 0; }
.tg-toggle-note { font-size: .72rem; color: var(--tg-text-3); margin-top: 6px; }

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
.tg-btn-sm { padding: 6px 13px; font-size: .78rem; border-radius: 8px; }
.tg-btn-primary { background: #2563EB; color: #fff; border-color: #2563EB; }
.tg-btn-primary:hover { background: #1D4ED8; border-color: #1D4ED8; color: #fff; }
.tg-btn-w100 { width: 100%; justify-content: center; }
.tg-btn-outline-back {
    background: rgba(255,255,255,.12); color: rgba(255,255,255,.85);
    border-color: rgba(255,255,255,.25);
}
.tg-btn-outline-back:hover { background: rgba(255,255,255,.22); color: #fff; }
.tg-btn-save {
    background: rgba(255,255,255,.15); color: #fff;
    border-color: rgba(255,255,255,.3);
}
.tg-btn-save:hover { background: rgba(255,255,255,.25); color: #fff; }

/* =============================================================
   ALERT
   ============================================================= */
.tg-alert {
    border-radius: 10px; padding: 11px 15px; font-size: .84rem;
    margin-bottom: 18px; display: flex; align-items: flex-start; gap: 9px; font-weight: 500;
}
.tg-alert .bi { font-size: .95rem !important; flex-shrink: 0; margin-top: 1px; }
.tg-alert-success { background: #D1FAE5; color: #065F46; border: 1px solid #6EE7B7; }
.tg-alert-danger  { background: #FEE2E2; color: #991B1B; border: 1px solid #FCA5A5; }
.tg-alert ul { margin: 6px 0 0; padding-left: 18px; }
.tg-alert li { font-size: .82rem; }
</style>
@endsection

@section('content')

<form action="{{ route('packages.update', $package->id) }}" method="POST">
    @csrf @method('PUT')

    <div class="row g-3">

        {{-- ── Kiri: Form Utama ── --}}
        <div class="col-lg-8">
            <span class="section-label">Informasi Paket</span>
            <div class="panel-card">
                <div class="panel-head">
                    <h6>
                        <i class="bi bi-pencil-square"></i>
                        Edit: {{ Str::limit($package->name, 30) }}
                    </h6>
                    <div class="panel-head-actions">
                        <a href="{{ route('packages.index') }}" class="tg-btn tg-btn-sm tg-btn-outline-back">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="tg-btn tg-btn-sm tg-btn-save">
                            <i class="bi bi-save2"></i> Update Paket
                        </button>
                    </div>
                </div>
                <div class="panel-body">

                    @if(session('success'))
                    <div class="tg-alert tg-alert-success">
                        <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                    </div>
                    @endif
                    @if($errors->any())
                    <div class="tg-alert tg-alert-danger">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <div>
                            <strong>Ada kesalahan input:</strong>
                            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                        </div>
                    </div>
                    @endif

                    {{-- Meta Info --}}
                    <div class="meta-pills">
                        <span class="meta-pill">
                            <i class="bi bi-hash"></i> ID #{{ $package->id }}
                        </span>
                        <span class="meta-pill">
                            <i class="bi bi-calendar3"></i>
                            Dibuat {{ \Carbon\Carbon::parse($package->created_at)->isoFormat('D MMM YYYY') }}
                        </span>
                        <span class="meta-pill">
                            <i class="bi bi-folder2"></i>
                            {{ $package->category->name ?? '-' }}
                        </span>
                    </div>

                    <div class="row g-3">

                        {{-- Nama --}}
                        <div class="col-12">
                            <label class="field-label">Nama Paket <span>*</span></label>
                            <input type="text" name="name"
                                   class="tg-input @error('name') is-invalid @enderror"
                                   value="{{ old('name', $package->name) }}"
                                   placeholder="Nama paket...">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Kategori --}}
                        <div class="col-lg-6">
                            <label class="field-label">Kategori <span>*</span></label>
                            <select name="category_id"
                                    class="tg-input @error('category_id') is-invalid @enderror">
                                <option value="" disabled>Pilih kategori...</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ old('category_id', $package->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Harga --}}
                        <div class="col-lg-6">
                            <label class="field-label">Harga <span>*</span></label>
                            <div class="input-prefix-wrap">
                                <span class="input-affix">Rp</span>
                                <input type="number" name="price"
                                       class="tg-input @error('price') is-invalid @enderror"
                                       value="{{ old('price', $package->price) }}" min="0">
                            </div>
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Durasi --}}
                        <div class="col-lg-6">
                            <label class="field-label">Durasi <span>*</span></label>
                            <div class="input-suffix-wrap">
                                <input type="number" name="duration"
                                       class="tg-input @error('duration') is-invalid @enderror"
                                       value="{{ old('duration', $package->duration) }}" min="1">
                                <span class="input-affix">menit</span>
                            </div>
                            @error('duration')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Peserta --}}
                        <div class="col-lg-6">
                            <label class="field-label">Keterangan Peserta <span>*</span></label>
                            <input type="text" name="participants"
                                   class="tg-input @error('participants') is-invalid @enderror"
                                   value="{{ old('participants', $package->participants) }}"
                                   placeholder="Contoh: Personal (1 orang)">
                            @error('participants')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Fitur --}}
                        <div class="col-12">
                            <label class="field-label">Fitur Paket</label>
                            <div class="field-hint">
                                <i class="bi bi-info-circle-fill"></i>
                                Pisahkan setiap fitur dengan Enter.
                            </div>
                            <textarea name="features"
                                      class="tg-input @error('features') is-invalid @enderror"
                                      rows="7">{{ old('features', $package->features) }}</textarea>
                            @error('features')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- ── Kanan: Pengaturan ── --}}
        <div class="col-lg-4">
            <span class="section-label">Pengaturan</span>

            {{-- Batas Peserta --}}
            <div class="panel-card mb-3">
                <div class="panel-head">
                    <h6><i class="bi bi-people"></i> Batas Peserta</h6>
                </div>
                <div class="panel-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="field-label">Min. Peserta</label>
                            <input type="number" name="min_participants"
                                   class="tg-input"
                                   value="{{ old('min_participants', $package->min_participants) }}"
                                   min="1">
                        </div>
                        <div class="col-6">
                            <label class="field-label">Maks. Peserta</label>
                            <input type="number" name="max_participants"
                                   class="tg-input"
                                   value="{{ old('max_participants', $package->max_participants) }}"
                                   placeholder="—" min="1">
                        </div>
                        <div class="col-12">
                            <input type="hidden" name="unlimited_participants" value="0">
                            <div class="tg-toggle-wrap">
                                <input class="form-check-input" type="checkbox"
                                       name="unlimited_participants"
                                       id="unlimited" value="1"
                                       {{ old('unlimited_participants', $package->unlimited_participants ? '1' : '0') == '1' ? 'checked' : '' }}>
                                <label for="unlimited">Peserta tidak terbatas</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Status Paket --}}
            <div class="panel-card">
                <div class="panel-head">
                    <h6><i class="bi bi-toggles"></i> Status Paket</h6>
                </div>
                <div class="panel-body">
                    <input type="hidden" name="is_active" value="0">
                    <div class="tg-toggle-wrap">
                        <input class="form-check-input" type="checkbox"
                               name="is_active" id="is_active" value="1"
                               {{ old('is_active', $package->is_active ? '1' : '0') == '1' ? 'checked' : '' }}>
                        <label for="is_active" style="font-weight:700;">
                            Paket aktif &amp; tampil di website
                        </label>
                    </div>
                    <p class="tg-toggle-note">Paket non-aktif tidak bisa dipesan oleh customer.</p>
                </div>
            </div>

        </div>

    </div>
</form>

@endsection