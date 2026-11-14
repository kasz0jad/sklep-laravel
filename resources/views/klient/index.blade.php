@extends('layouts.app')
@section('title', 'Moje konto')

@section('content')
<h1>Witaj, {{ auth()->user()->name }}!</h1>
<p class="muted">Co chcesz dziś zrobić?</p>

<div class="tiles">
    <a href="{{ route('shop') }}" class="tile">
        <h3>Sklep</h3>
        <p>Przeglądaj produkty</p>
    </a>
    <a href="{{ route('cart.index') }}" class="tile">
        <h3>Koszyk</h3>
        <p>Pozycje w koszyku: {{ array_sum(session('cart', [])) }}</p>
    </a>
    <a href="{{ route('orders.index') }}" class="tile">
        <h3>Moje zamówienia</h3>
        <p>Historia zamówień</p>
    </a>
    <a href="{{ route('profile.edit') }}" class="tile">
        <h3>Moje dane</h3>
        <p>Zmień imię, e-mail, telefon lub hasło</p>
    </a>
</div>
@endsection