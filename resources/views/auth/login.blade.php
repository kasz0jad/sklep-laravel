@extends('layouts.app')
@section('title', 'Logowanie')

@section('content')
<div class="form-card narrow">
    <h1>Logowanie</h1>
    <form method="POST" action="/login">
        @csrf
        <div class="field">
            <label>E-mail</label>
            <input type="email" name="email" value="{{ old('email') }}">
        </div>
        <div class="field">
            <label>Hasło</label>
            <input type="password" name="password">
        </div>
        <button type="submit" class="btn btn-block">Zaloguj się</button>
    </form>
    <p class="muted">Nie masz konta? <a href="{{ route('register') }}"><strong>Utwórz konto</strong></a></p>
</div>
@endsection