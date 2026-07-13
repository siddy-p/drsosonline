@extends('layouts.base')
@section('title', 'Education & Preferences — Dr.SOS EduConsult')
@section('content')
<section class="auth-section auth-section-wide">
  <div class="auth-card auth-card-wide">
    <div class="step-indicator">
      <div class="step done"><span><i class="fas fa-check"></i></span><p>Account</p></div>
      <div class="step-line active"></div>
      <div class="step done"><span><i class="fas fa-check"></i></span><p>Profile</p></div>
      <div class="step-line active"></div>
      <div class="step active"><span>3</span><p>Education</p></div>
    </div>

    <div class="auth-header">
      <h1>Education & Study Preferences</h1>
      <p>Help us match you with the best universities and programmes</p>
    </div>

    <form method="POST" action="{{ route('register.education.submit') }}">
      @csrf
      <div class="form-section-title"><i class="fas fa-graduation-cap me-2"></i>Education History</div>
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label-auth">Highest Qualification *</label>
          <select name="highest_qualification" class="form-control-auth" required>
            <option value="">Select...</option>
            <option {{ old('highest_qualification') === 'Secondary School / O-Level' ? 'selected' : '' }}>Secondary School / O-Level</option>
            <option {{ old('highest_qualification') === 'A-Level / Higher Secondary' ? 'selected' : '' }}>A-Level / Higher Secondary</option>
            <option {{ old('highest_qualification') === 'Bachelor\'s Degree' ? 'selected' : '' }}>Bachelor's Degree</option>
            <option {{ old('highest_qualification') === 'Master\'s Degree' ? 'selected' : '' }}>Master's Degree</option>
            <option {{ old('highest_qualification') === 'PhD / Doctorate' ? 'selected' : '' }}>PhD / Doctorate</option>
            <option {{ old('highest_qualification') === 'Diploma / HND' ? 'selected' : '' }}>Diploma / HND</option>
            <option {{ old('highest_qualification') === 'Other' ? 'selected' : '' }}>Other</option>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label-auth">Institution Name *</label>
          <input type="text" name="institution_name" class="form-control-auth" placeholder="Institution/School Name" value="{{ old('institution_name') }}" required>
        </div>
        <div class="col-md-4">
          <label class="form-label-auth">Field of Study</label>
          <input type="text" name="field_of_study" class="form-control-auth" placeholder="e.g. Science, Pre-Med" value="{{ old('field_of_study') }}">
        </div>
        <div class="col-md-4">
          <label class="form-label-auth">Graduation Year</label>
          <input type="number" name="graduation_year" class="form-control-auth" placeholder="2025" min="1980" max="2035" value="{{ old('graduation_year') }}">
        </div>
        <div class="col-md-4">
          <label class="form-label-auth">Grade / Result</label>
          <input type="text" name="grade_achieved" class="form-control-auth" placeholder="e.g. 85%, 3.8 GPA" value="{{ old('grade_achieved') }}">
        </div>
      </div>

      <div class="form-section-title mt-4"><i class="fas fa-language me-2"></i>English Language Test</div>
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label-auth">English Test Type</label>
          <select name="english_test" class="form-control-auth" id="englishTest">
            <option value="None" {{ old('english_test') === 'None' ? 'selected' : '' }}>None / Not yet taken</option>
            <option value="IELTS" {{ old('english_test') === 'IELTS' ? 'selected' : '' }}>IELTS</option>
            <option value="TOEFL" {{ old('english_test') === 'TOEFL' ? 'selected' : '' }}>TOEFL</option>
            <option value="PTE" {{ old('english_test') === 'PTE' ? 'selected' : '' }}>PTE Academic</option>
            <option value="Duolingo" {{ old('english_test') === 'Duolingo' ? 'selected' : '' }}>Duolingo English Test</option>
            <option value="Cambridge" {{ old('english_test') === 'Cambridge' ? 'selected' : '' }}>Cambridge (C1/C2)</option>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label-auth">Score / Band</label>
          <input type="text" name="english_score" class="form-control-auth" placeholder="e.g. 6.5 / 90 / C1" value="{{ old('english_score') }}">
        </div>
      </div>

      <div class="form-section-title mt-4"><i class="fas fa-earth-europe me-2"></i>Study Preferences</div>
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label-auth">Preferred Study Destination *</label>
          <select name="preferred_country" class="form-control-auth" required>
            <option value="">Select country...</option>
            <option {{ old('preferred_country') === 'Russia' ? 'selected' : '' }}>Russia</option>
            <option {{ old('preferred_country') === 'Georgia' ? 'selected' : '' }}>Georgia</option>
            <option {{ old('preferred_country') === 'China' ? 'selected' : '' }}>China</option>
            <option {{ old('preferred_country') === 'Kazakhstan' ? 'selected' : '' }}>Kazakhstan</option>
            <option {{ old('preferred_country') === 'Kyrgyzstan' ? 'selected' : '' }}>Kyrgyzstan</option>
            <option {{ old('preferred_country') === 'Philippines' ? 'selected' : '' }}>Philippines</option>
            <option {{ old('preferred_country') === 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
            <option {{ old('preferred_country') === 'Canada' ? 'selected' : '' }}>Canada</option>
            <option {{ old('preferred_country') === 'Other' ? 'selected' : '' }}>Other</option>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label-auth">Preferred Course / Programme *</label>
          <input type="text" name="preferred_course" class="form-control-auth" placeholder="e.g. MBBS, MD" value="{{ old('preferred_course') }}" required>
        </div>
        <div class="col-md-4">
          <label class="form-label-auth">Intake Year</label>
          <select name="intake_year" class="form-control-auth">
            <option {{ old('intake_year') === '2026' ? 'selected' : '' }}>2026</option>
            <option {{ old('intake_year') === '2027' ? 'selected' : '' }}>2027</option>
            <option {{ old('intake_year') === '2028' ? 'selected' : '' }}>2028</option>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label-auth">Intake Month</label>
          <select name="intake_month" class="form-control-auth">
            <option {{ old('intake_month') === 'September' ? 'selected' : '' }}>September</option>
            <option {{ old('intake_month') === 'October' ? 'selected' : '' }}>October</option>
            <option {{ old('intake_month') === 'January' ? 'selected' : '' }}>January</option>
            <option {{ old('intake_month') === 'May' ? 'selected' : '' }}>May</option>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label-auth">Annual Budget (INR)</label>
          <select name="budget_range" class="form-control-auth">
            <option value="">Select range...</option>
            <option {{ old('budget_range') === 'Under ₹3 Lakhs' ? 'selected' : '' }}>Under ₹3 Lakhs</option>
            <option {{ old('budget_range') === '₹3 Lakhs – ₹6 Lakhs' ? 'selected' : '' }}>₹3 Lakhs – ₹6 Lakhs</option>
            <option {{ old('budget_range') === '₹6 Lakhs – ₹12 Lakhs' ? 'selected' : '' }}>₹6 Lakhs – ₹12 Lakhs</option>
            <option {{ old('budget_range') === '₹12 Lakhs+' ? 'selected' : '' }}>₹12 Lakhs+</option>
          </select>
        </div>
        <div class="col-12">
          <label class="form-label-auth">Additional Notes / Goals</label>
          <textarea name="additional_notes" class="form-control-auth" rows="3" placeholder="Tell us anything else that would help us advise you better...">{{ old('additional_notes') }}</textarea>
        </div>
      </div>

      <button type="submit" class="btn-auth-submit mt-4">
        Complete Registration <i class="fas fa-check ms-2"></i>
      </button>
    </form>
  </div>
</section>
@endsection
