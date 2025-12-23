<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_copy_id',
        'user_id',
        'loan_date',
        'due_date',
        'return_date',
        'status',
    ];

    // 哪一位讀者借的
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 借的是哪一本館藏副本
    public function copy()
    {
        return $this->belongsTo(BookCopy::class, 'book_copy_id');
    }
}
