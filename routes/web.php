<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\Staff\LoanController as StaffLoanController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});


// ===== 館員借出功能 =====
Route::middleware(['auth'])->group(function () {
    Route::get('/staff/loans/checkout', [StaffLoanController::class, 'create'])
        ->name('staff.loans.create');

    Route::post('/staff/loans/checkout', [StaffLoanController::class, 'store'])
        ->name('staff.loans.store');
});

//===== 歸還功能 =====
Route::get('/staff/loans/return', [StaffLoanController::class, 'returnForm'])
    ->name('staff.loans.return.form');

Route::post('/staff/loans/return', [StaffLoanController::class, 'returnStore'])
    ->name('staff.loans.return.store');
// ===== 館員查看借閱紀錄功能 =====
Route::get('/staff/loans', [StaffLoanController::class, 'index'])
    ->name('staff.loans.index');

Route::get('/my/loans', [StaffLoanController::class, 'myLoans'])
    ->name('my.loans.index');
