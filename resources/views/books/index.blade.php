@extends('layouts.app')

@section('title', '圖書查詢')

@section('content')
    {{-- ===== 頁首 + 搜尋 ===== --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">圖書查詢</h1>

        {{-- GET 搜尋：?q=關鍵字 --}}
        <form method="GET" action="{{ route('books.index') }}" class="d-flex gap-2">
            <div class="input-group">
                <input
                    type="text"
                    name="q"
                    value="{{ $q }}"
                    placeholder="搜尋書名 / 作者 / ISBN"
                    class="form-control"
                    style="width: 300px;"
                >
                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-search"></i> 搜尋
                </button>
            </div>
        </form>
    </div>

    {{-- ===== 無資料提示 ===== --}}
    @if($books->count() === 0)
        <div class="alert alert-info shadow-sm">
            目前沒有符合條件的書籍資料。
        </div>
    @else
        {{-- ===== 書籍表格 (使用 Bootstrap Card 包裝) ===== --}}
        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">書名</th>
                            <th>作者</th>
                            <th>ISBN</th>
                            <th class="text-center">可借副本</th>
                            <th class="pe-4 text-end">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($books as $book)
                            <tr>
                                <td class="ps-4">
                                    <span class="fw-bold text-dark">{{ $book->title }}</span>
                                </td>
                                <td>{{ $book->author }}</td>
                                <td><code>{{ $book->isbn }}</code></td>
                                <td class="text-center">
                                    @if($book->available_copies_count > 0)
                                        <span class="badge rounded-pill bg-success-subtle text-success border border-success">
                                            {{ $book->available_copies_count }} 可借
                                        </span>
                                    @else
                                        <span class="badge rounded-pill bg-secondary-subtle text-secondary border border-secondary">
                                            0（不可借）
                                        </span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm btn-outline-primary">
                                        查看詳情
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ===== 分頁 ===== --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $books->links() }}
        </div>
    @endif
@endsection
