<!DOCTYPE html>
<html lang="pl">
<head><meta charset="UTF-8"><title>Użytkownicy</title></head>
<body>
    <h1>Użytkownicy</h1>
    <p><a href="{{ route('admin.index') }}">← Panel</a> |
       <a href="{{ route('admin.users.create') }}">Dodaj użytkownika</a></p>

    @if (session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif
    @if ($errors->any())
        <p style="color:red">{{ $errors->first() }}</p>
    @endif

    <table border="1" cellpadding="6">
        <tr><th>ID</th><th>Imię</th><th>E-mail</th><th>Rola</th><th>Akcje</th></tr>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>
                    <a href="{{ route('admin.users.show', $user) }}">Podgląd</a> |
                    <a href="{{ route('admin.users.edit', $user) }}">Edytuj</a> |
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display:inline"
                          onsubmit="return confirm('Usunąć użytkownika?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Usuń</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
</body>
</html>