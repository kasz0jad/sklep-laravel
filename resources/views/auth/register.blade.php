@extends('layouts.app')
@section('title', 'Rejestracja')

@section('content')
<div class="form-card narrow">
    <h1>Utwórz konto</h1>
    <form method="POST" action="/register">
        @csrf
        <div class="field">
            <label>Imię</label>
            <input type="text" name="name" value="{{ old('name') }}">
        </div>
        <div class="field">
            <label>E-mail</label>
            <input type="email" name="email" value="{{ old('email') }}">
        </div>
        <div class="field">
            <label>Telefon (9 cyfr, opcjonalnie)</label>
            <input type="text" name="phone" value="{{ old('phone') }}">
        </div>
        <div class="field">
            <label>Hasło (min. 8 znaków)</label>
            <input type="password" name="password">
        </div>
        <div class="field">
            <label>Powtórz hasło</label>
            <input type="password" name="password_confirmation">
        </div>
        <button type="submit" class="btn btn-block">Zarejestruj się</button>
    </form>
    <p class="muted">Masz już konto? <a href="{{ route('login') }}"><strong>Zaloguj się</strong></a></p>
</div>
@endsection