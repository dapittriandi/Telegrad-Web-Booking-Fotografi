@extends('base.base-admin-index')

@section('custom-css')
<style>
.info-group { margin-bottom: 18px; }
.info-label { font-size: .7rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: #6C757D; margin-bottom: 4px; }
.info-value { font-size: .9rem; color: #212529; font-weight: 500; }

/* Progress steps */
.order-timeline { display: flex; align-items: flex-start; gap: 0; padding: 20px 0 8px; }
.tl-step { flex: 1; text-align: center; position: relative; }
.tl-step::before {
    content: '';
    position: absolute; top: 16px; left: calc(50% + 18px);
    width: calc(100% - 36px); height: 2px;
    background: #E9ECEF;
}
.tl-step:last-child::before { display: none; }
.tl-step.done::before { background: #198754; }

.tl-icon {
    width: 34px; height: 34px; border-radius: 50%;
    border: 2px solid #DEE2E6; background: #fff;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 8px; font-size: .85rem; color: #ADB5BD;
    position: relative; z-index: 1;
}
.tl-step.done   .tl-icon { border-color: #198754; background: #D1E7DD; color: #198754; }
.tl-step.active .tl-icon { border-color: #1E3A8A; background: #DBEAFE; color: #1E3A8A; }

.tl-label { font-size: .68rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; color: #ADB5BD; }
.tl-step.done .tl-label   { color: #198754; }
.tl-step.active .tl-label { color: #1E3A8A; }

/* Proof image */
.proof-img { max-height: 300px; width: 100%; object-fit: contain; background: #F8F9FA; border-radius: 10px; border: 1px solid #E9ECEF; }

/* Status badge */
.badge-pending   { background: #FFF3CD; color: #856404; border: 1px solid #FFE69C; }
.badge-confirmed { background: #CFE2FF; color: #084298; border: 1px solid #B6D4FE; }
.badge-completed { background: #D1E7DD; color: #0A3622; border: 1px solid #A3CFBB; }
.badge-cancelled { background: #F8D7DA; color: #842029; border: 1px solid #F5C2C7; }
</style>
@endsection

@section('content')

<div class="row g-4">

    {{-- ─── LEFT: Detail ─── --}}
    <div class="col-lg-8">

        {{-- Order header --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">
                            Order #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                        </h5>
                        <small class="text-muted">
                            <i class="fa-solid fa-calendar me-1"></i>
                            Dipesan {{ \Carbon\Carbon::parse($order->created_at)->isoFormat('D MMMM YYYY, HH:mm') }} WIB
                        </small>
                    </div>
                    @php
                        $badgeClass = match($order->status) {
                            'pending'   => 'badge-pending',
                            'confirmed' => 'badge-confirmed',
                            'completed' => 'badge-completed',
                            'cancelled' => 'badge-cancelled',
                            default     => 'bg-secondary text-white',
                        };
                        $statusLabel = match($order->status) {
                            'pending'   => 'Pending',
                            'confirmed' => 'Dikonfirmasi',
                            'completed' => 'Selesai',
                            'cancelled' => 'Dibatalkan',
                            default     => ucfirst($order->status),
                        };
                    @endphp
                    <span class="badge fs-6 {{ $badgeClass }}">{{ $statusLabel }}</span>
                </div>

                {{-- Progress timeline --}}
                @if($order->status !== 'cancelled')
                @php
                    $steps = ['pending','confirmed','completed'];
                    $curIdx = array_search($order->status, $steps);
                    if ($curIdx === false) $curIdx = -1;
                @endphp
                <div class="order-timeline">
                    @foreach(['pending'=>['Dipesan','fa-inbox'],'confirmed'=>['Dikonfirmasi','fa-check-circle'],'completed'=>['Selesai','fa-camera']] as $key=>[$lbl,$ic])
                    @php
                        $idx = array_search($key, $steps);
                        $cls = $idx < $curIdx ? 'done' : ($idx == $curIdx ? 'active' : '');
                    @endphp
                    <div class="tl-step {{ $cls }}">
                        <div class="tl-icon">
                            @if($cls=='done') <i class="fa-solid fa-check"></i>
                            @else <i class="fa-solid {{ $ic }}"></i>
                            @endif
                        </div>
                        <div class="tl-label">{{ $lbl }}</div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="alert alert-danger d-flex align-items-center gap-2 mb-0">
                    <i class="fa-solid fa-ban"></i>
                    <span>Pesanan ini telah dibatalkan.</span>
                </div>
                @endif
            </div>
        </div>

        {{-- Customer & Booking Info --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h6 class="mb-0 fw-bold"><i class="fa-solid fa-user me-2 text-primary"></i>Informasi Customer</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="info-group">
                            <div class="info-label">Nama</div>
                            <div class="info-value">{{ $order->user->name ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-group">
                            <div class="info-label">Email</div>
                            <div class="info-value">{{ $order->user->email ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-group">
                            <div class="info-label">No. HP</div>
                            <div class="info-value">{{ $order->user->phone ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h6 class="mb-0 fw-bold"><i class="fa-solid fa-calendar-check me-2 text-success"></i>Detail Booking</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="info-group">
                            <div class="info-label">Paket</div>
                            <div class="info-value">{{ $order->package->name ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-group">
                            <div class="info-label">Kategori</div>
                            <div class="info-value">{{ $order->package->category->name ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-group">
                            <div class="info-label">Tanggal Sesi</div>
                            <div class="info-value">{{ \Carbon\Carbon::parse($order->booking_date)->isoFormat('dddd, D MMMM YYYY') }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-group">
                            <div class="info-label">Waktu</div>
                            <div class="info-value">
                                {{ \Carbon\Carbon::parse($order->start_time)->format('H:i') }} –
                                {{ \Carbon\Carbon::parse($order->end_time)->format('H:i') }} WIB
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-group">
                            <div class="info-label">Durasi</div>
                            <div class="info-value">{{ $order->package->duration ?? '-' }} menit</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="info-group">
                            <div class="info-label">Lokasi</div>
                            <div class="info-value">{{ $order->location ?? '-' }}</div>
                        </div>
                    </div>
                    @if($order->notes)
                    <div class="col-12">
                        <div class="info-group mb-0">
                            <div class="info-label">Catatan</div>
                            <div class="info-value p-3 bg-light rounded" style="font-style:italic;">
                                {{ $order->notes }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Payment info --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h6 class="mb-0 fw-bold"><i class="fa-solid fa-credit-card me-2 text-warning"></i>Informasi Pembayaran</h6>
            </div>
            <div class="card-body">
                @if($order->payment)
                @php
                    $ps = $order->payment->payment_status ?? $order->payment->status ?? 'pending';
                    $psBadge = match($ps) {
                        'verified' => ['class'=>'bg-success','label'=>'Terverifikasi'],
                        'rejected' => ['class'=>'bg-danger', 'label'=>'Ditolak'],
                        default    => ['class'=>'bg-warning text-dark','label'=>'Menunggu'],
                    };
                @endphp
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="info-label">Metode</div>
                        <div class="info-value text-capitalize">{{ $order->payment->payment_method ?? '-' }}</div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-label">Jumlah</div>
                        <div class="info-value fw-bold">Rp {{ number_format($order->payment->amount, 0, ',', '.') }}</div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-label">Status</div>
                        <span class="badge {{ $psBadge['class'] }}">{{ $psBadge['label'] }}</span>
                    </div>
                    @if($order->payment->payment_proof)
                    <div class="col-12">
                        <div class="info-label mb-2">Bukti Pembayaran</div>
                        <img src="{{ asset('storage/payments/' . $order->payment->payment_proof) }}"
                             class="proof-img" alt="Bukti pembayaran">
                        <div class="mt-2">
                            <a href="{{ asset('storage/payments/' . $order->payment->payment_proof) }}"
                               target="_blank" class="btn btn-sm btn-outline-secondary">
                                <i class="fa-solid fa-expand me-1"></i> Lihat Full
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
                @else
                <div class="text-center text-muted py-3">
                    <i class="fa-solid fa-credit-card fa-2x mb-2 d-block opacity-25"></i>
                    Belum ada pembayaran
                </div>
                @endif
            </div>
        </div>

        {{-- Delivery info --}}
        @if($order->delivery)
        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="mb-0 fw-bold"><i class="fa-solid fa-paper-plane me-2 text-info"></i>Pengiriman Hasil</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="info-label">Status</div>
                        <div class="info-value text-capitalize">{{ $order->delivery->status ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-label">Tanggal Kirim</div>
                        <div class="info-value">{{ $order->delivery->delivery_date ? \Carbon\Carbon::parse($order->delivery->delivery_date)->isoFormat('D MMMM YYYY') : '-' }}</div>
                    </div>
                    @if($order->delivery->delivery_link)
                    <div class="col-12">
                        <div class="info-label">Link Google Drive</div>
                        <a href="{{ $order->delivery->delivery_link }}" target="_blank"
                           class="btn btn-success btn-sm mt-1">
                            <i class="fa-brands fa-google-drive me-1"></i> Buka Drive
                        </a>
                    </div>
                    @endif
                    @if($order->delivery->notes)
                    <div class="col-12">
                        <div class="info-label">Catatan</div>
                        <div class="info-value">{{ $order->delivery->notes }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

    </div>

    {{-- ─── RIGHT: Actions ─── --}}
    <div class="col-lg-4">

        {{-- Summary card --}}
        <div class="card shadow-sm mb-3">
            <div class="card-header" style="background:#1E3A8A;">
                <h6 class="mb-0 text-white fw-bold">Ringkasan Pesanan</h6>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted small">Paket</span>
                        <strong class="small text-end" style="max-width:60%;">{{ $order->package->name ?? '-' }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted small">Durasi</span>
                        <strong class="small">{{ $order->package->duration ?? '-' }} menit</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted small">Tanggal</span>
                        <strong class="small">{{ \Carbon\Carbon::parse($order->booking_date)->isoFormat('D MMM YYYY') }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="text-muted small">Waktu</span>
                        <strong class="small">{{ \Carbon\Carbon::parse($order->start_time)->format('H:i') }}–{{ \Carbon\Carbon::parse($order->end_time)->format('H:i') }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between bg-light">
                        <span class="fw-bold">Total</span>
                        <strong class="text-success">Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Action buttons --}}
        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="mb-0 fw-bold">Aksi</h6>
            </div>
            <div class="card-body d-flex flex-column gap-2">

                @if($order->status === 'pending')
                <form action="{{ route('admin.orders.confirm', $order->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success w-100"
                            onclick="return confirm('Konfirmasi order ini?')">
                        <i class="fa-solid fa-check me-2"></i> Konfirmasi Order
                    </button>
                </form>
                @endif

                @if($order->status === 'confirmed')
                <form action="{{ route('admin.orders.complete', $order->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100"
                            onclick="return confirm('Tandai order selesai?')">
                        <i class="fa-solid fa-camera me-2"></i> Tandai Selesai
                    </button>
                </form>

                {{-- Link to create delivery if not yet --}}
                @if(!$order->delivery)
                <a href="{{ route('deliveries.create') }}?order_id={{ $order->id }}"
                   class="btn btn-outline-info w-100">
                    <i class="fa-solid fa-paper-plane me-2"></i> Kirim Hasil Foto
                </a>
                @endif
                @endif

                @if(!in_array($order->status, ['completed','cancelled']))
                <form action="{{ route('admin.orders.cancel', $order->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-warning w-100"
                            onclick="return confirm('Batalkan order ini?')">
                        <i class="fa-solid fa-ban me-2"></i> Batalkan Order
                    </button>
                </form>
                @endif

                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary w-100">
                    <i class="fa-solid fa-arrow-left me-2"></i> Kembali
                </a>

                <hr class="my-1">

                <form id="delete-form-{{ $order->id }}"
                      action="{{ route('orders.destroy', $order->id) }}"
                      method="POST">
                    @csrf @method('DELETE')
                    <button type="button" onclick="deleteData({{ $order->id }})"
                            class="btn btn-outline-danger w-100">
                        <i class="fa-solid fa-trash me-2"></i> Hapus Order
                    </button>
                </form>

            </div>
        </div>

    </div>

</div>

@endsection