@extends('layouts.app')

@section('title', '登入')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h3>登入</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus />
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">密碼</label>
                            <input type="password" id="password" name="password" class="form-control" required />
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" id="remember" name="remember" class="form-check-input">
                                <label for="remember" class="form-check-label">記住我</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">登入</button>
                    </form>

                    @if (Route::has('password.request'))
                        <div class="mt-3 text-center">
                            <a href="{{ route('password.request') }}">忘記密碼?</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
