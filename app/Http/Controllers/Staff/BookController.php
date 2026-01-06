<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\BookTitle;
use App\Models\BookCopy;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * 後台書籍管理列表（含搜尋）
     */
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $books = BookTitle::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                    ->orWhere('author', 'like', "%{$q}%")
                    ->orWhere('isbn', 'like', "%{$q}%");
            })
            ->withCount([
                'copies as available_copies_count' => fn ($sub) => $sub->where('status', 'available'),
            ])
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('staff.books.index', compact('books', 'q'));
    }

    public function create()
    {
        return view('staff.books.create');
    }

    /**
     * 儲存新增書目 (含選擇性的初始副本)
     */
    public function store(Request $request)
    {
        // 1. 驗證資料
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author' => ['nullable', 'string', 'max:255'],
            'isbn' => ['nullable', 'string', 'max:50'],
            'published_year' => ['nullable', 'integer', 'min:0', 'max:3000'],
            'barcode' => ['nullable', 'string', 'max:50', 'unique:book_copies,barcode'],
        ]);

        // 2. 取出 barcode 並從 data 移除 (因為 BookTitle 表沒有 barcode 欄位)
        $barcode = $data['barcode'] ?? null;
        unset($data['barcode']);

        // 3. 建立書目
        $book = BookTitle::create($data);

        // 4. 如果有填寫條碼，順便建立副本
        $message = '書目新增成功！';
        
        if ($barcode) {
            BookCopy::create([
                'book_title_id' => $book->id,
                'barcode' => $barcode,
                'status' => 'available', // 預設在架上
            ]);
            $message = '書目與初始副本皆新增成功！';
        }

        return redirect()
            ->route('staff.books.index')
            ->with('success', $message);
    }

    public function edit($id)
    {
        $book = BookTitle::findOrFail($id);
        return view('staff.books.edit', compact('book'));
    }

    public function update(Request $request, $id)
    {
        $book = BookTitle::findOrFail($id);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author' => ['nullable', 'string', 'max:255'],
            'isbn' => ['nullable', 'string', 'max:50', 'unique:book_titles,isbn,' . $id],
            'published_year' => ['nullable', 'integer', 'min:0', 'max:3000'],
        ]);

        $book->update($data);

        return redirect()
            ->route('staff.books.index')
            ->with('success', '書目資料更新成功！');
    }

    public function destroy($id)
    {
        $book = BookTitle::findOrFail($id);
        $book->delete();

        return redirect()
            ->route('staff.books.index')
            ->with('success', '書目已刪除！');
    }

    public function show($id)
    {
        // 抓取書籍，並預先載入 copies (副本) 以避免 N+1 問題
        $book = BookTitle::with('copies')->findOrFail($id);

        return view('staff.books.show', compact('book'));
    }

    /**
     * 新增副本 (接收 POST 請求)
     */
    public function addCopy(Request $request, $id)
    {
        $book = BookTitle::findOrFail($id);

        // 驗證
        $request->validate([
            'barcode' => ['required', 'string', 'max:50', 'unique:book_copies,barcode'],
        ]);

        // 建立副本
        \App\Models\BookCopy::create([
            'book_title_id' => $book->id,
            'barcode' => $request->barcode,
            'status' => 'available', // 預設為可借
        ]);

        return redirect()
            ->route('staff.books.show', $book->id)
            ->with('success', '成功新增一本館藏副本！');
    }
}