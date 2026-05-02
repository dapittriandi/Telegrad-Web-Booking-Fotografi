@extends('base.base-root-index')

@push('css')
<style>
/* ─── profile.blade — theme-aware ───────────────────────── */

.page-header {
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    padding: 80px 0 0;
}
.page-header-inner { padding: 28px 0; }

.page-header-eyebrow {
    font-size: .67rem; font-weight: 700; letter-spacing: .18em;
    text-transform: uppercase; color: var(--gold);
    border: 1px solid var(--gold-border); border-radius: 100px;
    padding: 3px 12px; display: inline-block; margin-bottom: 10px;
}
.page-header h1 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.4rem, 3vw, 1.9rem);
    color: var(--text); font-weight: 700; margin: 0 0 4px;
}
.page-header-sub { font-size: .88rem; color: var(--muted); margin: 0; }

/* ─── Section ────────────────────────────────────────────── */
.profile-section { padding: 36px 0 80px; }

/* ─── Avatar sidebar ─────────────────────────────────────── */
.avatar-card {
    background: var(--card);
    border: 1px solid var(--gold-border);
    border-radius: 12px; overflow: hidden;
    position: sticky; top: 90px;
    transition: background .3s;
}
@media(max-width:992px) { .avatar-card { position: static; } }

.avatar-head {
    background: var(--gold-dim);
    border-bottom: 1px solid var(--gold-border);
    padding: 28px 22px; text-align: center;
}
.avatar-wrap { position: relative; width: 96px; height: 96px; margin: 0 auto 14px; }
.avatar-img {
    width: 96px; height: 96px; border-radius: 50%; object-fit: cover;
    border: 3px solid var(--gold-border); display: block;
    transition: border-color .2s;
}
.avatar-upload-btn {
    position: absolute; bottom: 2px; right: 2px;
    width: 28px; height: 28px; border-radius: 50%;
    background: var(--gold); border: 2px solid var(--card);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-size: .7rem; color: #0d0d0d;
    transition: background .2s, transform .2s;
}
.avatar-upload-btn:hover { background: var(--gold-light); transform: scale(1.1); }
#avatar-input { display: none; }

.avatar-name  { font-family: 'Playfair Display', serif; font-size: 1.1rem; font-weight: 700; color: var(--text); margin-bottom: 3px; }
.avatar-email { font-size: .76rem; color: var(--muted); }
.avatar-role  {
    display: inline-block; margin-top: 8px;
    font-size: .65rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase;
    color: var(--gold); background: rgba(200,169,110,.1); border: 1px solid var(--gold-border);
    padding: 3px 12px; border-radius: 100px;
}

.avatar-body { padding: 16px 20px; }

.avatar-stat {
    display: flex; justify-content: space-between; align-items: center;
    padding: 8px 0; border-bottom: 1px solid var(--border); font-size: .82rem;
    transition: border-color .3s;
}
.avatar-stat:last-of-type { border-bottom: none; }
.avatar-stat-key { color: var(--muted); display: flex; align-items: center; gap: 7px; }
.avatar-stat-key i { color: var(--gold); width: 14px; }
.avatar-stat-val { color: var(--text); font-weight: 600; }

/* Quick nav */
.quick-nav {
    display: flex; flex-direction: column; gap: 2px;
    margin-top: 12px; border-top: 1px solid var(--border);
    padding-top: 12px; transition: border-color .3s;
}
.quick-nav a {
    display: flex; align-items: center; gap: 10px;
    padding: 9px 12px; border-radius: 8px; font-size: .82rem;
    color: var(--muted); text-decoration: none;
    transition: background .2s, color .2s;
}
.quick-nav a:hover { background: var(--gold-dim); color: var(--gold); }
.quick-nav a i { color: var(--gold); width: 16px; }

.btn-logout {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    width: 100%; padding: 10px 0; font-size: .82rem; font-weight: 600;
    color: var(--danger); border: 1px solid rgba(224,92,92,.25); border-radius: 10px;
    background: transparent; cursor: pointer; margin-top: 12px;
    transition: background .2s, border-color .2s;
}
.btn-logout:hover { background: rgba(224,92,92,.08); border-color: rgba(224,92,92,.45); color: var(--danger); }

/* ─── Form cards ─────────────────────────────────────────── */
.form-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 12px; overflow: hidden;
    margin-bottom: 16px;
    transition: border-color .22s, background .3s, box-shadow .22s;
}
.form-card:hover { border-color: var(--gold-border); box-shadow: var(--shadow-sm); }

.form-card-head {
    padding: 16px 22px; border-bottom: 1px solid var(--border);
    display: flex; align-items: center; gap: 12px;
    background: rgba(0,0,0,.018);
    transition: background .3s;
}
[data-theme="light"] .form-card-head { background: rgba(0,0,0,.025); }

.form-card-icon {
    width: 36px; height: 36px;
    background: var(--gold-dim); border: 1px solid var(--gold-border);
    border-radius: 10px; display: flex; align-items: center; justify-content: center;
    color: var(--gold); font-size: .9rem; flex-shrink: 0;
}
.form-card-head h5 {
    font-family: 'Playfair Display', serif;
    font-size: 1rem; font-weight: 700; color: var(--text); margin: 0;
}
.form-card-body { padding: 22px; }

/* ─── Fields ─────────────────────────────────────────────── */
.field-group { margin-bottom: 18px; }
.field-group:last-child { margin-bottom: 0; }

.field-label {
    display: block; font-size: .7rem; font-weight: 700;
    letter-spacing: .12em; text-transform: uppercase;
    color: var(--muted); margin-bottom: 7px;
}
.field-label span { color: var(--danger); }

.field-input {
    width: 100%; background: var(--surface);
    border: 1px solid var(--border); border-radius: 10px;
    padding: 11px 15px; font-size: .875rem; color: var(--text);
    outline: none; appearance: none;
    transition: border-color .2s, background .3s, box-shadow .2s;
    font-family: 'DM Sans', sans-serif;
}
.field-input::placeholder { color: var(--muted); }
.field-input:focus {
    border-color: var(--gold-border);
    background: var(--card);
    box-shadow: 0 0 0 3px var(--gold-dim);
}
.field-input:read-only { opacity: .55; cursor: not-allowed; }
.field-input.is-invalid { border-color: rgba(224,92,92,.5); }

.invalid-msg { font-size: .74rem; color: var(--danger); margin-top: 5px; display: block; }
.field-hint  { font-size: .74rem; color: var(--muted); margin-top: 6px; display: flex; align-items: center; gap: 5px; }
.field-hint i { color: var(--gold); }

/* ─── Password strength ──────────────────────────────────── */
.strength-bar  { height: 4px; border-radius: 2px; background: var(--border); margin-top: 8px; overflow: hidden; transition: background .3s; }
.strength-fill { height: 100%; border-radius: 2px; transition: width .3s, background .3s; width: 0; }
.strength-label { font-size: .72rem; color: var(--muted); margin-top: 4px; }

/* ─── Save button ────────────────────────────────────────── */
.btn-save {
    display: inline-flex; align-items: center; justify-content: center; gap: 9px;
    padding: 12px 32px; font-size: .84rem; font-weight: 700;
    letter-spacing: .07em; text-transform: uppercase;
    color: #0d0d0d; background: var(--gold);
    border: none; border-radius: 10px; cursor: pointer;
    transition: opacity .2s, transform .2s, box-shadow .2s;
}
.btn-save:hover { opacity: .88; transform: translateY(-2px); box-shadow: 0 8px 28px rgba(200,169,110,.28); }
.btn-save:disabled { opacity: .6; cursor: not-allowed; transform: none; }

/* ─── Alert messages ─────────────────────────────────────── */
.alert-box {
    border-radius: 10px; padding: 13px 16px;
    font-size: .82rem; display: flex; align-items: flex-start; gap: 10px;
    margin-bottom: 18px;
}
.alert-success { background: rgba(76,175,130,.08); border: 1px solid rgba(76,175,130,.22); color: var(--success); }
.alert-danger  { background: rgba(224,92,92,.08);  border: 1px solid rgba(224,92,92,.22);  color: var(--danger); }
.alert-dismiss { margin-left: auto; background: none; border: none; color: inherit; cursor: pointer; font-size: 1.1rem; line-height: 1; flex-shrink: 0; }

/* ─── Photo upload button ────────────────────────────────── */
.photo-upload-label {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 8px 16px; border: 1px solid var(--gold-border); border-radius: 8px;
    font-size: .78rem; color: var(--gold); cursor: pointer;
    transition: background .2s, color .2s;
}
.photo-upload-label:hover { background: var(--gold-dim); color: var(--gold-light); }
</style>
@endpush

@section('content')
<main id="main">

{{-- PAGE HEADER --}}
<div class="page-header">
    <div class="container">
        <div class="page-header-inner">
            <span class="page-header-eyebrow"><i class="bi bi-person-gear me-1"></i> Akun</span>
            <h1>Pengaturan Profil</h1>
            <p class="page-header-sub">Kelola informasi akun dan keamanan login kamu.</p>
        </div>
    </div>
</div>

<section class="profile-section">
<div class="container">

    {{-- Flash alerts --}}
    @if(session('success'))
    <div class="alert-box alert-success" data-aos="fade-up">
        <i class="bi bi-check-circle-fill" style="flex-shrink:0;"></i>
        <span>{{ session('success') }}</span>
        <button class="alert-dismiss" onclick="this.parentElement.remove()">&times;</button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert-box alert-danger" data-aos="fade-up">
        <i class="bi bi-exclamation-triangle-fill" style="flex-shrink:0;"></i>
        <span>{{ session('error') }}</span>
        <button class="alert-dismiss" onclick="this.parentElement.remove()">&times;</button>
    </div>
    @endif
    @if($errors->any())
    <div class="alert-box alert-danger" data-aos="fade-up">
        <i class="bi bi-exclamation-triangle-fill" style="flex-shrink:0;"></i>
        <div>@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>
        <button class="alert-dismiss" onclick="this.parentElement.remove()">&times;</button>
    </div>
    @endif

    <div class="row g-4 align-items-start">

        {{-- ─── LEFT: Avatar sidebar ─── --}}
        <div class="col-lg-4" data-aos="fade-right">
            <div class="avatar-card">
                <div class="avatar-head">
                    <form action="{{ route('customer.profile.update') }}" method="POST"
                          enctype="multipart/form-data" id="avatar-form">
                        @csrf @method('PUT')
                        <div class="avatar-wrap">
                            <img id="avatar-preview"
                                 src="{{ Auth::user()->photo
                                    ? asset('storage/images/profile/' . Auth::user()->photo)
                                    : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=c8a96e&color=1a1408&size=100' }}"
                                 class="avatar-img" alt="{{ Auth::user()->name }}">
                            <label for="avatar-input" class="avatar-upload-btn" title="Ganti Foto">
                                <i class="bi bi-camera-fill"></i>
                            </label>
                            <input type="file" name="photo" id="avatar-input"
                                   accept="image/jpeg,image/png,image/jpg"
                                   onchange="previewAvatar(event)">
                        </div>
                    </form>
                    <div class="avatar-name">{{ Auth::user()->name }}</div>
                    <div class="avatar-email">{{ Auth::user()->email }}</div>
                    <span class="avatar-role">Customer</span>
                </div>

                <div class="avatar-body">
                    @php
                        $totalOrders     = Auth::user()->orders()->count();
                        $completedOrders = Auth::user()->orders()->where('status','completed')->count();
                        $pendingOrders   = Auth::user()->orders()->whereIn('status',['pending','confirmed'])->count();
                    @endphp

                    <div class="avatar-stat">
                        <span class="avatar-stat-key"><i class="bi bi-grid-3x3-gap"></i> Total Order</span>
                        <span class="avatar-stat-val">{{ $totalOrders }}</span>
                    </div>
                    <div class="avatar-stat">
                        <span class="avatar-stat-key"><i class="bi bi-check-circle"></i> Selesai</span>
                        <span class="avatar-stat-val">{{ $completedOrders }}</span>
                    </div>
                    <div class="avatar-stat">
                        <span class="avatar-stat-key"><i class="bi bi-hourglass-split"></i> Diproses</span>
                        <span class="avatar-stat-val">{{ $pendingOrders }}</span>
                    </div>
                    <div class="avatar-stat">
                        <span class="avatar-stat-key"><i class="bi bi-calendar3"></i> Bergabung</span>
                        <span class="avatar-stat-val">{{ Auth::user()->created_at->isoFormat('MMM YYYY') }}</span>
                    </div>

                    <div class="quick-nav">
                        <a href="{{ route('customer.orders') }}">
                            <i class="bi bi-list-check"></i> Riwayat Order
                        </a>
                        <a href="{{ route('packages.categories') }}">
                            <i class="bi bi-camera"></i> Lihat Paket
                        </a>
                        <a href="{{ route('contact') }}">
                            <i class="bi bi-headset"></i> Bantuan
                        </a>
                    </div>

                    <form action="{{ route('customer.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-logout">
                            <i class="bi bi-box-arrow-right"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ─── RIGHT: Forms ─── --}}
        <div class="col-lg-8">

            <form action="{{ route('customer.profile.update') }}" method="POST"
                  enctype="multipart/form-data" id="profile-form">
                @csrf @method('PUT')

                {{-- Informasi Pribadi --}}
                <div class="form-card" data-aos="fade-up">
                    <div class="form-card-head">
                        <div class="form-card-icon"><i class="bi bi-person"></i></div>
                        <h5>Informasi Pribadi</h5>
                    </div>
                    <div class="form-card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="field-group">
                                    <label class="field-label">Nama Lengkap <span>*</span></label>
                                    <input type="text" name="name"
                                           class="field-input @error('name') is-invalid @enderror"
                                           value="{{ old('name', Auth::user()->name) }}"
                                           placeholder="Nama lengkap..." required>
                                    @error('name')<span class="invalid-msg">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="field-group">
                                    <label class="field-label">Username</label>
                                    <input type="text" name="username"
                                           class="field-input @error('username') is-invalid @enderror"
                                           value="{{ old('username', Auth::user()->username) }}"
                                           placeholder="username...">
                                    @error('username')<span class="invalid-msg">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="field-group">
                                    <label class="field-label">Email <span>*</span></label>
                                    <input type="email" name="email"
                                           class="field-input @error('email') is-invalid @enderror"
                                           value="{{ old('email', Auth::user()->email) }}"
                                           placeholder="email@kamu.com" required>
                                    @error('email')<span class="invalid-msg">{{ $message }}</span>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="field-group">
                                    <label class="field-label">No. HP / WhatsApp <span>*</span></label>
                                    <input type="text" name="phone"
                                           class="field-input @error('phone') is-invalid @enderror"
                                           value="{{ old('phone', Auth::user()->getRawOriginal('phone') ?? Auth::user()->phone) }}"
                                           placeholder="08xxxxxxxxxx" required>
                                    @error('phone')<span class="invalid-msg">{{ $message }}</span>@enderror
                                    <div class="field-hint">
                                        <i class="bi bi-info-circle"></i> Digunakan admin untuk menghubungi kamu
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="field-group mb-0">
                                    <label class="field-label">Foto Profil</label>
                                    <div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;">
                                        <img id="avatar-preview-2"
                                             src="{{ Auth::user()->photo
                                                ? asset('storage/images/profile/' . Auth::user()->photo)
                                                : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=c8a96e&color=1a1408&size=60' }}"
                                             style="width:52px;height:52px;border-radius:50%;object-fit:cover;border:2px solid var(--gold-border);"
                                             alt="Preview">
                                        <div>
                                            <label for="photo-input-2" class="photo-upload-label">
                                                <i class="bi bi-upload"></i> Pilih Foto
                                            </label>
                                            <input type="file" name="photo" id="photo-input-2"
                                                   accept="image/jpeg,image/png,image/jpg"
                                                   style="display:none;"
                                                   onchange="previewAvatarMain(event)">
                                            <div class="field-hint mt-1">
                                                <i class="bi bi-info-circle"></i> JPG, PNG · Maks. 2MB
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Keamanan Akun --}}
                <div class="form-card" data-aos="fade-up" data-aos-delay="40">
                    <div class="form-card-head">
                        <div class="form-card-icon"><i class="bi bi-shield-lock"></i></div>
                        <h5>Keamanan Akun</h5>
                    </div>
                    <div class="form-card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="field-group">
                                    <label class="field-label">Password Baru</label>
                                    <input type="password" name="password"
                                           class="field-input @error('password') is-invalid @enderror"
                                           id="new-password"
                                           placeholder="Kosongkan jika tidak ingin mengubah..."
                                           oninput="checkStrength(this.value)">
                                    @error('password')<span class="invalid-msg">{{ $message }}</span>@enderror
                                    <div class="strength-bar"><div class="strength-fill" id="strength-fill"></div></div>
                                    <div class="strength-label" id="strength-label"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="field-group mb-0">
                                    <label class="field-label">Konfirmasi Password Baru</label>
                                    <input type="password" name="password_confirmation"
                                           class="field-input"
                                           placeholder="Ulangi password baru...">
                                    <div class="field-hint">
                                        <i class="bi bi-info-circle"></i>
                                        Minimal 8 karakter. Kosongkan jika tidak ingin mengubah password.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Save --}}
                <div data-aos="fade-up" data-aos-delay="60">
                    <button type="submit" class="btn-save" id="save-btn">
                        <i class="bi bi-floppy"></i> Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>
</section>

</main>
@endsection

@push('js')
<script>
function previewAvatar(event) {
    var file = event.target.files[0];
    if (!file) return;
    var reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('avatar-preview').src  = e.target.result;
        document.getElementById('avatar-preview-2').src = e.target.result;
    };
    reader.readAsDataURL(file);
}

function previewAvatarMain(event) {
    var file = event.target.files[0];
    if (!file) return;
    var reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('avatar-preview').src  = e.target.result;
        document.getElementById('avatar-preview-2').src = e.target.result;
    };
    reader.readAsDataURL(file);
}

function checkStrength(val) {
    var fill  = document.getElementById('strength-fill');
    var label = document.getElementById('strength-label');
    if (!val) { fill.style.width = '0'; label.textContent = ''; return; }
    var score = 0;
    if (val.length >= 8)        score++;
    if (/[A-Z]/.test(val))      score++;
    if (/[0-9]/.test(val))      score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;
    var map = [
        { w:'15%',  bg:'#e05c5c', t:'Terlalu lemah' },
        { w:'40%',  bg:'#e0a935', t:'Lemah' },
        { w:'70%',  bg:'#5b9bd5', t:'Cukup' },
        { w:'100%', bg:'#4caf82', t:'Kuat' },
    ];
    var m = map[score - 1] || map[0];
    fill.style.width      = m.w;
    fill.style.background = m.bg;
    label.textContent     = m.t;
    label.style.color     = m.bg;
}

document.getElementById('profile-form').addEventListener('submit', function() {
    var btn = document.getElementById('save-btn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" style="width:14px;height:14px;border-width:2px;"></span> Menyimpan...';
});
</script>
@endpush