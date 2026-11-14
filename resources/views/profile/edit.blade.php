@extends('layouts.app')
@section('title', 'Moje konto')

@section('content')
<div class="form-card">
    <h1>Moje konto</h1>
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PUT')
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