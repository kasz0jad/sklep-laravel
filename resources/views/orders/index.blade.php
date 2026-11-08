<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Moje zamówienia</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <h1>Moje zamówienia</h1>
    <p><a href="/dashboard">← Moja strona</a></p>

    <table border="1" cellpadding="6">
        <tr><th>Nr</th><th>Data</th><th>Suma</th><th>Status</th><th></th></tr>
        @forelse ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->created_at }}</td>
                <td>{{ number_format($order->total, 2, ',', ' ') }} zł</td>
                <td>{{ $order->status }}</td>
                <td><a href="{{ route('orders.show', $order) }}">Szczegóły</a></td>
            </tr>
        @empty
            <tr><td colspan="5">Brak zamówień.</td></tr>
        @endforelse
    </table>
</body>
</html>