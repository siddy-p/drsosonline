@extends('layouts.base_edu')
@section('title', 'Book Free MBBS Counselling — Dr.SOS EduConsult')
@section('content')

<section class="page-hero page-hero-gold fade-in">
  <div class="container text-center">
    <h1 class="display-5 fw-bold">Book Free MBBS Counselling</h1>
    <p class="lead">Get expert guidance on MBBS abroad from our Kerala office</p>
  </div>
</section>

<section class="container my-5">
  <div class="row justify-content-center">
    <div class="col-lg-8 fade-in">
      <div class="dashboard-card">
        <h3 class="mb-1"><i class="fas fa-calendar-plus me-2 text-success"></i>Schedule Your MBBS Counselling</h3>
        <p class="text-muted mb-4">Free 30-minute session with our MBBS abroad expert.</p>
        <form method="POST" action="{{ route('edu.book.submit') }}">
          @csrf
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label-auth">Full Name *</label>
              <input type="text" name="name" class="form-control-auth" placeholder="John Doe" required
                value="{{ old('name', Auth::check() ? Auth::user()->profile->full_name : '') }}">
            </div>
            <div class="col-md-6">
              <label class="form-label-auth">Email Address *</label>
              <input type="email" name="email" class="form-control-auth" placeholder="you@example.com" required
                value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}">
            </div>
            <div class="col-md-6">
              <label class="form-label-auth">Phone Number</label>
              <input type="tel" name="phone" class="form-control-auth" placeholder="+91 98765 43210"
                value="{{ old('phone', Auth::check() ? Auth::user()->profile->phone : '') }}">
            </div>
            <div class="col-md-6">
              <label class="form-label-auth">Service *</label>
              <select name="service" class="form-control-auth" required>
                <option value="">Select a service...</option>
                <option {{ old('service') === 'MBBS Abroad — Admission Guidance' ? 'selected' : '' }}>MBBS Abroad — Admission Guidance</option>
                <option {{ old('service') === 'NEET Score Assessment' ? 'selected' : '' }}>NEET Score Assessment</option>
                <option {{ old('service') === 'University & Country Selection' ? 'selected' : '' }}>University & Country Selection</option>
                <option {{ old('service') === 'Visa & Documentation Support' ? 'selected' : '' }}>Visa & Documentation Support</option>
                <option {{ old('service') === 'Education Loan Assistance' ? 'selected' : '' }}>Education Loan Assistance</option>
                <option {{ old('service') === 'PG / MD / MS Abroad' ? 'selected' : '' }}>PG / MD / MS Abroad</option>
                <option {{ old('service') === 'FMGE / NEXT Exam Guidance' ? 'selected' : '' }}>FMGE / NEXT Exam Guidance</option>
                <option {{ old('service') === 'General Enquiry' ? 'selected' : '' }}>General Enquiry</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label-auth">Preferred Date *</label>
              <input type="date" name="preferred_date" class="form-control-auth" value="{{ old('preferred_date') }}" required>
            </div>
            <div class="col-md-6">
              <label class="form-label-auth">Preferred Time</label>
              <select name="preferred_time" class="form-control-auth">
                <option {{ old('preferred_time') === 'Morning (9am – 12pm)' ? 'selected' : '' }}>Morning (9am – 12pm)</option>
                <option {{ old('preferred_time') === 'Afternoon (12pm – 3pm)' ? 'selected' : '' }}>Afternoon (12pm – 3pm)</option>
                <option {{ old('preferred_time') === 'Late Afternoon (3pm – 6pm)' ? 'selected' : '' }}>Late Afternoon (3pm – 6pm)</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label-auth">Message / Notes</label>
              <textarea name="message" class="form-control-auth" rows="4" placeholder="Tell us what you'd like to discuss in the consultation...">{{ old('message') }}</textarea>
            </div>
          </div>
          <button type="submit" class="btn-auth-submit mt-3">
            <i class="fas fa-calendar-check me-2"></i>Confirm Booking
          </button>
        </form>
      </div>
    </div>

    <!-- Side Info -->
    <div class="col-lg-4 fade-in">
      <div class="booking-info-card">
        <h5><i class="fas fa-circle-check me-2 text-success"></i>What to Expect</h5>
        <ul class="booking-expect-list">
          <li><i class="fas fa-check"></i> 30-minute video or phone call</li>
          <li><i class="fas fa-check"></i> Expert advice tailored to you</li>
          <li><i class="fas fa-check"></i> University shortlist suggestions</li>
          <li><i class="fas fa-check"></i> Visa route overview</li>
          <li><i class="fas fa-check"></i> No commitment required</li>
        </ul>
        <div class="booking-wa mt-4">
          <p>Prefer to message us?</p>
          <a href="https://wa.me/your-number" class="btn btn-success w-100" target="_blank">
            <i class="fab fa-whatsapp me-2"></i>WhatsApp Us
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
