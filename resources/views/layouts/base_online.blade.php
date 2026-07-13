<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dr.SOS Online — See a Doctor Today')</title>
  <meta name="description" content="@yield('meta_desc', 'Dr.SOS Online — Affordable phone, WhatsApp and video doctor consultations from ₹99. Book now.')">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/online.css') }}">
  <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
  @yield('extra_css')
</head>
<body class="online-portal">

<div class="custom-cursor" id="customCursor" style="background:radial-gradient(circle,#0d9488,#065f56)"></div>

<!-- Flash Toasts -->
@if(session('success') || session('danger') || session('warning') || session('info') || $errors->any())
  <div class="flash-container" id="flashContainer">
    @if(session('success'))
      <div class="flash-toast flash-success">
        <i class="fas fa-circle-check"></i>
        <span>{{ session('success') }}</span>
        <button class="flash-close" onclick="this.parentElement.remove()">×</button>
      </div>
    @endif
    @if(session('danger'))
      <div class="flash-toast flash-danger">
        <i class="fas fa-circle-xmark"></i>
        <span>{{ session('danger') }}</span>
        <button class="flash-close" onclick="this.parentElement.remove()">×</button>
      </div>
    @endif
    @if(session('warning'))
      <div class="flash-toast flash-warning">
        <i class="fas fa-triangle-exclamation"></i>
        <span>{{ session('warning') }}</span>
        <button class="flash-close" onclick="this.parentElement.remove()">×</button>
      </div>
    @endif
    @if(session('info'))
      <div class="flash-toast flash-info">
        <i class="fas fa-circle-info"></i>
        <span>{{ session('info') }}</span>
        <button class="flash-close" onclick="this.parentElement.remove()">×</button>
      </div>
    @endif
    @if($errors->any())
      @foreach($errors->all() as $error)
        <div class="flash-toast flash-danger">
          <i class="fas fa-circle-xmark"></i>
          <span>{{ $error }}</span>
          <button class="flash-close" onclick="this.parentElement.remove()">×</button>
        </div>
      @endforeach
    @endif
  </div>
@endif

<!-- Online Navbar -->
<nav class="navbar navbar-expand-lg online-nav" id="mainNav">
  <div class="container">
    <a class="navbar-brand online-brand" href="{{ route('online.home') }}">
      <i class="fas fa-stethoscope me-2" style="color: var(--on-secondary)"></i>
      <span class="on-dr">Dr.</span><span class="on-sos">SOS</span><span class="on-sub"> Online</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navOnline">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navOnline">
      <ul class="navbar-nav mx-auto gap-2">
        <li class="nav-item"><a class="nav-link" href="{{ route('online.home') }}">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('online.doctors') }}">Our Doctors</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('online.palliative_care') }}">Palliative Care</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('online.air_ambulance') }}">Air Ambulance</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('online.contact') }}">Contact</a></li>
        <li class="nav-item"><a class="nav-link online-back-link ms-lg-2" href="{{ route('landing') }}"><i class="fas fa-th-large me-1"></i>All Services</a></li>
      </ul>
      <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0">
        @auth
        <a href="{{ route('dashboard') }}" class="text-white text-decoration-none fw-medium d-flex align-items-center">
          <div class="nav-avatar me-2" style="background:var(--on-secondary);color:#fff">{{ strtoupper((Auth::user()->profile->first_name ?? Auth::user()->email)[0]) }}</div>
          Dashboard
        </a>
        <a href="{{ route('logout') }}" class="text-white-50 text-decoration-none"><i class="fas fa-right-from-bracket"></i></a>
        @else
        <a href="{{ route('login') }}" class="text-white text-decoration-none fw-medium" style="font-size: 0.95rem;">Login</a>
        <a href="{{ route('online.consult') }}" class="btn btn-online-primary px-3 py-2 fw-bold" style="border-radius: 8px;">Book Now ₹99+</a>
        @endauth
      </div>
    </div>
  </div>
</nav>

<main>@yield('content')</main>

<!-- Online Footer -->
<footer class="online-footer">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-4">
        <div class="on-footer-brand"><i class="fas fa-stethoscope me-2" style="color:#0d9488"></i><span style="color:#fff;font-weight:800">Dr.SOS Online</span></div>
        <p class="on-footer-tagline">Affordable, accessible medical consultations from the comfort of your home. Phone, WhatsApp & Video — we're here when you need us.</p>
        <div class="footer-social mt-3">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="https://wa.me/your-number" target="_blank"><i class="fab fa-whatsapp"></i></a>
        </div>
      </div>
      <div class="col-lg-2 col-6">
        <h6 class="footer-heading">Services</h6>
        <ul class="footer-links">
          <li><a href="{{ route('online.consult') }}">Book Consultation</a></li>
          <li><a href="{{ route('online.doctors') }}">Our Doctors</a></li>
          <li><a href="{{ route('online.palliative_care') }}">Palliative Care</a></li>
          <li><a href="{{ route('online.air_ambulance') }}">Air Ambulance</a></li>
        </ul>
      </div>
      <div class="col-lg-3 col-6">
        <h6 class="footer-heading">Consultation</h6>
        <ul class="footer-links">
          <li><i class="fas fa-phone me-1" style="color:var(--on-secondary)"></i> Phone Call — ₹99</li>
          <li><i class="fab fa-whatsapp me-1" style="color:var(--on-secondary)"></i> WhatsApp — ₹99</li>
          <li><i class="fas fa-video me-1" style="color:var(--on-secondary)"></i> Video Call — ₹199</li>
          <li><i class="fas fa-calendar-days me-1" style="color:var(--on-secondary)"></i> Available Mon–Sat</li>

        </ul>
      </div>
      <div class="col-lg-3">
        <h6 class="footer-heading">Contact</h6>
        <ul class="footer-links">
          <li><i class="fas fa-envelope me-2"></i>online@drsosonline.com</li>
          <li><i class="fab fa-whatsapp me-2"></i>WhatsApp Us</li>
          <li><i class="fas fa-clock me-2"></i>Mon–Sat, 9am–7pm IST</li>
        </ul>
      </div>
    </div>
    <hr class="footer-divider">
    <p class="footer-bottom text-center">© 2024 Dr.SOS Online. All rights reserved. | <a href="{{ route('landing') }}" style="color:rgba(255,255,255,.4)">DrSOS Home</a></p>
  </div>
</footer>

<a href="https://wa.me/your-number" class="whatsapp-float" target="_blank" title="WhatsApp Us"><i class="fab fa-whatsapp"></i></a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/main.js') }}"></script>
@yield('extra_js')
</body>
</html>
