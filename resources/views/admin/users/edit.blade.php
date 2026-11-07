<!DOCTYPE html>
<html lang="pl">
<head><meta charset="UTF-8"><title>Edytuj użytkownika</title></head>
<body>
    <h1>Edytuj użytkownika #{{ $user->id }}</h1>
    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PUT')
        @include('admin.users._form')
        <button type="submit">Zapisz zmiany</button>
    </form>
    <p><a href="{{ route('admin.users.index') }}">← Lista</a></p>
</body>
</html>