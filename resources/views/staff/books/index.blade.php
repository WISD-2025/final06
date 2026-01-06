@extends('layouts.app')

@section('title', '書籍管理')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">書籍管理</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">書籍管理</li>
    </ol>

    {{-- 搜尋與新增區塊 --}}
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            書籍列表 <span class="badge bg-secondary">{{ $books->total() }} 筆</span>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-8"></div>
                <div class="col-md-4">
                    <form action="{{ route('staff.books.index') }}" method="GET" class="d-flex gap-2">
                        <input type="text" name="q" class="form-control" placeholder="搜尋書名 / 作者 / ISBN" value="{{ request('q') }}">
                        <button type="submit" class="btn btn-dark">搜尋</button>
                        <a href="{{ route('staff.books.create') }}" class="btn btn-primary text-nowrap">
                            <i class="fas fa-plus"></i> 新增
                        </a>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            {{-- ID 欄位已移除 --}}
                            <th>書名</th>
                            <th>作者</th>
                            <th>ISBN</th>
                            <th>出版年</th>
                            <th class="text-center">可借副本</th>
                            <th class="text-center" style="width: 150px;">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($books as $book)
                            <tr>
                                {{-- ID 欄位已移除 --}}
                                <td>
                                    <span class="fw-bold text-primary">{{ $book->title }}</span>
                                </td>
                                <td>{{ $book->author }}</td>
                                <td>{{ $book->isbn }}</td>
                                <td>{{ $book->published_year }}</td>
                                <td class="text-center">
                                    @if($book->available_copies_count > 0)
                                        <span class="badge bg-success rounded-pill">可借 {{ $book->available_copies_count }}</span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill">0</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('staff.books.edit', $book->id) }}" class="btn btn-outline-secondary">編輯</a>
                                        
                                        <form action="{{ route('staff.books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('確定要刪除這本書嗎？');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger">刪除</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    尚無書籍資料
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- 分頁 --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $books->links() }}
            </div>
        </div>
    </div>
</div>
@endsection