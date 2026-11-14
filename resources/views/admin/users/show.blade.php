@extends('layouts.app')
@section('title', 'Użytkownik')

@section('content')
<a href="{{ route('admin.users.index') }}" class="back">← Lista użytkowników</a>

<div class="form-card">
    <h1>Użytkownik #{{ $user->id }}</h1>
    <p><strong>Imię:</strong> {{ $user->name }}</p>
    <p><strong>E-mail:</strong> {{ $user->email }}</p>
    <p><strong>Telefon:</strong> {{ $user->phone ?: '—' }}</p>
    <p><strong>Rola:</strong> <span class="tag tag-{{ $user->role }}">{{ $user->role }}</span></p>
    <p><strong>Utworzono:</strong> {{ $user->created_at }}</p>

    <div class="actions">
        <a href="{{ route('admin.users.edit', $user) }}" class="btn">Edytuj</a>
    </div>
</div>
@endsection