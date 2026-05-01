<ul class="menu">

    {{-- ── Menu Utama ── --}}
    <li class="sidebar-title">Menu Utama</li>

    <li class="sidebar-item {{ Route::is('admin.dashboard') ? 'active' : '' }}">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link">
            <i class="fa-solid fa-house"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="sidebar-item {{ Route::is('admin.profile') ? 'active' : '' }}">
        <a href="{{ route('admin.profile') }}" class="sidebar-link">
            <i class="fa-solid fa-circle-user"></i>
            <span>Edit Profile</span>
        </a>
    </li>

    {{-- ── Kelola Paket ── --}}
    <li class="sidebar-title">Kelola Paket</li>

    <li class="sidebar-item {{ Route::is('categories.*') ? 'active' : '' }}">
        <a href="{{ route('categories.index') }}" class="sidebar-link">
            <i class="fa-solid fa-folder-open"></i>
            <span>Kategori</span>
        </a>
    </li>

    <li class="sidebar-item {{ Route::is('packages.*') ? 'active' : '' }}">
        <a href="{{ route('packages.index') }}" class="sidebar-link">
            <i class="fa-solid fa-camera-retro"></i>
            <span>Paket Foto</span>
        </a>
    </li>

    {{-- ── Kelola Transaksi ── --}}
    <li class="sidebar-title">Kelola Transaksi</li>

    <li class="sidebar-item {{ Route::is('orders.*') ? 'active' : '' }}">
        <a href="{{ route('orders.index') }}" class="sidebar-link">
            <i class="fa-solid fa-receipt"></i>
            <span>Pesanan</span>
        </a>
    </li>

    <li class="sidebar-item {{ Route::is('payments.*') ? 'active' : '' }}">
        <a href="{{ route('payments.index') }}" class="sidebar-link">
            <i class="fa-solid fa-wallet"></i>
            <span>Pembayaran</span>
        </a>
    </li>

    <li class="sidebar-item {{ Route::is('deliveries.*') ? 'active' : '' }}">
        <a href="{{ route('deliveries.index') }}" class="sidebar-link">
            <i class="fa-solid fa-paper-plane"></i>
            <span>Pengiriman Hasil</span>
        </a>
    </li>

    {{-- ── Kelola Konten ── --}}
    <li class="sidebar-title">Kelola Konten</li>

    <li class="sidebar-item {{ Route::is('portfolios.*') ? 'active' : '' }}">
        <a href="{{ route('portfolios.index') }}" class="sidebar-link">
            <i class="fa-solid fa-images"></i>
            <span>Portofolio</span>
        </a>
    </li>

    <li class="sidebar-item {{ Route::is('ratings.*') ? 'active' : '' }}">
        <a href="{{ route('ratings.index') }}" class="sidebar-link">
            <i class="fa-solid fa-star"></i>
            <span>Rating</span>
        </a>
    </li>

    <li class="sidebar-item {{ Route::is('admin.websetting.*') ? 'active' : '' }}">
        <a href="{{ route('admin.websetting.index') }}" class="sidebar-link">
            <i class="fa-solid fa-sliders"></i>
            <span>Pengaturan Web</span>
        </a>
    </li>

</ul>