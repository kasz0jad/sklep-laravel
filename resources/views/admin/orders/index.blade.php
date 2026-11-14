@extends('layouts.app')
@section('title', 'Zamówienia')

@section('content')
<a href="{{ route('admin.index') }}" class="back">← Panel</a>
<h1>Wszystkie zamówienia</h1>

@if ($orders->isEmpty())
    <div class="empty">Brak zamówień.</div>
@else
    <div class="table-wrap">
        <table class="table">
            <tr><th>Nr</th><th>Data</th><th>Klient</th><th>Suma</th><th>Status</th><th>Akcje</th></tr>
            @foreach ($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->created_at }}</td>
                    <td>{{ $order->user?->name }}<br><span class="muted">{{ $order->user?->email }}</span></td>
                    <td>{{ number_format($order->total, 2, ',', ' ') }} zł</td>
                    <td><span class="tag tag-{{ \Illuminate\Support\Str::slug($order->status) }}">{{ $order->status }}</span></td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline btn-sm">Podgląd</a>
                            @if ($order->status !== 'anulowane')
                                <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-outline btn-sm">Edytuj</a>
                                <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" class="inline"
                                      onsubmit="return confirm('Anulować zamówienie #{{ $order->id }}? Towar wróci do magazynu.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Anuluj</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endif
@endsection