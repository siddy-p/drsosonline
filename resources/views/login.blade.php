@extends('layouts.base')
@section('title', 'Login — Dr.SOS')
@section('content')
<section class="auth-section">
  <div class="auth-card">
    <div class="auth-header">
      <div class="auth-icon"><i class="fas fa-right-to-bracket"></i></div>
      <h1>Welcome Back</h1>
      <p>Sign in to your Dr.SOS account</p>
    </div>

    <form method="POST" action="{{ route('login.submit') }}">
      @csrf
      <div class="form-group-auth">
        <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
        <input type="email" id="email" name="email" class="form-control-auth" placeholder="you@example.com" value="{{ old('email') }}" required>
      </div>
      <div class="form-group-auth">
        <label for="password"><i class="fas fa-lock"></i> Password</label>
        <div class="password-wrap">
          <input type="password" id="password" name="password" class="form-control-auth" placeholder="Your password" required>
          <button type="button" class="toggle-pw" onclick="togglePw('password')"><i class="fas fa-eye"></i></button>
        </div>
      </div>
      <div class="d-flex justify-content-between align-items-center mb-3">
        <label class="remember-label">
          <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember me
        </label>
        <a href="#" class="forgot-link">Forgot password?</a>
      </div>
      <button type="submit" class="btn-auth-submit">
        Sign In <i class="fas fa-arrow-right ms-2"></i>
      </button>
    </form>

    <p class="auth-switch">Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
  </div>
</section>
@endsection
