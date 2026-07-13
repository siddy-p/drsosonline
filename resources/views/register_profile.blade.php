@extends('layouts.base')
@section('title', 'Complete Your Profile — Dr.SOS')
@section('content')
<section class="auth-section auth-section-wide">
  <div class="auth-card auth-card-wide">
    <div class="step-indicator">
      <div class="step done"><span><i class="fas fa-check"></i></span><p>Account</p></div>
      <div class="step-line active"></div>
      <div class="step active"><span>2</span><p>Profile</p></div>
      <div class="step-line"></div>
      <div class="step"><span>3</span><p>Education</p></div>
    </div>

    <div class="auth-header">
      <h1>Personal Details</h1>
      <p>Basic information required for your account</p>
    </div>

    <form method="POST" action="{{ route('register.profile.submit') }}">
      @csrf
      <div class="form-section-title"><i class="fas fa-user me-2"></i>Personal Information</div>
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label-auth">First Name *</label>
          <input type="text" name="first_name" class="form-control-auth" placeholder="John" value="{{ old('first_name') }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label-auth">Last Name *</label>
          <input type="text" name="last_name" class="form-control-auth" placeholder="Doe" value="{{ old('last_name') }}" required>
        </div>
        <div class="col-md-4">
          <label class="form-label-auth">Date of Birth *</label>
          <input type="date" name="date_of_birth" class="form-control-auth" value="{{ old('date_of_birth') }}" required>
        </div>
        <div class="col-md-4">
          <label class="form-label-auth">Gender</label>
          <select name="gender" class="form-control-auth">
            <option value="">Select...</option>
            <option {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
            <option {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
            <option {{ old('gender') === 'Non-binary' ? 'selected' : '' }}>Non-binary</option>
            <option {{ old('gender') === 'Prefer not to say' ? 'selected' : '' }}>Prefer not to say</option>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label-auth">Nationality *</label>
          <input type="text" name="nationality" class="form-control-auth" placeholder="e.g. Indian" value="{{ old('nationality', 'Indian') }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label-auth">Phone Number *</label>
          <input type="tel" name="phone" class="form-control-auth" placeholder="+91 00000 00000" value="{{ old('phone') }}" required>
        </div>
      </div>

      <div class="form-section-title mt-4"><i class="fas fa-house me-2"></i>Home Address</div>
      <div class="row g-3">
        <div class="col-12">
          <label class="form-label-auth">Street Address *</label>
          <input type="text" name="street_address" class="form-control-auth" placeholder="123 Main Street" value="{{ old('street_address') }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label-auth">City *</label>
          <input type="text" name="city" class="form-control-auth" placeholder="Mumbai" value="{{ old('city') }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label-auth">County / State</label>
          <input type="text" name="county_state" class="form-control-auth" placeholder="Maharashtra" value="{{ old('county_state') }}">
        </div>
        <div class="col-md-6">
          <label class="form-label-auth">Country *</label>
          <input type="text" name="country" class="form-control-auth" placeholder="India" value="{{ old('country', 'India') }}" required>
        </div>
        <div class="col-md-6">
          <label class="form-label-auth">Postcode / ZIP</label>
          <input type="text" name="postcode" class="form-control-auth" placeholder="400001" value="{{ old('postcode') }}">
        </div>
      </div>

      <div class="form-section-title mt-4"><i class="fas fa-passport me-2"></i>Passport / ID</div>
      <div class="row g-3">
        <div class="col-md-4">
          <label class="form-label-auth">Passport Number</label>
          <input type="text" name="passport_number" class="form-control-auth" placeholder="A12345678" value="{{ old('passport_number') }}">
        </div>
        <div class="col-md-4">
          <label class="form-label-auth">Expiry Date</label>
          <input type="date" name="passport_expiry" class="form-control-auth" value="{{ old('passport_expiry') }}">
        </div>
        <div class="col-md-4">
          <label class="form-label-auth">Issuing Country</label>
          <input type="text" name="passport_country" class="form-control-auth" placeholder="India" value="{{ old('passport_country', 'India') }}">
        </div>
      </div>

      <div class="d-flex flex-column gap-2 mt-4">
        <button type="submit" name="action" value="finish" class="btn-auth-submit" style="background: linear-gradient(135deg,#0d9488,#14b8a6); color: #fff;">
          Finish Registration (Medical Only) <i class="fas fa-check ms-2"></i>
        </button>
        <button type="submit" name="action" value="edu" class="btn-ghost-dark text-center justify-content-center">
          Continue to Education Details <i class="fas fa-arrow-right ms-2"></i>
        </button>
      </div>
    </form>
  </div>
</section>
@endsection
