<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('register', ['step' => 1]);
    }

    public function submitRegister(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:150',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|string|same:password',
        ]);

        $email = strtolower(trim($request->input('email')));

        if (User::where('email', $email)->exists()) {
            return redirect()->route('login')->with('warning', 'An account with this email already exists.');
        }

        $user = User::create([
            'email' => $email,
            'password' => Hash::make($request->input('password')),
            'is_active' => true,
            'is_admin' => false,
        ]);

        Profile::create([
            'user_id' => $user->id,
        ]);

        Session::put('reg_user_id', $user->id);

        return redirect()->route('register.profile')->with('success', 'Account created! Now complete your profile.');
    }

    public function showRegisterProfile()
    {
        $userId = Session::get('reg_user_id');
        if (!$userId) {
            return redirect()->route('register');
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('register');
        }

        return view('register_profile', ['step' => 2]);
    }

    public function submitRegisterProfile(Request $request)
    {
        $userId = Session::get('reg_user_id');
        if (!$userId) {
            return redirect()->route('register');
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('register');
        }

        $fields = [
            'first_name', 'last_name', 'date_of_birth', 'gender', 'nationality', 'phone',
            'street_address', 'city', 'county_state', 'country', 'postcode',
            'passport_number', 'passport_expiry', 'passport_country'
        ];

        $data = $request->only($fields);
        $user->profile->update($data);

        $action = $request->input('action');
        if ($action === 'finish') {
            Session::forget('reg_user_id');
            Auth::login($user);
            $name = $user->profile->first_name ?? 'there';
            return redirect()->route('dashboard')->with('success', "Welcome, {$name}! Your account is set up for Medical Consultations.");
        }

        return redirect()->route('register.education');
    }

    public function showRegisterEducation()
    {
        $userId = Session::get('reg_user_id');
        if (!$userId) {
            return redirect()->route('register');
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('register');
        }

        return view('register_education', ['step' => 3]);
    }

    public function submitRegisterEducation(Request $request)
    {
        $userId = Session::get('reg_user_id');
        if (!$userId) {
            return redirect()->route('register');
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('register');
        }

        $fields = [
            'highest_qualification', 'institution_name', 'graduation_year', 'grade_achieved',
            'field_of_study', 'english_test', 'english_score', 'preferred_country',
            'preferred_course', 'intake_year', 'intake_month', 'budget_range', 'additional_notes'
        ];

        $data = $request->only($fields);
        $user->profile->update($data);

        Session::forget('reg_user_id');
        Auth::login($user);
        $name = $user->profile->first_name ?? 'there';

        return redirect()->route('dashboard')->with('success', "Welcome, {$name}! Your account is all set up.");
    }

    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('login');
    }

    public function submitLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials['email'] = strtolower(trim($credentials['email']));
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $nextPage = $request->input('next');
            return redirect()->intended($nextPage ?? route('dashboard'))->with('success', 'Welcome back!');
        }

        return redirect()->back()->withInput($request->only('email'))->with('danger', 'Invalid email or password.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing')->with('info', 'You have been logged out.');
    }
}
