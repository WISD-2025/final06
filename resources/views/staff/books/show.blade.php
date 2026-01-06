@extends('layouts.app')

@section('title', $book->title . ' - 管理副本')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">書籍詳情與庫存管理</h1>
    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('staff.books.index') }}">書籍管理</a></li>
        <li class="breadcrumb-item active">{{ $book->title }}</li>
    </ol>

    {{-- 顯示成功訊息 --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- 顯示錯誤訊息 (例如條碼重複) --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        {{-- 左邊：書籍基本資料 --}}
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header fw-bold">
                    <i class="fas fa-book me-1"></i> 書籍資訊
                </div>
                <div class="card-body">
                    <h4 class="card-title">{{ $book->title }}</h4>
                    <p class="card-text text-muted">{{ $book->author }}</p>
                    <hr>
                    <p><strong>ISBN：</strong> {{ $book->isbn ?? '無' }}</p>
                    <p><strong>出版年：</strong> {{ $book->published_year ?? '未知' }}</p>
                    <p><strong>總庫存：</strong> {{ $book->copies->count() }} 本</p>
                    <div class="d-grid mt-3">
                        <a href="{{ route('staff.books.edit', $book->id) }}" class="btn btn-outline-primary">
                            <i class="fas fa-edit"></i> 編輯書目資料
                        </a>
                    </div>
                </div>
            </div>

            {{-- 新增副本區塊 --}}
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white fw-bold">
                    <i class="fas fa-plus-circle me-1"></i> 新增副本 (入庫)
                </div>
                <div class="card-body">
                    <form action="{{ route('staff.books.add_copy', $book->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">新書條碼 (Barcode)</label>
                            <input type="text" name="barcode" class="form-control" placeholder="請掃描或輸入條碼" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">新增庫存</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- 右邊：現有副本列表 --}}
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i> 館藏副本列表
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>條碼 (Barcode)</th>
                                <th>當前狀態</th>
                                <th>建立時間</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($book->copies as $copy)
                                <tr>
                                    <td>{{ $copy->id }}</td>
                                    <td class="fw-bold font-monospace">{{ $copy->barcode }}</td>
                                    <td>
                                        @if($copy->status === 'available')
                                            <span class="badge bg-success">可借閱</span>
                                        @elseif($copy->status === 'loaned')
                                            <span class="badge bg-warning text-dark">出借中</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $copy->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $copy->created_at->format('Y-m-d') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">目前尚無庫存，請從左側新增。</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection