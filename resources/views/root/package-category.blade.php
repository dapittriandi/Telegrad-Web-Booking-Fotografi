@extends('base.base-root-index')

@push('css')
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,600&family=DM+Sans:wght@300;400;500;600&display=swap');

/* ─── Variables ──────────────────────────────────────────────── */
:root {
    --gold: #c8a96e;
    --gold-light: #d4b97e;
    --gold-dim: rgba(200,169,110,.10);
    --gold-border: rgba(200,169,110,.28);
    --text: #f0ece3;
    --muted: #888;
    --muted-2: #666;
    --card: #151515;
    --card-hover: #1a1a1a;
    --border: rgba(255,255,255,.07);
    --surface: #0f0f0f;
    --success: #5cb85c;
    --transition: cubic-bezier(.4,0,.2,1);
}

/* ─── Page hero ──────────────────────────────────────────────── */
.page-hero {
    position: relative;
    padding: 80px 0 64px;
    text-align: center;
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    overflow: hidden;
}
.page-hero::before {
    content: '';
    position: absolute;
    top: -100px; left: 50%;
    transform: translateX(-50%);
    width: 700px; height: 360px;
    background: radial-gradient(ellipse, rgba(200,169,110,.10) 0%, transparent 68%);
    pointer-events: none;
}
.page-hero h1 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2rem, 5vw, 3.2rem);
    font-weight: 700;
    color: var(--text);
    margin-bottom: 12px;
    line-height: 1.15;
    position: relative;
}
.breadcrumb-nav {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    font-family: 'DM Sans', sans-serif;
    font-size: .78rem; font-weight: 500;
    color: var(--muted);
    letter-spacing: .06em; text-transform: uppercase;
    position: relative;
}
.breadcrumb-nav a { color: var(--muted); text-decoration: none; transition: color .2s; }
.breadcrumb-nav a:hover { color: var(--gold); }
.breadcrumb-nav .sep { color: var(--border); }
.breadcrumb-nav .current { color: var(--gold); }

/* ─── Section layout ─────────────────────────────────────────── */
.pkg-list-section { padding: 64px 0 100px; }

/* ─── Back link ──────────────────────────────────────────────── */
.back-link {
    display: inline-flex; align-items: center; gap: 8px;
    font-family: 'DM Sans', sans-serif;
    font-size: .78rem; font-weight: 500;
    color: var(--muted); text-decoration: none;
    margin-bottom: 40px;
    padding: 7px 16px;
    border: 1px solid var(--border);
    border-radius: 100px;
    transition: color .26s, border-color .26s, background .26s;
}
.back-link:hover {
    color: var(--gold);
    border-color: var(--gold-border);
    background: var(--gold-dim);
}

/* ─── Section header ─────────────────────────────────────────── */
.pkg-header { text-align: center; margin-bottom: 48px; }
.pkg-header .section-label {
    font-family: 'DM Sans', sans-serif;
    font-size: .73rem; font-weight: 600;
    letter-spacing: .1em; text-transform: uppercase;
    color: var(--gold); display: inline-block; margin-bottom: 10px;
}
.pkg-header h2 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.7rem, 3.5vw, 2.5rem);
    font-weight: 700; color: var(--text);
    margin-bottom: 12px; line-height: 1.2;
}
.pkg-header p {
    font-family: 'DM Sans', sans-serif;
    font-size: .92rem; color: var(--muted);
    max-width: 480px; margin: 0 auto; line-height: 1.8;
}
.line-accent.centered {
    width: 48px; height: 2px;
    background: linear-gradient(90deg, transparent, var(--gold), transparent);
    margin: 10px auto 16px;
}

/* ─── Filter & Sort bar ──────────────────────────────────────── */
.controls-bar {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 40px;
    padding: 16px 20px;
    background: rgba(255,255,255,.025);
    border: 1px solid var(--border);
    border-radius: 16px;
}

/* Filter group */
.filter-group {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    align-items: center;
    flex: 1;
}
.filter-label {
    font-family: 'DM Sans', sans-serif;
    font-size: .7rem; font-weight: 600;
    letter-spacing: .08em; text-transform: uppercase;
    color: var(--muted-2);
    margin-right: 4px;
    white-space: nowrap;
}
.filter-btn {
    font-family: 'DM Sans', sans-serif;
    font-size: .72rem; font-weight: 600;
    letter-spacing: .06em; text-transform: uppercase;
    padding: 6px 16px; border-radius: 100px;
    border: 1px solid var(--gold-border);
    color: var(--muted); background: transparent;
    cursor: pointer;
    transition: all .22s var(--transition);
    white-space: nowrap;
}
.filter-btn:hover { color: var(--gold-light); border-color: var(--gold); background: var(--gold-dim); }
.filter-btn.active {
    background: var(--gold-dim);
    border-color: var(--gold);
    color: var(--gold-light);
    box-shadow: 0 0 12px rgba(200,169,110,.12);
}

/* Sort group */
.sort-group {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
}
.sort-label {
    font-family: 'DM Sans', sans-serif;
    font-size: .7rem; font-weight: 600;
    letter-spacing: .08em; text-transform: uppercase;
    color: var(--muted-2);
    white-space: nowrap;
}
.sort-select {
    font-family: 'DM Sans', sans-serif;
    font-size: .78rem; font-weight: 500;
    color: var(--text);
    background: rgba(255,255,255,.04);
    border: 1px solid var(--gold-border);
    border-radius: 100px;
    padding: 6px 32px 6px 14px;
    cursor: pointer;
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%23c8a96e' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    transition: border-color .22s, background-color .22s;
    outline: none;
}
.sort-select:hover, .sort-select:focus {
    border-color: var(--gold);
    background-color: var(--gold-dim);
}
.sort-select option { background: #1a1a1a; color: var(--text); }

/* Results count */
.results-count {
    font-family: 'DM Sans', sans-serif;
    font-size: .75rem; color: var(--muted);
    white-space: nowrap;
}
.results-count span { color: var(--gold); font-weight: 600; }

/* ─── Package cards ──────────────────────────────────────────── */
.pkg-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 18px;
    overflow: hidden; height: 100%;
    display: flex; flex-direction: column;
    position: relative;
    transition: transform .3s var(--transition),
                border-color .3s, background .3s, box-shadow .3s;
}
.pkg-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, transparent, var(--gold), transparent);
    opacity: 0; transition: opacity .3s;
}
.pkg-card:hover {
    transform: translateY(-6px);
    border-color: var(--gold-border);
    background: var(--card-hover);
    box-shadow: 0 20px 48px rgba(0,0,0,.3), 0 0 0 1px rgba(200,169,110,.08);
}
.pkg-card:hover::before { opacity: 1; }

.pkg-card-head {
    padding: 22px 24px 18px;
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
    font-size: 1rem; font-weight: 700;
    color: var(--gold-light); white-space: nowrap; flex-shrink: 0;
}

.pkg-card-body {
    padding: 18px 24px;
    flex-grow: 1; display: flex; flex-direction: column; gap: 14px;
}
.pkg-meta { display: flex; flex-wrap: wrap; gap: 7px; }
.pkg-pill {
    display: inline-flex; align-items: center; gap: 5px;
    font-family: 'DM Sans', sans-serif;
    font-size: .71rem; color: var(--muted);
    background: var(--gold-dim);
    border: 1px solid var(--gold-border);
    padding: 4px 11px; border-radius: 100px;
}
.pkg-pill i { color: var(--gold); font-size: .76rem; }

/* Type badge */
.pkg-type-badge {
    display: inline-flex; align-items: center; gap: 5px;
    font-family: 'DM Sans', sans-serif;
    font-size: .68rem; font-weight: 700;
    letter-spacing: .06em; text-transform: uppercase;
    color: var(--gold);
    background: rgba(200,169,110,.08);
    border: 1px solid rgba(200,169,110,.2);
    padding: 3px 10px; border-radius: 6px;
}

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
    font-size: .81rem; color: var(--muted);
    display: flex; align-items: flex-start; gap: 8px; line-height: 1.5;
}
.pkg-features li i { color: var(--success); font-size: .73rem; margin-top: 3px; flex-shrink: 0; }

.pkg-card-foot {
    padding: 14px 24px 20px;
    border-top: 1px solid var(--border);
}
.pkg-cta {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    width: 100%; padding: 11px 0;
    font-family: 'DM Sans', sans-serif;
    font-size: .78rem; font-weight: 700;
    letter-spacing: .08em; text-transform: uppercase;
    color: #0d0d0d; background: var(--gold);
    border: none; border-radius: 10px;
    text-decoration: none;
    transition: background .24s, transform .2s, box-shadow .24s;
}
.pkg-cta:hover {
    background: var(--gold-light); color: #0d0d0d;
    transform: scale(1.02);
    box-shadow: 0 8px 24px rgba(200,169,110,.28);
}

/* ─── Empty state ────────────────────────────────────────────── */
.pkg-empty {
    grid-column: 1 / -1;
    text-align: center; padding: 80px 20px; color: var(--muted);
}
.pkg-empty i { font-size: 3rem; color: var(--gold-border); display: block; margin-bottom: 16px; }
.pkg-empty p { font-family: 'DM Sans', sans-serif; font-size: .95rem; }

/* ─── Card hidden state ──────────────────────────────────────── */
.pkg-col {
    transition: opacity .25s, transform .25s;
}
.pkg-col.hidden {
    display: none !important;
}

/* ─── Mobile: sticky controls ────────────────────────────────── */
@media (max-width: 767px) {
    .controls-bar {
        flex-direction: column;
        align-items: stretch;
        gap: 14px;
        padding: 14px 16px;
        border-radius: 14px;
    }
    .filter-group { justify-content: flex-start; }
    .sort-group { justify-content: space-between; }
    .sort-select { flex: 1; }
    .results-count { text-align: center; }

    /* Scrollable filter chips on mobile */
    .filter-scroll-wrapper {
        display: flex;
        overflow-x: auto;
        gap: 8px;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
        padding-bottom: 2px;
    }
    .filter-scroll-wrapper::-webkit-scrollbar { display: none; }
    .filter-scroll-wrapper .filter-btn { flex-shrink: 0; }

    .pkg-card-head { padding: 18px 18px 14px; }
    .pkg-card-body { padding: 14px 18px; }
    .pkg-card-foot { padding: 12px 18px 16px; }
    .pkg-name { font-size: .98rem; }
    .pkg-price { font-size: .95rem; }
}

/* ─── Animate in ─────────────────────────────────────────────── */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(18px); }
    to   { opacity: 1; transform: translateY(0); }
}
.pkg-col.animate-in {
    animation: fadeUp .38s var(--transition) both;
}
</style>
@endpush

@section('content')
<main id="main">

    {{-- Page hero --}}
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

            {{-- Section header --}}
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

            {{-- Controls: Filter + Sort --}}
            @php
                /**
                 * Determine participant type from the participants string.
                 * Returns a slug like 'personal', 'couple', 'family', 'group', 'foto-video'
                 */
                function pkgType(string $p): string {
                    $p = strtolower($p);
                    if (str_contains($p, 'family') || str_contains($p, 'keluarga'))  return 'family';
                    if (str_contains($p, 'couple') || str_contains($p, 'pasangan'))  return 'couple';
                    if (str_contains($p, 'group')  || str_contains($p, 'grup') || str_contains($p, 'rombongan')) return 'group';
                    if (str_contains($p, 'foto') && str_contains($p, 'video'))       return 'foto-video';
                    if (str_contains($p, 'video'))                                   return 'video';
                    return 'personal';
                }

                $typeLabels = [
                    'personal'   => ['label' => 'Personal',   'icon' => 'bi-person'],
                    'couple'     => ['label' => 'Couple',     'icon' => 'bi-people'],
                    'family'     => ['label' => 'Family',     'icon' => 'bi-house-heart'],
                    'group'      => ['label' => 'Group',      'icon' => 'bi-people-fill'],
                    'foto-video' => ['label' => 'Foto & Video','icon'=> 'bi-camera-video'],
                    'video'      => ['label' => 'Video',      'icon' => 'bi-camera-video-fill'],
                ];

                $usedTypes = $packages->map(fn($pkg) => pkgType($pkg->participants ?? ''))->unique()->values()->toArray();
            @endphp

            <div class="controls-bar" data-aos="fade-up" data-aos-delay="60">
                {{-- Filter chips --}}
                <div class="filter-group">
                    <span class="filter-label"><i class="bi bi-funnel me-1"></i>Tipe</span>
                    <div class="filter-scroll-wrapper">
                        <button class="filter-btn active" data-filter="all">Semua</button>
                        @foreach($usedTypes as $typeKey)
                            @if(isset($typeLabels[$typeKey]))
                                <button class="filter-btn" data-filter="{{ $typeKey }}">
                                    <i class="bi {{ $typeLabels[$typeKey]['icon'] }} me-1"></i>
                                    {{ $typeLabels[$typeKey]['label'] }}
                                </button>
                            @endif
                        @endforeach
                    </div>
                </div>

                {{-- Sort + count --}}
                <div class="sort-group">
                    <span class="sort-label"><i class="bi bi-arrow-down-up me-1"></i>Urut</span>
                    <select class="sort-select" id="sort-select">
                        <option value="default">Default</option>
                        <option value="price-asc">Harga: Termurah</option>
                        <option value="price-desc">Harga: Termahal</option>
                        <option value="name-asc">Nama: A–Z</option>
                        <option value="name-desc">Nama: Z–A</option>
                    </select>
                </div>

                <div class="results-count">
                    <span id="visible-count">{{ $packages->count() }}</span> paket ditemukan
                </div>
            </div>

            {{-- Package grid --}}
            <div class="row g-4" id="pkg-grid">
                @forelse($packages as $package)
                @php
                    $typeKey  = pkgType($package->participants ?? '');
                    $typeInfo = $typeLabels[$typeKey] ?? ['label' => 'Personal', 'icon' => 'bi-person'];
                    $features = array_filter(array_map('trim', explode("\n", $package->features ?? '')));
                @endphp
                <div class="col-lg-4 col-md-6 pkg-col"
                     data-type="{{ $typeKey }}"
                     data-price="{{ $package->price }}"
                     data-name="{{ strtolower($package->name) }}"
                     data-aos="fade-up"
                     data-aos-delay="{{ ($loop->index % 3) * 70 }}">
                    <div class="pkg-card">
                        <div class="pkg-card-head">
                            <div class="pkg-name">{{ $package->name }}</div>
                            <div class="pkg-price">Rp {{ number_format($package->price, 0, ',', '.') }}</div>
                        </div>
                        <div class="pkg-card-body">
                            <div class="pkg-meta">
                                {{-- Type badge --}}
                                <span class="pkg-type-badge">
                                    <i class="bi {{ $typeInfo['icon'] }}"></i>
                                    {{ $typeInfo['label'] }}
                                </span>
                                {{-- Duration --}}
                                @if($package->duration)
                                <span class="pkg-pill">
                                    <i class="bi bi-clock"></i> {{ $package->duration }} mnt
                                </span>
                                @endif
                                {{-- Participants count --}}
                                @if($package->unlimited_participants)
                                    <span class="pkg-pill"><i class="bi bi-infinity"></i> Unlimited</span>
                                @elseif($package->max_participants)
                                    <span class="pkg-pill">
                                        <i class="bi bi-people"></i>
                                        {{ $package->min_participants == $package->max_participants
                                            ? $package->min_participants . ' org'
                                            : $package->min_participants . '–' . $package->max_participants . ' org' }}
                                    </span>
                                @endif
                            </div>

                            <div class="pkg-participants">
                                <i class="bi bi-person-badge"></i>
                                <span>{{ $package->participants }}</span>
                            </div>

                            <ul class="pkg-features">
                                @foreach(array_slice($features, 0, 5) as $feat)
                                    <li><i class="bi bi-check-circle-fill"></i>{{ $feat }}</li>
                                @endforeach
                                @if(count($features) > 5)
                                    <li style="color:var(--gold);font-size:.76rem;">
                                        <i class="bi bi-plus-circle"></i>
                                        +{{ count($features) - 5 }} keuntungan lainnya
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

            {{-- No results message (injected by JS) --}}
            <div id="no-results" class="pkg-empty" style="display:none;">
                <i class="bi bi-search"></i>
                <p>Tidak ada paket untuk filter ini.</p>
            </div>

        </div>
    </section>

</main>
@endsection

@push('js')
<script>
(function () {
    const grid       = document.getElementById('pkg-grid');
    const noResults  = document.getElementById('no-results');
    const countEl    = document.getElementById('visible-count');
    const sortSelect = document.getElementById('sort-select');
    const filterBtns = document.querySelectorAll('.filter-btn');

    let activeFilter = 'all';
    let activeSort   = 'default';

    /* ── Helpers ─────────────────────────────────── */
    function getCards() {
        return Array.from(grid.querySelectorAll('.pkg-col'));
    }

    function applyFilterAndSort() {
        const cards = getCards();

        // 1. Filter visibility
        cards.forEach(card => {
            const type    = card.dataset.type;
            const visible = activeFilter === 'all' || type === activeFilter;
            card.classList.toggle('hidden', !visible);
        });

        // 2. Sort visible cards
        const visible = cards.filter(c => !c.classList.contains('hidden'));

        visible.sort((a, b) => {
            switch (activeSort) {
                case 'price-asc':  return Number(a.dataset.price) - Number(b.dataset.price);
                case 'price-desc': return Number(b.dataset.price) - Number(a.dataset.price);
                case 'name-asc':   return a.dataset.name.localeCompare(b.dataset.name);
                case 'name-desc':  return b.dataset.name.localeCompare(a.dataset.name);
                default:           return 0;
            }
        });

        // 3. Re-append in sorted order (hidden ones last, preserving DOM)
        const hidden = cards.filter(c => c.classList.contains('hidden'));
        [...visible, ...hidden].forEach(c => grid.appendChild(c));

        // 4. Animate newly visible cards
        visible.forEach((card, i) => {
            card.classList.remove('animate-in');
            void card.offsetWidth; // reflow
            card.style.animationDelay = (i * 55) + 'ms';
            card.classList.add('animate-in');
        });

        // 5. Update count & empty state
        countEl.textContent = visible.length;
        noResults.style.display = visible.length === 0 ? 'block' : 'none';
        grid.style.display      = visible.length === 0 ? 'none'  : '';
    }

    /* ── Filter buttons ──────────────────────────── */
    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            activeFilter = btn.dataset.filter;
            applyFilterAndSort();
        });
    });

    /* ── Sort select ─────────────────────────────── */
    sortSelect.addEventListener('change', () => {
        activeSort = sortSelect.value;
        applyFilterAndSort();
    });

})();
</script>
@endpush