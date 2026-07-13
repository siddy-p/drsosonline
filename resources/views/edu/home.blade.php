@extends('layouts.base_edu')
@section('title', 'Dr.SOS EduConsult — MBBS Abroad for Indian Students')
@section('content')

<!-- HERO -->
<section class="hero-home">
  <div class="hero-blob hero-blob-1"></div>
  <div class="hero-blob hero-blob-2"></div>
  <div class="container hero-home-inner">
    <div class="row align-items-center g-5">
      <div class="col-lg-6 hero-text-col">
        <div class="hero-badge"><i class="fas fa-shield-halved me-2" style="color: var(--gold)"></i> Trusted by 1,000+ Medical Students from India</div>
        <h1 class="hero-heading">Study <span class="hero-highlight">MBBS Abroad</span> — Your Medical Career Starts Here</h1>
        <p class="hero-subtext">Expert guidance for Indian students seeking MBBS abroad. NMC-approved universities, affordable fees, and complete support from our Kerala office.</p>
        <div class="hero-actions">
          <a href="{{ route('edu.book') }}" class="btn btn-gold btn-lg">Book Free Counselling</a>
          <a href="{{ route('edu.education') }}" class="btn-ghost-white">Explore Countries <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
        <div class="hero-trust-pills">
          <span><i class="fas fa-circle-check"></i> NMC Approved</span>
          <span><i class="fas fa-circle-check"></i> 95% Success Rate</span>
          <span><i class="fas fa-circle-check"></i> Free Counselling</span>
        </div>
      </div>
      <div class="col-lg-6 text-center hero-img-col">
        <div class="hero-img-wrap">
          <div class="hero-float-card hero-float-top">
            <i class="fas fa-stethoscope"></i>
            <div><strong>95%</strong><span>Admission Success</span></div>
          </div>
          <img src="{{ asset('images/hero.jpg') }}" class="hero-img" alt="Indian students studying MBBS abroad">
          <div class="hero-float-card hero-float-bottom">
            <i class="fas fa-graduation-cap"></i>
            <div><strong>500+</strong><span>Students Placed</span></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- STATS -->
<section class="stats-bar">
  <div class="container">
    <div class="stats-grid">
      <div class="stat-pill reveal"><span class="stat-num"><span class="counter" data-target="1000">0</span>+</span><span class="stat-label">Students Placed</span></div>
      <div class="stat-divider"></div>
      <div class="stat-pill reveal"><span class="stat-num"><span class="counter" data-target="95">0</span>%</span><span class="stat-label">Admission Success</span></div>
      <div class="stat-divider"></div>
      <div class="stat-pill reveal"><span class="stat-num"><span class="counter" data-target="8">0</span>+</span><span class="stat-label">Countries</span></div>
      <div class="stat-divider"></div>
      <div class="stat-pill reveal"><span class="stat-num"><span class="counter" data-target="30">0</span>+</span><span class="stat-label">NMC Universities</span></div>
    </div>
  </div>
</section>

<!-- WHO IS THIS FOR -->
<section class="section-padded" style="background:#f8faf9;">
  <div class="container">
    <div class="section-header reveal">
      <p class="section-eyebrow">Who Is This For?</p>
      <h2 class="section-title">Perfect for Indian Students After 12th (BiPC)</h2>
    </div>
    <div class="row g-4 mt-2">
      @foreach ([
        ['fa-user-graduate','12th BiPC Students','Completed 12th with Biology, Physics & Chemistry? You are eligible for MBBS abroad with NEET qualification.'],
        ['fa-indian-rupee-sign','Budget-Friendly MBBS','Total fees from ₹15–35 Lakhs for the full course — a fraction of private medical college costs in India.'],
        ['fa-building-columns','NMC/WHO Recognised','All our partner universities are approved by NMC (formerly MCI) and listed with WHO, so your degree is valid in India.'],
        ['fa-plane-departure','No Donation, No Capitation','Direct admission based on merit. No management quota, no donation — transparent process from start to finish.'],
        ['fa-language','English Medium','All courses are taught in English. No need to learn a foreign language before you start.'],
        ['fa-handshake','PG & FMGE Support','We support you even after MBBS — coaching for FMGE/NEXT exam and guidance for PG (MD/MS) in India or abroad.']
      ] as $item)
      <div class="col-lg-4 col-md-6 reveal">
        <div class="home-service-card">
          <div class="hsc-icon"><i class="fas {{ $item[0] }}"></i></div>
          <h4>{{ $item[1] }}</h4><p>{{ $item[2] }}</p>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

<!-- DESTINATIONS -->
<section class="destinations-home">
  <div class="container">
    <div class="section-header reveal" style="color:#fff">
      <p class="section-eyebrow" style="color:var(--gold)">MBBS Destinations</p>
      <h2 class="section-title text-white">Top Countries for Indian Medical Students</h2>
    </div>
    <div class="dest-scroll-row reveal">
      <div class="dest-tile"><span class="dest-flag">🇷🇺</span><strong>Russia</strong></div>
      <div class="dest-tile"><span class="dest-flag">🇬🇪</span><strong>Georgia</strong></div>
      <div class="dest-tile"><span class="dest-flag">🇨🇳</span><strong>China</strong></div>
      <div class="dest-tile"><span class="dest-flag">🇰🇿</span><strong>Kazakhstan</strong></div>
      <div class="dest-tile"><span class="dest-flag">🇰🇬</span><strong>Kyrgyzstan</strong></div>
      <div class="dest-tile"><span class="dest-flag">🇺🇿</span><strong>Uzbekistan</strong></div>
      <div class="dest-tile"><span class="dest-flag">🇬🇧</span><strong>UK (PG)</strong></div>

    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section class="section-padded how-home">
  <div class="container">
    <div class="section-header reveal"><p class="section-eyebrow">Simple Process</p><h2 class="section-title">How It Works</h2></div>
    <div class="how-steps-row">
      @foreach ([
        ['01','Free Counselling','Book a free call with our MBBS abroad expert from our Kerala office.'],
        ['02','University Selection','We shortlist NMC-approved universities matching your budget and NEET score.'],
        ['03','Admission & Visa','We handle the full admission process, documentation, and visa application.'],
        ['04','Fly & Study','Pre-departure briefing, airport pickup, and hostel arrangement — we are with you until you land.']
      ] as $step)
      <div class="how-home-step reveal">
        <div class="hhs-num">{{ $step[0] }}</div>
        <div class="hhs-icon"><i class="fas {{ $loop->iteration == 1 ? 'fa-calendar-check' : ($loop->iteration == 2 ? 'fa-magnifying-glass-chart' : ($loop->iteration == 3 ? 'fa-file-circle-check' : 'fa-plane')) }}"></i></div>
        <h5>{{ $step[1] }}</h5><p>{{ $step[2] }}</p>
      </div>
      @if(!$loop->last)<div class="how-connector"></div>@endif
      @endforeach
    </div>
  </div>
</section>

<!-- TESTIMONIALS -->
<section class="section-padded testimonial-home">
  <div class="container">
    <div class="section-header reveal" style="color:#fff">
      <p class="section-eyebrow" style="color:var(--gold)">Success Stories</p>
      <h2 class="section-title text-white">What Our Students Say</h2>
    </div>
    <div class="testimonials-slider reveal" id="testimonialSlider">
      @foreach ([
        ['"Dr.SOS made my dream of becoming a doctor possible. I got into a top NMC-approved university in Russia and the entire process was handled from their Kerala office!"','Ananya R. — Kerala → Russia, MBBS','A'],
        ['"After struggling with NEET cutoffs for private colleges, I found MBBS abroad through Dr.SOS. Now studying in Georgia with world-class facilities at half the cost."','Vishnu M. — Karnataka → Georgia, MBBS','V'],
        ['"The team helped me from NEET counselling to airport pickup in China. My parents were worried but Dr.SOS made everything transparent and safe."','Sneha P. — Tamil Nadu → China, MBBS','S']
      ] as $t)
      <div class="testimonial-slide {{ $loop->first ? 'active' : '' }}">
        <div class="testimonial-card">
          <p class="testimonial-quote">{{ $t[0] }}</p>
          <div class="testimonial-author">
            <div class="testimonial-avatar">{{ $t[2] }}</div>
            <div><strong>{{ $t[1] }}</strong></div>
            <div class="ms-auto" style="color:var(--gold);"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    <div class="testimonial-dots text-center mt-4">
      <span class="t-dot active" onclick="goToSlide(0)"></span>
      <span class="t-dot" onclick="goToSlide(1)"></span>
      <span class="t-dot" onclick="goToSlide(2)"></span>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta-home">
  <div class="container">
    <div class="cta-home-inner reveal">
      <div>
        <h2>Ready to Start Your MBBS Journey?</h2>
        <p>Join 1,000+ Indian students who trusted Dr.SOS EduConsult for MBBS abroad.</p>
      </div>
      <div class="cta-home-btns">
        <a href="{{ route('register') }}" class="btn btn-gold btn-lg">Create Free Account</a>
        <a href="{{ route('edu.book') }}" class="btn-ghost-dark">Book Free Counselling</a>
      </div>
    </div>
  </div>
</section>

@endsection
