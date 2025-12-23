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
        return $this->belongsTo(BookTitle::class);
    }
}

