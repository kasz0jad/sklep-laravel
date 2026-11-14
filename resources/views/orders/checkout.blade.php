@extends('layouts.app')
@section('title', 'Zamówienie')

@section('content')
<a href="{{ route('cart.index') }}" class="back">← Wróć do koszyka</a>
<h1>Zamówienie</h1>

<div class="table-wrap">
    <table class="table">
        <tr><th>Produkt</th><th>Ilość</th><th>Razem</th></tr>
        @foreach ($items as $item)
            <tr>
                <td>{{ $item['product']->name }}</td>
                <td>{{ $item['quantity'] }}</td>
                <td>{{ number_format($item['subtotal'], 2, ',', ' ') }} zł</td>
            </tr>
        @endforeach
    </table>
</div>
<div class="summary"><p class="total">Suma: {{ number_format($total, 2, ',', ' ') }} zł</p></div>

<div class="form-card" style="margin-top:30px">
    <h2>Dane do wysyłki</h2>
    <form method="POST" action="{{ route('orders.store') }}">
        @csrf
        <div class="field">
            <label>Imię i nazwisko</label>
            <input type="text" name="shipping_name" value="{{ old('shipping_name', auth()->user()?->name) }}">
        </div>
        <div class="field">
            <label>Telefon (9 cyfr)</label>
            <input type="text" name="shipping_phone" value="{{ old('shipping_phone', auth()->user()?->phone) }}">
        </div>
        <div class="field">
            <label>Adres dostawy</label>
            <input type="text" name="shipping_address" value="{{ old('shipping_address') }}">
        </div>

        @guest
            <div class="alert alert-error">Aby złożyć zamówienie, zaloguj się lub utwórz konto.</div>
            <div class="actions">
                <a href="{{ route('login') }}" class="btn">Zaloguj się</a>
                <a href="{{ route('register') }}" class="btn btn-outline">Utwórz konto</a>
            </div>
        @else
            @if (auth()->user()->role === 'klient')
                <button type="submit" class="btn btn-block">Złóż zamówienie</button>
            @else
                <p class="muted">Konta moderatora i administratora nie składają zamówień.</p>
            @endif
        @endguest
    </form>
</div>
@endsection