@extends('layouts.base')
@section('title', 'My Applications — Dr.SOS')
@section('content')
<section class="dashboard-section">
  <div class="container">
    <div class="dashboard-welcome fade-in">
      <div>
        <h1><i class="fas fa-file-lines me-2"></i>My Applications</h1>
        <p>Track the status of all your education applications.</p>
      </div>
      <a href="{{ route('edu.book') }}" class="btn btn-gold"><i class="fas fa-plus me-2"></i>New Application</a>
    </div>

    <div class="dashboard-card fade-in">
      @if(count($applications) > 0)
      <div class="table-responsive">
        <table class="dash-table">
          <thead>
            <tr>
              <th>#</th>
              <th>Service</th>
              <th>Destination</th>
              <th>Course</th>
              <th>Intake</th>
              <th>Status</th>
              <th>Submitted</th>
            </tr>
          </thead>
          <tbody>
            @foreach($applications as $app)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $app->service_type }}</td>
              <td>{{ $app->preferred_country ?? '—' }}</td>
              <td>{{ $app->preferred_course ?? '—' }}</td>
              <td>{{ $app->intake ?? '—' }}</td>
              <td><span class="status-badge status-{{ strtolower(str_replace(' ', '-', $app->status)) }}">{{ $app->status }}</span></td>
              <td>{{ $app->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      @else
      <div class="empty-state">
        <i class="fas fa-folder-open" style="font-size:3rem;color:var(--primary-color);margin-bottom:15px;"></i>
        <h5>No Applications Yet</h5>
        <p class="text-muted">Book a consultation and we'll create your application together.</p>
        <a href="{{ route('edu.book') }}" class="btn btn-gold mt-2">Book a Consultation</a>
      </div>
      @endif
    </div>

    <!-- Status Legend -->
    <div class="d-flex flex-wrap gap-3 mt-3 fade-in">
      <div class="d-flex align-items-center gap-2"><span class="status-badge status-pending">Pending</span> <small class="text-muted">Received, awaiting review</small></div>
      <div class="d-flex align-items-center gap-2"><span class="status-badge status-in-review">In Review</span> <small class="text-muted">Being processed by advisor</small></div>
      <div class="d-flex align-items-center gap-2"><span class="status-badge status-approved">Approved</span> <small class="text-muted">Application successful</small></div>
      <div class="d-flex align-items-center gap-2"><span class="status-badge status-rejected">Rejected</span> <small class="text-muted">Not successful this time</small></div>
    </div>
  </div>
</section>
@endsection
