@extends('base.base-root-index')

@push('css')
<style>
/* ─── Page Hero ──────────────────────────────────────────────── */
.page-hero {
    background: var(--bg);
    padding: 80px 0 56px;
    position: relative; overflow: hidden;
    border-bottom: 1px solid var(--border);
}
.page-hero::before {
    content: '';
    position: absolute; top: -120px; left: 50%;
    transform: translateX(-50%);
    width: 600px; height: 300px;
    background: radial-gradient(ellipse, var(--gold-dim) 0%, transparent 70%);
    pointer-events: none;
}
.page-hero-inner { position: relative; text-align: center; }
.page-hero-eyebrow {
    display: inline-block;
    font-size: .65rem; font-weight: 700;
    letter-spacing: .2em; text-transform: uppercase;
    color: var(--gold); border: 1px solid var(--gold-border);
    padding: 4px 14px; border-radius: 100px; margin-bottom: 16px;
}
.page-hero h1 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.6rem, 3.5vw, 2.6rem);
    color: var(--text); font-weight: 700;
    line-height: 1.2; margin-bottom: 20px;
    max-width: 680px; margin-left: auto; margin-right: auto;
}
.page-hero-breadcrumb {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    font-size: .76rem; color: var(--muted);
}
.page-hero-breadcrumb a { color: var(--muted); text-decoration: none; transition: color .25s; }
.page-hero-breadcrumb a:hover { color: var(--gold); }
.page-hero-breadcrumb .sep { color: var(--dim); font-size: .6rem; }
.page-hero-breadcrumb .current { color: var(--gold); }

/* ─── Section ────────────────────────────────────────────────── */
.detail-section { background: var(--bg); padding: 60px 0 100px; }
.back-link {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: .82rem; color: var(--muted); text-decoration: none; margin-bottom: 36px;
    transition: color .26s;
}
.back-link:hover { color: var(--gold); }

/* ─── Main image ─────────────────────────────────────────────── */
.main-img-wrap {
    position: relative; border-radius: 14px; overflow: hidden;
    border: 1px solid var(--border); background: var(--card);
}
.main-img-wrap img {
    width: 100%; display: block; max-height: 560px; object-fit: cover;
    transition: transform .6s cubic-bezier(.4,0,.2,1);
}
.main-img-wrap:hover img { transform: scale(1.02); }
.zoom-btn {
    position: absolute; top: 14px; right: 14px;
    width: 40px; height: 40px;
    background: rgba(11,12,14,.75); backdrop-filter: blur(6px);
    border: 1px solid var(--gold-border); border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: var(--gold); font-size: .9rem; text-decoration: none; z-index: 2;
    transition: background .26s, color .26s;
}
.zoom-btn:hover { background: var(--gold); color: #0d0d0d; }
.img-cat-pill {
    position: absolute; top: 14px; left: 14px;
    font-size: .66rem; font-weight: 700;
    letter-spacing: .12em; text-transform: uppercase; color: var(--gold);
    background: rgba(11,12,14,.75); backdrop-filter: blur(6px);
    border: 1px solid var(--gold-border); padding: 5px 12px; border-radius: 100px; z-index: 2;
}

/* ─── Content ────────────────────────────────────────────────── */
.porto-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.5rem, 3vw, 2.2rem);
    color: var(--text); font-weight: 700;
    margin: 28px 0 16px; line-height: 1.25;
}
.gold-divider {
    height: 1px;
    background: linear-gradient(90deg, var(--gold-border), transparent);
    margin: 20px 0;
}
.porto-desc { font-size: .9rem; color: var(--muted); line-height: 1.9; }
.cta-strip { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 28px; }
.cta-primary {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 12px 24px; font-size: .82rem; font-weight: 700;
    letter-spacing: .07em; text-transform: uppercase;
    color: #1a1410; background: var(--gold);
    border-radius: 10px; text-decoration: none;
    transition: background .26s, transform .26s;
}
.cta-primary:hover { background: var(--gold-light); color: #1a1410; transform: translateY(-2px); }
.cta-secondary {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 11px 22px; font-size: .82rem; font-weight: 600;
    color: var(--gold); border: 1px solid var(--gold-border);
    border-radius: 10px; text-decoration: none;
    transition: background .26s, border-color .26s;
}
.cta-secondary:hover { background: var(--gold-dim); border-color: var(--gold); color: var(--gold-light); }

/* ─── Sidebar ────────────────────────────────────────────────── */
.sidebar-card {
    background: var(--card); border: 1px solid var(--gold-border);
    border-radius: 14px; overflow: hidden; position: sticky; top: 90px;
}
.sidebar-head {
    background: linear-gradient(135deg, var(--surface), var(--card));
    border-bottom: 1px solid var(--gold-border);
    padding: 20px 24px; display: flex; align-items: center; gap: 10px;
}
.sidebar-head i {
    width: 36px; height: 36px;
    background: var(--gold-dim); border: 1px solid var(--gold-border);
    border-radius: 10px; display: flex; align-items: center; justify-content: center;
    color: var(--gold); font-size: .9rem; flex-shrink: 0;
}
.sidebar-head h5 {
    font-family: 'Playfair Display', serif;
    font-size: 1rem; font-weight: 700; color: var(--text); margin: 0;
}
.sidebar-body { padding: 20px 24px; }
.info-row {
    display: flex; flex-direction: column; gap: 3px;
    padding: 12px 0; border-bottom: 1px solid var(--border);
}
.info-row:last-of-type { border-bottom: none; }
.info-row-label {
    font-size: .66rem; font-weight: 700;
    letter-spacing: .14em; text-transform: uppercase; color: var(--muted);
}
.info-row-val {
    font-size: .875rem; color: var(--text);
    display: flex; align-items: center; gap: 6px;
}
.info-row-val i { color: var(--gold); }
.info-row-val a { color: var(--gold); text-decoration: none; }
.info-row-val a:hover { color: var(--gold-light); }
.sidebar-cta {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    width: 100%; padding: 12px 0; font-size: .82rem; font-weight: 700;
    letter-spacing: .07em; text-transform: uppercase;
    color: #1a1410; background: var(--gold); border: none; border-radius: 10px;
    text-decoration: none; margin-top: 16px;
    transition: background .26s, transform .26s;
}
.sidebar-cta:hover { background: var(--gold-light); color: #1a1410; transform: translateY(-2px); }

/* ─── Related ────────────────────────────────────────────────── */
.related-section { margin-top: 80px; }
.related-title { font-family: 'Playfair Display', serif; font-size: 1.5rem; color: var(--text); margin-bottom: 4px; }
.related-divider {
    height: 1px; background: linear-gradient(90deg, var(--gold-border), transparent);
    margin: 12px 0 32px;
}
.rel-card {
    position: relative; border-radius: 14px; overflow: hidden;
    border: 1px solid var(--border); aspect-ratio: 4/3; background: var(--card);
    display: block; text-decoration: none;
}
.rel-card img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .55s; }
.rel-card:hover img { transform: scale(1.06); }
.rel-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,.8) 0%, transparent 60%);
    opacity: 0; transition: opacity .26s;
    display: flex; flex-direction: column; justify-content: flex-end; padding: 16px;
}
.rel-card:hover .rel-overlay { opacity: 1; }
.rel-cat { font-size: .65rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: var(--gold); margin-bottom: 4px; }
.rel-name { font-family: 'Playfair Display', serif; font-size: .9rem; font-weight: 700; color: #f0ede8; line-height: 1.3; }
.rel-badge {
    position: absolute; top: 10px; left: 10px;
    font-size: .62rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase;
    color: var(--gold); background: rgba(11,12,14,.75); backdrop-filter: blur(4px);
    border: 1px solid var(--gold-border); padding: 3px 9px; border-radius: 100px; z-index: 2;
}
</style>
@endpush

@section('content')
<main id="main">

    <div class="page-hero">
        <div class="container">
            <div class="page-hero-inner" data-aos="fade-up">
                <span class="page-hero-eyebrow">
                    @if($portofolio->category)
                        <i class="bi bi-tag me-1"></i>{{ $portofolio->category->name }}
                    @else
                        <i class="bi bi-images me-1"></i> Portofolio
                    @endif
                </span>
                <h1>{{ $portofolio->title }}</h1>
                <div class="page-hero-breadcrumb">
                    <a href="{{ route('home') }}">Beranda</a>
                    <span class="sep">&#9656;</span>
                    <a href="{{ route('portfolio.index') }}">Portofolio</a>
                    <span class="sep">&#9656;</span>
                    <span class="current">{{ Str::limit($portofolio->title, 40) }}</span>
                </div>
            </div>
        </div>
    </div>

    <section class="detail-section">
        <div class="container">

            <a href="{{ route('portfolio.index') }}" class="back-link" data-aos="fade-right">
                <i class="bi bi-arrow-left"></i> Kembali ke Portofolio
            </a>

            <div class="row g-5 align-items-start">

                <div class="col-lg-8" data-aos="fade-right">
                    <div class="main-img-wrap">
                        <img src="{{ asset('storage/images/portofolio/' . $portofolio->image) }}"
                             alt="{{ $portofolio->title }}" loading="lazy">
                        @if($portofolio->category)
                            <span class="img-cat-pill">{{ $portofolio->category->name }}</span>
                        @endif
                        <a href="{{ asset('storage/images/portofolio/' . $portofolio->image) }}"
                           class="zoom-btn glightbox" title="{{ $portofolio->title }}">
                            <i class="bi bi-zoom-in"></i>
                        </a>
                    </div>

                    <h1 class="porto-title">{{ $portofolio->title }}</h1>
                    <div class="gold-divider"></div>
                    <div class="porto-desc">
                        {!! $portofolio->description ?? '<p>Momen spesial yang berhasil kami abadikan dengan penuh cerita dan kenangan.</p>' !!}
                    </div>
                    <div class="cta-strip">
                        <a href="{{ route('packages.categories') }}" class="cta-primary">
                            <i class="bi bi-camera"></i> Pesan Sesi Foto
                        </a>
                        @if($portofolio->category)
                            <a href="{{ route('packages.byCategory', $portofolio->category->slug) }}" class="cta-secondary">
                                <i class="bi bi-grid"></i> Lihat Paket {{ $portofolio->category->name }}
                            </a>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4" data-aos="fade-left">
                    <div class="sidebar-card">
                        <div class="sidebar-head">
                            <i class="bi bi-info-circle"></i>
                            <h5>Informasi Karya</h5>
                        </div>
                        <div class="sidebar-body">
                            @if($portofolio->category)
                            <div class="info-row">
                                <span class="info-row-label">Kategori</span>
                                <span class="info-row-val">
                                    <i class="bi bi-tag"></i>
                                    <a href="{{ route('packages.byCategory', $portofolio->category->slug) }}">{{ $portofolio->category->name }}</a>
                                </span>
                            </div>
                            @endif
                            <div class="info-row">
                                <span class="info-row-label">Tanggal Diunggah</span>
                                <span class="info-row-val">
                                    <i class="bi bi-calendar3"></i>
                                    {{ \Carbon\Carbon::parse($portofolio->created_at)->isoFormat('D MMMM YYYY') }}
                                </span>
                            </div>
                            <div class="info-row">
                                <span class="info-row-label">Fotografer</span>
                                <span class="info-row-val"><i class="bi bi-person"></i> Tim Telegrad</span>
                            </div>
                            <div class="info-row">
                                <span class="info-row-label">Pengiriman File</span>
                                <span class="info-row-val"><i class="bi bi-cloud-arrow-up"></i> Google Drive</span>
                            </div>
                            <a href="{{ route('packages.categories') }}" class="sidebar-cta">
                                <i class="bi bi-camera"></i> Pesan Sesi Foto
                            </a>
                            <div style="text-align:center; margin-top:12px;">
                                <a href="{{ route('portfolio.index') }}" style="font-size:.76rem; color:var(--muted); text-decoration:none;">
                                    <i class="bi bi-arrow-left me-1"></i> Semua Portofolio
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            @if($related->count())
            <div class="related-section" data-aos="fade-up">
                <h3 class="related-title">Portofolio Terkait</h3>
                <div class="related-divider"></div>
                <div class="row g-3">
                    @foreach($related as $item)
                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                        <a href="{{ route('portfolio.detail', $item->id) }}" class="rel-card">
                            <img src="{{ asset('storage/images/portofolio/' . $item->image) }}" alt="{{ $item->title }}" loading="lazy">
                            @if($item->category)<span class="rel-badge">{{ $item->category->name }}</span>@endif
                            <div class="rel-overlay">
                                <div class="rel-cat">{{ $item->category->name ?? '' }}</div>
                                <div class="rel-name">{{ $item->title }}</div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </section>
</main>
@endsection