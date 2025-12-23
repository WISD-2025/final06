<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\BookCopy;
use App\Models\Loan;
use Carbon\Carbon;

class LoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 找出測試讀者與館藏
        $member = User::where('email', 'member@example.com')->first();
        $copy   = BookCopy::where('barcode', 'BC0001')->first();

        if (! $member || ! $copy) {
            return; // 如果找不到使用者或館藏，則結束
        }

        $loanDate = Carbon::today();
        $dueDate  = Carbon::today()->addDays(14);

        // 建立一筆借閱紀錄（尚未歸還）
        Loan::create([
            'book_copy_id' => $copy->id,
            'user_id'      => $member->id,
            'loan_date'    => $loanDate,
            'due_date'     => $dueDate,
            'return_date'  => null,
            'status'       => 'loaned',
        ]);

        // 把這本書的狀態改成已借出
        $copy->update([
            'status' => 'loaned',
        ]);
    }
}

