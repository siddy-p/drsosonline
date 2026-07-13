<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        $apps = $user->applications()->limit(5)->get();
        $bookings = $user->bookings()->limit(3)->get();
        $appointments = $user->appointments()->limit(5)->get();

        return view('dashboard', [
            'applications' => $apps,
            'bookings' => $bookings,
            'appointments' => $appointments
        ]);
    }

    public function profile()
    {
        $profile = Auth::user()->profile;
        return view('profile', compact('profile'));
    }

    public function updateProfile(Request $request)
    {
        $profile = Auth::user()->profile;

        $fields = [
            'first_name','last_name','date_of_birth','gender','nationality','phone',
            'street_address','city','county_state','country','postcode',
            'passport_number','passport_expiry','passport_country',
            'highest_qualification','institution_name','graduation_year','grade_achieved',
            'field_of_study','english_test','english_score',
            'preferred_country','preferred_course','intake_year','intake_month',
            'budget_range','additional_notes'
        ];

        $data = $request->only($fields);
        $profile->update($data);

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }

    public function applications()
    {
        $apps = Auth::user()->applications;
        return view('applications', ['applications' => $apps]);
    }
}
