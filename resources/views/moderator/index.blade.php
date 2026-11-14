@extends('layouts.app')
@section('title', 'Panel moderatora')

@section('content')
<h1>Panel moderatora</h1>
<p class="muted">Witaj, {{ auth()->user()->name }}!</p>

<div class="tiles">
    <a href="{{ route('products.index') }}" class="tile">
        <h3>Produkty</h3>
        <p>Dodawanie, edycja i usuwanie produktów</p>
    </a>
    <a href="{{ route('products.create') }}" class="tile">
        <h3>Nowy produkt</h3>
        <p>Dodaj produkt ze zdjęciem</p>
    </a>
    <a href="{{ route('shop') }}" class="tile">
        <h3>Sklep</h3>
        <p>Podgląd strony dla klientów</p>
    </a>
</div>
@endsection