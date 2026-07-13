<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\ContactMessage;
use App\Mail\GenericMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class OnlineConsultController extends Controller
{
    public function home()
    {
        $doctors = Doctor::where('is_active', true)->limit(3)->get();
        return view('online.home', compact('doctors'));
    }

    public function doctors(Request $request)
    {
        $specialty = $request->query('specialty', '');

        $query = Doctor::where('is_active', true);
        if (!empty($specialty)) {
            $query->where('specialty', 'LIKE', "%{$specialty}%");
        }
        $docs = $query->get();

        $specialties = Doctor::where('is_active', true)
            ->whereNotNull('specialty')
            ->distinct()
            ->pluck('specialty')
            ->toArray();

        return view('online.doctors', [
            'doctors' => $docs,
            'specialties' => $specialties,
            'selected' => $specialty
        ]);
    }

    public function doctorDetail($id)
    {
        $doctor = Doctor::findOrFail($id);
        return view('online.doctor_detail', compact('doctor'));
    }

    public function consult(Request $request)
    {
        $doctors = Doctor::where('is_active', true)->get();
        $prefill_doctor = $request->query('doctor_id', '');
        return view('online.consult', compact('doctors', 'prefill_doctor'));
    }

    public function submitConsult(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'nullable|exists:doctors,id',
            'patient_name' => 'required|string|max:150',
            'patient_email' => 'required|email|max:150',
            'patient_phone' => 'required|string|max:20',
            'patient_age' => 'nullable|string|max:10',
            'patient_gender' => 'nullable|string|max:20',
            'appointment_date' => 'required|string|max:20',
            'appointment_time' => 'required|string|max:10',
            'consult_type' => 'required|string|max:20',
            'reason' => 'nullable|string',
            'symptoms' => 'nullable|string',
        ]);

        $consultType = $request->input('consult_type');
        $fee = ($consultType === 'video') ? 199 : 99;

        $apt = Appointment::create(array_merge($validated, [
            'user_id' => Auth::check() ? Auth::id() : null,
            'fee' => $fee,
            'status' => 'pending',
            'payment_status' => 'pending',
        ]));

        // Notify admin
        $adminEmail = env('ADMIN_EMAIL', 'admin@drsosonline.com');
        $adminSubject = "[Dr.SOS Online] New Appointment #{$apt->id} – {$apt->patient_name}";
        $adminBody = "New doctor appointment received:\n\n" .
                     "ID          : #{$apt->id}\n" .
                     "Patient     : {$apt->patient_name}\n" .
                     "Email       : {$apt->patient_email}\n" .
                     "Phone       : {$apt->patient_phone}\n" .
                     "Type        : {$apt->consult_type}\n" .
                     "Fee         : ₹{$apt->fee}\n" .
                     "Date & Time : {$apt->appointment_date} at {$apt->appointment_time}\n" .
                     "Reason      : {$apt->reason}\n" .
                     "Symptoms    : {$apt->symptoms}\n";

        // Confirm to patient
        $upiId = env('UPI_ID', '7025361771@ptsbi');
        $patientSubject = "Appointment Confirmed – Dr.SOS Online";
        $patientBody = "Dear {$apt->patient_name},\n\n" .
                       "Your consultation appointment (#{$apt->id}) has been received.\n\n" .
                       "Type  : " . ucfirst($apt->consult_type) . " Consultation\n" .
                       "Date  : {$apt->appointment_date} at {$apt->appointment_time}\n" .
                       "Fee   : ₹{$apt->fee}\n\n" .
                       "Please complete your payment via UPI to confirm your slot.\n" .
                       "UPI ID: {$upiId}\n\n" .
                       "We will confirm within 30 minutes after payment.\n\n" .
                       "Regards,\nDr.SOS Online Team";

        try {
            Mail::to($adminEmail)->send(new GenericMail($adminSubject, $adminBody));
        } catch (\Exception $e) {
            logger()->warning("Admin appointment notification failed: " . $e->getMessage());
        }

        try {
            Mail::to($apt->patient_email)->send(new GenericMail($patientSubject, $patientBody));
        } catch (\Exception $e) {
            logger()->warning("Patient appointment confirmation failed: " . $e->getMessage());
        }

        return redirect()->route('payment.upi', [
            'apt_id' => $apt->id,
            'name' => $apt->patient_name,
            'amount' => $fee,
            'consult_type' => $apt->consult_type,
        ]);
    }

    public function palliativeCare()
    {
        return view('online.palliative_care');
    }

    public function airAmbulance()
    {
        return view('online.air_ambulance');
    }

    public function contact()
    {
        return view('online.contact');
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:30',
            'subject' => 'nullable|string|max:200',
            'message' => 'required|string',
        ]);

        ContactMessage::create(array_merge($validated, ['portal' => 'online']));

        return redirect()->route('online.contact')->with('success', "Your message has been sent! We'll get back to you shortly.");
    }
}
