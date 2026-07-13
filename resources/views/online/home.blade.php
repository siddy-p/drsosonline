@extends('layouts.base_online')
@section('title', 'Dr.SOS Online — See a Doctor Today from ₹99')
@section('content')

<!-- HERO -->
<section class="on-hero">
  <div class="on-hero-blob on-blob-1"></div>
  <div class="on-hero-blob on-blob-2"></div>
  <div class="on-hero-blob on-blob-3"></div>
  <div class="container on-hero-inner">
    <div class="row align-items-center g-5">
      <div class="col-lg-6 on-hero-text">
        <div class="on-badge"><span class="on-badge-dot"></span>Available Mon–Sat · 9am–7pm IST</div>
        <h1 class="on-hero-h1">See a Doctor <br><span class="on-accent">From ₹99</span></h1>
        <p class="on-hero-sub">Phone, WhatsApp or video consultations with experienced doctors — from the comfort of your home. Quick, affordable, and confidential.</p>
        <div class="on-consult-cards">
          <div class="on-price-card">
            <div class="on-price-icon phone-icon"><i class="fas fa-phone"></i></div>
            <div>
              <strong>Phone / WhatsApp</strong>
              <span>General, follow-up, quick consult</span>
            </div>
            <div class="on-price-tag">₹99</div>
          </div>
          <div class="on-price-card on-price-featured">
            <div class="on-price-icon video-icon"><i class="fas fa-video"></i></div>
            <div>
              <strong>Video Consultation</strong>
              <span>Face-to-face with your doctor</span>
            </div>
            <div class="on-price-tag">₹199</div>
          </div>
        </div>
        <div class="on-hero-actions">
          <a href="{{ route('online.consult') }}" class="btn-online-book">Book Appointment <i class="fas fa-arrow-right"></i></a>
          <a href="{{ route('online.doctors') }}" class="btn-online-ghost">View Doctors</a>
        </div>
        <div class="on-trust-strip">
          <span><i class="fas fa-shield-halved"></i> 100% Confidential</span>
          <span><i class="fas fa-clock"></i> Confirmed in 30 min</span>
          <span><i class="fas fa-star" style="color:var(--on-gold)"></i> 4.9/5 Rating</span>
        </div>
      </div>
      <div class="col-lg-6 on-hero-img-col">
        <div class="on-hero-img-wrap">
          <img src="{{ asset('images/online_hero.png') }}" class="on-hero-img" alt="Online Doctor Consultation">
          <div class="on-float-card on-float-top">
            <i class="fas fa-user-doctor"></i>
            <div><strong>{{ count($doctors) }}+</strong><span>Expert Doctors</span></div>
          </div>
          <div class="on-float-card on-float-bottom">
            <i class="fas fa-calendar-check"></i>
            <div><strong>500+</strong><span>Consultations Done</span></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- STATS -->
<section class="on-stats-bar">
  <div class="container">
    <div class="on-stats-grid">
      <div class="on-stat reveal"><span class="on-stat-n"><span class="counter" data-target="500">0</span>+</span><span>Patients Served</span></div>
      <div class="on-stat-div"></div>
      <div class="on-stat reveal"><span class="on-stat-n"><span class="counter" data-target="2">0</span>+</span><span>Specialist Doctors</span></div>
      <div class="on-stat-div"></div>
      <div class="on-stat reveal"><span class="on-stat-n">₹99</span><span>Starting Price</span></div>
      <div class="on-stat-div"></div>
      <div class="on-stat reveal"><span class="on-stat-n">4.9<i class="fas fa-star ms-1" style="color:#f59e0b;font-size:.8rem"></i></span><span>Average Rating</span></div>
    </div>
  </div>
</section>


<!-- HOW IT WORKS -->
<section class="on-section">
  <div class="container">
    <div class="on-section-header reveal">
      <p class="on-eyebrow">Simple &amp; Fast</p>
      <h2>How It Works</h2>
    </div>
    <div class="on-steps-row">
      @foreach ([
        ['fa-calendar-plus','01','Book Your Slot','Choose your doctor, preferred time, and consultation type — phone, WhatsApp or video.'],
        ['fa-circle-check','02','We Confirm',"You'll receive a confirmation call or message within 30 minutes of booking."],
        ['fa-stethoscope','03','Consult Doctor','At your scheduled time, your doctor calls you directly — no travel, no waiting.'],
        ['fa-file-medical','04','Get Prescription','Receive your prescription or health advice digitally after your consultation.']
      ] as $step)
      <div class="on-step reveal">
        <div class="on-step-num">{{ $step[1] }}</div>
        <div class="on-step-icon"><i class="fas {{ $step[0] }}"></i></div>
        <h5>{{ $step[2] }}</h5>
        <p>{{ $step[3] }}</p>
      </div>
      @if(!$loop->last)<div class="on-step-connector"></div>@endif
      @endforeach
    </div>
  </div>
</section>

<!-- FEATURED DOCTORS -->
<section class="on-section on-doctors-home">
  <div class="container">
    <div class="on-section-header reveal">
      <p class="on-eyebrow">Meet Our Team</p>
      <h2>Our Doctors</h2>
      <a href="{{ route('online.doctors') }}" class="on-see-all">See All Doctors <i class="fas fa-arrow-right"></i></a>
    </div>
    <div class="row g-4 mt-2">
      @foreach ($doctors as $doc)
      <div class="col-lg-4 col-md-6 reveal">
        <div class="on-doc-card">
          <div class="on-doc-photo-wrap">
            <img src="{{ asset($doc->photo_url) }}" alt="{{ $doc->name }}" class="on-doc-photo">
            <div class="on-doc-rating"><i class="fas fa-star"></i> {{ $doc->rating }}</div>
          </div>
          <div class="on-doc-info">
            <h5>{{ $doc->name }}</h5>
            <p class="on-doc-spec">{{ $doc->specialty }}</p>
            <p class="on-doc-qual">{{ $doc->qualification }}</p>
            <div class="on-doc-langs">
              @foreach ($doc->language_list as $lang)<span>{{ $lang }}</span>@endforeach
            </div>
            <div class="on-doc-fees">
              <span><i class="fas fa-phone"></i> ₹{{ $doc->fee_phone }}</span>
              <span><i class="fas fa-video"></i> ₹{{ $doc->fee_video }}</span>
            </div>
            <div class="on-doc-actions">
              <a href="{{ route('online.doctors.show', $doc->id) }}" class="btn-online-outline-sm">View Profile</a>
              <a href="{{ route('online.consult', ['doctor_id' => $doc->id]) }}" class="btn-online-sm">Book Now</a>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

<!-- SERVICES STRIP -->
<section class="on-services-strip">
  <div class="container">
    <div class="on-section-header reveal" style="color:#fff">
      <p class="on-eyebrow" style="color:#5eead4">More Services</p>
      <h2 style="color:#fff">Comprehensive Healthcare</h2>
    </div>
    <div class="row g-4 mt-2">
      @foreach ([
        ['fa-heart-pulse','Palliative Care','Compassionate in-home care for patients with serious illness — dignified and expert.', route('online.palliative_care')],
        ['fa-helicopter','Air Ambulance','24/7 medical air transport for emergencies across India.', route('online.air_ambulance')],
        ['fa-user-doctor','Specialist Referrals','We connect you with specialist consultants in cardiology, orthopaedics, neurology & more.', route('online.doctors')],
        ['fa-notes-medical','Second Opinion','Get a second medical opinion from our panel of experienced consultants.', route('online.consult')]
      ] as $service)
      <div class="col-lg-3 col-md-6 reveal">
        <div class="on-service-card">
          <div class="on-svc-icon"><i class="fas {{ $service[0] }}"></i></div>
          <h5>{{ $service[1] }}</h5>
          <p>{{ $service[2] }}</p>
          <a href="{{ $service[3] }}" class="on-svc-link">Learn more <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

<!-- TESTIMONIALS -->
<section class="on-section" style="background: linear-gradient(135deg, var(--on-primary), var(--on-dark)); color: #fff; padding: 80px 0;">
  <div class="container">
    <div class="on-section-header reveal" style="color:#fff">
      <p class="on-eyebrow" style="color:var(--on-secondary)">Patient Reviews</p>
      <h2 class="text-white">What Our Patients Say</h2>
    </div>
    <div class="testimonials-slider reveal" id="testimonialSlider">
      @foreach ([
        ['"Booked a phone consultation and the doctor called me within the hour. So convenient and affordable!"','Riya Patel — Ahmedabad','R'],
        ['"My child had a fever at midnight. Dr. Mehta was available on WhatsApp and guided us through. Lifesaver!"','Suresh Kumar — Chennai','S'],
        ['"Highly professional. Video call with Dr. Sharma was just like being in a clinic — she was thorough and kind."','Anjali Nair — Kochi','A']
      ] as $review)
      <div class="testimonial-slide {{ $loop->first ? 'active' : '' }}">
        <div class="testimonial-card" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #fff; max-width: 720px; margin: 0 auto; padding: 36px; border-radius: 16px;">
          <p class="testimonial-quote" style="font-size: 1.1rem; font-style: italic; line-height: 1.7; margin-bottom: 24px; color: rgba(255,255,255,0.95);">{{ $review[0] }}</p>
          <div class="testimonial-author" style="display: flex; align-items: center; gap: 14px;">
            <div class="testimonial-avatar" style="width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.2rem; flex-shrink: 0; background: var(--on-secondary); color: #fff;">{{ $review[2] }}</div>
            <div><strong>{{ $review[1] }}</strong></div>
            <div class="ms-auto">⭐⭐⭐⭐⭐</div>
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
<section class="on-cta">
  <div class="container">
    <div class="on-cta-inner reveal">
      <div class="on-cta-text">
        <h2>Talk to a Doctor Today</h2>
        <p>Phone or WhatsApp from ₹99 · Video from ₹199 · Confirmed in 30 minutes</p>
      </div>
      <a href="{{ route('online.consult') }}" class="btn-online-book-lg">Book Appointment <i class="fas fa-arrow-right"></i></a>
    </div>
  </div>
</section>

@endsection
