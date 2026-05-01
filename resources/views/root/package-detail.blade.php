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
    width: 700px; height: 320px;
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
    font-size: clamp(1.6rem, 3.5vw, 2.8rem);
    color: var(--text); font-weight: 700;
    line-height: 1.15; margin-bottom: 20px;
    max-width: 720px; margin-left: auto; margin-right: auto;
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

/* ─── Left content ───────────────────────────────────────────── */
.detail-label {
    display: inline-block; font-size: .68rem; font-weight: 700;
    letter-spacing: .18em; text-transform: uppercase;
    color: var(--gold); border: 1px solid var(--gold-border);
    padding: 4px 14px; border-radius: 100px; margin-bottom: 16px;
}
.detail-name {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.6rem, 3vw, 2.4rem);
    font-weight: 700; color: var(--text); line-height: 1.2; margin-bottom: 8px;
}
.detail-category { font-size: .85rem; color: var(--muted); margin-bottom: 28px; }
.detail-category a { color: var(--gold); text-decoration: none; }
.detail-category a:hover { color: var(--gold-light); }

/* ─── Meta pills ─────────────────────────────────────────────── */
.meta-row { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 32px; }
.meta-pill {
    display: inline-flex; align-items: center; gap: 7px;
    font-size: .8rem; color: var(--text);
    background: var(--surface); border: 1px solid var(--border);
    padding: 8px 16px; border-radius: 100px;
}
.meta-pill i { color: var(--gold); font-size: .85rem; }
.meta-pill strong { color: var(--gold-light); }

.gold-divider {
    height: 1px;
    background: linear-gradient(90deg, var(--gold-border), transparent);
    margin: 28px 0;
}

/* ─── Features ───────────────────────────────────────────────── */
.features-title {
    font-size: .72rem; font-weight: 700;
    letter-spacing: .14em; text-transform: uppercase;
    color: var(--muted); margin-bottom: 16px;
}
.feature-list {
    list-style: none; padding: 0; margin: 0;
    display: grid; grid-template-columns: 1fr 1fr; gap: 12px;
}
@media (max-width: 576px) { .feature-list { grid-template-columns: 1fr; } }
.feature-list li {
    display: flex; align-items: flex-start; gap: 10px;
    font-size: .875rem; color: var(--muted); line-height: 1.55;
}
.feature-list li i { color: var(--success); font-size: .8rem; margin-top: 3px; flex-shrink: 0; }

/* ─── Note box ───────────────────────────────────────────────── */
.note-box {
    background: var(--gold-dim); border: 1px solid var(--gold-border);
    border-radius: 10px; padding: 16px 20px;
    font-size: .82rem; color: var(--muted); line-height: 1.7;
    margin-top: 28px; display: flex; gap: 12px;
}
.note-box i { color: var(--gold); font-size: 1rem; flex-shrink: 0; margin-top: 1px; }
.note-box strong { color: var(--text); }

/* ─── Sticky price card ──────────────────────────────────────── */
.detail-sidebar { position: sticky; top: 90px; }
.price-card {
    background: var(--card); border: 1px solid var(--gold-border);
    border-radius: 14px; overflow: hidden;
}
.price-card-head {
    background: linear-gradient(135deg, var(--surface), var(--card));
    border-bottom: 1px solid var(--gold-border);
    padding: 28px 28px 24px; text-align: center;
}
.price-label {
    font-size: .7rem; font-weight: 700;
    letter-spacing: .15em; text-transform: uppercase; color: var(--muted); margin-bottom: 8px;
}
.price-amount {
    font-family: 'Playfair Display', serif;
    font-size: 2.2rem; font-weight: 800; color: var(--gold-light); line-height: 1;
}
.price-note { font-size: .75rem; color: var(--muted); margin-top: 6px; }
.price-card-body { padding: 24px 28px; display: flex; flex-direction: column; gap: 16px; }

.summary-row {
    display: flex; align-items: center; justify-content: space-between;
    font-size: .83rem; padding-bottom: 12px;
    border-bottom: 1px solid var(--border);
}
.summary-row:last-of-type { border-bottom: none; padding-bottom: 0; }
.summary-key { display: flex; align-items: center; gap: 8px; color: var(--muted); }
.summary-key i { color: var(--gold); width: 16px; }
.summary-val { color: var(--text); font-weight: 500; text-align: right; }

.cta-book {
    display: flex; align-items: center; justify-content: center; gap: 9px;
    width: 100%; padding: 14px 0; font-size: .85rem; font-weight: 700;
    letter-spacing: .08em; text-transform: uppercase;
    color: #1a1410; background: var(--gold); border: none; border-radius: 10px;
    text-decoration: none; cursor: pointer;
    transition: background .26s, transform .26s, box-shadow .26s;
}
.cta-book:hover {
    background: var(--gold-light); color: #1a1410;
    transform: translateY(-2px); box-shadow: var(--shadow-md);
}
.cta-login {
    display: flex; align-items: center; justify-content: center; gap: 9px;
    width: 100%; padding: 13px 0; font-size: .82rem; font-weight: 600;
    color: var(--gold); background: transparent;
    border: 1px solid var(--gold-border); border-radius: 10px; text-decoration: none;
    margin-top: 4px; transition: background .26s, border-color .26s;
}
.cta-login:hover { background: var(--gold-dim); border-color: var(--gold); color: var(--gold-light); }
.cta-hint { text-align: center; font-size: .75rem; color: var(--muted); margin-top: 12px; line-height: 1.6; }
.cta-hint a { color: var(--gold); text-decoration: none; }

.guarantee-strip { display: flex; border-top: 1px solid var(--border); margin-top: 4px; }
.g-item {
    flex: 1; text-align: center; padding: 14px 8px;
    border-right: 1px solid var(--border);
    font-size: .72rem; color: var(--muted); line-height: 1.5;
}
.g-item:last-child { border-right: none; }
.g-item i { display: block; color: var(--gold); font-size: 1rem; margin-bottom: 4px; }

/* ─── Related ────────────────────────────────────────────────── */
.related-section { margin-top: 80px; }
.related-title { font-family: 'Playfair Display', serif; font-size: 1.5rem; color: var(--text); margin-bottom: 4px; }
.related-divider {
    height: 1px; background: linear-gradient(90deg, var(--gold-border), transparent);
    margin-bottom: 32px; margin-top: 12px;
}
.rel-card {
    background: var(--card); border: 1px solid var(--border);
    border-radius: 14px; padding: 22px 20px 18px; height: 100%;
    display: flex; flex-direction: column; position: relative;
    transition: transform .26s, border-color .26s;
}
.rel-card:hover { transform: translateY(-5px); border-color: var(--gold-border); }
.rel-card::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, transparent, var(--gold), transparent);
    opacity: 0; border-radius: 14px 14px 0 0; transition: opacity .26s;
}
.rel-card:hover::before { opacity: 1; }
.rel-name { font-family: 'Playfair Display', serif; font-size: 1rem; color: var(--text); margin-bottom: 6px; font-weight: 700; }
.rel-participants { font-size: .78rem; color: var(--muted); margin-bottom: 12px; line-height: 1.5; }
.rel-price { font-size: 1.05rem; font-weight: 800; color: var(--gold-light); margin-bottom: 16px; }
.rel-pills { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 18px; }
.rel-pill {
    font-size: .7rem; color: var(--muted); background: var(--surface);
    border: 1px solid var(--border); padding: 3px 10px; border-radius: 100px;
    display: flex; align-items: center; gap: 4px;
}
.rel-pill i { color: var(--gold); }
.rel-link {
    margin-top: auto; display: inline-flex; align-items: center; gap: 6px;
    font-size: .78rem; font-weight: 600; color: var(--gold); text-decoration: none;
    transition: gap .26s;
}
.rel-link:hover { gap: 10px; color: var(--gold-light); }
</style>
@endpush

@section('content')
<main id="main">

    <div class="page-hero">
        <div class="container">
            <div class="page-hero-inner" data-aos="fade-up">
                @if($package->category)
                    <span class="page-hero-eyebrow"><i class="bi bi-tag me-1"></i>{{ $package->category->name }}</span>
                @else
                    <span class="page-hero-eyebrow"><i class="bi bi-box me-1"></i> Paket Foto</span>
                @endif
                <h1>{{ $package->name }}</h1>
                <div class="page-hero-breadcrumb">
                    <a href="{{ route('home') }}">Beranda</a>
                    <span class="sep">&#9656;</span>
                    <a href="{{ route('packages.categories') }}">Paket</a>
                    @if($package->category)
                        <span class="sep">&#9656;</span>
                        <a href="{{ route('packages.byCategory', $package->category->slug) }}">{{ $package->category->name }}</a>
                    @endif
                    <span class="sep">&#9656;</span>
                    <span class="current">{{ Str::limit($package->name, 40) }}</span>
                </div>
            </div>
        </div>
    </div>

    <section class="detail-section">
        <div class="container">

            <a href="{{ $package->category ? route('packages.byCategory', $package->category->slug) : route('packages.categories') }}"
               class="back-link" data-aos="fade-right">
                <i class="bi bi-arrow-left"></i> Kembali ke {{ $package->category->name ?? 'Paket' }}
            </a>

            <div class="row g-5 align-items-start">

                {{-- LEFT --}}
                <div class="col-lg-8" data-aos="fade-right">
                    @if($package->category)
                        <span class="detail-label"><i class="bi bi-tag me-1"></i>{{ $package->category->name }}</span>
                    @endif
                    <h1 class="detail-name">{{ $package->name }}</h1>
                    <div class="detail-category">
                        Kategori:
                        @if($package->category)
                            <a href="{{ route('packages.byCategory', $package->category->slug) }}">{{ $package->category->name }}</a>
                        @else <span>—</span> @endif
                    </div>

                    <div class="meta-row">
                        <span class="meta-pill">
                            <i class="bi bi-clock"></i>
                            Durasi <strong>{{ $package->duration ?? '-' }} menit</strong>
                        </span>
                        <span class="meta-pill">
                            <i class="bi bi-people"></i>
                            @if($package->unlimited_participants)
                                Peserta <strong>Tidak Dibatasi</strong>
                            @elseif($package->min_participants && $package->max_participants)
                                @if($package->min_participants == $package->max_participants)
                                    <strong>{{ $package->min_participants }} Orang</strong>
                                @else
                                    <strong>{{ $package->min_participants }}–{{ $package->max_participants }} Orang</strong>
                                @endif
                            @else
                                <strong>{{ $package->participants }}</strong>
                            @endif
                        </span>
                    </div>

                    <div class="gold-divider"></div>

                    @php $features = array_filter(explode("\n", $package->features ?? '')); @endphp
                    @if(count($features))
                        <div class="features-title">Yang Kamu Dapatkan</div>
                        <ul class="feature-list">
                            @foreach($features as $feat)
                                <li><i class="bi bi-check-circle-fill"></i> {{ trim($feat) }}</li>
                            @endforeach
                        </ul>
                    @endif

                    <div class="note-box">
                        <i class="bi bi-info-circle-fill"></i>
                        <div>
                            <strong>Catatan Pemesanan:</strong><br>
                            Setelah booking dikonfirmasi, kamu akan mendapatkan detail jadwal via WhatsApp.
                            Pembatalan harap dilakukan minimal <strong>1×24 jam</strong> sebelum sesi.
                            File hasil foto dikirimkan via Google Drive dalam 3–5 hari kerja.
                        </div>
                    </div>
                </div>

                {{-- RIGHT --}}
                <div class="col-lg-4" data-aos="fade-left">
                    <div class="detail-sidebar">
                        <div class="price-card">
                            <div class="price-card-head">
                                <div class="price-label">Harga Paket</div>
                                <div class="price-amount">Rp {{ number_format($package->price, 0, ',', '.') }}</div>
                                <div class="price-note">Sudah termasuk semua yang tertera di paket</div>
                            </div>
                            <div class="price-card-body">
                                <div class="summary-row">
                                    <span class="summary-key"><i class="bi bi-box"></i> Paket</span>
                                    <span class="summary-val">{{ $package->name }}</span>
                                </div>
                                <div class="summary-row">
                                    <span class="summary-key"><i class="bi bi-clock"></i> Durasi</span>
                                    <span class="summary-val">{{ $package->duration ?? '-' }} menit</span>
                                </div>
                                <div class="summary-row">
                                    <span class="summary-key"><i class="bi bi-people"></i> Peserta</span>
                                    <span class="summary-val">
                                        @if($package->unlimited_participants) Tidak Dibatasi
                                        @elseif($package->min_participants == $package->max_participants) {{ $package->min_participants }} Orang
                                        @else {{ $package->min_participants }}–{{ $package->max_participants }} Orang
                                        @endif
                                    </span>
                                </div>
                                <div class="summary-row">
                                    <span class="summary-key"><i class="bi bi-folder2-open"></i> File</span>
                                    <span class="summary-val">Via Google Drive</span>
                                </div>

                                @auth
                                    <a href="{{ route('booking.form', $package->id) }}" class="cta-book">
                                        <i class="bi bi-calendar-check"></i> Pesan Sekarang
                                    </a>
                                    <div class="cta-hint">
                                        Login sebagai <strong style="color:var(--gold);">{{ Auth::user()->name }}</strong>
                                    </div>
                                @else
                                    <a href="{{ route('customer.login') }}?redirect={{ urlencode(url()->current()) }}" class="cta-book">
                                        <i class="bi bi-calendar-check"></i> Pesan Sekarang
                                    </a>
                                    <a href="{{ route('customer.login') }}?redirect={{ urlencode(url()->current()) }}" class="cta-login">
                                        <i class="bi bi-box-arrow-in-right"></i> Login untuk Memesan
                                    </a>
                                    <div class="cta-hint">
                                        Belum punya akun? <a href="{{ route('customer.login') }}">Daftar di sini</a>
                                    </div>
                                @endauth

                                <div class="guarantee-strip">
                                    <div class="g-item"><i class="bi bi-shield-check"></i>Aman &<br>Terpercaya</div>
                                    <div class="g-item"><i class="bi bi-camera2"></i>Foto<br>Profesional</div>
                                    <div class="g-item"><i class="bi bi-cloud-arrow-up"></i>File via<br>Drive</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Related --}}
            @if($related->count())
            <div class="related-section" data-aos="fade-up">
                <h3 class="related-title">Paket Lainnya</h3>
                <div class="related-divider"></div>
                <div class="row g-4">
                    @foreach($related as $rel)
                    <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                        <div class="rel-card">
                            <div class="rel-name">{{ $rel->name }}</div>
                            <div class="rel-participants">{{ $rel->participants }}</div>
                            <div class="rel-price">Rp {{ number_format($rel->price, 0, ',', '.') }}</div>
                            <div class="rel-pills">
                                <span class="rel-pill"><i class="bi bi-clock"></i> {{ $rel->duration }} mnt</span>
                                @if($rel->unlimited_participants)
                                    <span class="rel-pill"><i class="bi bi-people"></i> Bebas</span>
                                @elseif($rel->max_participants)
                                    <span class="rel-pill">
                                        <i class="bi bi-people"></i>
                                        {{ $rel->min_participants == $rel->max_participants
                                            ? $rel->min_participants . ' org'
                                            : $rel->min_participants . '–' . $rel->max_participants . ' org' }}
                                    </span>
                                @endif
                            </div>
                            <a href="{{ route('packages.detail', $rel->id) }}" class="rel-link">
                                Lihat Detail <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </section>
</main>
@endsection