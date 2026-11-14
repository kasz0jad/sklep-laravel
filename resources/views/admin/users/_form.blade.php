<div class="field">
    <label>Imię</label>
    <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}">
</div>
<div class="field">
    <label>E-mail</label>
    <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}">
</div>
<div class="field">
    <label>Telefon (9 cyfr, opcjonalnie)</label>
    <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}">
</div>
<div class="field">
    <label>Hasło {{ isset($user) ? '(puste = bez zmiany)' : '(min. 8 znaków)' }}</label>
    <input type="password" name="password">
</div>
<div class="field">
    <label>Rola</label>
    <select name="role">
        @foreach (['klient', 'moderator', 'admin'] as $role)
            <option value="{{ $role }}" @selected(old('role', $user->role ?? 'klient') === $role)>{{ $role }}</option>
        @endforeach
    </select>
</div>