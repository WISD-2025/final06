<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookCopy extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'book_title_id',   // 所屬書目
        'barcode',         // 條碼
        'status',          // 狀態：available / loaned
    ];

    /**
     * 每一本館藏副本屬於一個書目
     */
    public function title()
    {
        return $this->belongsTo(BookTitle::class, 'book_title_id');
    }
    

    /**
     * 這本館藏的所有借閱紀錄
     */
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    /**
     * 目前有效的借閱紀錄（尚未歸還）
     */
    public function currentLoan()
    {
        return $this->hasOne(Loan::class)->whereNull('return_date');
    }
}



