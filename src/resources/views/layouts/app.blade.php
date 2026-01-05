<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionablyLate</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/">FashionablyLate</a>

            {{-- admin画面ならログアウトボタン --}}
            @if (Request::is('admin*') && Auth::check())
            <form method="POST" action="{{ route('logout') }}" class="header__logout">
                @csrf
                <button type="submit" class="logout-btn">logout</button>
            </form>
            @endif

            {{-- login画面ではRegisterボタン --}}
            @if (Request::is('login') && !Auth::check())
            <a href="{{ url('/register') }}" class="header-btn">register</a>
            @endif

            {{-- register画面ではLoginボタン --}}
            @if (Request::is('register') && !Auth::check())
            <a href="{{ url('/login') }}" class="header-btn">Login</a>
            @endif
        </div>
    </header>



    <main>
        @yield('content')
    </main>
    @yield('js')
</body>

</html>