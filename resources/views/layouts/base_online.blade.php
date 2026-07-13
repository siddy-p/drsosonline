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
<nav class="online-nav" id="mainNav">
  <div class="container d-flex align-items-center justify-content-between">
    <a class="online-brand" href="{{ route('online.home') }}">
      <i class="fas fa-stethoscope me-2"></i>
      <span class="on-dr">Dr.</span><span class="on-sos">SOS</span><span class="on-sub"> Online</span>
    </a>
    <button class="navbar-toggler-online" onclick="toggleMobileNav()"><i class="fas fa-bars"></i></button>
    <div class="online-nav-links" id="onlineNavLinks">
      <a href="{{ route('online.home') }}" class="onl">Home</a>
      <a href="{{ route('online.doctors') }}" class="onl">Our Doctors</a>
      <a href="{{ route('online.palliative_care') }}" class="onl">Palliative Care</a>
      <a href="{{ route('online.air_ambulance') }}" class="onl">Air Ambulance</a>
      <a href="{{ route('online.contact') }}" class="onl">Contact</a>
      <a href="{{ route('landing') }}" class="onl onl-portal"><i class="fas fa-th-large me-1"></i>All Services</a>
    </div>
    <div class="online-nav-cta">
      @auth
      <a href="{{ route('dashboard') }}" class="btn btn-online-outline btn-sm">Dashboard</a>
      <a href="{{ route('logout') }}" class="btn btn-online-outline btn-sm">Logout</a>
      @else
      <a href="{{ route('login') }}" class="btn btn-online-outline btn-sm">Login</a>
      @endauth
      <a href="{{ route('online.consult') }}" class="btn btn-online-primary">Book Now ₹99+</a>
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
          <li>📞 Phone Call — ₹99</li>
          <li><i class="fab fa-whatsapp me-1"></i>WhatsApp — ₹99</li>
          <li>🎥 Video Call — ₹199</li>
          <li>⏱ Available Mon–Sat</li>
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
<script>
function toggleMobileNav(){
  const nl = document.getElementById('onlineNavLinks');
  nl.classList.toggle('open');
}
</script>
@yield('extra_js')
</body>
</html>
