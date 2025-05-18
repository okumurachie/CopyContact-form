<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionablyLate</title>
    <link href="https://fonts.googleapis.com/css2?family=Inika:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header-utilities">
                <h2 class="header__logo">
                    FashionablyLate
                </h2>
            </div>
        </div>
        <nav>
            <ul class="header-nav">
                @if (Auth::check())
                <li class="header-nav__item">
                    <form class="form" action="/logout" method="post">
                        @csrf
                        <button class="header-nav__button">logout</button>
                    </form>
                </li>
                @else
                <li class="header-nav__item">
                    <a class="header-nav__link" href="/login">login</a>
                </li>
                <li class="header-nav__item">
                    <a class="header-nav__link" href="/register">register</a>
                </li>
                @endif
            </ul>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>
    <footer class="footer">
        <div class="footer__inner">
            @if (!Auth::check())
            <div class="footer-nav__item">
                <a href="/admin" class="footer-nav__link">管理者フォームはこちら</a>
            </div>
            @endif
        </div>
    </footer>
</body>

</html>