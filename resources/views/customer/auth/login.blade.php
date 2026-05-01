<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    @php $web = \App\Models\WebSetting::first(); @endphp

    <title>{{ $web->site_name ?? 'Telegrad' }} - Login</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet"/>
    <link href="{{ asset('auth/assets/css/nucleo-icons.css') }}" rel="stylesheet"/>
    <link href="{{ asset('auth/assets/css/nucleo-svg.css') }}" rel="stylesheet"/>
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{ asset('auth/assets/css/argon-dashboard.min.css?v=2.0.4') }}" rel="stylesheet"/>
</head>

<body>

<div class="container position-sticky z-index-sticky top-0">
    <div class="row">
        <div class="col-12">
            <nav class="navbar navbar-expand-lg blur border-radius-lg top-0 z-index-3 shadow position-absolute mt-4 py-2 start-0 end-0 mx-4">
                <div class="container-fluid">
                    <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3" href="{{ url('/') }}">
                        {{ $web->site_name ?? 'Telegrad' }}
                    </a>
                    <div class="collapse navbar-collapse justify-content-end">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a href="{{ url('/') }}" class="btn btn-sm btn-outline-primary">
                                    ← Kembali ke Beranda
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>

<main class="main-content mt-0">
    <section>
        <div class="page-header min-vh-100">
            <div class="container">
                <div class="row">

                    {{-- FORM LOGIN --}}
                    <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">

                        <div class="card card-plain">

                            <div class="card-header pb-0 text-start">
                                <h4 class="font-weight-bolder">Login</h4>
                                <p class="mb-0">Masukkan email/username dan password kamu</p>
                            </div>

                            <div class="card-body">

                                {{-- Error bag --}}
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        @foreach($errors->all() as $error)
                                            <p class="mb-0 small">{{ $error }}</p>
                                        @endforeach
                                    </div>
                                @endif

                                {{-- Success message --}}
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <form action="{{ route('customer.login.post') }}" method="POST">
                                    @csrf

                                    <div class="form-group">
                                        <label for="login">Email, Username, atau No. HP</label>
                                        <input
                                            type="text"
                                            class="form-control @error('login') is-invalid @enderror"
                                            name="login"
                                            value="{{ old('login') }}"
                                            placeholder="Email / username / no. HP...">
                                        @error('login')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input
                                            type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            name="password"
                                            placeholder="Password...">
                                        @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-lg btn-primary w-100 mt-4 mb-0">
                                            Masuk
                                        </button>
                                    </div>
                                </form>

                                @include('sweetalert::alert')

                            </div>

                            <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <p class="mb-2 text-sm mx-auto">
                                    Belum punya akun?
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#registModal"
                                       class="text-primary text-gradient font-weight-bold">
                                        Daftar di sini
                                    </a>
                                </p>
                                <p class="mb-0 text-sm mx-auto">
                                    <a href="{{ url('/') }}" class="text-secondary">
                                        Lanjutkan tanpa login
                                    </a>
                                </p>
                            </div>

                        </div>

                    </div>

                    {{-- BANNER KANAN --}}
                    <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                        <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                            style="background-image: url('{{ asset('storage/images/default/' . ($web->slider_1 ?? 'slider_1.jpg')) }}'); background-size: cover;">
                            <span class="mask bg-gradient-primary opacity-6"></span>
                            <h4 class="mt-5 text-white font-weight-bolder position-relative">
                                {{ $web->site_head ?? 'Abadikan Momenmu Bersama Kami' }}
                            </h4>
                            <p class="text-white position-relative">
                                {{ $web->site_description ?? 'Jasa foto & video wisuda profesional' }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</main>

{{-- Modal Register --}}
<div class="modal fade" id="registModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('customer.register') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar Akun Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" placeholder="Nama lengkap..." value="{{ old('name') }}" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username" placeholder="Username (opsional)..." value="{{ old('username') }}">
                        @error('username') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" placeholder="Email..." value="{{ old('email') }}" required>
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label>No. HP / WhatsApp <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="phone" placeholder="08xxxxxxxxxx..." value="{{ old('phone') }}" required>
                        @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label>Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password" placeholder="Min. 6 karakter..." required>
                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label>Konfirmasi Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Ulangi password..." required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Daftar Sekarang</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('auth/assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('auth/assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('auth/assets/js/argon-dashboard.min.js?v=2.0.4') }}"></script>

{{-- Buka modal register otomatis jika ada error registrasi --}}
@if($errors->has('name') || $errors->has('email') || $errors->has('phone') || $errors->has('username') || $errors->has('password'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modal = new bootstrap.Modal(document.getElementById('registModal'));
        modal.show();
    });
</script>
@endif

</body>
</html>