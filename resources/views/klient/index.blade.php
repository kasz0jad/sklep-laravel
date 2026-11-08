<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Strona klienta</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <h1>Strona klienta</h1>
    <p>Witaj, {{ auth()->user()->name }}!</p>
    <form method="POST" action="/logout">@csrf<button type="submit">Wyloguj</button></form>
    <p><a href="{{ route('shop') }}">Przeglądaj produkty</a></p>
    <p><a href="{{ route('cart.index') }}">Koszyk</a> | <a href="{{ route('orders.index') }}">Moje zamówienia</a></p>
</body>
</html>