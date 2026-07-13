@extends('layouts.base')
@section('title', 'Doctor Dashboard — Dr.SOS')
@section('content')
<section class="dashboard-section">
  <div class="container">
    <div class="dashboard-welcome fade-in mb-4">
      <div>
        <h1>Welcome, {{ $doctor->name }}</h1>
        <p>{{ $doctor->specialty }} specialist | {{ $doctor->qualification }}</p>
      </div>
    </div>

    <div class="row g-4 mb-4">
      <div class="col-md-4 fade-in">
        <div class="stat-card">
          <div class="stat-icon bg-green"><i class="fas fa-calendar-check"></i></div>
          <div>
            <h3>{{ $appointments->count() }}</h3>
            <p>Total Consultations</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 fade-in">
        <div class="stat-card">
          <div class="stat-icon bg-gold"><i class="fas fa-clock"></i></div>
          <div>
            <h3>{{ $appointments->where('status', 'pending')->count() }}</h3>
            <p>Pending Review</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 fade-in">
        <div class="stat-card">
          <div class="stat-icon bg-blue"><i class="fas fa-circle-check"></i></div>
          <div>
            <h3>{{ $appointments->where('status', 'confirmed')->count() }}</h3>
            <p>Confirmed Slots</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Appointments Table -->
    <div class="dashboard-card fade-in">
      <h5 class="mb-3"><i class="fas fa-calendar-alt me-2 text-success"></i>Patient Consultations</h5>
      @if($appointments->count() > 0)
      <div class="table-responsive">
        <table class="dash-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Patient</th>
              <th>Date & Time</th>
              <th>Type</th>
              <th>Fee</th>
              <th>Payment</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($appointments as $apt)
            <tr>
              <td>#{{ $apt->id }}</td>
              <td>
                <strong>{{ $apt->patient_name }}</strong><br>
                <small class="text-muted">{{ $apt->patient_phone }} (Age: {{ $apt->patient_age ?? '—' }}, {{ $apt->patient_gender ?? '—' }})</small>
              </td>
              <td>{{ $apt->appointment_date }} at {{ $apt->appointment_time }}</td>
              <td>{{ ucfirst($apt->consult_type) }}</td>
              <td>₹{{ $apt->fee }}</td>
              <td>
                <span class="badge {{ $apt->payment_status === 'paid' ? 'bg-success' : 'bg-warning text-dark' }}">
                  {{ ucfirst($apt->payment_status) }}
                </span>
              </td>
              <td>
                <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $apt->status)) }}">
                  {{ ucfirst($apt->status) }}
                </span>
              </td>
              <td>
                <a href="{{ route('doctor.appointment.show', $apt->id) }}" class="btn btn-outline-gold btn-sm">Manage</a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      @else
      <div class="empty-state">
        <i class="fas fa-calendar-times" style="font-size:3rem;color:var(--primary-color);margin-bottom:15px;"></i>
        <h5>No Appointments Found</h5>
        <p class="text-muted">You do not have any appointments booked under your profile yet.</p>
      </div>
      @endif
    </div>

  </div>
</section>
@endsection
