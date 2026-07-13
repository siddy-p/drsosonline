<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Models\Booking;
use App\Mail\GenericMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class EduConsultController extends Controller
{
    public function home()
    {
        return view('edu.home');
    }

    public function education()
    {
        return view('edu.education');
    }

    public function contact()
    {
        return view('edu.contact');
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

        ContactMessage::create(array_merge($validated, ['portal' => 'edu']));

        return redirect()->route('edu.contact')->with('success', "Your message has been sent! We'll be in touch shortly.");
    }

    public function book()
    {
        return view('edu.book');
    }

    public function submitBook(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:30',
            'service' => 'nullable|string|max:100',
            'preferred_date' => 'nullable|string|max:30',
            'message' => 'nullable|string',
        ]);

        $booking = Booking::create(array_merge($validated, [
            'user_id' => Auth::check() ? Auth::id() : null,
        ]));

        // Notify admin
        $adminEmail = env('ADMIN_EMAIL', 'admin@drsosonline.com');
        $adminSubject = "[Dr.SOS EduConsult] New Booking – {$booking->name}";
        $adminBody = "New education consultation booking received:\n\n" .
                     "Name    : {$booking->name}\n" .
                     "Email   : {$booking->email}\n" .
                     "Phone   : {$booking->phone}\n" .
                     "Service : {$booking->service}\n" .
                     "Date    : {$booking->preferred_date}\n" .
                     "Message : {$booking->message}\n";

        // Confirm to patient
        $patientSubject = "Your EduConsult Booking is Received – Dr.SOS";
        $patientBody = "Dear {$booking->name},\n\n" .
                       "Thank you for booking an education consultation with Dr.SOS.\n" .
                       "We will confirm your appointment within 24 hours.\n\n" .
                       "Service : {$booking->service}\n" .
                       "Date    : {$booking->preferred_date}\n\n" .
                       "Regards,\nDr.SOS EduConsult Team";

        try {
            Mail::to($adminEmail)->send(new GenericMail($adminSubject, $adminBody));
        } catch (\Exception $e) {
            logger()->warning("Admin booking notification failed: " . $e->getMessage());
        }

        try {
            Mail::to($booking->email)->send(new GenericMail($patientSubject, $patientBody));
        } catch (\Exception $e) {
            logger()->warning("Patient booking confirmation failed: " . $e->getMessage());
        }

        return redirect()->route('edu.book')->with('success', 'Consultation request submitted! We will confirm shortly.');
    }
}
