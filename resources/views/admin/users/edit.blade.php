@extends('layouts.app')
@section('title', 'Edytuj użytkownika')

@section('content')
<a href="{{ route('admin.users.index') }}" class="back">← Lista użytkowników</a>

<div class="form-card">
    <h1>Edytuj użytkownika #{{ $user->id }}</h1>
    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf
        @method('PUT')
        @include('admin.users._form')
        <button type="submit" class="btn">Zapisz zmiany</button>
    </form>
</div>
@endsection