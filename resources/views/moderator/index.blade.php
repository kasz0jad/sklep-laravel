<!DOCTYPE html>
<html lang="pl">
<head><meta charset="UTF-8"><title>Panel moderatora</title></head>
<body>
    <h1>Panel moderatora</h1>
    <p>Witaj, {{ auth()->user()->name }}! Tu będzie zarządzanie produktami.</p>
    <p><a href="{{ route('products.index') }}">Zarządzanie produktami</a></p>
    <form method="POST" action="/logout">@csrf<button type="submit">Wyloguj</button></form>
</body>
</html>