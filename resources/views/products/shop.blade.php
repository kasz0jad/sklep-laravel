<!DOCTYPE html>
<html lang="pl">
<head><meta charset="UTF-8"><title>Sklep</title></head>
<body>
    <h1>Produkty</h1>
    <p><a href="/dashboard">← Moja strona</a>
    @if (auth()->user()->role === 'klient')
        | <a href="{{ route('cart.index') }}">Koszyk</a>
    @endif
    </p>

    @if (session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif
    @if ($errors->any())
        <p style="color:red">{{ $errors->first() }}</p>
    @endif

    <table border="1" cellpadding="6">
        <tr><th>Nazwa</th><th>Opis</th><th>Cena</th><th>Dostępne</th><th></th></tr>
        @forelse ($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ number_format($product->price, 2, ',', ' ') }} zł</td>
                <td>{{ $product->stock }}</td>
                <td>
                    @if (auth()->user()->role === 'klient' && $product->stock > 0)
                        <form method="POST" action="{{ route('cart.add', $product) }}">
                            @csrf
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" style="width:60px">
                            <button type="submit">Do koszyka</button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="5">Brak produktów.</td></tr>
        @endforelse
    </table>
</body>
</html>
</html>