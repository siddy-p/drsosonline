@extends('layouts.base_online')
@section('title', 'Contact Us — Dr.SOS Online')
@section('content')
<section class="on-page-hero">
  <div class="container text-center">
    <h1><i class="fas fa-envelope me-3"></i>Contact Us</h1>
    <p class="lead">We typically respond within 30 minutes during working hours</p>
  </div>
</section>
<section class="on-section">
  <div class="container">
    <div class="row g-5 align-items-start">
      <div class="col-lg-5 reveal">
        <div class="on-contact-info">
          <h4>Get in Touch</h4>
          <div class="on-contact-item"><i class="fab fa-whatsapp"></i><div><strong>WhatsApp</strong><span>Message us anytime</span></div></div>
          <div class="on-contact-item"><i class="fas fa-envelope"></i><div><strong>Email</strong><span>online@drsosonline.com</span></div></div>
          <div class="on-contact-item"><i class="fas fa-clock"></i><div><strong>Working Hours</strong><span>Mon–Sat, 9am–7pm IST</span></div></div>
          <div class="on-contact-item on-emergency-contact"><i class="fas fa-triangle-exclamation"></i><div><strong>Emergency / Air Ambulance</strong><span>24/7 — Call immediately</span></div></div>
        </div>
      </div>
      <div class="col-lg-7 reveal">
        <form action="{{ route('online.contact.submit') }}" method="POST" class="on-book-form">
          @csrf
          <div class="row g-3">
            <div class="col-md-6">
              <label class="on-label">Your Name *</label>
              <input type="text" name="name" class="on-input" value="{{ old('name') }}" required placeholder="Full name">
            </div>
            <div class="col-md-6">
              <label class="on-label">Phone Number</label>
              <input type="tel" name="phone" class="on-input" value="{{ old('phone') }}" placeholder="+91 XXXXX XXXXX">
            </div>
            <div class="col-12">
              <label class="on-label">Email Address *</label>
              <input type="email" name="email" class="on-input" value="{{ old('email') }}" required placeholder="your@email.com">
            </div>
            <div class="col-12">
              <label class="on-label">Subject *</label>
              <select name="subject" class="on-input" required>
                <option value="">Select a subject</option>
                <option {{ old('subject') === 'Book a Consultation' ? 'selected' : '' }}>Book a Consultation</option>
                <option {{ old('subject') === 'Palliative Care Enquiry' ? 'selected' : '' }}>Palliative Care Enquiry</option>
                <option {{ old('subject') === 'Air Ambulance / Emergency' ? 'selected' : '' }}>Air Ambulance / Emergency</option>
                <option {{ old('subject') === 'Doctor Referral' ? 'selected' : '' }}>Doctor Referral</option>
                <option {{ old('subject') === 'General Enquiry' ? 'selected' : '' }}>General Enquiry</option>
              </select>
            </div>
            <div class="col-12">
              <label class="on-label">Message *</label>
              <textarea name="message" class="on-input on-textarea" rows="5" required placeholder="How can we help you?">{{ old('message') }}</textarea>
            </div>
            <div class="col-12">
              <button type="submit" class="btn-online-book-lg w-100">Send Message <i class="fas fa-paper-plane ms-2"></i></button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection
