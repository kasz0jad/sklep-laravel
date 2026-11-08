<!DOCTYPE html>
<html lang="pl">
<head><meta charset="UTF-8"><title>Panel administratora</title></head>
<body>
    <h1>Panel administratora</h1>
    <p>Witaj, {{ auth()->user()->name }}!</p>
    <p><a href="{{ route('admin.users.index') }}">Zarządzanie użytkownikami</a></p>
    <p><a href="{{ route('products.index') }}">Zarządzanie produktami</a></p>
    <form method="POST" action="/logout">@csrf<button type="submit">Wyloguj</button></form>
</body>
</html>