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
    display: inline-block; font-size: .65rem; font-weight: 700;
    letter-spacing: .2em; text-transform: uppercase;
    color: var(--gold); border: 1px solid var(--gold-border);
    padding: 4px 14px; border-radius: 100px; margin-bottom: 16px;
}
.page-hero h1 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.8rem, 4vw, 3rem);
    color: var(--text); font-weight: 700; line-height: 1.15; margin-bottom: 14px;
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
.contact-section { background: var(--bg); padding: 60px 0 100px; }

/* ─── Info cards ─────────────────────────────────────────────── */
.info-cards-row { margin-bottom: 56px; }
.info-card {
    background: var(--card); border: 1px solid var(--border);
    border-radius: 14px; padding: 32px 24px; text-align: center;
    height: 100%; position: relative; overflow: hidden;
    transition: transform .26s, border-color .26s, box-shadow .26s;
}
.info-card::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, transparent, var(--gold), transparent);
    opacity: 0; transition: opacity .26s;
}
.info-card:hover { transform: translateY(-5px); border-color: var(--gold-border); box-shadow: var(--shadow-md); }
.info-card:hover::before { opacity: 1; }
.info-icon {
    width: 56px; height: 56px; background: var(--gold-dim);
    border: 1px solid var(--gold-border); border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 20px; font-size: 1.3rem; color: var(--gold);
}
.info-card h4 {
    font-family: 'Playfair Display', serif;
    font-size: 1rem; font-weight: 700; color: var(--text); margin-bottom: 8px;
}
.info-card p, .info-card a {
    font-size: .875rem; color: var(--muted);
    line-height: 1.65; text-decoration: none; margin: 0; transition: color .25s;
}
.info-card a:hover { color: var(--gold); }
.social-links { display: flex; align-items: center; justify-content: center; gap: 10px; margin-top: 10px; }
.social-link {
    width: 36px; height: 36px; border: 1px solid var(--gold-border); border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: var(--muted); font-size: .9rem; text-decoration: none;
    transition: background .25s, color .25s, border-color .25s;
}
.social-link:hover { background: var(--gold); color: #1a1410; border-color: var(--gold); }

/* ─── Map ────────────────────────────────────────────────────── */
.map-card {
    border-radius: 14px; overflow: hidden;
    border: 1px solid var(--border); height: 100%; min-height: 400px;
}
.map-card iframe { width: 100%; height: 100%; min-height: 400px; border: none; display: block; }
.map-empty {
    display: flex; align-items: center; justify-content: center;
    height: 100%; min-height: 400px; color: var(--muted);
    font-size: .875rem; background: var(--card); text-align: center;
}

/* ─── Form card ──────────────────────────────────────────────── */
.form-card {
    background: var(--card); border: 1px solid var(--border);
    border-radius: 14px; overflow: hidden; height: 100%;
}
.form-card-head {
    padding: 22px 28px; border-bottom: 1px solid var(--border);
    display: flex; align-items: center; gap: 12px;
}
.form-card-head i {
    width: 38px; height: 38px; background: var(--gold-dim);
    border: 1px solid var(--gold-border); border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: var(--gold); font-size: .95rem; flex-shrink: 0;
}
.form-card-head h4 {
    font-family: 'Playfair Display', serif;
    font-size: 1.05rem; font-weight: 700; color: var(--text); margin: 0;
}
.form-card-body { padding: 28px; }

/* ─── Fields ─────────────────────────────────────────────────── */
.field-group { margin-bottom: 20px; }
.field-label {
    display: block; font-size: .7rem; font-weight: 700;
    letter-spacing: .12em; text-transform: uppercase; color: var(--muted); margin-bottom: 7px;
}
.field-label span { color: var(--danger); }
.field-input {
    width: 100%; background: var(--surface); border: 1px solid var(--border);
    border-radius: 10px; padding: 11px 15px;
    font-size: .875rem; color: var(--text);
    outline: none; appearance: none;
    transition: border-color .26s, background .26s;
}
.field-input::placeholder { color: var(--dim); }
.field-input:focus { border-color: var(--gold-border); background: var(--gold-dim); }
.field-input.is-invalid { border-color: rgba(224,92,92,.5); }
textarea.field-input { resize: vertical; min-height: 120px; }
.invalid-msg { font-size: .74rem; color: var(--danger); margin-top: 5px; display: block; }

/* ─── Submit ─────────────────────────────────────────────────── */
.btn-send {
    display: flex; align-items: center; justify-content: center; gap: 9px;
    width: 100%; padding: 13px 0; font-size: .84rem; font-weight: 700;
    letter-spacing: .08em; text-transform: uppercase;
    color: #1a1410; background: var(--gold); border: none; border-radius: 10px; cursor: pointer;
    transition: background .26s, transform .26s, box-shadow .26s;
}
.btn-send:hover { background: var(--gold-light); transform: translateY(-2px); box-shadow: var(--shadow-md); }

/* ─── Alert ──────────────────────────────────────────────────── */
.alert-success-msg {
    background: rgba(76,175,130,.08); border: 1px solid rgba(76,175,130,.25);
    border-radius: 10px; padding: 14px 18px; font-size: .82rem; color: var(--success);
    display: flex; align-items: center; gap: 10px; margin-bottom: 20px;
}
</style>
@endpush

@section('content')
<main id="main">

    <div class="page-hero">
        <div class="container">
            <div class="page-hero-inner" data-aos="fade-up">
                <span class="page-hero-eyebrow"><i class="bi bi-chat-dots me-1"></i> Hubungi Kami</span>
                <h1>Ada yang bisa kami bantu?</h1>
                <p class="page-hero-sub">Kami siap menjawab pertanyaan kamu seputar paket foto, jadwal, atau hal lainnya.</p>
                <div class="page-hero-breadcrumb">
                    <a href="{{ route('home') }}">Beranda</a>
                    <span class="sep">&#9656;</span>
                    <span class="current">Kontak</span>
                </div>
            </div>
        </div>
    </div>

    <section class="contact-section">
        <div class="container">

            {{-- Info cards --}}
            <div class="row g-4 info-cards-row">
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="0">
                    <div class="info-card">
                        <div class="info-icon"><i class="bi bi-geo-alt"></i></div>
                        <h4>Alamat</h4>
                        <p>{{ $web->site_street ?? 'Jl. Fotografi No.1' }},<br>Jambi {{ $web->site_poscod ?? '36000' }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="80">
                    <div class="info-card">
                        <div class="info-icon"><i class="bi bi-envelope"></i></div>
                        <h4>Email</h4>
                        <a href="mailto:{{ $web->site_email ?? 'hello@telegrad.id' }}">{{ $web->site_email ?? 'hello@telegrad.id' }}</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="160">
                    <div class="info-card">
                        <div class="info-icon"><i class="bi bi-whatsapp"></i></div>
                        <h4>WhatsApp</h4>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $web->site_phone ?? '62000') }}" target="_blank">
                            {{ $web->site_phone ?? '+62 xxx xxxx xxxx' }}
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="240">
                    <div class="info-card">
                        <div class="info-icon"><i class="bi bi-instagram"></i></div>
                        <h4>Sosial Media</h4>
                        <div class="social-links">
                            @if($web->instagram ?? null)
                                <a href="{{ $web->instagram }}" target="_blank" class="social-link" title="Instagram"><i class="bi bi-instagram"></i></a>
                            @endif
                            @if($web->tiktok ?? null)
                                <a href="{{ $web->tiktok }}" target="_blank" class="social-link" title="TikTok"><i class="bi bi-tiktok"></i></a>
                            @endif
                            @if($web->facebook ?? null)
                                <a href="{{ $web->facebook }}" target="_blank" class="social-link" title="Facebook"><i class="bi bi-facebook"></i></a>
                            @endif
                        </div>
                        <p class="mt-2" style="font-size:.78rem;">@telegrad__</p>
                    </div>
                </div>
            </div>

            {{-- Map + Form --}}
            <div class="row g-4 align-items-stretch" data-aos="fade-up" data-aos-delay="80">

                <div class="col-lg-6">
                    <div class="map-card">
                        @if($web->site_locate ?? null)
                            {!! $web->site_locate !!}
                        @else
                            <div class="map-empty">
                                <div>
                                    <i class="bi bi-map" style="font-size:2rem;color:var(--gold-border);display:block;margin-bottom:10px;"></i>
                                    Peta belum dikonfigurasi
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-card">
                        <div class="form-card-head">
                            <i class="bi bi-send"></i>
                            <h4>Kirim Pesan</h4>
                        </div>
                        <div class="form-card-body">

                            @if(session('success'))
                                <div class="alert-success-msg">
                                    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                                </div>
                            @endif

                            <form action="{{ route('contact.store') }}" method="POST" id="contact-form">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="field-group">
                                            <label class="field-label">Nama <span>*</span></label>
                                            <input type="text" name="name"
                                                   class="field-input @error('name') is-invalid @enderror"
                                                   placeholder="Nama lengkap kamu"
                                                   value="{{ Auth::user()->name ?? old('name') }}" required>
                                            @error('name')<span class="invalid-msg">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="field-group">
                                            <label class="field-label">Email <span>*</span></label>
                                            <input type="email" name="email"
                                                   class="field-input @error('email') is-invalid @enderror"
                                                   placeholder="email@kamu.com"
                                                   value="{{ Auth::user()->email ?? old('email') }}" required>
                                            @error('email')<span class="invalid-msg">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="field-group">
                                            <label class="field-label">Subjek <span>*</span></label>
                                            <input type="text" name="subject"
                                                   class="field-input @error('subject') is-invalid @enderror"
                                                   placeholder="Perihal pesan kamu"
                                                   value="{{ old('subject') }}" required>
                                            @error('subject')<span class="invalid-msg">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="field-group">
                                            <label class="field-label">Pesan <span>*</span></label>
                                            <textarea name="message"
                                                      class="field-input @error('message') is-invalid @enderror"
                                                      placeholder="Tulis pertanyaan atau pesanmu di sini..."
                                                      required>{{ old('message') }}</textarea>
                                            @error('message')<span class="invalid-msg">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn-send" id="send-btn">
                                            <i class="bi bi-send"></i> Kirim Pesan
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>
@endsection

@push('js')
<script>
document.getElementById('contact-form').addEventListener('submit', function () {
    const btn = document.getElementById('send-btn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Mengirim...';
});
</script>
@endpush