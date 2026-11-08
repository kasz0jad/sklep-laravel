<!DOCTYPE html>
<html lang="pl">
<head><meta charset="UTF-8"><title>Sklep</title></head>
<body>
    <h1>Produkty</h1>
    <p><a href="/dashboard">← Moja strona</a></p>

    <table border="1" cellpadding="6">
        <tr><th>Nazwa</th><th>Opis</th><th>Cena</th><th>Dostępne</th></tr>
        @forelse ($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ number_format($product->price, 2, ',', ' ') }} zł</td>
                <td>{{ $product->stock }}</td>
            </tr>
        @empty
            <tr><td colspan="4">Brak produktów.</td></tr>
        @endforelse
    </table>
</body>
</html>