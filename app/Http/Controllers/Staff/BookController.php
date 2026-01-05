<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\BookTitle;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * 後台書籍管理列表（含搜尋）
     * GET /staff/books?q=
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
                // 可借副本數：status=available
                'copies as available_copies_count' => fn ($sub) => $sub->where('status', 'available'),
            ])
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('staff.books.index', compact('books', 'q'));
    }

    /**
     * 新增書目表單
     * GET /staff/books/create
     */
    public function create()
    {
        return view('staff.books.create');
    }

    /**
     * 儲存新增書目
     * POST /staff/books
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author' => ['nullable', 'string', 'max:255'],
            'isbn' => ['nullable', 'string', 'max:50'],
            'published_year' => ['nullable', 'integer', 'min:0', 'max:3000'],
        ]);

        BookTitle::create($data);

        return redirect()
            ->route('staff.books.index')
            ->with('success', '書目新增成功！');
    }

}
