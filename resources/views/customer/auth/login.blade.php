<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    @php $web = \App\Models\WebSetting::first(); @endphp

    <title>{{ $web->site_name ?? 'Telegrad' }} — Masuk</title>
    <link rel="icon" href="{{ asset('images/logo_telegrad_gold.png') }}" type="image/png">

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,300&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <link href="{{ asset('root/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('auth/assets/css/nucleo-icons.css') }}" rel="stylesheet"/>
    <link href="{{ asset('auth/assets/css/argon-dashboard.min.css?v=2.0.4') }}" rel="stylesheet"/>

    <style>
        :root {
            --c-ink:      #0F1117;
            --c-ink-2:    #4B5563;
            --c-ink-3:    #9CA3AF;
            --c-surface:  #FFFFFF;
            --c-bg:       #F5F5F0;
            --c-border:   #E4E4E0;
            --c-accent:   #a28820;
            --c-accent-h: #bea749;
            --c-err:      #DC2626;
            --r-input:    8px;
            --r-btn:      8px;
            --font-sans:  'DM Sans', sans-serif;
            --font-serif: 'DM Serif Display', serif;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; font-family: var(--font-sans); background: var(--c-bg); color: var(--c-ink); }

        /* ── Layout ── */
        .auth-shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 480px 1fr;
        }

        /* ── Left pane ── */
        .auth-pane {
            background: var(--c-surface);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 56px 52px;
            position: relative;
            border-right: 1px solid var(--c-border);
        }

        /* Back link */
        .auth-back {
            position: absolute; top: 28px; left: 52px;
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 13px; font-weight: 500; color: var(--c-ink-3);
            text-decoration: none; letter-spacing: .01em;
            transition: color .15s;
        }
        .auth-back:hover { color: var(--c-accent); }

        /* Brand */
        .auth-brand {
            display: flex; align-items: center; gap: 10px;
            margin-bottom: 44px;
        }
        .auth-brand img { height: 36px; width: auto; }
        .auth-brand-name {
            font-size: 15px; font-weight: 700;
            color: var(--c-ink); letter-spacing: -.01em;
        }

        /* Heading */
        .auth-title {
            font-family: var(--font-serif);
            font-size: 28px; font-weight: 400;
            color: var(--c-ink); line-height: 1.2;
            margin-bottom: 6px;
        }
        .auth-subtitle {
            font-size: 13.5px; color: var(--c-ink-2);
            margin-bottom: 32px; line-height: 1.5;
        }

        /* Fields */
        .auth-field { margin-bottom: 18px; }
        .auth-field label {
            display: block;
            font-size: 12.5px; font-weight: 600;
            color: var(--c-ink); margin-bottom: 6px;
            letter-spacing: .02em; text-transform: uppercase;
        }
        .auth-field .iw { position: relative; }
        .auth-field .iw i {
            position: absolute; left: 13px; top: 50%;
            transform: translateY(-50%);
            color: var(--c-ink-3); font-size: 14px;
            pointer-events: none; transition: color .15s;
        }
        .auth-field input {
            width: 100%;
            padding: 10px 14px 10px 38px;
            border: 1.5px solid var(--c-border);
            border-radius: var(--r-input);
            font-family: var(--font-sans);
            font-size: 14px; color: var(--c-ink);
            background: var(--c-bg);
            transition: border-color .15s, box-shadow .15s, background .15s;
            outline: none;
        }
        .auth-field input:focus {
            border-color: var(--c-accent);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(37,99,235,.1);
        }
        .auth-field input::placeholder { color: var(--c-ink-3); }
        .auth-field .iw:focus-within i { color: var(--c-accent); }
        .auth-field .is-invalid { border-color: var(--c-err) !important; }
        .auth-field .invalid-feedback,
        .auth-field small.text-danger {
            font-size: 12px; color: var(--c-err); margin-top: 4px; display: block;
        }

        /* Submit */
        .btn-auth {
            width: 100%;
            padding: 11px 20px;
            background: var(--c-accent);
            border: none; border-radius: var(--r-btn);
            color: #fff; font-family: var(--font-sans);
            font-size: 14px; font-weight: 600;
            cursor: pointer; letter-spacing: .01em;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            transition: background .15s, transform .1s;
            margin-top: 10px;
        }
        .btn-auth:hover { background: var(--c-accent-h); transform: translateY(-1px); }
        .btn-auth:active { transform: none; }

        /* Footer note */
        .auth-foot {
            margin-top: 20px; padding-top: 20px;
            border-top: 1px solid var(--c-border);
            font-size: 13px; color: var(--c-ink-2); text-align: center;
            line-height: 1.7;
        }
        .auth-foot a { color: var(--c-accent); font-weight: 600; text-decoration: none; }
        .auth-foot a:hover { text-decoration: underline; }
        .auth-foot .divider { display: block; margin-top: 6px; color: var(--c-ink-3); font-size: 12.5px; }

        /* Alerts */
        .auth-alert {
            padding: 11px 14px; border-radius: var(--r-input);
            font-size: 13px; margin-bottom: 20px; line-height: 1.5;
        }
        .auth-alert.danger { background: #FEF2F2; color: var(--c-err); border: 1px solid #FECACA; }
        .auth-alert.success { background: #F0FDF4; color: #15803D; border: 1px solid #BBF7D0; }

        /* ── Right pane ── */
        .auth-visual {
            position: relative; overflow: hidden;
            display: flex; align-items: center; justify-content: center;
        }
        .auth-visual-bg {
            position: absolute; inset: 0;
            background-size: cover; background-position: center;
            filter: brightness(.5) saturate(1.1);
        }
        .auth-visual-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(160deg, rgba(10,18,36,.72) 0%, rgba(30,60,130,.5) 100%);
        }
        .auth-visual-body {
            position: relative; z-index: 2;
            text-align: center; padding: 48px 52px; max-width: 460px;
        }
        .auth-visual-icon {
            width: 56px; height: 56px; border-radius: 16px;
            background: rgba(255,255,255,.12); backdrop-filter: blur(8px);
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; margin: 0 auto 28px;
        }
        .auth-visual-body h2 {
            font-family: var(--font-serif);
            font-size: 30px; font-weight: 400;
            color: #fff; margin-bottom: 14px;
            line-height: 1.2;
        }
        .auth-visual-body p {
            color: rgba(255,255,255,.65);
            font-size: 14px; line-height: 1.7;
        }
        .auth-visual-stars {
            display: flex; gap: 4px; justify-content: center;
            margin-top: 36px; margin-bottom: 8px;
        }
        .auth-visual-caption {
            font-size: 12px; color: rgba(255,255,255,.45);
        }

        /* Modal overrides */
        .modal-content { border-radius: 12px; border: 1px solid var(--c-border); }
        .modal-header { border-bottom: 1px solid var(--c-border); padding: 20px 24px; }
        .modal-title { font-size: 15px; font-weight: 700; color: var(--c-ink); }
        .modal-body { padding: 24px; }
        .modal-footer { border-top: 1px solid var(--c-border); padding: 16px 24px; gap: 8px; }
        .modal .auth-field label { text-transform: none; letter-spacing: 0; font-size: 13px; font-weight: 600; }
        .modal .auth-field input { padding: 9px 14px 9px 38px; font-size: 13.5px; }
        .btn-cancel {
            padding: 9px 18px; border: 1.5px solid var(--c-border);
            border-radius: var(--r-btn); background: transparent;
            font-family: var(--font-sans); font-size: 13.5px; font-weight: 600;
            color: var(--c-ink-2); cursor: pointer; transition: border-color .15s, color .15s;
        }
        .btn-cancel:hover { border-color: var(--c-ink-2); color: var(--c-ink); }
        .btn-submit {
            padding: 9px 18px; border: none;
            border-radius: var(--r-btn); background: var(--c-accent);
            font-family: var(--font-sans); font-size: 13.5px; font-weight: 600;
            color: #fff; cursor: pointer; transition: background .15s;
        }
        .btn-submit:hover { background: var(--c-accent-h); }

        /* ── Responsive ── */
        @media (max-width: 820px) {
            .auth-shell { grid-template-columns: 1fr; }
            .auth-visual { display: none; }
            .auth-pane { padding: 48px 28px; border-right: none; }
            .auth-back { left: 28px; }
        }

        /* ── Entrance ── */
        .auth-pane  { animation: paneIn .35s ease both; }
        .auth-visual { animation: fadeIn .4s ease .1s both; }
        @keyframes paneIn {
            from { opacity:0; transform:translateX(-16px); }
            to   { opacity:1; transform:translateX(0); }
        }
        @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
    </style>
</head>

<body>
<div class="auth-shell">

    {{-- ── Left pane ── --}}
    <div class="auth-pane">

        <a href="{{ url('/') }}" class="auth-back">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>

        <div class="auth-brand">
            <img src="{{ asset('storage/images/default/' . ($web->site_logo ?? 'site_logo.png')) }}"
                 alt="{{ $web->site_name ?? 'Telegrad' }}">
            <span class="auth-brand-name">{{ $web->site_name ?? 'Telegrad' }}</span>
        </div>

        <div class="auth-title">Selamat datang</div>
        <p class="auth-subtitle">Masukkan email, username, atau no. HP dan password kamu.</p>

        {{-- Alerts --}}
        @if($errors->any())
        <div class="auth-alert danger">
            @foreach($errors->all() as $error)
                @if(!$errors->has('name') && !$errors->has('email') && !$errors->has('phone') && !$errors->has('username'))
                <div>{{ $error }}</div>
                @endif
            @endforeach
        </div>
        @endif

        @if(session('success'))
        <div class="auth-alert success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('customer.login.post') }}" method="POST" novalidate>
            @csrf

            <div class="auth-field">
                <label for="login">Email / Username / No. HP</label>
                <div class="iw">
                    <i class="bi bi-person"></i>
                    <input
                        type="text" id="login" name="login"
                        value="{{ old('login') }}"
                        placeholder="Masukkan email, username, atau no. HP"
                        class="{{ $errors->has('login') ? 'is-invalid' : '' }}"
                        autofocus>
                </div>
                @error('login') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="auth-field">
                <label for="password">Password</label>
                <div class="iw">
                    <i class="bi bi-lock"></i>
                    <input
                        type="password" id="password" name="password"
                        placeholder="Masukkan password"
                        class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                </div>
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn-auth">
                <i class="bi bi-box-arrow-in-right"></i> Masuk
            </button>
        </form>

        @include('sweetalert::alert')

        <div class="auth-foot">
            Belum punya akun?
            <a href="#" data-bs-toggle="modal" data-bs-target="#registModal">Daftar di sini</a>
            <span class="divider">
                <a href="{{ url('/') }}" style="color:var(--c-ink-3); font-weight:400;">Lanjutkan tanpa login</a>
            </span>
        </div>

    </div>

    {{-- ── Right pane ── --}}
    <div class="auth-visual">
        <div class="auth-visual-bg"
             style="background-image: url('{{ asset('storage/images/default/' . ($web->slider_1 ?? 'slider_1.jpg')) }}');">
        </div>
        <div class="auth-visual-overlay"></div>

        <div class="auth-visual-body">
            <div class="auth-visual-icon">📷</div>
            <h2>{{ $web->site_head ?? 'Abadikan Momen Terbaikmu' }}</h2>
            <p>{{ $web->site_description ?? 'Jasa foto & video profesional untuk setiap momen berharga.' }}</p>

            <div class="auth-visual-stars">
                @foreach(['⭐','⭐','⭐','⭐','⭐'] as $s)
                    <span>{{ $s }}</span>
                @endforeach
            </div>
            <p class="auth-visual-caption">Dipercaya ratusan pelanggan</p>
        </div>
    </div>

</div>

{{-- ── Modal Register ── --}}
<div class="modal fade" id="registModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('customer.register') }}" method="POST" novalidate>
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buat Akun Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <div class="auth-field">
                        <label>Nama Lengkap <span style="color:var(--c-err)">*</span></label>
                        <div class="iw">
                            <i class="bi bi-person"></i>
                            <input type="text" name="name" placeholder="Nama lengkap"
                                   value="{{ old('name') }}" required
                                   class="{{ $errors->has('name') ? 'is-invalid' : '' }}">
                        </div>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="auth-field">
                        <label>Username</label>
                        <div class="iw">
                            <i class="bi bi-at"></i>
                            <input type="text" name="username" placeholder="Username (opsional)"
                                   value="{{ old('username') }}"
                                   class="{{ $errors->has('username') ? 'is-invalid' : '' }}">
                        </div>
                        @error('username') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="auth-field">
                        <label>Email <span style="color:var(--c-err)">*</span></label>
                        <div class="iw">
                            <i class="bi bi-envelope"></i>
                            <input type="email" name="email" placeholder="Alamat email"
                                   value="{{ old('email') }}" required
                                   class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                        </div>
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="auth-field">
                        <label>No. HP / WhatsApp <span style="color:var(--c-err)">*</span></label>
                        <div class="iw">
                            <i class="bi bi-phone"></i>
                            <input type="text" name="phone" placeholder="08xxxxxxxxxx"
                                   value="{{ old('phone') }}" required
                                   class="{{ $errors->has('phone') ? 'is-invalid' : '' }}">
                        </div>
                        @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="auth-field">
                        <label>Password <span style="color:var(--c-err)">*</span></label>
                        <div class="iw">
                            <i class="bi bi-lock"></i>
                            <input type="password" name="password" placeholder="Min. 6 karakter"
                                   required class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                        </div>
                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="auth-field" style="margin-bottom:0">
                        <label>Konfirmasi Password <span style="color:var(--c-err)">*</span></label>
                        <div class="iw">
                            <i class="bi bi-lock-fill"></i>
                            <input type="password" name="password_confirmation"
                                   placeholder="Ulangi password" required>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-submit">Daftar Sekarang</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('auth/assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('auth/assets/js/core/bootstrap.min.js') }}"></script>

{{-- Buka modal otomatis jika ada error registrasi --}}
@if($errors->has('name') || $errors->has('email') || $errors->has('phone') || $errors->has('username') || $errors->has('password'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new bootstrap.Modal(document.getElementById('registModal')).show();
    });
</script>
@endif

</body>
</html>