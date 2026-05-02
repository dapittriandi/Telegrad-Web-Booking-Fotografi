@extends('base.base-auth-index')

@section('content')

<div class="pg-title">Selamat <em>datang</em><br>kembali.</div>
<p class="pg-sub">{{ $subdesc ?? 'Masukkan kredensial admin kamu untuk melanjutkan.' }}</p>

{{-- ── Alerts ── --}}
@if($errors->any())
<div class="alert danger">
    <i class="bi bi-exclamation-circle-fill"></i>
    <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
</div>
@endif

@if(session('success'))
<div class="alert success">
    <i class="bi bi-check-circle-fill"></i>
    <div>{{ session('success') }}</div>
</div>
@endif

@if(session('error'))
<div class="alert danger">
    <i class="bi bi-exclamation-circle-fill"></i>
    <div>{{ session('error') }}</div>
</div>
@endif

{{-- ── Form Login ── --}}
<form id="loginForm" action="{{ route('admin.login.post') }}" method="POST" novalidate>
    @csrf

    <div class="field">
        <label for="login">Email atau Username</label>
        <div class="iw">
            <i class="bi bi-person ico"></i>
            <input
                type="text" id="login" name="login"
                value="{{ old('login') }}"
                placeholder="Masukkan email atau username"
                class="{{ $errors->has('login') ? 'is-invalid' : '' }}"
                autofocus autocomplete="username">
        </div>
        @error('login')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="field">
        <label for="password">Password</label>
        <div class="iw">
            <i class="bi bi-lock ico"></i>
            <input
                type="password" id="password" name="password"
                placeholder="Masukkan password"
                class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                autocomplete="current-password">
            <button type="button" class="pwd-eye" id="pwdToggle" title="Tampilkan">
                <i class="bi bi-eye" id="pwdIcon"></i>
            </button>
        </div>
        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="row-rem">
        <label class="rem-label">
            <input type="checkbox" name="remember" id="remember">
            <span class="rem-box"></span>
            <span>Ingat saya</span>
        </label>
        <button type="button" class="btn-forgot" id="openForgot">
            Lupa password?
        </button>
    </div>

    <button type="submit" class="btn-main" id="loginBtn">
        <i class="bi bi-arrow-right-circle"></i>
        <span class="btn-label">Masuk ke Dashboard</span>
    </button>
</form>

<div class="foot">
    Butuh akses? &nbsp;
    <a href="mailto:{{ $web->site_email ?? 'admin@telegrad.id' }}">Hubungi superadmin</a>
</div>


{{-- ══════════════════════════════════════
     MODAL LUPA PASSWORD
══════════════════════════════════════ --}}
<div class="fp-backdrop" id="fpBackdrop" aria-hidden="true"></div>

<div class="fp-modal" id="fpModal" role="dialog" aria-modal="true" aria-labelledby="fpTitle">
    <button type="button" class="fp-close" id="closeForgot" aria-label="Tutup">
        <i class="bi bi-x-lg"></i>
    </button>

    <div class="fp-icon"><i class="bi bi-envelope-at"></i></div>
    <h3 class="fp-title" id="fpTitle">Reset Password</h3>
    <p class="fp-desc">Masukkan email admin kamu dan kami akan mengirimkan link untuk membuat password baru.</p>

    @if(session('fp_success'))
    <div class="alert success" style="margin-bottom:20px;">
        <i class="bi bi-check-circle-fill"></i>
        <div>{{ session('fp_success') }}</div>
    </div>
    @endif

    @if(session('fp_error'))
    <div class="alert danger" style="margin-bottom:20px;">
        <i class="bi bi-exclamation-circle-fill"></i>
        <div>{{ session('fp_error') }}</div>
    </div>
    @endif

    <form action="{{ route('admin.forgot-password.send') }}" method="POST" id="fpForm" novalidate>
        @csrf
        <div class="field" style="margin-bottom:22px;">
            <label for="fp_email">Alamat Email</label>
            <div class="iw">
                <i class="bi bi-envelope ico"></i>
                <input
                    type="email" id="fp_email" name="email"
                    placeholder="contoh@telegrad.id"
                    value="{{ old('email') }}"
                    autocomplete="email" required>
            </div>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn-main" id="fpSubmitBtn">
            <i class="bi bi-send"></i>
            <span class="btn-label">Kirim Link Reset</span>
        </button>
    </form>
</div>


{{-- ══════════════════════════════════════
     SCRIPTS
══════════════════════════════════════ --}}
<script>
(function () {

    /* Toggle password visibility */
    const pwdInput = document.getElementById('password');
    const pwdIcon  = document.getElementById('pwdIcon');
    document.getElementById('pwdToggle')?.addEventListener('click', () => {
        const show      = pwdInput.type === 'password';
        pwdInput.type   = show ? 'text' : 'password';
        pwdIcon.className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
    });

    /* Login loading state */
    document.getElementById('loginForm')?.addEventListener('submit', () => {
        document.getElementById('loginBtn')?.classList.add('loading');
    });

    /* Modal */
    const backdrop = document.getElementById('fpBackdrop');
    const modal    = document.getElementById('fpModal');

    function openModal() {
        backdrop.classList.add('show');
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
        setTimeout(() => document.getElementById('fp_email')?.focus(), 260);
    }
    function closeModal() {
        backdrop.classList.remove('show');
        modal.classList.remove('show');
        document.body.style.overflow = '';
    }

    document.getElementById('openForgot')?.addEventListener('click', openModal);
    document.getElementById('closeForgot')?.addEventListener('click', closeModal);
    backdrop?.addEventListener('click', closeModal);
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && modal.classList.contains('show')) closeModal();
    });

    document.getElementById('fpForm')?.addEventListener('submit', e => {
        const v = document.getElementById('fp_email').value.trim();
        if (!v) { e.preventDefault(); return; }
        document.getElementById('fpSubmitBtn')?.classList.add('loading');
    });

    /* Auto-buka modal jika ada session respons forgot password */
    @if(session('fp_error') || session('fp_success') || $errors->has('email'))
        openModal();
    @endif

})();
</script>

@endsection