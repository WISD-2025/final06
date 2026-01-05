<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookTitle extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'title',           // 書名
        'author',          // 作者
        'isbn',            // ISBN
        'published_year',  // 出版年
    ];

    /**
     * 一個書目有多個館藏副本
     */
    public function copies()
    {
        return $this->hasMany(BookCopy::class);
    }


    /**
     * BookTitle（一筆書目）對應多筆 BookCopy（館藏副本）
     * 用於：
     * - 計算可借副本數（status=available）
     * - 後續書籍詳情頁顯示副本列表
     */
    public function bookCopies()
    {
        return $this->hasMany(\App\Models\BookCopy::class);
    }
    
}
