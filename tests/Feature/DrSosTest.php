<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Profile;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Booking;
use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DrSosTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    /**
     * Test the landing page.
     */
    public function test_landing_page_returns_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Dr.SOS');
    }

    /**
     * Test the health check endpoint.
     */
    public function test_health_check_returns_ok(): void
    {
        $response = $this->get('/health');
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'ok',
            'service' => 'drsosonline'
        ]);
    }

    /**
     * Test guest can access login and register.
     */
    public function test_guest_can_access_login_and_register(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);

        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    /**
     * Test the user registration and 3-step setup flow.
     */
    public function test_multi_step_user_registration_flow(): void
    {
        // Step 1: Create Account
        $response = $this->post('/register', [
            'email' => 'testpatient@drsosonline.com',
            'password' => 'password123',
            'confirm_password' => 'password123',
        ]);

        $response->assertRedirect(route('register.profile'));
        $this->assertDatabaseHas('users', [
            'email' => 'testpatient@drsosonline.com'
        ]);

        $user = User::where('email', 'testpatient@drsosonline.com')->first();
        $this->assertNotNull($user->profile);

        // Put the user id in session as expected by profile steps
        $this->withSession(['reg_user_id' => $user->id]);

        // Step 2: Complete Profile
        $response = $this->post('/register/profile', [
            'first_name' => 'Test',
            'last_name' => 'Patient',
            'date_of_birth' => '1995-05-15',
            'gender' => 'Male',
            'nationality' => 'Indian',
            'phone' => '+91 99999 11111',
            'street_address' => 'Test Street',
            'city' => 'Kochi',
            'county_state' => 'Kerala',
            'country' => 'India',
            'postcode' => '682001',
            'action' => 'edu', // Continue to step 3
        ]);

        $response->assertRedirect(route('register.education'));
        $this->assertEquals('Test', $user->profile->fresh()->first_name);

        // Step 3: Complete Education Details
        $this->withSession(['reg_user_id' => $user->id]);
        $response = $this->post('/register/education', [
            'highest_qualification' => 'A-Level / Higher Secondary',
            'institution_name' => 'Test School',
            'field_of_study' => 'Science',
            'graduation_year' => '2023',
            'grade_achieved' => '90%',
            'english_test' => 'None',
            'preferred_country' => 'Georgia',
            'preferred_course' => 'MBBS',
            'intake_year' => '2026',
            'intake_month' => 'September',
            'budget_range' => '₹12 Lakhs+',
            'additional_notes' => 'Looking for affordable universities',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertEquals('MBBS', $user->profile->fresh()->preferred_course);
        $this->assertTrue(auth()->check());
    }

    /**
     * Test booking an education consultation (guest/user).
     */
    public function test_education_consultation_booking(): void
    {
        $response = $this->post('/edu/book', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'phone' => '+91 98765 00000',
            'service' => 'MBBS Abroad — Admission Guidance',
            'preferred_date' => '2026-08-15',
            'preferred_time' => 'Morning (9am – 12pm)',
            'message' => 'I would like to know about universities in Georgia.',
        ]);

        $response->assertRedirect(route('edu.book'));
        $this->assertDatabaseHas('bookings', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'service' => 'MBBS Abroad — Admission Guidance',
        ]);
    }

    /**
     * Test booking a medical consultation.
     */
    public function test_medical_consultation_booking(): void
    {
        $doctor = Doctor::first();
        $this->assertNotNull($doctor);

        $response = $this->post('/online/consult', [
            'doctor_id' => $doctor->id,
            'patient_name' => 'Aarav Kumar',
            'patient_email' => 'aarav@example.com',
            'patient_phone' => '+91 99999 22222',
            'patient_age' => '25',
            'patient_gender' => 'Male',
            'appointment_date' => '2026-08-20',
            'appointment_time' => '10:30',
            'consult_type' => 'video',
            'reason' => 'Fever',
            'symptoms' => 'High fever and headache since 2 days.',
        ]);

        // Should redirect to UPI payment deep link
        $this->assertDatabaseHas('appointments', [
            'patient_name' => 'Aarav Kumar',
            'doctor_id' => $doctor->id,
            'fee' => 199,
        ]);

        $apt = Appointment::where('patient_name', 'Aarav Kumar')->first();
        $response->assertRedirect(route('payment.upi', [
            'apt_id' => $apt->id,
            'name' => 'Aarav Kumar',
            'amount' => 199,
            'consult_type' => 'video',
        ]));
    }

    /**
     * Test admin dashboard authorization restrictions.
     */
    public function test_admin_dashboard_access_restrictions(): void
    {
        // 1. Guest is redirected to login
        $response = $this->get('/admin');
        $response->assertRedirect('/login');

        // 2. Regular user is redirected to landing with error
        $regularUser = User::where('email', 'patient@drsosonline.com')->first();
        $response = $this->actingAs($regularUser)->get('/admin');
        $response->assertRedirect(route('landing'));
        $response->assertSessionHas('danger');

        // 3. Admin can access successfully
        $adminUser = User::where('email', 'admin@drsosonline.com')->first();
        $response = $this->actingAs($adminUser)->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('Admin Control Panel');
    }

    /**
     * Test doctor dashboard authorization restrictions.
     */
    public function test_doctor_dashboard_access_restrictions(): void
    {
        // 1. Guest is redirected to login
        $response = $this->get('/doctor/dashboard');
        $response->assertRedirect('/login');

        // 2. Regular user is redirected to landing with error
        $regularUser = User::where('email', 'patient@drsosonline.com')->first();
        $response = $this->actingAs($regularUser)->get('/doctor/dashboard');
        $response->assertRedirect(route('landing'));

        // 3. Doctor can access successfully
        $doctorUser = User::where('email', 'priya@drsosonline.com')->first();
        $response = $this->actingAs($doctorUser)->get('/doctor/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Doctor Dashboard');
    }
}
