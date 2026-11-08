<!DOCTYPE html>
<html lang="pl">
<head><meta charset="UTF-8"><title>Koszyk</title></head>
<body>
    <h1>Koszyk</h1>
    <p><a href="{{ route('shop') }}">← Produkty</a></p>

    @if ($errors->any())
        <p style="color:red">{{ $errors->first() }}</p>
    @endif

    @if ($items->isEmpty())
        <p>Koszyk jest pusty.</p>
    @else
        <table border="1" cellpadding="6">
            <tr><th>Produkt</th><th>Cena</th><th>Ilość</th><th>Razem</th><th></th></tr>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item['product']->name }}</td>
                    <td>{{ number_format($item['product']->price, 2, ',', ' ') }} zł</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>{{ number_format($item['subtotal'], 2, ',', ' ') }} zł</td>
                    <td>
                        <form method="POST" action="{{ route('cart.remove', $item['product']) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Usuń</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
        <p><strong>Suma: {{ number_format($total, 2, ',', ' ') }} zł</strong></p>

        <form method="POST" action="{{ route('orders.store') }}">
            @csrf
            <button type="submit">Złóż zamówienie</button>
        </form>
    @endif
</body>
</html>