<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Mail\GenericMail;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function landing()
    {
        return view('landing');
    }

    public function health()
    {
        return response()->json([
            'status' => 'ok',
            'service' => 'drsosonline'
        ]);
    }

    public function upiPayment(Request $request)
    {
        $aptId = $request->query('apt_id', '');
        $patientName = $request->query('name', 'Patient');
        $amount = $request->query('amount', '99');
        $consultType = $request->query('consult_type', 'phone');

        $upiId = env('UPI_ID', '7025361771@ptsbi');
        $upiName = env('UPI_NAME', 'Dr SOS Online');
        
        $txnNote = "DrSOS Consultation #{$aptId}";
        $upiLink = "upi://pay?pa={$upiId}&pn=" . urlencode($upiName) . "&am={$amount}&cu=INR&tn=" . urlencode($txnNote);

        return view('payment_upi', [
            'upi_link' => $upiLink,
            'upi_id' => $upiId,
            'amount' => $amount,
            'apt_id' => $aptId,
            'patient_name' => $patientName,
            'consult_type' => $consultType
        ]);
    }

    public function paymentSuccess(Request $request)
    {
        $aptId = $request->query('apt_id', '');
        if ($aptId) {
            $apt = Appointment::find((int)$aptId);
            if ($apt) {
                $apt->payment_status = 'paid';
                $apt->save();

                // Notify admin of payment
                $adminEmail = env('ADMIN_EMAIL', 'admin@drsosonline.com');
                $subject = "[Dr.SOS] Payment Received – Appointment #{$aptId}";
                $body = "Patient {$apt->patient_name} has confirmed payment of ₹{$apt->fee} for appointment #{$aptId}.";

                try {
                    Mail::to($adminEmail)->send(new GenericMail($subject, $body));
                } catch (\Exception $e) {
                    logger()->warning("Admin payment notification failed: " . $e->getMessage());
                }
            }
        }

        return redirect()->route('online.home')->with('success', 'Payment confirmed! We will contact you within 30 minutes to confirm your appointment.');
    }
}
