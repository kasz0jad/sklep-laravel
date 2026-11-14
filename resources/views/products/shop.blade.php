@extends('layouts.app')
@section('title', $category ?: 'Sklep')

@section('content')
@php $canBuy = ! auth()->check() || auth()->user()->role === 'klient'; @endphp

@if ($category === '' && $search === '')
    <section class="hero">
        <h1>NOWA KOLEKCJA</h1>
        <p>Odkryj najnowsze produkty w LUMA.</p>
    </section>
@endif

<h1>
    @if ($search !== '') Wyniki dla „{{ $search }}"
    @elseif ($category !== '') {{ $category }}
    @else Wszystkie produkty
    @endif
</h1>

@if ($products->isEmpty())
    <div class="empty">Brak produktów do wyświetlenia.</div>
@else
    <div class="grid">
        @foreach ($products as $product)
            <article class="card">
                <div class="card-img">
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    @else
                        <div class="no-img">Brak zdjęcia</div>
                    @endif
                </div>
                <div class="card-body">
                    <span class="card-cat">{{ $product->category }}</span>
                    <h3>{{ $product->name }}</h3>
                    <p class="price">{{ number_format($product->price, 2, ',', ' ') }} zł</p>

                    @if ($product->stock <= 0)
                        <span class="soldout">Wyprzedane</span>
                    @elseif ($canBuy)
                        <form method="POST" action="{{ route('cart.add', $product) }}" class="add-form">
                            @csrf
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}">
                            <button type="submit" class="btn btn-sm">Do koszyka</button>
                        </form>
                    @endif
                </div>
            </article>
        @endforeach
    </div>
@endif
@endsection