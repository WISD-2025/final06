<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\Staff\LoanController as StaffLoanController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BookController;



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


// ===== 館員/管理者專區（librarian 才能進）=====
Route::middleware(['auth', 'role:librarian'])
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {

        // 館員查看全部借閱紀錄
        Route::get('/loans', [StaffLoanController::class, 'index'])
            ->name('loans.index');

        // 借出
        Route::get('/loans/checkout', [StaffLoanController::class, 'create'])
            ->name('loans.create');
        Route::post('/loans/checkout', [StaffLoanController::class, 'store'])
            ->name('loans.store');

        // 歸還
        Route::get('/loans/return', [StaffLoanController::class, 'returnForm'])
            ->name('loans.return.form');
        Route::post('/loans/return', [StaffLoanController::class, 'returnStore'])
            ->name('loans.return.store');
    });

// ===== 讀者：我的借閱（登入即可）=====
Route::middleware(['auth'])->get('/my/loans', [StaffLoanController::class, 'myLoans'])
    ->name('my.loans.index');


// ===== 偵錯專用路由（開發時使用）=====
Route::get('/__debug/db', function () {
    $db = DB::selectOne('select database() as db');
    return response()->json([
        'database' => $db?->db,
        'users_count' => \App\Models\User::count(),
        'admin_exists' => \App\Models\User::where('email','admin@final06.com')->exists(),
        'fortify_username' => config('fortify.username'),
        'auth_user_model' => config('auth.providers.users.model'),
    ]);
});

Route::get('/books', [BookController::class, 'index'])->name('books.index');


/*管理者帳號:admin@final06.com
密碼:Admin12345!*/


