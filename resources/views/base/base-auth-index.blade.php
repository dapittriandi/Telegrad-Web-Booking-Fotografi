<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{ asset('auth/assets/img/favicon.png') }}">
    <title>{{ ($web->site_name ?? 'Telegrad') . ' — ' . ($submenu ?? 'Masuk') }}</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="{{ asset('root/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

    <!-- Argon -->
    <link href="{{ asset('auth/assets/css/nucleo-icons.css') }}" rel="stylesheet"/>
    <link href="{{ asset('auth/assets/css/nucleo-svg.css') }}" rel="stylesheet"/>
    <link href="{{ asset('auth/assets/css/argon-dashboard.min.css?v=2.0.4') }}" rel="stylesheet"/>

    <style>
        :root {
            --tg-navy:  #0A1628;
            --tg-royal: #1E3A8A;
            --tg-blue:  #3B82F6;
            --tg-font:  'Plus Jakarta Sans', sans-serif;
        }

        *, body { font-family: var(--tg-font) !important; }

        /* ─── Full viewport layout ─── */
        html, body { height: 100%; margin: 0; }

        .auth-wrapper {
            min-height: 100vh;
            display: flex;
        }

        /* ─── Left panel — form ─── */
        .auth-left {
            width: 480px;
            min-width: 320px;
            max-width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px 52px;
            background: #fff;
            position: relative;
            z-index: 2;
        }

        /* ─── Right panel — visual ─── */
        .auth-right {
            flex: 1;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .auth-right-bg {
            position: absolute; inset: 0;
            background-size: cover;
            background-position: center;
            filter: brightness(.55) saturate(1.2);
        }
        .auth-right-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(160deg, rgba(10,22,40,.7) 0%, rgba(30,58,138,.55) 100%);
        }
        .auth-right-content {
            position: relative; z-index: 2;
            text-align: center; padding: 40px;
            max-width: 460px;
        }
        .auth-right-content h2 {
            font-size: 2rem; font-weight: 800;
            color: #fff; margin-bottom: 12px;
            letter-spacing: -.03em; line-height: 1.2;
        }
        .auth-right-content p {
            color: rgba(255,255,255,.75);
            font-size: .95rem; line-height: 1.6;
        }

        /* ─── Brand bar ─── */
        .auth-brand {
            display: flex; align-items: center; gap: 10px;
            margin-bottom: 40px;
        }
        .auth-brand img { height: 40px; width: auto; }
        .auth-brand-name {
            font-size: 1.25rem; font-weight: 800;
            color: var(--tg-navy); letter-spacing: -.02em;
        }

        /* ─── Heading ─── */
        .auth-heading { margin-bottom: 28px; }
        .auth-heading h1 {
            font-size: 1.65rem; font-weight: 800;
            color: var(--tg-navy); letter-spacing: -.03em;
            margin-bottom: 6px;
        }
        .auth-heading p { font-size: .85rem; color: #6B7280; }

        /* ─── Form fields ─── */
        .auth-field { margin-bottom: 16px; }
        .auth-field label {
            display: block;
            font-size: .8rem; font-weight: 600;
            color: #374151; margin-bottom: 6px;
        }
        .auth-field .input-wrap {
            position: relative;
        }
        .auth-field .input-wrap .input-icon {
            position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
            color: #9CA3AF; font-size: .95rem; pointer-events: none;
            transition: color .15s;
        }
        .auth-field input {
            width: 100%;
            padding: 10px 13px 10px 38px;
            border: 1.5px solid #E5E7EB;
            border-radius: 10px;
            font-size: .875rem;
            color: #111827;
            background: #F9FAFB;
            transition: border-color .15s, box-shadow .15s, background .15s;
            outline: none;
            box-sizing: border-box;
        }
        .auth-field input:focus {
            border-color: var(--tg-blue);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(59,130,246,.12);
        }
        .auth-field input::placeholder { color: #C4C9D4; }
        .auth-field input:focus + .input-icon,
        .auth-field .input-wrap:focus-within .input-icon { color: var(--tg-blue); }
        .auth-field .is-invalid { border-color: #EF4444 !important; }
        .auth-field .invalid-feedback { font-size: .75rem; color: #EF4444; margin-top: 4px; }

        /* ─── Submit button ─── */
        .btn-auth {
            width: 100%; padding: 12px;
            background: linear-gradient(135deg, var(--tg-royal), var(--tg-blue));
            border: none; border-radius: 10px;
            color: #fff; font-size: .9rem; font-weight: 700;
            cursor: pointer; letter-spacing: .01em;
            box-shadow: 0 4px 16px rgba(59,130,246,.35);
            transition: transform .15s, box-shadow .15s;
            margin-top: 8px;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(59,130,246,.4);
        }
        .btn-auth:active { transform: translateY(0); }

        /* ─── Footer note ─── */
        .auth-footer {
            margin-top: 28px; text-align: center;
            font-size: .8rem; color: #9CA3AF;
        }
        .auth-footer a { color: var(--tg-blue); font-weight: 600; text-decoration: none; }
        .auth-footer a:hover { text-decoration: underline; }

        /* ─── Back link ─── */
        .auth-back {
            position: absolute; top: 24px; left: 24px;
            display: flex; align-items: center; gap: 6px;
            font-size: .78rem; font-weight: 600; color: #6B7280;
            text-decoration: none; transition: color .15s;
        }
        .auth-back:hover { color: var(--tg-blue); }

        /* ─── Animated dots on right panel ─── */
        .auth-dots {
            position: absolute; inset: 0; overflow: hidden; pointer-events: none;
        }
        .auth-dots span {
            position: absolute; border-radius: 50%;
            background: rgba(255,255,255,.06);
            animation: floatDot linear infinite;
        }
        @keyframes floatDot {
            from { transform: translateY(0) scale(1); opacity: .6; }
            to   { transform: translateY(-120vh) scale(.4); opacity: 0; }
        }

        /* ─── Page fade-in ─── */
        .auth-left { animation: slideIn .4s ease both; }
        .auth-right { animation: fadeIn .5s ease .1s both; }
        @keyframes slideIn {
            from { opacity:0; transform: translateX(-20px); }
            to   { opacity:1; transform: translateX(0); }
        }
        @keyframes fadeIn {
            from { opacity:0; } to { opacity:1; }
        }

        /* ─── Responsive ─── */
        @media (max-width: 768px) {
            .auth-wrapper { flex-direction: column; }
            .auth-right { display: none; }
            .auth-left { width: 100%; padding: 36px 28px; }
        }
    </style>
</head>

<body>
<div class="auth-wrapper">

    {{-- ── Left: Form Panel ── --}}
    <div class="auth-left">

        <a href="{{ url('/') }}" class="auth-back">
            <i class="bi bi-arrow-left"></i> Kembali ke Website
        </a>

        {{-- Brand --}}
        <div class="auth-brand">
            <img src="{{ asset('storage/images/default/' . ($web->site_logo ?? 'site_logo.png')) }}"
                 alt="{{ $web->site_name ?? 'Telegrad' }}">
            <span class="auth-brand-name">{{ $web->site_name ?? 'Telegrad' }}</span>
        </div>

        {{-- Form content from child views --}}
        @yield('content')

    </div>

    {{-- ── Right: Visual Panel ── --}}
    <div class="auth-right">
        <div class="auth-right-bg"
             style="background-image: url('{{ asset('storage/images/default/' . ($web->slider_1 ?? 'slider_1.jpg')) }}');">
        </div>
        <div class="auth-right-overlay"></div>

        {{-- Floating dots decoration --}}
        <div class="auth-dots" id="authDots"></div>

        <div class="auth-right-content">
            <div style="width:64px; height:64px; border-radius:20px;
                        background:rgba(255,255,255,.15); backdrop-filter:blur(8px);
                        display:flex; align-items:center; justify-content:center;
                        margin:0 auto 24px; font-size:1.8rem;">
                📷
            </div>
            <h2>{{ $web->site_head ?? 'Abadikan Momen Terbaikmu' }}</h2>
            <p>{{ $web->site_description ?? 'Jasa foto & video profesional untuk setiap momen berharga dalam hidupmu.' }}</p>

            <div style="display:flex; gap:10px; justify-content:center; margin-top:32px;">
                @foreach(['⭐', '⭐', '⭐', '⭐', '⭐'] as $star)
                <span style="font-size:1.1rem;">{{ $star }}</span>
                @endforeach
            </div>
            <p style="color:rgba(255,255,255,.6); font-size:.8rem; margin-top:8px;">
                Dipercaya ratusan pelanggan
            </p>
        </div>
    </div>

</div>

<script src="{{ asset('auth/assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('auth/assets/js/core/bootstrap.min.js') }}"></script>
<script>
    // Generate floating dots
    const container = document.getElementById('authDots');
    for (let i = 0; i < 12; i++) {
        const dot = document.createElement('span');
        const size = Math.random() * 80 + 20;
        dot.style.cssText = `
            width:${size}px; height:${size}px;
            left:${Math.random() * 100}%;
            top:${Math.random() * 100 + 100}%;
            animation-duration:${Math.random() * 20 + 15}s;
            animation-delay:${Math.random() * -20}s;
        `;
        container.appendChild(dot);
    }
</script>
</body>
</html>