@extends('base.base-root-index')

@push('css')
<style>
:root {
    --gold:        #c8a96e;
    --gold-light:  #e2c98a;
    --gold-dim:    rgba(200,169,110,.12);
    --gold-border: rgba(200,169,110,.22);
    --bg-page:     #0d0d0d;
    --bg-card:     #141414;
    --text:        #f0ece4;
    --muted:       #8a8070;
    --success:     #4caf82;
    --danger:      #e05c5c;
    --radius:      14px;
    --trans:       .26s cubic-bezier(.4,0,.2,1);
}

.checkout-section {
    background: var(--bg-page);
    padding: 64px 0 100px;
}

/* ─── Page title ────────────────────────────────────────────── */
.checkout-heading {
    margin-bottom: 40px;
}
.checkout-label {
    display: inline-block;
    font-size: .68rem; font-weight: 700;
    letter-spacing: .18em; text-transform: uppercase;
    color: var(--gold); border: 1px solid var(--gold-border);
    padding: 4px 14px; border-radius: 100px;
    margin-bottom: 14px;
}
.checkout-heading h2 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.6rem, 3vw, 2.2rem);
    color: var(--text); font-weight: 700;
    margin-bottom: 6px; line-height: 1.25;
}
.checkout-heading p {
    font-size: .88rem; color: var(--muted);
    line-height: 1.7;
}

/* ─── Steps indicator ───────────────────────────────────────── */
.steps-bar {
    display: flex; align-items: center;
    gap: 0; margin-bottom: 48px;
}
.step-item {
    display: flex; align-items: center; gap: 10px;
    font-size: .75rem; font-weight: 600;
    letter-spacing: .06em; text-transform: uppercase;
    color: var(--muted);
}
.step-item.active { color: var(--gold-light); }
.step-item.done   { color: var(--success); }
.step-num {
    width: 28px; height: 28px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .75rem; font-weight: 700;
    border: 1px solid rgba(255,255,255,.12);
    color: var(--muted); flex-shrink: 0;
}
.step-item.active .step-num {
    background: var(--gold); color: #0d0d0d; border-color: var(--gold);
}
.step-item.done .step-num {
    background: var(--success); color: #fff; border-color: var(--success);
}
.step-line {
    flex: 1; height: 1px; margin: 0 12px;
    background: rgba(255,255,255,.08);
}

/* ─── Form card ─────────────────────────────────────────────── */
.form-card {
    background: var(--bg-card);
    border: 1px solid rgba(255,255,255,.07);
    border-radius: var(--radius);
    overflow: hidden;
    margin-bottom: 24px;
}
.form-card-head {
    padding: 18px 28px;
    border-bottom: 1px solid rgba(255,255,255,.06);
    display: flex; align-items: center; gap: 12px;
}
.form-card-head i {
    width: 36px; height: 36px;
    background: var(--gold-dim);
    border: 1px solid var(--gold-border);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: var(--gold); font-size: .9rem; flex-shrink: 0;
}
.form-card-head h5 {
    font-family: 'Playfair Display', serif;
    font-size: 1rem; font-weight: 700;
    color: var(--text); margin: 0;
}
.form-card-body { padding: 28px; }

/* ─── Form fields ───────────────────────────────────────────── */
.field-group { margin-bottom: 22px; }
.field-group:last-child { margin-bottom: 0; }

.field-label {
    display: block;
    font-size: .72rem; font-weight: 700;
    letter-spacing: .1em; text-transform: uppercase;
    color: var(--muted); margin-bottom: 8px;
}
.field-label span { color: var(--danger); margin-left: 2px; }

.field-input {
    width: 100%;
    background: rgba(255,255,255,.04);
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 10px;
    padding: 12px 16px;
    font-size: .875rem; color: var(--text);
    transition: border-color var(--trans), background var(--trans);
    outline: none;
    appearance: none;
}
.field-input::placeholder { color: var(--muted); }
.field-input:focus {
    border-color: var(--gold-border);
    background: rgba(200,169,110,.05);
}

select.field-input { cursor: pointer; }
textarea.field-input { resize: vertical; min-height: 100px; }

.field-hint {
    font-size: .74rem; color: var(--muted);
    margin-top: 6px; line-height: 1.5;
    display: flex; align-items: flex-start; gap: 5px;
}
.field-hint i { color: var(--gold); margin-top: 1px; flex-shrink: 0; }

/* ─── Time display (auto-calc) ──────────────────────────────── */
.time-result {
    display: flex; align-items: center; gap: 16px;
    background: rgba(200,169,110,.06);
    border: 1px solid var(--gold-border);
    border-radius: 10px;
    padding: 12px 16px;
    font-size: .82rem; color: var(--muted);
    margin-top: 8px;
}
.time-result i { color: var(--gold); }
.time-result strong { color: var(--gold-light); }

/* ─── Sidebar: Order summary ────────────────────────────────── */
.summary-card {
    background: var(--bg-card);
    border: 1px solid var(--gold-border);
    border-radius: var(--radius);
    overflow: hidden;
    position: sticky;
    top: 90px;
}
.summary-head {
    background: linear-gradient(135deg, #1a1408, #111);
    border-bottom: 1px solid var(--gold-border);
    padding: 22px 24px;
    text-align: center;
}
.summary-head .s-label {
    font-size: .68rem; font-weight: 700;
    letter-spacing: .15em; text-transform: uppercase;
    color: var(--muted); margin-bottom: 4px;
}
.summary-head .s-name {
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem; font-weight: 700;
    color: var(--text); line-height: 1.3;
}
.summary-head .s-cat {
    font-size: .75rem; color: var(--gold);
    margin-top: 4px;
}
.summary-body { padding: 20px 24px; }

.s-row {
    display: flex; justify-content: space-between; align-items: flex-start;
    gap: 12px; padding: 10px 0;
    border-bottom: 1px solid rgba(255,255,255,.05);
    font-size: .82rem;
}
.s-row:last-of-type { border-bottom: none; }
.s-key { color: var(--muted); display: flex; align-items: center; gap: 7px; }
.s-key i { color: var(--gold); width: 14px; }
.s-val { color: var(--text); font-weight: 500; text-align: right; }

/* ─── Feature quick-list in sidebar ────────────────────────── */
.s-features {
    list-style: none; padding: 0; margin: 0;
    display: flex; flex-direction: column; gap: 6px;
}
.s-features li {
    font-size: .78rem; color: var(--muted);
    display: flex; align-items: flex-start; gap: 7px; line-height: 1.5;
}
.s-features li i { color: var(--success); flex-shrink: 0; margin-top: 2px; }

/* ─── Total & submit ────────────────────────────────────────── */
.s-total {
    background: rgba(200,169,110,.06);
    border: 1px solid var(--gold-border);
    border-radius: 10px;
    padding: 16px 20px;
    display: flex; justify-content: space-between; align-items: center;
    margin-top: 16px;
}
.s-total-label {
    font-size: .72rem; font-weight: 700;
    letter-spacing: .1em; text-transform: uppercase;
    color: var(--muted);
}
.s-total-price {
    font-family: 'Playfair Display', serif;
    font-size: 1.4rem; font-weight: 800;
    color: var(--gold-light);
}

.btn-submit {
    display: flex; align-items: center; justify-content: center; gap: 9px;
    width: 100%; padding: 14px 0;
    font-size: .85rem; font-weight: 700;
    letter-spacing: .08em; text-transform: uppercase;
    color: #0d0d0d; background: var(--gold);
    border: none; border-radius: 10px; cursor: pointer;
    transition: background var(--trans), transform var(--trans), box-shadow var(--trans);
    margin-top: 14px;
}
.btn-submit:hover {
    background: var(--gold-light);
    transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(200,169,110,.25);
}

.secure-note {
    text-align: center; font-size: .72rem;
    color: var(--muted); margin-top: 10px;
    display: flex; align-items: center; justify-content: center; gap: 5px;
}
.secure-note i { color: var(--gold); }

/* ─── Alert ─────────────────────────────────────────────────── */
.alert-gold {
    background: rgba(200,169,110,.08);
    border: 1px solid var(--gold-border);
    border-radius: 10px; padding: 14px 18px;
    font-size: .82rem; color: var(--muted);
    display: flex; align-items: flex-start; gap: 10px;
    margin-bottom: 24px;
}
.alert-gold i { color: var(--gold); flex-shrink: 0; margin-top: 1px; }
.alert-danger {
    background: rgba(224,92,92,.08);
    border: 1px solid rgba(224,92,92,.3);
    border-radius: 10px; padding: 14px 18px;
    font-size: .82rem; color: #f08080;
    display: flex; align-items: flex-start; gap: 10px;
    margin-bottom: 24px;
}
.alert-danger i { color: var(--danger); flex-shrink: 0; margin-top: 1px; }

/* ─── Error state ───────────────────────────────────────────── */
.field-input.is-invalid { border-color: rgba(224,92,92,.5); }
.invalid-msg {
    font-size: .74rem; color: var(--danger);
    margin-top: 5px;
}
</style>
@endpush

@section('content')
<main id="main">

    {{-- ======= Breadcrumb ======= --}}
    <div class="breadcrumbs d-flex align-items-center"
         style="background-image: url('{{ asset('root/assets/img/breadcrumbs-bg.jpg') }}');">
        <div class="container position-relative d-flex flex-column align-items-center text-center" data-aos="fade">
            <h2>Booking Paket</h2>
            <ol>
                <li><a href="{{ route('home') }}">Beranda</a></li>
                <li><a href="{{ route('packages.categories') }}">Paket</a></li>
                @if($package->category)
                    <li><a href="{{ route('packages.byCategory', $package->category->slug) }}">{{ $package->category->name }}</a></li>
                @endif
                <li>Booking</li>
            </ol>
        </div>
    </div>

    {{-- ======= Checkout Section ======= --}}
    <section class="checkout-section">
        <div class="container">

            {{-- Steps --}}
            <div class="steps-bar" data-aos="fade-up">
                <div class="step-item active">
                    <div class="step-num">1</div>
                    <span class="d-none d-sm-block">Isi Data</span>
                </div>
                <div class="step-line"></div>
                <div class="step-item">
                    <div class="step-num">2</div>
                    <span class="d-none d-sm-block">Pembayaran</span>
                </div>
                <div class="step-line"></div>
                <div class="step-item">
                    <div class="step-num">3</div>
                    <span class="d-none d-sm-block">Konfirmasi</span>
                </div>
            </div>

            {{-- Heading --}}
            <div class="checkout-heading" data-aos="fade-up">
                <span class="checkout-label">
                    <i class="bi bi-calendar-check me-1"></i> Pemesanan
                </span>
                <h2>Isi Data Booking</h2>
                <p>Lengkapi detail jadwal sesi foto kamu. Pastikan tanggal dan waktu sudah sesuai.</p>
            </div>

            {{-- Flash messages --}}
            @if(session('error'))
                <div class="alert-danger" data-aos="fade-up">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif
            @if(session('success'))
                <div class="alert-gold" data-aos="fade-up">
                    <i class="bi bi-check-circle-fill"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            <form action="{{ route('booking.store') }}" method="POST" id="booking-form">
                @csrf
                <input type="hidden" name="package_id" value="{{ $package->id }}">

                <div class="row g-4 align-items-start">

                    {{-- ───── LEFT: Form ───── --}}
                    <div class="col-lg-8">

                        {{-- 1. Jadwal --}}
                        <div class="form-card" data-aos="fade-up">
                            <div class="form-card-head">
                                <i class="bi bi-calendar3"></i>
                                <h5>Jadwal Sesi</h5>
                            </div>
                            <div class="form-card-body">

                                <div class="row g-3">
                                    {{-- Tanggal --}}
                                    <div class="col-md-6">
                                        <div class="field-group">
                                            <label class="field-label" for="booking_date">
                                                Tanggal Sesi <span>*</span>
                                            </label>
                                            <input type="date"
                                                   id="booking_date"
                                                   name="booking_date"
                                                   class="field-input @error('booking_date') is-invalid @enderror"
                                                   value="{{ old('booking_date') }}"
                                                   min="{{ now()->addDay()->format('Y-m-d') }}"
                                                   required>
                                            @error('booking_date')
                                                <div class="invalid-msg">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Jam mulai --}}
                                    <div class="col-md-6">
                                        <div class="field-group">
                                            <label class="field-label" for="start_time">
                                                Jam Mulai <span>*</span>
                                            </label>
                                            <input type="time"
                                                   id="start_time"
                                                   name="start_time"
                                                   class="field-input @error('start_time') is-invalid @enderror"
                                                   value="{{ old('start_time', '08:00') }}"
                                                   min="06:00" max="17:00"
                                                   required>
                                            @error('start_time')
                                                <div class="invalid-msg">{{ $message }}</div>
                                            @enderror
                                            <div class="field-hint">
                                                <i class="bi bi-info-circle"></i>
                                                Tersedia pukul 06.00–17.00
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Estimasi selesai (auto-calc) --}}
                                <div class="time-result" id="time-result">
                                    <i class="bi bi-clock-history"></i>
                                    <span>
                                        Durasi paket: <strong>{{ $package->duration ?? 60 }} menit</strong> &nbsp;|&nbsp;
                                        Estimasi selesai: <strong id="end-time-display">—</strong>
                                    </span>
                                </div>

                            </div>
                        </div>

                        {{-- 2. Lokasi --}}
                        <div class="form-card" data-aos="fade-up" data-aos-delay="60">
                            <div class="form-card-head">
                                <i class="bi bi-geo-alt"></i>
                                <h5>Lokasi Pemotretan</h5>
                            </div>
                            <div class="form-card-body">
                                <div class="field-group">
                                    <label class="field-label" for="location">
                                        Lokasi / Tempat <span>*</span>
                                    </label>
                                    <input type="text"
                                           id="location"
                                           name="location"
                                           class="field-input @error('location') is-invalid @enderror"
                                           placeholder="Contoh: Gedung Rektorat UNJA, Taman Anggrek..."
                                           value="{{ old('location') }}"
                                           required>
                                    @error('location')
                                        <div class="invalid-msg">{{ $message }}</div>
                                    @enderror
                                    <div class="field-hint">
                                        <i class="bi bi-info-circle"></i>
                                        Tuliskan nama tempat + lokasi spesifik agar fotografer bisa langsung menemukan kamu.
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 3. Catatan --}}
                        <div class="form-card" data-aos="fade-up" data-aos-delay="100">
                            <div class="form-card-head">
                                <i class="bi bi-chat-text"></i>
                                <h5>Catatan Tambahan</h5>
                            </div>
                            <div class="form-card-body">
                                <div class="field-group">
                                    <label class="field-label" for="notes">
                                        Catatan / Request
                                    </label>
                                    <textarea id="notes"
                                              name="notes"
                                              class="field-input @error('notes') is-invalid @enderror"
                                              placeholder="Contoh: moodboard referensi, warna outfit, request pose khusus, dll...">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-msg">{{ $message }}</div>
                                    @enderror
                                    <div class="field-hint">
                                        <i class="bi bi-info-circle"></i>
                                        Opsional. Semakin detail request kamu, semakin terarah sesi fotonya.
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 4. Info user (read-only) --}}
                        <div class="form-card" data-aos="fade-up" data-aos-delay="130">
                            <div class="form-card-head">
                                <i class="bi bi-person-check"></i>
                                <h5>Data Pemesan</h5>
                            </div>
                            <div class="form-card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="field-group">
                                            <label class="field-label">Nama</label>
                                            <input type="text"
                                                   class="field-input"
                                                   value="{{ Auth::user()->name }}"
                                                   readonly style="opacity:.6; cursor:not-allowed;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="field-group">
                                            <label class="field-label">Email</label>
                                            <input type="text"
                                                   class="field-input"
                                                   value="{{ Auth::user()->email }}"
                                                   readonly style="opacity:.6; cursor:not-allowed;">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    <div class="field-group">
                                        <label class="field-label" for="phone">
                                            No. HP / WhatsApp <span>*</span>
                                        </label>
                                        <input type="tel"
                                            id="phone"
                                            name="phone"
                                            class="field-input @error('phone') is-invalid @enderror"
                                            placeholder="Contoh: 08123456789"
                                            value="{{ old('phone', Auth::user()->phone) }}"
                                            required>
                                        @error('phone')
                                            <div class="invalid-msg">{{ $message }}</div>
                                        @enderror
                                        <div class="field-hint">
                                            <i class="bi bi-whatsapp"></i>
                                            Admin akan menghubungi kamu lewat nomor ini.
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div class="field-hint mt-2">
                                    <i class="bi bi-lock"></i>
                                    Data diambil dari akun kamu. Jika perlu diubah, edit di halaman profil.
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- ───── RIGHT: Summary ───── --}}
                    <div class="col-lg-4" data-aos="fade-left">
                        <div class="summary-card">

                            <div class="summary-head">
                                <div class="s-label">Ringkasan Paket</div>
                                <div class="s-name">{{ $package->name }}</div>
                                @if($package->category)
                                    <div class="s-cat">{{ $package->category->name }}</div>
                                @endif
                            </div>

                            <div class="summary-body">

                                {{-- Package details --}}
                                <div class="s-row">
                                    <span class="s-key"><i class="bi bi-clock"></i> Durasi</span>
                                    <span class="s-val">{{ $package->duration ?? '-' }} menit</span>
                                </div>
                                <div class="s-row">
                                    <span class="s-key"><i class="bi bi-people"></i> Peserta</span>
                                    <span class="s-val">
                                        @if($package->unlimited_participants)
                                            Tidak Dibatasi
                                        @elseif($package->min_participants == $package->max_participants)
                                            {{ $package->min_participants }} Orang
                                        @else
                                            {{ $package->min_participants }}–{{ $package->max_participants }} Orang
                                        @endif
                                    </span>
                                </div>
                                <div class="s-row">
                                    <span class="s-key"><i class="bi bi-folder2-open"></i> File</span>
                                    <span class="s-val">Google Drive</span>
                                </div>

                                {{-- Features --}}
                                @php $feats = array_filter(explode("\n", $package->features ?? '')); @endphp
                                @if(count($feats))
                                <div class="s-row" style="flex-direction:column; align-items:flex-start; gap:10px;">
                                    <span class="s-key"><i class="bi bi-stars"></i> Yang Didapat</span>
                                    <ul class="s-features">
                                        @foreach(array_slice($feats, 0, 6) as $f)
                                            <li>
                                                <i class="bi bi-check-circle-fill"></i>
                                                {{ trim($f) }}
                                            </li>
                                        @endforeach
                                        @if(count($feats) > 6)
                                            <li style="color:var(--gold);">
                                                <i class="bi bi-plus-circle"></i>
                                                +{{ count($feats) - 6 }} lainnya
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                                @endif

                                {{-- Total --}}
                                <div class="s-total">
                                    <div class="s-total-label">Total Bayar</div>
                                    <div class="s-total-price">
                                        Rp {{ number_format($package->price, 0, ',', '.') }}
                                    </div>
                                </div>

                                {{-- Submit --}}
                                <button type="submit" class="btn-submit">
                                    <i class="bi bi-calendar-check"></i>
                                    Konfirmasi Booking
                                </button>

                                <div class="secure-note">
                                    <i class="bi bi-shield-lock"></i>
                                    Data kamu aman & terenkripsi
                                </div>

                                {{-- Cancel back --}}
                                <div class="text-center mt-3">
                                    <a href="{{ route('packages.detail', $package->id) }}"
                                       style="font-size:.78rem; color:var(--muted); text-decoration:none;">
                                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Detail Paket
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </section>

</main>
@endsection

@push('js')
<script>
// ─── Auto-calc end time ─────────────────────────────────────────
const duration = {{ $package->duration ?? 60 }};

function updateEndTime() {
    const dateVal  = document.getElementById('booking_date').value;
    const timeVal  = document.getElementById('start_time').value;
    const display  = document.getElementById('end-time-display');

    if (!timeVal) { display.textContent = '—'; return; }

    const [h, m] = timeVal.split(':').map(Number);
    const start  = new Date(2000, 0, 1, h, m);
    const end    = new Date(start.getTime() + duration * 60000);

    const hh = String(end.getHours()).padStart(2, '0');
    const mm = String(end.getMinutes()).padStart(2, '0');
    display.textContent = `${hh}.${mm} WIB`;
}

document.getElementById('start_time').addEventListener('input', updateEndTime);
document.getElementById('booking_date').addEventListener('change', updateEndTime);
updateEndTime();

// ─── Prevent double-submit ──────────────────────────────────────
document.getElementById('booking-form').addEventListener('submit', function () {
    const btn = this.querySelector('.btn-submit');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Memproses...';
});
</script>
@endpush