@extends('layouts.base_edu')
@section('title', 'Contact Us — Dr.SOS EduConsult')
@section('content')

<section class="page-hero page-hero-green fade-in">
  <div class="container text-center text-white">
    <h1 class="display-5 fw-bold">Get In Touch</h1>
    <p class="lead">Our MBBS abroad experts are ready to guide you — Head Office: Kerala</p>
  </div>
</section>

<section class="container my-5">
  <div class="row g-5 align-items-start">
    <!-- Contact Form -->
    <div class="col-lg-7 fade-in">
      <div class="dashboard-card">
        <h3 class="mb-4"><i class="fas fa-paper-plane me-2 text-success"></i>Send Us a Message</h3>
        <form method="POST" action="{{ route('edu.contact.submit') }}">
          @csrf
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label-auth">Full Name *</label>
              <input type="text" name="name" class="form-control-auth" placeholder="John Doe" value="{{ old('name') }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label-auth">Email Address *</label>
              <input type="email" name="email" class="form-control-auth" placeholder="you@example.com" value="{{ old('email') }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label-auth">Phone Number</label>
              <input type="tel" name="phone" class="form-control-auth" placeholder="+91 98765 43210" value="{{ old('phone') }}">
            </div>
            <div class="col-md-6">
              <label class="form-label-auth">Subject *</label>
              <select name="subject" class="form-control-auth" required>
                <option value="">Select a topic...</option>
                <option {{ old('subject') === 'MBBS Abroad Enquiry' ? 'selected' : '' }}>MBBS Abroad Enquiry</option>
                <option {{ old('subject') === 'NEET Score Assessment' ? 'selected' : '' }}>NEET Score Assessment</option>
                <option {{ old('subject') === 'University & Country Info' ? 'selected' : '' }}>University & Country Info</option>
                <option {{ old('subject') === 'Visa & Documentation' ? 'selected' : '' }}>Visa & Documentation</option>
                <option {{ old('subject') === 'Education Loan Help' ? 'selected' : '' }}>Education Loan Help</option>
                <option {{ old('subject') === 'PG / MD / MS Abroad' ? 'selected' : '' }}>PG / MD / MS Abroad</option>
                <option {{ old('subject') === 'FMGE / NEXT Guidance' ? 'selected' : '' }}>FMGE / NEXT Guidance</option>
                <option {{ old('subject') === 'General Enquiry' ? 'selected' : '' }}>General Enquiry</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label-auth">Message *</label>
              <textarea name="message" class="form-control-auth" rows="5" placeholder="Tell us how we can help you..." required>{{ old('message') }}</textarea>
            </div>
          </div>
          <button type="submit" class="btn-auth-submit mt-3">
            <i class="fas fa-paper-plane me-2"></i>Send Message
          </button>
        </form>
      </div>
    </div>

    <!-- Contact Info -->
    <div class="col-lg-5 fade-in">
      <div class="contact-info-card">
        <h4 class="mb-4">Contact Information</h4>
        <div class="contact-info-item"><div class="contact-icon"><i class="fas fa-envelope"></i></div><div><strong>Email</strong><p>edu@drsosonline.com</p></div></div>
        <div class="contact-info-item"><div class="contact-icon"><i class="fas fa-phone"></i></div><div><strong>Phone</strong><p>+91 XXXXX XXXXX</p></div></div>
        <div class="contact-info-item"><div class="contact-icon"><i class="fab fa-whatsapp"></i></div><div><strong>WhatsApp</strong><p>+91 XXXXX XXXXX</p></div></div>
        <div class="contact-info-item"><div class="contact-icon"><i class="fas fa-location-dot"></i></div><div><strong>Head Office</strong><p>Kerala, India</p></div></div>
        <div class="contact-info-item"><div class="contact-icon"><i class="fas fa-clock"></i></div><div><strong>Hours</strong><p>Mon–Sat: 9am – 6pm IST<br>Sundays: By appointment</p></div></div>

        <a href="https://wa.me/your-number" class="btn btn-success w-100 mt-3" target="_blank">
          <i class="fab fa-whatsapp me-2"></i>Chat on WhatsApp
        </a>
      </div>

      <!-- Map Placeholder -->
      <div class="map-placeholder fade-in mt-4">
        <i class="fas fa-map-location-dot"></i>
        <p>Kerala, India — Full map coming soon</p>
      </div>
    </div>
  </div>
</section>
@endsection
