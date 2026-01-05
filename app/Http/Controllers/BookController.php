<?php

namespace App\Http\Controllers;

use App\Models\BookTitle;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * 前台書籍列表（含搜尋 + 可借副本數）
     * URL 範例：
     * - /books
     * - /books?q=harry
     */
    public function index(Request $request)
    {
        // 取得搜尋關鍵字（query string: ?q=）
        $q = trim((string) $request->query('q', ''));

        // 查詢書目 BookTitle
        $books = BookTitle::query()
            // 1) 計算每本書「可借副本數」
            //    available_copies_count = bookCopies(status=available) 的數量
            ->withCount(['bookCopies as available_copies_count' => function ($query) {
                $query->where('status', 'available');
            }])

            // 2) 有輸入 q 才做搜尋（書名/作者/ISBN 任一符合）
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('title', 'like', "%{$q}%")
                       ->orWhere('author', 'like', "%{$q}%")
                       ->orWhere('isbn', 'like', "%{$q}%");
                });
            })

            // 3) 排序 + 分頁（每頁 10 筆）
            ->orderBy('title')
            ->paginate(10)

            // 4) 分頁時保留 query string（例如 q=xxx）
            ->withQueryString();

        // 改成回傳 Blade 畫面（取代 JSON）
        return view('books.index', compact('books', 'q'));


    }
}
