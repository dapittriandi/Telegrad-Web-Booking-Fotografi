@extends('base.base-auth-index')

@section('content')

<div class="auth-title">Buat Password Baru</div>
<p class="auth-subtitle">Masukkan password baru{{ ($email ?? '') ? ' untuk akun <strong>' . e($email) . '</strong>' : '' }}.</p>

{{-- ── Alerts ── --}}
@if($errors->any())
<div class="auth-alert danger">
    @foreach($errors->all() as $error)
        <div>{{ $error }}</div>
    @endforeach
</div>
@endif

<form action="{{ route('admin.reset-password.update') }}" method="POST" id="resetForm" novalidate>
    @csrf

    <input type="hidden" name="token" value="{{ $token ?? '' }}">
    <input type="hidden" name="email" value="{{ $email ?? old('email', '') }}">

    {{-- Password Baru --}}
    <div class="auth-field">
        <label for="password">Password Baru</label>
        <div class="iw">
            <i class="bi bi-lock"></i>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Min. 8 karakter"
                class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                autocomplete="new-password"
                autofocus>
            <button type="button" class="pwd-toggle" id="pwdToggle1" title="Tampilkan">
                <i class="bi bi-eye" id="pwdIcon1"></i>
            </button>
        </div>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        {{-- Password strength bar --}}
        <div class="pwd-strength-wrap" id="pwdStrengthWrap" style="display:none; margin-top:8px;">
            <div class="pwd-strength-bar">
                <div class="pwd-strength-fill" id="pwdStrengthFill"></div>
            </div>
            <span class="pwd-strength-label" id="pwdStrengthLabel"></span>
        </div>
    </div>

    {{-- Konfirmasi Password --}}
    <div class="auth-field">
        <label for="password_confirmation">Konfirmasi Password</label>
        <div class="iw">
            <i class="bi bi-lock-fill"></i>
            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                placeholder="Ulangi password baru"
                class="{{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                autocomplete="new-password">
            <button type="button" class="pwd-toggle" id="pwdToggle2" title="Tampilkan">
                <i class="bi bi-eye" id="pwdIcon2"></i>
            </button>
        </div>
        <div class="match-hint" id="matchHint" style="display:none;"></div>
    </div>

    <button type="submit" class="btn-auth" id="resetBtn">
        <i class="bi bi-shield-check"></i>
        <span>Simpan Password Baru</span>
    </button>
</form>

<div class="auth-foot">
    Ingat password lama? &nbsp;
    <a href="{{ route('admin.login') }}">Kembali ke Login</a>
</div>

{{-- ── Extra styles ── --}}
<style>
    .pwd-toggle {
        position: absolute; right: 12px; top: 50%;
        transform: translateY(-50%);
        background: none; border: none;
        color: var(--c-ink-3); font-size: 14px;
        cursor: pointer; padding: 4px; line-height: 1;
        transition: color .15s;
    }
    .pwd-toggle:hover { color: var(--c-accent); }
    #password, #password_confirmation { padding-right: 40px; }

    .pwd-strength-bar {
        height: 4px; background: var(--c-border);
        border-radius: 99px; overflow: hidden;
        margin-bottom: 4px;
    }
    .pwd-strength-fill {
        height: 100%; border-radius: 99px;
        transition: width .3s ease, background .3s ease;
        width: 0;
    }
    .pwd-strength-label {
        font-size: 11.5px; font-weight: 600;
        letter-spacing: .02em; text-transform: uppercase;
    }

    .match-hint {
        font-size: 12px; margin-top: 4px;
        display: flex; align-items: center; gap: 4px;
    }
    .match-hint.ok    { color: #15803D; }
    .match-hint.err   { color: var(--c-err); }

    .btn-auth.loading { opacity: .7; pointer-events: none; }
</style>

{{-- ── Scripts ── --}}
<script>
(function () {
    /* Toggle visibility helpers */
    function makeToggle(inputId, btnId, iconId) {
        const input = document.getElementById(inputId);
        const btn   = document.getElementById(btnId);
        const icon  = document.getElementById(iconId);
        if (!btn) return;
        btn.addEventListener('click', () => {
            const show  = input.type === 'password';
            input.type  = show ? 'text' : 'password';
            icon.className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
            btn.title   = show ? 'Sembunyikan' : 'Tampilkan';
        });
    }
    makeToggle('password', 'pwdToggle1', 'pwdIcon1');
    makeToggle('password_confirmation', 'pwdToggle2', 'pwdIcon2');

    /* Password strength */
    const pwdInput      = document.getElementById('password');
    const strengthWrap  = document.getElementById('pwdStrengthWrap');
    const strengthFill  = document.getElementById('pwdStrengthFill');
    const strengthLabel = document.getElementById('pwdStrengthLabel');

    const levels = [
        { min: 0,  max: 3,  label: 'Lemah',   color: '#DC2626', w: '25%' },
        { min: 4,  max: 5,  label: 'Sedang',   color: '#D97706', w: '50%' },
        { min: 6,  max: 7,  label: 'Kuat',     color: '#2563EB', w: '75%' },
        { min: 8,  max: 99, label: 'Sangat Kuat', color: '#15803D', w: '100%' },
    ];

    function calcScore(val) {
        let s = 0;
        if (val.length >= 8)  s++;
        if (val.length >= 12) s++;
        if (/[A-Z]/.test(val)) s++;
        if (/[a-z]/.test(val)) s++;
        if (/[0-9]/.test(val)) s++;
        if (/[^A-Za-z0-9]/.test(val)) s++;
        return s;
    }

    pwdInput.addEventListener('input', () => {
        const val = pwdInput.value;
        if (!val) { strengthWrap.style.display = 'none'; return; }
        strengthWrap.style.display = 'block';
        const score = calcScore(val);
        const lvl   = levels.find(l => score >= l.min && score <= l.max) || levels[0];
        strengthFill.style.width      = lvl.w;
        strengthFill.style.background = lvl.color;
        strengthLabel.textContent     = lvl.label;
        strengthLabel.style.color     = lvl.color;
        checkMatch();
    });

    /* Match hint */
    const confInput = document.getElementById('password_confirmation');
    const matchHint = document.getElementById('matchHint');

    function checkMatch() {
        const p = pwdInput.value;
        const c = confInput.value;
        if (!c) { matchHint.style.display = 'none'; return; }
        matchHint.style.display = 'flex';
        if (p === c) {
            matchHint.className   = 'match-hint ok';
            matchHint.innerHTML   = '&#10003; Password cocok';
        } else {
            matchHint.className   = 'match-hint err';
            matchHint.innerHTML   = '&#10005; Password tidak cocok';
        }
    }
    confInput.addEventListener('input', checkMatch);

    /* Loading on submit */
    const form = document.getElementById('resetForm');
    const btn  = document.getElementById('resetBtn');
    form.addEventListener('submit', () => btn.classList.add('loading'));
})();
</script>

@endsection