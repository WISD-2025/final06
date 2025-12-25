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

    public function create()
    {
        // 權限：只有館員
        abort_unless(auth()->user()?->role === 'librarian', 403);

        return view('staff.loans.create');
    }


    public function store(Request $request)
    {
        abort_unless(auth()->user()?->role === 'librarian', 403);

        $data = $request->validate([
            'member_email' => ['required', 'email'],
            'barcode'      => ['required', 'string'],
            'days'         => ['nullable', 'integer', 'min:1', 'max:60'],
        ]);

        $days = (int) ($data['days'] ?? 14);


        $member = User::where('email', $data['member_email'])->first();
if (! $member || $member->role !== 'member') {
    return back()->withErrors([
        'member_email' => '查無此讀者帳號，或該帳號不具備借閱資格。'
    ])->withInput();
}

        $copy = BookCopy::where('barcode', $data['barcode'])->first();
if (! $copy) {
    return back()->withErrors([
        'barcode' => '查無此館藏條碼，請確認輸入是否正確。'
    ])->withInput();
}

if ($copy->status !== 'available') {
    return back()->withErrors([
        'barcode' => '此館藏目前已被借出，暫時無法借閱。'
    ])->withInput();
}

$loan = null;

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


    $bookTitle = $loan->copy->title->title;
$dueDate   = $loan->due_date->format('Y-m-d');

return redirect()
    ->route('staff.loans.create')
    ->with('success', "《{$bookTitle}》已成功借出，到期日為 {$dueDate}。");

}
}
