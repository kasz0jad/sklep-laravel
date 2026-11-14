@extends('layouts.app')
@section('title', 'Moje zamówienia')

@section('content')
<h1>Moje zamówienia</h1>

@if ($orders->isEmpty())
    <div class="empty">
        <p>Nie masz jeszcze żadnych zamówień.</p>
        <a href="{{ route('shop') }}" class="btn">Przejdź do sklepu</a>
    </div>
@else
    <div class="table-wrap">
        <table class="table">
            <tr><th>Nr</th><th>Data</th><th>Suma</th><th>Status</th><th></th></tr>
            @foreach ($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->created_at }}</td>
                    <td>{{ number_format($order->total, 2, ',', ' ') }} zł</td>
                    <td><span class="tag">{{ $order->status }}</span></td>
                    <td><a href="{{ route('orders.show', $order) }}" class="btn btn-outline btn-sm">Szczegóły</a></td>
                </tr>
            @endforeach
        </table>
    </div>
@endif
@endsection