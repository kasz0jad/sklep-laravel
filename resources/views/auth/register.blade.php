<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Rejestracja</title>
</head>
<body>
    <h1>Rejestracja</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="/register">
        @csrf
        <p><input type="text" name="name" placeholder="Imię" value="{{ old('name') }}"></p>
        <p><input type="email" name="email" placeholder="E-mail" value="{{ old('email') }}"></p>
        <p><input type="text" name="phone" placeholder="Telefon (9 cyfr)" value="{{ old('phone') }}"></p>
        <p><input type="password" name="password" placeholder="Hasło"></p>
        <p><input type="password" name="password_confirmation" placeholder="Powtórz hasło"></p>
        <button type="submit">Zarejestruj</button>
    </form>
</body>
</html>