<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dr.SOS — Education consultancy and online medical consultations.">
    <title>@yield('title', 'Dr.SOS')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('extra_css')
</head>
<body>

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

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark" id="mainNav">
  <div class="container">
    <a class="navbar-brand" href="{{ route('landing') }}">
      <span class="brand-dr">Dr.</span><span class="brand-sos">SOS</span>
    </a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-1">
        <li class="nav-item"><a class="nav-link" href="{{ route('landing') }}">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('edu.home') }}">EduConsult</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('online.home') }}">Online Consultation</a></li>

        @auth
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
              <div class="nav-avatar">{{ strtoupper(Auth::user()->email[0]) }}</div>
              <span>{{ Auth::user()->profile->first_name ?? 'Account' }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fas fa-gauge-high me-2"></i>Dashboard</a></li>
              <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user me-2"></i>My Profile</a></li>
              <li><a class="dropdown-item" href="{{ route('applications') }}"><i class="fas fa-file-lines me-2"></i>My Applications</a></li>
              @if(Auth::user()->is_admin)
                <li><a class="dropdown-item" href="{{ route('admin') }}"><i class="fas fa-shield me-2"></i>Admin Panel</a></li>
              @endif
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="{{ route('logout') }}"><i class="fas fa-right-from-bracket me-2"></i>Logout</a></li>
            </ul>
          </li>
        @else
          <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
          <li class="nav-item"><a class="btn btn-outline-gold ms-1" href="{{ route('register') }}">Register</a></li>
        @endauth
      </ul>
    </div>
  </div>
</nav>

@yield('content')

<!-- Footer -->
<footer class="footer">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-4 col-md-6">
        <div class="footer-brand mb-3">
          <span class="brand-dr">Dr.</span><span class="brand-sos">SOS</span>
        </div>
        <p class="footer-tagline">Your trusted partner for MBBS abroad education and online medical consultations. Head Office: Kerala, India.</p>
        <div class="footer-social mt-3">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-linkedin-in"></i></a>
          <a href="https://wa.me/your-number" target="_blank"><i class="fab fa-whatsapp"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-6">
        <h6 class="footer-heading">EduConsult</h6>
        <ul class="footer-links">
          <li><a href="{{ route('edu.home') }}">MBBS Abroad</a></li>
          <li><a href="{{ route('edu.education') }}">Education Services</a></li>
          <li><a href="{{ route('edu.book') }}">Book Consultation</a></li>
          <li><a href="{{ route('edu.contact') }}">Contact Us</a></li>
        </ul>
      </div>
      <div class="col-lg-3 col-md-6 col-6">
        <h6 class="footer-heading">Online Consultation</h6>
        <ul class="footer-links">
          <li><a href="{{ route('online.home') }}">Medical Consult</a></li>
          <li><a href="{{ route('online.doctors') }}">Our Doctors</a></li>
          <li><a href="{{ route('online.palliative_care') }}">Palliative Care</a></li>
          <li><a href="{{ route('online.air_ambulance') }}">Air Ambulance</a></li>
        </ul>
      </div>
      <div class="col-lg-2 col-md-6 col-6">
        <h6 class="footer-heading">Contact</h6>
        <ul class="footer-links">
          <li><i class="fas fa-envelope me-1"></i> info@drsosonline.com</li>
          <li><i class="fab fa-whatsapp me-1"></i> WhatsApp Us</li>
          <li><i class="fas fa-location-dot me-1"></i> Kerala, India</li>
        </ul>
      </div>
    </div>
    <hr class="footer-divider">
    <div class="footer-bottom d-flex flex-wrap justify-content-between align-items-center">
      <p class="mb-0">© 2025 Dr.SOS. All rights reserved.</p>
      <p class="mb-0 footer-love">Made with <i class="fas fa-heart text-danger"></i> in Kerala</p>
    </div>
  </div>
</footer>

<a href="https://wa.me/your-number" class="whatsapp-float" target="_blank" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
<div class="custom-cursor" id="customCursor"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/main.js') }}"></script>
@yield('extra_js')
</body>
</html>
