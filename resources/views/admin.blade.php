@extends('layouts.base')
@section('title', 'Admin Panel — Dr.SOS')
@section('content')
<section class="dashboard-section">
  <div class="container">
    <div class="dashboard-welcome fade-in mb-4">
      <div>
        <h1><i class="fas fa-shield me-2 text-danger"></i>Admin Control Panel</h1>
        <p>Manage all records, users, consultations, and doctor profiles.</p>
      </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="mb-4">
      <ul class="nav nav-pills" id="adminTabs" role="tablist">
        <li class="nav-item">
          <button class="nav-link active btn-sm" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab">Users ({{ count($users) }})</button>
        </li>
        <li class="nav-item ms-2">
          <button class="nav-link btn-sm" id="apps-tab" data-bs-toggle="tab" data-bs-target="#apps" type="button" role="tab">Applications ({{ count($apps) }})</button>
        </li>
        <li class="nav-item ms-2">
          <button class="nav-link btn-sm" id="bookings-tab" data-bs-toggle="tab" data-bs-target="#bookings" type="button" role="tab">Edu Bookings ({{ count($bookings) }})</button>
        </li>
        <li class="nav-item ms-2">
          <button class="nav-link btn-sm" id="apts-tab" data-bs-toggle="tab" data-bs-target="#apts" type="button" role="tab">Medical Apts ({{ count($appointments) }})</button>
        </li>
        <li class="nav-item ms-2">
          <button class="nav-link btn-sm" id="messages-tab" data-bs-toggle="tab" data-bs-target="#messages" type="button" role="tab">Messages ({{ count($messages) }})</button>
        </li>
        <li class="nav-item ms-2">
          <button class="nav-link btn-sm" id="doctors-tab" data-bs-toggle="tab" data-bs-target="#doctors" type="button" role="tab">Doctors ({{ count($doctors) }})</button>
        </li>
      </ul>
    </div>

    <!-- Tab Content -->
    <div class="tab-content" id="adminTabsContent">
      
      <!-- Users Tab -->
      <div class="tab-pane fade show active" id="users" role="tabpanel">
        <div class="dashboard-card">
          <h5 class="mb-3"><i class="fas fa-users me-2"></i>Registered Users</h5>
          <div class="table-responsive">
            <table class="dash-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Email</th>
                  <th>Name</th>
                  <th>Status</th>
                  <th>Admin</th>
                  <th>Joined Date</th>
                </tr>
              </thead>
              <tbody>
                @foreach($users as $user)
                <tr>
                  <td>#{{ $user->id }}</td>
                  <td>{{ $user->email }}</td>
                  <td>{{ $user->profile->full_name ?? 'No profile yet' }}</td>
                  <td>
                    <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }}">
                      {{ $user->is_active ? 'Active' : 'Inactive' }}
                    </span>
                  </td>
                  <td>
                    <span class="badge {{ $user->is_admin ? 'bg-danger' : 'bg-secondary' }}">
                      {{ $user->is_admin ? 'Admin' : 'User' }}
                    </span>
                  </td>
                  <td>{{ $user->created_at->format('d M Y H:i') }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Applications Tab -->
      <div class="tab-pane fade" id="apps" role="tabpanel">
        <div class="dashboard-card">
          <h5 class="mb-3"><i class="fas fa-file-lines me-2"></i>Recent Applications</h5>
          <div class="table-responsive">
            <table class="dash-table">
              <thead>
                <tr>
                  <th>User ID</th>
                  <th>Email</th>
                  <th>Service Type</th>
                  <th>Preferred Country</th>
                  <th>Preferred Course</th>
                  <th>Intake</th>
                  <th>Status</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
                @foreach($apps as $app)
                <tr>
                  <td>#{{ $app->user_id }}</td>
                  <td>{{ $app->user->email ?? '—' }}</td>
                  <td>{{ $app->service_type }}</td>
                  <td>{{ $app->preferred_country ?? '—' }}</td>
                  <td>{{ $app->preferred_course ?? '—' }}</td>
                  <td>{{ $app->intake ?? '—' }}</td>
                  <td><span class="status-badge status-{{ strtolower(str_replace(' ', '-', $app->status)) }}">{{ $app->status }}</span></td>
                  <td>{{ $app->created_at->format('d M Y H:i') }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Bookings Tab -->
      <div class="tab-pane fade" id="bookings" role="tabpanel">
        <div class="dashboard-card">
          <h5 class="mb-3"><i class="fas fa-calendar-check me-2"></i>Education Consultation Bookings</h5>
          <div class="table-responsive">
            <table class="dash-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Patient Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Service</th>
                  <th>Pref. Date</th>
                  <th>Status</th>
                  <th>Created At</th>
                </tr>
              </thead>
              <tbody>
                @foreach($bookings as $booking)
                <tr>
                  <td>#{{ $booking->id }}</td>
                  <td>{{ $booking->name }}</td>
                  <td>{{ $booking->email }}</td>
                  <td>{{ $booking->phone ?? '—' }}</td>
                  <td>{{ $booking->service ?? '—' }}</td>
                  <td>{{ $booking->preferred_date ?? '—' }}</td>
                  <td><span class="status-badge status-{{ strtolower(str_replace(' ', '-', $booking->status)) }}">{{ $booking->status }}</span></td>
                  <td>{{ $booking->created_at->format('d M Y H:i') }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Medical Appointments Tab -->
      <div class="tab-pane fade" id="apts" role="tabpanel">
        <div class="dashboard-card">
          <h5 class="mb-3"><i class="fas fa-stethoscope me-2"></i>Medical Doctor Appointments</h5>
          <div class="table-responsive">
            <table class="dash-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Patient</th>
                  <th>Doctor</th>
                  <th>Phone</th>
                  <th>Date & Time</th>
                  <th>Type</th>
                  <th>Fee</th>
                  <th>Payment</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach($appointments as $apt)
                <tr>
                  <td>#{{ $apt->id }}</td>
                  <td>
                    <strong>{{ $apt->patient_name }}</strong><br>
                    <small class="text-muted">{{ $apt->patient_email }} (Age: {{ $apt->patient_age ?? '—' }}, {{ $apt->patient_gender ?? '—' }})</small>
                  </td>
                  <td>{{ $apt->doctor->name ?? 'Any Doctor' }}</td>
                  <td>{{ $apt->patient_phone }}</td>
                  <td>{{ $apt->appointment_date }} at {{ $apt->appointment_time }}</td>
                  <td>{{ ucfirst($apt->consult_type) }}</td>
                  <td>₹{{ $apt->fee }}</td>
                  <td>
                    <span class="badge {{ $apt->payment_status === 'paid' ? 'bg-success' : 'bg-warning text-dark' }}">
                      {{ ucfirst($apt->payment_status) }}
                    </span>
                  </td>
                  <td><span class="status-badge status-{{ strtolower(str_replace(' ', '-', $apt->status)) }}">{{ ucfirst($apt->status) }}</span></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Messages Tab -->
      <div class="tab-pane fade" id="messages" role="tabpanel">
        <div class="dashboard-card">
          <h5 class="mb-3"><i class="fas fa-envelope-open-text me-2"></i>Contact Messages</h5>
          <div class="table-responsive">
            <table class="dash-table">
              <thead>
                <tr>
                  <th>Portal</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Subject</th>
                  <th>Message</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
                @foreach($messages as $msg)
                <tr>
                  <td>
                    <span class="badge {{ $msg->portal === 'edu' ? 'bg-success' : 'bg-info' }}">
                      {{ $msg->portal === 'edu' ? 'EduConsult' : 'Medical' }}
                    </span>
                  </td>
                  <td>{{ $msg->name }}</td>
                  <td>{{ $msg->email }}</td>
                  <td>{{ $msg->phone ?? '—' }}</td>
                  <td>{{ $msg->subject ?? '—' }}</td>
                  <td>{{ $msg->message }}</td>
                  <td>{{ $msg->created_at->format('d M Y H:i') }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Doctors Tab -->
      <div class="tab-pane fade" id="doctors" role="tabpanel">
        <div class="dashboard-card">
          <h5 class="mb-3"><i class="fas fa-user-md me-2"></i>Doctor Profiles</h5>
          <div class="table-responsive">
            <table class="dash-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Photo</th>
                  <th>Name</th>
                  <th>Specialty</th>
                  <th>Exp.</th>
                  <th>Language</th>
                  <th>Active</th>
                </tr>
              </thead>
              <tbody>
                @foreach($doctors as $doc)
                <tr>
                  <td>#{{ $doc->id }}</td>
                  <td><img src="{{ asset($doc->photo_url) }}" alt="{{ $doc->name }}" style="width:40px; height:40px; border-radius:50%; object-fit:cover;"></td>
                  <td>{{ $doc->name }}</td>
                  <td>{{ $doc->specialty }}</td>
                  <td>{{ $doc->years_experience }} years</td>
                  <td>{{ $doc->languages }}</td>
                  <td>
                    <span class="badge {{ $doc->is_active ? 'bg-success' : 'bg-danger' }}">
                      {{ $doc->is_active ? 'Yes' : 'No' }}
                    </span>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection
