<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;
use App\Models\Doctor;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Admin User
        $adminUser = User::create([
            'email' => 'admin@drsosonline.com',
            'password' => Hash::make('password123'),
            'is_active' => true,
            'is_admin' => true,
        ]);

        Profile::create([
            'user_id' => $adminUser->id,
            'first_name' => 'Dr.SOS',
            'last_name' => 'Admin',
            'phone' => '+91 70253 61771',
            'country' => 'India',
        ]);

        // 2. Create Patient Test User
        $patientUser = User::create([
            'email' => 'patient@drsosonline.com',
            'password' => Hash::make('password123'),
            'is_active' => true,
            'is_admin' => false,
        ]);

        Profile::create([
            'user_id' => $patientUser->id,
            'first_name' => 'Aarav',
            'last_name' => 'Kumar',
            'phone' => '+91 98765 43210',
            'country' => 'India',
            'city' => 'Kochi',
            'county_state' => 'Kerala',
        ]);

        // 3. Create Doctor 1 User and Doctor profile
        $doctorUser1 = User::create([
            'email' => 'priya@drsosonline.com',
            'password' => Hash::make('password123'),
            'is_active' => true,
            'is_admin' => false,
        ]);

        Profile::create([
            'user_id' => $doctorUser1->id,
            'first_name' => 'Priya',
            'last_name' => 'Sharma',
            'phone' => '+91 99999 88888',
            'country' => 'India',
        ]);

        Doctor::create([
            'user_id' => $doctorUser1->id,
            'name' => 'Dr. Priya Sharma',
            'specialty' => 'General Physician',
            'qualification' => 'MBBS, MD (Internal Medicine)',
            'bio' => 'Dr. Priya Sharma has over 10 years of experience in general medicine and primary care. She specialises in managing chronic conditions, lifestyle diseases, and preventive healthcare. Known for her patient-first approach and clear communication.',
            'languages' => 'English, Hindi, Tamil',
            'photo_url' => 'images/dr_priya.png',
            'years_experience' => 10,
            'available_days' => 'Mon,Tue,Wed,Thu,Fri',
            'available_from' => '09:00',
            'available_to' => '18:00',
            'fee_phone' => 99,
            'fee_video' => 199,
            'rating' => 4.9,
            'total_consultations' => 320,
            'is_active' => true,
        ]);

        // 4. Create Doctor 2 User and Doctor profile
        $doctorUser2 = User::create([
            'email' => 'rahul@drsosonline.com',
            'password' => Hash::make('password123'),
            'is_active' => true,
            'is_admin' => false,
        ]);

        Profile::create([
            'user_id' => $doctorUser2->id,
            'first_name' => 'Rahul',
            'last_name' => 'Mehta',
            'phone' => '+91 77777 66666',
            'country' => 'India',
        ]);

        Doctor::create([
            'user_id' => $doctorUser2->id,
            'name' => 'Dr. Rahul Mehta',
            'specialty' => 'Paediatrician',
            'qualification' => 'MBBS, DCH, MD (Paediatrics)',
            'bio' => 'Dr. Rahul Mehta is a dedicated paediatrician with 8 years of experience caring for infants, children, and adolescents. He has a special interest in childhood nutrition, developmental milestones, and respiratory conditions. Parents trust his calm and reassuring approach.',
            'languages' => 'English, Hindi, Gujarati',
            'photo_url' => 'images/dr_rahul.png',
            'years_experience' => 8,
            'available_days' => 'Mon,Wed,Thu,Fri,Sat',
            'available_from' => '10:00',
            'available_to' => '19:00',
            'fee_phone' => 99,
            'fee_video' => 199,
            'rating' => 4.8,
            'total_consultations' => 215,
            'is_active' => true,
        ]);
    }
}
