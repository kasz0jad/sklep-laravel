@extends('layouts.app')
@section('title', 'Koszyk')

@section('content')
<h1>Koszyk</h1>

@if ($items->isEmpty())
    <div class="empty">
        <p>Twój koszyk jest pusty.</p>
        <a href="{{ route('shop') }}" class="btn">Wróć do sklepu</a>
    </div>
@else
    <div class="table-wrap">
        <table class="table">
            <tr><th></th><th>Produkt</th><th>Cena</th><th>Ilość</th><th>Razem</th><th></th></tr>
            @foreach ($items as $item)
                <tr>
                    <td>
                        @if ($item['product']->image)
                            <img class="thumb" src="{{ asset('storage/' . $item['product']->image) }}" alt="">
                        @endif
                    </td>
                    <td>{{ $item['product']->name }}</td>
                    <td>{{ number_format($item['product']->price, 2, ',', ' ') }} zł</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>{{ number_format($item['subtotal'], 2, ',', ' ') }} zł</td>
                    <td>
                        <form method="POST" action="{{ route('cart.remove', $item['product']) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Usuń</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <div class="summary">
        <p class="total">Suma: {{ number_format($total, 2, ',', ' ') }} zł</p>
        <a href="{{ route('checkout') }}" class="btn btn-block">Przejdź do zamówienia</a>
    </div>
@endif
@endsection