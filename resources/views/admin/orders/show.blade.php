@extends('layouts.app')
@section('title', 'Zamówienie #' . $order->id)

@section('content')
<a href="{{ route('admin.orders.index') }}" class="back">← Wszystkie zamówienia</a>

<div class="toolbar">
    <h1>Zamówienie #{{ $order->id }}</h1>
    @if ($order->status !== 'anulowane')
        <div class="actions">
            <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-outline">Edytuj</a>
            <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" class="inline"
                  onsubmit="return confirm('Anulować to zamówienie? Towar wróci do magazynu.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Anuluj zamówienie</button>
            </form>
        </div>
    @endif
</div>

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
<div class="summary"><p class="total">Suma: {{ number_format($order->total, 2, ',', ' ') }} zł</p></div>

<div class="tiles" style="margin-top:30px">
    <div class="tile">
        <h3>Klient</h3>
        <p>{{ $order->user?->name }}<br>{{ $order->user?->email }}</p>
    </div>
    <div class="tile">
        <h3>Dane do wysyłki</h3>
        <p>
            {{ $order->shipping_name }}, tel. {{ $order->shipping_phone }}<br>
            @if ($order->shipping_city)
                {{ $order->shipping_street ? $order->shipping_street . ' ' : '' }}{{ $order->shipping_house_number }}<br>
                {{ $order->shipping_postcode }} {{ $order->shipping_city }}
            @else
                {{ $order->shipping_address }}
            @endif
        </p>
    </div>
</div>
@endsection