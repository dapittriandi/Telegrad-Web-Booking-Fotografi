@extends('base.base-admin-index')

@section('content')

<section class="section">
<form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
@csrf

{{-- ── Alerts ── --}}
@if($errors->any())
<div class="alert alert-danger d-flex align-items-start gap-2 mb-4">
    <i class="bi bi-exclamation-circle-fill mt-1" style="flex-shrink:0;"></i>
    <div>
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
</div>
@endif
@if(session('success'))
<div class="alert alert-success d-flex align-items-center gap-2 mb-4">
    <i class="bi bi-check-circle-fill" style="flex-shrink:0;"></i>
    {{ session('success') }}
</div>
@endif

<div class="row g-4">

    {{-- ── LEFT: Avatar card ── --}}
    <div class="col-lg-4 col-12">
        <div class="card h-100">

            <div class="card-header">
                <h4 class="card-title mb-0">
                    <i class="bi bi-person-bounding-box me-2" style="color:var(--tg-blue);"></i>
                    Foto Profil
                </h4>
            </div>

            <div class="card-body d-flex flex-column align-items-center gap-3 py-4">

                {{-- Avatar preview --}}
                <div style="position:relative; width:110px; height:110px; flex-shrink:0;">
                    <img id="avatarPreview"
                         src="{{ asset('storage/images/profile/' . Auth::user()->photo) }}"
                         alt="Foto Profil"
                         style="width:110px; height:110px; border-radius:50%; object-fit:cover;
                                border:3px solid rgba(59,130,246,.2);
                                box-shadow:0 4px 16px rgba(0,0,0,.10);">
                    <label for="photo"
                           style="position:absolute; bottom:4px; right:4px;
                                  width:28px; height:28px; border-radius:50%;
                                  background:var(--tg-blue); color:#fff;
                                  display:flex; align-items:center; justify-content:center;
                                  cursor:pointer; font-size:12px;
                                  border:2px solid #fff;
                                  box-shadow:0 2px 6px rgba(37,99,235,.4);"
                           title="Ganti foto">
                        <i class="bi bi-camera-fill"></i>
                    </label>
                </div>

                <div class="text-center">
                    <div style="font-size:15px; font-weight:700; color:var(--tg-text);">
                        {{ Auth::user()->name }}
                    </div>
                    <div style="font-size:12.5px; color:var(--tg-text-3); margin-top:2px;">
                        &#64;{{ Auth::user()->username }}
                    </div>
                </div>

                <input type="file" name="photo" id="photo"
                       class="d-none" accept="image/*">

                <label for="photo" class="btn btn-outline-primary w-100" style="cursor:pointer;">
                    <i class="bi bi-upload me-2"></i> Pilih Foto Baru
                </label>

                @error('photo')
                <small class="text-danger text-center d-block">{{ $message }}</small>
                @enderror

            </div>
        </div>
    </div>

    {{-- ── RIGHT: Identity card ── --}}
    <div class="col-lg-8 col-12">
        <div class="card h-100 d-flex flex-column">

            <div class="card-header">
                <h4 class="card-title mb-0">
                    <i class="bi bi-person-lines-fill me-2" style="color:var(--tg-blue);"></i>
                    Identitas Admin
                </h4>
            </div>

            <div class="card-body flex-grow-1">
                <div class="row g-3">

                    <div class="col-lg-6 col-12">
                        <label class="form-label" for="name">
                            <i class="bi bi-person me-1 text-muted"></i> Nama Lengkap
                        </label>
                        <input type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name"
                               value="{{ old('name', Auth::user()->name) }}"
                               placeholder="Nama lengkap">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-6 col-12">
                        <label class="form-label" for="username">
                            <i class="bi bi-at me-1 text-muted"></i> Username
                        </label>
                        <input type="text"
                               class="form-control @error('username') is-invalid @enderror"
                               id="username" name="username"
                               value="{{ old('username', Auth::user()->username) }}"
                               placeholder="Username">
                        @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-6 col-12">
                        <label class="form-label" for="phone">
                            <i class="bi bi-phone me-1 text-muted"></i> No. HP / WhatsApp
                        </label>
                        <input type="text"
                               class="form-control @error('phone') is-invalid @enderror"
                               id="phone" name="phone"
                               value="{{ old('phone', Auth::user()->phone) }}"
                               placeholder="08xxxxxxxxxx">
                        @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-lg-6 col-12">
                        <label class="form-label" for="email">
                            <i class="bi bi-envelope me-1 text-muted"></i> Alamat Email
                        </label>
                        <input type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email"
                               value="{{ old('email', Auth::user()->email) }}"
                               placeholder="email@contoh.com">
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="card-footer d-flex justify-content-end"
                 style="background:transparent; border-top:1px solid var(--tg-border); padding:14px 20px;">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check2-circle me-2"></i> Simpan Perubahan
                </button>
            </div>

        </div>
    </div>

</div>
</form>
</section>

@endsection

@section('custom-js')
<script>
    document.getElementById('photo').addEventListener('change', function (e) {
        var file = e.target.files[0];
        if (!file) return;
        var reader = new FileReader();
        reader.onload = function (ev) {
            document.getElementById('avatarPreview').src = ev.target.result;
        };
        reader.readAsDataURL(file);
    });
</script>
@endsection