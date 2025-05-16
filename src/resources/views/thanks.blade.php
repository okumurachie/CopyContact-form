<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionablyLate</title>
    <link href="https://fonts.googleapis.com/css2?family=Inika:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
</head>

<body>
    <div class="thanks-content_box">
        <div class="background-text">Thank you</div>
        <div class="thanks-content">
            <h2 class="thank-you">お問い合わせありがとうございました</h2>
            <a href="{{route('contact.form')}}" class="back-home">HOME</a>
        </div>
    </div>
</body>

</html>