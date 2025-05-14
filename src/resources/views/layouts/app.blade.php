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
    </header>

    <main>
        <div class="register__alert">
            @if(session('message'))
            <div class="register__alert--success">
                {{session('message')}}
            </div>
            @endif
            @if($errors->any())
            <div class="register__alert--danger">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
        @yield('content')
    </main>

</body>

</html>