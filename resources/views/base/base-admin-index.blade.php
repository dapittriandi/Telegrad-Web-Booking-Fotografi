<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ ($web->site_name ?? 'Telegrad') . ' — ' . ($submenu ?? 'Admin') }}</title>

    <!-- Mazer Admin Template -->
    <link rel="stylesheet" href="{{ asset('dist/assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/assets/compiled/css/app-dark.css') }}">

    <!-- SweetAlert -->
    <link rel="stylesheet" href="{{ asset('vendor/sweetalerts2/sweetalerts2.css') }}">

    <!-- FontAwesome -->
    <link href="{{ asset('root/assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="{{ asset('root/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('dist/assets/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/assets/compiled/css/table-datatable.css') }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* ─── CSS Variables ─────────────────────────────────────── */
        :root {
            --tg-navy:      #0A1628;
            --tg-royal:     #1E3A8A;
            --tg-blue:      #3B82F6;
            --tg-blue-lt:   #EFF6FF;
            --tg-accent:    #F59E0B;
            --tg-radius:    12px;
            --tg-shadow:    0 1px 3px rgba(0,0,0,.08), 0 4px 16px rgba(0,0,0,.04);
            --tg-font:      'Plus Jakarta Sans', sans-serif;
        }

        /* ─── Global ─────────────────────────────────────────────── */
        body, * { font-family: var(--tg-font) !important; }

        /* ─── Page fade-in ───────────────────────────────────────── */
        #main-content { animation: fadeUp .35s ease both; }
        @keyframes fadeUp {
            from { opacity:0; transform:translateY(10px); }
            to   { opacity:1; transform:translateY(0); }
        }

        /* ─── Sidebar refinements ────────────────────────────────── */
        #sidebar .sidebar-wrapper {
            border-right: 1px solid rgba(0,0,0,.06);
        }
        .sidebar-header {
            padding: 18px 20px 14px !important;
            border-bottom: 1px solid rgba(0,0,0,.06);
        }

        /* Sembunyikan logo bawaan Mazer */
        .sidebar-header .logo img,
        .sidebar-header .logo .logo-name,
        .sidebar-header .logo h5,
        .sidebar-header .logo span.align-middle {
            display: none !important;
        }

        /* Brand Telegrad */
        .tg-brand {
            font-size: 1.25rem;
            font-weight: 800;
            letter-spacing: -.02em;
            line-height: 1;
            text-decoration: none !important;
            display: inline-block;
        }
        .tg-brand .tele { color: #000000 !important; }
        .tg-brand .grad { color: #1f81cd !important; }
        .dark .tg-brand .tele { color: #f1f5f9 !important; }
        .dark .tg-brand .grad { color: #1f81cd !important; }

        /* Sidebar menu items */
        .sidebar-item .sidebar-link {
            border-radius: 10px !important;
            margin: 2px 8px !important;
            padding: 9px 14px !important;
            transition: background .18s, color .18s, transform .15s !important;
            font-size: .84rem !important;
            font-weight: 500 !important;
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
        }
        .sidebar-item .sidebar-link i {
            font-family: "Font Awesome 6 Free" !important;
            font-weight: 900 !important;
            font-style: normal !important;
            -webkit-font-smoothing: antialiased !important;
            display: inline-block !important;
            width: 16px !important;
            text-align: center !important;
            font-size: .88rem !important;
            flex-shrink: 0 !important;
            color: #94a3b8 !important;
            transition: color .15s !important;
        }
        .sidebar-item .sidebar-link:hover {
            background: var(--tg-blue-lt) !important;
            color: var(--tg-royal) !important;
            transform: translateX(2px);
        }
        .sidebar-item .sidebar-link:hover i { color: var(--tg-royal) !important; }
        .sidebar-item.active > .sidebar-link {
            background: linear-gradient(135deg, var(--tg-navy), var(--tg-royal)) !important;
            color: #fff !important;
            box-shadow: 0 4px 14px rgba(30,58,138,.25) !important;
        }
        .sidebar-item.active > .sidebar-link i,
        .sidebar-item.active > .sidebar-link svg { color: #fff !important; }

        /* Sidebar section title */
        .sidebar-title {
            font-size: .67rem !important;
            font-weight: 700 !important;
            letter-spacing: .09em !important;
            text-transform: uppercase !important;
            padding: 16px 22px 5px !important;
            color: #94a3b8 !important;
        }

        /* ─── Topbar ─────────────────────────────────────────────── */
        /* FIXED: dihapus karakter Arab yang corrupt di baris sebelumnya */
        .navbar-top {
            backdrop-filter: blur(12px);
            background: rgba(255,255,255,.9) !important;
            border-bottom: 1px solid rgba(0,0,0,.07);
            box-shadow: none !important;
            padding: 10px 20px !important;
        }
        .dark .navbar-top {
            background: rgba(18,28,54,.9) !important;
            border-bottom-color: rgba(255,255,255,.07);
        }

        /* ─── Topbar — user avatar ───────────────────────────────── */
        .avatar.avatar-md img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--tg-blue-lt);
            box-shadow: 0 0 0 3px rgba(59,130,246,.15);
        }
        .user-name h6 { font-size: .84rem !important; font-weight: 600 !important; }
        .user-name p  { font-size: .72rem !important; }

        /* ─── Topbar notification bell ───────────────────────────── */
        .nav-link .bi-bell { transition: transform .2s; }
        .nav-link:hover .bi-bell { transform: rotate(-15deg) scale(1.15); }

        /* ─── User menu pill ─────────────────────────────────────── */
        .user-menu {
            border-radius: 12px;
            border: 1px solid rgba(0,0,0,.08);
            transition: background .15s;
            cursor: pointer;
        }
        .user-menu:hover { background: #F9FAFB !important; }
        .dark .user-menu { border-color: rgba(255,255,255,.08); }
        .dark .user-menu:hover { background: rgba(255,255,255,.06) !important; }

        /* Notif hover bg */
        .notif-btn { border-radius: 10px; transition: background .15s; }
        .notif-btn:hover { background: #F3F4F6 !important; }
        .dark .notif-btn:hover { background: rgba(255,255,255,.08) !important; }

        /* ─── Page heading ───────────────────────────────────────── */
        .page-heading { padding: 24px 28px 12px !important; }
        .page-title h3 {
            font-size: 1.35rem !important;
            font-weight: 800 !important;
            letter-spacing: -.02em;
            margin-bottom: 2px;
        }
        .page-title .text-subtitle { font-size: .8rem !important; }

        /* ─── Breadcrumb ─────────────────────────────────────────── */
        .breadcrumb-item a { font-size: .78rem; font-weight: 500; color: var(--tg-blue); }
        .breadcrumb-item.active { font-size: .78rem; }

        /* ─── Card global ────────────────────────────────────────── */
        .card {
            border: 1px solid rgba(0,0,0,.07) !important;
            border-radius: var(--tg-radius) !important;
            box-shadow: var(--tg-shadow) !important;
            transition: box-shadow .2s;
        }
        .card:hover { box-shadow: 0 4px 24px rgba(0,0,0,.09) !important; }
        .card-header {
            border-bottom: 1px solid rgba(0,0,0,.06) !important;
            padding: 16px 20px !important;
            background: transparent !important;
        }
        .card-header .card-title {
            font-size: .95rem !important;
            font-weight: 700 !important;
            letter-spacing: -.01em;
        }
        .card-body { padding: 20px !important; }

        /* ─── Buttons ────────────────────────────────────────────── */
        .btn {
            border-radius: 8px !important;
            font-weight: 600 !important;
            font-size: .8rem !important;
            transition: all .18s !important;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--tg-royal), var(--tg-blue)) !important;
            border: none !important;
            box-shadow: 0 4px 12px rgba(59,130,246,.3) !important;
        }
        .btn-primary:hover {
            transform: translateY(-1px) !important;
            box-shadow: 0 6px 18px rgba(59,130,246,.4) !important;
        }
        .btn-primary:active { transform: translateY(0) !important; }

        /* ─── Tables ─────────────────────────────────────────────── */
        .table thead th {
            font-size: .70rem !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            letter-spacing: .07em !important;
            color: #6B7280 !important;
            padding: 12px 14px !important;
            border-bottom: 2px solid #F3F4F6 !important;
            white-space: nowrap;
        }
        .table tbody td {
            padding: 12px 14px !important;
            vertical-align: middle !important;
            font-size: .84rem !important;
            border-bottom: 1px solid #F9FAFB !important;
        }
        .table-hover tbody tr { transition: background .12s; }
        .table-hover tbody tr:hover { background: #FAFBFF !important; }

        /* ─── Badges ─────────────────────────────────────────────── */
        .badge {
            font-size: .70rem !important;
            font-weight: 600 !important;
            padding: 4px 10px !important;
            border-radius: 100px !important;
        }

        /* ─── Form controls ──────────────────────────────────────── */
        .form-control, .form-select {
            border-radius: 8px !important;
            font-size: .84rem !important;
            border-color: #E5E7EB !important;
            padding: 9px 13px !important;
            transition: border-color .15s, box-shadow .15s !important;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--tg-blue) !important;
            box-shadow: 0 0 0 3px rgba(59,130,246,.15) !important;
        }
        .form-label {
            font-size: .82rem !important;
            font-weight: 600 !important;
            color: #374151 !important;
            margin-bottom: 5px !important;
        }

        /* ─── Footer ─────────────────────────────────────────────── */
        footer .footer {
            font-size: .78rem !important;
            padding: 14px 28px !important;
            border-top: 1px solid rgba(0,0,0,.06);
        }

        /* ─── Dark mode overrides ────────────────────────────────── */
        .dark .card { border-color: rgba(255,255,255,.07) !important; }
        .dark .table thead th {
            border-bottom-color: rgba(255,255,255,.08) !important;
            color: #9CA3AF !important;
        }
        .dark .table tbody td { border-bottom-color: rgba(255,255,255,.04) !important; }
        .dark .form-control, .dark .form-select {
            border-color: rgba(255,255,255,.12) !important;
            background: rgba(255,255,255,.04) !important;
            color: #f1f5f9 !important;
        }
        .dark .form-label { color: #CBD5E1 !important; }
        .dark .table-hover tbody tr:hover { background: rgba(255,255,255,.03) !important; }

        /* ─── Dropdown ───────────────────────────────────────────── */
        .dropdown-menu {
            border-radius: 12px !important;
            border: 1px solid rgba(0,0,0,.08) !important;
            box-shadow: 0 8px 30px rgba(0,0,0,.12) !important;
            padding: 6px !important;
            animation: dropIn .18s ease;
        }
        @keyframes dropIn {
            from { opacity:0; transform:translateY(-6px); }
            to   { opacity:1; transform:translateY(0); }
        }
        .dropdown-item {
            border-radius: 8px !important;
            font-size: .82rem !important;
            font-weight: 500 !important;
            padding: 8px 12px !important;
            transition: background .12s !important;
        }

        /* ─── Alert ──────────────────────────────────────────────── */
        .alert {
            border-radius: 10px !important;
            font-size: .84rem !important;
            border: none !important;
        }

        /* ─── Scrollbar ──────────────────────────────────────────── */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #D1D5DB; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #9CA3AF; }

        /* ─── Responsive page heading padding ────────────────────── */
        @media (max-width: 767.98px) {
            .page-heading { padding: 16px 16px 8px !important; }
        }
    </style>

    @yield('custom-css')
</head>

<body>
    @include('sweetalert::alert')
    <script src="{{ asset('dist/assets/static/js/initTheme.js') }}"></script>

    <div id="app">

        {{-- ======= SIDEBAR ======= --}}
        <div id="sidebar">
            <div class="sidebar-wrapper active">

                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">

                        {{-- Logo / Brand --}}
                        <div class="logo">
                            <a href="{{ route('admin.dashboard') }}" class="tg-brand">
                                <span class="tele">Tele</span><span class="grad">grad</span>
                            </a>
                        </div>

                        {{-- Dark Mode Toggle --}}
                        <div class="theme-toggle d-flex gap-2 align-items-center">
                            {{-- Sun icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="16" height="16" viewBox="0 0 21 21">
                                <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2" opacity=".4"/>
                                </g>
                            </svg>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input me-0" type="checkbox" id="toggle-dark"
                                       style="cursor:pointer; width:34px; height:18px;">
                            </div>
                            {{-- Moon icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="16" height="16" viewBox="0 0 24 24">
                                <path fill="currentColor" d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z" opacity=".7"/>
                            </svg>
                        </div>

                        {{-- Mobile close button --}}
                        <div class="sidebar-toggler x">
                            <a href="#" class="sidebar-hide d-xl-none d-block">
                                <i class="bi bi-x bi-middle"></i>
                            </a>
                        </div>

                    </div>
                </div>

                <div class="sidebar-menu">
                    @include('admin.sidebar')
                </div>

            </div>
        </div>
        {{-- End Sidebar --}}

        {{-- ======= MAIN ======= --}}
        <div id="main" class="layout-navbar navbar-fixed">

            {{-- Topbar --}}
            <header>
                <nav class="navbar navbar-expand navbar-light navbar-top">
                    <div class="container-fluid">

                        {{-- Burger / toggle sidebar --}}
                        <a href="#" class="burger-btn d-block">
                            <i class="bi bi-justify fs-3"></i>
                        </a>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mb-lg-0 align-items-center gap-1">

                                {{-- Notifikasi --}}
                                <li class="nav-item dropdown me-1 position-relative">
                                    <a class="nav-link dropdown-toggle text-gray-600 p-2 notif-btn"
                                       href="#" data-bs-toggle="dropdown">
                                        <i class="bi bi-bell fs-5"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" style="min-width:220px;">
                                        <li>
                                            <h6 class="dropdown-header" style="font-size:.72rem; letter-spacing:.05em;">
                                                NOTIFIKASI
                                            </h6>
                                        </li>
                                        <li>
                                            <span class="dropdown-item text-muted" style="cursor:default;">
                                                <i class="bi bi-inbox me-2 opacity-50"></i>Tidak ada notifikasi baru
                                            </span>
                                        </li>
                                    </ul>
                                </li>

                            </ul>

                            {{-- User Dropdown --}}
                            <div class="dropdown ms-2">
                                <a href="#" data-bs-toggle="dropdown" style="text-decoration:none;">
                                    <div class="user-menu d-flex align-items-center gap-2 px-2 py-1">
                                        <div class="user-name text-end d-none d-md-block">
                                            <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                                            <p class="mb-0 text-muted">Administrator</p>
                                        </div>
                                        <div class="avatar avatar-md">
                                            <img src="{{ asset('storage/images/profile/' . (Auth::user()->photo ?? 'default.jpg')) }}"
                                                 alt="{{ Auth::user()->name }}"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            {{-- Fallback avatar jika gambar gagal load --}}
                                            <div style="display:none; width:38px; height:38px; border-radius:50%;
                                                        background:#EFF6FF; border:2px solid #BFDBFE;
                                                        align-items:center; justify-content:center;
                                                        font-weight:700; font-size:.85rem; color:#1E3A8A;">
                                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" style="min-width:12rem;">
                                    <li>
                                        <div class="px-3 py-2 mb-1">
                                            <div style="font-size:.82rem; font-weight:700;">{{ Auth::user()->name }}</div>
                                            <div style="font-size:.72rem; color:#9CA3AF;">Administrator</div>
                                        </div>
                                    </li>
                                    <li><hr class="dropdown-divider my-1"></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                            <i class="bi bi-person me-2 text-primary"></i> Profil Saya
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider my-1"></li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="#" onclick="logoutAdmin(event)">
                                            <i class="bi bi-box-arrow-left me-2"></i> Keluar
                                        </a>
                                        <form id="logout-form-admin" action="{{ route('admin.logout') }}" method="POST" style="display:none;">
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
                    <div class="page-title">
                        <div class="row align-items-center mb-3">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3 class="mb-0">{{ $submenu ?? '' }}</h3>
                                <p class="text-subtitle text-muted mb-0 mt-1">{{ $subdesc ?? '' }}</p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb mb-0" style="background:none; padding:0;">
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('admin.dashboard') }}">
                                                <i class="bi bi-house-door me-1"></i>{{ $menu ?? 'Dashboard' }}
                                            </a>
                                        </li>
                                        <li class="breadcrumb-item active">{{ $submenu ?? '' }}</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>

                    @yield('content')

                </div>
            </div>

            {{-- Footer --}}
            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p class="mb-0">&copy; {{ date('Y') }} {{ $web->site_name ?? 'Telegrad' }}</p>
                    </div>
                    <div class="float-end">
                        <p class="mb-0">
                            Crafted with <span class="text-danger"><i class="bi bi-heart-fill"></i></span>
                            by Telegrad Team
                        </p>
                    </div>
                </div>
            </footer>

        </div>
        {{-- End Main --}}

    </div>

    <!-- Scripts -->
    <script src="{{ asset('dist/assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('dist/assets/compiled/js/app.js') }}"></script>
    <script src="{{ asset('vendor/sweetalerts2/sweetalerts2.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalerts2/custom-sweetalert.js') }}"></script>
    <script src="{{ asset('dist/assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('dist/assets/static/js/pages/simple-datatables.js') }}"></script>

    <script>
        // ── Logout confirmation ─────────────────────────────────────────────
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
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form-admin').submit();
                }
            });
        }

        // ── Delete confirmation ─────────────────────────────────────────────
        function deleteData(id) {
            Swal.fire({
                title: 'Hapus data ini?',
                text: 'Data yang dihapus tidak bisa dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                confirmButtonColor: '#dc3545',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        // ── Staggered sidebar animation on load ─────────────────────────────
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.sidebar-item').forEach((el, i) => {
                el.style.opacity = '0';
                el.style.transform = 'translateX(-8px)';
                el.style.transition = `opacity .25s ease ${i * 0.03}s, transform .25s ease ${i * 0.03}s`;
                requestAnimationFrame(() => {
                    el.style.opacity = '1';
                    el.style.transform = 'translateX(0)';
                });
            });
        });
    </script>

    @yield('custom-js')
</body>
</html>