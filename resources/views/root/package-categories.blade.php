@extends('base.base-root-index')

@push('css')
<style>
/* ─── Google Fonts ───────────────────────────────────────────── */
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap');

/* ─── Page hero (no background image) ───────────────────────── */
.page-hero {
    position: relative;
    padding: 72px 0 60px;
    text-align: center;
    background: var(--surface, #111);
    border-bottom: 1px solid var(--border, rgba(255,255,255,.08));
    overflow: hidden;
}
/* subtle decorative gradient blob */
.page-hero::before {
    content: '';
    position: absolute;
    top: -80px; left: 50%;
    transform: translateX(-50%);
    width: 600px; height: 300px;
    background: radial-gradient(ellipse, rgba(200,169,110,.12) 0%, transparent 70%);
    pointer-events: none;
}
.page-hero h1 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 700;
    color: var(--text, #f0ece3);
    margin-bottom: 10px;
    line-height: 1.15;
    position: relative;
}
.page-hero .breadcrumb-nav {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    font-family: 'DM Sans', sans-serif;
    font-size: .8rem; font-weight: 500;
    color: var(--muted, #888);
    letter-spacing: .06em; text-transform: uppercase;
    position: relative;
}
.page-hero .breadcrumb-nav a {
    color: var(--muted, #888); text-decoration: none;
    transition: color .2s;
}
.page-hero .breadcrumb-nav a:hover { color: var(--gold, #c8a96e); }
.page-hero .breadcrumb-nav span { color: var(--gold, #c8a96e); }

/* ─── Stats strip ────────────────────────────────────────────── */
.cat-stats-strip {
    background: var(--surface, #111);
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
    padding: 32px 0;
}
.strip-item { text-align: center; padding: 0 20px; }
.strip-item + .strip-item { border-left: 1px solid var(--border); }
.strip-num {
    font-family: 'Playfair Display', serif;
    font-size: 1.9rem; font-weight: 700;
    color: var(--gold, #c8a96e); line-height: 1;
}
.strip-label {
    font-family: 'DM Sans', sans-serif;
    font-size: .7rem; color: var(--muted);
    letter-spacing: .1em; text-transform: uppercase; margin-top: 5px;
}

/* ─── Section ────────────────────────────────────────────────── */
.pkg-cat-section { padding: 72px 0 100px; }

.pkg-cat-header { text-align: center; margin-bottom: 56px; }
.pkg-cat-header h2 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.9rem, 3.5vw, 2.7rem);
    font-weight: 700; color: var(--text);
    margin-bottom: 12px; line-height: 1.2;
}
.pkg-cat-header p {
    font-family: 'DM Sans', sans-serif;
    font-size: .95rem; color: var(--muted);
    max-width: 460px; margin: 0 auto; line-height: 1.8;
}

/* ─── Category card ──────────────────────────────────────────── */
.cat-link { display: block; height: 100%; text-decoration: none; }
.cat-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 18px;
    padding: 36px 30px 32px;
    height: 100%;
    position: relative; overflow: hidden;
    transition: transform .3s cubic-bezier(.4,0,.2,1),
                border-color .3s, background .3s, box-shadow .3s;
    display: flex; flex-direction: column;
}
.cat-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, transparent, var(--gold, #c8a96e), transparent);
    opacity: 0; transition: opacity .3s;
}
.cat-card::after {
    content: '';
    position: absolute; bottom: -60px; right: -60px;
    width: 180px; height: 180px; border-radius: 50%;
    background: radial-gradient(circle, var(--gold-dim, rgba(200,169,110,.1)) 0%, transparent 70%);
    pointer-events: none; opacity: 0; transition: opacity .3s;
}
.cat-card:hover {
    transform: translateY(-8px);
    border-color: var(--gold-border, rgba(200,169,110,.35));
    background: var(--card-hover);
    box-shadow: 0 20px 48px rgba(0,0,0,.35), 0 0 0 1px var(--gold-border, rgba(200,169,110,.15));
}
.cat-card:hover::before { opacity: 1; }
.cat-card:hover::after  { opacity: 1; }

/* ─── Icon box ───────────────────────────────────────────────── */
.cat-icon-wrap {
    width: 64px; height: 64px;
    background: var(--gold-dim, rgba(200,169,110,.1));
    border: 1px solid var(--gold-border, rgba(200,169,110,.25));
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 22px;
    font-size: 1.5rem; color: var(--gold, #c8a96e);
    transition: background .3s, transform .3s;
    flex-shrink: 0;
}
.cat-card:hover .cat-icon-wrap {
    background: rgba(200,169,110,.2);
    transform: scale(1.06) rotate(-3deg);
}

/* ─── Card content ───────────────────────────────────────────── */
.cat-name {
    font-family: 'Playfair Display', serif;
    font-size: 1.25rem; font-weight: 700;
    color: var(--text); margin-bottom: 10px; line-height: 1.3;
}
.cat-desc {
    font-family: 'DM Sans', sans-serif;
    font-size: .86rem; color: var(--muted);
    line-height: 1.75; flex-grow: 1; margin-bottom: 22px;
}
.cat-start-price {
    font-family: 'DM Sans', sans-serif;
    font-size: .76rem; color: var(--muted); margin-bottom: 18px;
}
.cat-start-price i { color: var(--gold); }
.cat-start-price strong { color: var(--gold-light, #d4b97e); }

/* ─── Meta row ───────────────────────────────────────────────── */
.cat-meta {
    display: flex; align-items: center; justify-content: space-between;
    border-top: 1px solid var(--border); padding-top: 18px;
}
.cat-count-badge {
    display: inline-flex; align-items: center; gap: 6px;
    font-family: 'DM Sans', sans-serif;
    font-size: .75rem; font-weight: 600; letter-spacing: .05em;
    color: var(--gold); background: var(--gold-dim, rgba(200,169,110,.1));
    border: 1px solid var(--gold-border, rgba(200,169,110,.25));
    padding: 5px 13px; border-radius: 100px;
}
.cat-arrow {
    width: 34px; height: 34px;
    border: 1px solid var(--gold-border, rgba(200,169,110,.3)); border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: var(--gold); font-size: .8rem;
    transition: background .28s, transform .28s, border-color .28s;
}
.cat-card:hover .cat-arrow {
    background: var(--gold); border-color: var(--gold);
    color: #0d0d0d; transform: translateX(3px);
}

/* ─── Empty state ────────────────────────────────────────────── */
.cat-empty { text-align: center; padding: 80px 20px; color: var(--muted); }
.cat-empty i { font-size: 3rem; color: var(--gold-border); display: block; margin-bottom: 16px; }
</style>
@endpush

@section('content')
<main id="main">

    {{-- Clean page hero (no background image) --}}
    <div class="page-hero" data-aos="fade-down">
        <div class="container">
            <h1>Paket Kami</h1>
            <nav class="breadcrumb-nav mt-3">
                <a href="{{ route('home') }}">Beranda</a>
                <span>/</span>
                <span style="color:var(--muted)">Paket</span>
            </nav>
        </div>
    </div>

    {{-- Stats Strip --}}
    <div class="cat-stats-strip">
        <div class="container">
            <div class="row g-0">
                <div class="col-6 col-md-3">
                    <div class="strip-item">
                        <div class="strip-num">{{ $categories->count() }}</div>
                        <div class="strip-label">Kategori</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="strip-item">
                        <div class="strip-num">{{ $categories->sum('packages_count') }}+</div>
                        <div class="strip-label">Pilihan Paket</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="strip-item">
                        <div class="strip-num">40rb</div>
                        <div class="strip-label">Mulai dari</div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="strip-item">
                        <div class="strip-num">100%</div>
                        <div class="strip-label">File via Drive</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Categories Grid --}}
    <section class="pkg-cat-section">
        <div class="container">

            <div class="pkg-cat-header" data-aos="fade-up">
                <span class="section-label">Pilih Kategori</span>
                <div class="line-accent centered"></div>
                <h2>Kategori Paket Foto</h2>
                <p>Temukan sesi pemotretan yang paling sesuai dengan momen spesialmu.</p>
            </div>

            <div class="row g-4">
                @forelse($categories as $category)
                @php
                    $icons = [
                        'wisuda'       => 'bi-mortarboard',
                        'yudisium'     => 'bi-award',
                        'after-sidang' => 'bi-journal-check',
                    ];
                    $icon = $icons[$category->slug] ?? 'bi-camera';
                    $startPrice = [
                        'wisuda'       => 'Rp 250.000',
                        'yudisium'     => 'Rp 250.000',
                        'after-sidang' => 'Rp 150.000',
                    ];
                    $minPrice = $startPrice[$category->slug] ?? null;
                @endphp
                <div class="col-lg-4 col-md-6"
                     data-aos="fade-up"
                     data-aos-delay="{{ $loop->index * 100 }}">
                    <a href="{{ route('packages.byCategory', $category->slug) }}" class="cat-link">
                        <div class="cat-card">
                            <div class="cat-icon-wrap">
                                <i class="bi {{ $icon }}"></i>
                            </div>
                            <div class="cat-name">{{ $category->name }}</div>
                            <div class="cat-desc">
                                {{ $category->description ?? 'Sesi foto profesional untuk momen terbaik kamu.' }}
                            </div>
                            @if($minPrice)
                            <div class="cat-start-price">
                                <i class="bi bi-tag me-1"></i>
                                Mulai dari <strong>{{ $minPrice }}</strong>
                            </div>
                            @endif
                            <div class="cat-meta">
                                <span class="cat-count-badge">
                                    <i class="bi bi-images"></i>
                                    {{ $category->packages_count ?? 0 }} Paket
                                </span>
                                <span class="cat-arrow">
                                    <i class="bi bi-arrow-right"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
                @empty
                <div class="col-12 cat-empty">
                    <i class="bi bi-camera-slash"></i>
                    <p>Belum ada kategori paket tersedia.</p>
                </div>
                @endforelse
            </div>

        </div>
    </section>

</main>
@endsection