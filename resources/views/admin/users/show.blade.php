<!DOCTYPE html>
<html lang="pl">
<head><meta charset="UTF-8"><title>Użytkownik</title></head>
<body>
    <h1>Użytkownik #{{ $user->id }}</h1>
    <p>Imię: {{ $user->name }}</p>
    <p>E-mail: {{ $user->email }}</p>
    <p>Telefon: {{ $user->phone }}</p>
    <p>Rola: {{ $user->role }}</p>
    <p>Utworzono: {{ $user->created_at }}</p>
    <p><a href="{{ route('admin.users.index') }}">← Lista</a></p>
</body>
</html>