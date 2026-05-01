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
.page-hero .breadcrumb-nav .sep { color: var(--border); }
.page-hero .breadcrumb-nav .current { color: var(--gold, #c8a96e); }

/* ─── Section ────────────────────────────────────────────────── */
.pkg-list-section { padding: 72px 0 100px; }

/* ─── Header ─────────────────────────────────────────────────── */
.pkg-header { text-align: center; margin-bottom: 52px; }
.pkg-header h2 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.8rem, 3.5vw, 2.6rem);
    font-weight: 700; color: var(--text);
    margin-bottom: 12px; line-height: 1.2;
}
.pkg-header p {
    font-family: 'DM Sans', sans-serif;
    font-size: .95rem; color: var(--muted);
    max-width: 500px; margin: 0 auto; line-height: 1.8;
}

/* ─── Filter tabs ────────────────────────────────────────────── */
.filter-bar {
    display: flex; flex-wrap: wrap;
    justify-content: center; gap: 8px;
    margin-bottom: 48px;
}
.filter-btn {
    font-family: 'DM Sans', sans-serif;
    font-size: .74rem; font-weight: 600;
    letter-spacing: .07em; text-transform: uppercase;
    padding: 7px 18px; border-radius: 100px;
    border: 1px solid var(--gold-border, rgba(200,169,110,.25));
    color: var(--muted); background: transparent;
    cursor: pointer;
    transition: all .26s cubic-bezier(.4,0,.2,1);
}
.filter-btn:hover,
.filter-btn.active {
    background: var(--gold-dim, rgba(200,169,110,.12));
    border-color: var(--gold, #c8a96e);
    color: var(--gold-light, #d4b97e);
}

/* ─── Package card ───────────────────────────────────────────── */
.pkg-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 16px;
    overflow: hidden; height: 100%;
    display: flex; flex-direction: column;
    position: relative;
    transition: transform .3s cubic-bezier(.4,0,.2,1),
                border-color .3s, background .3s, box-shadow .3s;
}
.pkg-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, transparent, var(--gold, #c8a96e), transparent);
    opacity: 0; transition: opacity .3s;
}
.pkg-card:hover {
    transform: translateY(-7px);
    border-color: var(--gold-border, rgba(200,169,110,.35));
    background: var(--card-hover);
    box-shadow: 0 20px 48px rgba(0,0,0,.3), 0 0 0 1px var(--gold-border, rgba(200,169,110,.12));
}
.pkg-card:hover::before { opacity: 1; }

/* Card header */
.pkg-card-head {
    padding: 22px 24px 20px;
    border-bottom: 1px solid var(--border);
    display: flex; align-items: flex-start;
    justify-content: space-between; gap: 12px;
}
.pkg-name {
    font-family: 'Playfair Display', serif;
    font-size: 1.05rem; font-weight: 700;
    color: var(--text); line-height: 1.3; flex: 1;
}
.pkg-price {
    font-family: 'DM Sans', sans-serif;
    font-size: 1.05rem; font-weight: 700;
    color: var(--gold-light, #d4b97e); white-space: nowrap; flex-shrink: 0;
}

/* Card body */
.pkg-card-body {
    padding: 20px 24px;
    flex-grow: 1; display: flex; flex-direction: column; gap: 14px;
}
.pkg-meta { display: flex; flex-wrap: wrap; gap: 8px; }
.pkg-pill {
    display: inline-flex; align-items: center; gap: 5px;
    font-family: 'DM Sans', sans-serif;
    font-size: .73rem; color: var(--muted);
    background: var(--gold-dim, rgba(200,169,110,.08));
    border: 1px solid var(--gold-border, rgba(200,169,110,.2));
    padding: 4px 11px; border-radius: 100px;
}
.pkg-pill i { color: var(--gold); font-size: .78rem; }
.pkg-participants {
    font-family: 'DM Sans', sans-serif;
    font-size: .82rem; color: var(--text);
    display: flex; align-items: center; gap: 8px;
}
.pkg-participants i { color: var(--gold); }
.pkg-features {
    list-style: none; padding: 0; margin: 0;
    display: flex; flex-direction: column; gap: 7px; flex-grow: 1;
}
.pkg-features li {
    font-family: 'DM Sans', sans-serif;
    font-size: .82rem; color: var(--muted);
    display: flex; align-items: flex-start; gap: 8px; line-height: 1.5;
}
.pkg-features li i { color: var(--success, #5cb85c); font-size: .75rem; margin-top: 3px; flex-shrink: 0; }

/* Card footer */
.pkg-card-foot {
    padding: 16px 24px 20px;
    border-top: 1px solid var(--border);
}
.pkg-cta {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    width: 100%; padding: 11px 0;
    font-family: 'DM Sans', sans-serif;
    font-size: .8rem; font-weight: 700;
    letter-spacing: .08em; text-transform: uppercase;
    color: #0d0d0d; background: var(--gold, #c8a96e);
    border: none; border-radius: 10px;
    text-decoration: none;
    transition: background .26s, transform .2s, box-shadow .26s;
}
.pkg-cta:hover {
    background: var(--gold-light, #d4b97e); color: #0d0d0d;
    transform: scale(1.02);
    box-shadow: 0 8px 24px rgba(200,169,110,.28);
}

/* Back link */
.back-link {
    display: inline-flex; align-items: center; gap: 8px;
    font-family: 'DM Sans', sans-serif;
    font-size: .8rem; font-weight: 500;
    color: var(--muted); text-decoration: none;
    margin-bottom: 40px;
    padding: 7px 16px;
    border: 1px solid var(--border);
    border-radius: 100px;
    transition: color .26s, border-color .26s, background .26s;
}
.back-link:hover {
    color: var(--gold, #c8a96e);
    border-color: var(--gold-border, rgba(200,169,110,.3));
    background: var(--gold-dim, rgba(200,169,110,.08));
}

/* Empty */
.pkg-empty { text-align: center; padding: 80px 20px; color: var(--muted); }
.pkg-empty i { font-size: 3rem; color: var(--gold-border); display: block; margin-bottom: 16px; }
.pkg-col.hidden { display: none; }
</style>
@endpush

@section('content')
<main id="main">

    {{-- Clean page hero (no background image) --}}
    <div class="page-hero" data-aos="fade-down">
        <div class="container">
            <h1>{{ $category->name }}</h1>
            <nav class="breadcrumb-nav mt-3">
                <a href="{{ route('home') }}">Beranda</a>
                <span class="sep">/</span>
                <a href="{{ route('packages.categories') }}">Paket</a>
                <span class="sep">/</span>
                <span class="current">{{ $category->name }}</span>
            </nav>
        </div>
    </div>

    <section class="pkg-list-section">
        <div class="container">

            <a href="{{ route('packages.categories') }}" class="back-link" data-aos="fade-right">
                <i class="bi bi-arrow-left"></i> Semua Kategori
            </a>

            <div class="pkg-header" data-aos="fade-up">
                @php
                    $icons = ['wisuda'=>'bi-mortarboard','yudisium'=>'bi-award','after-sidang'=>'bi-journal-check'];
                    $icon  = $icons[$category->slug] ?? 'bi-camera';
                @endphp
                <span class="section-label">
                    <i class="bi {{ $icon }} me-1"></i> {{ $category->name }}
                </span>
                <div class="line-accent centered"></div>
                <h2>Paket {{ $category->name }}</h2>
                <p>{{ $category->description ?? 'Pilih paket yang paling sesuai dengan kebutuhanmu.' }}</p>
            </div>

            {{-- Filter tabs --}}
            @php
                $types = $packages->pluck('participants')
                    ->map(fn($p) => match(true) {
                        str_contains(strtolower($p), 'personal') || str_contains(strtolower($p), '1 orang') => 'Personal',
                        str_contains(strtolower($p), 'family')   => 'Family',
                        str_contains(strtolower($p), 'couple')   => 'Couple',
                        str_contains(strtolower($p), 'group')    => 'Group',
                        str_contains(strtolower($p), 'foto') && str_contains(strtolower($p), 'video') => 'Foto & Video',
                        str_contains(strtolower($p), 'video')    => 'Video',
                        default => 'Lainnya',
                    })
                    ->unique()->values();
            @endphp
            @if($types->count() > 1)
            <div class="filter-bar" data-aos="fade-up" data-aos-delay="80">
                <button class="filter-btn active" data-filter="all">Semua</button>
                @foreach($types as $type)
                    <button class="filter-btn" data-filter="{{ Str::slug($type) }}">{{ $type }}</button>
                @endforeach
            </div>
            @endif

            <div class="row g-4" id="pkg-grid">
                @forelse($packages as $package)
                @php
                    $p = strtolower($package->participants ?? '');
                    $filterTag = match(true) {
                        str_contains($p, 'family')  => 'family',
                        str_contains($p, 'couple')  => 'couple',
                        str_contains($p, 'group')   => 'group',
                        str_contains($p, 'foto') && str_contains($p, 'video') => 'foto-video',
                        str_contains($p, 'video')   => 'video',
                        default                     => 'personal',
                    };
                    $features = array_filter(explode("\n", $package->features ?? ''));
                @endphp
                <div class="col-lg-4 col-md-6 pkg-col"
                     data-type="{{ $filterTag }}"
                     data-aos="fade-up"
                     data-aos-delay="{{ ($loop->index % 3) * 80 }}">
                    <div class="pkg-card">
                        <div class="pkg-card-head">
                            <div class="pkg-name">{{ $package->name }}</div>
                            <div class="pkg-price">Rp {{ number_format($package->price, 0, ',', '.') }}</div>
                        </div>
                        <div class="pkg-card-body">
                            <div class="pkg-meta">
                                <span class="pkg-pill">
                                    <i class="bi bi-clock"></i> {{ $package->duration ?? '-' }} menit
                                </span>
                                @if($package->unlimited_participants)
                                    <span class="pkg-pill"><i class="bi bi-people"></i> Tidak dibatasi</span>
                                @elseif($package->max_participants)
                                    <span class="pkg-pill">
                                        <i class="bi bi-people"></i>
                                        {{ $package->min_participants == $package->max_participants
                                            ? $package->min_participants . ' orang'
                                            : $package->min_participants . '–' . $package->max_participants . ' orang' }}
                                    </span>
                                @endif
                            </div>
                            <div class="pkg-participants">
                                <i class="bi bi-person-badge"></i>
                                <span>{{ $package->participants }}</span>
                            </div>
                            <ul class="pkg-features">
                                @foreach(array_slice($features, 0, 5) as $feat)
                                    <li><i class="bi bi-check-circle-fill"></i>{{ trim($feat) }}</li>
                                @endforeach
                                @if(count($features) > 5)
                                    <li style="color:var(--gold);font-size:.78rem;">
                                        <i class="bi bi-plus-circle"></i>+{{ count($features) - 5 }} keuntungan lainnya
                                    </li>
                                @endif
                            </ul>
                        </div>
                        <div class="pkg-card-foot">
                            <a href="{{ route('packages.detail', $package->id) }}" class="pkg-cta">
                                <i class="bi bi-camera"></i> Lihat & Pesan
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 pkg-empty">
                    <i class="bi bi-camera-slash"></i>
                    <p>Belum ada paket tersedia untuk kategori ini.</p>
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
        document.querySelectorAll('.pkg-col').forEach(col => {
            col.classList.toggle('hidden', filter !== 'all' && col.dataset.type !== filter);
        });
    });
});
</script>
@endpush