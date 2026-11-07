<!DOCTYPE html>
<html lang="pl">
<head><meta charset="UTF-8"><title>Strona klienta</title></head>
<body>
    <h1>Strona klienta</h1>
    <p>Witaj, {{ auth()->user()->name }}!</p>
    <form method="POST" action="/logout">@csrf<button type="submit">Wyloguj</button></form>
</body>
</html>