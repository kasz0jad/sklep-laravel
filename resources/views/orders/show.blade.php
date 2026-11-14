@extends('layouts.app')
@section('title', 'Zamówienie #' . $order->id)

@section('content')
<a href="{{ route('orders.index') }}" class="back">← Moje zamówienia</a>

<h1>Zamówienie #{{ $order->id }}</h1>
<p class="muted">
    {{ $order->created_at }} · Status: <span class="tag tag-{{ \Illuminate\Support\Str::slug($order->status) }}">{{ $order->status }}</span>
</p>

<div class="table-wrap">
    <table class="table">
        <tr><th>Produkt</th><th>Cena</th><th>Ilość</th><th>Razem</th></tr>
        @foreach ($order->items as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td>{{ number_format($item->price, 2, ',', ' ') }} zł</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price * $item->quantity, 2, ',', ' ') }} zł</td>
            </tr>
        @endforeach
    </table>
</div>

<div class="summary">
    <p class="total">Suma: {{ number_format($order->total, 2, ',', ' ') }} zł</p>
</div>

@if ($order->shipping_name)
    <div class="form-card" style="margin-top:30px">
        <h2>Dane do wysyłki</h2>
        <p>{{ $order->shipping_name }}, tel. {{ $order->shipping_phone }}</p>
        @if ($order->shipping_city)
            <p>
                {{ $order->shipping_street ? $order->shipping_street . ' ' : '' }}{{ $order->shipping_house_number }}<br>
                {{ $order->shipping_postcode }} {{ $order->shipping_city }}
            </p>
        @else
            <p>{{ $order->shipping_address }}</p>
        @endif
    </div>
@endif
@endsection