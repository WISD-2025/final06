<!doctype html>
<html lang="zh-Hant">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Library')</title>

    {{-- 使用 Vite 載入 Tailwind/JS（沿用專案既有前端資源） --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900">
    {{-- ===== 上方導覽列：提供前台入口 & 登入狀態 ===== --}}
    <nav class="bg-white border-b">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="font-semibold">final06</a>
                <a href="{{ route('books.index') }}" class="text-sm hover:underline">Books</a>
            </div>

            <div class="text-sm">
                @auth
                    <span class="mr-3">Hi, {{ auth()->user()->name }}</span>
                    <a class="hover:underline mr-3" href="{{ route('dashboard') }}">Dashboard</a>

                    {{-- 登出（POST） --}}
                    <form class="inline" method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="hover:underline" type="submit">Logout</button>
                    </form>
                @else
                    <a class="hover:underline mr-3" href="{{ route('login') }}">Login</a>
                    <a class="hover:underline" href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-4 py-6">
        @yield('content')
    </main>
</body>
</html>
