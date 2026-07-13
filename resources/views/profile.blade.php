@extends('layouts.base')
@section('title', 'My Profile — Dr.SOS')
@section('content')
<section class="dashboard-section">
  <div class="container">
    <div class="dashboard-welcome fade-in">
      <div>
        <h1><i class="fas fa-user-edit me-2"></i>My Profile</h1>
        <p>Keep your details up to date to ensure the best advice and consultation services.</p>
      </div>
      @if($profile)
        <span class="badge-pct">{{ $profile->completion_percentage }}% Complete</span>
      @endif
    </div>

    <form method="POST" action="{{ route('profile.update') }}">
      @csrf
      <!-- Personal -->
      <div class="dashboard-card fade-in mb-4">
        <div class="form-section-title mb-3"><i class="fas fa-user me-2"></i>Personal Information</div>
        <div class="row g-3">
          <div class="col-md-6"><label class="form-label-auth">First Name</label><input type="text" name="first_name" class="form-control-auth" value="{{ $profile->first_name ?? '' }}"></div>
          <div class="col-md-6"><label class="form-label-auth">Last Name</label><input type="text" name="last_name" class="form-control-auth" value="{{ $profile->last_name ?? '' }}"></div>
          <div class="col-md-4"><label class="form-label-auth">Date of Birth</label><input type="date" name="date_of_birth" class="form-control-auth" value="{{ $profile->date_of_birth ?? '' }}"></div>
          <div class="col-md-4"><label class="form-label-auth">Gender</label>
            <select name="gender" class="form-control-auth">
              <option value="">Select...</option>
              @foreach (['Male','Female','Non-binary','Prefer not to say'] as $g)
                <option {{ ($profile->gender ?? '') === $g ? 'selected' : '' }}>{{ $g }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4"><label class="form-label-auth">Nationality</label><input type="text" name="nationality" class="form-control-auth" value="{{ $profile->nationality ?? '' }}"></div>
          <div class="col-md-6"><label class="form-label-auth">Phone</label><input type="tel" name="phone" class="form-control-auth" value="{{ $profile->phone ?? '' }}"></div>
        </div>
      </div>

      <!-- Address -->
      <div class="dashboard-card fade-in mb-4">
        <div class="form-section-title mb-3"><i class="fas fa-house me-2"></i>Home Address</div>
        <div class="row g-3">
          <div class="col-12"><label class="form-label-auth">Street Address</label><input type="text" name="street_address" class="form-control-auth" value="{{ $profile->street_address ?? '' }}"></div>
          <div class="col-md-6"><label class="form-label-auth">City</label><input type="text" name="city" class="form-control-auth" value="{{ $profile->city ?? '' }}"></div>
          <div class="col-md-6"><label class="form-label-auth">County / State</label><input type="text" name="county_state" class="form-control-auth" value="{{ $profile->county_state ?? '' }}"></div>
          <div class="col-md-6"><label class="form-label-auth">Country</label><input type="text" name="country" class="form-control-auth" value="{{ $profile->country ?? '' }}"></div>
          <div class="col-md-6"><label class="form-label-auth">Postcode</label><input type="text" name="postcode" class="form-control-auth" value="{{ $profile->postcode ?? '' }}"></div>
        </div>
      </div>

      <!-- Passport -->
      <div class="dashboard-card fade-in mb-4">
        <div class="form-section-title mb-3"><i class="fas fa-passport me-2"></i>Passport / ID</div>
        <div class="row g-3">
          <div class="col-md-4"><label class="form-label-auth">Passport Number</label><input type="text" name="passport_number" class="form-control-auth" value="{{ $profile->passport_number ?? '' }}"></div>
          <div class="col-md-4"><label class="form-label-auth">Expiry Date</label><input type="date" name="passport_expiry" class="form-control-auth" value="{{ $profile->passport_expiry ?? '' }}"></div>
          <div class="col-md-4"><label class="form-label-auth">Issuing Country</label><input type="text" name="passport_country" class="form-control-auth" value="{{ $profile->passport_country ?? '' }}"></div>
        </div>
      </div>

      <!-- Education -->
      <div class="dashboard-card fade-in mb-4">
        <div class="form-section-title mb-3"><i class="fas fa-graduation-cap me-2"></i>Education & Study Preferences</div>
        <div class="row g-3">
          <div class="col-md-6"><label class="form-label-auth">Highest Qualification</label>
            <select name="highest_qualification" class="form-control-auth">
              <option value="">Select...</option>
              @foreach (["Secondary School / O-Level","A-Level / Higher Secondary","Bachelor's Degree","Master's Degree","PhD / Doctorate","Diploma / HND","Other"] as $q)
                <option {{ ($profile->highest_qualification ?? '') === $q ? 'selected' : '' }}>{{ $q }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6"><label class="form-label-auth">Institution Name</label><input type="text" name="institution_name" class="form-control-auth" value="{{ $profile->institution_name ?? '' }}"></div>
          <div class="col-md-4"><label class="form-label-auth">Field of Study</label><input type="text" name="field_of_study" class="form-control-auth" value="{{ $profile->field_of_study ?? '' }}"></div>
          <div class="col-md-4"><label class="form-label-auth">Graduation Year</label><input type="number" name="graduation_year" class="form-control-auth" value="{{ $profile->graduation_year ?? '' }}" min="1980" max="2035"></div>
          <div class="col-md-4"><label class="form-label-auth">Grade / Result</label><input type="text" name="grade_achieved" class="form-control-auth" value="{{ $profile->grade_achieved ?? '' }}"></div>
          <div class="col-md-6"><label class="form-label-auth">English Test</label>
            <select name="english_test" class="form-control-auth">
              @foreach (['None','IELTS','TOEFL','PTE','Duolingo','Cambridge'] as $t)
                <option {{ ($profile->english_test ?? '') === $t ? 'selected' : '' }}>{{ $t }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6"><label class="form-label-auth">Score / Band</label><input type="text" name="english_score" class="form-control-auth" value="{{ $profile->english_score ?? '' }}"></div>
          <div class="col-md-6"><label class="form-label-auth">Preferred Country</label>
            <select name="preferred_country" class="form-control-auth">
              <option value="">Select...</option>
              @foreach (['Russia','Georgia','China','Kazakhstan','Kyrgyzstan','Philippines','United Kingdom','Canada','Other'] as $c)
                <option {{ ($profile->preferred_country ?? '') === $c ? 'selected' : '' }}>{{ $c }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6"><label class="form-label-auth">Preferred Course</label><input type="text" name="preferred_course" class="form-control-auth" value="{{ $profile->preferred_course ?? '' }}"></div>
          <div class="col-md-4"><label class="form-label-auth">Intake Year</label>
            <select name="intake_year" class="form-control-auth">
              @foreach (['2026','2027','2028'] as $y)
                <option {{ ($profile->intake_year ?? '') === $y ? 'selected' : '' }}>{{ $y }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4"><label class="form-label-auth">Intake Month</label>
            <select name="intake_month" class="form-control-auth">
              @foreach (['January','May','September','October'] as $m)
                <option {{ ($profile->intake_month ?? '') === $m ? 'selected' : '' }}>{{ $m }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-4"><label class="form-label-auth">Budget (INR/year)</label>
            <select name="budget_range" class="form-control-auth">
              <option value="">Select...</option>
              @foreach (['Under ₹3 Lakhs','₹3 Lakhs – ₹6 Lakhs','₹6 Lakhs – ₹12 Lakhs','₹12 Lakhs+'] as $b)
                <option {{ ($profile->budget_range ?? '') === $b ? 'selected' : '' }}>{{ $b }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-12"><label class="form-label-auth">Additional Notes</label><textarea name="additional_notes" class="form-control-auth" rows="3">{{ $profile->additional_notes ?? '' }}</textarea></div>
        </div>
      </div>

      <button type="submit" class="btn-auth-submit mb-4">
        <i class="fas fa-save me-2"></i>Save Changes
      </button>
    </form>
  </div>
</section>
@endsection
