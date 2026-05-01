<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($title) ? $title . ' — ' : '' }}{{ $web->site_name ?? config('app.name', 'Telegrad') }}</title>
    <meta name="description" content="{{ $web->site_description ?? 'Jasa foto & video wisuda profesional di Jambi' }}">

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

            --shadow-sm:     0 4px 16px rgba(0,0,0,0.08);
            --shadow-md:     0 12px 40px rgba(0,0,0,0.12);
            --shadow-lg:     0 24px 64px rgba(0,0,0,0.15);

            --theme-icon:    "🌙";
        }

        /* =====================================================
           RESET & BASE
        ===================================================== */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            font-size: 16px;
            line-height: 1.7;
            font-weight: 300;
            -webkit-font-smoothing: antialiased;
            transition: background 0.35s ease, color 0.35s ease;
        }
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: var(--bg); }
        ::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 10px; }

        /* =====================================================
           NAVBAR
        ===================================================== */
        #navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1000;
            height: 72px;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            background: var(--nav-bg);
            transition: background 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
        }
        #navbar.scrolled {
            background: var(--nav-bg-scroll);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--nav-border);
            box-shadow: var(--shadow-sm);
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

        /* Mobile hamburger */
        .nav-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--text);
            font-size: 1.4rem;
            cursor: pointer;
            padding: 0.25rem;
        }

        /* User dropdown */
        #user-dropdown-wrap { position: relative; }
        #user-nav-dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: var(--card);
            border: 1px solid var(--gold-border);
            border-radius: 12px;
            min-width: 210px;
            padding: 8px;
            box-shadow: var(--shadow-md);
            z-index: 999;
        }
        .udd-header {
            padding: 10px 12px 8px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 4px;
        }
        .udd-name { font-size: 0.82rem; font-weight: 600; color: var(--text); }
        .udd-email { font-size: 0.72rem; color: var(--muted); }
        .udd-link {
            display: flex; align-items: center; gap: 9px;
            padding: 9px 12px; border-radius: 8px;
            font-size: 0.82rem; color: var(--muted);
            text-decoration: none;
            transition: background 0.2s, color 0.2s;
        }
        .udd-link i { color: var(--gold); width: 16px; }
        .udd-link:hover { background: var(--gold-dim); color: var(--gold-light); }
        .udd-sep { border-top: 1px solid var(--border); margin: 4px 0; }
        .udd-logout {
            display: flex; align-items: center; gap: 9px;
            padding: 9px 12px; border-radius: 8px;
            font-size: 0.82rem; color: var(--danger);
            background: none; border: none;
            width: 100%; cursor: pointer;
            transition: background 0.2s;
        }
        .udd-logout:hover { background: rgba(224,92,92,0.08); }

        @media (max-width: 768px) {
            .nav-links { display: none; }
            .nav-toggle { display: block; }
            .nav-links.open {
                display: flex;
                flex-direction: column;
                position: fixed;
                top: 72px; left: 0; right: 0;
                background: var(--nav-bg-scroll);
                backdrop-filter: blur(20px);
                border-bottom: 1px solid var(--border);
                padding: 1rem;
                gap: 0.25rem;
                z-index: 999;
            }
        }

        /* =====================================================
           BREADCRUMBS
        ===================================================== */
        .breadcrumbs {
            position: relative;
            min-height: 240px;
            display: flex;
            align-items: flex-end;
            padding: calc(72px + 2.5rem) 0 3rem;
            background-size: cover;
            background-position: center;
            overflow: hidden;
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
            font-size: 0.95rem; color: #f0ede8; margin-bottom: 0.2rem;
        }
        .portfolio-grid-overlay span { font-size: 0.75rem; color: rgba(240,237,232,0.6); }
        .portfolio-grid-actions { display: flex; gap: 0.4rem; margin-top: 0.6rem; }
        .portfolio-grid-actions a {
            width: 30px; height: 30px;
            display: flex; align-items: center; justify-content: center;
            background: rgba(200,169,110,0.15);
            border: 1px solid rgba(200,169,110,0.3);
            border-radius: 50%; color: var(--gold);
            font-size: 0.8rem; text-decoration: none;
            transition: background 0.25s;
        }
        .portfolio-grid-actions a:hover { background: var(--gold); color: #1a1410; }

        /* =====================================================
           PACKAGE CARD (used on homepage)
        ===================================================== */
        .package-card {
            background: var(--card); border: 1px solid var(--border);
            border-radius: 16px; overflow: hidden; height: 100%;
            transition: transform 0.28s, box-shadow 0.28s, border-color 0.28s;
        }
        .package-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
            border-color: var(--gold-border);
        }
        .package-img { position: relative; aspect-ratio: 4/3; overflow: hidden; }
        .package-img img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform 0.6s ease;
        }
        .package-card:hover .package-img img { transform: scale(1.05); }
        .package-cat-badge { position: absolute; top: 1rem; left: 1rem; }
        .package-body { padding: 1.5rem; }
        .package-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.05rem; font-weight: 600;
            color: var(--text); margin-bottom: 0.5rem;
        }
        .package-price {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem; font-weight: 600; color: var(--gold);
        }
        .package-link {
            display: inline-flex; align-items: center; gap: 0.35rem;
            font-size: 0.8rem; font-weight: 500; color: var(--muted);
            text-decoration: none; margin-top: 1rem;
            transition: color 0.25s;
        }
        .package-link:hover { color: var(--gold); }

        /* =====================================================
           TESTIMONIAL
        ===================================================== */
        .testimonial-card {
            background: var(--card); border: 1px solid var(--border);
            border-radius: 16px; padding: 2rem;
            position: relative; height: 100%;
            transition: border-color 0.28s, transform 0.28s;
        }
        .testimonial-card:hover { border-color: var(--gold-border); transform: translateY(-3px); }
        .testimonial-card::before {
            content: '\201C';
            font-family: 'Playfair Display', serif;
            font-size: 4rem; line-height: 1;
            color: var(--gold); opacity: 0.25;
            position: absolute; top: 1rem; left: 1.5rem;
        }
        .testimonial-stars { color: var(--gold); font-size: 0.85rem; margin-bottom: 0.75rem; }
        .testimonial-text { color: var(--muted); font-size: 0.9rem; line-height: 1.8; margin-bottom: 1.25rem; }
        .testimonial-author { font-weight: 500; font-size: 0.9rem; color: var(--text); }

        /* =====================================================
           FOOTER
        ===================================================== */
        footer {
            background: var(--footer-bg);
            border-top: 1px solid var(--border);
            padding: 5rem 0 2rem;
        }
        [data-theme="light"] footer { background: #1a1814; }

        .footer-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem; font-weight: 700;
            color: #f0ede8 !important; text-decoration: none;
        }
        .footer-logo span { color: var(--gold); }
        .footer-tagline { font-size: 0.875rem; color: #8a8880; line-height: 1.7; max-width: 280px; }

        .footer-social { display: flex; gap: 0.5rem; margin-top: 1.25rem; }
        .footer-social a {
            width: 36px; height: 36px;
            display: flex; align-items: center; justify-content: center;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 8px; color: #8a8880;
            font-size: 0.9rem; text-decoration: none;
            transition: all 0.25s;
        }
        .footer-social a:hover { background: var(--gold); border-color: var(--gold); color: #1a1410; }

        .footer-heading {
            font-size: 0.72rem; font-weight: 600;
            letter-spacing: 0.14em; text-transform: uppercase;
            color: #f0ede8; margin-bottom: 1.25rem;
        }
        .footer-links { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.6rem; }
        .footer-links a { color: #8a8880; text-decoration: none; font-size: 0.875rem; transition: color 0.25s; }
        .footer-links a:hover { color: var(--gold); }

        .footer-contact-item {
            display: flex; align-items: flex-start; gap: 0.75rem;
            margin-bottom: 0.85rem; font-size: 0.875rem; color: #8a8880;
        }
        .footer-contact-item i { color: var(--gold); font-size: 0.9rem; margin-top: 0.15rem; flex-shrink: 0; }
        .footer-contact-item a { color: #8a8880; text-decoration: none; transition: color 0.25s; }
        .footer-contact-item a:hover { color: var(--gold); }

        .footer-divider { border-color: rgba(255,255,255,0.07); margin: 3rem 0 1.5rem; }
        .footer-bottom { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.5rem; }
        .footer-copy { font-size: 0.78rem; color: #555350; margin: 0; }
        .footer-copy i { color: var(--gold); }

        /* =====================================================
           MODAL (Login)
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

{{-- ======= NAVBAR ======= --}}
<nav id="navbar">
    <div class="container d-flex align-items-center justify-content-between gap-3">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="nav-logo">
            Tele<span>grad</span>
        </a>

        {{-- Mobile hamburger --}}
        <button class="nav-toggle ms-auto" id="navToggle" aria-label="Toggle menu">
            <i class="bi bi-list"></i>
        </button>

        {{-- Nav links --}}
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

            {{-- Theme Toggle --}}
            <li>
                <button class="theme-toggle" id="themeToggle" aria-label="Toggle tema" title="Toggle Dark/Light Mode">
                    <i class="bi bi-sun-fill" id="themeIcon"></i>
                </button>
            </li>

            {{-- Auth --}}
            @auth
            <li class="position-relative" id="user-dropdown-wrap">
                <a href="#" class="nav-cta d-flex align-items-center gap-2" id="user-nav-btn">
                    <img src="{{ Auth::user()->photo
                        ? asset('storage/images/profile/' . Auth::user()->photo)
                        : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=c8a96e&color=1a1408&size=32' }}"
                         style="width:22px;height:22px;border-radius:50%;object-fit:cover;"
                         alt="{{ Auth::user()->name }}">
                    <span>{{ Str::words(Auth::user()->name, 1, '') }}</span>
                    <i class="bi bi-chevron-down" style="font-size:.6rem;"></i>
                </a>
                <div id="user-nav-dropdown">
                    <div class="udd-header">
                        <div class="udd-name">{{ Auth::user()->name }}</div>
                        <div class="udd-email">{{ Auth::user()->email }}</div>
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
AOS.init({ duration: 700, easing: 'ease-out-cubic', once: true, offset: 60 });

// ── Navbar scroll effect ──────────────────────────────────────
const navbar = document.getElementById('navbar');
const onScroll = () => navbar.classList.toggle('scrolled', window.scrollY > 30);
window.addEventListener('scroll', onScroll, { passive: true });
onScroll();

// ── Mobile menu toggle ────────────────────────────────────────
document.getElementById('navToggle')?.addEventListener('click', () => {
    document.getElementById('navLinks')?.classList.toggle('open');
});

// ── Close mobile menu on link click ──────────────────────────
document.querySelectorAll('#navLinks a').forEach(link => {
    link.addEventListener('click', () => {
        document.getElementById('navLinks')?.classList.remove('open');
    });
});

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

// ── User dropdown ─────────────────────────────────────────────
const userBtn = document.getElementById('user-nav-btn');
const userDd  = document.getElementById('user-nav-dropdown');
if (userBtn && userDd) {
    userBtn.addEventListener('click', e => {
        e.preventDefault();
        const isOpen = userDd.style.display === 'block';
        userDd.style.display = isOpen ? 'none' : 'block';
    });
    document.addEventListener('click', e => {
        if (!document.getElementById('user-dropdown-wrap')?.contains(e.target)) {
            if (userDd) userDd.style.display = 'none';
        }
    });
}

// ── Dark / Light Mode Toggle ──────────────────────────────────
const html      = document.documentElement;
const toggleBtn = document.getElementById('themeToggle');
const themeIcon = document.getElementById('themeIcon');

// Load saved preference (default: dark)
const savedTheme = localStorage.getItem('tg-theme') || 'dark';
html.setAttribute('data-theme', savedTheme);
updateIcon(savedTheme);

toggleBtn?.addEventListener('click', () => {
    const current = html.getAttribute('data-theme');
    const next    = current === 'dark' ? 'light' : 'dark';
    html.setAttribute('data-theme', next);
    localStorage.setItem('tg-theme', next);
    updateIcon(next);
});

function updateIcon(theme) {
    if (!themeIcon) return;
    if (theme === 'dark') {
        themeIcon.className = 'bi bi-sun-fill';
        toggleBtn.title     = 'Ganti ke Mode Terang';
    } else {
        themeIcon.className = 'bi bi-moon-fill';
        toggleBtn.title     = 'Ganti ke Mode Gelap';
    }
}
</script>

@stack('js')
</body>
</html>