<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>ログアウト</title>
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/logout.css') }}"> {{-- 新規追加 --}}
</head>

<body>
    <main class="logout-page">
        <h1>ログアウトしました</h1>
        <p>またログインする場合は下のボタンからどうぞ。</p>
        <a href="{{ url('/login') }}">
            <button class="login-btn">ログインはこちら</button>
        </a>
    </main>
</body>

</html>