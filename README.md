# Sklep internetowy (Laravel)

Projekt zaliczeniowy z przedmiotu Programowanie zaawansowane.
Autor: [Imię Nazwisko]

## Technologie
- PHP 8.5, Laravel 13
- MariaDB (XAMPP)
- HTML5, CSS3, Blade

## Instalacja
1. `composer install`
2. Skopiuj `.env.example` do `.env` i ustaw bazę:
   `DB_CONNECTION=mariadb`, `DB_DATABASE=projekt`, `DB_USERNAME=root`, puste hasło
3. `php artisan key:generate`
4. `php artisan migrate`
5. `php artisan serve`, potem wejdź na http://127.0.0.1:8000

## Role użytkowników
- **klient**: przegląda produkty, korzysta z koszyka, składa zamówienia
- **moderator**: dodaje i usuwa produkty
- **admin**: zarządza użytkownikami (CRUD) i produktami

## Postęp prac
- [x] Środowisko (PHP, Composer, MariaDB, Git) i repozytorium na GitHubie
- [x] Kolumna `role` w tabeli `users` (migracja) i metody `isAdmin()`, `isModerator()` w modelu User
- [x] Rejestracja z walidacją i szyfrowaniem hasła (bcrypt)
- [x] Logowanie i wylogowanie
- [ ] Middleware ról i różne strony dla klienta, moderatora i admina
- [ ] Panel administratora (CRUD użytkowników)
- [ ] Produkty (dodawanie i usuwanie: moderator, admin)
- [ ] Koszyk w sesji i składanie zamówień
- [ ] Wyrażenia regularne w walidacji
- [ ] Zabezpieczenie przed SQL Injection
- [ ] (opcjonalnie) Aktywacja konta przez e-mail

## Notatki do obrony

### Migracja `add_role_to_users_table`
- Migracja to wersjonowana zmiana struktury bazy: `up()` ją wprowadza, `down()` cofa.
- Domyślna rola nowego użytkownika to `klient`.

### Model User
- `#[Fillable([...])]` określa pola, które wolno wypełniać masowo (`User::create`). Dodano `role`.
- `'password' => 'hashed'` w `casts()` powoduje automatyczne szyfrowanie hasła (bcrypt).

### Rejestracja (AuthController::register)
- `validate` sprawdza wypełnienie pól, `unique:users,email` pilnuje unikalności e-maila, `confirmed` wymaga pola `password_confirmation`.
- Rolę `klient` nadajemy w kodzie, nie z formularza (nikt nie nada sobie roli admina).

### Logowanie (AuthController::login)
- `Auth::attempt` sprawdza e-mail i porównuje hasło z hashem w bazie, więc nie trzeba ręcznie niczego odszyfrowywać.
- `session()->regenerate()` po zalogowaniu chroni przed przejęciem sesji.
- Wylogowanie jest przez POST z `@csrf`, żeby nikt nie wylogował użytkownika zwykłym linkiem.

### CSRF
- `@csrf` w każdym formularzu dodaje token chroniący przed fałszowaniem żądań. Bez niego Laravel zwraca błąd 419.