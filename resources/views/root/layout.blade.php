<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? config('app.name', 'Telegrad') }}</title>

    <link rel="icon" href="{{ asset('storage/images/logo_header/logo_telegrad_gold.png') }}" type="image/png">


    <!-- Fonts: Playfair Display + DM Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- AOS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    <!-- GLightbox -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">

    <style>
        /* =========================================
           GLOBAL TOKENS
        ========================================= */
        :root {
            --clr-bg:        #0b0c0e;
            --clr-surface:   #111214;
            --clr-card:      #16181c;
            --clr-border:    rgba(255,255,255,0.07);
            --clr-accent:    #c8a96e;        /* warm gold */
            --clr-accent2:   #e8c98a;        /* lighter gold */
            --clr-text:      #f0ede8;
            --clr-muted:     #8a8880;
            --clr-dim:       #555350;

            --ff-display:    'Playfair Display', Georgia, serif;
            --ff-body:       'DM Sans', sans-serif;

            --radius-sm:     6px;
            --radius-md:     12px;
            --radius-lg:     20px;
            --radius-xl:     32px;

            --nav-h:         72px;
            --transition:    0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        body {
            font-family: var(--ff-body);
            background: var(--clr-bg);
            color: var(--clr-text);
            font-size: 16px;
            line-height: 1.7;
            font-weight: 300;
            -webkit-font-smoothing: antialiased;
        }

        /* =========================================
           SCROLLBAR
        ========================================= */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: var(--clr-bg); }
        ::-webkit-scrollbar-thumb { background: var(--clr-accent); border-radius: 10px; }

        /* =========================================
           NAVBAR
        ========================================= */
        #navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1000;
            height: var(--nav-h);
            display: flex;
            align-items: center;
            padding: 0 2rem;
            transition: background var(--transition), box-shadow var(--transition);
        }
        #navbar.scrolled {
            background: rgba(11, 12, 14, 0.92);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--clr-border);
            box-shadow: 0 4px 40px rgba(0,0,0,0.4);
        }
        .nav-logo {
            font-family: var(--ff-display);
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--clr-text) !important;
            text-decoration: none;
            letter-spacing: -0.5px;
        }
        .nav-logo span { color: var(--clr-accent); }
        .nav-links {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .nav-links a {
            display: block;
            padding: 0.5rem 1rem;
            color: var(--clr-muted);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 400;
            letter-spacing: 0.3px;
            border-radius: var(--radius-sm);
            transition: color var(--transition), background var(--transition);
        }
        .nav-links a:hover,
        .nav-links a.active {
            color: var(--clr-text);
            background: rgba(255,255,255,0.05);
        }
        .nav-cta {
            padding: 0.5rem 1.25rem !important;
            background: var(--clr-accent) !important;
            color: #1a1410 !important;
            border-radius: var(--radius-sm) !important;
            font-weight: 500 !important;
            transition: opacity var(--transition) !important;
        }
        .nav-cta:hover { opacity: 0.85 !important; background: var(--clr-accent) !important; }

        /* Mobile hamburger */
        .nav-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--clr-text);
            font-size: 1.4rem;
            cursor: pointer;
            padding: 0.25rem;
        }
        @media (max-width: 768px) {
            .nav-links { display: none; }
            .nav-toggle { display: block; }
            .nav-links.open {
                display: flex;
                flex-direction: column;
                position: fixed;
                top: var(--nav-h); left: 0; right: 0;
                background: rgba(11,12,14,0.98);
                border-bottom: 1px solid var(--clr-border);
                padding: 1rem;
                gap: 0.25rem;
            }
        }

        /* =========================================
           BREADCRUMBS
        ========================================= */
        .breadcrumbs {
            position: relative;
            min-height: 240px;
            display: flex;
            align-items: flex-end;
            padding: calc(var(--nav-h) + 2rem) 0 3rem;
            background-size: cover;
            background-position: center;
            overflow: hidden;
        }
        .breadcrumbs::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, rgba(11,12,14,0.5) 0%, rgba(11,12,14,0.85) 100%);
        }
        .breadcrumbs-inner { position: relative; z-index: 1; }
        .breadcrumbs h2 {
            font-family: var(--ff-display);
            font-size: clamp(1.8rem, 4vw, 3rem);
            font-weight: 600;
            color: var(--clr-text);
            margin-bottom: 0.75rem;
        }
        .breadcrumbs ol {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .breadcrumbs ol li { font-size: 0.85rem; color: var(--clr-muted); }
        .breadcrumbs ol li a { color: var(--clr-accent); text-decoration: none; }
        .breadcrumbs ol li a:hover { color: var(--clr-accent2); }
        .breadcrumbs ol li + li::before {
            content: '/';
            margin-right: 0.5rem;
            color: var(--clr-dim);
        }

        /* =========================================
           SECTIONS
        ========================================= */
        section { padding: 5rem 0; }
        .section-label {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--clr-accent);
            margin-bottom: 0.75rem;
        }
        .section-title {
            font-family: var(--ff-display);
            font-size: clamp(1.75rem, 3.5vw, 2.5rem);
            font-weight: 600;
            color: var(--clr-text);
            line-height: 1.2;
            margin-bottom: 1rem;
        }
        .section-subtitle {
            color: var(--clr-muted);
            font-size: 1rem;
            max-width: 520px;
            margin: 0 auto;
        }
        .section-bg { background: var(--clr-surface); }

        /* =========================================
           CARDS
        ========================================= */
        .card-modern {
            background: var(--clr-card);
            border: 1px solid var(--clr-border);
            border-radius: var(--radius-lg);
            overflow: hidden;
            transition: transform var(--transition), border-color var(--transition), box-shadow var(--transition);
        }
        .card-modern:hover {
            transform: translateY(-4px);
            border-color: rgba(200,169,110,0.25);
            box-shadow: 0 16px 48px rgba(0,0,0,0.4);
        }

        /* =========================================
           PORTFOLIO / PACKAGE ITEM
        ========================================= */
        .portfolio-item {
            position: relative;
            border-radius: var(--radius-md);
            overflow: hidden;
            aspect-ratio: 4/3;
            cursor: pointer;
        }
        .portfolio-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }
        .portfolio-item:hover img { transform: scale(1.06); }
        .portfolio-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(11,12,14,0.92) 0%, transparent 55%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 1.5rem;
            opacity: 0;
            transition: opacity var(--transition);
        }
        .portfolio-item:hover .portfolio-overlay { opacity: 1; }
        .portfolio-overlay h4 {
            font-family: var(--ff-display);
            font-size: 1.1rem;
            color: var(--clr-text);
            margin-bottom: 0.25rem;
        }
        .portfolio-overlay p { font-size: 0.8rem; color: var(--clr-muted); margin: 0; }
        .portfolio-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 0.75rem;
        }
        .portfolio-actions a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 34px; height: 34px;
            background: rgba(200,169,110,0.15);
            border: 1px solid rgba(200,169,110,0.3);
            border-radius: 50%;
            color: var(--clr-accent);
            font-size: 0.9rem;
            text-decoration: none;
            transition: background var(--transition);
        }
        .portfolio-actions a:hover { background: var(--clr-accent); color: #1a1410; }

        /* =========================================
           BUTTONS
        ========================================= */
        .btn-gold {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.75rem;
            background: var(--clr-accent);
            color: #1a1410;
            border: none;
            border-radius: var(--radius-sm);
            font-family: var(--ff-body);
            font-weight: 500;
            font-size: 0.9rem;
            text-decoration: none;
            cursor: pointer;
            transition: opacity var(--transition), transform var(--transition);
        }
        .btn-gold:hover { opacity: 0.85; transform: translateY(-1px); color: #1a1410; }

        .btn-outline-gold {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.75rem;
            background: transparent;
            color: var(--clr-accent);
            border: 1px solid rgba(200,169,110,0.4);
            border-radius: var(--radius-sm);
            font-family: var(--ff-body);
            font-weight: 500;
            font-size: 0.9rem;
            text-decoration: none;
            cursor: pointer;
            transition: background var(--transition), border-color var(--transition);
        }
        .btn-outline-gold:hover {
            background: rgba(200,169,110,0.08);
            border-color: var(--clr-accent);
            color: var(--clr-accent);
        }

        /* =========================================
           FORM ELEMENTS
        ========================================= */
        .form-control-dark {
            width: 100%;
            padding: 0.8rem 1rem;
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--clr-border);
            border-radius: var(--radius-sm);
            color: var(--clr-text);
            font-family: var(--ff-body);
            font-size: 0.9rem;
            outline: none;
            transition: border-color var(--transition);
        }
        .form-control-dark::placeholder { color: var(--clr-dim); }
        .form-control-dark:focus { border-color: rgba(200,169,110,0.5); }

        /* =========================================
           BADGE / TAG
        ========================================= */
        .badge-gold {
            display: inline-block;
            padding: 0.3rem 0.85rem;
            background: rgba(200,169,110,0.12);
            border: 1px solid rgba(200,169,110,0.3);
            color: var(--clr-accent);
            border-radius: 100px;
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        /* =========================================
           DIVIDERS & DECORATIVE
        ========================================= */
        .line-accent {
            width: 40px;
            height: 2px;
            background: var(--clr-accent);
            margin-bottom: 1rem;
        }
        .line-accent.centered { margin-left: auto; margin-right: auto; }

        /* =========================================
           FOOTER
        ========================================= */
        footer {
            background: var(--clr-surface);
            border-top: 1px solid var(--clr-border);
            padding: 4rem 0 2rem;
        }
        .footer-logo {
            font-family: var(--ff-display);
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--clr-text);
            text-decoration: none;
            display: inline-block;
            margin-bottom: 0.75rem;
        }
        .footer-logo span { color: var(--clr-accent); }
        .footer-tagline { color: var(--clr-muted); font-size: 0.875rem; max-width: 260px; }
        .footer-heading {
            font-size: 0.7rem;
            font-weight: 500;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--clr-dim);
            margin-bottom: 1.25rem;
        }
        .footer-links { list-style: none; padding: 0; margin: 0; }
        .footer-links li { margin-bottom: 0.6rem; }
        .footer-links a {
            color: var(--clr-muted);
            text-decoration: none;
            font-size: 0.875rem;
            transition: color var(--transition);
        }
        .footer-links a:hover { color: var(--clr-accent); }
        .footer-contact-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
            font-size: 0.875rem;
            color: var(--clr-muted);
        }
        .footer-contact-item i { color: var(--clr-accent); margin-top: 3px; flex-shrink: 0; }
        .footer-contact-item a { color: var(--clr-muted); text-decoration: none; }
        .footer-contact-item a:hover { color: var(--clr-accent); }
        .footer-divider {
            border: none;
            border-top: 1px solid var(--clr-border);
            margin: 3rem 0 2rem;
        }
        .footer-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .footer-copy { font-size: 0.8rem; color: var(--clr-dim); }
        .social-links { display: flex; gap: 0.5rem; }
        .social-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px; height: 36px;
            border: 1px solid var(--clr-border);
            border-radius: 50%;
            color: var(--clr-muted);
            font-size: 0.9rem;
            text-decoration: none;
            transition: all var(--transition);
        }
        .social-links a:hover {
            border-color: var(--clr-accent);
            color: var(--clr-accent);
            background: rgba(200,169,110,0.08);
        }

        /* =========================================
           ISOTOPE FILTERS
        ========================================= */
        .portfolio-flters {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            list-style: none;
            padding: 0;
            margin: 0 0 2.5rem;
            justify-content: center;
        }
        .portfolio-flters li {
            padding: 0.45rem 1.1rem;
            border: 1px solid var(--clr-border);
            border-radius: 100px;
            font-size: 0.8rem;
            color: var(--clr-muted);
            cursor: pointer;
            transition: all var(--transition);
            font-weight: 400;
        }
        .portfolio-flters li:hover,
        .portfolio-flters li.filter-active {
            background: var(--clr-accent);
            border-color: var(--clr-accent);
            color: #1a1410;
            font-weight: 500;
        }

        /* =========================================
           TESTIMONIAL
        ========================================= */
        .testimonial-card {
            background: var(--clr-card);
            border: 1px solid var(--clr-border);
            border-radius: var(--radius-lg);
            padding: 2rem;
            position: relative;
        }
        .testimonial-card::before {
            content: '\201C';
            font-family: var(--ff-display);
            font-size: 4rem;
            line-height: 1;
            color: var(--clr-accent);
            opacity: 0.3;
            position: absolute;
            top: 1rem;
            left: 1.5rem;
        }
        .testimonial-stars { color: var(--clr-accent); font-size: 0.85rem; margin-bottom: 0.75rem; }
        .testimonial-text {
            color: var(--clr-muted);
            font-size: 0.9rem;
            line-height: 1.8;
            margin-bottom: 1.25rem;
        }
        .testimonial-author { font-weight: 500; font-size: 0.9rem; color: var(--clr-text); }

        /* =========================================
           MISC
        ========================================= */
        .price-tag {
            font-family: var(--ff-display);
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--clr-accent);
        }
        .text-muted-custom { color: var(--clr-muted); }
        .text-accent { color: var(--clr-accent); }

        /* Prevent flash before JS loads */
        .aos-init[data-aos] { opacity: 1 !important; transform: none !important; }

        @media (max-width: 576px) {
            section { padding: 3.5rem 0; }
            .footer-bottom { flex-direction: column; text-align: center; }
        }
    </style>

    @stack('css')
</head>
<body>

<!-- ======= NAVBAR ======= -->
<nav id="navbar">
    <div class="container d-flex align-items-center justify-content-between">
        <a href="/" class="nav-logo">Tele<span>grad</span></a>

        <button class="nav-toggle" id="navToggle" aria-label="Toggle menu">
            <i class="bi bi-list"></i>
        </button>

        <ul class="nav-links" id="navLinks">
            <li><a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Beranda</a></li>
            <li><a href="{{ route('packages.categories') }}" class="{{ request()->is('packages*') ? 'active' : '' }}">Paket</a></li>
            <li><a href="{{ route('portfolio.index') }}" class="{{ request()->is('portfolio*') ? 'active' : '' }}">Portofolio</a></li>
            <li><a href="{{ route('contact.index') }}" class="{{ request()->is('contact*') ? 'active' : '' }}">Kontak</a></li>
            @auth
                <li>
                    <a href="{{ route('customer.dashboard') }}" class="nav-cta">
                        <i class="bi bi-person-circle"></i> Dashboard
                    </a>
                </li>
            @else
                <li>
                    <a href="{{ route('customer.login') }}" class="nav-cta">
                        <i class="bi bi-box-arrow-in-right"></i> Masuk
                    </a>
                </li>
            @endauth
        </ul>
    </div>
</nav>

<!-- ======= CONTENT ======= -->
@yield('content')

<!-- ======= FOOTER ======= -->
<footer>
    <div class="container">
        <div class="row g-5">
            <!-- Brand -->
            <div class="col-lg-4">
                <a href="/" class="footer-logo">Tele<span>grad</span></a>
                <p class="footer-tagline mt-2">
                    Studio fotografi profesional untuk momen yang tak terlupakan.
                </p>
                <div class="social-links mt-3">
                    <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                    <a href="#" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                </div>
            </div>

            <!-- Navigasi -->
            <div class="col-lg-2 col-sm-6">
                <p class="footer-heading">Navigasi</p>
                <ul class="footer-links">
                    <li><a href="/">Beranda</a></li>
                    <li><a href="{{ route('packages.categories') }}">Paket Kami</a></li>
                    <li><a href="{{ route('portfolio.index') }}">Portofolio</a></li>
                    <li><a href="{{ route('contact.index') }}">Kontak</a></li>
                </ul>
            </div>

            <!-- Layanan -->
            <div class="col-lg-2 col-sm-6">
                <p class="footer-heading">Layanan</p>
                <ul class="footer-links">
                    <li><a href="#">Foto Pernikahan</a></li>
                    <li><a href="#">Foto Keluarga</a></li>
                    <li><a href="#">Foto Produk</a></li>
                    <li><a href="#">Foto Portrait</a></li>
                </ul>
            </div>

            <!-- Kontak -->
            <div class="col-lg-4">
                <p class="footer-heading">Hubungi Kami</p>
                <div class="footer-contact-item">
                    <i class="bi bi-geo-alt-fill"></i>
                    <span>{{ ($web->site_street ?? 'Jl. Fotografi No.1') . ', ' . ($web->site_poscod ?? '36000') }}</span>
                </div>
                <div class="footer-contact-item">
                    <i class="bi bi-envelope-fill"></i>
                    <a href="mailto:{{ $web->site_email ?? 'hello@telegrad.id' }}">{{ $web->site_email ?? 'hello@telegrad.id' }}</a>
                </div>
                <div class="footer-contact-item">
                    <i class="bi bi-telephone-fill"></i>
                    <a href="tel:{{ $web->site_phone ?? '' }}">{{ $web->site_phone ?? '+62 xxx xxxx xxxx' }}</a>
                </div>
            </div>
        </div>

        <hr class="footer-divider">

        <div class="footer-bottom">
            <p class="footer-copy">&copy; {{ date('Y') }} Telegrad. Semua hak dilindungi.</p>
            <p class="footer-copy">Dibuat dengan <i class="bi bi-heart-fill text-accent" style="font-size:11px;"></i> untuk momen terbaik</p>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/isotope-layout@3.0.6/dist/isotope.pkgd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/imagesloaded@5.0.0/imagesloaded.pkgd.min.js"></script>

<script>
    // AOS
    AOS.init({ duration: 700, easing: 'ease-out-cubic', once: true, offset: 60 });

    // Navbar scroll
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        navbar.classList.toggle('scrolled', window.scrollY > 30);
    });

    // Mobile toggle
    document.getElementById('navToggle')?.addEventListener('click', () => {
        document.getElementById('navLinks')?.classList.toggle('open');
    });

    // GLightbox
    const lightbox = GLightbox({ touchNavigation: true, loop: true, zoomable: true });

    // Isotope for portfolio
    const isoContainers = document.querySelectorAll('.portfolio-isotope');
    isoContainers.forEach(container => {
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
</script>

@stack('js')
</body>
</html>