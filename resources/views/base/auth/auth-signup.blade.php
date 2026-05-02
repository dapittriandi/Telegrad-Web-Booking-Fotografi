@extends('base.base-auth-index')

@section('content')

<div class="auth-title">{{ $submenu ?? 'Buat Akun' }}</div>
<p class="auth-subtitle">{{ $subdesc ?? 'Isi data di bawah untuk mendaftar.' }}</p>

{{-- Error / success alerts --}}
@if($errors->any())
<div class="auth-alert danger">
    @foreach($errors->all() as $error)
        <div>{{ $error }}</div>
    @endforeach
</div>
@endif

@if(session('success'))
<div class="auth-alert success">{{ session('success') }}</div>
@endif

<form action="{{ route('auth.auth-signup-post') }}" method="POST" novalidate>
    @csrf

    <div class="auth-field">
        <label for="name">Nama Lengkap <span style="color:var(--c-err)">*</span></label>
        <div class="iw">
            <i class="bi bi-person"></i>
            <input
                type="text" id="name" name="name"
                value="{{ old('name') }}"
                placeholder="Nama lengkap"
                class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                required>
        </div>
        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="auth-field">
        <label for="email">Email <span style="color:var(--c-err)">*</span></label>
        <div class="iw">
            <i class="bi bi-envelope"></i>
            <input
                type="email" id="email" name="email"
                value="{{ old('email') }}"
                placeholder="Alamat email"
                class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                required>
        </div>
        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="auth-field">
        <label for="username">Username</label>
        <div class="iw">
            <i class="bi bi-at"></i>
            <input
                type="text" id="username" name="username"
                value="{{ old('username') }}"
                placeholder="Username (opsional)"
                class="{{ $errors->has('username') ? 'is-invalid' : '' }}">
        </div>
        @error('username') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="auth-field">
        <label for="phone">No. HP / WhatsApp <span style="color:var(--c-err)">*</span></label>
        <div class="iw">
            <i class="bi bi-phone"></i>
            <input
                type="text" id="phone" name="phone"
                value="{{ old('phone') }}"
                placeholder="08xxxxxxxxxx"
                class="{{ $errors->has('phone') ? 'is-invalid' : '' }}"
                required>
        </div>
        @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="auth-field">
        <label for="password">Password <span style="color:var(--c-err)">*</span></label>
        <div class="iw">
            <i class="bi bi-lock"></i>
            <input
                type="password" id="password" name="password"
                placeholder="Min. 6 karakter"
                class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                required>
        </div>
        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="auth-field">
        <label for="password_confirmation">Konfirmasi Password <span style="color:var(--c-err)">*</span></label>
        <div class="iw">
            <i class="bi bi-lock-fill"></i>
            <input
                type="password" id="password_confirmation"
                name="password_confirmation"
                placeholder="Ulangi password"
                required>
        </div>
    </div>

    <button type="submit" class="btn-auth">
        <i class="bi bi-person-plus"></i> {{ $submenu ?? 'Daftar' }}
    </button>
</form>

@include('sweetalert::alert')

<div class="auth-foot">
    Sudah punya akun?
    <a href="{{ route('auth.auth-signin') }}">Masuk di sini</a>
</div>

@endsection