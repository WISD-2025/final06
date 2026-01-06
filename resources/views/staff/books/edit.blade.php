@extends('layouts.app')

@section('title', '編輯書籍')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">編輯書籍</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('staff.books.index') }}">書籍管理</a></li>
        <li class="breadcrumb-item active">編輯書籍</li>
    </ol>

    <div class="card mb-4 shadow-sm">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i> 編輯書目資料
        </div>
        
        <div class="card-body">
            {{-- 表單開始：指向 update路由 --}}
            <form action="{{ route('staff.books.update', $book->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- 關鍵：模擬 PUT 請求以觸發 update 方法 --}}

                {{-- 書名 (必填) --}}
                <div class="mb-3">
                    <label for="title" class="form-label">書名 <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('title') is-invalid @enderror" 
                           id="title" 
                           name="title" 
                           value="{{ old('title', $book->title) }}" 
                           required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- 作者 --}}
                <div class="mb-3">
                    <label for="author" class="form-label">作者</label>
                    <input type="text" 
                           class="form-control @error('author') is-invalid @enderror" 
                           id="author" 
                           name="author" 
                           value="{{ old('author', $book->author) }}">
                    @error('author')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    {{-- ISBN --}}
                    <div class="col-md-6 mb-3">
                        <label for="isbn" class="form-label">ISBN</label>
                        <input type="text" 
                               class="form-control @error('isbn') is-invalid @enderror" 
                               id="isbn" 
                               name="isbn" 
                               value="{{ old('isbn', $book->isbn) }}">
                        @error('isbn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- 出版年份 --}}
                    <div class="col-md-6 mb-3">
                        <label for="published_year" class="form-label">出版年份</label>
                        <input type="number" 
                               class="form-control @error('published_year') is-invalid @enderror" 
                               id="published_year" 
                               name="published_year" 
                               value="{{ old('published_year', $book->published_year) }}">
                        @error('published_year')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- 按鈕區 --}}
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> 儲存變更
                    </button>
                    <a href="{{ route('staff.books.index') }}" class="btn btn-secondary">
                        取消
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection