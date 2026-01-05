@extends('layouts.app')

@section('title', $book->title)

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">書籍詳情</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('books.index') }}">圖書查詢</a></li>
        <li class="breadcrumb-item active">詳細資訊</li>
    </ol>

    <div class="row">
        <div class="col-xl-4 col-md-12">
            <div class="card mb-4 shadow-sm border-0 border-top border-primary border-3">
                <div class="card-body">
                    <h2 class="card-title text-primary fw-bold mb-3">{{ $book->title }}</h2>
                    <p class="card-text fs-5 mb-1"><i class="fas fa-user-edit me-2 text-muted"></i>{{ $book->author }}</p>
                    <p class="card-text text-muted"><i class="fas fa-barcode me-2"></i>{{ $book->isbn }}</p>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold">目前館藏狀態：</span>
                        @if($availableCount > 0)
                            <span class="badge bg-success fs-6 rounded-pill">可借閱 ({{ $availableCount }} 本)</span>
                        @else
                            <span class="badge bg-danger fs-6 rounded-pill">已借光</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-md-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light fw-bold">
                    <i class="fas fa-table me-1"></i> 館藏副本列表
                </div>
                <div class="card-body">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>條碼 (Barcode)</th>
                                <th>狀態</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($book->bookCopies as $copy)
                            <tr>
                                <td class="font-monospace">{{ $copy->barcode }}</td>
                                <td>
                                    @if($copy->status === 'available')
                                        <span class="badge bg-success">在架上</span>
                                    @elseif($copy->status === 'loaned')
                                        <span class="badge bg-warning text-dark">借出中</span>
                                    @elseif($copy->status === 'maintenance')
                                        <span class="badge bg-secondary">維護中</span>
                                    @else
                                        <span class="badge bg-danger">遺失/損壞</span>
                                    @endif
                                </td>
                                <td>
                                    @auth
                                        @if(auth()->user()->role === 'librarian')
                                            <button class="btn btn-sm btn-outline-secondary" disabled>編輯狀態</button>
                                        @else
                                            <span class="text-muted text-sm">-</span>
                                        @endif
                                    @else
                                        <span class="text-muted text-sm">-</span>
                                    @endauth
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection