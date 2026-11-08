<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Zarządzanie produktami</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <h1>Zarządzanie produktami</h1>
    <p><a href="/dashboard">← Panel</a> | <a href="{{ route('products.create') }}">Dodaj produkt</a></p>

    @if (session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="6">
        <tr><th>ID</th><th>Nazwa</th><th>Cena</th><th>Ilość</th><th>Akcje</th></tr>
        @forelse ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ number_format($product->price, 2, ',', ' ') }} zł</td>
                <td>{{ $product->stock }}</td>
                <td>
                    <form method="POST" action="{{ route('products.destroy', $product) }}"
                          onsubmit="return confirm('Usunąć produkt?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Usuń</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">Brak produktów.</td></tr>
        @endforelse
    </table>
</body>
</html>