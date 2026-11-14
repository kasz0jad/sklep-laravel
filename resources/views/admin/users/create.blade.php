@extends('layouts.app')
@section('title', 'Dodaj użytkownika')

@section('content')
<a href="{{ route('admin.users.index') }}" class="back">← Lista użytkowników</a>

<div class="form-card">
    <h1>Dodaj użytkownika</h1>
    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        @include('admin.users._form')
        <button type="submit" class="btn">Zapisz</button>
    </form>
</div>
@endsection