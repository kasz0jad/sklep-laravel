@extends('layouts.app')
@section('title', 'Zamówienie')

@section('content')
<a href="{{ route('cart.index') }}" class="back">← Wróć do koszyka</a>
<h1>Zamówienie</h1>

<div class="table-wrap">
    <table class="table">
        <tr><th>Produkt</th><th>Ilość</th><th>Razem</th></tr>
        @foreach ($items as $item)
            <tr>
                <td>{{ $item['product']->name }}</td>
                <td>{{ $item['quantity'] }}</td>
                <td>{{ number_format($item['subtotal'], 2, ',', ' ') }} zł</td>
            </tr>
        @endforeach
    </table>
</div>
<div class="summary"><p class="total">Suma: {{ number_format($total, 2, ',', ' ') }} zł</p></div>

@guest
    <div class="form-card narrow" style="margin-top:30px; text-align:center">
        <h2>Aby złożyć zamówienie, zaloguj się</h2>
        <p class="muted">Po zalogowaniu wrócisz tutaj, a Twój koszyk zostanie zachowany.</p>
        <div class="field">
            <a href="{{ route('login') }}" class="btn btn-block">Zaloguj się</a>
        </div>
        <div class="field">
            <a href="{{ route('register') }}" class="btn btn-outline btn-block">Utwórz konto</a>
        </div>
    </div>
@else
    @if (auth()->user()->role === 'klient')
        @php $u = auth()->user(); @endphp
        <div class="form-card" style="margin-top:30px">
            <h2>Dane do wysyłki</h2>

            @if ($u->hasAddress())
                <p class="muted">Wpisaliśmy Twoje zapisane dane. Możesz je zmienić tutaj lub na stałe w zakładce <a href="{{ route('profile.edit') }}"><strong>Konto</strong></a>.</p>
            @endif

            <form method="POST" action="{{ route('orders.store') }}">
                @csrf
                <div class="field">
                    <label>Imię i nazwisko *</label>
                    <input type="text" name="shipping_name" value="{{ old('shipping_name', $u->name) }}">
                </div>
                <div class="field">
                    <label>Telefon (9 cyfr) *</label>
                    <input type="text" name="shipping_phone" value="{{ old('shipping_phone', $u->phone) }}">
                </div>
                <div class="field">
                    <label>Ulica (opcjonalnie)</label>
                    <input type="text" name="shipping_street" value="{{ old('shipping_street', $u->street) }}">
                </div>
                <div class="field">
                    <label>Numer domu / mieszkania *</label>
                    <input type="text" name="shipping_house_number" placeholder="np. 12, 12A, 12/4" value="{{ old('shipping_house_number', $u->house_number) }}">
                </div>
                <div class="field">
                    <label>Kod pocztowy *</label>
                    <input type="text" name="shipping_postcode" id="postcode" placeholder="00-000" maxlength="6" inputmode="numeric" value="{{ old('shipping_postcode', $u->postcode) }}">
                </div>
                <div class="field">
                    <label>Miejscowość *</label>
                    <input type="text" name="shipping_city" value="{{ old('shipping_city', $u->city) }}">
                </div>

                <div class="field">
                    <label style="font-weight:400">
                        <input type="checkbox" name="save_address" value="1" style="width:auto; min-width:0"
                               @checked(session()->hasOldInput() ? old('save_address') : ! $u->hasAddress())>
                        Zapisz moje dane do kolejnych zamówień
                    </label>
                </div>

                <button type="submit" class="btn btn-block">Złóż zamówienie</button>
            </form>
        </div>
    @else
        <div class="alert alert-error" style="margin-top:30px">
            Konta moderatora i administratora nie składają zamówień.
        </div>
    @endif
@endguest
@endsection

@push('scripts')
<script>
const postcode = document.getElementById('postcode');
if (postcode) {
    postcode.addEventListener('input', function () {
        let v = this.value.replace(/\D/g, '').slice(0, 5);
        if (v.length > 2) v = v.slice(0, 2) + '-' + v.slice(2);
        this.value = v;
    });
}
</script>
@endpush