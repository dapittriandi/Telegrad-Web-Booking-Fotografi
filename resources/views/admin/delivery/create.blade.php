@extends('base.base-admin-index')

@php $menu = 'Pengiriman'; $submenu = 'Kirim Hasil Foto'; $subdesc = 'Kirimkan link hasil foto ke customer'; @endphp

@section('custom-css')
<style>
    @font-face { font-family:"Font Awesome 6 Free"; font-weight:900; font-display:block; src:url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/webfonts/fa-solid-900.woff2") format("woff2"); }
    @font-face { font-family:"Font Awesome 6 Brands"; font-weight:400; font-display:block; src:url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/webfonts/fa-brands-400.woff2") format("woff2"); }
    .fa-solid,.fas{font-family:"Font Awesome 6 Free"!important;font-weight:900!important;}
    .fa-brands,.fab{font-family:"Font Awesome 6 Brands"!important;font-weight:400!important;}

    .tg-card { border:none!important; border-radius:14px!important; box-shadow:0 1px 3px rgba(0,0,0,.06),0 4px 16px rgba(0,0,0,.05)!important; }
    .tg-card .card-header { background:linear-gradient(135deg,#1E3A8A,#2563EB)!important; border:none!important; padding:15px 20px!important; }
    .tg-card .card-header h5 { color:#fff!important; font-weight:600!important; font-size:.95rem!important; margin:0; }
    .tg-card .card-body { padding:24px!important; }

    .field-label { font-size:.8rem; font-weight:600; color:#374151; margin-bottom:5px; }
    .order-preview { background:#F9FAFB; border-radius:10px; border:1px solid #F3F4F6; padding:14px 16px; }
    .preview-label { font-size:.68rem; text-transform:uppercase; letter-spacing:.07em; color:#9CA3AF; font-weight:700; margin-bottom:2px; }
    .preview-val   { font-size:.84rem; font-weight:600; color:#111827; }
    .info-box { background:#EFF6FF; border-radius:10px; border-left:3px solid #2563EB; padding:12px 16px; font-size:.82rem; color:#1E40AF; }
    .section-label { font-size:.68rem; font-weight:700; text-transform:uppercase; letter-spacing:.1em; color:#9CA3AF; margin-bottom:10px; }
</style>
@endsection

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-8">

        @if(session('error'))
        <div class="alert alert-danger mb-3" style="border-radius:10px;border:none;font-size:.84rem;">
            <i class="fa-solid fa-exclamation-triangle me-1"></i> {{ session('error') }}
        </div>
        @endif

        <p class="section-label">Form Pengiriman</p>
        <div class="card tg-card">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="fa-solid fa-paper-plane text-white"></i>
                <h5>Kirim Hasil Foto</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('deliveries.store') }}" method="POST">
                    @csrf

                    {{-- Pilih Order --}}
                    <div class="mb-4">
                        <label class="field-label">Pilih Order <span class="text-danger">*</span></label>
                        <select name="order_id" id="order-select" class="form-select @error('order_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Order (status: confirmed) --</option>
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
                        @error('order_id')<div class="invalid-feedback">{{ $message }}</div>@enderror

                        {{-- Preview Order --}}
                        <div id="order-preview" class="order-preview mt-3" style="display:none;">
                            <div class="row g-2">
                                <div class="col-6">
                                    <p class="preview-label">Customer</p>
                                    <p class="preview-val" id="prev-customer">-</p>
                                </div>
                                <div class="col-6">
                                    <p class="preview-label">Paket</p>
                                    <p class="preview-val" id="prev-package">-</p>
                                </div>
                                <div class="col-6">
                                    <p class="preview-label">Tanggal Sesi</p>
                                    <p class="preview-val" id="prev-date">-</p>
                                </div>
                                <div class="col-6">
                                    <p class="preview-label">Jam Mulai</p>
                                    <p class="preview-val" id="prev-time">-</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Google Drive Link --}}
                    <div class="mb-4">
                        <label class="field-label">Link Google Drive <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="fa-brands fa-google-drive text-success"></i>
                            </span>
                            <input type="url" name="delivery_link"
                                   class="form-control @error('delivery_link') is-invalid @enderror"
                                   placeholder="https://drive.google.com/..."
                                   value="{{ old('delivery_link') }}" required>
                        </div>
                        @error('delivery_link')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        <p style="font-size:.76rem;color:#9CA3AF;margin-top:6px;">
                            <i class="fa-solid fa-circle-info me-1"></i>
                            Pastikan link sudah di-set <em>"Anyone with the link can view"</em> di Google Drive.
                        </p>
                    </div>

                    {{-- Catatan --}}
                    <div class="mb-4">
                        <label class="field-label">Catatan</label>
                        <textarea name="notes" class="form-control @error('notes') is-invalid @enderror"
                                  rows="4" placeholder="Contoh: File ready, terdiri dari 30 foto edited...">{{ old('notes') }}</textarea>
                        @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Info --}}
                    <div class="info-box mb-4">
                        <i class="fa-solid fa-circle-info me-1"></i>
                        Setelah menyimpan, status order akan otomatis berubah menjadi <strong>Completed</strong> dan customer dapat mengakses link hasil foto dari halaman pesanan mereka.
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4" style="border-radius:8px;font-size:.86rem;">
                            <i class="fa-solid fa-paper-plane me-2"></i> Kirim Hasil
                        </button>
                        <a href="{{ route('deliveries.index') }}" class="btn btn-outline-secondary px-4" style="border-radius:8px;font-size:.86rem;">
                            <i class="fa-solid fa-arrow-left me-2"></i> Batal
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
sel.addEventListener('change', function() {
    const opt = this.options[this.selectedIndex];
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
window.addEventListener('DOMContentLoaded', () => { if (sel.value) sel.dispatchEvent(new Event('change')); });
</script>
@endsection