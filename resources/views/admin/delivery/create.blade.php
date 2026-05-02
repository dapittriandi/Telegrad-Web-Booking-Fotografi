@extends('base.base-admin-index')

@php $menu = 'Pengiriman'; $submenu = 'Kirim Hasil Foto'; $subdesc = 'Kirimkan link hasil foto ke customer'; @endphp

@section('custom-css')
<style>
@font-face { font-family:"Font Awesome 6 Free"; font-weight:900; font-display:block; src:url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/webfonts/fa-solid-900.woff2") format("woff2"); }
@font-face { font-family:"Font Awesome 6 Brands"; font-weight:400; font-display:block; src:url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/webfonts/fa-brands-400.woff2") format("woff2"); }
.fa-solid,.fas { font-family:"Font Awesome 6 Free"!important; font-weight:900!important; }
.fa-brands,.fab { font-family:"Font Awesome 6 Brands"!important; font-weight:400!important; }

/* ── Section Label ── */
.section-label {
    font-size: .63rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .1em;
    color: var(--tg-text-3); margin-bottom: 10px;
}

/* ── Main Card ── */
.del-card {
    border: 1px solid var(--tg-glass-border) !important;
    border-radius: 14px !important;
    box-shadow: var(--tg-sh-sm) !important;
    background: var(--tg-glass) !important;
    backdrop-filter: var(--tg-blur) !important;
    overflow: hidden;
}
.del-card-head {
    background: linear-gradient(135deg, #0A1628, #1E3A8A) !important;
    padding: 15px 20px;
    display: flex; align-items: center; gap: 10px;
}
.del-card-head h5 {
    color: #fff !important; font-weight: 700 !important;
    font-size: .95rem !important; margin: 0;
}
.del-card-body { padding: 24px !important; }

/* ── Step indicator ── */
.step-bar {
    display: flex; align-items: center;
    margin-bottom: 28px;
    gap: 0;
}
.step-item {
    display: flex; align-items: center; gap: 8px;
    flex: 1;
    font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em;
    color: var(--tg-text-3);
}
.step-dot {
    width: 28px; height: 28px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .7rem; font-weight: 800;
    flex-shrink: 0;
    background: var(--tg-glass-border);
    color: var(--tg-text-3);
    border: 2px solid var(--tg-border);
    transition: all .2s;
}
.step-item.active .step-dot {
    background: linear-gradient(135deg, #1E3A8A, #2563EB);
    color: #fff;
    border-color: transparent;
    box-shadow: 0 3px 10px rgba(37,99,235,.3);
}
.step-item.active { color: var(--tg-text); }
.step-line {
    flex: 1; height: 2px;
    background: var(--tg-border);
    margin: 0 6px;
    border-radius: 100px;
}
.step-line.done { background: linear-gradient(90deg, #1E3A8A, #2563EB); }

/* ── Field Label ── */
.field-label {
    font-size: .72rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .07em;
    color: var(--tg-text-3); margin-bottom: 7px;
    display: flex; align-items: center; gap: 6px;
}
.field-label i { font-size: .78rem; }

/* ── Form control overrides ── */
.del-select, .del-input, .del-textarea {
    background: var(--tg-glass) !important;
    border: 1px solid var(--tg-glass-border) !important;
    border-radius: 10px !important;
    color: var(--tg-text) !important;
    font-size: .84rem !important;
    padding: 9px 13px !important;
    transition: border-color .15s, box-shadow .15s !important;
    width: 100%;
}
.del-select:focus, .del-input:focus, .del-textarea:focus {
    border-color: #2563EB !important;
    box-shadow: 0 0 0 3px rgba(37,99,235,.1) !important;
    outline: none !important;
}
.del-textarea { resize: vertical; min-height: 100px; }

/* ── Input group (drive link) ── */
.del-input-group {
    display: flex; align-items: center;
    border: 1px solid var(--tg-glass-border);
    border-radius: 10px;
    overflow: hidden;
    transition: border-color .15s, box-shadow .15s;
    background: var(--tg-glass);
}
.del-input-group:focus-within {
    border-color: #2563EB;
    box-shadow: 0 0 0 3px rgba(37,99,235,.1);
}
.del-input-group-icon {
    padding: 0 13px;
    display: flex; align-items: center;
    background: transparent;
    border-right: 1px solid var(--tg-border);
    height: 100%;
    min-height: 40px;
}
.del-input-group .del-input {
    border: none !important;
    border-radius: 0 !important;
    box-shadow: none !important;
    flex: 1;
}

/* ── Order Preview card ── */
.order-preview {
    background: rgba(37,99,235,.04);
    border: 1px solid rgba(37,99,235,.12);
    border-radius: 10px;
    padding: 14px 16px;
    margin-top: 10px;
    display: none;
    animation: fadeSlide .2s ease;
}
@keyframes fadeSlide {
    from { opacity:0; transform:translateY(-6px); }
    to   { opacity:1; transform:translateY(0); }
}
.preview-grid {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 10px 16px;
}
.preview-label {
    font-size: .62rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .08em;
    color: var(--tg-text-3); margin-bottom: 3px;
}
.preview-val {
    font-size: .84rem; font-weight: 600;
    color: var(--tg-text); margin: 0; line-height: 1.3;
}

/* ── Info box ── */
.del-info-box {
    background: rgba(37,99,235,.06);
    border-left: 3px solid #2563EB;
    border-radius: 0 10px 10px 0;
    padding: 12px 16px;
    font-size: .80rem;
    color: var(--tg-text-2);
    display: flex; align-items: flex-start; gap: 10px;
}
.del-info-box i { color: #2563EB; margin-top: 1px; flex-shrink: 0; font-size: .9rem; }

/* ── Hint text ── */
.field-hint {
    font-size: .73rem; color: var(--tg-text-3);
    margin-top: 6px;
    display: flex; align-items: center; gap: 5px;
}

/* ── Buttons ── */
.btn-send {
    background: linear-gradient(135deg, #1E3A8A, #2563EB) !important;
    border: none !important;
    color: #fff !important;
    font-weight: 700 !important; font-size: .86rem !important;
    border-radius: 10px !important;
    padding: 10px 24px !important;
    display: inline-flex; align-items: center; gap: 8px;
    transition: opacity .15s, transform .15s, box-shadow .15s;
    box-shadow: 0 3px 12px rgba(37,99,235,.3);
    cursor: pointer;
}
.btn-send:hover { opacity: .9; transform: translateY(-1px); box-shadow: 0 6px 18px rgba(37,99,235,.35); }

.btn-cancel {
    background: var(--tg-glass) !important;
    border: 1px solid var(--tg-glass-border) !important;
    color: var(--tg-text-2) !important;
    font-weight: 600 !important; font-size: .86rem !important;
    border-radius: 10px !important;
    padding: 10px 20px !important;
    display: inline-flex; align-items: center; gap: 8px;
    transition: background .15s, transform .15s;
    cursor: pointer;
    text-decoration: none;
}
.btn-cancel:hover {
    background: var(--tg-glass-border) !important;
    color: var(--tg-text) !important;
    transform: translateX(-2px);
}

/* ── Field separator ── */
.field-sep {
    border: none; border-top: 1px solid var(--tg-border);
    margin: 20px 0;
}
</style>
@endsection

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">

        {{-- Alert error --}}
        @if(session('error'))
        <div style="background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.2);border-radius:10px;padding:12px 16px;margin-bottom:16px;font-size:.82rem;color:#991B1B;display:flex;align-items:center;gap:8px;">
            <i class="fa-solid fa-circle-exclamation" style="flex-shrink:0;"></i>
            {{ session('error') }}
        </div>
        @endif

        <p class="section-label">Form Pengiriman</p>

        <div class="del-card">

            {{-- Header --}}
            <div class="del-card-head">
                <i class="fa-solid fa-paper-plane" style="color:rgba(255,255,255,.8);"></i>
                <h5>Kirim Hasil Foto</h5>
            </div>

            <div class="del-card-body">

                {{-- Step indicator --}}
                <div class="step-bar">
                    <div class="step-item active">
                        <div class="step-dot">1</div>
                        <span>Pilih Order</span>
                    </div>
                    <div class="step-line"></div>
                    <div class="step-item active">
                        <div class="step-dot">2</div>
                        <span>Link Drive</span>
                    </div>
                    <div class="step-line"></div>
                    <div class="step-item active">
                        <div class="step-dot">3</div>
                        <span>Catatan</span>
                    </div>
                    <div class="step-line"></div>
                    <div class="step-item active">
                        <div class="step-dot"><i class="fa-solid fa-check" style="font-size:.6rem;"></i></div>
                        <span>Kirim</span>
                    </div>
                </div>

                <form action="{{ route('deliveries.store') }}" method="POST">
                    @csrf

                    {{-- 1. Pilih Order --}}
                    <div class="mb-4">
                        <label class="field-label">
                            <i class="fa-solid fa-bag-shopping" style="color:#2563EB;"></i>
                            Pilih Order <span style="color:#EF4444;">*</span>
                        </label>
                        <select name="order_id" id="order-select"
                                class="del-select @error('order_id') is-invalid @enderror" required>
                            <option value="">— Pilih order dengan status confirmed —</option>
                            @foreach($orders as $order)
                            <option value="{{ $order->id }}"
                                    data-customer="{{ $order->user->name ?? '-' }}"
                                    data-package="{{ $order->package->name ?? '-' }}"
                                    data-date="{{ \Carbon\Carbon::parse($order->booking_date)->isoFormat('D MMM YYYY') }}"
                                    data-time="{{ \Carbon\Carbon::parse($order->start_time)->format('H:i') }}"
                                    {{ request('order_id') == $order->id ? 'selected' : '' }}>
                                #{{ str_pad($order->id,5,'0',STR_PAD_LEFT) }} — {{ $order->user->name ?? '-' }} — {{ $order->package->name ?? '-' }} — {{ \Carbon\Carbon::parse($order->booking_date)->isoFormat('D MMM YYYY') }}
                            </option>
                            @endforeach
                        </select>
                        @error('order_id')
                        <div style="color:#EF4444;font-size:.76rem;margin-top:5px;">{{ $message }}</div>
                        @enderror

                        {{-- Order Preview --}}
                        <div id="order-preview" class="order-preview">
                            <div style="font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#2563EB;margin-bottom:10px;display:flex;align-items:center;gap:6px;">
                                <i class="fa-solid fa-circle-check"></i> Detail Order
                            </div>
                            <div class="preview-grid">
                                <div>
                                    <p class="preview-label">Customer</p>
                                    <p class="preview-val" id="prev-customer">-</p>
                                </div>
                                <div>
                                    <p class="preview-label">Paket</p>
                                    <p class="preview-val" id="prev-package">-</p>
                                </div>
                                <div>
                                    <p class="preview-label">Tanggal Sesi</p>
                                    <p class="preview-val" id="prev-date">-</p>
                                </div>
                                <div>
                                    <p class="preview-label">Jam Mulai</p>
                                    <p class="preview-val" id="prev-time">-</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="field-sep">

                    {{-- 2. Google Drive Link --}}
                    <div class="mb-4">
                        <label class="field-label">
                            <i class="fa-brands fa-google-drive" style="color:#34A853;"></i>
                            Link Google Drive <span style="color:#EF4444;">*</span>
                        </label>
                        <div class="del-input-group">
                            <div class="del-input-group-icon">
                                <i class="fa-brands fa-google-drive" style="color:#34A853;font-size:.95rem;"></i>
                            </div>
                            <input type="url" name="delivery_link"
                                   class="del-input @error('delivery_link') is-invalid @enderror"
                                   placeholder="https://drive.google.com/drive/folders/..."
                                   value="{{ old('delivery_link') }}" required>
                        </div>
                        @error('delivery_link')
                        <div style="color:#EF4444;font-size:.76rem;margin-top:5px;">{{ $message }}</div>
                        @enderror
                        <p class="field-hint">
                            <i class="fa-solid fa-circle-info" style="color:#2563EB;"></i>
                            Pastikan link sudah di-set <em>"Anyone with the link can view"</em> di Google Drive.
                        </p>
                    </div>

                    <hr class="field-sep">

                    {{-- 3. Catatan --}}
                    <div class="mb-4">
                        <label class="field-label">
                            <i class="fa-solid fa-note-sticky" style="color:#D97706;"></i>
                            Catatan
                        </label>
                        <textarea name="notes"
                                  class="del-textarea @error('notes') is-invalid @enderror"
                                  placeholder="Contoh: File ready, terdiri dari 30 foto edited dalam format JPG dan RAW...">{{ old('notes') }}</textarea>
                        @error('notes')
                        <div style="color:#EF4444;font-size:.76rem;margin-top:5px;">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Info box --}}
                    <div class="del-info-box mb-5">
                        <i class="fa-solid fa-circle-info"></i>
                        <span>
                            Setelah menyimpan, status order akan otomatis berubah menjadi
                            <strong>Completed</strong> dan customer dapat mengakses link hasil foto
                            langsung dari halaman pesanan mereka.
                        </span>
                    </div>

                    {{-- Actions --}}
                    <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                        <button type="submit" class="btn-send">
                            <i class="fa-solid fa-paper-plane"></i> Kirim Hasil Foto
                        </button>
                        <a href="{{ route('deliveries.index') }}" class="btn-cancel">
                            <i class="fa-solid fa-arrow-left"></i> Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('custom-js')
<script>
const sel = document.getElementById('order-select');

sel.addEventListener('change', function () {
    const opt     = this.options[this.selectedIndex];
    const preview = document.getElementById('order-preview');
    if (this.value) {
        document.getElementById('prev-customer').textContent = opt.dataset.customer;
        document.getElementById('prev-package').textContent  = opt.dataset.package;
        document.getElementById('prev-date').textContent     = opt.dataset.date;
        document.getElementById('prev-time').textContent     = opt.dataset.time + ' WIB';
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
    }
});

window.addEventListener('DOMContentLoaded', () => {
    if (sel.value) sel.dispatchEvent(new Event('change'));
});
</script>
@endsection