@extends('layouts.base')
@section('title', 'Appointment #' . $appointment->id . ' — Doctor Panel')
@section('content')
<section class="dashboard-section">
  <div class="container">
    <a href="{{ route('doctor.dashboard') }}" class="on-back-link mb-3 d-inline-block"><i class="fas fa-arrow-left me-2"></i>Back to Dashboard</a>
    
    <div class="row g-4">
      
      <!-- Appointment Details Card -->
      <div class="col-lg-7 fade-in">
        <div class="dashboard-card h-100">
          <h3 class="mb-4"><i class="fas fa-file-invoice-dollar me-2 text-success"></i>Appointment #{{ $appointment->id }} Details</h3>
          
          <ul class="profile-summary-list">
            <li><span>Patient Name</span><strong>{{ $appointment->patient_name }}</strong></li>
            <li><span>Patient Email</span><strong>{{ $appointment->patient_email }}</strong></li>
            <li><span>Patient Phone</span><strong>{{ $appointment->patient_phone }}</strong></li>
            <li><span>Age & Gender</span><strong>{{ $appointment->patient_age ?? '—' }} yrs ({{ $appointment->patient_gender ?? '—' }})</strong></li>
            <li><span>Date & Time</span><strong>{{ $appointment->appointment_date }} at {{ $appointment->appointment_time }}</strong></li>
            <li><span>Consultation Type</span><strong>{{ ucfirst($appointment->consult_type) }}</strong></li>
            <li><span>Fee Amount</span><strong>₹{{ $appointment->fee }}</strong></li>
            <li><span>Payment Status</span><strong>{{ ucfirst($appointment->payment_status) }}</strong></li>
          </ul>

          <div class="mt-4">
            <h5>Reason for Consultation:</h5>
            <div class="p-3 bg-light rounded text-dark" style="font-size:0.95rem;">
              {{ $appointment->reason ?? 'No reason specified' }}
            </div>
          </div>

          <div class="mt-3">
            <h5>Symptoms / Medical History:</h5>
            <div class="p-3 bg-light rounded text-dark" style="font-size:0.95rem; white-space: pre-line;">
              {{ $appointment->symptoms ?? 'No symptoms provided' }}
            </div>
          </div>
        </div>
      </div>

      <!-- Actions & Notes Card -->
      <div class="col-lg-5 fade-in">
        <div class="dashboard-card h-100">
          <h4 class="mb-4"><i class="fas fa-user-md me-2"></i>Update Appointment</h4>
          
          <form method="POST" action="{{ route('doctor.appointment.update', $appointment->id) }}">
            @csrf
            
            <div class="mb-3">
              <label class="form-label-auth">Appointment Status</label>
              <select name="status" class="form-control-auth" required>
                <option value="pending" {{ $appointment->status === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ $appointment->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="completed" {{ $appointment->status === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ $appointment->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label-auth">Doctor Notes / Prescription</label>
              <textarea name="doctor_notes" class="form-control-auth" rows="8" placeholder="Add diagnosis details, advice, or digital prescription notes here...">{{ $appointment->doctor_notes }}</textarea>
            </div>

            <button type="submit" class="btn-auth-submit w-100">
              <i class="fas fa-save me-2"></i>Save &amp; Update
            </button>
          </form>

        </div>
      </div>

    </div>
  </div>
</section>
@endsection
