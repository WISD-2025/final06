@extends('layouts.app')

@section('title', '借出中清單')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">借出中書籍清單</h1>
    
    <div class="card mb-4 mt-3">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            目前外借中 (未歸還)
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>借閱人 (Email)</th>
                        <th>條碼</th>
                        <th>書名</th>
                        <th>借出日期</th>
                        <th>應還日期</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loans as $loan)
                        <tr>
                            <td>{{ $loan->user->email ?? '未知使用者' }}</td>
                            <td>{{ $loan->copy->barcode ?? '-' }}</td>
                            <td>{{ $loan->copy->book->title ?? '未知書名' }}</td>
                            <td>{{ $loan->loan_date }}</td>
                            {{-- 判斷是否逾期，逾期顯示紅色 --}}
                            <td class="{{ \Carbon\Carbon::parse($loan->due_date)->isPast() ? 'text-danger fw-bold' : '' }}">
                                {{ $loan->due_date }}
                                @if(\Carbon\Carbon::parse($loan->due_date)->isPast())
                                    (逾期)
                                @endif
                            </td>
                            <td>
                                {{-- 這裡可以放快速還書按鈕，或只是顯示狀態 --}}
                                <span class="badge bg-warning text-dark">借出中</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">目前沒有外借中的書籍。</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection