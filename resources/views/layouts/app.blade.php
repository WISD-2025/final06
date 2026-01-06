<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title') - 圖書館</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="{{ url('/') }}">📚  Library</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        
        <ul class="navbar-nav ms-auto me-3 me-lg-4">
            @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user fa-fw"></i> {{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger" type="submit">登出</button>
                            </form>
                        </li>
                    </ul>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">登入</a>
                </li>
            @endauth
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">公共服務</div>
                        <a class="nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}" href="{{ route('books.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-search"></i></div>
                            圖書查詢
                        </a>

                        @auth
                            {{-- 讀者專區 --}}
                            @if(auth()->user()->role === 'member')
                                <div class="sb-sidenav-menu-heading">讀者中心</div>
                                <a class="nav-link {{ request()->routeIs('my.loans') ? 'active' : '' }}" href="{{ url('/my/loans') }}">
                                    <div class="sb-nav-link-icon"><i class="fas fa-book-reader"></i></div>
                                    我的借閱紀錄
                                </a>
                            @endif

                            {{-- 工作人員專區 (Admin 或 Librarian) --}}
                            @if(auth()->user()->role === 'librarian' || auth()->user()->role === 'admin')
                                <div class="sb-sidenav-menu-heading">館務管理</div>
                                
                                {{-- ★★★ Admin 專屬：書籍管理 ★★★ --}}
                                @if(auth()->user()->role === 'admin')
                                    <a class="nav-link {{ request()->routeIs('staff.books.*') ? 'active' : '' }}" href="{{ route('staff.books.index') }}">
                                        <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                                        書籍管理
                                    </a>
                                @endif

                                {{-- ★★★ Librarian 專屬：流通櫃台 ★★★ --}}
                                @if(auth()->user()->role === 'librarian')
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseStaff" aria-expanded="false" aria-controls="collapseStaff">
                                        <div class="sb-nav-link-icon"><i class="fas fa-id-card"></i></div>
                                        流通櫃台
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    
                                    <div class="collapse {{ request()->routeIs('staff.loans.*') ? 'show' : '' }}" id="collapseStaff" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link {{ request()->routeIs('staff.loans.create') ? 'active' : '' }}" href="{{ route('staff.loans.create') }}">
                                                辦理借書
                                            </a>
                                            
                                            <a class="nav-link {{ request()->routeIs('staff.loans.return.form') ? 'active' : '' }}" href="{{ route('staff.loans.return.form') }}">
                                                辦理還書
                                            </a>

                                            <a class="nav-link {{ request()->routeIs('staff.loans.index') ? 'active' : '' }}" href="{{ route('staff.loans.index') }}">
                                                借閱紀錄總覽
                                            </a>
                                        </nav>
                                    </div>
                                @endif
                            @endif
                        @endauth
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">登入身分：</div>
                    {{ auth()->check() ? auth()->user()->role : '訪客' }}
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                @yield('content')
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Final06 Library 2026</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>