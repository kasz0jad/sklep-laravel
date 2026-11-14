@extends('layouts.app')
@section('title', 'Zarządzanie produktami')

@section('content')
<div class="toolbar">
    <h1>Zarządzanie produktami</h1>
    <a href="{{ route('products.create') }}" class="btn">Dodaj produkt</a>
</div>

<div class="table-wrap">
    <table class="table">
        <tr><th></th><th>ID</th><th>Nazwa</th><th>Kategoria</th><th>Cena</th><th>Ilość</th><th>Akcje</th></tr>
        @forelse ($products as $product)
            <tr>
                <td>
                    @if ($product->image)
                        <img class="thumb" src="{{ asset('storage/' . $product->image) }}" alt="">
                    @endif
                </td>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category }}</td>
                <td>{{ number_format($product->price, 2, ',', ' ') }} zł</td>
                <td>{{ $product->stock }}</td>
                <td>
                    <div class="actions">
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-outline btn-sm">Edytuj</a>
                        <form method="POST" action="{{ route('products.destroy', $product) }}" class="inline"
                              onsubmit="return confirm('Usunąć produkt?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Usuń</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="7">Brak produktów.</td></tr>
        @endforelse
    </table>
</div>
@endsection