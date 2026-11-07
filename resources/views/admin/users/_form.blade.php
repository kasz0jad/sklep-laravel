@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<p><input type="text" name="name" placeholder="Imię" value="{{ old('name', $user->name ?? '') }}"></p>
<p><input type="email" name="email" placeholder="E-mail" value="{{ old('email', $user->email ?? '') }}"></p>
<p><input type="password" name="password" placeholder="Hasło {{ isset($user) ? '(zostaw puste, by nie zmieniać)' : '' }}"></p>
<p>
    <select name="role">
        @foreach (['klient', 'moderator', 'admin'] as $role)
            <option value="{{ $role }}" @selected(old('role', $user->role ?? 'klient') === $role)>{{ $role }}</option>
        @endforeach
    </select>
</p>