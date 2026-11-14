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
            <label>Ulica (opcjonalnie)</label>
            <input type="text" name="shipping_street" value="{{ old('shipping_street') }}">
        </div>
        <div class="field">
            <label>Numer domu / mieszkania *</label>
            <input type="text" name="shipping_house_number" placeholder="np. 12, 12A, 12/4" value="{{ old('shipping_house_number') }}">
        </div>
        <div class="field">
            <label>Kod pocztowy *</label>
            <input type="text" name="shipping_postcode" id="postcode" placeholder="00-000" maxlength="6" inputmode="numeric" value="{{ old('shipping_postcode') }}">
        </div>
        <div class="field">
            <label>Miejscowość *</label>
            <input type="text" name="shipping_city" value="{{ old('shipping_city') }}">
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

@push('scripts')
<script>
document.getElementById('postcode').addEventListener('input', function () {
    let v = this.value.replace(/\D/g, '').slice(0, 5);
    if (v.length > 2) v = v.slice(0, 2) + '-' + v.slice(2);
    this.value = v;
});
</script>
@endpush

@endsection