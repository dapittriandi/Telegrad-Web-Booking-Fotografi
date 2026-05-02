<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="dark light">
    <title>{{ isset($title) ? $title . ' — ' : '' }}{{ $web->site_name ?? config('app.name', 'Telegrad') }}</title>
    <meta name="description" content="{{ $web->site_description ?? 'Jasa foto & video wisuda profesional di Jambi' }}">

<link rel="icon" href="{{ asset('images/logo_telegrad_gold.png') }}" type="image/png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">

    <!-- Libs -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">

    <style>
        /* =====================================================
           DESIGN TOKENS — DARK MODE (default)
        ===================================================== */
        :root,
        [data-theme="dark"] {
            --bg:            #0b0c0e;
            --surface:       #111214;
            --card:          #16181c;
            --card-hover:    #1c1e23;
            --border:        rgba(255,255,255,0.07);
            --border-strong: rgba(255,255,255,0.12);

            --gold:          #c8a96e;
            --gold-light:    #e2c98a;
            --gold-dim:      rgba(200,169,110,0.12);
            --gold-border:   rgba(200,169,110,0.22);

            --text:          #f0ede8;
            --muted:         #8a8880;
            --dim:           #555350;
            --success:       #4caf82;
            --danger:        #e05c5c;

            --nav-bg:        rgba(11,12,14,0.0);
            --nav-bg-scroll: rgba(11,12,14,0.92);
            --nav-border:    rgba(255,255,255,0.07);
            --footer-bg:     #0e0f11;

            /* Bottom nav */
            --bottom-nav-bg: rgba(14,15,17,0.96);
            --bottom-nav-border: rgba(255,255,255,0.08);

            --shadow-sm:     0 4px 16px rgba(0,0,0,0.3);
            --shadow-md:     0 12px 40px rgba(0,0,0,0.45);
            --shadow-lg:     0 24px 64px rgba(0,0,0,0.55);

            --theme-icon:    "☀️";
        }

        /* =====================================================
           DESIGN TOKENS — LIGHT MODE
        ===================================================== */
        [data-theme="light"] {
            --bg:            #f8f6f2;
            --surface:       #ffffff;
            --card:          #ffffff;
            --card-hover:    #faf9f7;
            --border:        rgba(0,0,0,0.08);
            --border-strong: rgba(0,0,0,0.14);

            --gold:          #a8873e;
            --gold-light:    #c8a96e;
            --gold-dim:      rgba(168,135,62,0.10);
            --gold-border:   rgba(168,135,62,0.22);

            --text:          #1a1814;
            --muted:         #6b6660;
            --dim:           #a09890;
            --success:       #2e8b5a;
            --danger:        #c0392b;

            --nav-bg:        rgba(248,246,242,0.0);
            --nav-bg-scroll: rgba(255,255,255,0.95);
            --nav-border:    rgba(0,0,0,0.08);
            --footer-bg:     #1a1814;

            /* Bottom nav */
            --bottom-nav-bg: rgba(255,255,255,0.97);
            --bottom-nav-border: rgba(0,0,0,0.10);

            --shadow-sm:     0 4px 16px rgba(0,0,0,0.08);
            --shadow-md:     0 12px 40px rgba(0,0,0,0.12);
            --shadow-lg:     0 24px 64px rgba(0,0,0,0.15);

            --theme-icon:    "🌙";
        }

        /* =====================================================
           RESET & BASE
        ===================================================== */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html {
            scroll-behavior: smooth;
            /* Offset anchor link agar tidak tertutup navbar */
            scroll-padding-top: 80px;
        }
        @media (max-width: 768px) {
            html { scroll-padding-top: 64px; }
        }
        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            font-size: 16px;
            line-height: 1.7;
            font-weight: 300;
            -webkit-font-smoothing: antialiased;
            transition: background 0.35s ease, color 0.35s ease;
            /* Space for bottom nav on mobile */
            padding-bottom: 0;
        }
        @media (max-width: 768px) {
            body { padding-bottom: 72px; }
        }
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: var(--bg); }
        ::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 10px; }

        /* =====================================================
           NAVBAR — Desktop only (hidden on mobile)
        ===================================================== */
        #navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1000;
            height: 68px;
            display: flex;
            align-items: center;
            padding: 0;
            background: var(--nav-bg);
            transition: background 0.35s ease, box-shadow 0.35s ease, backdrop-filter 0.35s ease;
            /* GPU layer hanya saat diperlukan (mobile override di bawah) */
            transform: translateZ(0);
            -webkit-transform: translateZ(0);
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
        }
        /* Desktop: lepas will-change agar tidak buang memori GPU */
        @media (min-width: 769px) {
            #navbar { will-change: auto; }
        }
        #navbar .container {
            height: 100%;
            display: flex;
            align-items: center;
        }
        #navbar.scrolled {
            background: rgba(10, 11, 13, 0.55);
            backdrop-filter: blur(28px) saturate(180%);
            -webkit-backdrop-filter: blur(28px) saturate(180%);
            border-bottom: 1px solid rgba(255,255,255,0.055);
            box-shadow: 0 2px 40px rgba(0,0,0,0.3);
        }
        [data-theme="light"] #navbar.scrolled {
            background: rgba(252, 250, 247, 0.92);
            border-bottom: 1px solid rgba(0,0,0,0.08);
            box-shadow: 0 2px 24px rgba(0,0,0,0.09);
        }
        .nav-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text) !important;
            text-decoration: none;
            letter-spacing: -0.5px;
            flex-shrink: 0;
        }
        .nav-logo span { color: var(--gold); }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            list-style: none;
            margin: 0; padding: 0;
        }
        .nav-links a {
            display: block;
            padding: 0.45rem 0.9rem;
            color: var(--muted);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 400;
            border-radius: 6px;
            transition: color 0.25s, background 0.25s;
        }
        .nav-links a:hover,
        .nav-links a.active {
            color: var(--text);
            background: var(--gold-dim);
        }
        .nav-links a.active { color: var(--gold); }

        /* CTA button in nav */
        .nav-cta {
            padding: 0.45rem 1.1rem !important;
            background: var(--gold) !important;
            color: #1a1410 !important;
            border-radius: 6px !important;
            font-weight: 500 !important;
            font-size: 0.85rem !important;
            transition: opacity 0.25s !important;
        }
        .nav-cta:hover { opacity: 0.85 !important; background: var(--gold) !important; }

        /* Theme toggle button */
        .theme-toggle {
            width: 36px; height: 36px;
            display: flex; align-items: center; justify-content: center;
            background: var(--gold-dim);
            border: 1px solid var(--gold-border);
            border-radius: 8px;
            color: var(--gold);
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.25s, transform 0.2s;
            flex-shrink: 0;
        }
        .theme-toggle:hover {
            background: var(--gold);
            color: #1a1410;
            transform: rotate(15deg);
        }

        /* Hide hamburger — no longer needed */
        .nav-toggle { display: none !important; }

        /* On mobile: hide desktop nav links */
        @media (max-width: 768px) {
            .nav-links { display: none !important; }
            /* Keep navbar visible on mobile for logo only */
            #navbar {
                height: 56px;
                padding: 0;
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                right: 0 !important;
                transform: none !important;
                will-change: auto;
            }
            #navbar .container {
                height: 56px;
            }
            #navbar.scrolled {
                background: var(--nav-bg-scroll);
            }
        }

        /* =====================================================
           USER DROPDOWN — Glassmorphism
        ===================================================== */
        /* #user-dropdown-wrap moved to portal — no longer in nav flow */

        #user-nav-dropdown {
            /* HIDDEN by default — display:none is the only reliable way */
            display: none;

            /* Fixed to viewport — JS sets top/right dynamically */
            position: fixed;
            top: 72px;
            right: 1.5rem;

            /* Glassmorphism */
            background: rgba(14, 15, 17, 0.78);
            backdrop-filter: blur(32px) saturate(180%);
            -webkit-backdrop-filter: blur(32px) saturate(180%);
            border: 1px solid rgba(200, 169, 110, 0.15);
            border-radius: 16px;
            min-width: 230px;
            padding: 8px;
            box-shadow:
                0 16px 48px rgba(0,0,0,0.55),
                0 1px 0 rgba(255,255,255,0.05) inset,
                0 0 0 0.5px rgba(200,169,110,0.08);
            z-index: 9999;

            /* Animation via JS-toggled class */
            opacity: 0;
            transform: translateY(6px) scale(0.97);
            transition: opacity 0.2s ease, transform 0.2s cubic-bezier(0.34,1.2,0.64,1);
        }

        [data-theme="light"] #user-nav-dropdown {
            background: rgba(255, 255, 255, 0.82);
            border-color: rgba(168, 135, 62, 0.2);
            box-shadow:
                0 8px 32px rgba(0,0,0,0.12),
                0 1px 0 rgba(255,255,255,0.8) inset;
        }

        /* Open state — JS adds this class */
        #user-nav-dropdown.dd-open {
            display: block;
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .udd-header {
            padding: 10px 12px 10px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
            margin-bottom: 4px;
        }
        [data-theme="light"] .udd-header {
            border-bottom-color: rgba(0,0,0,0.07);
        }
        .udd-name { font-size: 0.82rem; font-weight: 600; color: var(--text); }
        .udd-email { font-size: 0.7rem; color: var(--muted); margin-top: 1px; }

        .udd-link {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px; border-radius: 10px;
            font-size: 0.82rem; color: var(--muted);
            text-decoration: none;
            transition: background 0.18s, color 0.18s;
        }
        .udd-link i { color: var(--gold); width: 16px; font-size: 0.9rem; flex-shrink: 0; }
        .udd-link:hover {
            background: rgba(200,169,110,0.10);
            color: var(--text);
        }
        .udd-sep { border-top: 1px solid rgba(255,255,255,0.06); margin: 4px 0; }
        [data-theme="light"] .udd-sep { border-top-color: rgba(0,0,0,0.07); }
        .udd-logout {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px; border-radius: 10px;
            font-size: 0.82rem; color: var(--danger);
            background: none; border: none;
            width: 100%; cursor: pointer;
            transition: background 0.18s;
        }
        .udd-logout:hover { background: rgba(224,92,92,0.08); }

        /* =====================================================
           MOBILE-ONLY ELEMENTS — desktop: always hidden
        ===================================================== */
        #bottom-nav        { display: none; }
        #bn-user-sheet     { display: none; }
        #bn-sheet-overlay  { display: none; }
        #mobile-topbar-right { display: none; }
        /* Sembunyikan mobile-theme-btn di desktop */
        #mobile-theme-btn  { display: none !important; }

        /* =====================================================
           MOBILE TOP BAR RIGHT (theme + profile icons)
        ===================================================== */
        /* Defined here for positioning, shown only in media query */
        #mobile-topbar-right {
            position: fixed;
            top: 0; right: 0;
            height: 56px;
            display: none; /* overridden in media query */
            align-items: center;
            gap: 8px;
            padding: 0 14px;
            z-index: 1010;
            /* Cegah gerak saat scroll */
            transform: translateZ(0);
            -webkit-transform: translateZ(0);
            will-change: transform;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
        }
        #mobile-theme-btn {
            width: 34px; height: 34px;
            display: flex; align-items: center; justify-content: center;
            background: rgba(200,169,110,0.08);
            border: 1px solid rgba(200,169,110,0.18);
            border-radius: 10px;
            color: var(--gold);
            font-size: 0.95rem;
            cursor: pointer;
            transition: background 0.2s;
            -webkit-tap-highlight-color: transparent;
        }
        #mobile-profile-btn {
            width: 34px; height: 34px;
            display: flex; align-items: center; justify-content: center;
            background: var(--gold);
            border: none;
            border-radius: 10px;
            cursor: pointer;
            overflow: hidden;
            -webkit-tap-highlight-color: transparent;
            padding: 0;
        }
        #mobile-profile-btn img {
            width: 100%; height: 100%;
            object-fit: cover;
        }
        #mobile-profile-btn i {
            font-size: 1rem;
            color: #1a1410;
        }

        /* =====================================================
           BOTTOM NAVIGATION BAR — Mobile
        ===================================================== */
        /* Bottom sheet overlay */
        #bn-sheet-overlay {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1049;
            opacity: 0;
            transition: opacity 0.25s;
        }
        #bn-user-sheet {
            position: fixed;
            bottom: 64px; left: 0; right: 0;
            background: var(--card);
            border: 1px solid rgba(200,169,110,0.12);
            border-radius: 20px 20px 0 0;
            padding: 12px 12px 0;
            z-index: 1050;
            box-shadow: 0 -8px 40px rgba(0,0,0,0.45);
            transform: translateY(calc(100% + 64px));
            transition: transform 0.3s cubic-bezier(0.4,0,0.2,1);
        }
        #bn-user-sheet.open  { transform: translateY(0); }
        .bn-sheet-handle {
            width: 32px; height: 3px;
            background: var(--border-strong);
            border-radius: 2px;
            margin: 0 auto 12px;
        }

        @media (max-width: 768px) {

            /* Show mobile-only elements */
            #mobile-topbar-right { display: flex !important; }
            #bn-user-sheet       { display: block; }
            #bn-sheet-overlay    { display: block; }
            /* Override: tampilkan theme btn di mobile */
            #mobile-theme-btn    { display: flex !important; }

            /* Bottom nav bar */
            #bottom-nav {
                display: flex !important;
                position: fixed;
                bottom: 0; left: 0; right: 0;
                z-index: 1100;
                height: 64px;
                background: var(--bottom-nav-bg);
                backdrop-filter: blur(20px) saturate(160%);
                -webkit-backdrop-filter: blur(20px) saturate(160%);
                border-top: 1px solid var(--bottom-nav-border);
                align-items: stretch;
                padding-bottom: env(safe-area-inset-bottom, 0px);
                /* Cegah bottom nav gerak/jitter saat scroll */
                transform: translateZ(0);
                -webkit-transform: translateZ(0);
                will-change: transform;
                backface-visibility: hidden;
                -webkit-backface-visibility: hidden;
            }

            /* Nav items */
            .bn-item {
                flex: 1;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 4px;
                text-decoration: none;
                color: var(--muted);
                border: none;
                background: none;
                cursor: pointer;
                position: relative;
                padding: 6px 4px;
                transition: color 0.18s;
                -webkit-tap-highlight-color: transparent;
            }

            /* Minimal clean SVG-style icons via Bootstrap Icons */
            .bn-item i {
                font-size: 1.35rem;
                line-height: 1;
                transition: transform 0.18s cubic-bezier(0.34,1.4,0.64,1);
                display: block;
            }

            .bn-item span {
                font-size: 0.58rem;
                font-weight: 500;
                letter-spacing: 0.15px;
                line-height: 1;
            }

            /* Active state */
            .bn-item.active { color: var(--gold); }
            .bn-item.active i { transform: translateY(-1px); }

            /* Active pill indicator */
            .bn-item.active::before {
                content: '';
                position: absolute;
                top: 0;
                left: 50%;
                transform: translateX(-50%);
                width: 20px; height: 2px;
                background: var(--gold);
                border-radius: 0 0 2px 2px;
            }

            /* Tap feedback */
            .bn-item:active i { transform: scale(0.87); }

            /* User avatar in bottom nav */
            .bn-avatar {
                width: 24px; height: 24px;
                border-radius: 50%;
                object-fit: cover;
                border: 1.5px solid transparent;
                transition: border-color 0.18s;
                display: block;
            }
            .bn-item.active .bn-avatar { border-color: var(--gold); }
        }

        /* =====================================================
           BREADCRUMBS
        ===================================================== */
        .breadcrumbs {
            position: relative;
            min-height: 240px;
            display: flex;
            align-items: flex-end;
            padding: calc(68px + 2.5rem) 0 3rem;
            background-size: cover;
            background-position: center;
            overflow: hidden;
        }
        @media (max-width: 768px) {
            .breadcrumbs {
                padding: calc(56px + 2rem) 0 2.5rem;
            }
        }
        .breadcrumbs::before {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(to bottom, rgba(11,12,14,0.45), rgba(11,12,14,0.82));
        }
        .breadcrumbs > .container { position: relative; z-index: 1; }
        .breadcrumbs h2 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.8rem, 4vw, 3rem);
            font-weight: 600;
            color: #f0ede8;
            margin-bottom: 0.75rem;
        }
        .breadcrumbs ol {
            display: flex; gap: 0.5rem; align-items: center;
            list-style: none; padding: 0; margin: 0;
        }
        .breadcrumbs ol li { font-size: 0.85rem; color: rgba(240,237,232,0.6); }
        .breadcrumbs ol li a { color: var(--gold); text-decoration: none; }
        .breadcrumbs ol li a:hover { color: var(--gold-light); }
        .breadcrumbs ol li + li::before {
            content: '/';
            margin-right: 0.5rem;
            color: rgba(240,237,232,0.3);
        }

        /* =====================================================
           SECTIONS
        ===================================================== */
        section { padding: 5rem 0; }
        .section-bg { background: var(--surface); }

        .section-label {
            display: inline-block;
            font-size: 0.68rem; font-weight: 600;
            letter-spacing: 0.18em; text-transform: uppercase;
            color: var(--gold);
            border: 1px solid var(--gold-border);
            padding: 4px 14px; border-radius: 100px;
            margin-bottom: 1rem;
        }
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.6rem, 3vw, 2.5rem);
            font-weight: 600; color: var(--text);
            margin-bottom: 0.75rem; line-height: 1.2;
        }
        .section-subtitle {
            font-size: 0.95rem; color: var(--muted);
            max-width: 540px; margin: 0 auto; line-height: 1.8;
        }
        .line-accent {
            width: 36px; height: 2px;
            background: var(--gold); margin-bottom: 1rem;
        }
        .line-accent.centered { margin: 0 auto 1rem; }

        /* =====================================================
           BUTTONS
        ===================================================== */
        .btn-gold {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.72rem 1.6rem;
            background: var(--gold); color: #1a1410;
            font-size: 0.875rem; font-weight: 500;
            border-radius: 6px; text-decoration: none;
            border: none; cursor: pointer;
            transition: opacity 0.25s, transform 0.2s, box-shadow 0.25s;
        }
        .btn-gold:hover {
            opacity: 0.88; transform: translateY(-1px);
            color: #1a1410; box-shadow: 0 6px 20px rgba(200,169,110,0.3);
        }
        .btn-outline-gold {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.7rem 1.6rem;
            border: 1px solid var(--gold-border); color: var(--gold);
            font-size: 0.875rem; font-weight: 400;
            border-radius: 6px; text-decoration: none;
            background: transparent; cursor: pointer;
            transition: background 0.25s, border-color 0.25s, color 0.25s;
        }
        .btn-outline-gold:hover {
            background: var(--gold-dim);
            border-color: var(--gold); color: var(--gold-light);
        }

        /* =====================================================
           BADGE
        ===================================================== */
        .badge-gold {
            display: inline-block; padding: 0.28rem 0.75rem;
            background: var(--gold-dim); border: 1px solid var(--gold-border);
            color: var(--gold); font-size: 0.7rem; font-weight: 500;
            letter-spacing: 0.5px; border-radius: 100px;
        }

        /* =====================================================
           PORTFOLIO FILTER (Isotope)
        ===================================================== */
        .portfolio-flters {
            display: flex; flex-wrap: wrap; gap: 0.5rem;
            list-style: none; padding: 0; margin: 0 0 2.5rem;
        }
        .portfolio-flters li {
            padding: 0.45rem 1.1rem;
            font-size: 0.8rem; font-weight: 400;
            color: var(--muted);
            border: 1px solid var(--border);
            border-radius: 100px; cursor: pointer;
            transition: all 0.25s; user-select: none;
        }
        .portfolio-flters li:hover { color: var(--text); border-color: var(--gold-border); }
        .portfolio-flters li.filter-active {
            background: var(--gold); color: #1a1410;
            border-color: var(--gold); font-weight: 500;
        }

        /* =====================================================
           PORTFOLIO GRID
        ===================================================== */
        .portfolio-grid-item {
            position: relative; border-radius: 12px;
            overflow: hidden; cursor: pointer;
        }
        .portfolio-grid-item img {
            width: 100%; display: block;
            transition: transform 0.6s ease;
        }
        .portfolio-grid-item:hover img { transform: scale(1.06); }
        .portfolio-grid-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(11,12,14,0.9) 0%, transparent 55%);
            display: flex; flex-direction: column;
            justify-content: flex-end; padding: 1.25rem;
            opacity: 0; transition: opacity 0.28s;
        }
        .portfolio-grid-item:hover .portfolio-grid-overlay { opacity: 1; }
        .portfolio-grid-overlay h4 {
            font-family: 'Playfair Display', serif;
            font-size: 1rem; font-weight: 600;
            color: #f0ede8; margin-bottom: 0.3rem;
        }
        .portfolio-grid-overlay p {
            font-size: 0.78rem; color: rgba(240,237,232,0.7);
        }

        /* =====================================================
           PACKAGE CARDS
        ===================================================== */
        .package-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            transition: transform 0.28s cubic-bezier(0.4,0,0.2,1),
                        box-shadow 0.28s ease,
                        border-color 0.28s ease;
            height: 100%;
        }
        .package-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-md);
            border-color: var(--gold-border);
        }
        .package-card.featured {
            border-color: var(--gold-border);
            box-shadow: 0 0 0 1px var(--gold-border), var(--shadow-sm);
        }
        .pkg-img-wrap { position: relative; overflow: hidden; height: 200px; }
        .pkg-img-wrap img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s; }
        .package-card:hover .pkg-img-wrap img { transform: scale(1.06); }
        .pkg-badge {
            position: absolute; top: 12px; left: 12px;
            padding: 4px 10px; border-radius: 100px;
            font-size: 0.65rem; font-weight: 600; letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .pkg-badge-gold { background: var(--gold); color: #1a1410; }
        .pkg-badge-pop  { background: #4caf82; color: #fff; }
        .pkg-body { padding: 1.5rem; }
        .pkg-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.15rem; font-weight: 600;
            color: var(--text); margin-bottom: 0.35rem;
        }
        .pkg-desc { font-size: 0.83rem; color: var(--muted); margin-bottom: 1.1rem; line-height: 1.7; }
        .pkg-features { list-style: none; padding: 0; margin: 0 0 1.25rem; }
        .pkg-features li {
            display: flex; align-items: flex-start; gap: 0.6rem;
            font-size: 0.82rem; color: var(--muted);
            padding: 0.3rem 0;
            border-bottom: 1px solid var(--border);
        }
        .pkg-features li:last-child { border-bottom: none; }
        .pkg-features li i { color: var(--gold); font-size: 0.75rem; margin-top: 3px; flex-shrink: 0; }
        .pkg-footer {
            padding: 1rem 1.5rem 1.5rem;
            display: flex; align-items: center; justify-content: space-between;
            border-top: 1px solid var(--border);
        }

        /* =====================================================
           WHY CARDS
        ===================================================== */
        .why-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 2rem 1.75rem;
            transition: transform 0.28s ease, border-color 0.28s, box-shadow 0.28s;
            height: 100%;
        }
        .why-card:hover {
            transform: translateY(-4px);
            border-color: var(--gold-border);
            box-shadow: var(--shadow-sm);
        }
        .why-icon {
            width: 48px; height: 48px;
            background: var(--gold-dim);
            border: 1px solid var(--gold-border);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; color: var(--gold);
            margin-bottom: 1.25rem;
        }
        .why-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.05rem; font-weight: 600;
            color: var(--text); margin-bottom: 0.5rem;
        }
        .why-desc { font-size: 0.85rem; color: var(--muted); line-height: 1.8; }

        /* =====================================================
           TESTIMONIALS
        ===================================================== */
        .testimonial-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 2rem;
            height: 100%;
            position: relative;
        }
        .testimonial-card::before {
            content: '\201C';
            font-family: 'Playfair Display', serif;
            font-size: 4rem; line-height: 1;
            color: var(--gold); opacity: 0.25;
            position: absolute; top: 1rem; left: 1.5rem;
        }
        .testimonial-stars { color: var(--gold); font-size: 0.85rem; margin-bottom: 0.75rem; }
        .testimonial-text { color: var(--muted); font-size: 0.88rem; line-height: 1.8; margin-bottom: 1.25rem; }
        .testimonial-author { font-weight: 500; font-size: 0.88rem; color: var(--text); }

        /* =====================================================
           HERO (Home)
        ===================================================== */
        .hero {
            position: relative;
            min-height: 100svh;
            min-height: 100vh; /* fallback browser lama */
            min-height: 100svh; /* modern: exclude browser UI */
            display: flex; align-items: center; justify-content: center;
            overflow: hidden;
            padding-top: 68px;
        }
        @media (max-width: 768px) {
            .hero { padding-top: 56px; }
        }

        /* =====================================================
           FOOTER
        ===================================================== */
        footer {
            background: var(--footer-bg);
            padding: 5rem 0 3rem;
            border-top: 1px solid var(--border);
        }
        @media (max-width: 768px) {
            footer {
                /* Tambah ruang untuk bottom nav (64px) + sedikit buffer */
                padding-bottom: calc(64px + 2rem);
            }
        }
        .footer-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem; font-weight: 700;
            color: #f0ede8 !important;
            text-decoration: none;
        }
        .footer-logo span { color: var(--gold); }
        .footer-tagline { font-size: 0.875rem; color: var(--muted); line-height: 1.8; max-width: 260px; }
        .footer-social { display: flex; gap: 0.75rem; flex-wrap: wrap; }
        .footer-social a {
            width: 38px; height: 38px;
            background: var(--card); border: 1px solid var(--border);
            border-radius: 10px; display: flex; align-items: center;
            justify-content: center; color: var(--muted);
            text-decoration: none; font-size: 1rem;
            transition: all 0.25s;
        }
        .footer-social a:hover { background: var(--gold); color: #1a1410; border-color: var(--gold); }
        .footer-heading { font-size: 0.75rem; font-weight: 600; letter-spacing: 0.12em; text-transform: uppercase; color: var(--muted); margin-bottom: 1.1rem; }
        .footer-links { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.6rem; }
        .footer-links a { color: var(--dim); text-decoration: none; font-size: 0.875rem; transition: color 0.2s; }
        .footer-links a:hover { color: var(--gold); }
        .footer-contact-item { display: flex; align-items: flex-start; gap: 0.75rem; margin-bottom: 0.75rem; }
        .footer-contact-item i { color: var(--gold); font-size: 0.9rem; margin-top: 3px; flex-shrink: 0; }
        .footer-contact-item span, .footer-contact-item a { font-size: 0.875rem; color: var(--dim); text-decoration: none; }
        .footer-contact-item a:hover { color: var(--gold); }
        .footer-divider { border-color: var(--border); margin: 3rem 0 2rem; }
        .footer-bottom { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.5rem; }
        .footer-copy { font-size: 0.8rem; color: var(--dim); margin: 0; }

        /* =====================================================
           FORM ELEMENTS
        ===================================================== */
        .form-control-dark {
            background: var(--surface) !important;
            border: 1px solid var(--border) !important;
            color: var(--text) !important;
            border-radius: 8px !important;
            font-size: 0.875rem !important;
            padding: 0.65rem 1rem !important;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control-dark:focus {
            border-color: var(--gold-border) !important;
            box-shadow: 0 0 0 3px var(--gold-dim) !important;
            outline: none;
        }
        .form-control-dark::placeholder { color: var(--dim); }
        .form-label-dark { font-size: 0.82rem; font-weight: 500; color: var(--muted); margin-bottom: 0.4rem; }

        /* =====================================================
           ALERTS
        ===================================================== */
        .alert-gold {
            background: var(--gold-dim);
            border: 1px solid var(--gold-border);
            border-radius: 10px; padding: 0.85rem 1.1rem;
            font-size: 0.875rem; color: var(--gold-light);
        }

        /* =====================================================
           MODAL
        ===================================================== */
        .modal-content {
            background: var(--card) !important;
            border: 1px solid var(--gold-border) !important;
            border-radius: 16px !important;
        }
        .modal-header {
            border-bottom: 1px solid var(--border) !important;
            padding: 1.25rem 1.5rem !important;
        }
        .modal-title { color: var(--text) !important; font-family: 'Playfair Display', serif; }
        .btn-close { filter: var(--text) == '#f0ede8' ? invert(1) : none; }
        [data-theme="dark"] .btn-close { filter: invert(1) opacity(0.6); }
        .modal-body { padding: 1.5rem !important; }
        .modal-body p { color: var(--muted); font-size: 0.9rem; margin-bottom: 1.25rem; }

        /* =====================================================
           MISC UTILITIES
        ===================================================== */
        .price-tag { font-family: 'Playfair Display', serif; font-size: 1.3rem; font-weight: 600; color: var(--gold); }
        .text-muted-custom { color: var(--muted); }
        .text-accent { color: var(--gold); }
        .text-gold { color: var(--gold); }

        /* =====================================================
           ACCESSIBILITY — Reduced Motion
        ===================================================== */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
            }
            /* AOS: nonaktifkan transform bawaan */
            [data-aos] {
                opacity: 1 !important;
                transform: none !important;
                transition: none !important;
            }
            .package-card:hover,
            .why-card:hover,
            .portfolio-grid-item:hover img,
            .package-card:hover .pkg-img-wrap img {
                transform: none !important;
            }
        }

        /* Prevent AOS flash */
        [data-aos] { opacity: 1 !important; }
        .aos-animate { opacity: 1 !important; }

        @media (max-width: 576px) {
            section { padding: 3.5rem 0; }
            .footer-bottom { flex-direction: column; text-align: center; }
        }

        /* =====================================================
           THEME TRANSITION SMOOTHING
        ===================================================== */
        *,
        .package-card,
        .testimonial-card,
        .why-card,
        .cat-card,
        .pkg-card,
        .form-card,
        .info-card,
        .price-card,
        .sidebar-card {
            transition-property: background-color, border-color, color, box-shadow;
            transition-duration: 0.3s;
            transition-timing-function: ease;
        }
        /* Avoid transition conflict with hover transforms */
        .package-card, .testimonial-card, .why-card, .cat-card, .pkg-card {
            transition: background-color 0.3s ease, border-color 0.3s ease,
                        color 0.3s ease, box-shadow 0.3s ease,
                        transform 0.28s cubic-bezier(0.4,0,0.2,1);
        }
    </style>

    @stack('css')
</head>
<body>

{{-- ======= NAVBAR (Desktop only — logo stays visible on mobile) ======= --}}
<nav id="navbar">
    <div class="container d-flex align-items-center justify-content-between gap-3">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="nav-logo">
            Tele<span>grad</span>
        </a>

        {{-- Desktop Nav links (hidden on mobile) --}}
        <ul class="nav-links" id="navLinks">
            <li>
                <a href="{{ route('home') }}"
                   class="{{ request()->routeIs('home') ? 'active' : '' }}">
                    Beranda
                </a>
            </li>
            <li>
                <a href="{{ route('packages.categories') }}"
                   class="{{ request()->is('packages*') ? 'active' : '' }}">
                    Paket
                </a>
            </li>
            <li>
                <a href="{{ route('portfolio.index') }}"
                   class="{{ request()->is('portfolio*') ? 'active' : '' }}">
                    Portofolio
                </a>
            </li>
            <li>
                <a href="{{ route('contact') }}"
                   class="{{ request()->is('contact*') ? 'active' : '' }}">
                    Kontak
                </a>
            </li>

            {{-- Theme Toggle (desktop) --}}
            <li>
                <button class="theme-toggle" id="themeToggle" aria-label="Toggle tema" title="Toggle Dark/Light Mode">
                    <i class="bi bi-sun-fill" id="themeIcon"></i>
                </button>
            </li>

            {{-- Auth --}}
            @auth
            <li>
                <button class="nav-cta d-flex align-items-center gap-2" id="user-nav-btn" style="border:none;cursor:pointer;">
                    <img src="{{ Auth::user()->photo
                        ? asset('storage/images/profile/' . Auth::user()->photo)
                        : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=c8a96e&color=1a1408&size=32' }}"
                         style="width:22px;height:22px;border-radius:50%;object-fit:cover;"
                         alt="{{ Auth::user()->name }}">
                    <span>{{ Str::words(Auth::user()->name, 1, '') }}</span>
                    <i class="bi bi-chevron-down" id="udd-chevron" style="font-size:.6rem;transition:transform 0.2s;"></i>
                </button>
            </li>
            @else
            <li>
                <a href="{{ route('customer.login') }}" class="nav-cta">
                    <i class="bi bi-box-arrow-in-right" style="font-size:.8rem;"></i> Masuk
                </a>
            </li>
            @endauth
        </ul>
    </div>
</nav>

{{-- ======= DESKTOP USER DROPDOWN PORTAL (outside navbar flow) ======= --}}
@auth
<div id="user-nav-dropdown" role="menu" aria-label="Menu akun">
    <div class="udd-header">
        <div style="display:flex;align-items:center;gap:10px;">
            <img src="{{ Auth::user()->photo
                ? asset('storage/images/profile/' . Auth::user()->photo)
                : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=c8a96e&color=1a1408&size=64' }}"
                 style="width:36px;height:36px;border-radius:50%;object-fit:cover;border:2px solid rgba(200,169,110,0.35);"
                 alt="{{ Auth::user()->name }}">
            <div>
                <div class="udd-name">{{ Auth::user()->name }}</div>
                <div class="udd-email">{{ Auth::user()->email }}</div>
            </div>
        </div>
    </div>
    <a href="{{ route('customer.orders') }}" class="udd-link">
        <i class="bi bi-list-check"></i> Pesanan Saya
    </a>
    <a href="{{ route('customer.profile') }}" class="udd-link">
        <i class="bi bi-person-gear"></i> Profil Saya
    </a>
    <a href="{{ route('packages.categories') }}" class="udd-link">
        <i class="bi bi-camera"></i> Pesan Foto
    </a>
    <div class="udd-sep"></div>
    <form action="{{ route('customer.logout') }}" method="POST">
        @csrf
        <button type="submit" class="udd-logout">
            <i class="bi bi-box-arrow-right"></i> Keluar
        </button>
    </form>
</div>
@endauth

{{-- ======= MOBILE: Topbar kanan (theme toggle) ======= --}}
<div id="mobile-topbar-right">
    <button id="mobile-theme-btn" aria-label="Toggle tema">
        <i class="bi bi-sun-fill" id="mobileThemeIcon"></i>
    </button>
</div>

{{-- ======= BOTTOM NAVIGATION (Mobile only — Instagram style) ======= --}}
<nav id="bottom-nav" role="navigation" aria-label="Navigasi utama">

    {{-- Beranda --}}
    <a href="{{ route('home') }}"
       class="bn-item {{ request()->routeIs('home') ? 'active' : '' }}"
       aria-label="Beranda">
        <i class="bi {{ request()->routeIs('home') ? 'bi-house-fill' : 'bi-house' }}"></i>
        <span>Beranda</span>
    </a>

    {{-- Paket --}}
    <a href="{{ route('packages.categories') }}"
       class="bn-item {{ request()->is('packages*') ? 'active' : '' }}"
       aria-label="Paket">
        <i class="bi {{ request()->is('packages*') ? 'bi-grid-fill' : 'bi-grid' }}"></i>
        <span>Paket</span>
    </a>

    {{-- Pesan Foto — CTA center --}}
    <a href="{{ route('packages.categories') }}"
       class="bn-item bn-cta"
       aria-label="Pesan Foto">
        <div class="bn-cta-wrap">
            <i class="bi bi-camera-fill"></i>
        </div>
        <span>Pesan</span>
    </a>

    {{-- Portofolio --}}
    <a href="{{ route('portfolio.index') }}"
       class="bn-item {{ request()->is('portfolio*') ? 'active' : '' }}"
       aria-label="Portofolio">
        <i class="bi {{ request()->is('portfolio*') ? 'bi-images' : 'bi-images' }}"></i>
        <span>Portfolio</span>
    </a>

    {{-- Akun / Kontak --}}
    @auth
    <button class="bn-item {{ request()->is('customer*') ? 'active' : '' }}"
            id="bn-user-btn"
            aria-label="Akun saya">
        <img class="bn-avatar"
             src="{{ Auth::user()->photo
                ? asset('storage/images/profile/' . Auth::user()->photo)
                : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=c8a96e&color=1a1408&size=52' }}"
             alt="{{ Auth::user()->name }}">
        <span>Akun</span>
    </button>
    @else
    <a href="{{ route('customer.login') }}"
       class="bn-item"
       aria-label="Masuk">
        <i class="bi bi-person-circle"></i>
        <span>Masuk</span>
    </a>
    @endauth

</nav>

{{-- ======= BOTTOM SHEET (Mobile user menu) ======= --}}
@auth
<div id="bn-sheet-overlay"></div>
<div id="bn-user-sheet" role="dialog" aria-label="Menu akun">
    <div class="bn-sheet-handle"></div>
    {{-- User info --}}
    <div style="display:flex;align-items:center;gap:12px;padding:0 4px 16px;border-bottom:1px solid var(--border);margin-bottom:8px;">
        <img src="{{ Auth::user()->photo
            ? asset('storage/images/profile/' . Auth::user()->photo)
            : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=c8a96e&color=1a1408&size=80' }}"
             style="width:46px;height:46px;border-radius:50%;object-fit:cover;border:2px solid var(--gold);"
             alt="{{ Auth::user()->name }}">
        <div>
            <div style="font-size:.9rem;font-weight:600;color:var(--text);">{{ Auth::user()->name }}</div>
            <div style="font-size:.75rem;color:var(--muted);">{{ Auth::user()->email }}</div>
        </div>
    </div>
    {{-- Menu items --}}
    <a href="{{ route('customer.orders') }}" class="udd-link" style="border-radius:10px;padding:12px 14px;font-size:.875rem;">
        <i class="bi bi-list-check" style="font-size:1.1rem;"></i> Pesanan Saya
    </a>
    <a href="{{ route('customer.profile') }}" class="udd-link" style="border-radius:10px;padding:12px 14px;font-size:.875rem;">
        <i class="bi bi-person-gear" style="font-size:1.1rem;"></i> Profil Saya
    </a>
    <a href="{{ route('packages.categories') }}" class="udd-link" style="border-radius:10px;padding:12px 14px;font-size:.875rem;">
        <i class="bi bi-camera" style="font-size:1.1rem;"></i> Pesan Foto
    </a>
    <div style="border-top:1px solid var(--border);margin:8px 0;"></div>
    <form action="{{ route('customer.logout') }}" method="POST">
        @csrf
        <button type="submit" class="udd-logout" style="border-radius:10px;padding:12px 14px;font-size:.875rem;width:100%;">
            <i class="bi bi-box-arrow-right" style="font-size:1.1rem;"></i> Keluar
        </button>
    </form>
    <div style="height: env(safe-area-inset-bottom, 12px);"></div>
</div>
@endauth

{{-- ======= CONTENT ======= --}}
@yield('content')

{{-- ======= FOOTER ======= --}}
<footer>
    <div class="container">
        <div class="row g-5">

            {{-- Brand --}}
            <div class="col-lg-4">
                <a href="{{ route('home') }}" class="footer-logo">Tele<span>grad</span></a>
                <p class="footer-tagline mt-3">
                    {{ $web->site_description ?? 'Studio fotografi profesional untuk momen yang tak terlupakan.' }}
                </p>
                <div class="footer-social">
                    @if($web->instagram ?? null)
                    <a href="{{ $web->instagram }}" target="_blank" rel="noopener" aria-label="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>
                    @endif
                    @if($web->tiktok ?? null)
                    <a href="{{ $web->tiktok }}" target="_blank" rel="noopener" aria-label="TikTok">
                        <i class="bi bi-tiktok"></i>
                    </a>
                    @endif
                    @if($web->facebook ?? null)
                    <a href="{{ $web->facebook }}" target="_blank" rel="noopener" aria-label="Facebook">
                        <i class="bi bi-facebook"></i>
                    </a>
                    @endif
                    @if($web->site_phone ?? null)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $web->site_phone) }}"
                       target="_blank" rel="noopener" aria-label="WhatsApp">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                    @endif
                </div>
            </div>

            {{-- Navigasi --}}
            <div class="col-lg-2 col-sm-6">
                <p class="footer-heading">Navigasi</p>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Beranda</a></li>
                    <li><a href="{{ route('packages.categories') }}">Paket Kami</a></li>
                    <li><a href="{{ route('portfolio.index') }}">Portofolio</a></li>
                    <li><a href="{{ route('contact') }}">Kontak</a></li>
                </ul>
            </div>

            {{-- Layanan --}}
            <div class="col-lg-2 col-sm-6">
                <p class="footer-heading">Layanan</p>
                <ul class="footer-links">
                    <li><a href="{{ route('packages.byCategory', 'wisuda') }}">Foto Wisuda</a></li>
                    <li><a href="{{ route('packages.byCategory', 'yudisium') }}">Foto Yudisium</a></li>
                    <li><a href="{{ route('packages.byCategory', 'after-sidang') }}">After Sidang</a></li>
                    <li><a href="{{ route('packages.categories') }}">Semua Paket</a></li>
                </ul>
            </div>

            {{-- Kontak --}}
            <div class="col-lg-4">
                <p class="footer-heading">Hubungi Kami</p>
                @if($web->site_street ?? null)
                <div class="footer-contact-item">
                    <i class="bi bi-geo-alt-fill"></i>
                    <span>{{ $web->site_street }}{{ $web->site_poscod ? ', ' . $web->site_poscod : '' }}</span>
                </div>
                @endif
                @if($web->site_email ?? null)
                <div class="footer-contact-item">
                    <i class="bi bi-envelope-fill"></i>
                    <a href="mailto:{{ $web->site_email }}">{{ $web->site_email }}</a>
                </div>
                @endif
                @if($web->site_phone ?? null)
                <div class="footer-contact-item">
                    <i class="bi bi-whatsapp"></i>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $web->site_phone) }}"
                       target="_blank">{{ $web->site_phone }}</a>
                </div>
                @endif
                @if($web->site_link ?? null)
                <div class="footer-contact-item">
                    <i class="bi bi-globe2"></i>
                    <a href="{{ $web->site_link }}" target="_blank">{{ $web->site_link }}</a>
                </div>
                @endif
            </div>

        </div>

        <hr class="footer-divider">

        <div class="footer-bottom">
            <p class="footer-copy">&copy; {{ date('Y') }} {{ $web->site_name ?? 'Telegrad' }}. Semua hak dilindungi.</p>
            <p class="footer-copy">Dibuat dengan <i class="bi bi-heart-fill"></i> untuk momen terbaik</p>
        </div>
    </div>
</footer>

{{-- ======= MODAL LOGIN ======= --}}
@include('base.base-root-modal')

{{-- ======= SCRIPTS ======= --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/isotope-layout@3.0.6/dist/isotope.pkgd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/imagesloaded@5.0.0/imagesloaded.pkgd.min.js"></script>

<script>
// ── AOS ──────────────────────────────────────────────────────
const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
AOS.init({
    duration: 700,
    easing: 'ease-out-cubic',
    once: true,
    offset: 60,
    disable: prefersReducedMotion,
});

// ── Navbar scroll effect ──────────────────────────────────────
const navbar = document.getElementById('navbar');
const onScroll = () => navbar.classList.toggle('scrolled', window.scrollY > 30);
window.addEventListener('scroll', onScroll, { passive: true });
onScroll();

// ── GLightbox ─────────────────────────────────────────────────
const lightbox = GLightbox({ touchNavigation: true, loop: true, zoomable: true });

// ── Isotope (portfolio filter) ────────────────────────────────
document.querySelectorAll('.portfolio-isotope').forEach(container => {
    const grid = container.querySelector('.portfolio-container');
    if (!grid) return;
    imagesLoaded(grid, () => {
        const iso = new Isotope(grid, {
            itemSelector: '.portfolio-item-wrap',
            layoutMode: 'masonry',
            masonry: { columnWidth: '.portfolio-item-wrap' }
        });
        container.querySelectorAll('.portfolio-flters li').forEach(btn => {
            btn.addEventListener('click', function () {
                container.querySelectorAll('.portfolio-flters li').forEach(b => b.classList.remove('filter-active'));
                this.classList.add('filter-active');
                iso.arrange({ filter: this.dataset.filter });
            });
        });
    });
});

// ── Desktop User dropdown — fixed portal positioning ─────────
const userBtn = document.getElementById('user-nav-btn');
const userDd  = document.getElementById('user-nav-dropdown');
const uddChevron = document.getElementById('udd-chevron');

function positionDropdown() {
    if (!userBtn || !userDd) return;
    const rect = userBtn.getBoundingClientRect();
    const rightFromViewport = window.innerWidth - rect.right;
    userDd.style.top  = (rect.bottom + 10) + 'px';
    userDd.style.right = Math.max(rightFromViewport, 12) + 'px';
    userDd.style.left = 'auto';
}

function openDropdown() {
    positionDropdown();
    // Add class (display:block + start transition on next frame)
    userDd.classList.add('dd-open');
    if (uddChevron) uddChevron.style.transform = 'rotate(180deg)';
}
function closeDropdown() {
    userDd.classList.remove('dd-open');
    if (uddChevron) uddChevron.style.transform = 'rotate(0deg)';
}

if (userBtn && userDd) {
    userBtn.addEventListener('click', e => {
        e.stopPropagation();
        userDd.classList.contains('dd-open') ? closeDropdown() : openDropdown();
    });
    document.addEventListener('click', e => {
        if (!userDd.contains(e.target) && !userBtn.contains(e.target)) {
            closeDropdown();
        }
    });
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeDropdown();
    });
    window.addEventListener('scroll', () => {
        if (userDd.classList.contains('dd-open')) positionDropdown();
    }, { passive: true });
    window.addEventListener('resize', () => {
        if (userDd.classList.contains('dd-open')) positionDropdown();
    });
}

// ── Dark / Light Mode Toggle (shared logic) ───────────────────
const html       = document.documentElement;
const themeIcon  = document.getElementById('themeIcon');
const mobileIcon = document.getElementById('mobileThemeIcon');

const savedTheme = localStorage.getItem('tg-theme') || 'dark';
html.setAttribute('data-theme', savedTheme);
applyThemeIcon(savedTheme);

function applyThemeIcon(theme) {
    const isDark = theme === 'dark';
    if (themeIcon) {
        themeIcon.className = isDark ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
    }
    if (mobileIcon) {
        mobileIcon.className = isDark ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
    }
    // Sync meta color-scheme dengan tema aktif
    document.querySelector('meta[name="color-scheme"]')?.setAttribute('content', isDark ? 'dark' : 'light');
}

function toggleTheme() {
    const current = html.getAttribute('data-theme');
    const next    = current === 'dark' ? 'light' : 'dark';
    html.setAttribute('data-theme', next);
    localStorage.setItem('tg-theme', next);
    applyThemeIcon(next);
}

document.getElementById('themeToggle')?.addEventListener('click', toggleTheme);
document.getElementById('mobile-theme-btn')?.addEventListener('click', toggleTheme);

// ── Mobile Bottom Nav: User Sheet ─────────────────────────────
const bnUserBtn   = document.getElementById('bn-user-btn');
const bnUserSheet = document.getElementById('bn-user-sheet');
const bnOverlay   = document.getElementById('bn-sheet-overlay');

if (bnUserBtn && bnUserSheet) {
    bnUserBtn.addEventListener('click', () => {
        bnUserSheet.classList.toggle('open');
        if (bnOverlay) {
            bnOverlay.style.display = 'block';
            requestAnimationFrame(() => bnOverlay.classList.toggle('open', bnUserSheet.classList.contains('open')));
        }
    });

    // Close on overlay tap
    bnOverlay?.addEventListener('click', closeSheet);

    // Swipe down to close
    let startY = 0;
    bnUserSheet.addEventListener('touchstart', e => { startY = e.touches[0].clientY; }, { passive: true });
    bnUserSheet.addEventListener('touchend', e => {
        if (e.changedTouches[0].clientY - startY > 60) closeSheet();
    }, { passive: true });
}

function closeSheet() {
    bnUserSheet?.classList.remove('open');
    if (bnOverlay) {
        bnOverlay.classList.remove('open');
        setTimeout(() => { bnOverlay.style.display = 'none'; }, 250);
    }
}
</script>

@stack('js')
</body>
</html>