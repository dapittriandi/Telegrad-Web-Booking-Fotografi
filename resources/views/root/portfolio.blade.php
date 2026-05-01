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
    font-size: clamp(2rem, 4.5vw, 3.2rem);
    color: var(--text); font-weight: 700;
    line-height: 1.15; margin-bottom: 14px;
}
.page-hero-sub {
    font-size: .9rem; color: var(--muted);
    max-width: 440px; margin: 0 auto 24px; line-height: 1.75;
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
.portfolio-section { background: var(--bg); padding: 60px 0 100px; }

/* ─── Stats ──────────────────────────────────────────────────── */
.porto-stats {
    display: flex; margin-bottom: 52px;
    border: 1px solid var(--border); border-radius: 14px;
    background: var(--card); overflow: hidden;
}
.porto-stat {
    flex: 1; text-align: center; padding: 20px 12px;
    border-right: 1px solid var(--border);
}
.porto-stat:last-child { border-right: none; }
.porto-stat-num {
    font-family: 'Playfair Display', serif;
    font-size: 1.7rem; font-weight: 700; color: var(--gold); line-height: 1;
}
.porto-stat-label {
    font-size: .68rem; color: var(--muted);
    letter-spacing: .08em; text-transform: uppercase; margin-top: 4px;
}

/* ─── Filter ─────────────────────────────────────────────────── */
.filter-bar {
    display: flex; flex-wrap: wrap; justify-content: center; gap: 8px;
    margin-bottom: 40px;
}
.filter-btn {
    font-size: .75rem; font-weight: 700;
    letter-spacing: .07em; text-transform: uppercase;
    padding: 7px 20px; border-radius: 100px;
    border: 1px solid var(--border-strong);
    color: var(--muted); background: transparent; cursor: pointer;
    transition: all .28s cubic-bezier(.4,0,.2,1);
}
.filter-btn:hover, .filter-btn.active {
    background: var(--gold-dim); border-color: var(--gold); color: var(--gold-light);
}

/* ─── Grid ───────────────────────────────────────────────────── */
.porto-col.hidden { display: none; }
.porto-item {
    position: relative; border-radius: 14px; overflow: hidden;
    border: 1px solid var(--border); aspect-ratio: 4/3;
    background: var(--card); display: block; cursor: pointer;
}
.porto-item img {
    width: 100%; height: 100%; object-fit: cover; display: block;
    transition: transform .6s cubic-bezier(.4,0,.2,1);
}
.porto-item:hover img { transform: scale(1.07); }
.porto-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,.85) 0%, rgba(0,0,0,.2) 50%, transparent 100%);
    opacity: 0; transition: opacity .28s; display: flex; flex-direction: column;
    justify-content: flex-end; padding: 20px;
}
.porto-item:hover .porto-overlay { opacity: 1; }
.porto-overlay-cat {
    font-size: .68rem; font-weight: 700;
    letter-spacing: .14em; text-transform: uppercase;
    color: var(--gold); margin-bottom: 6px;
}
.porto-overlay-title {
    font-family: 'Playfair Display', serif;
    font-size: 1rem; font-weight: 700;
    color: #f0ede8; line-height: 1.3; margin-bottom: 14px;
}
.porto-overlay-actions { display: flex; gap: 8px; }
.porto-action-btn {
    width: 36px; height: 36px;
    background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.2);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: .85rem; text-decoration: none;
    backdrop-filter: blur(6px); transition: background .28s, border-color .28s;
}
.porto-action-btn:hover { background: var(--gold); border-color: var(--gold); color: #0d0d0d; }
.porto-cat-pill {
    position: absolute; top: 12px; left: 12px;
    font-size: .66rem; font-weight: 700;
    letter-spacing: .1em; text-transform: uppercase;
    color: var(--gold); background: rgba(11,12,14,.75);
    border: 1px solid var(--gold-border); padding: 4px 10px; border-radius: 100px;
    backdrop-filter: blur(6px); z-index: 2;
}
.porto-empty { text-align: center; padding: 80px 20px; color: var(--muted); }
.porto-empty i { font-size: 3rem; color: var(--gold-border); display: block; margin-bottom: 14px; }
</style>
@endpush

@section('content')
<main id="main">

    <div class="page-hero">
        <div class="container">
            <div class="page-hero-inner" data-aos="fade-up">
                <span class="page-hero-eyebrow"><i class="bi bi-images me-1"></i> Karya Kami</span>
                <h1>Koleksi Karya Terbaik</h1>
                <p class="page-hero-sub">Setiap foto adalah cerita — inilah momen-momen spesial yang telah kami abadikan.</p>
                <div class="page-hero-breadcrumb">
                    <a href="{{ route('home') }}">Beranda</a>
                    <span class="sep">&#9656;</span>
                    <span class="current">Portofolio</span>
                </div>
            </div>
        </div>
    </div>

    <section class="portfolio-section">
        <div class="container">

            <div class="porto-stats" data-aos="fade-up" data-aos-delay="60">
                <div class="porto-stat">
                    <div class="porto-stat-num">{{ $portofolios->count() }}+</div>
                    <div class="porto-stat-label">Karya Tersedia</div>
                </div>
                <div class="porto-stat">
                    <div class="porto-stat-num">{{ $categories->count() }}</div>
                    <div class="porto-stat-label">Kategori</div>
                </div>
                <div class="porto-stat">
                    <div class="porto-stat-num">100%</div>
                    <div class="porto-stat-label">Outdoor Session</div>
                </div>
            </div>

            @if($categories->count() > 1)
            <div class="filter-bar" data-aos="fade-up" data-aos-delay="100">
                <button class="filter-btn active" data-filter="all">Semua</button>
                @foreach($categories as $cat)
                    <button class="filter-btn" data-filter="{{ $cat->slug }}">{{ $cat->name }}</button>
                @endforeach
            </div>
            @endif

            <div class="row g-3">
                @forelse($portofolios as $item)
                <div class="col-lg-4 col-md-6 porto-col"
                     data-cat="{{ $item->category->slug ?? '' }}"
                     data-aos="fade-up"
                     data-aos-delay="{{ ($loop->index % 3) * 80 }}">
                    <div class="porto-item">
                        <img src="{{ asset('storage/images/portofolio/' . $item->image) }}"
                             alt="{{ $item->title }}" loading="lazy">
                        @if($item->category)
                            <span class="porto-cat-pill">{{ $item->category->name }}</span>
                        @endif
                        <div class="porto-overlay">
                            <div class="porto-overlay-cat">{{ $item->category->name ?? '' }}</div>
                            <div class="porto-overlay-title">{{ $item->title }}</div>
                            <div class="porto-overlay-actions">
                                <a href="{{ asset('storage/images/portofolio/' . $item->image) }}"
                                   class="porto-action-btn glightbox" data-gallery="portfolio"
                                   title="{{ $item->title }}"><i class="bi bi-zoom-in"></i></a>
                                <a href="{{ route('portfolio.detail', $item->id) }}"
                                   class="porto-action-btn" title="Lihat Detail"><i class="bi bi-arrow-up-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 porto-empty">
                    <i class="bi bi-images"></i>
                    <p>Belum ada portofolio tersedia.</p>
                </div>
                @endforelse
            </div>

        </div>
    </section>
</main>
@endsection

@push('js')
<script>
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const filter = btn.dataset.filter;
        document.querySelectorAll('.porto-col').forEach(col => {
            col.classList.toggle('hidden', filter !== 'all' && col.dataset.cat !== filter);
        });
    });
});
</script>
@endpush