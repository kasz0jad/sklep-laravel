@extends('layouts.app')
@section('title', 'Dodaj produkt')

@section('content')
<a href="{{ route('products.index') }}" class="back">← Lista produktów</a>
<div class="form-card wide">
    <h1>Dodaj produkt</h1>
    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
        @csrf
        @include('products._form')
        <button type="submit" class="btn">Zapisz produkt</button>
    </form>
</div>
@endsection