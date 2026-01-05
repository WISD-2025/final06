<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\BookCopy;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    // 顯示借書表單
    public function create()
    {
        abort_unless(auth()->user()?->role === 'librarian', 403);
        // 注意：這裡對應的 View 檔名必須是 create.blade.php
        return view('staff.loans.create');
    }

    // 處理借書邏輯
    public function store(Request $request)
    {
        abort_unless(auth()->user()?->role === 'librarian', 403);

        // 1. 驗證輸入格式
        $data = $request->validate([
            'member_email' => ['required', 'email'],
            'barcode'      => ['required', 'string'],
            'days'         => ['nullable', 'integer', 'min:1', 'max:60'],
        ]);

        $days = (int) ($data['days'] ?? 14);

        // 2. 檢查讀者資格
        $member = User::where('email', $data['member_email'])->first();
        if (! $member || $member->role !== 'member') {
            return back()->withErrors([
                'member_email' => '查無此讀者帳號，或該帳號不具備借閱資格。'
            ])->withInput();
        }

        // 3. 檢查書籍是否存在
        $copy = BookCopy::where('barcode', $data['barcode'])->first();
        if (! $copy) {
            return back()->withErrors([
                'barcode' => '查無此館藏條碼，請確認輸入是否正確。'
            ])->withInput();
        }

        // 4. 檢查書籍是否在庫
        if ($copy->status !== 'available') {
            return back()->withErrors([
                'barcode' => '此館藏目前已被借出，暫時無法借閱。'
            ])->withInput();
        }

        $loan = null;

        // 5. 資料庫交易：確保「新增借閱紀錄」跟「更新書籍狀態」同時成功
        DB::transaction(function () use ($copy, $member, $days, &$loan) {
            $loan = Loan::create([
                'book_copy_id' => $copy->id,
                'user_id'      => $member->id,
                'loan_date'    => today(),
                'due_date'     => today()->addDays($days),
                'return_date'  => null,
                'status'       => 'loaned',
            ]);

            $copy->update(['status' => 'loaned']);
        });

        // 取得書名 (這裡假設關聯名稱為 title，若報錯請改為 book)
        $bookTitle = $loan->copy->title->title ?? $loan->copy->book->title ?? '未知書名';
        $dueDate   = $loan->due_date->format('Y-m-d');

        return redirect()
            ->route('staff.loans.create')
            ->with('success', "《{$bookTitle}》已成功借出，到期日為 {$dueDate}。");
    }

    // 顯示還書表單
    public function returnForm()
    {
        abort_unless(auth()->user()?->role === 'librarian', 403);
        return view('staff.loans.return');
    }

    // 處理還書邏輯
    public function returnStore(Request $request)
    {
        abort_unless(auth()->user()?->role === 'librarian', 403);

        $data = $request->validate([
            'barcode' => ['required', 'string'],
        ]);

        $copy = BookCopy::where('barcode', $data['barcode'])->first();
        if (! $copy) {
            return back()->withErrors([
                'barcode' => '查無此館藏條碼，請確認輸入是否正確。'
            ])->withInput();
        }

        // 只允許歸還「借出中」的館藏
        if ($copy->status !== 'loaned') {
            return back()->withErrors([
                'barcode' => '此館藏目前不是借出狀態，無法辦理歸還。'
            ])->withInput();
        }

        // 找出目前還沒還的那一筆紀錄
        $loan = $copy->loans()->whereNull('return_date')->first();
        
        if (! $loan) {
            return back()->withErrors([
                'barcode' => '借閱資料異常：查無對應的未歸還紀錄。'
            ])->withInput();
        }

        DB::transaction(function () use ($loan, $copy) {
            $loan->update([
                'return_date' => today(),
                'status'      => 'returned',
            ]);

            $copy->update(['status' => 'available']);
        });

        $bookTitle = $copy->title->title ?? $copy->book->title ?? '未知書名';
        $returnDate = today()->format('Y-m-d');

        return redirect()
            ->route('staff.loans.return.form')
            ->with('success', "《{$bookTitle}》已完成歸還，歸還日為 {$returnDate}。");
    }

    // 館員總覽
    public function index()
    {
        abort_unless(auth()->user()?->role === 'librarian', 403);

            $loans = Loan::with(['user', 'copy.title'])
            ->whereNull('return_date')
            ->orderByDesc('loan_date')
            ->get();

        return view('staff.loans.index', compact('loans'));
    }

    // 讀者查詢自己的紀錄
    public function myLoans()
    {
        $user = auth()->user();

        $loans = Loan::with(['copy.title'])
            ->where('user_id', $user->id)
            ->orderByDesc('loan_date')
            ->get();

        return view('staff.loans.my', compact('loans'));
    }
}