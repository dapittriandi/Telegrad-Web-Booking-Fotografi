{{-- Modal Login (muncul saat tamu klik Pesan) --}}
<div class="modal fade" id="modalLogin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Login Diperlukan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <p>Silakan login terlebih dahulu untuk memesan paket.</p>
                <a href="{{ route('customer.login') }}" class="btn btn-warning px-4">
                    Login Sekarang
                </a>
            </div>
        </div>
    </div>
</div>