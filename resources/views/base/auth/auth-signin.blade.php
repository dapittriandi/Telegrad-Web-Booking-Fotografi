@extends('base.base-auth-index')

@section('content')
<div class="card card-plain">

    <div class="card-header pb-0 text-start">
        <h4 class="font-weight-bolder">{{ $submenu ?? 'Login Admin' }}</h4>
        <p class="mb-0 text-sm text-muted">{{ $subdesc ?? 'Masukkan kredensial admin kamu' }}</p>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf

            <div class="form-group mb-3">
                <label class="form-label">Email atau Username</label>
                <input
                    type="text"
                    class="form-control @error('login') is-invalid @enderror"
                    name="login"
                    value="{{ old('login') }}"
                    placeholder="Masukkan email atau username..."
                    autofocus>
                @error('login')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label class="form-label">Password</label>
                <input
                    type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    name="password"
                    placeholder="Masukkan password...">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-lg btn-primary w-100">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Masuk
                </button>
            </div>

        </form>
    </div>

    <div class="card-footer text-center pt-0 px-lg-2 px-1">
        <p class="mb-0 text-sm mx-auto text-muted">
            Lupa password?
            <a href="javascript:;" class="text-primary font-weight-bold">
                Hubungi superadmin
            </a>
        </p>
    </div>

</div>
@endsection