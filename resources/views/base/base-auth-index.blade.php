<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="{{ asset('images/logo_telegrad_blue.png') }}" type="image/png">
    <title>{{ ($web->site_name ?? 'Telegrad') . ' — ' . ($submenu ?? 'Masuk') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,300&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <link href="{{ asset('root/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('auth/assets/css/nucleo-icons.css') }}" rel="stylesheet"/>
    <link href="{{ asset('auth/assets/css/nucleo-svg.css') }}" rel="stylesheet"/>
    <link href="{{ asset('auth/assets/css/argon-dashboard.min.css?v=2.0.4') }}" rel="stylesheet"/>

    <style>
        :root {
            --c-ink:      #0F1117;
            --c-ink-2:    #4B5563;
            --c-ink-3:    #9CA3AF;
            --c-surface:  #FFFFFF;
            --c-bg:       #F5F5F0;
            --c-border:   #E4E4E0;
            --c-accent:   #2563EB;
            --c-accent-h: #1D4ED8;
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
            font-family: var(--font-sans);
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
            margin-top: 28px; padding-top: 24px;
            border-top: 1px solid var(--c-border);
            font-size: 13px; color: var(--c-ink-2); text-align: center;
        }
        .auth-foot a { color: var(--c-accent); font-weight: 600; text-decoration: none; }
        .auth-foot a:hover { text-decoration: underline; }

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
            line-height: 1.2; letter-spacing: -.01em;
        }
        .auth-visual-body p {
            color: rgba(255,255,255,.65);
            font-size: 14px; line-height: 1.7;
        }
        .auth-visual-stars {
            display: flex; gap: 4px; justify-content: center;
            margin-top: 36px; margin-bottom: 8px;
        }
        .auth-visual-stars span { font-size: 16px; }
        .auth-visual-caption {
            font-size: 12px; color: rgba(255,255,255,.45); margin-top: 0;
        }

        /* ── Responsive ── */
        @media (max-width: 820px) {
            .auth-shell { grid-template-columns: 1fr; }
            .auth-visual { display: none; }
            .auth-pane { padding: 48px 28px; border-right: none; }
            .auth-back { left: 28px; }
        }

        /* ── Entrance animation ── */
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

    {{-- ── Left: Form pane ── --}}
    <div class="auth-pane">

        <a href="{{ url('/') }}" class="auth-back">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>

        <div class="auth-brand">
            <img src="{{ asset('storage/images/default/' . ($web->site_logo ?? 'site_logo.png')) }}"
                 alt="{{ $web->site_name ?? 'Telegrad' }}">
            <span class="auth-brand-name">{{ $web->site_name ?? 'Telegrad' }}</span>
        </div>

        @yield('content')

    </div>

    {{-- ── Right: Visual pane ── --}}
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

<script src="{{ asset('auth/assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('auth/assets/js/core/bootstrap.min.js') }}"></script>
</body>
</html>