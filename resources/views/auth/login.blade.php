<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <h1>Logowanie</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="/login">
        @csrf
        <p><input type="email" name="email" placeholder="E-mail" value="{{ old('email') }}"></p>
        <p><input type="password" name="password" placeholder="Hasło"></p>
        <button type="submit">Zaloguj</button>
    </form>

    <p><a href="/register">Nie masz konta? Zarejestruj się</a></p>
</body>
</html>