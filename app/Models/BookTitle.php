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
}
