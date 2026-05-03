<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminPasswordController;
use App\Http\Controllers\CustomerAuthController;


// wordpress+laravel login system releated part
use App\Http\Controllers\SsoController;
use App\Http\Controllers\SsoRegisterController;
use App\Http\Controllers\SsoPasswordController;

Route::post('/sso/login-request', [SsoController::class, 'loginRequest'])
    ->middleware(['guest', 'verify.sso'])
    ->name('sso.login-request');

Route::get('/sso/consume', [SsoController::class, 'consume'])
    ->middleware(['guest'])
    ->name('sso.consume');

Route::post('/sso/register-request', [SsoRegisterController::class, 'registerRequest'])
    ->middleware(['guest', 'verify.sso'])
    ->name('sso.register-request');

Route::post('/sso/forgot-password', [SsoPasswordController::class, 'forgotPassword'])
    ->middleware(['guest', 'verify.sso'])
    ->name('sso.forgot-password');

Route::get('/reset-password/{token}', [SsoPasswordController::class, 'showResetPage'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/sso/reset-password', [SsoPasswordController::class, 'resetPassword'])
    ->middleware(['guest', 'verify.sso'])
    ->name('sso.reset-password');
    
Route::post('/customer-logout', [CustomerAuthController::class, 'customerLogout'])
    ->middleware(['auth'])
    ->name('customerLogout');
// wordpress+laravel login system releated part ends

//wordpress broker finder route
use App\Http\Controllers\BrokerFinderApiController;
Route::prefix('api/broker-finder')->group(function () {
    Route::get('/questions', [BrokerFinderApiController::class, 'questions'])
        ->name('broker-finder.api.questions');

    Route::post('/match', [BrokerFinderApiController::class, 'match'])
        ->name('broker-finder.api.match');

    Route::get('/recommendations', [BrokerFinderApiController::class, 'recommendations'])
        ->name('broker-finder.api.recommendations');
});
// End of WordPress broker finder routes


Route::get('/', [CustomerAuthController::class, 'showLoginForm'])->name('login');

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

// Public quiz route (also accessible from authenticated area)
Route::get('/quiz', \App\Livewire\QuizPage::class)->name('quiz');

use App\Models\Testimonial;
use Illuminate\Http\Request;

use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\AffiliateController;
use App\Http\Controllers\BrokerFinderController;

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
    Route::get('/investment-plans', [\App\Http\Controllers\InvestmentPlanController::class, 'index'])->name('investment-plans');
    Route::get('/submit-broker-details', [\App\Http\Controllers\InvestmentPlanController::class, 'submitDetailsShortcut'])->name('investment-plans.submit-details');
    Route::get('/investment-plans/{package}/request', [\App\Http\Controllers\InvestmentPlanController::class, 'requestForm'])->name('investment-plans.request');
    Route::post('/investment-plans/{package}/request', [\App\Http\Controllers\InvestmentPlanController::class, 'submitRequest'])->name('investment-plans.request.submit');
    Route::get('/custom-best-broker', [BrokerFinderController::class, 'chooser'])->name('custom-best-broker');
    Route::get('/find-broker', [BrokerFinderController::class, 'index'])->name('find-broker');
    Route::get('/complaints', fn() => view('customer.complaints'))->name('complaints');
    
    // Affiliate routes
    Route::get('/partners', [AffiliateController::class, 'index'])->name('partners');
    Route::get('/partners/apply', [AffiliateController::class, 'apply'])->name('partners.apply');
    Route::post('/partners/apply', [AffiliateController::class, 'storeApplication'])->name('partners.store-application');
    Route::post('/affiliate/referral-link', [AffiliateController::class, 'getReferralLink'])->name('affiliate.referral-link');
    
    Route::get('/profile', [CustomerProfileController::class, 'edit'])->name('profile');
    Route::post('/profile', [CustomerProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [CustomerProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::post('/profile/password', [CustomerProfileController::class, 'updatePassword'])->name('profile.password.update');

    // Email verification
    Route::get('/email/verify', [\App\Http\Controllers\CustomerEmailVerificationController::class, 'notice'])
        ->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [\App\Http\Controllers\CustomerEmailVerificationController::class, 'verify'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('/email/verification-notification', [\App\Http\Controllers\CustomerEmailVerificationController::class, 'resend'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // Pending email change verification
    Route::get('/email/change/verify/{id}/{hash}', [\App\Http\Controllers\CustomerProfileController::class, 'verifyPendingEmail'])
        ->middleware('signed')
        ->name('verification.email-change.verify');
    Route::post('/email/change/cancel', [\App\Http\Controllers\CustomerProfileController::class, 'cancelPendingEmail'])
        ->name('verification.email-change.cancel');
    Route::post('/email/change/resend', [\App\Http\Controllers\CustomerProfileController::class, 'resendPendingEmailChange'])
        ->middleware('throttle:6,1')
        ->name('verification.email-change.resend');
    
    // Customer complaints/ticketing
    Route::get('/complaints', [\App\Http\Controllers\CustomerComplaintController::class,'index'])->name('complaints');
    Route::get('/complaints/create', [\App\Http\Controllers\CustomerComplaintController::class,'create'])->name('complaints.create');
    Route::post('/complaints', [\App\Http\Controllers\CustomerComplaintController::class,'store'])->name('complaints.store');
    Route::get('/complaints/{ticket}', [\App\Http\Controllers\CustomerComplaintController::class,'show'])->name('complaints.show');
    Route::post('/complaints/{ticket}/reply', [\App\Http\Controllers\CustomerComplaintController::class,'reply'])->name('complaints.reply');
    Route::post('/complaints/{ticket}/close', [\App\Http\Controllers\CustomerComplaintController::class,'close'])->name('complaints.close');
    Route::post('/complaints/{ticket}/update-priority', [\App\Http\Controllers\CustomerComplaintController::class,'updatePriority'])->name('complaints.update-priority');
});


