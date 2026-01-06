@extends('layouts.app')

@section('title', '歡迎 - 圖書館')

@section('content')
    <div class="container-fluid py-4">
        <h1 class="text-center">歡迎來到圖書館管理系統</h1>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">登入</div>

                    <div class="card-body">
                        <!-- 登入表單 -->
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">電子郵件</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">密碼</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="remember" class="form-check-input">
                                <label class="form-check-label" for="remember">記住我</label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">登入</button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a href="{{ route('register') }}">還沒有帳號？註冊</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
