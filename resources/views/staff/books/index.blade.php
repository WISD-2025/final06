@extends('layouts.app')

@section('title', '書籍管理')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">書籍管理</h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">書籍管理</li>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </ol>

    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-light fw-bold d-flex align-items-center justify-content-between">
            <div>
                <i class="fas fa-book me-1"></i> 書籍列表
                <span class="text-muted fw-normal ms-2">（共 {{ $books->total() }} 筆）</span>
            </div>

            {{-- 搜尋與新增按鈕區塊 --}}
            <form method="GET" action="{{ route('staff.books.index') }}" class="d-flex" style="gap:8px;">
                <div class="input-group">
                    <input type="text"
                           name="q"
                           value="{{ $q }}"
                           class="form-control"
                           placeholder="搜尋書名 / 作者 / ISBN">
                    <button class="btn btn-dark" type="submit">搜尋</button>
                </div>

                @if($q)
                    <a class="btn btn-outline-secondary" href="{{ route('staff.books.index') }}">清除</a>
                @endif

                <a class="btn btn-primary" href="{{ route('staff.books.create') }}">
                    <i class="fas fa-plus me-1"></i> 新增
                </a>
            </form>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width:70px;">ID</th>
                            <th>書名</th>
                            <th style="width:160px;">作者</th>
                            <th style="width:160px;">ISBN</th>
                            <th style="width:110px;">出版年</th>
                            <th style="width:120px;">可借副本</th>
                            <th style="width:170px;">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($books as $book)
                            <tr>
                                <td>{{ $book->id }}</td>
                                <td class="fw-bold text-primary">
                                    {{ $book->title }}
                                </td>
                                <td>{{ $book->author }}</td>
                                <td class="font-monospace">{{ $book->isbn }}</td>
                                <td>{{ $book->published_year }}</td>
                                <td>
                                    @if(($book->available_copies_count ?? 0) > 0)
                                        <span class="badge bg-success rounded-pill">
                                            可借 {{ $book->available_copies_count }}
                                        </span>
                                    @else
                                        <span class="badge bg-danger rounded-pill">
                                            已借光
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    
                                    <div class="d-flex gap-2">
                                        {{-- 編輯按鈕 --}}
                                        <a href="{{ route('staff.books.edit', $book->id) }}" 
                                           class="btn btn-sm btn-outline-secondary">
                                            編輯
                                        </a>

                                        {{-- 刪除按鈕 --}}
                                        <form action="{{ route('staff.books.destroy', $book->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('確定要刪除《{{ $book->title }}》嗎？此操作無法復原！');">
                                            
                                            @csrf
                                            @method('DELETE')
                                            
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                刪除
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    目前沒有書籍資料。
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- 分頁 --}}
            <div class="mt-3">
                {{ $books->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection