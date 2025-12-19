@extends('layouts.app')

@section('content')
<div class="login-page">
  <div class="login-box">

    {{-- Branding --}}
    <div class="login-brand">
      <div class="brand-logo">✦</div>
      <h2>Ecommerce Manggala </h2>
      <p>Masuk untuk melanjutkan</p>
    </div>

    {{-- Form --}}
    <form method="POST" action="{{ route('login') }}" class="login-form">
      @csrf

      {{-- Email --}}
      <div class="form-group floating">
        <input
          type="email"
          name="email"
          value="{{ old('email') }}"
          required
          autofocus
        >
        <label>Email</label>
        @error('email')
          <span class="error-text">{{ $message }}</span>
        @enderror
      </div>

      {{-- Password --}}
      <div class="form-group floating">
        <input
          type="password"
          name="password"
          required
        >
        <label>Password</label>
        @error('password')
          <span class="error-text">{{ $message }}</span>
        @enderror
      </div>

      {{-- Options --}}
      <div class="login-options">
        <label class="remember">
          <input type="checkbox" name="remember">
          <span>Ingat saya</span>
        </label>

        @if (Route::has('password.request'))
          <a href="{{ route('password.request') }}" class="forgot">
            Lupa password?
          </a>
        @endif
      </div>

      {{-- Button --}}
      <button type="submit" class="login-btn">
        Masuk
      </button>

      {{-- Divider --}}
      <div class="divider">
        <span>atau</span>
      </div>

      {{-- Google --}}
      <a href="#" class="google-btn">
        <img src="https://www.svgrepo.com/show/475656/google-color.svg">
        Masuk dengan Google
      </a>

      {{-- Register --}}
      <p class="register-text">
        Belum punya akun?
        <a href="{{ route('register') }}">Daftar sekarang</a>
      </p>
    </form>

  </div>
</div>
@endsection
