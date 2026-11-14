@extends('layouts.app')
@section('title', 'Edytuj produkt')

@section('content')
<a href="{{ route('products.index') }}" class="back">← Lista produktów</a>
<div class="form-card wide">
    <h1>Edytuj produkt #{{ $product->id }}</h1>
    <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('products._form')
        <button type="submit" class="btn">Zapisz zmiany</button>
    </form>
</div>
@endsection