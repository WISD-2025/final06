@extends('layouts.app')

@section('title', '新增書目')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">新增書目</h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('staff.books.index') }}">書籍管理</a></li>
        <li class="breadcrumb-item active">新增</li>
    </ol>

    @if ($errors->any())
        <div class="alert alert-danger">
            <div class="fw-bold mb-2">表單有錯誤，請修正後再送出：</div>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-light fw-bold">
            <i class="fas fa-plus me-1"></i> 新增書目資料
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('staff.books.store') }}">
                @csrf

                {{-- 1. 書名 --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">書名 <span class="text-danger">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" class="form-control" required>
                </div>

                {{-- 2. 作者 --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">作者</label>
                    <input type="text" name="author" value="{{ old('author') }}" class="form-control">
                </div>

                {{-- 3. ISBN --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">ISBN</label>
                    <input type="text" name="isbn" value="{{ old('isbn') }}" class="form-control">
                </div>

                {{-- 4. 出版年 --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">出版年</label>
                    <input type="number" name="published_year" value="{{ old('published_year') }}" class="form-control" min="0" max="3000">
                </div>

                <hr class="my-4">

                {{-- ★★★ 5. 初始副本條碼 (原本缺了這一塊) ★★★ --}}
                <div class="p-3 bg-light border rounded mb-3">
                    <label class="form-label fw-bold text-primary">
                        <i class="fas fa-barcode me-1"></i> 初始副本條碼 (選填)
                    </label>
                    <input type="text" name="barcode" value="{{ old('barcode') }}" class="form-control border-primary" placeholder="請輸入條碼，系統將自動建立一本「在架上」的庫存">
                    <div class="form-text text-muted">若您手邊已有第一本書，請輸入條碼；若留空則只會建立書目資料。</div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-check me-1"></i> 儲存並新增
                    </button>
                    <a class="btn btn-outline-secondary" href="{{ route('staff.books.index') }}">取消</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection