@extends('base.base-auth-index')

@section('content')

{{-- ── Judul & subjudul ── --}}
<div class="auth-title">{{ $submenu ?? 'Selamat datang' }}</div>
<p class="auth-subtitle">{{ $subdesc ?? 'Masukkan kredensial admin kamu untuk melanjutkan.' }}</p>

{{-- ── Alert error / success ── --}}
@if($errors->any())
<div class="auth-alert danger">
    @foreach($errors->all() as $error)
        <div>{{ $error }}</div>
    @endforeach
</div>
@endif

@if(session('success'))
<div class="auth-alert success">
    <i class="bi bi-check-circle-fill" style="margin-right:6px;"></i>{{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="auth-alert danger">
    <i class="bi bi-exclamation-triangle-fill" style="margin-right:6px;"></i>{{ session('error') }}
</div>
@endif

{{-- ── Form Login ── --}}
<form id="loginForm" action="{{ route('admin.login.post') }}" method="POST" novalidate>
    @csrf

    <div class="auth-field">
        <label for="login">Email atau Username</label>
        <div class="iw">
            <i class="bi bi-person"></i>
            <input
                type="text"
                id="login"
                name="login"
                value="{{ old('login') }}"
                placeholder="Masukkan email atau username"
                class="{{ $errors->has('login') ? 'is-invalid' : '' }}"
                autofocus autocomplete="username">
        </div>
        @error('login')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="auth-field">
        <label for="password">
            Password
        </label>
        <div class="iw">
            <i class="bi bi-lock"></i>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Masukkan password"
                class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                autocomplete="current-password">
            {{-- Toggle visibility --}}
            <button type="button" class="pwd-toggle" id="pwdToggle" tabindex="-1" title="Tampilkan password">
                <i class="bi bi-eye" id="pwdIcon"></i>
            </button>
        </div>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- Remember me --}}
    <div class="auth-remember">
        <label class="remember-label">
            <input type="checkbox" name="remember" id="remember">
            <span class="remember-check"></span>
            <span>Ingat saya</span>
        </label>
        <button type="button" class="forgot-link" id="openForgot">
            Lupa password?
        </button>
    </div>

    <button type="submit" class="btn-auth" id="loginBtn">
        <i class="bi bi-box-arrow-in-right"></i>
        <span>Masuk ke Dashboard</span>
    </button>
</form>

{{-- ── Footer ── --}}
<div class="auth-foot">
    Belum punya akses? &nbsp;
    <a href="mailto:{{ $web->site_email ?? 'admin@telegrad.id' }}">Hubungi superadmin</a>
</div>


{{-- ═══════════════════════════════════════════
     MODAL LUPA PASSWORD
     ═══════════════════════════════════════════ --}}
<div class="fp-backdrop" id="fpBackdrop" aria-hidden="true"></div>

<div class="fp-modal" id="fpModal" role="dialog" aria-modal="true" aria-labelledby="fpTitle">

    {{-- Step 1: Masukkan email --}}
    <div class="fp-step" id="fpStep1">
        <div class="fp-modal-icon">
            <i class="bi bi-shield-lock"></i>
        </div>
        <h3 class="fp-modal-title" id="fpTitle">Lupa Password?</h3>
        <p class="fp-modal-desc">Masukkan email admin kamu. Kami akan mengirim link reset password ke email tersebut.</p>

        @if(session('fp_success'))
        <div class="auth-alert success" style="margin-bottom:16px;">
            <i class="bi bi-check-circle-fill" style="margin-right:6px;"></i>{{ session('fp_success') }}
        </div>
        @endif

        @if(session('fp_error'))
        <div class="auth-alert danger" style="margin-bottom:16px;">
            <i class="bi bi-exclamation-triangle-fill" style="margin-right:6px;"></i>{{ session('fp_error') }}
        </div>
        @endif

        <form action="{{ route('admin.forgot-password.send') }}" method="POST" id="fpForm" novalidate>
            @csrf
            <div class="auth-field" style="margin-bottom:20px;">
                <label for="fp_email">Alamat Email Admin</label>
                <div class="iw">
                    <i class="bi bi-envelope"></i>
                    <input
                        type="email"
                        id="fp_email"
                        name="email"
                        placeholder="contoh@telegrad.id"
                        autocomplete="email"
                        required>
                </div>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-auth" id="fpSubmitBtn">
                <i class="bi bi-send"></i>
                <span>Kirim Link Reset</span>
            </button>
        </form>
    </div>

    {{-- Close button --}}
    <button type="button" class="fp-close" id="closeForgot" aria-label="Tutup">
        <i class="bi bi-x-lg"></i>
    </button>
</div>


{{-- ═══════════════════════════════════════════
     EXTRA STYLES
     ═══════════════════════════════════════════ --}}
<style>
    /* ── Password toggle ── */
    .pwd-toggle {
        position: absolute; right: 12px; top: 50%;
        transform: translateY(-50%);
        background: none; border: none;
        color: var(--c-ink-3); font-size: 14px;
        cursor: pointer; padding: 4px;
        line-height: 1; transition: color .15s;
    }
    .pwd-toggle:hover { color: var(--c-accent); }
    /* Geser padding input supaya tidak tertutup icon toggle */
    #password { padding-right: 40px; }

    /* ── Remember & Forgot row ── */
    .auth-remember {
        display: flex; align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .remember-label {
        display: inline-flex; align-items: center; gap: 8px;
        font-size: 13px; color: var(--c-ink-2);
        cursor: pointer; user-select: none;
    }
    .remember-label input[type="checkbox"] { display: none; }
    .remember-check {
        width: 16px; height: 16px;
        border: 1.5px solid var(--c-border);
        border-radius: 4px; background: var(--c-bg);
        display: flex; align-items: center; justify-content: center;
        transition: all .15s; flex-shrink: 0;
    }
    .remember-label input:checked + .remember-check {
        background: var(--c-accent); border-color: var(--c-accent);
    }
    .remember-label input:checked + .remember-check::after {
        content: '';
        display: block; width: 9px; height: 5px;
        border-left: 2px solid #fff; border-bottom: 2px solid #fff;
        transform: rotate(-45deg) translateY(-1px);
    }
    .forgot-link {
        background: none; border: none;
        font-size: 13px; font-weight: 600;
        color: var(--c-accent); cursor: pointer;
        padding: 0; text-decoration: none;
        transition: color .15s;
        font-family: var(--font-sans);
    }
    .forgot-link:hover { color: var(--c-accent-h); text-decoration: underline; }

    /* ── Loading state on buttons ── */
    .btn-auth.loading { opacity: .7; pointer-events: none; }
    .btn-auth.loading span::after { content: '…'; }

    /* ══════════════════════════════════
       MODAL LUPA PASSWORD
       ══════════════════════════════════ */
    .fp-backdrop {
        position: fixed; inset: 0;
        background: rgba(15,17,23,.45);
        backdrop-filter: blur(4px);
        opacity: 0; pointer-events: none;
        transition: opacity .25s ease;
        z-index: 900;
    }
    .fp-backdrop.show { opacity: 1; pointer-events: all; }

    .fp-modal {
        position: fixed;
        top: 50%; left: 50%;
        transform: translate(-50%, calc(-50% + 20px));
        width: min(440px, calc(100vw - 32px));
        background: var(--c-surface);
        border: 1px solid var(--c-border);
        border-radius: 16px;
        padding: 40px 36px 36px;
        opacity: 0; pointer-events: none;
        transition: opacity .25s ease, transform .25s ease;
        z-index: 901; box-shadow: 0 24px 64px rgba(0,0,0,.12);
        position: fixed;
    }
    .fp-modal.show {
        opacity: 1; pointer-events: all;
        transform: translate(-50%, -50%);
    }

    .fp-modal-icon {
        width: 52px; height: 52px;
        background: #EFF6FF; border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 22px; color: var(--c-accent);
        margin: 0 auto 20px;
    }
    .fp-modal-title {
        font-family: var(--font-serif);
        font-size: 22px; font-weight: 400;
        color: var(--c-ink); text-align: center;
        margin-bottom: 8px;
    }
    .fp-modal-desc {
        font-size: 13.5px; color: var(--c-ink-2);
        text-align: center; line-height: 1.6;
        margin-bottom: 28px;
    }

    .fp-close {
        position: absolute; top: 16px; right: 16px;
        background: none; border: none;
        width: 32px; height: 32px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 14px; color: var(--c-ink-3);
        cursor: pointer; transition: all .15s;
    }
    .fp-close:hover {
        background: var(--c-bg); color: var(--c-ink);
    }

    .fp-step { animation: fadeIn .2s ease both; }

    /* Jika modal perlu dibuka otomatis (ada session error/success) */
    .fp-modal.auto-open,
    .fp-backdrop.auto-open {
        opacity: 1; pointer-events: all;
    }
    .fp-modal.auto-open { transform: translate(-50%, -50%); }
</style>


{{-- ═══════════════════════════════════════════
     SCRIPTS
     ═══════════════════════════════════════════ --}}
<script>
(function () {
    /* ── Password toggle ── */
    const pwdInput  = document.getElementById('password');
    const pwdToggle = document.getElementById('pwdToggle');
    const pwdIcon   = document.getElementById('pwdIcon');

    if (pwdToggle) {
        pwdToggle.addEventListener('click', () => {
            const show = pwdInput.type === 'password';
            pwdInput.type       = show ? 'text' : 'password';
            pwdIcon.className   = show ? 'bi bi-eye-slash' : 'bi bi-eye';
            pwdToggle.title     = show ? 'Sembunyikan password' : 'Tampilkan password';
        });
    }

    /* ── Login form: loading state ── */
    const loginForm = document.getElementById('loginForm');
    const loginBtn  = document.getElementById('loginBtn');
    if (loginForm && loginBtn) {
        loginForm.addEventListener('submit', () => {
            loginBtn.classList.add('loading');
        });
    }

    /* ── Modal Lupa Password ── */
    const backdrop  = document.getElementById('fpBackdrop');
    const modal     = document.getElementById('fpModal');
    const openBtn   = document.getElementById('openForgot');
    const closeBtn  = document.getElementById('closeForgot');
    const fpForm    = document.getElementById('fpForm');
    const fpSubmit  = document.getElementById('fpSubmitBtn');

    function openModal() {
        backdrop.classList.add('show');
        modal.classList.add('show');
        backdrop.removeAttribute('aria-hidden');
        document.body.style.overflow = 'hidden';
        setTimeout(() => document.getElementById('fp_email')?.focus(), 250);
    }

    function closeModal() {
        backdrop.classList.remove('show');
        modal.classList.remove('show');
        backdrop.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    if (openBtn)  openBtn.addEventListener('click', openModal);
    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (backdrop) backdrop.addEventListener('click', closeModal);

    /* Tutup dengan ESC */
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.classList.contains('show')) closeModal();
    });

    /* Loading state pada form forgot */
    if (fpForm && fpSubmit) {
        fpForm.addEventListener('submit', (e) => {
            const email = document.getElementById('fp_email').value.trim();
            if (!email) { e.preventDefault(); return; }
            fpSubmit.classList.add('loading');
        });
    }

    /* ── Auto-buka modal jika ada session fp_error atau fp_success ── */
    @if(session('fp_error') || session('fp_success') || $errors->has('email'))
        openModal();
    @endif

})();
</script>

@endsection