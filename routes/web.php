<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EduConsultController;
use App\Http\Controllers\OnlineConsultController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;

// Landing and General
Route::get('/', [HomeController::class, 'landing'])->name('landing');
Route::get('/health', [HomeController::class, 'health'])->name('health');
Route::get('/payment/upi', [HomeController::class, 'upiPayment'])->name('payment.upi');
Route::get('/payment/success', [HomeController::class, 'paymentSuccess'])->name('payment.success');

// Authentication Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'submitRegister'])->name('register.submit');
    Route::get('/register/profile', [AuthController::class, 'showRegisterProfile'])->name('register.profile');
    Route::post('/register/profile', [AuthController::class, 'submitRegisterProfile'])->name('register.profile.submit');
    Route::get('/register/education', [AuthController::class, 'showRegisterEducation'])->name('register.education');
    Route::post('/register/education', [AuthController::class, 'submitRegisterEducation'])->name('register.education.submit');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'submitLogin'])->name('login.submit');
});

// Authentication Required routes
Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
    
    // Support both paths to avoid broken links
    Route::get('/applications', [DashboardController::class, 'applications'])->name('applications');
    Route::get('/dashboard/applications', [DashboardController::class, 'applications'])->name('dashboard.applications');
});

// Admin Panel routes (Requires auth and admin middleware)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'admin'])->name('admin');
});

// Doctor Portal routes
Route::middleware(['auth', 'doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');
    Route::get('/appointments/{id}', [DoctorController::class, 'showAppointment'])->name('appointment.show');
    Route::post('/appointments/{id}', [DoctorController::class, 'updateAppointment'])->name('appointment.update');
});

// EduConsult Portal
Route::prefix('edu')->group(function () {
    Route::get('/', [EduConsultController::class, 'home'])->name('edu.home');
    Route::get('/education', [EduConsultController::class, 'education'])->name('edu.education');
    Route::get('/contact', [EduConsultController::class, 'contact'])->name('edu.contact');
    Route::post('/contact', [EduConsultController::class, 'submitContact'])->name('edu.contact.submit');
    Route::get('/book', [EduConsultController::class, 'book'])->name('edu.book');
    Route::post('/book', [EduConsultController::class, 'submitBook'])->name('edu.book.submit');
});

// Online Medical Portal
Route::prefix('online')->group(function () {
    Route::get('/', [OnlineConsultController::class, 'home'])->name('online.home');
    Route::get('/doctors', [OnlineConsultController::class, 'doctors'])->name('online.doctors');
    Route::get('/doctors/{id}', [OnlineConsultController::class, 'doctorDetail'])->name('online.doctors.show');
    Route::get('/consult', [OnlineConsultController::class, 'consult'])->name('online.consult');
    Route::post('/consult', [OnlineConsultController::class, 'submitConsult'])->name('online.consult.submit');
    Route::get('/palliative-care', [OnlineConsultController::class, 'palliativeCare'])->name('online.palliative_care');
    Route::get('/air-ambulance', [OnlineConsultController::class, 'airAmbulance'])->name('online.air_ambulance');
    Route::get('/contact', [OnlineConsultController::class, 'contact'])->name('online.contact');
    Route::post('/contact', [OnlineConsultController::class, 'submitContact'])->name('online.contact.submit');
});
