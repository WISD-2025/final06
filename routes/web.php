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


// ===== 後台管理專區 (Staff Area) =====
Route::middleware(['auth'])
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {

        // ==========================================
        // 1. 流通櫃台 (借還書)
        // 權限僅限 館員 (Librarian)
        // ==========================================
        Route::middleware(['role:librarian'])->group(function() {
            
            // 紀錄總覽
            Route::get('/loans', [StaffLoanController::class, 'index'])
                ->name('loans.index');

            // 借書
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


        // ==========================================
        // 2. 書籍與庫存管理
        // 權限：僅限 管理員 (Admin)
        // ==========================================
        Route::middleware(['role:admin'])->group(function () {
            
            // --- 書籍 CRUD ---
            Route::get('/books', [StaffBookController::class, 'index'])->name('books.index');
            Route::get('/books/create', [StaffBookController::class, 'create'])->name('books.create');
            Route::post('/books', [StaffBookController::class, 'store'])->name('books.store');
            Route::get('/books/{id}/edit', [StaffBookController::class, 'edit'])->name('books.edit');
            Route::put('/books/{id}', [StaffBookController::class, 'update'])->name('books.update');
            Route::delete('/books/{id}', [StaffBookController::class, 'destroy'])->name('books.destroy');

            // --- 庫存副本管理 ---
            Route::post('/books/{book}/copies', [\App\Http\Controllers\Staff\BookCopyController::class, 'store'])
                ->name('copies.store');
            Route::delete('/copies/{id}', [\App\Http\Controllers\Staff\BookCopyController::class, 'destroy'])
                ->name('copies.destroy');
        });

    });


// ===== 讀者：我的借閱 =====
Route::middleware(['auth'])->get('/my/loans', [StaffLoanController::class, 'myLoans'])
    ->name('my.loans.index');


// ===== 書籍查詢 (前台) =====
Route::get('/books', [BookController::class, 'index'])->name('books.index');

Route::get('/books/{id}', [BookController::class, 'show'])
    ->whereNumber('id')
    ->name('books.show');


// ===== 偵錯專用 =====
Route::middleware(['auth', 'role:admin'])->get('/__debug/db', function () {
    $db = DB::selectOne('select database() as db');
    return response()->json([
        'database' => $db?->db,
        'users_count' => \App\Models\User::count(),
    ]);
});