<!DOCTYPE html>
<html lang="pl">
<head><meta charset="UTF-8"><title>Dodaj użytkownika</title></head>
<body>
    <h1>Dodaj użytkownika</h1>
    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        @include('admin.users._form')
        <button type="submit">Zapisz</button>
    </form>
    <p><a href="{{ route('admin.users.index') }}">← Lista</a></p>
</body>
</html>