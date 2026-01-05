@extends('layouts.app')

@section('title', '我的借閱')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">我的借閱紀錄</h1>

    <div class="card mb-4 mt-3">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>書名</th>
                        <th>借閱日期</th>
                        <th>應還日期</th>
                        <th>歸還日期</th>
                        <th>狀態</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loans as $loan)
                        <tr>
                            <td>
                                {{-- ★★★ 修正點：嘗試多種路徑抓取書名，確保不顯示未知 ★★★ --}}
                                <span class="fw-bold">
                                    {{ $loan->copy->title->title ?? $loan->copy->book->title ?? '未知書名' }}
                                </span>
                                <br>
                                <small class="text-muted">{{ $loan->copy->barcode ?? '' }}</small>
                            </td>
                            {{-- ★★★ 優化點：加上 format('Y-m-d') 讓日期更乾淨 ★★★ --}}
                            <td>{{ $loan->loan_date->format('Y-m-d') }}</td>
                            <td>{{ $loan->due_date->format('Y-m-d') }}</td>
                            <td>
                                {{ $loan->return_date ? $loan->return_date->format('Y-m-d') : '-' }}
                            </td>
                            <td>
                                @if($loan->return_date)
                                    <span class="badge bg-secondary">已歸還</span>
                                @elseif($loan->due_date->isPast())
                                    <span class="badge bg-danger">逾期</span>
                                @else
                                    <span class="badge bg-primary">借閱中</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                您目前沒有借閱紀錄。
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection