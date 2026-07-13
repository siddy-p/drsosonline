@extends('layouts.base')
@section('title', 'Dashboard — Dr.SOS')
@section('content')
<section class="dashboard-section">
  <div class="container">

    <!-- Welcome Banner -->
    <div class="dashboard-welcome fade-in">
      <div>
        <h1>Welcome back, {{ Auth::user()->profile->first_name ?? explode('@', Auth::user()->email)[0] }}</h1>
        <p>Here's an overview of your education journey and medical consultations with Dr.SOS.</p>
      </div>
      <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('edu.book') }}" class="btn btn-gold"><i class="fas fa-graduation-cap me-2"></i>Book Edu Counselling</a>
        <a href="{{ route('online.consult') }}" class="btn btn-online-primary"><i class="fas fa-calendar-plus me-2"></i>Book Doctor Call</a>
        @if(Auth::user()->isDoctor())
          <a href="{{ route('doctor.dashboard') }}" class="btn btn-success"><i class="fas fa-user-md me-2"></i>Doctor Portal</a>
        @endif
      </div>
    </div>

    <!-- Profile Completion -->
    @if(Auth::user()->profile)
    @php $pct = Auth::user()->profile->completion_percentage; @endphp
    <div class="dashboard-card fade-in mb-4">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="mb-0"><i class="fas fa-user-check me-2 text-success"></i>Profile Completion</h6>
        <span class="badge-pct">{{ $pct }}%</span>
      </div>
      <div class="progress-bar-outer">
        <div class="progress-bar-inner" style="width: {{ $pct }}%"></div>
      </div>
      @if($pct < 100)
      <p class="mt-2 small text-muted">Complete your profile to improve your applications and consultations. <a href="{{ route('profile') }}">Update now →</a></p>
      @else
      <p class="mt-2 small text-success"><i class="fas fa-check-circle me-1"></i>Your profile is complete!</p>
      @endif
    </div>
    @endif

    <!-- Stat Cards -->
    <div class="row g-4 mb-4">
      <div class="col-md-4 fade-in">
        <div class="stat-card">
          <div class="stat-icon bg-green"><i class="fas fa-file-lines"></i></div>
          <div>
            <h3>{{ count($applications) }}</h3>
            <p>Application{{ count($applications) !== 1 ? 's' : '' }}</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 fade-in">
        <div class="stat-card">
          <div class="stat-icon bg-gold"><i class="fas fa-calendar-check"></i></div>
          <div>
            <h3>{{ count($bookings) }}</h3>
            <p>Edu Booking{{ count($bookings) !== 1 ? 's' : '' }}</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 fade-in">
        <div class="stat-card">
          <div class="stat-icon bg-blue"><i class="fas fa-stethoscope"></i></div>
          <div>
            <h3>{{ Auth::user()->appointments()->count() }}</h3>
            <p>Doctor Appointment{{ Auth::user()->appointments()->count() !== 1 ? 's' : '' }}</p>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-4 mb-4">
      <!-- Recent Applications -->
      <div class="col-lg-7 fade-in">
        <div class="dashboard-card h-100">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0"><i class="fas fa-file-lines me-2"></i>Recent Applications</h5>
            <a href="{{ route('applications') }}" class="btn-link-green">View All</a>
          </div>
          @if(count($applications) > 0)
          <div class="table-responsive">
            <table class="dash-table">
              <thead><tr><th>Service</th><th>Country</th><th>Status</th><th>Date</th></tr></thead>
              <tbody>
                @foreach($applications as $app)
                <tr>
                  <td>{{ $app->service_type }}</td>
                  <td>{{ $app->preferred_country ?? '—' }}</td>
                  <td><span class="status-badge status-{{ strtolower(str_replace(' ', '-', $app->status)) }}">{{ $app->status }}</span></td>
                  <td>{{ $app->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          @else
          <div class="empty-state">
            <i class="fas fa-folder-open"></i>
            <p>No applications yet</p>
            <a href="{{ route('edu.book') }}" class="btn btn-gold btn-sm">Start Application</a>
          </div>
          @endif
        </div>
      </div>

      <!-- Profile Summary -->
      <div class="col-lg-5 fade-in">
        <div class="dashboard-card h-100">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0"><i class="fas fa-user me-2"></i>Profile Summary</h5>
            <a href="{{ route('profile') }}" class="btn-link-green">Edit</a>
          </div>
          @if(Auth::user()->profile)
          @php $p = Auth::user()->profile; @endphp
          <ul class="profile-summary-list">
            <li><span>Name</span><strong>{{ $p->full_name }}</strong></li>
            <li><span>Email</span><strong>{{ Auth::user()->email }}</strong></li>
            <li><span>Phone</span><strong>{{ $p->phone ?? '—' }}</strong></li>
            <li><span>Nationality</span><strong>{{ $p->nationality ?? '—' }}</strong></li>
            <li><span>Destination</span><strong>{{ $p->preferred_country ?? '—' }}</strong></li>
            <li><span>Course</span><strong>{{ $p->preferred_course ?? '—' }}</strong></li>
            <li><span>Intake</span><strong>{{ (!empty($p->intake_month) && !empty($p->intake_year)) ? ($p->intake_month . ' ' . $p->intake_year) : '—' }}</strong></li>
          </ul>
          @endif
          <a href="{{ route('profile') }}" class="btn-auth-submit mt-3" style="padding:10px 20px;font-size:0.9rem; text-decoration: none; text-align: center; display: block;">
            <i class="fas fa-pen me-2"></i>Update Full Profile
          </a>
        </div>
      </div>
    </div>

    <!-- Recent Medical Appointments -->
    <div class="row g-4">
      <div class="col-12 fade-in">
        <div class="dashboard-card">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0"><i class="fas fa-stethoscope me-2"></i>Medical Consultation Appointments</h5>
          </div>
          @php $appointments = Auth::user()->appointments()->limit(5)->get(); @endphp
          @if($appointments->count() > 0)
          <div class="table-responsive">
            <table class="dash-table">
              <thead><tr><th>Appointment ID</th><th>Doctor</th><th>Patient Name</th><th>Date & Time</th><th>Type</th><th>Payment</th><th>Status</th></tr></thead>
              <tbody>
                @foreach($appointments as $apt)
                <tr>
                  <td>#{{ $apt->id }}</td>
                  <td>{{ $apt->doctor->name ?? 'Any Doctor' }}</td>
                  <td>{{ $apt->patient_name }}</td>
                  <td>{{ $apt->appointment_date }} at {{ $apt->appointment_time }}</td>
                  <td>{{ ucfirst($apt->consult_type) }}</td>
                  <td>
                    @if($apt->payment_status === 'paid')
                      <span class="badge bg-success">Paid</span>
                    @else
                      <a href="{{ route('payment.upi', ['apt_id' => $apt->id, 'name' => $apt->patient_name, 'amount' => $apt->fee, 'consult_type' => $apt->consult_type]) }}" class="badge bg-warning text-dark text-decoration-none">Pay ₹{{ $apt->fee }}</a>
                    @endif
                  </td>
                  <td><span class="status-badge status-{{ strtolower(str_replace(' ', '-', $apt->status)) }}">{{ ucfirst($apt->status) }}</span></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          @else
          <div class="empty-state">
            <i class="fas fa-stethoscope"></i>
            <p>No doctor appointments booked yet</p>
            <a href="{{ route('online.consult') }}" class="btn btn-online-primary btn-sm">Book Online Consultation</a>
          </div>
          @endif
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-3 mt-4 fade-in">
      <div class="col-md-3 col-6">
        <a href="{{ route('edu.education') }}" class="quick-action-card">
          <i class="fas fa-graduation-cap"></i>
          <span>Explore Universities</span>
        </a>
      </div>
      <div class="col-md-3 col-6">
        <a href="{{ route('edu.book') }}" class="quick-action-card">
          <i class="fas fa-calendar-plus"></i>
          <span>Book Appointment</span>
        </a>
      </div>
      <div class="col-md-3 col-6">
        <a href="{{ route('edu.contact') }}" class="quick-action-card">
          <i class="fas fa-headset"></i>
          <span>Contact Advisor</span>
        </a>
      </div>
      <div class="col-md-3 col-6">
        <a href="{{ route('applications') }}" class="quick-action-card">
          <i class="fas fa-file-lines"></i>
          <span>My Applications</span>
        </a>
      </div>
    </div>

  </div>
</section>
@endsection
