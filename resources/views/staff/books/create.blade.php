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

                {{-- 基本資料 --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">書名 <span class="text-danger">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">作者</label>
                    <input type="text" name="author" value="{{ old('author') }}" class="form-control">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">ISBN</label>
                        <input type="text" name="isbn" value="{{ old('isbn') }}" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">出版年</label>
                        <input type="number" name="published_year" value="{{ old('published_year') }}" class="form-control" min="0" max="3000">
                    </div>
                </div>

                <hr class="my-4">

                {{-- ★★★ 新增：初始副本設定 (起始條碼 + 數量) ★★★ --}}
                <div class="p-3 bg-light border rounded mb-3">
                    <h6 class="fw-bold text-primary mb-3">
                        <i class="fas fa-barcode me-1"></i> 初始庫存設定 (選填)
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-bold">起始條碼</label>
                            <input type="text" name="start_barcode" value="{{ old('start_barcode') }}" class="form-control border-primary" placeholder="例如：LIB-2026-001">
                            <div class="form-text text-muted">若輸入文字結尾是數字，系統將會自動遞增 (如 A-01, A-02...)</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">新增數量</label>
                            <input type="number" name="copy_quantity" value="{{ old('copy_quantity', 1) }}" class="form-control border-primary" min="1" max="50">
                        </div>
                    </div>
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