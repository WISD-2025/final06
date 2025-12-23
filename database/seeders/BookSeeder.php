<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BookTitle;
use App\Models\BookCopy;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 書目 1
        $book1 = BookTitle::create([
            'title' => 'Laravel 入門',
            'author' => 'Taylor Otwell',
            'isbn' => '978000000001',
            'published_year' => 2023,
        ]);

        BookCopy::create([
            'book_title_id' => $book1->id,
            'barcode' => 'BC0001',
            'status' => 'available',
        ]);

        BookCopy::create([
            'book_title_id' => $book1->id,
            'barcode' => 'BC0002',
            'status' => 'available',
        ]);


        
        // 書目 2
        $book2 = BookTitle::create([
            'title' => '資料庫系統概論',
            'author' => 'Elmasri',
            'isbn' => '978000000002',
            'published_year' => 2020,
        ]);

        BookCopy::create([
            'book_title_id' => $book2->id,
            'barcode' => 'BC0003',
            'status' => 'available',
        ]);
    }
}

