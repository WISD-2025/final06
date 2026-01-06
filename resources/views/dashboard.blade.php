@extends('layouts.app')

@section('title', '儀表板 - 圖書館')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">歡迎，{{ auth()->user()->name }}！</h1>

        <div class="row">
            <div class="col-md-12">
                @if(auth()->user()->role === 'admin')
                    <div class="alert alert-info">
                        您是管理員，您可以管理圖書館系統中的所有功能！
                    </div>
                    <a href="{{ route('staff.books.index') }}" class="btn btn-primary">管理書籍</a>
                @elseif(auth()->user()->role === 'librarian')
                    <div class="alert alert-info">
                        您是圖書館員，您可以管理借閱紀錄。
                    </div>
                @elseif(auth()->user()->role === 'member')
                    <div class="alert alert-success">
                        您是讀者，您可以查看您的借閱紀錄。
                    </div>
                    <a href="{{ route('my.loans.index') }}" class="btn btn-success">查看我的借閱紀錄</a>
                @endif
            </div>
        </div>
    </div>
@endsection
