@extends('base.base-auth-index')

@section('content')

<div class="auth-title">{{ $submenu ?? 'Selamat datang' }}</div>
<p class="auth-subtitle">{{ $subdesc ?? 'Masukkan kredensial admin kamu untuk melanjutkan.' }}</p>

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

<form action="{{ route('admin.login.post') }}" method="POST" novalidate>
    @csrf

    <div class="auth-field">
        <label for="login">Email atau Username</label>
        <div class="iw">
            <i class="bi bi-person"></i>
            <input
                type="text"
                id="login"
                name="login"
                value="{{ old('login') }}"
                placeholder="Masukkan email atau username"
                class="{{ $errors->has('login') ? 'is-invalid' : '' }}"
                autofocus>
        </div>
        @error('login')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="auth-field">
        <label for="password">Password</label>
        <div class="iw">
            <i class="bi bi-lock"></i>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Masukkan password"
                class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
        </div>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn-auth">
        <i class="bi bi-box-arrow-in-right"></i> Masuk
    </button>
</form>

<div class="auth-foot">
    Lupa password?
    <a href="javascript:;">Hubungi superadmin</a>
</div>

@endsection