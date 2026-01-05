<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\Staff\LoanController as StaffLoanController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\Staff\BookController as StaffBookController;
use Illuminate\Support\Facades\DB;

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


// ===== 館員/管理者專區 =====
// 修正：移除這裡的 inline function，只保留 'auth'
// 權限檢查交給 Controller 裡的 abort_unless 處理
Route::middleware(['auth', 'role:librarian']) 
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {

        // 1. 館員查看全部借閱紀錄
        Route::get('/loans', [StaffLoanController::class, 'index'])
            ->name('loans.index');

        // 2. 借出
        Route::get('/loans/checkout', [StaffLoanController::class, 'create'])
            ->name('loans.create');
        Route::post('/loans/checkout', [StaffLoanController::class, 'store'])
            ->name('loans.store');

        // 3. 歸還
        Route::get('/loans/return', [StaffLoanController::class, 'returnForm'])
            ->name('loans.return.form');
        Route::post('/loans/return', [StaffLoanController::class, 'returnStore'])
            ->name('loans.return.store');
        
        // ===== 書籍管理（librarian）=====
        Route::get('/books', [StaffBookController::class, 'index'])
            ->name('books.index');
        
        // 新增書目（表單）
        Route::get('/books/create', [StaffBookController::class, 'create'])
            ->name('books.create');

        // 新增書目（送出）
        Route::post('/books', [StaffBookController::class, 'store'])
            ->name('books.store');


    });

// ===== 讀者：我的借閱 =====
Route::middleware(['auth'])->get('/my/loans', [StaffLoanController::class, 'myLoans'])
    ->name('my.loans.index');


// ===== 書籍查詢 =====
Route::get('/books', [BookController::class, 'index'])->name('books.index');

Route::get('/books/{id}', [BookController::class, 'show'])
    ->whereNumber('id')
    ->name('books.show');


// ===== 偵錯專用 =====
Route::middleware(['auth', 'role:librarian'])->get('/__debug/db', function () {
    $db = DB::selectOne('select database() as db');
    return response()->json([
        'database' => $db?->db,
        'users_count' => \App\Models\User::count(),
    ]);
});


