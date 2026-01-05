<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanks</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
</head>

<body>

    <div class="thanks-wrapper">
        <p class="thanks-message">
            お問い合わせありがとうございました
        </p>

        <a href="{{ url('/') }}" class="thanks-home-btn">
            HOME
        </a>
    </div>

</body>

</html>