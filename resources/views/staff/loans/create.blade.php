@extends('layouts.app')

@section('title', '館員借出')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">流通櫃台 - 借書作業</h1>
    
    {{-- 錯誤訊息顯示區 --}}
    @if($errors->any())
        <div class="alert alert-danger mt-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 成功訊息 --}}
    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">新增借閱紀錄</div>

                <div class="card-body">
                    {{-- ★★★ 1. 顯示錯誤訊息 (這段很重要) ★★★ --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- ★★★ 2. 顯示成功訊息 ★★★ --}}
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('staff.loans.store') }}">
                        @csrf

                        {{-- 讀者 Email --}}
                        <div class="mb-3">
                            <label for="member_email" class="form-label">讀者 Email</label>
                            {{-- ★ 重點：name 必須是 member_email，對應 Controller --}}
                            <input type="email" 
                                   class="form-control" 
                                   id="member_email" 
                                   name="member_email" 
                                   value="{{ old('member_email') }}" 
                                   required 
                                   placeholder="請輸入讀者信箱">
                        </div>

                        {{-- 書籍條碼 --}}
                        <div class="mb-3">
                            <label for="barcode" class="form-label">書籍條碼 (Barcode)</label>
                            {{-- ★ 重點：name 必須是 barcode --}}
                            <input type="text" 
                                    class="form-control" 
                                    id="barcode" 
                                    name="barcode" 
                                    value="{{ old('barcode') }}" 
                                    required 
                                    placeholder="請掃描或輸入書籍條碼">
                        </div>

                        {{-- 借閱天數 (選填) --}}
                        <div class="mb-3">
                            <label for="days" class="form-label">借閱天數 (預設 14 天)</label>
                            <input type="number" 
                                    class="form-control" 
                                    id="days" 
                                    name="days" 
                                    value="{{ old('days', 14) }}" 
                                    min="1" 
                                    max="60">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                確認借出
                            </button>
                            <a href="{{ route('staff.loans.index') }}" class="btn btn-outline-secondary">
                                返回列表
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection