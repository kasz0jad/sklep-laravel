@extends('layouts.app')
@section('title', 'Panel administratora')

@section('content')
<h1>Panel administratora</h1>
<p class="muted">Witaj, {{ auth()->user()->name }}!</p>

<div class="tiles">
    <a href="{{ route('admin.users.index') }}" class="tile">
        <h3>Użytkownicy</h3>
        <p>Dodawanie, edycja i usuwanie kont</p>
    </a>
    <a href="{{ route('products.index') }}" class="tile">
        <h3>Produkty</h3>
        <p>Zarządzanie asortymentem</p>
    </a>
    <a href="{{ route('shop') }}" class="tile">
        <h3>Sklep</h3>
        <p>Podgląd strony dla klientów</p>
    </a>
</div>
@endsection