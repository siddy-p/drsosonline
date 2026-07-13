<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dr.SOS EduConsult')</title>
  <meta name="description" content="@yield('meta_desc', 'Dr.SOS EduConsult — MBBS abroad for Indian students. NMC-approved universities, affordable fees, expert guidance from Kerala.')">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
  @yield('extra_css')
</head>
<body>

<!-- Custom cursor -->
<div class="custom-cursor" id="customCursor"></div>

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

<!-- EDU Navbar -->
<nav class="navbar navbar-expand-lg edu-nav" id="mainNav">
  <div class="container">
    <a class="navbar-brand edu-brand" href="{{ route('edu.home') }}">
      <span class="brand-dr">Dr.</span><span class="brand-sos">SOS</span> <span class="brand-sub">EduConsult</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMain">
      <ul class="navbar-nav mx-auto gap-2">
        <li class="nav-item"><a class="nav-link" href="{{ route('edu.home') }}">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('edu.education') }}">MBBS Abroad</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('edu.education') }}#faq">FAQs</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('edu.contact') }}">Contact</a></li>
        <li class="nav-item"><a class="nav-link edu-back-link ms-lg-2" href="{{ route('landing') }}"><i class="fas fa-th-large me-1"></i>All Services</a></li>
      </ul>
      <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0">
        @auth
        <a href="{{ route('dashboard') }}" class="text-white text-decoration-none fw-medium d-flex align-items-center">
          <div class="nav-avatar me-2">{{ strtoupper((Auth::user()->profile->first_name ?? Auth::user()->email)[0]) }}</div>
          Dashboard
        </a>
        <a href="{{ route('logout') }}" class="text-white-50 text-decoration-none"><i class="fas fa-right-from-bracket"></i></a>
        @else
        <a href="{{ route('login') }}" class="text-white text-decoration-none fw-medium" style="font-size: 0.95rem;">Login</a>
        <a href="{{ route('edu.book') }}" class="btn btn-gold px-3 py-2 fw-bold" style="border-radius: 8px;">Free Counselling</a>
        @endauth
      </div>
    </div>
  </div>
</nav>

@yield('content')

<!-- EDU Footer -->
<footer class="footer">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-4">
        <div class="footer-brand"><span class="brand-dr">Dr.</span><span style="color:#fff">SOS</span> <span style="color:rgba(255,255,255,.6);font-weight:400">EduConsult</span></div>
        <p class="footer-tagline mt-2">Your trusted partner for MBBS abroad. We help Indian students from 12th BiPC get admitted to NMC-approved medical universities worldwide. Head Office: Kerala, India.</p>
        <div class="footer-social">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-linkedin-in"></i></a>
          <a href="https://wa.me/your-number" target="_blank"><i class="fab fa-whatsapp"></i></a>
        </div>
      </div>
      <div class="col-lg-2 col-6">
        <h6 class="footer-heading">Services</h6>
        <ul class="footer-links">
          <li><a href="{{ route('edu.education') }}">MBBS Abroad</a></li>
          <li><a href="{{ route('edu.education') }}#faq">FAQs</a></li>
          <li><a href="{{ route('edu.book') }}">Book Counselling</a></li>
          <li><a href="{{ route('edu.contact') }}">Contact Us</a></li>
        </ul>
      </div>
      <div class="col-lg-3 col-6">
        <h6 class="footer-heading">MBBS Destinations</h6>
        <ul class="footer-links">
          <li><a href="{{ route('edu.education') }}#destinations">🇷🇺 Russia</a></li>
          <li><a href="{{ route('edu.education') }}#destinations">🇬🇪 Georgia</a></li>
          <li><a href="{{ route('edu.education') }}#destinations">🇨🇳 China</a></li>
          <li><a href="{{ route('edu.education') }}#destinations">🇰🇿 Kazakhstan</a></li>
          <li><a href="{{ route('edu.education') }}#destinations">🇰🇬 Kyrgyzstan</a></li>
        </ul>
      </div>
      <div class="col-lg-3">
        <h6 class="footer-heading">Contact</h6>
        <ul class="footer-links">
          <li><i class="fas fa-envelope me-2"></i>edu@drsosonline.com</li>
          <li><i class="fab fa-whatsapp me-2"></i>WhatsApp Us</li>
          <li><i class="fas fa-location-dot me-2"></i>Kerala, India</li>
          <li><i class="fas fa-clock me-2"></i>Mon–Sat, 9am–6pm IST</li>
        </ul>
      </div>
    </div>
    <hr class="footer-divider">
    <p class="footer-bottom text-center">© 2025 Dr.SOS EduConsult. All rights reserved. | <a href="{{ route('landing') }}" style="color:rgba(255,255,255,.4)">DrSOS Home</a></p>
  </div>
</footer>

<a href="https://wa.me/your-number" class="whatsapp-float" target="_blank" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/main.js') }}"></script>
@yield('extra_js')
</body>
</html>
