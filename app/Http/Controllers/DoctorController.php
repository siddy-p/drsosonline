<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;

class DoctorController extends Controller
{
    public function dashboard()
    {
        $doctor = Auth::user()->doctor;
        if (!$doctor) {
            return redirect()->route('landing')->with('danger', 'Doctor profile not found.');
        }

        $appointments = $doctor->appointments()->latest()->get();

        return view('doctor.dashboard', compact('doctor', 'appointments'));
    }

    public function showAppointment($id)
    {
        $doctor = Auth::user()->doctor;
        if (!$doctor) {
            return redirect()->route('landing')->with('danger', 'Doctor profile not found.');
        }

        $appointment = Appointment::where('doctor_id', $doctor->id)->findOrFail($id);

        return view('doctor.appointment_detail', compact('appointment'));
    }

    public function updateAppointment(Request $request, $id)
    {
        $doctor = Auth::user()->doctor;
        if (!$doctor) {
            return redirect()->route('landing')->with('danger', 'Doctor profile not found.');
        }

        $appointment = Appointment::where('doctor_id', $doctor->id)->findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|string|in:pending,confirmed,cancelled,completed',
            'doctor_notes' => 'nullable|string',
        ]);

        $appointment->update($validated);

        return redirect()->route('doctor.appointment.show', $appointment->id)->with('success', 'Appointment updated successfully!');
    }
}
