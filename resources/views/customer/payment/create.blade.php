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
    --warning:     #e0a935;
    --radius:      14px;
    --trans:       .26s cubic-bezier(.4,0,.2,1);
}

.payment-section { background: var(--bg-page); padding: 64px 0 100px; }

/* ─── Steps ──────────────────────────────────────────────────── */
.steps-bar { display: flex; align-items: center; margin-bottom: 48px; }
.step-item {
    display: flex; align-items: center; gap: 10px;
    font-size: .75rem; font-weight: 600;
    letter-spacing: .06em; text-transform: uppercase;
    color: var(--muted);
}
.step-item.done  { color: var(--success); }
.step-item.active { color: var(--gold-light); }
.step-num {
    width: 28px; height: 28px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .75rem; font-weight: 700;
    border: 1px solid rgba(255,255,255,.12);
    color: var(--muted); flex-shrink: 0;
}
.step-item.done .step-num   { background: var(--success); color: #fff; border-color: var(--success); }
.step-item.active .step-num { background: var(--gold); color: #0d0d0d; border-color: var(--gold); }
.step-line { flex: 1; height: 1px; margin: 0 12px; background: rgba(255,255,255,.08); }

/* ─── Heading ────────────────────────────────────────────────── */
.pay-heading { margin-bottom: 36px; }
.pay-label {
    display: inline-block;
    font-size: .68rem; font-weight: 700;
    letter-spacing: .18em; text-transform: uppercase;
    color: var(--gold); border: 1px solid var(--gold-border);
    padding: 4px 14px; border-radius: 100px; margin-bottom: 14px;
}
.pay-heading h2 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.6rem, 3vw, 2.2rem);
    color: var(--text); font-weight: 700;
    margin-bottom: 6px; line-height: 1.25;
}
.pay-heading p { font-size: .88rem; color: var(--muted); line-height: 1.7; }

/* ─── Cards ──────────────────────────────────────────────────── */
.pay-card {
    background: var(--bg-card);
    border: 1px solid rgba(255,255,255,.07);
    border-radius: var(--radius);
    overflow: hidden; margin-bottom: 20px;
}
.pay-card-head {
    padding: 18px 24px;
    border-bottom: 1px solid rgba(255,255,255,.06);
    display: flex; align-items: center; gap: 12px;
}
.pay-card-head i {
    width: 36px; height: 36px;
    background: var(--gold-dim); border: 1px solid var(--gold-border);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: var(--gold); font-size: .9rem; flex-shrink: 0;
}
.pay-card-head h5 {
    font-family: 'Playfair Display', serif;
    font-size: 1rem; font-weight: 700;
    color: var(--text); margin: 0;
}
.pay-card-body { padding: 24px; }

/* ─── Payment method tabs ────────────────────────────────────── */
.method-tabs { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 24px; }
.method-tab {
    flex: 1; min-width: 140px;
    background: rgba(255,255,255,.04);
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 10px;
    padding: 14px 16px;
    text-align: center; cursor: pointer;
    transition: all var(--trans);
}
.method-tab:hover { border-color: var(--gold-border); background: var(--gold-dim); }
.method-tab.active {
    border-color: var(--gold);
    background: var(--gold-dim);
    box-shadow: 0 0 0 1px var(--gold-border);
}
.method-tab i { font-size: 1.4rem; color: var(--gold); display: block; margin-bottom: 8px; }
.method-tab span { font-size: .78rem; font-weight: 600; color: var(--text); }

/* ─── Payment info box ───────────────────────────────────────── */
.payment-info-box {
    background: rgba(200,169,110,.06);
    border: 1px solid var(--gold-border);
    border-radius: 10px;
    padding: 18px 20px;
    margin-bottom: 20px;
}
.payment-info-box .info-title {
    font-size: .72rem; font-weight: 700;
    letter-spacing: .12em; text-transform: uppercase;
    color: var(--muted); margin-bottom: 12px;
}
.payment-info-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid rgba(255,255,255,.05);
    font-size: .85rem;
}
.payment-info-row:last-child { border-bottom: none; padding-bottom: 0; }
.payment-info-row .key { color: var(--muted); display: flex; align-items: center; gap: 7px; }
.payment-info-row .key i { color: var(--gold); }
.payment-info-row .val { color: var(--text); font-weight: 600; }
.payment-info-row .val.amount {
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem; color: var(--gold-light);
}

/* ─── Upload area ────────────────────────────────────────────── */
.upload-area {
    border: 2px dashed rgba(255,255,255,.1);
    border-radius: 12px;
    padding: 36px 20px;
    text-align: center;
    cursor: pointer;
    transition: border-color var(--trans), background var(--trans);
    position: relative;
}
.upload-area:hover, .upload-area.drag-over {
    border-color: var(--gold-border);
    background: var(--gold-dim);
}
.upload-area input[type="file"] {
    position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%;
}
.upload-icon { font-size: 2.5rem; color: var(--gold-border); margin-bottom: 12px; display: block; transition: color var(--trans); }
.upload-area:hover .upload-icon { color: var(--gold); }
.upload-area .upload-text { font-size: .875rem; color: var(--muted); line-height: 1.6; }
.upload-area .upload-text strong { color: var(--gold); }
.upload-area .upload-hint { font-size: .75rem; color: var(--muted); margin-top: 6px; }

/* Preview image */
.preview-wrap {
    display: none;
    margin-top: 16px;
    border-radius: 10px; overflow: hidden;
    border: 1px solid var(--gold-border);
    position: relative;
}
.preview-wrap img { width: 100%; max-height: 260px; object-fit: contain; background: #0a0a0a; display: block; }
.preview-remove {
    position: absolute; top: 8px; right: 8px;
    width: 30px; height: 30px; border-radius: 50%;
    background: rgba(224,92,92,.85); border: none;
    color: #fff; font-size: .8rem; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background var(--trans);
}
.preview-remove:hover { background: var(--danger); }

.invalid-msg { font-size: .74rem; color: var(--danger); margin-top: 6px; display: block; }

/* ─── Alert ──────────────────────────────────────────────────── */
.alert-danger-custom {
    background: rgba(224,92,92,.08);
    border: 1px solid rgba(224,92,92,.3);
    border-radius: 10px; padding: 14px 18px;
    font-size: .82rem; color: #f08080;
    display: flex; align-items: flex-start; gap: 10px;
    margin-bottom: 24px;
}
.alert-danger-custom i { flex-shrink: 0; }

/* ─── Sidebar order summary ──────────────────────────────────── */
.order-summary {
    background: var(--bg-card);
    border: 1px solid var(--gold-border);
    border-radius: var(--radius);
    overflow: hidden;
    position: sticky; top: 90px;
}
.os-head {
    background: linear-gradient(135deg, #1a1408, #111);
    border-bottom: 1px solid var(--gold-border);
    padding: 20px 24px; text-align: center;
}
.os-head .os-label { font-size: .68rem; font-weight: 700; letter-spacing: .15em; text-transform: uppercase; color: var(--muted); margin-bottom: 4px; }
.os-head .os-name { font-family: 'Playfair Display', serif; font-size: 1.05rem; font-weight: 700; color: var(--text); line-height: 1.3; }
.os-head .os-cat  { font-size: .75rem; color: var(--gold); margin-top: 4px; }
.os-body { padding: 18px 24px; }

.os-row {
    display: flex; justify-content: space-between; align-items: flex-start;
    gap: 10px; padding: 9px 0;
    border-bottom: 1px solid rgba(255,255,255,.05);
    font-size: .82rem;
}
.os-row:last-of-type { border-bottom: none; }
.os-key { color: var(--muted); display: flex; align-items: center; gap: 7px; flex-shrink: 0; }
.os-key i { color: var(--gold); width: 14px; }
.os-val { color: var(--text); font-weight: 500; text-align: right; }

/* Status badge */
.status-badge {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: .72rem; font-weight: 700;
    padding: 4px 10px; border-radius: 100px;
    text-transform: uppercase; letter-spacing: .06em;
}
.status-pending   { background: rgba(224,169,53,.12); border: 1px solid rgba(224,169,53,.3); color: var(--warning); }
.status-confirmed { background: rgba(76,175,130,.12); border: 1px solid rgba(76,175,130,.3); color: var(--success); }

/* Total */
.os-total {
    background: rgba(200,169,110,.06);
    border: 1px solid var(--gold-border);
    border-radius: 10px; padding: 14px 18px;
    display: flex; justify-content: space-between; align-items: center;
    margin-top: 12px;
}
.os-total-label { font-size: .72rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--muted); }
.os-total-price { font-family: 'Playfair Display', serif; font-size: 1.3rem; font-weight: 800; color: var(--gold-light); }

/* Submit */
.btn-pay-submit {
    display: flex; align-items: center; justify-content: center; gap: 9px;
    width: 100%; padding: 13px 0;
    font-size: .84rem; font-weight: 700;
    letter-spacing: .08em; text-transform: uppercase;
    color: #0d0d0d; background: var(--gold);
    border: none; border-radius: 10px; cursor: pointer;
    transition: background var(--trans), transform var(--trans), box-shadow var(--trans);
    margin-top: 14px;
}
.btn-pay-submit:hover {
    background: var(--gold-light); transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(200,169,110,.25);
}
.btn-pay-submit:disabled { opacity: .6; pointer-events: none; }

.secure-note {
    text-align: center; font-size: .72rem;
    color: var(--muted); margin-top: 10px;
    display: flex; align-items: center; justify-content: center; gap: 5px;
}
.secure-note i { color: var(--gold); }

/* ─── QRIS / Rekening info ───────────────────────────────────── */
.bank-info-wrap {
    background: rgba(255,255,255,.03);
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 10px; padding: 16px 20px;
    font-size: .85rem;
}
.bank-info-wrap .bank-name { font-weight: 700; color: var(--text); margin-bottom: 6px; }
.bank-info-wrap .bank-num  { font-family: monospace; font-size: 1.05rem; color: var(--gold-light); letter-spacing: .1em; }
.bank-info-wrap .bank-owner { font-size: .78rem; color: var(--muted); margin-top: 4px; }
.copy-btn {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: .74rem; color: var(--gold);
    background: var(--gold-dim); border: 1px solid var(--gold-border);
    padding: 4px 12px; border-radius: 100px; cursor: pointer;
    border: none; margin-top: 10px; transition: background var(--trans);
}
.copy-btn:hover { background: rgba(200,169,110,.2); }
</style>
@endpush

@section('content')
<main id="main">

    {{-- ======= Breadcrumb ======= --}}
    <div class="breadcrumbs d-flex align-items-center"
         style="background-image: url('{{ asset('root/assets/img/breadcrumbs-bg.jpg') }}');">
        <div class="container position-relative d-flex flex-column align-items-center text-center" data-aos="fade">
            <h2>Pembayaran</h2>
            <ol>
                <li><a href="{{ route('home') }}">Beranda</a></li>
                <li><a href="{{ route('customer.orders') }}">My Orders</a></li>
                <li>Pembayaran</li>
            </ol>
        </div>
    </div>

    <section class="payment-section">
        <div class="container">

            {{-- Steps --}}
            <div class="steps-bar" data-aos="fade-up">
                <div class="step-item done">
                    <div class="step-num"><i class="bi bi-check"></i></div>
                    <span class="d-none d-sm-block">Isi Data</span>
                </div>
                <div class="step-line"></div>
                <div class="step-item active">
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
            <div class="pay-heading" data-aos="fade-up">
                <span class="pay-label"><i class="bi bi-credit-card me-1"></i> Pembayaran</span>
                <h2>Upload Bukti Pembayaran</h2>
                <p>Lakukan transfer ke rekening di bawah, lalu upload bukti pembayaranmu.</p>
            </div>

            {{-- Flash --}}
            @if(session('error'))
                <div class="alert-danger-custom" data-aos="fade-up">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            <form action="{{ route('customer.payment.store') }}" method="POST" enctype="multipart/form-data" id="payment-form">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <input type="hidden" name="payment_method" id="payment_method_input" value="transfer">

                <div class="row g-4 align-items-start">

                    {{-- ───── LEFT ───── --}}
                    <div class="col-lg-8">

                        {{-- Payment method --}}
                        <div class="pay-card" data-aos="fade-up">
                            <div class="pay-card-head">
                                <i class="bi bi-wallet2"></i>
                                <h5>Pilih Metode Pembayaran</h5>
                            </div>
                            <div class="pay-card-body">
                                <div class="method-tabs">
                                    <div class="method-tab active" data-method="transfer" onclick="selectMethod(this)">
                                        <i class="bi bi-bank"></i>
                                        <span>Transfer Bank</span>
                                    </div>
                                    <div class="method-tab" data-method="qris" onclick="selectMethod(this)">
                                        <i class="bi bi-qr-code-scan"></i>
                                        <span>QRIS</span>
                                    </div>
                                    <div class="method-tab" data-method="cash" onclick="selectMethod(this)">
                                        <i class="bi bi-cash-coin"></i>
                                        <span>Cash / COD</span>
                                    </div>
                                </div>

                                {{-- Transfer info --}}
                                <div id="info-transfer">
                                    @if($web->bank_name || $web->bank_account_number)
                                    <div class="bank-info-wrap">
                                        <div class="bank-name">{{ $web->bank_name ?? 'Nama Bank' }}</div>
                                        <div class="bank-num" id="rek-number">
                                            {{ $web->bank_account_number ?? '-' }}
                                        </div>
                                        <div class="bank-owner">a.n. {{ $web->bank_account_name ?? '-' }}</div>
                                        <button type="button" class="copy-btn" onclick="copyRek()">
                                            <i class="bi bi-clipboard"></i> Salin Nomor Rekening
                                        </button>
                                    </div>
                                    @else
                                    <div class="bank-info-wrap">
                                        <p style="font-size:.82rem; color:var(--muted); text-align:center; padding:8px 0;">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Info rekening belum dikonfigurasi admin.
                                        </p>
                                    </div>
                                    @endif
                                </div>

                                {{-- QRIS info --}}
                                <div id="info-qris" style="display:none;">
                                    <div class="bank-info-wrap text-center">
                                        <div class="bank-name mb-3">Scan QRIS Berikut</div>
                                        @if($web->site_qris && $web->site_qris !== 'site_qris.png')
                                            <img src="{{ asset('storage/images/default/' . $web->site_qris) }}"
                                                 alt="QRIS"
                                                 style="max-width:220px; border-radius:10px; border:1px solid var(--gold-border);">
                                            <p style="font-size:.76rem; color:var(--muted); margin-top:10px;">
                                                Screenshot atau scan QR di atas, lalu upload bukti pembayaran.
                                            </p>
                                        @else
                                            <p style="font-size:.82rem; color:var(--muted);">
                                                <i class="bi bi-qr-code" style="font-size:3rem; color:var(--gold-border); display:block; margin-bottom:8px;"></i>
                                                QRIS belum dikonfigurasi admin.
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                {{-- Cash info --}}
                                <div id="info-cash" style="display:none;">
                                    <div class="bank-info-wrap">
                                        <div class="bank-name">Pembayaran Cash / COD</div>
                                        <p style="font-size:.82rem; color:var(--muted); margin-top:8px; line-height:1.7;">
                                            Bayar langsung di lokasi sesi foto. Pastikan kamu membawa uang tunai sesuai total pembayaran.
                                            Upload foto konfirmasi (screenshot chat / nota) sebagai bukti.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Upload bukti --}}
                        <div class="pay-card" data-aos="fade-up" data-aos-delay="60">
                            <div class="pay-card-head">
                                <i class="bi bi-upload"></i>
                                <h5>Upload Bukti Pembayaran</h5>
                            </div>
                            <div class="pay-card-body">

                                <div class="upload-area" id="upload-area">
                                    <input type="file"
                                           name="payment_proof"
                                           id="payment_proof"
                                           accept="image/jpg,image/jpeg,image/png"
                                           onchange="previewProof(event)">
                                    <i class="bi bi-cloud-arrow-up upload-icon"></i>
                                    <div class="upload-text">
                                        <strong>Klik untuk pilih file</strong> atau drag & drop di sini
                                    </div>
                                    <div class="upload-hint">JPG, JPEG, PNG · Maks. 2MB</div>
                                </div>

                                <div class="preview-wrap" id="preview-wrap">
                                    <img id="preview-img" src="" alt="Preview bukti pembayaran">
                                    <button type="button" class="preview-remove" onclick="removeProof()">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>

                                @error('payment_proof')
                                    <span class="invalid-msg">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>

                        {{-- Catatan --}}
                        <div class="pay-card" data-aos="fade-up" data-aos-delay="100">
                            <div class="pay-card-head">
                                <i class="bi bi-info-circle"></i>
                                <h5>Panduan Pembayaran</h5>
                            </div>
                            <div class="pay-card-body">
                                <ol style="font-size:.85rem; color:var(--muted); line-height:2; padding-left:1.2rem; margin:0;">
                                    <li>Pilih metode pembayaran yang diinginkan.</li>
                                    <li>Transfer sesuai total yang tertera di ringkasan pesanan.</li>
                                    <li>Ambil screenshot / foto bukti transfer.</li>
                                    <li>Upload bukti pembayaran di form di atas.</li>
                                    <li>Klik tombol <strong style="color:var(--gold);">Kirim Pembayaran</strong>.</li>
                                    <li>Pembayaran akan diverifikasi admin dalam 1×24 jam.</li>
                                </ol>
                            </div>
                        </div>

                    </div>

                    {{-- ───── RIGHT: Order Summary ───── --}}
                    <div class="col-lg-4" data-aos="fade-left">
                        <div class="order-summary">

                            <div class="os-head">
                                <div class="os-label">Ringkasan Pesanan</div>
                                <div class="os-name">{{ $order->package->name ?? '-' }}</div>
                                @if($order->package->category ?? null)
                                    <div class="os-cat">{{ $order->package->category->name }}</div>
                                @endif
                            </div>

                            <div class="os-body">

                                <div class="os-row">
                                    <span class="os-key"><i class="bi bi-hash"></i> ID Order</span>
                                    <span class="os-val">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                                </div>
                                <div class="os-row">
                                    <span class="os-key"><i class="bi bi-calendar3"></i> Tanggal</span>
                                    <span class="os-val">
                                        {{ \Carbon\Carbon::parse($order->booking_date)->isoFormat('D MMM YYYY') }}
                                    </span>
                                </div>
                                <div class="os-row">
                                    <span class="os-key"><i class="bi bi-clock"></i> Waktu</span>
                                    <span class="os-val">
                                        {{ \Carbon\Carbon::parse($order->start_time)->format('H:i') }}–{{ \Carbon\Carbon::parse($order->end_time)->format('H:i') }} WIB
                                    </span>
                                </div>
                                <div class="os-row">
                                    <span class="os-key"><i class="bi bi-geo-alt"></i> Lokasi</span>
                                    <span class="os-val" style="max-width:140px;">{{ $order->location ?? '-' }}</span>
                                </div>
                                <div class="os-row">
                                    <span class="os-key"><i class="bi bi-clock-history"></i> Durasi</span>
                                    <span class="os-val">{{ $order->package->duration ?? '-' }} menit</span>
                                </div>
                                <div class="os-row">
                                    <span class="os-key"><i class="bi bi-flag"></i> Status</span>
                                    <span class="os-val">
                                        <span class="status-badge status-pending">
                                            <i class="bi bi-hourglass-split"></i> Menunggu
                                        </span>
                                    </span>
                                </div>

                                <div class="os-total">
                                    <div class="os-total-label">Total Bayar</div>
                                    <div class="os-total-price">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </div>
                                </div>

                                <button type="submit" class="btn-pay-submit" id="pay-btn">
                                    <i class="bi bi-send-check"></i> Kirim Pembayaran
                                </button>

                                <div class="secure-note">
                                    <i class="bi bi-shield-lock"></i>
                                    Data kamu aman & terenkripsi
                                </div>

                                <div class="text-center mt-3">
                                    <a href="{{ route('customer.orders') }}"
                                       style="font-size:.76rem; color:var(--muted); text-decoration:none;">
                                        <i class="bi bi-list-ul me-1"></i> Lihat Semua Pesanan
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
// ─── Method select ──────────────────────────────────────────────
function selectMethod(el) {
    document.querySelectorAll('.method-tab').forEach(t => t.classList.remove('active'));
    el.classList.add('active');
    document.getElementById('payment_method_input').value = el.dataset.method;

    document.getElementById('info-transfer').style.display = 'none';
    document.getElementById('info-qris').style.display     = 'none';
    document.getElementById('info-cash').style.display     = 'none';
    document.getElementById('info-' + el.dataset.method).style.display = 'block';
}

// ─── Preview upload ─────────────────────────────────────────────
function previewProof(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('preview-img').src = e.target.result;
        document.getElementById('preview-wrap').style.display = 'block';
        document.getElementById('upload-area').style.display  = 'none';
    };
    reader.readAsDataURL(file);
}

function removeProof() {
    document.getElementById('payment_proof').value = '';
    document.getElementById('preview-wrap').style.display = 'none';
    document.getElementById('upload-area').style.display  = 'block';
}

// ─── Copy rekening ──────────────────────────────────────────────
function copyRek() {
    const num = document.getElementById('rek-number').textContent.replace(/\s/g,'');
    navigator.clipboard.writeText(num).then(() => {
        const btn = document.querySelector('.copy-btn');
        btn.innerHTML = '<i class="bi bi-check2"></i> Tersalin!';
        setTimeout(() => btn.innerHTML = '<i class="bi bi-clipboard"></i> Salin Nomor Rekening', 2000);
    });
}

// ─── Drag & drop ────────────────────────────────────────────────
const area = document.getElementById('upload-area');
area.addEventListener('dragover', e => { e.preventDefault(); area.classList.add('drag-over'); });
area.addEventListener('dragleave', () => area.classList.remove('drag-over'));
area.addEventListener('drop', e => {
    e.preventDefault(); area.classList.remove('drag-over');
    const file = e.dataTransfer.files[0];
    if (file) {
        const dt = new DataTransfer();
        dt.items.add(file);
        document.getElementById('payment_proof').files = dt.files;
        previewProof({ target: { files: [file] } });
    }
});

// ─── Prevent double submit ──────────────────────────────────────
document.getElementById('payment-form').addEventListener('submit', function() {
    const btn = document.getElementById('pay-btn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Mengirim...';
});
</script>
@endpush