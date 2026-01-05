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

            {{-- 搜尋（GET /staff/books?q= ） --}}
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

                {{-- Step 3 會做新增功能，先放一個 disabled 按鈕當佔位 --}}
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
                                    {{-- Step 3 會做編輯/刪除，先放 disabled --}}
                                    <button class="btn btn-sm btn-outline-secondary" disabled>
                                        編輯
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" disabled>
                                        刪除
                                    </button>
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

            {{-- 分頁（用 bootstrap 版型） --}}
            <div class="mt-3">
                {{ $books->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
