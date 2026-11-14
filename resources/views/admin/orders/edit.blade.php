@extends('layouts.app')
@section('title', 'Edytuj zamówienie #' . $order->id)

@section('content')
<a href="{{ route('admin.orders.show', $order) }}" class="back">← Zamówienie #{{ $order->id }}</a>

<div class="form-card">
    <h1>Edytuj zamówienie #{{ $order->id }}</h1>
    <form method="POST" action="{{ route('admin.orders.update', $order) }}">
        @csrf
        @method('PUT')

        <div class="field">
            <label>Status</label>
            <select name="status">
                @foreach ($statuses as $status)
                    <option value="{{ $status }}" @selected(old('status', $order->status) === $status)>{{ $status }}</option>
                @endforeach
            </select>
        </div>

        <h2>Dane do wysyłki</h2>
        <div class="field">
            <label>Imię i nazwisko *</label>
            <input type="text" name="shipping_name" value="{{ old('shipping_name', $order->shipping_name) }}">
        </div>
        <div class="field">
            <label>Telefon (9 cyfr) *</label>
            <input type="text" name="shipping_phone" value="{{ old('shipping_phone', $order->shipping_phone) }}">
        </div>
        <div class="field">
            <label>Ulica (opcjonalnie)</label>
            <input type="text" name="shipping_street" value="{{ old('shipping_street', $order->shipping_street) }}">
        </div>
        <div class="field">
            <label>Numer domu / mieszkania *</label>
            <input type="text" name="shipping_house_number" value="{{ old('shipping_house_number', $order->shipping_house_number) }}">
        </div>
        <div class="field">
            <label>Kod pocztowy *</label>
            <input type="text" name="shipping_postcode" id="postcode" maxlength="6" inputmode="numeric" value="{{ old('shipping_postcode', $order->shipping_postcode) }}">
        </div>
        <div class="field">
            <label>Miejscowość *</label>
            <input type="text" name="shipping_city" value="{{ old('shipping_city', $order->shipping_city) }}">
        </div>

        <button type="submit" class="btn">Zapisz zmiany</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('postcode').addEventListener('input', function () {
    let v = this.value.replace(/\D/g, '').slice(0, 5);
    if (v.length > 2) v = v.slice(0, 2) + '-' + v.slice(2);
    this.value = v;
});
</script>
@endpush