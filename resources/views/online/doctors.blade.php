@extends('layouts.base_online')
@section('title', 'Our Doctors — Dr.SOS Online')
@section('content')

<section class="on-page-hero">
  <div class="container text-center">
    <h1><i class="fas fa-user-doctor me-3"></i>Our Doctors</h1>
    <p class="lead">Experienced, verified physicians available for phone, WhatsApp &amp; video consultations</p>
  </div>
</section>

<section class="on-section">
  <div class="container">
    <!-- Filter bar -->
    <div class="on-filter-bar reveal">
      <a href="{{ route('online.doctors') }}" class="on-filter-btn {{ empty($selected) ? 'active' : '' }}">All Specialties</a>
      @foreach ($specialties as $spec)
      <a href="{{ route('online.doctors', ['specialty' => $spec]) }}" class="on-filter-btn {{ $selected == $spec ? 'active' : '' }}">{{ $spec }}</a>
      @endforeach
    </div>

    <div class="row g-4 mt-3">
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
            <p class="on-doc-exp"><i class="fas fa-briefcase me-1"></i>{{ $doc->years_experience }} years experience</p>
            <div class="on-doc-langs">
              @foreach ($doc->language_list as $lang)<span>{{ $lang }}</span>@endforeach
            </div>
            <div class="on-doc-days"><i class="fas fa-calendar me-1"></i>{{ str_replace(',', ' · ', $doc->available_days) }}</div>
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
      @if(count($doctors) === 0)
      <div class="col-12 text-center py-5">
        <i class="fas fa-user-doctor fa-3x mb-3" style="color:#0d9488;opacity:.4"></i>
        <h5 style="color:#666">No doctors found for this specialty</h5>
        <a href="{{ route('online.doctors') }}" class="btn-online-sm mt-3 d-inline-block">View All</a>
      </div>
      @endif
    </div>
  </div>
</section>

@endsection
