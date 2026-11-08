<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dodaj produkt</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <h1>Dodaj produkt</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('products.store') }}">
        @csrf
        <p><input type="text" name="name" placeholder="Nazwa" value="{{ old('name') }}"></p>
        <p><textarea name="description" placeholder="Opis">{{ old('description') }}</textarea></p>
        <p><input type="text" name="price" placeholder="Cena (np. 19.99)" value="{{ old('price') }}"></p>
        <p><input type="number" name="stock" placeholder="Ilość" value="{{ old('stock', 0) }}"></p>
        <button type="submit">Zapisz</button>
    </form>
    <p><a href="{{ route('products.index') }}">← Lista</a></p>
</body>
</html>