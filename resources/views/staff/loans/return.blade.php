@extends('layouts.app')

@section('title', '館員歸還')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">流通櫃台 - 還書作業</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger mt-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card mb-4 mt-3">
        <div class="card-header bg-success text-white">
            <i class="fas fa-undo me-1"></i> 書籍歸還
        </div>
        <div class="card-body">
            <form action="{{ route('staff.loans.return.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="barcode" class="form-label">書籍條碼</label>
                    <div class="input-group">
                        <input type="text" class="form-control form-control-lg" id="barcode" name="barcode" placeholder="請輸入書籍編號" required autofocus>
                        <button class="btn btn-success" type="submit">確認歸還</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection