@extends('base.base-admin-index')

@php $menu = 'Profil'; $submenu = 'Profil Admin'; $subdesc = 'Kelola informasi akun admin'; @endphp

@section('custom-css')
<style>
/* ── Icon Fix ── */
.bi { font-family:"bootstrap-icons"!important; line-height:1!important; display:inline-flex!important; align-items:center!important; justify-content:center!important; vertical-align:middle!important; }

/* ── Page Banner ── */
.profile-banner {
    background: linear-gradient(135deg, #0A1628 0%, #1E3A8A 55%, #2563EB 100%);
    border-radius: 16px; padding: 20px 24px; margin-bottom: 20px;
    position: relative; overflow: hidden;
    box-shadow: 0 4px 24px rgba(37,99,235,.22);
}
.profile-banner::before {
    content:''; position:absolute; top:-30px; right:-30px;
    width:180px; height:180px; border-radius:50%; background:rgba(255,255,255,.05);
}
.profile-banner::after {
    content:''; position:absolute; bottom:-40px; right:80px;
    width:120px; height:120px; border-radius:50%; background:rgba(255,255,255,.04);
}
.profile-banner-title { font-size:1.1rem; font-weight:800; color:#fff; letter-spacing:-.02em; margin-bottom:4px; }
.profile-banner-sub   { font-size:.78rem; color:rgba(255,255,255,.55); margin:0; }
.banner-meta { display:flex; gap:8px; flex-wrap:wrap; margin-top:12px; }
.banner-meta-pill {
    display:inline-flex; align-items:center; gap:5px;
    background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.15);
    color:rgba(255,255,255,.75); font-size:.7rem; font-weight:600;
    padding:3px 10px; border-radius:100px;
}

/* ── Cards ── */
.tg-card {
    border:1px solid var(--tg-glass-border,#F3F4F6)!important;
    border-radius:14px!important;
    box-shadow:0 1px 3px rgba(0,0,0,.06),0 4px 16px rgba(0,0,0,.05)!important;
    overflow:hidden;
    background:var(--tg-glass,#fff);
    backdrop-filter:var(--tg-blur,none);
    height:100%;
}
.tg-card-head {
    background:linear-gradient(135deg,#0A1628,#1E3A8A);
    padding:13px 18px;
    display:flex; align-items:center; gap:8px;
}
.tg-card-head h5 { color:#fff; font-size:.88rem; font-weight:700; margin:0; display:flex; align-items:center; gap:7px; line-height:1; }
.tg-card-body { padding:24px; }
.tg-card-footer {
    border-top:1px solid var(--tg-border,#F3F4F6)!important;
    padding:14px 20px;
    background:var(--tg-glass,#fff);
    display:flex; justify-content:flex-end;
}

/* ── Avatar area ── */
.avatar-wrap {
    position:relative; width:100px; height:100px; flex-shrink:0;
}
.avatar-wrap img {
    width:100px; height:100px; border-radius:50%; object-fit:cover;
    border:3px solid rgba(37,99,235,.2);
    box-shadow:0 4px 20px rgba(0,0,0,.12);
    transition:opacity .2s;
}
.avatar-edit-btn {
    position:absolute; bottom:2px; right:2px;
    width:28px; height:28px; border-radius:50%;
    background:linear-gradient(135deg,#1E3A8A,#2563EB);
    color:#fff; display:flex; align-items:center; justify-content:center;
    cursor:pointer; font-size:.75rem;
    border:2px solid var(--tg-glass,#fff);
    box-shadow:0 2px 8px rgba(37,99,235,.4);
    transition:transform .15s;
}
.avatar-edit-btn:hover { transform:scale(1.1); }

/* ── Admin name display ── */
.admin-name { font-size:.96rem; font-weight:800; color:var(--tg-text,#111827); line-height:1.3; }
.admin-username { font-size:.78rem; color:var(--tg-text-3,#9CA3AF); margin-top:3px; }
.admin-badge {
    display:inline-flex; align-items:center; gap:5px;
    background:rgba(37,99,235,.08); color:#1E40AF;
    font-size:.68rem; font-weight:700; padding:3px 10px; border-radius:100px;
    margin-top:8px;
}
[data-theme="dark"] .admin-badge { background:rgba(147,197,253,.12); color:#93C5FD; }

/* ── Upload btn ── */
.btn-upload {
    width:100%; display:flex; align-items:center; justify-content:center; gap:7px;
    font-size:.78rem; font-weight:600; padding:8px 14px; border-radius:9px;
    border:1.5px dashed var(--tg-border,#D1D5DB);
    background:transparent; color:var(--tg-text-2,#374151);
    cursor:pointer; transition:border-color .2s, background .2s, color .2s;
    text-decoration:none;
}
.btn-upload:hover { border-color:#2563EB; background:#EFF6FF; color:#2563EB; }

/* ── Form ── */
.field-label { font-size:.78rem; font-weight:700; color:var(--tg-text-2,#374151); margin-bottom:6px; display:flex; align-items:center; gap:5px; }
.form-control {
    font-size:.84rem; border-radius:9px;
    border:1.5px solid var(--tg-border,#E5E7EB);
    background:var(--tg-glass,#fff); color:var(--tg-text,#111827);
    padding:9px 12px; transition:border-color .2s, box-shadow .2s;
}
.form-control:focus {
    border-color:#2563EB; box-shadow:0 0 0 3px rgba(37,99,235,.1);
    background:var(--tg-glass,#fff);
}

/* ── Divider ── */
.field-divider { height:1px; background:var(--tg-border,#F3F4F6); margin:4px 0 16px; }

/* ── Section label ── */
.section-label { font-size:.63rem; font-weight:700; text-transform:uppercase; letter-spacing:.1em; color:var(--tg-text-3,#9CA3AF); margin-bottom:10px; }

/* ── Alerts ── */
.tg-alert { border-radius:10px; border:none; font-size:.83rem; padding:10px 14px; margin-bottom:16px; display:flex; align-items:flex-start; gap:8px; }
.tg-alert-danger  { background:#FEE2E2; color:#991B1B; }
.tg-alert-success { background:#D1FAE5; color:#065F46; }
[data-theme="dark"] .tg-alert-danger  { background:rgba(254,226,226,.12); color:#FCA5A5; }
[data-theme="dark"] .tg-alert-success { background:rgba(209,250,229,.12); color:#6EE7B7; }
</style>
@endsection

@section('content')

<form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
@csrf

{{-- ── Banner ── --}}
<div class="profile-banner mb-4">
    <div>
        <h2 class="profile-banner-title"><i class="bi bi-person-circle me-2" style="opacity:.8;font-size:1rem;"></i>Profil Admin</h2>
        <p class="profile-banner-sub">Kelola informasi akun dan foto profil Anda.</p>
    </div>
    <div class="banner-meta">
        <span class="banner-meta-pill"><i class="bi bi-person" style="font-size:.65rem;"></i> {{ Auth::user()->name }}</span>
        <span class="banner-meta-pill"><i class="bi bi-at" style="font-size:.65rem;"></i> {{ Auth::user()->username }}</span>
        <span class="banner-meta-pill"><i class="bi bi-shield-check" style="font-size:.65rem;color:#6EE7B7;"></i> Administrator</span>
    </div>
</div>

{{-- ── Alerts ── --}}
@if($errors->any())
<div class="tg-alert tg-alert-danger">
    <i class="bi bi-exclamation-circle-fill" style="flex-shrink:0;margin-top:1px;font-size:.9rem;"></i>
    <div>@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>
</div>
@endif
@if(session('success'))
<div class="tg-alert tg-alert-success">
    <i class="bi bi-check-circle-fill" style="flex-shrink:0;font-size:.9rem;"></i>
    {{ session('success') }}
</div>
@endif

<div class="row g-3">

    {{-- ── Kiri: Avatar ── --}}
    <div class="col-lg-4">
        <p class="section-label">Foto Profil</p>
        <div class="tg-card">
            <div class="tg-card-head">
                <h5><i class="bi bi-person-bounding-box" style="font-size:.82rem;"></i> Foto Profil</h5>
            </div>
            <div class="tg-card-body d-flex flex-column align-items-center gap-3 text-center">

                {{-- Avatar ── --}}
                <div class="avatar-wrap">
                    <img id="avatarPreview"
                         src="{{ asset('storage/images/profile/' . Auth::user()->photo) }}"
                         alt="Foto Profil">
                    <label for="photo" class="avatar-edit-btn" title="Ganti foto">
                        <i class="bi bi-camera-fill"></i>
                    </label>
                </div>

                {{-- Info ── --}}
                <div>
                    <div class="admin-name">{{ Auth::user()->name }}</div>
                    <div class="admin-username">&#64;{{ Auth::user()->username }}</div>
                    <div>
                        <span class="admin-badge">
                            <i class="bi bi-shield-check" style="font-size:.65rem;"></i> Administrator
                        </span>
                    </div>
                </div>

                <div style="width:100%;border-top:1px solid var(--tg-border,#F3F4F6);padding-top:16px;">
                    <label for="photo" class="btn-upload">
                        <i class="bi bi-upload" style="font-size:.8rem;"></i> Pilih Foto Baru
                    </label>
                    <p style="font-size:.71rem;color:var(--tg-text-3,#9CA3AF);margin-top:8px;margin-bottom:0;">
                        JPG, PNG, WebP — Maks 2MB
                    </p>
                    @error('photo')
                    <small class="text-danger d-block mt-1" style="font-size:.76rem;">{{ $message }}</small>
                    @enderror
                </div>

                <input type="file" name="photo" id="photo" class="d-none" accept="image/*">

            </div>
        </div>
    </div>

    {{-- ── Kanan: Identitas ── --}}
    <div class="col-lg-8">
        <p class="section-label">Identitas Admin</p>
        <div class="tg-card">
            <div class="tg-card-head">
                <h5><i class="bi bi-person-lines-fill" style="font-size:.82rem;"></i> Informasi Akun</h5>
            </div>
            <div class="tg-card-body">

                <div class="row g-3">

                    <div class="col-lg-6">
                        <label class="field-label" for="name">
                            <i class="bi bi-person" style="font-size:.82rem;color:var(--tg-text-3,#9CA3AF);"></i> Nama Lengkap
                        </label>
                        <input type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name"
                               value="{{ old('name', Auth::user()->name) }}"
                               placeholder="Nama lengkap Anda">
                        @error('name')<div class="invalid-feedback" style="font-size:.77rem;">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-lg-6">
                        <label class="field-label" for="username">
                            <i class="bi bi-at" style="font-size:.82rem;color:var(--tg-text-3,#9CA3AF);"></i> Username
                        </label>
                        <input type="text"
                               class="form-control @error('username') is-invalid @enderror"
                               id="username" name="username"
                               value="{{ old('username', Auth::user()->username) }}"
                               placeholder="Username unik Anda">
                        @error('username')<div class="invalid-feedback" style="font-size:.77rem;">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-lg-6">
                        <label class="field-label" for="phone">
                            <i class="bi bi-phone" style="font-size:.82rem;color:var(--tg-text-3,#9CA3AF);"></i> No. HP / WhatsApp
                        </label>
                        <input type="text"
                               class="form-control @error('phone') is-invalid @enderror"
                               id="phone" name="phone"
                               value="{{ old('phone', Auth::user()->phone) }}"
                               placeholder="08xxxxxxxxxx">
                        @error('phone')<div class="invalid-feedback" style="font-size:.77rem;">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-lg-6">
                        <label class="field-label" for="email">
                            <i class="bi bi-envelope" style="font-size:.82rem;color:var(--tg-text-3,#9CA3AF);"></i> Alamat Email
                        </label>
                        <input type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email"
                               value="{{ old('email', Auth::user()->email) }}"
                               placeholder="email@contoh.com">
                        @error('email')<div class="invalid-feedback" style="font-size:.77rem;">{{ $message }}</div>@enderror
                    </div>

                </div>

            </div>
            <div class="tg-card-footer">
                <button type="submit" class="btn btn-primary btn-sm"
                        style="border-radius:8px;font-size:.78rem;padding:7px 18px;display:inline-flex;align-items:center;gap:6px;">
                    <i class="bi bi-check2-circle" style="font-size:.82rem;"></i> Simpan Perubahan
                </button>
            </div>
        </div>
    </div>

</div>
</form>

@endsection

@section('custom-js')
<script>
document.getElementById('photo').addEventListener('change', function (e) {
    var file = e.target.files[0];
    if (!file) return;
    var reader = new FileReader();
    reader.onload = function (ev) {
        document.getElementById('avatarPreview').src = ev.target.result;
    };
    reader.readAsDataURL(file);
});
</script>
@endsection