<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Application;
use App\Models\Booking;
use App\Models\Appointment;
use App\Models\ContactMessage;
use App\Models\Doctor;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function admin()
    {
        $users = User::latest()->get();
        $apps = Application::latest()->get();
        $bookings = Booking::latest()->get();
        $appointments = Appointment::latest()->get();
        $messages = ContactMessage::latest()->get();
        $doctors = Doctor::all();

        return view('admin', compact('users', 'apps', 'bookings', 'appointments', 'messages', 'doctors'));
    }
}
