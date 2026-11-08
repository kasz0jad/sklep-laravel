<!DOCTYPE html>
<html lang="pl">
<head><meta charset="UTF-8"><title>Zamówienie</title></head>
<body>
    <h1>Zamówienie #{{ $order->id }}</h1>
    <p><a href="{{ route('orders.index') }}">← Moje zamówienia</a></p>

    @if (session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <p>Data: {{ $order->created_at }} | Status: {{ $order->status }}</p>

    <table border="1" cellpadding="6">
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
    <p><strong>Suma: {{ number_format($order->total, 2, ',', ' ') }} zł</strong></p>
</body>
</html>