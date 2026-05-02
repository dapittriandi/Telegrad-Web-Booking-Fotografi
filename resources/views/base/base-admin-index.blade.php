<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ($web->site_name ?? 'Telegrad') . ' — ' . ($submenu ?? 'Admin') }}</title>

    <link rel="icon" href="{{ asset('images/logo_telegrad_blue.png') }}" type="image/png">

    <!-- Mazer Admin Template -->
    <link rel="stylesheet" href="{{ asset('dist/assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/assets/compiled/css/app-dark.css') }}">

    <!-- SweetAlert -->
    <link rel="stylesheet" href="{{ asset('vendor/sweetalerts2/sweetalerts2.css') }}">

    <!-- FontAwesome -->
    <link href="{{ asset('root/assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">

    <!-- Bootstrap Icons (local + CDN fallback) -->
    <link href="{{ asset('root/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('dist/assets/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/assets/compiled/css/table-datatable.css') }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* =================================================================
         *  TELEGRAD ADMIN — Design System v3
         *  Strategy: load AFTER Mazer, gunakan specificity + !important
         *  hanya di tempat yang perlu override Mazer.
         * ================================================================= */

        /* ── 1. CSS Tokens ─────────────────────────────────────────────── */
        :root {
            --tg-navy:         #0A1628;
            --tg-royal:        #1E3A8A;
            --tg-blue:         #3B82F6;
            --tg-blue-lt:      #EFF6FF;
            --tg-blue-lt2:     rgba(59,130,246,0.08);
            --tg-accent:       #F59E0B;

            --tg-page-bg:      #E8EEF6;
            --tg-glass:        rgba(255,255,255,0.80);
            --tg-glass-border: rgba(255,255,255,0.70);
            --tg-blur:         blur(18px);

            --tg-text:         #0F172A;
            --tg-text-2:       #475569;
            --tg-text-3:       #94A3B8;
            --tg-border:       rgba(0,0,0,0.07);

            --tg-ok-bg:        #D1FAE5; --tg-ok-tx:  #065F46;
            --tg-warn-bg:      #FEF3C7; --tg-warn-tx: #92400E;
            --tg-err-bg:       #FEE2E2; --tg-err-tx:  #991B1B;
            --tg-info-bg:      #DBEAFE; --tg-info-tx: #1E40AF;

            --tg-r-sm:         8px;
            --tg-r-md:         12px;
            --tg-r-lg:         16px;
            --tg-ease:         cubic-bezier(0.4,0,0.2,1);
            --tg-t:            0.25s;

            --tg-sh-sm:  0 1px 4px rgba(0,0,0,.06);
            --tg-sh-md:  0 4px 20px rgba(0,0,0,.08);
            --tg-sh-lg:  0 8px 32px rgba(0,0,0,.10);
            --tg-sh-blue:0 4px 16px rgba(59,130,246,.28);
            --tg-sh-navy:0 4px 16px rgba(30,58,138,.28);

            --tg-sidebar-w:    252px;
            --tg-sidebar-mini: 64px;
            --tg-topbar-h:     60px;
            --tg-font:         'Plus Jakarta Sans', sans-serif;
            --tg-sidebar-bg:   #ffffff;
            --tg-sidebar-border: rgba(0,0,0,0.07);
        }

        /* Dark mode token overrides */
        [data-theme="dark"] {
            --tg-page-bg:      #06101E;
            --tg-glass:        rgba(10,22,40,0.82);
            --tg-glass-border: rgba(255,255,255,0.06);
            --tg-text:         #F1F5F9;
            --tg-text-2:       #94A3B8;
            --tg-text-3:       #475569;
            --tg-border:       rgba(255,255,255,0.07);
            --tg-blue-lt:      rgba(59,130,246,0.12);
            --tg-blue-lt2:     rgba(59,130,246,0.07);
            --tg-ok-bg: rgba(6,95,70,.25);    --tg-ok-tx:  #6EE7B7;
            --tg-warn-bg:rgba(146,64,14,.25); --tg-warn-tx:#FCD34D;
            --tg-err-bg: rgba(153,27,27,.25); --tg-err-tx: #FCA5A5;
            --tg-info-bg:rgba(30,64,175,.25); --tg-info-tx:#93C5FD;
            --tg-sidebar-bg:   #0D1B2E;
            --tg-sidebar-border: rgba(255,255,255,0.07);
        }

        /* ── 2. Base reset ──────────────────────────────────────────────── */
        html { scroll-behavior: smooth; }

        body {
            font-family: var(--tg-font) !important;
            background: var(--tg-page-bg) !important;
            color: var(--tg-text) !important;
            -webkit-font-smoothing: antialiased;
        }

        /*
         * PENTING: JANGAN pakai "body *" untuk font-family karena akan
         * menimpa font-family milik Bootstrap Icons & FontAwesome —
         * icon tidak bisa merender glyph-nya jika font-family-nya dioverride.
         * Terapkan ke elemen teks saja, lindungi pseudo-element icon.
         */
        body p, body div, body a, body button, body input, body select,
        body textarea, body label, body h1, body h2, body h3,
        body h4, body h5, body h6, body td, body th, body li,
        body small, body strong, body em, body nav, body header,
        body footer, body section, body article, body main {
            font-family: var(--tg-font) !important;
        }

        /*
         * Proteksi icon font — WAJIB ada setelah rule di atas
         * agar Bootstrap Icons dan FontAwesome tidak tertimpa.
         */
        i[class*="bi"],
        [class*="bi"]::before,
        [class*="bi"]::after {
            font-family: "bootstrap-icons" !important;
        }

        i.fa, i.fas, i.far, i.fal, i.fab, i.fad,
        i[class*="fa-"],
        .fa::before, .fas::before, .far::before,
        .fal::before, .fab::before, i[class*="fa-"]::before {
            font-family: "Font Awesome 6 Free", "Font Awesome 5 Free", "FontAwesome" !important;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--tg-text-3); border-radius: 99px; }

        /* ── 3. Sidebar ────────────────────────────────────────────────── */
        #sidebar {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: var(--tg-sidebar-w) !important;
            height: 100vh !important;
            max-height: 100vh !important;
            z-index: 100 !important;
            overflow: hidden !important;
            display: flex !important;
            flex-direction: column !important;
            background: var(--tg-sidebar-bg) !important;
            border-right: 1px solid var(--tg-sidebar-border) !important;
            transition: width var(--tg-t) var(--tg-ease), transform var(--tg-t) var(--tg-ease) !important;
        }

        #sidebar .sidebar-wrapper,
        #sidebar .sidebar-wrapper.active {
            display: flex !important;
            flex-direction: column !important;
            height: 100vh !important;
            max-height: 100vh !important;
            width: 100% !important;
            overflow: hidden !important;
            background: transparent !important;
            position: static !important;
            transform: none !important;
        }

        /* Header sidebar */
        #sidebar .sidebar-header {
            flex-shrink: 0 !important;
            height: var(--tg-topbar-h) !important;
            min-height: var(--tg-topbar-h) !important;
            display: flex !important;
            align-items: center !important;
            padding: 0 14px !important;
            gap: 8px !important;
            margin: 0 !important;
            border-bottom: 1px solid var(--tg-sidebar-border) !important;
            background: var(--tg-sidebar-bg) !important;
        }

        /*
         * .sidebar-menu: flex:1 + min-height:0 agar mengisi sisa tinggi.
         * overflow-y diset HANYA via JS (lihat killPerfectScrollbar) karena
         * Mazer PerfectScrollbar akan override CSS rule biasa dengan inline style.
         */
        #sidebar .sidebar-menu {
            flex: 1 1 0% !important;
            min-height: 0 !important;
            overflow-x: hidden !important;
            -webkit-overflow-scrolling: touch !important;
            overscroll-behavior: contain !important;
            padding-bottom: 24px !important;
            scrollbar-width: thin !important;
            scrollbar-color: rgba(156,163,175,.5) transparent !important;
        }
        #sidebar .sidebar-menu::-webkit-scrollbar { width: 3px !important; }
        #sidebar .sidebar-menu::-webkit-scrollbar-thumb {
            background: rgba(156,163,175,.5) !important;
            border-radius: 99px !important;
        }

        /* Hapus padding/margin berlebih dari Mazer */
        #sidebar .sidebar-menu > ul,
        #sidebar .sidebar-menu .menu-inner {
            padding-top: 4px !important;
            margin-top: 0 !important;
        }

        /* Main content offset — smooth transition saat toggle mini */
        #main, #main.layout-navbar {
            margin-left: var(--tg-sidebar-w) !important;
            width: calc(100% - var(--tg-sidebar-w)) !important;
            min-height: 100vh !important;
            transition: margin-left var(--tg-t) var(--tg-ease), width var(--tg-t) var(--tg-ease) !important;
        }
        body.sidebar-mini #main,
        body.sidebar-mini #main.layout-navbar {
            margin-left: var(--tg-sidebar-mini) !important;
            width: calc(100% - var(--tg-sidebar-mini)) !important;
        }
        @media (max-width: 1199.98px) {
            #main, #main.layout-navbar {
                margin-left: 0 !important;
                width: 100% !important;
            }
        }

/* ====== TOPBAR FIX ====== */

/* Dark pill: tinggi konsisten, icon sejajar */
.tg-dark-pill {
    height: 34px !important;
    padding: 0 12px !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 6px !important;
    line-height: 1 !important;
}
.tg-dark-pill .bi {
    font-size: 0.88rem !important;
    line-height: 1 !important;
    display: flex !important;
    align-items: center !important;
}

/* Burger button legacy — tidak dipakai lagi di topbar */
.burger-btn { display: none !important; }

/* Tombol buka sidebar mobile di topbar */
.tg-menu-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border-radius: var(--tg-r-sm);
    border: 1px solid var(--tg-border);
    background: transparent;
    color: var(--tg-text-2);
    cursor: pointer;
    flex-shrink: 0;
    transition: background var(--tg-t), color var(--tg-t);
}
.tg-menu-btn:hover {
    background: var(--tg-blue-lt);
    color: var(--tg-royal);
    border-color: rgba(59,130,246,.25);
}
.tg-menu-btn i { font-size: 1.25rem; line-height: 1; }
/* Desktop: sembunyikan — d-xl-none dibantu media query ini */
@media (min-width: 1200px) {
    .tg-menu-btn { display: none !important; }
}

        /* Brand TG kustom */
        .tg-brand-wrap {
            display: flex;
            align-items: center;
            gap: 9px;
            overflow: hidden;
            flex: 1;
            min-width: 0;
            text-decoration: none !important;
        }

        .tg-brand-icon {
            width: 34px; height: 34px;
            border-radius: var(--tg-r-sm);
            background: linear-gradient(135deg, var(--tg-navy), var(--tg-royal));
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 12px; font-weight: 800;
            flex-shrink: 0;
            box-shadow: var(--tg-sh-navy);
        }

        .tg-brand-text {
            font-size: 1.12rem !important;
            font-weight: 800 !important;
            letter-spacing: -0.025em !important;
            line-height: 1;
            white-space: nowrap;
            overflow: hidden;
            color: var(--tg-text) !important;
            opacity: 1;
            transition: opacity var(--tg-t) var(--tg-ease);
        }
        .tg-brand-text .tele { color: var(--tg-text) !important; }
        .tg-brand-text .grad { color: var(--tg-blue) !important; }

        /* Toggle sidebar desktop */
        .tg-toggle-btn {
            width: 30px; height: 30px;
            border: 1px solid var(--tg-border);
            background: transparent !important;
            border-radius: var(--tg-r-sm);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; color: var(--tg-text-3);
            flex-shrink: 0;
            transition: background var(--tg-t), color var(--tg-t), border-color var(--tg-t);
        }
        .tg-toggle-btn:hover {
            background: var(--tg-blue-lt) !important;
            color: var(--tg-royal) !important;
            border-color: rgba(59,130,246,.25) !important;
        }
        .tg-toggle-btn svg { transition: transform var(--tg-t) var(--tg-ease); }

        /* State: mini sidebar */
        body.sidebar-mini #sidebar { width: var(--tg-sidebar-mini) !important; }
        body.sidebar-mini .tg-brand-text { opacity: 0 !important; pointer-events: none; }
        body.sidebar-mini #sidebar .sidebar-section-title { opacity: 0 !important; }
        body.sidebar-mini #sidebar .sidebar-item .sidebar-link span:not(.menu-badge) { opacity: 0 !important; width: 0 !important; overflow: hidden; }
        body.sidebar-mini #sidebar .sidebar-item .menu-badge { opacity: 0 !important; }
        body.sidebar-mini .tg-toggle-btn svg { transform: rotate(180deg); }
        /* margin-left main saat mini sudah dihandle di blok #main di atas */

        /* Tooltip saat mini */
        body.sidebar-mini #sidebar .sidebar-item { position: relative; }
        body.sidebar-mini #sidebar .sidebar-item .sidebar-link::after {
            content: attr(data-tooltip);
            position: absolute;
            left: calc(var(--tg-sidebar-mini) - 4px);
            top: 50%; transform: translateY(-50%);
            background: var(--tg-navy); color: #fff;
            font-size: 0.72rem !important; font-weight: 600 !important;
            padding: 5px 12px; border-radius: var(--tg-r-sm);
            white-space: nowrap; pointer-events: none;
            opacity: 0; z-index: 999;
            box-shadow: var(--tg-sh-md);
            transition: opacity 0.15s;
        }
        body.sidebar-mini #sidebar .sidebar-item .sidebar-link:hover::after { opacity: 1; }

        /* ── 3b. Sidebar section title ── */
        #sidebar .sidebar-title {
            font-size: 0.62rem !important;
            font-weight: 700 !important;
            letter-spacing: 0.10em !important;
            text-transform: uppercase !important;
            color: var(--tg-text-3) !important;
            padding: 10px 20px 4px !important; /* turun dari 16px → 10px */
            white-space: nowrap;
            transition: opacity var(--tg-t);
        }
        /* Khusus section title pertama: lebih dekat ke header */
        #sidebar .sidebar-menu > ul > li:first-child .sidebar-title,
        #sidebar .sidebar-menu .menu-inner > .sidebar-title:first-child {
            padding-top: 8px !important;
        }

        /* ── 3c. Sidebar menu links ── */
        #sidebar .sidebar-item > .sidebar-link,
        #sidebar .sidebar-item > a.sidebar-link {
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            border-radius: var(--tg-r-sm) !important;
            margin: 2px 8px !important;
            padding: 9px 13px !important;
            font-size: 0.82rem !important;
            font-weight: 500 !important;
            color: var(--tg-text-2) !important;
            text-decoration: none !important;
            white-space: nowrap;
            overflow: hidden;
            transition:
                background var(--tg-t) var(--tg-ease),
                color var(--tg-t) var(--tg-ease),
                transform 0.15s var(--tg-ease),
                box-shadow var(--tg-t) var(--tg-ease) !important;
        }

        #sidebar .sidebar-item > .sidebar-link:hover,
        #sidebar .sidebar-item > a.sidebar-link:hover {
            background: var(--tg-blue-lt) !important;
            color: var(--tg-royal) !important;
            transform: translateX(2px);
        }

        /* Active */
        #sidebar .sidebar-item.active > .sidebar-link,
        #sidebar .sidebar-item.active > a.sidebar-link {
            background: linear-gradient(135deg, var(--tg-navy), var(--tg-royal)) !important;
            color: #fff !important;
            box-shadow: var(--tg-sh-navy) !important;
        }

        /* Icon di dalam link */
        #sidebar .sidebar-item .sidebar-link i,
        #sidebar .sidebar-item .sidebar-link svg {
            font-size: 0.875rem !important;
            width: 18px !important; min-width: 18px !important;
            text-align: center !important;
            flex-shrink: 0 !important;
            color: inherit !important;
            opacity: 0.70;
            transition: opacity var(--tg-t);
        }
        #sidebar .sidebar-item:hover .sidebar-link i,
        #sidebar .sidebar-item.active .sidebar-link i { opacity: 1; }

        /* Badge counter */
        #sidebar .sidebar-link .menu-badge {
            font-size: 0.60rem !important;
            font-weight: 700 !important;
            padding: 2px 7px !important;
            border-radius: 99px !important;
            background: var(--tg-accent) !important;
            color: #fff !important;
            margin-left: auto;
            flex-shrink: 0;
            transition: opacity var(--tg-t);
        }

        /* Stagger animation initial state */
        #sidebar .sidebar-item {
            opacity: 0;
            transform: translateX(-8px);
        }

        /* ── 4. Main layout adjust — lihat seksi 3 di atas ─────────────── */
        /* (sudah di-handle di blok sidebar, tidak perlu duplikasi) */

        /* ── 5. Topbar — full glass override ────────────────────────────── */
        .navbar.navbar-top,
        header .navbar-top {
            height: var(--tg-topbar-h) !important;
            background: var(--tg-glass) !important;
            backdrop-filter: var(--tg-blur) !important;
            -webkit-backdrop-filter: var(--tg-blur) !important;
            border-bottom: 1px solid var(--tg-glass-border) !important;
            box-shadow: 0 1px 0 var(--tg-border) !important;
            padding: 0 24px !important;
            position: sticky !important;
            top: 0;
            z-index: 101 !important; /* di atas overlay (z:99) dan sidebar (z:100) */
        }

        /* Burger */
        /* (dihandle di .tg-menu-btn di atas) */

        /* Notifikasi bell — presisi center, hapus caret Bootstrap */
        .tg-nav-btn {
            width: 38px !important;
            height: 38px !important;
            border-radius: var(--tg-r-sm) !important;
            border: 1px solid var(--tg-border) !important;
            background: transparent !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: var(--tg-text-2) !important;
            cursor: pointer !important;
            position: relative !important;
            text-decoration: none !important;
            transition: background var(--tg-t), color var(--tg-t), border-color var(--tg-t) !important;
            padding: 0 !important;
            line-height: 1 !important;
        }
        /* Hapus caret bawaan Bootstrap dropdown-toggle */
        .tg-nav-btn.dropdown-toggle::after { display: none !important; }
        .tg-nav-btn:hover {
            background: var(--tg-blue-lt) !important;
            color: var(--tg-royal) !important;
            border-color: rgba(59,130,246,.25) !important;
        }
        .tg-nav-btn .bi-bell {
            font-size: 1rem !important;
            line-height: 1 !important;
            transition: transform 0.2s var(--tg-ease);
        }
        .tg-nav-btn:hover .bi-bell { transform: rotate(-12deg) scale(1.1); }
        .tg-notif-dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: #EF4444; border: 1.5px solid white;
            position: absolute; top: 7px; right: 7px;
        }

        /* Dark toggle pill */
        .tg-dark-pill {
            display: flex; align-items: center; gap: 7px;
            padding: 5px 12px;
            border-radius: 99px;
            border: 1px solid var(--tg-border);
            background: transparent;
            cursor: pointer;
            color: var(--tg-text-2);
            font-size: 0.78rem;
            transition: background var(--tg-t), border-color var(--tg-t);
        }
        .tg-dark-pill:hover {
            background: var(--tg-blue-lt);
            border-color: rgba(59,130,246,.25);
        }
        .tg-dark-pill .bi { font-size: 0.92rem; }

        /* User chip */
        .tg-user-chip {
            display: flex; align-items: center; gap: 8px;
            padding: 4px 10px 4px 4px;
            border-radius: 99px;
            border: 1px solid var(--tg-border);
            background: transparent;
            cursor: pointer;
            text-decoration: none !important;
            transition: background var(--tg-t), border-color var(--tg-t);
        }
        /* Hapus caret Bootstrap dropdown-toggle */
        .tg-user-chip.dropdown-toggle::after { display: none !important; }
        .tg-user-chip:hover {
            background: var(--tg-blue-lt);
            border-color: rgba(59,130,246,.25);
        }
        .tg-user-chip .tg-avatar {
            width: 32px; height: 32px;
            border-radius: 50%; object-fit: cover;
            border: 2px solid var(--tg-blue-lt);
            box-shadow: 0 0 0 2px rgba(59,130,246,.15);
            flex-shrink: 0;
        }
        .tg-user-chip .tg-uname {
            font-size: 0.80rem !important; font-weight: 700 !important;
            color: var(--tg-text) !important; line-height: 1.2;
        }
        .tg-user-chip .tg-urole {
            font-size: 0.68rem !important;
            color: var(--tg-text-3) !important; line-height: 1.2;
        }
        @media (max-width: 767px) {
            .tg-user-meta { display: none !important; }
        }

        /* Dropdown */
        .dropdown-menu {
            border-radius: var(--tg-r-md) !important;
            border: 1px solid var(--tg-border) !important;
            box-shadow: var(--tg-sh-lg) !important;
            background: var(--tg-glass) !important;
            backdrop-filter: var(--tg-blur) !important;
            -webkit-backdrop-filter: var(--tg-blur) !important;
            padding: 6px !important;
            animation: tgDrop 0.18s var(--tg-ease) both;
        }
        @keyframes tgDrop {
            from { opacity:0; transform:translateY(-6px) scale(0.98); }
            to   { opacity:1; transform:translateY(0)   scale(1); }
        }
        .dropdown-item {
            border-radius: var(--tg-r-sm) !important;
            font-size: 0.80rem !important;
            font-weight: 500 !important;
            padding: 8px 12px !important;
            color: var(--tg-text) !important;
            transition: background 0.12s !important;
        }
        .dropdown-item:hover,
        .dropdown-item:focus {
            background: var(--tg-blue-lt) !important;
            color: var(--tg-royal) !important;
        }
        .dropdown-item.text-danger { color: #DC2626 !important; }
        .dropdown-item.text-danger:hover {
            background: var(--tg-err-bg) !important;
            color: var(--tg-err-tx) !important;
        }
        .dropdown-header {
            font-size: 0.62rem !important; font-weight: 700 !important;
            letter-spacing: 0.08em !important; text-transform: uppercase !important;
            color: var(--tg-text-3) !important;
            padding: 6px 12px 4px !important;
        }
        .dropdown-divider { border-color: var(--tg-border) !important; margin: 4px 0 !important; }

        /* ── 6. Page content ────────────────────────────────────────────── */
        #main-content { animation: tgUp 0.32s var(--tg-ease) both; }
        @keyframes tgUp {
            from { opacity:0; transform:translateY(12px); }
            to   { opacity:1; transform:translateY(0); }
        }

        .page-heading { padding: 24px 28px 10px !important; }

        /* .page-title legacy — kept for backward compat */
        .page-title h3 {
            font-size: 1.25rem !important;
            font-weight: 800 !important;
            letter-spacing: -0.025em !important;
            color: var(--tg-text) !important;
        }
        .page-title .text-subtitle,
        .page-title p.text-muted {
            font-size: 0.78rem !important;
            color: var(--tg-text-2) !important;
        }

        /* ── Page header bar (title kiri + breadcrumb kanan) ── */
        .tg-page-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .tg-page-bar-left { flex: 1; min-width: 0; }
        .tg-page-bar-right { flex-shrink: 0; }

        .tg-page-title {
            font-size: 1.25rem !important;
            font-weight: 800 !important;
            letter-spacing: -0.025em !important;
            color: var(--tg-text) !important;
            margin: 0 !important;
            line-height: 1.2 !important;
        }
        .tg-page-desc {
            font-size: 0.78rem !important;
            color: var(--tg-text-2) !important;
            margin: 3px 0 0 !important;
            line-height: 1.4 !important;
        }

        /* Breadcrumb */
        .breadcrumb {
            background: none !important;
            padding: 0 !important;
            margin: 0 !important;
            display: flex !important;
            align-items: center !important;
            flex-wrap: nowrap !important;
        }
        .breadcrumb-item {
            display: flex !important;
            align-items: center !important;
            line-height: 1 !important;
        }
        .breadcrumb-item a {
            font-size: 0.76rem !important;
            font-weight: 500 !important;
            color: var(--tg-blue) !important;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 4px !important;
            line-height: 1 !important;
        }
        .breadcrumb-item a i {
            font-size: 0.80rem !important;
            line-height: 1 !important;
            position: relative !important;
            top: 0 !important;
        }
        .breadcrumb-item a:hover { color: var(--tg-royal) !important; }
        .breadcrumb-item.active {
            font-size: 0.76rem !important;
            font-weight: 500 !important;
            color: var(--tg-text-2) !important;
            line-height: 1 !important;
            display: flex !important;
            align-items: center !important;
        }
        .breadcrumb-item + .breadcrumb-item::before {
            color: var(--tg-text-3) !important;
            font-size: 0.76rem !important;
            line-height: 1 !important;
            display: flex !important;
            align-items: center !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
        }

        @media (max-width: 576px) {
            .tg-page-bar { flex-direction: column; align-items: flex-start; gap: 8px; }
            .tg-page-bar-right { align-self: flex-start; }
        }

        /* ── 7. Cards ───────────────────────────────────────────────────── */
        .card {
            background: var(--tg-glass) !important;
            backdrop-filter: var(--tg-blur) !important;
            -webkit-backdrop-filter: var(--tg-blur) !important;
            border: 1px solid var(--tg-glass-border) !important;
            border-radius: var(--tg-r-lg) !important;
            box-shadow: var(--tg-sh-sm) !important;
            transition: box-shadow var(--tg-t) var(--tg-ease),
                        transform var(--tg-t) var(--tg-ease) !important;
        }
        .card:hover {
            box-shadow: var(--tg-sh-md) !important;
            transform: translateY(-2px);
        }
        .card-header {
            background: transparent !important;
            border-bottom: 1px solid var(--tg-border) !important;
            padding: 16px 20px !important;
        }
        .card-header .card-title {
            font-size: 0.92rem !important; font-weight: 700 !important;
            color: var(--tg-text) !important;
        }
        .card-body { padding: 20px !important; }

        /* ── 8. Stat cards (Mazer widget override) ──────────────────────── */
        .stats-icon,
        .card .stats-icon {
            border-radius: var(--tg-r-md) !important;
        }

        /* ── 9. Buttons ─────────────────────────────────────────────────── */
        .btn {
            border-radius: var(--tg-r-sm) !important;
            font-weight: 600 !important;
            font-size: 0.80rem !important;
            transition: all 0.18s var(--tg-ease) !important;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--tg-royal), var(--tg-blue)) !important;
            border: none !important;
            color: #fff !important;
            box-shadow: var(--tg-sh-blue) !important;
        }
        .btn-primary:hover, .btn-primary:focus {
            transform: translateY(-1px) !important;
            box-shadow: 0 6px 20px rgba(59,130,246,.40) !important;
            background: linear-gradient(135deg, var(--tg-navy), var(--tg-blue)) !important;
        }
        .btn-primary:active { transform: translateY(0) !important; }
        .btn-danger {
            background: #DC2626 !important; border: none !important;
            box-shadow: 0 4px 12px rgba(220,38,38,.25) !important;
        }
        .btn-danger:hover { transform: translateY(-1px) !important; }
        .btn-light, .btn-outline-primary {
            background: transparent !important;
            border: 1px solid var(--tg-border) !important;
            color: var(--tg-text-2) !important;
        }
        .btn-light:hover, .btn-outline-primary:hover {
            background: var(--tg-blue-lt) !important;
            border-color: rgba(59,130,246,.25) !important;
            color: var(--tg-royal) !important;
        }

        /* Icon buttons (edit, view, delete) */
        .btn-icon {
            width: 32px !important; height: 32px !important;
            padding: 0 !important;
            display: inline-flex !important; align-items: center !important;
            justify-content: center !important;
            border-radius: var(--tg-r-sm) !important;
            border: 1px solid var(--tg-border) !important;
            background: transparent !important;
            color: var(--tg-text-2) !important;
            font-size: 0.82rem !important;
            transition: all 0.15s !important;
        }
        .btn-icon:hover { transform: scale(1.08) !important; }
        .btn-icon.btn-warning { border-color: rgba(245,158,11,.3) !important; color: #D97706 !important; }
        .btn-icon.btn-warning:hover { background: var(--tg-warn-bg) !important; }
        .btn-icon.btn-success { border-color: rgba(16,185,129,.3) !important; color: #059669 !important; }
        .btn-icon.btn-success:hover { background: var(--tg-ok-bg) !important; }
        .btn-icon.btn-danger  { border-color: rgba(220,38,38,.3)  !important; color: #DC2626 !important; box-shadow: none !important; }
        .btn-icon.btn-danger:hover  { background: var(--tg-err-bg) !important; }

        /* ── 10. Tables ─────────────────────────────────────────────────── */
        .table thead th {
            font-size: 0.66rem !important; font-weight: 700 !important;
            text-transform: uppercase !important; letter-spacing: 0.08em !important;
            color: var(--tg-text-3) !important;
            padding: 12px 16px !important;
            border-bottom: 1px solid var(--tg-border) !important;
            background: transparent !important;
            white-space: nowrap;
        }
        .table tbody td {
            padding: 12px 16px !important;
            vertical-align: middle !important;
            font-size: 0.82rem !important;
            color: var(--tg-text) !important;
            border-bottom: 1px solid var(--tg-border) !important;
        }
        .table tbody tr:last-child td { border-bottom: none !important; }
        .table-hover tbody tr { transition: background 0.12s; }
        .table-hover tbody tr:hover { background: var(--tg-blue-lt2) !important; }

        /* ── 11. Badges ─────────────────────────────────────────────────── */
        .badge {
            font-size: 0.67rem !important; font-weight: 700 !important;
            padding: 4px 10px !important; border-radius: 99px !important;
            letter-spacing: 0.02em;
        }
        .badge.bg-success, .badge-success { background: var(--tg-ok-bg)   !important; color: var(--tg-ok-tx)   !important; }
        .badge.bg-warning, .badge-warning { background: var(--tg-warn-bg) !important; color: var(--tg-warn-tx) !important; }
        .badge.bg-danger,  .badge-danger  { background: var(--tg-err-bg)  !important; color: var(--tg-err-tx)  !important; }
        .badge.bg-info,    .badge-info    { background: var(--tg-info-bg) !important; color: var(--tg-info-tx) !important; }
        .badge.bg-primary, .badge-primary { background: var(--tg-blue-lt) !important; color: var(--tg-royal)   !important; }
        .badge.bg-secondary              { background: rgba(100,116,139,.12) !important; color: var(--tg-text-2) !important; }

        /* ── 12. Form controls ──────────────────────────────────────────── */
        .form-control, .form-select {
            border-radius: var(--tg-r-sm) !important;
            font-size: 0.82rem !important;
            border: 1px solid rgba(0,0,0,0.10) !important;
            background: rgba(255,255,255,0.70) !important;
            color: var(--tg-text) !important;
            padding: 9px 13px !important;
            transition: border-color 0.15s, box-shadow 0.15s !important;
        }
        [data-theme="dark"] .form-control,
        [data-theme="dark"] .form-select {
            background: rgba(15,23,42,0.50) !important;
            border-color: rgba(255,255,255,0.10) !important;
        }
        .form-control::placeholder { color: var(--tg-text-3) !important; }
        .form-control:focus, .form-select:focus {
            border-color: var(--tg-blue) !important;
            box-shadow: 0 0 0 3px rgba(59,130,246,.15) !important;
            outline: none !important;
        }
        .form-label {
            font-size: 0.80rem !important; font-weight: 600 !important;
            color: var(--tg-text-2) !important; margin-bottom: 5px !important;
        }

        /* ── 13. Alerts ─────────────────────────────────────────────────── */
        .alert {
            border-radius: var(--tg-r-md) !important;
            font-size: 0.82rem !important; border: none !important;
        }
        .alert-success { background: var(--tg-ok-bg)   !important; color: var(--tg-ok-tx)   !important; }
        .alert-warning { background: var(--tg-warn-bg) !important; color: var(--tg-warn-tx) !important; }
        .alert-danger  { background: var(--tg-err-bg)  !important; color: var(--tg-err-tx)  !important; }
        .alert-info    { background: var(--tg-info-bg) !important; color: var(--tg-info-tx) !important; }

        /* ── 14. Footer ─────────────────────────────────────────────────── */
        footer .footer {
            font-size: 0.76rem !important; padding: 14px 28px !important;
            border-top: 1px solid var(--tg-border) !important;
            color: var(--tg-text-3) !important;
            background: transparent !important;
        }

        /* ── 15. Mobile overlay ─────────────────────────────────────────── */
        .tg-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.40);
            z-index: 99; /* di bawah sidebar (100) dan topbar (101) */
            /* TIDAK pakai backdrop-filter — itu yang bikin konten blur */
        }
        .tg-overlay.active { display: block; }

        /* ── Override PerfectScrollbar Mazer di sidebar ── */
        /* Mazer load PS dan set overflow:hidden — kita paksa balik */
        #sidebar .sidebar-menu.ps,
        #sidebar .sidebar-menu.ps--active-y {
            overflow-y: auto !important;
            overflow-x: hidden !important;
        }
        /* Sembunyikan rail PS di sidebar */
        #sidebar .ps__rail-x,
        #sidebar .ps__rail-y { display: none !important; }

        /* ── Mobile: sidebar drawer ─────────────────────────────────────── */
        @media (max-width: 1199.98px) {
            #sidebar {
                transform: translateX(-100%) !important;
                width: var(--tg-sidebar-w) !important;
                box-shadow: none !important;
                transition: transform var(--tg-t) var(--tg-ease), box-shadow var(--tg-t) var(--tg-ease) !important;
            }
            #sidebar.sidebar-open {
                transform: translateX(0) !important;
                box-shadow: var(--tg-sh-lg) !important;
            }
        }

        /* ── 16. Dark mode explicit overrides (sidebar + page) ──────────── */
        /* Body & page background */
        [data-theme="dark"] body {
            background: var(--tg-page-bg) !important;
        }

        /* Topbar dark */
        [data-theme="dark"] .navbar.navbar-top,
        [data-theme="dark"] header .navbar-top {
            background: rgba(13,27,46,0.90) !important;
            border-bottom-color: rgba(255,255,255,0.07) !important;
        }

        /* Sidebar text dark */
        [data-theme="dark"] #sidebar .sidebar-title { color: var(--tg-text-3) !important; }
        [data-theme="dark"] #sidebar .sidebar-item > .sidebar-link,
        [data-theme="dark"] #sidebar .sidebar-item > a.sidebar-link {
            color: var(--tg-text-2) !important;
        }
        [data-theme="dark"] #sidebar .sidebar-item > .sidebar-link:hover,
        [data-theme="dark"] #sidebar .sidebar-item > a.sidebar-link:hover {
            background: rgba(59,130,246,0.12) !important;
            color: #93C5FD !important;
        }
        [data-theme="dark"] #sidebar .sidebar-item.active > .sidebar-link,
        [data-theme="dark"] #sidebar .sidebar-item.active > a.sidebar-link {
            background: linear-gradient(135deg, var(--tg-navy), var(--tg-royal)) !important;
            color: #fff !important;
        }

        /* Cards dark */
        [data-theme="dark"] .card {
            background: rgba(13,27,46,0.85) !important;
            border-color: rgba(255,255,255,0.07) !important;
        }

        /* Dropdown dark */
        [data-theme="dark"] .dropdown-menu {
            background: rgba(13,27,46,0.96) !important;
            border-color: rgba(255,255,255,0.08) !important;
        }
        [data-theme="dark"] .dropdown-item { color: var(--tg-text-2) !important; }
        [data-theme="dark"] .dropdown-item:hover { background: rgba(59,130,246,0.15) !important; color: #93C5FD !important; }
    </style>

    @yield('custom-css')
</head>

<body>
    @include('sweetalert::alert')

    {{-- Anti-flash: terapkan tema sebelum paint pertama --}}
    <script>
        (function(){
            var t = localStorage.getItem('tg-theme') || 'light';
            document.documentElement.setAttribute('data-theme', t);
            /* dark class on body diterapkan via applyTheme() setelah DOMContentLoaded */
            if (localStorage.getItem('tg-sidebar-mini') === '1') {
                document.documentElement.classList.add('sidebar-mini-pending');
            }
        })();
    </script>

    <div class="tg-overlay" id="tgOverlay" onclick="closeMobile()"></div>

    <div id="app">

        {{-- ============================================================ --}}
        {{-- SIDEBAR                                                        --}}
        {{-- ============================================================ --}}
        <div id="sidebar">
            <div class="sidebar-wrapper active">

                {{-- Header --}}
                <div class="sidebar-header">

                    {{-- Brand --}}
                    <a href="{{ route('admin.dashboard') }}" class="tg-brand-wrap">
                        <div class="tg-brand-icon">TG</div>
                        <span class="tg-brand-text">
                            <span class="tele">Tele</span><span class="grad">grad</span>
                        </span>
                    </a>

                    {{-- Desktop: collapse/expand sidebar --}}
                    <button class="tg-toggle-btn d-none d-xl-flex"
                            id="btnSidebarToggle"
                            onclick="toggleMini()"
                            aria-label="Toggle sidebar">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2.5"
                             stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="6" x2="21" y2="6"/>
                            <line x1="3" y1="12" x2="21" y2="12"/>
                            <line x1="3" y1="18" x2="21" y2="18"/>
                        </svg>
                    </button>

                    {{-- Mobile: tutup sidebar drawer --}}
                    <button class="tg-toggle-btn d-xl-none"
                            onclick="closeMobile()"
                            aria-label="Tutup menu">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2.5"
                             stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"/>
                            <line x1="6" y1="6" x2="18" y2="18"/>
                        </svg>
                    </button>

                </div>

                {{-- Menu --}}
                <div class="sidebar-menu">
                    @include('admin.sidebar')
                </div>

            </div>
        </div>
        {{-- /SIDEBAR --}}

        {{-- ============================================================ --}}
        {{-- MAIN                                                           --}}
        {{-- ============================================================ --}}
        <div id="main" class="layout-navbar navbar-fixed">

            {{-- Topbar --}}
            <header>
                <nav class="navbar navbar-expand navbar-light navbar-top">
                    <div class="container-fluid gap-2">

                        {{-- Tombol buka sidebar (mobile only) --}}
                        <button class="tg-menu-btn d-xl-none"
                                onclick="openMobile()"
                                aria-label="Buka menu">
                            <i class="bi bi-list"></i>
                        </button>

                        <div class="flex-grow-1"></div>

                        <div class="d-flex align-items-center gap-2">

                            {{-- Dark Mode Toggle --}}
                            <button class="tg-dark-pill d-none d-md-flex"
                                    onclick="toggleDark()"
                                    id="btnDark"
                                    aria-label="Toggle dark mode">
                                <i class="bi bi-sun" id="tgIconSun"></i>
                                <i class="bi bi-moon d-none" id="tgIconMoon"></i>
                            </button>

                            {{-- Notifikasi --}}
                            <div class="dropdown">
                                <a href="#" class="tg-nav-btn dropdown-toggle"
                                   data-bs-toggle="dropdown"
                                   aria-label="Notifikasi">
                                    <i class="bi bi-bell fs-6"></i>
                                    <span class="tg-notif-dot"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" style="min-width:240px;">
                                    <li><h6 class="dropdown-header">Notifikasi</h6></li>
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="bi bi-inbox me-2 opacity-50"></i>
                                            Tidak ada notifikasi baru
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            {{-- User --}}
                            <div class="dropdown">
                                <a href="#" class="tg-user-chip dropdown-toggle"
                                   data-bs-toggle="dropdown"
                                   aria-label="Menu pengguna">
                                    <img class="tg-avatar"
                                         src="{{ asset('storage/images/profile/' . (Auth::user()->photo ?? 'default.jpg')) }}"
                                         alt="{{ Auth::user()->name }}"
                                         onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=1E3A8A&color=fff&size=64'">
                                    <div class="tg-user-meta">
                                        <div class="tg-uname">{{ Auth::user()->name }}</div>
                                        <div class="tg-urole">Administrator</div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" style="min-width:14rem;">
                                    <li>
                                        <div class="px-3 py-2">
                                            <div style="font-size:.82rem;font-weight:700;color:var(--tg-text);">{{ Auth::user()->name }}</div>
                                            <div style="font-size:.70rem;color:var(--tg-text-3);">Administrator</div>
                                        </div>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                            <i class="bi bi-person me-2 opacity-75"></i>Profil Saya
                                        </a>
                                    </li>
                                    <li class="d-md-none">
                                        <a class="dropdown-item" href="#" onclick="toggleDark();return false;">
                                            <i class="bi bi-moon me-2 opacity-75"></i>Dark Mode
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="#" onclick="logoutAdmin(event)">
                                            <i class="bi bi-box-arrow-left me-2"></i>Keluar
                                        </a>
                                        <form id="logout-form-admin"
                                              action="{{ route('admin.logout') }}"
                                              method="POST" style="display:none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </nav>
            </header>

            {{-- Page Content --}}
            <div id="main-content">
                <div class="page-heading">

                    {{-- ── Page header bar ── --}}
                    <div class="tg-page-bar">
                        <div class="tg-page-bar-left">
                            <h3 class="tg-page-title">{{ $submenu ?? '' }}</h3>
                            @if(!empty($subdesc))
                            <p class="tg-page-desc">{{ $subdesc }}</p>
                            @endif
                        </div>
                        <nav aria-label="breadcrumb" class="tg-page-bar-right">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-house-door"></i>
                                        <span>{{ $menu ?? 'Dashboard' }}</span>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ $submenu ?? '' }}
                                </li>
                            </ol>
                        </nav>
                    </div>

                    @yield('content')

                </div>
            </div>

            {{-- Footer --}}
            <footer>
                <div class="footer clearfix mb-0">
                    <div class="float-start">
                        <p class="mb-0">&copy; {{ date('Y') }} {{ $web->site_name ?? 'Telegrad' }}</p>
                    </div>
                    <div class="float-end">
                        <p class="mb-0">
                            Crafted with <span style="color:#EF4444;"><i class="bi bi-heart-fill"></i></span>
                            by Telegrad Team
                        </p>
                    </div>
                </div>
            </footer>

        </div>
        {{-- /MAIN --}}

    </div>

    <!-- Scripts -->
    <script src="{{ asset('dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    {{-- Stub PerfectScrollbar SEBELUM app.js load agar Mazer tidak init PS --}}
    <script>
        window.PerfectScrollbar = function() {
            return { update: function(){}, destroy: function(){} };
        };
        window.PerfectScrollbar.prototype = { update: function(){}, destroy: function(){} };
        if (window.ps !== undefined) { window.ps = null; }
    </script>
    <script src="{{ asset('dist/assets/compiled/js/app.js') }}"></script>
    <script src="{{ asset('vendor/sweetalerts2/sweetalerts2.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalerts2/custom-sweetalert.js') }}"></script>
    <script src="{{ asset('dist/assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('dist/assets/static/js/pages/simple-datatables.js') }}"></script>

    <script>
        /* =============================================================
         *  Telegrad Admin — Core UI Logic
         * ============================================================= */

        const KEY_THEME = 'tg-theme';
        const KEY_MINI  = 'tg-sidebar-mini';

        /* ── Dark Mode ─────────────────────────────────────────────── */
        function applyTheme(t) {
            document.documentElement.setAttribute('data-theme', t);
            if (document.body) document.body.classList.toggle('dark', t === 'dark');
            localStorage.setItem(KEY_THEME, t);
            var sun  = document.getElementById('tgIconSun');
            var moon = document.getElementById('tgIconMoon');
            if (sun && moon) {
                sun.classList.toggle('d-none', t === 'dark');
                moon.classList.toggle('d-none', t !== 'dark');
            }
        }

        function toggleDark() {
            var cur = document.documentElement.getAttribute('data-theme') || 'light';
            applyTheme(cur === 'dark' ? 'light' : 'dark');
        }

        /* ── Sidebar Desktop Mini ──────────────────────────────────── */
        function toggleMini() {
            var isMini = document.body.classList.toggle('sidebar-mini');
            localStorage.setItem(KEY_MINI, isMini ? '1' : '0');
        }

        /* ── Sidebar Mobile ────────────────────────────────────────── */
        function openMobile() {
            document.getElementById('sidebar').classList.add('sidebar-open');
            document.getElementById('tgOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        /* Burger: di desktop toggle mini, di mobile buka drawer */
        function handleBurger() {
            if (window.innerWidth >= 1200) {
                toggleMini();   /* fungsi ini sudah ada */
            } else {
                openMobile();   /* fungsi ini sudah ada */
            }
        }

        function closeMobile() {
            document.getElementById('sidebar').classList.remove('sidebar-open');
            document.getElementById('tgOverlay').classList.remove('active');
            document.body.style.overflow = '';
        }

        /* ── Init on DOMContentLoaded ───────────────────────────────── */
        document.addEventListener('DOMContentLoaded', function () {
            /* Tema */
            applyTheme(localStorage.getItem(KEY_THEME) || 'light');

            /* Sidebar mini: restore dari localStorage */
            if (localStorage.getItem(KEY_MINI) === '1') {
                document.body.classList.add('sidebar-mini');
            }

            /* Stagger sidebar items */
            document.querySelectorAll('#sidebar .sidebar-item').forEach(function (el, i) {
                setTimeout(function () {
                    el.style.transition = 'opacity .22s ease, transform .22s ease';
                    el.style.opacity    = '1';
                    el.style.transform  = 'translateX(0)';
                }, i * 28);
            });

            /* Jalankan kill PS pertama kali */
            killPerfectScrollbar();
        });

        /* ── Kill PerfectScrollbar (cleanup setelah Mazer init) ───── */
        function killPerfectScrollbar() {
            var menu = document.querySelector('#sidebar .sidebar-menu');
            if (!menu) return;

            /* Hapus class PS */
            menu.classList.remove('ps', 'ps--active-y', 'ps--active-x');

            /* Hapus elemen rail PS */
            menu.querySelectorAll('.ps__rail-x, .ps__rail-y').forEach(function(r){ r.remove(); });

            /* Set overflow langsung via inline style (lebih kuat dari !important CSS) */
            menu.style.cssText += '; overflow-y: auto !important; overflow-x: hidden !important;';

            /* MutationObserver sebagai jaring pengaman terakhir */
            if (menu._tgObserver) menu._tgObserver.disconnect();
            menu._tgObserver = new MutationObserver(function(muts) {
                muts.forEach(function(m) {
                    if (m.attributeName === 'style') {
                        var s = menu.style;
                        if (s.overflow === 'hidden' || s.overflowY === 'hidden') {
                            menu.style.setProperty('overflow-y', 'auto', 'important');
                            menu.style.setProperty('overflow-x', 'hidden', 'important');
                        }
                    }
                    if (m.attributeName === 'class') {
                        menu.classList.remove('ps', 'ps--active-y', 'ps--active-x');
                    }
                });
            });
            menu._tgObserver.observe(menu, { attributes: true, attributeFilter: ['style', 'class'] });
        }

        /* Jalankan di DOMContentLoaded + load + delay berlapis */
        document.addEventListener('DOMContentLoaded', function(){ setTimeout(killPerfectScrollbar, 0); });
        window.addEventListener('load', function(){
            killPerfectScrollbar();
            setTimeout(killPerfectScrollbar, 100);
            setTimeout(killPerfectScrollbar, 500);
        });

        /* ── SweetAlert Logout ─────────────────────────────────────── */
        function logoutAdmin(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Yakin ingin keluar?',
                text: 'Sesi Anda akan diakhiri.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                confirmButtonColor: '#1E3A8A',
            }).then(function (r) {
                if (r.isConfirmed) {
                    document.getElementById('logout-form-admin').submit();
                }
            });
        }

        /* ── SweetAlert Delete ─────────────────────────────────────── */
        function deleteData(id) {
            Swal.fire({
                title: 'Hapus data ini?',
                text: 'Data yang dihapus tidak bisa dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                confirmButtonColor: '#DC2626',
            }).then(function (r) {
                if (r.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>

    @yield('custom-js')
</body>
</html>