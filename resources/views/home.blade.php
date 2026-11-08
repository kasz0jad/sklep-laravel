<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Sklep</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <h1>Sklep</h1>

    @auth
        <p>Zalogowano jako: {{ auth()->user()->name }} (rola: {{ auth()->user()->role }})</p>
        <form method="POST" action="/logout">
            @csrf
            <button type="submit">Wyloguj</button>
        </form>
    @else
        <p><a href="/login">Zaloguj</a> | <a href="/register">Zarejestruj</a></p>
    @endauth
</body>
</html>