@extends('layouts.app')
@section('title', 'Użytkownicy')

@section('content')
<a href="{{ route('admin.index') }}" class="back">← Panel</a>

<div class="toolbar">
    <h1>Użytkownicy</h1>
    <a href="{{ route('admin.users.create') }}" class="btn">Dodaj użytkownika</a>
</div>

<div class="table-wrap">
    <table class="table">
        <tr><th>ID</th><th>Imię</th><th>E-mail</th><th>Telefon</th><th>Rola</th><th>Akcje</th></tr>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td><span class="tag tag-{{ $user->role }}">{{ $user->role }}</span></td>
                <td>
                    <div class="actions">
                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline btn-sm">Podgląd</a>
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline btn-sm">Edytuj</a>
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline"
                              onsubmit="return confirm('Usunąć użytkownika?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Usuń</button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </table>
</div>
@endsection