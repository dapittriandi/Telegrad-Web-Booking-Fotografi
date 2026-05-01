@extends('base.base-root-index')

@push('css')
<style>
/* ======= HERO ======= */
#hero {
    min-height: 100vh;
    position: relative;
    display: flex;
    align-items: center;
    overflow: hidden;
}
.hero-carousel {
    position: absolute;
    inset: 0;
    z-index: 0;
}
.hero-carousel .carousel-item {
    height: 100vh;
    background-size: cover;
    background-position: center;
}
.hero-carousel .carousel-item::before {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(11,12,14,0.62);
}
.hero-fallback-bg {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, #0b0c0e 0%, #16181c 50%, #1a1408 100%);
}
.hero-fallback-bg::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse at 60% 50%, rgba(200,169,110,0.06) 0%, transparent 60%);
}
.hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    padding-top: 72px;
}
.hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    font-size: 0.72rem;
    font-weight: 500;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 1.5rem;
}
.hero-eyebrow::before, .hero-eyebrow::after {
    content: '';
    display: inline-block;
    width: 28px; height: 1px;
    background: var(--gold);
    opacity: 0.6;
}
.hero-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.5rem, 7vw, 5.5rem);
    font-weight: 700;
    line-height: 1.08;
    color: #f0ede8;
    margin-bottom: 1.5rem;
    letter-spacing: -1px;
}
.hero-title em { font-style: italic; color: var(--gold); }
.hero-desc {
    color: rgba(240,237,232,0.65);
    font-size: clamp(0.95rem, 1.5vw, 1.1rem);
    max-width: 500px;
    margin: 0 auto 2.5rem;
    font-weight: 300;
    line-height: 1.8;
}
.hero-actions {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}
.hero-scroll {
    position: absolute;
    bottom: 2.5rem;
    left: 50%;
    transform: translateX(-50%);
    z-index: 2;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.4rem;
    color: rgba(240,237,232,0.4);
    font-size: 0.7rem;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    animation: heroScroll 2s ease infinite;
}
.hero-scroll i { font-size: 1rem; }
@keyframes heroScroll {
    0%, 100% { opacity: 0.4; transform: translateX(-50%) translateY(0); }
    50%       { opacity: 1;   transform: translateX(-50%) translateY(5px); }
}

/* ======= WHY US ======= */
.why-card {
    padding: 2.5rem 2rem;
    border-radius: 16px;
    border: 1px solid var(--border);
    background: var(--card);
    text-align: center;
    transition: transform 0.28s, border-color 0.28s;
    height: 100%;
}
.why-card:hover {
    transform: translateY(-4px);
    border-color: var(--gold-border);
}
.why-icon {
    width: 60px; height: 60px;
    background: var(--gold-dim);
    border: 1px solid var(--gold-border);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 1.4rem;
    color: var(--gold);
    transition: background 0.28s;
}
.why-card:hover .why-icon { background: rgba(200,169,110,0.2); }
.why-card h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 0.6rem;
}
.why-card p { font-size: 0.875rem; color: var(--muted); line-height: 1.7; margin: 0; }

/* ======= PACKAGE FILTER ======= */
/*
 * FIX: Gunakan flex-based grid agar item yang di-hide tidak meninggalkan ruang kosong.
 * Tidak bergantung pada Bootstrap col- karena display:none pada col Bootstrap
 * masih memakan grid flow. Kita pakai wrapper flex sendiri.
 */
#pkg-home-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem; /* setara g-4 */
    margin-left: 0;
    margin-right: 0;
}
.pkg-home-item {
    /* 3 kolom pada lg, 2 kolom pada md, 1 kolom pada sm */
    flex: 0 0 calc(33.333% - 1rem);
    max-width: calc(33.333% - 1rem);
    /* Animasi saat show/hide */
    transition: opacity 0.3s ease, transform 0.3s ease;
}
.pkg-home-item.pkg-hidden {
    display: none !important;
}
@media (max-width: 991px) {
    .pkg-home-item {
        flex: 0 0 calc(50% - 0.75rem);
        max-width: calc(50% - 0.75rem);
    }
}
@media (max-width: 575px) {
    .pkg-home-item {
        flex: 0 0 100%;
        max-width: 100%;
    }
    #pkg-home-grid {
        gap: 1rem;
    }
}

/* Pesan kosong saat filter tidak menemukan hasil */
#pkg-empty-msg {
    display: none;
    width: 100%;
    text-align: center;
    padding: 3rem 0;
    color: var(--muted);
    font-size: 0.95rem;
}
#pkg-empty-msg i {
    font-size: 2.5rem;
    color: var(--gold);
    opacity: 0.4;
    display: block;
    margin-bottom: 0.75rem;
}

/* ======= PACKAGE CARD ======= */
.pkg-card-home {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
    position: relative;
    transition: transform 0.28s, border-color 0.28s, box-shadow 0.28s, background 0.28s;
}
.pkg-card-home::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, transparent, var(--gold), transparent);
    opacity: 0;
    transition: opacity 0.28s;
}
.pkg-card-home:hover {
    transform: translateY(-5px);
    border-color: var(--gold-border);
    background: var(--card-hover);
    box-shadow: var(--shadow-md);
}
.pkg-card-home:hover::before { opacity: 1; }
.pkg-card-head {
    padding: 1.5rem 1.5rem 0;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1rem;
}
.pkg-cat-icon {
    width: 48px; height: 48px;
    background: var(--gold-dim);
    border: 1px solid var(--gold-border);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem;
    color: var(--gold);
    flex-shrink: 0;
}
.pkg-card-body {
    padding: 1rem 1.5rem 1.5rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}
.pkg-card-home h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1rem;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 0.4rem;
    line-height: 1.3;
}
.pkg-card-home .pkg-price {
    font-family: 'Playfair Display', serif;
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--gold);
    margin-bottom: 0.75rem;
}
.pkg-card-home .pkg-meta-row {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-bottom: 1rem;
}
.pkg-pill-sm {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 0.72rem; color: var(--muted);
    background: var(--gold-dim);
    border: 1px solid var(--gold-border);
    padding: 3px 9px;
    border-radius: 100px;
}
.pkg-pill-sm i { color: var(--gold); font-size: 0.7rem; }
.pkg-card-home .package-link {
    display: inline-flex; align-items: center; gap: 0.35rem;
    font-size: 0.8rem; font-weight: 500;
    color: var(--muted); text-decoration: none;
    margin-top: auto;
    padding-top: 0.75rem;
    border-top: 1px solid var(--border);
    transition: color 0.25s;
}
.pkg-card-home .package-link:hover { color: var(--gold); }

/* ======= TESTIMONIAL ENHANCED ======= */
.testimonial-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 1.75rem;
    position: relative;
    height: 100%;
    display: flex;
    flex-direction: column;
    transition: border-color 0.28s, transform 0.28s, box-shadow 0.28s;
    overflow: hidden;
}
.testimonial-card::after {
    content: '\201C';
    font-family: 'Playfair Display', serif;
    font-size: 5rem; line-height: 1;
    color: var(--gold); opacity: 0.07;
    position: absolute; top: 0.5rem; right: 1.25rem;
    pointer-events: none;
}
.testimonial-card:hover {
    border-color: var(--gold-border);
    transform: translateY(-3px);
    box-shadow: var(--shadow-sm);
}

/* Top row: stars + tanggal */
.testi-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 0.9rem;
    gap: 0.5rem;
}
.testi-stars {
    display: flex;
    gap: 2px;
    color: var(--gold);
    font-size: 0.8rem;
}
.testi-date {
    font-size: 0.72rem;
    color: var(--muted);
    white-space: nowrap;
}

/* Review text */
.testi-text {
    color: var(--muted);
    font-size: 0.875rem;
    line-height: 1.8;
    flex-grow: 1;
    margin-bottom: 1.25rem;
    font-style: italic;
}

/* Divider */
.testi-divider {
    height: 1px;
    background: var(--border);
    margin-bottom: 1rem;
}

/* Author row */
.testi-author-row {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
.testi-avatar {
    width: 38px; height: 38px;
    border-radius: 50%;
    object-fit: cover;
    border: 1.5px solid var(--gold-border);
    flex-shrink: 0;
}
.testi-avatar-placeholder {
    width: 38px; height: 38px;
    border-radius: 50%;
    background: var(--gold-dim);
    border: 1.5px solid var(--gold-border);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--gold);
    flex-shrink: 0;
    text-transform: uppercase;
}
.testi-author-info {
    flex-grow: 1;
    min-width: 0;
}
.testi-author-name {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.testi-author-pkg {
    font-size: 0.72rem;
    color: var(--muted);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.testi-verified {
    flex-shrink: 0;
    width: 22px; height: 22px;
    border-radius: 50%;
    background: rgba(76,175,130,0.12);
    border: 1px solid rgba(76,175,130,0.25);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.65rem;
    color: var(--success);
    title: "Pesanan Terverifikasi";
}

/* Rating summary bar */
.rating-summary {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 2rem 2.5rem;
    display: flex;
    align-items: center;
    gap: 2.5rem;
    margin-bottom: 3rem;
    flex-wrap: wrap;
}
.rating-big {
    text-align: center;
    flex-shrink: 0;
}
.rating-big .num {
    font-family: 'Playfair Display', serif;
    font-size: 3.5rem;
    font-weight: 700;
    color: var(--gold);
    line-height: 1;
}
.rating-big .stars {
    color: var(--gold);
    font-size: 0.85rem;
    margin: 0.35rem 0 0.2rem;
    display: flex;
    justify-content: center;
    gap: 2px;
}
.rating-big .total {
    font-size: 0.72rem;
    color: var(--muted);
}
.rating-bars {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    gap: 0.45rem;
}
.rating-bar-row {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    font-size: 0.75rem;
}
.rating-bar-label {
    color: var(--muted);
    width: 30px;
    text-align: right;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    gap: 2px;
}
.rating-bar-label i { font-size: 0.65rem; color: var(--gold); }
.rating-bar-track {
    flex-grow: 1;
    height: 5px;
    background: var(--border);
    border-radius: 100px;
    overflow: hidden;
}
.rating-bar-fill {
    height: 100%;
    background: var(--gold);
    border-radius: 100px;
    transition: width 1s ease;
}
.rating-bar-count {
    color: var(--muted);
    width: 20px;
    text-align: left;
    flex-shrink: 0;
}
@media (max-width: 576px) {
    .rating-summary { gap: 1.5rem; padding: 1.5rem; }
    .rating-big .num { font-size: 2.8rem; }
}
</style>
@endpush

@section('content')

{{-- ======= HERO ======= --}}
<section id="hero">
    {{-- Carousel Background --}}
    @if(!empty($web->slider_1))
    <div id="heroCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner">
            <div class="carousel-item active"
                 style="background-image: url({{ asset('storage/images/default/' . $web->slider_1) }})"></div>
            @if(!empty($web->slider_2))
            <div class="carousel-item"
                 style="background-image: url({{ asset('storage/images/default/' . $web->slider_2) }})"></div>
            @endif
            @if(!empty($web->slider_3))
            <div class="carousel-item"
                 style="background-image: url({{ asset('storage/images/default/' . $web->slider_3) }})"></div>
            @endif
        </div>
    </div>
    @else
    <div class="hero-fallback-bg"></div>
    @endif

    <div class="container hero-content">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div data-aos="fade-down" data-aos-delay="100">
                    <span class="hero-eyebrow">Fotografi Profesional</span>
                </div>
                <h1 class="hero-title" data-aos="fade-up" data-aos-delay="200">
                    Abadikan Setiap<br><em>Momen Berharga</em>
                </h1>
                <p class="hero-desc" data-aos="fade-up" data-aos-delay="300">
                    {{ $web->site_head ?? 'Abadikan Momen Wisudamu' }}
                    @if(!empty($web->site_description)) — {{ $web->site_description }} @endif
                </p>
                <div class="hero-actions" data-aos="fade-up" data-aos-delay="400">
                    <a href="#packages" class="btn-gold">
                        <i class="bi bi-camera2"></i> Lihat Paket
                    </a>
                    <a href="{{ route('portfolio.index') }}" class="btn-outline-gold">
                        Portofolio Kami
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="hero-scroll">
        <i class="bi bi-chevron-down"></i>
        <span>Scroll</span>
    </div>
</section>

<main id="main">

{{-- ======= WHY US ======= --}}
<section class="section-bg">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-label">Keunggulan Kami</span>
            <div class="line-accent centered"></div>
            <h2 class="section-title">Mengapa Memilih Telegrad?</h2>
            <p class="section-subtitle">Layanan fotografi profesional yang mengabadikan setiap cerita dengan sempurna.</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="why-card">
                    <div class="why-icon"><i class="bi bi-camera2"></i></div>
                    <h3>Peralatan Modern</h3>
                    <p>Teknologi kamera terkini menghasilkan gambar dengan kualitas dan detail terbaik.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="why-card">
                    <div class="why-icon"><i class="bi bi-person-check"></i></div>
                    <h3>Fotografer Berpengalaman</h3>
                    <p>Tim profesional kami berpengalaman dalam menangkap momen terbaik setiap sesi.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="why-card">
                    <div class="why-icon"><i class="bi bi-gem"></i></div>
                    <h3>Harga Transparan</h3>
                    <p>Paket harga jelas tanpa biaya tersembunyi — kualitas premium yang terjangkau.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ======= PACKAGES ======= --}}
<section id="packages">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-label">Layanan</span>
            <div class="line-accent centered"></div>
            <h2 class="section-title">Paket Fotografi Kami</h2>
            <p class="section-subtitle">Pilih paket yang paling sesuai dengan kebutuhan dan momen spesial kamu.</p>
        </div>

        {{-- Filter buttons --}}
        <ul class="portfolio-flters" id="pkg-filters" data-aos="fade-up" data-aos-delay="100">
            <li data-filter="*" class="filter-active">Semua</li>
            @foreach($categories as $category)
                <li data-filter="filter-{{ $category->slug }}">{{ $category->name }}</li>
            @endforeach
        </ul>

        {{--
            FIX: Menggunakan flex layout sendiri (bukan Bootstrap col-)
            agar item yang di-hide tidak meninggalkan space kosong di grid.
            Class filter pada setiap item menggunakan prefix "filter-" diikuti slug kategori.
        --}}
        <div id="pkg-home-grid" data-aos="fade-up" data-aos-delay="200">
            @forelse($packages as $package)
                @php
                    $cat  = $package->category ?? null;
                    $icons = [
                        'wisuda'       => 'bi-mortarboard',
                        'yudisium'     => 'bi-award',
                        'after-sidang' => 'bi-journal-check',
                    ];
                    $icon = $cat ? ($icons[$cat->slug] ?? 'bi-camera') : 'bi-camera';
                @endphp
                @if($cat)
                {{--
                    PENTING: class "pkg-home-item" + "filter-{slug}" harus ada di elemen
                    langsung dalam #pkg-home-grid agar JS filter bisa mendeteksinya.
                --}}
                <div class="pkg-home-item filter-{{ $cat->slug }}">
                    <div class="pkg-card-home">
                        <div class="pkg-card-head">
                            <div class="pkg-cat-icon">
                                <i class="bi {{ $icon }}"></i>
                            </div>
                            <span class="badge-gold">{{ $cat->name }}</span>
                        </div>
                        <div class="pkg-card-body">
                            <h3>{{ $package->name }}</h3>
                            <div class="pkg-price">Rp {{ number_format($package->price, 0, ',', '.') }}</div>
                            <div class="pkg-meta-row">
                                <span class="pkg-pill-sm">
                                    <i class="bi bi-clock"></i> {{ $package->duration ?? '-' }} menit
                                </span>
                                @if($package->unlimited_participants)
                                    <span class="pkg-pill-sm">
                                        <i class="bi bi-people"></i> Bebas
                                    </span>
                                @elseif($package->max_participants)
                                    <span class="pkg-pill-sm">
                                        <i class="bi bi-people"></i>
                                        {{ $package->min_participants == $package->max_participants
                                            ? $package->min_participants . ' org'
                                            : $package->min_participants . '–' . $package->max_participants . ' org' }}
                                    </span>
                                @endif
                            </div>
                            <a href="{{ route('packages.detail', $package->id) }}" class="package-link">
                                Lihat Detail <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            @empty
                <div id="pkg-empty-msg" style="display:block;">
                    <i class="bi bi-camera-slash"></i>
                    Belum ada paket tersedia.
                </div>
            @endforelse

            {{-- Pesan kosong saat filter aktif tapi tidak ada hasil --}}
            <div id="pkg-empty-msg">
                <i class="bi bi-funnel"></i>
                Tidak ada paket untuk kategori ini.
            </div>
        </div>
    </div>
</section>

{{-- ======= PORTFOLIO PREVIEW ======= --}}
@if(isset($portofolios) && $portofolios->count() > 0)
<section class="section-bg">
    <div class="container">
        <div class="d-flex align-items-end justify-content-between mb-5 flex-wrap gap-3" data-aos="fade-up">
            <div>
                <span class="section-label">Karya Kami</span>
                <div class="line-accent"></div>
                <h2 class="section-title mb-0">Portofolio Terbaru</h2>
            </div>
            <a href="{{ route('portfolio.index') }}" class="btn-outline-gold">
                Lihat Semua <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        <div class="row g-3">
            @foreach($portofolios as $i => $item)
            <div class="col-lg-{{ $i === 0 ? '8' : '4' }} col-md-6"
                 data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                <div class="portfolio-grid-item"
                     style="aspect-ratio: {{ $i === 0 ? '16/9' : '4/3' }}">
                    <img src="{{ asset('storage/images/portofolio/' . $item->image) }}"
                         alt="{{ $item->title }}"
                         style="width:100%;height:100%;object-fit:cover;">
                    <div class="portfolio-grid-overlay">
                        <h4>{{ $item->title }}</h4>
                        <span>{{ $item->category->name ?? '' }}</span>
                        <div class="portfolio-grid-actions">
                            <a href="{{ asset('storage/images/portofolio/' . $item->image) }}"
                               class="glightbox" data-gallery="portfolio-home"
                               title="{{ $item->title }}">
                                <i class="bi bi-zoom-in"></i>
                            </a>
                            <a href="{{ route('portfolio.detail', $item->id) }}"
                               title="Lihat detail">
                                <i class="bi bi-link-45deg"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ======= TESTIMONIALS ======= --}}
@if(isset($ratings) && $ratings->count() > 0)
<section>
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-label">Testimoni</span>
            <div class="line-accent centered"></div>
            <h2 class="section-title">Apa Kata Pelanggan Kami</h2>
            <p class="section-subtitle">Kepuasan pelanggan adalah prioritas utama kami di setiap sesi foto.</p>
        </div>

        {{--
            Rating Summary Bar
            Menampilkan rata-rata rating dan distribusi bintang secara visual.
            Data dihitung dari koleksi $ratings.
        --}}
        @php
            $totalRatings   = $ratings->count();
            $avgRating      = $totalRatings > 0 ? round($ratings->avg('rating'), 1) : 0;
            $starCounts     = [];
            for ($s = 5; $s >= 1; $s--) {
                $starCounts[$s] = $ratings->where('rating', $s)->count();
            }
        @endphp

        <div class="rating-summary" data-aos="fade-up" data-aos-delay="50">
            <div class="rating-big">
                <div class="num">{{ number_format($avgRating, 1) }}</div>
                <div class="stars">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= floor($avgRating))
                            <i class="bi bi-star-fill"></i>
                        @elseif($i - $avgRating < 1)
                            <i class="bi bi-star-half"></i>
                        @else
                            <i class="bi bi-star"></i>
                        @endif
                    @endfor
                </div>
                <div class="total">{{ $totalRatings }} ulasan</div>
            </div>
            <div class="rating-bars">
                @for($s = 5; $s >= 1; $s--)
                    @php $pct = $totalRatings > 0 ? ($starCounts[$s] / $totalRatings * 100) : 0; @endphp
                    <div class="rating-bar-row">
                        <div class="rating-bar-label">
                            {{ $s }}<i class="bi bi-star-fill"></i>
                        </div>
                        <div class="rating-bar-track">
                            <div class="rating-bar-fill" style="width: {{ $pct }}%"></div>
                        </div>
                        <div class="rating-bar-count">{{ $starCounts[$s] }}</div>
                    </div>
                @endfor
            </div>
        </div>

        {{-- Kartu testimoni individual --}}
        <div class="row g-4">
            @foreach($ratings as $rating)
            @php
                $reviewer   = $rating->user ?? null;
                $reviewName = $reviewer?->name ?? 'Pelanggan';
                $initial    = strtoupper(substr($reviewName, 0, 1));
                $avatarUrl  = $reviewer?->photo
                    ? asset('storage/images/profile/' . $reviewer->photo)
                    : null;
                // Nama paket — coba dari relasi order → package, fallback ke kolom langsung
                $pkgName    = $rating->order?->package?->name
                           ?? $rating->package?->name
                           ?? null;
                // Tanggal ulasan
                $reviewDate = $rating->created_at
                    ? $rating->created_at->locale('id')->translatedFormat('d M Y')
                    : null;
            @endphp
            <div class="col-lg-4 col-md-6"
                 data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="testimonial-card">

                    {{-- Baris atas: bintang + tanggal --}}
                    <div class="testi-top">
                        <div class="testi-stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= ($rating->rating ?? 5))
                                    <i class="bi bi-star-fill"></i>
                                @else
                                    <i class="bi bi-star" style="opacity:.3;"></i>
                                @endif
                            @endfor
                        </div>
                        @if($reviewDate)
                        <span class="testi-date">
                            <i class="bi bi-calendar3" style="margin-right:3px;"></i>{{ $reviewDate }}
                        </span>
                        @endif
                    </div>

                    {{-- Teks ulasan --}}
                    <p class="testi-text">"{{ $rating->review ?? '' }}"</p>

                    {{-- Divider --}}
                    <div class="testi-divider"></div>

                    {{-- Author row --}}
                    <div class="testi-author-row">
                        {{-- Avatar: foto asli atau inisial --}}
                        @if($avatarUrl)
                            <img src="{{ $avatarUrl }}" alt="{{ $reviewName }}" class="testi-avatar">
                        @else
                            <div class="testi-avatar-placeholder">{{ $initial }}</div>
                        @endif

                        <div class="testi-author-info">
                            <div class="testi-author-name">{{ $reviewName }}</div>
                            @if($pkgName)
                            <div class="testi-author-pkg">
                                <i class="bi bi-camera" style="color:var(--gold);margin-right:3px;font-size:0.65rem;"></i>{{ $pkgName }}
                            </div>
                            @endif
                        </div>

                        {{-- Badge verifikasi --}}
                        <div class="testi-verified" title="Ulasan dari pesanan terverifikasi">
                            <i class="bi bi-check2"></i>
                        </div>
                    </div>

                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ======= CTA ======= --}}
<section class="section-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 text-center" data-aos="fade-up">
                <span class="section-label">Mulai Sekarang</span>
                <div class="line-accent centered"></div>
                <h2 class="section-title">Siap Mengabadikan Momenmu?</h2>
                <p class="section-subtitle mb-4">
                    Hubungi kami sekarang dan wujudkan sesi foto impianmu bersama tim profesional Telegrad.
                </p>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="{{ route('packages.categories') }}" class="btn-gold">
                        <i class="bi bi-camera2"></i> Lihat Paket
                    </a>
                    <a href="{{ route('contact') }}" class="btn-outline-gold">
                        <i class="bi bi-chat-dots"></i> Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

</main>
@endsection

@push('js')
<script>
// ── Package Filter (Fixed Version) ───────────────────────────────────────────
//
// BUG SEBELUMNYA:
//   Filter menggunakan `item.style.display = 'none'` pada elemen <div> yang
//   memiliki class Bootstrap col-lg-4 / col-md-6. Ketika kolom disembunyikan,
//   Bootstrap grid tetap meninggalkan ruang kosong, sehingga layout "bolong".
//
// SOLUSI:
//   1. Grid sekarang menggunakan flex layout sendiri (bukan Bootstrap col-).
//   2. Filter menambahkan class `.pkg-hidden` (display:none) langsung pada
//      elemen `.pkg-home-item`, sehingga item benar-benar hilang dari flow.
//   3. Jika tidak ada item yang cocok, tampilkan pesan kosong (#pkg-empty-msg).
//
// FORMAT DATA FILTER:
//   - Tombol filter: data-filter="*" atau data-filter="filter-{slug}"
//   - Item: class="pkg-home-item filter-{slug}"
//   Contoh: tombol "Yudisium" → data-filter="filter-yudisium"
//           card yudisium    → class="pkg-home-item filter-yudisium"
// ─────────────────────────────────────────────────────────────────────────────
(function () {
    const filters   = document.querySelectorAll('#pkg-filters li');
    const items     = document.querySelectorAll('.pkg-home-item');
    const emptyMsg  = document.getElementById('pkg-empty-msg');

    function applyFilter(filterValue) {
        let visibleCount = 0;

        items.forEach(item => {
            const show = filterValue === '*' || item.classList.contains(filterValue);
            if (show) {
                item.classList.remove('pkg-hidden');
                visibleCount++;
            } else {
                item.classList.add('pkg-hidden');
            }
        });

        // Tampilkan/sembunyikan pesan kosong
        if (emptyMsg) {
            emptyMsg.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    }

    filters.forEach(btn => {
        btn.addEventListener('click', function () {
            // Update active state
            filters.forEach(b => b.classList.remove('filter-active'));
            this.classList.add('filter-active');

            applyFilter(this.dataset.filter);
        });
    });

    // Jalankan filter awal (tampilkan semua)
    applyFilter('*');
})();
</script>
@endpush