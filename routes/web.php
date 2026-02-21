<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminPasswordController;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\CustomerAuthController;

Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [CustomerAuthController::class, 'login'])->name('login.attempt');

use App\Http\Controllers\CustomerRegisterController;

Route::get('/register', [CustomerRegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [CustomerRegisterController::class, 'register'])->name('register.attempt');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::get('/quiz', \App\Livewire\QuizPage::class)->name('quiz');

use App\Models\Testimonial;
use Illuminate\Http\Request;

use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\CustomerProfileController;

// Testimonial deletion is handled via Filament-native actions.

// Admin auth routes (separate login form)
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('filament.admin.auth.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.attempt');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Filament expects a named admin logout route for the panel; provide an alias.
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('filament.admin.auth.logout');

Route::post('/admin/tickets/{ticket}/reply', [\App\Http\Controllers\AdminTicketReplyController::class, 'store'])
    ->middleware('auth:admin')
    ->name('admin.tickets.reply');

// messages JSON (polled by admin chat partial)
Route::get('/admin/tickets/{ticket}/messages', [\App\Http\Controllers\AdminTicketReplyController::class, 'messages'])
    ->middleware('auth:admin')
    ->name('admin.tickets.messages');

// Admin password reset
Route::get('/admin/password/reset', [AdminPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');
Route::post('/admin/password/email', [AdminPasswordController::class, 'sendResetLinkEmail'])->name('admin.password.email');
Route::get('/admin/password/reset/{token}', [AdminPasswordController::class, 'showResetForm'])->name('admin.password.reset');
Route::post('/admin/password/reset', [AdminPasswordController::class, 'reset'])->name('admin.password.update');

// Customer dashboard (authenticated)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/my-plans', [\App\Http\Controllers\CustomerPackageController::class, 'index'])->name('my-plans');
    Route::post('/my-plans/{userPackage}/cancel', [\App\Http\Controllers\CustomerPackageController::class, 'cancel'])->name('my-plans.cancel');
    Route::post('/my-plans/{userPackage}/renew', [\App\Http\Controllers\CustomerPackageController::class, 'renew'])->name('my-plans.renew');
    Route::get('/investment-plans', fn() => view('customer.investment-plans'))->name('investment-plans');
    Route::get('/investment-plans', [\App\Http\Controllers\InvestmentPlanController::class, 'index'])->name('investment-plans');
    Route::post('/investment-plans/{package}/activate', [\App\Http\Controllers\InvestmentPlanController::class, 'activate'])->name('investment-plans.activate');
    Route::get('/complaints', fn() => view('customer.complaints'))->name('complaints');
    Route::get('/partners', fn() => view('customer.partners'))->name('partners');
    Route::get('/profile', [CustomerProfileController::class, 'edit'])->name('profile');
    Route::post('/profile', [CustomerProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [CustomerProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::post('/profile/password', [CustomerProfileController::class, 'updatePassword'])->name('profile.password.update');
    
    // Customer complaints/ticketing
    Route::get('/complaints', [\App\Http\Controllers\CustomerComplaintController::class,'index'])->name('complaints');
    Route::get('/complaints/create', [\App\Http\Controllers\CustomerComplaintController::class,'create'])->name('complaints.create');
    Route::post('/complaints', [\App\Http\Controllers\CustomerComplaintController::class,'store'])->name('complaints.store');
    Route::get('/complaints/{ticket}', [\App\Http\Controllers\CustomerComplaintController::class,'show'])->name('complaints.show');
    Route::post('/complaints/{ticket}/reply', [\App\Http\Controllers\CustomerComplaintController::class,'reply'])->name('complaints.reply');
});


