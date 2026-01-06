@extends('layouts.app')

@section('title', '註冊')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h3>註冊</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">姓名</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required autofocus />
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required />
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">密碼</label>
                            <input type="password" id="password" name="password" class="form-control" required />
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">確認密碼</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required />
                        </div>

                        <button type="submit" class="btn btn-primary w-100">註冊</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
