@extends('layouts.app')
@section('title', 'Moje konto')

@section('content')
<div class="form-card">
    <h1>Moje konto</h1>
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PUT')

        <h2>Dane konta</h2>
        <div class="field">
            <label>Imię</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}">
        </div>
        <div class="field">
            <label>E-mail</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}">
        </div>
        <div class="field">
            <label>Telefon (9 cyfr)</label>
            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}">
        </div>

        <h2>Adres dostawy</h2>
        <p class="muted">Ten adres będzie wpisywany automatycznie przy składaniu zamówienia.</p>
        <div class="field">
            <label>Ulica (opcjonalnie)</label>
            <input type="text" name="street" value="{{ old('street', $user->street) }}">
        </div>
        <div class="field">
            <label>Numer domu / mieszkania</label>
            <input type="text" name="house_number" placeholder="np. 12, 12A, 12/4" value="{{ old('house_number', $user->house_number) }}">
        </div>
        <div class="field">
            <label>Kod pocztowy</label>
            <input type="text" name="postcode" id="postcode" placeholder="00-000" maxlength="6" inputmode="numeric" value="{{ old('postcode', $user->postcode) }}">
        </div>
        <div class="field">
            <label>Miejscowość</label>
            <input type="text" name="city" value="{{ old('city', $user->city) }}">
        </div>

        <h2>Zmiana hasła</h2>
        <div class="field">
            <label>Nowe hasło (puste = bez zmiany)</label>
            <input type="password" name="password">
        </div>
        <div class="field">
            <label>Powtórz nowe hasło</label>
            <input type="password" name="password_confirmation">
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