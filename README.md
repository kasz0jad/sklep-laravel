# Sklep internetowy (Laravel)

Projekt zaliczeniowy z przedmiotu Programowanie zaawansowane.
Autor: [Imię Nazwisko]

## Technologie
- PHP 8.5, Laravel 13
- MariaDB (XAMPP)
- HTML5, CSS3, Blade

## Instalacja
1. `composer install`
2. Skopiuj `.env.example` do `.env` i ustaw dane bazy (`DB_CONNECTION=mariadb`, `DB_DATABASE=projekt`, `DB_USERNAME=root`, puste hasło)
3. `php artisan key:generate`
4. `php artisan migrate`
5. `php artisan serve`, potem wejdź na http://127.0.0.1:8000

## Role użytkowników
- **klient**: przegląda produkty, korzysta z koszyka, składa zamówienia
- **moderator**: dodaje i usuwa produkty
- **admin**: zarządza użytkownikami (CRUD) i produktami

## Zrealizowane funkcje
- [x] Rejestracja z walidacją i szyfrowaniem hasła (bcrypt)
- [x] Logowanie i wylogowanie
- [ ] Role i middleware
- [ ] Panel administratora (CRUD użytkowników)
- [ ] Produkty
- [ ] Koszyk w sesji i zamówienia
- [ ] Wyrażenia regularne, zabezpieczenie przed SQL Injection

## Notatki do obrony

### Rejestracja (AuthController::register)
- `validate` sprawdza wypełnienie pól, `unique:users,email` pilnuje unikalności e-maila.
- Hasło szyfruje się samo dzięki `'password' => 'hashed'` w modelu User (bcrypt).
- Rolę `klient` nadajemy w kodzie, nie z formularza.

### Logowanie (AuthController::login)
- `Auth::attempt` sprawdza e-mail i porównuje hasło z hashem w bazie, więc nie trzeba ręcznie niczego odszyfrowywać.
- `session()->regenerate()` po zalogowaniu chroni przed przejęciem sesji.
- Wylogowanie jest przez POST z `@csrf`, żeby nikt nie wylogował użytkownika zwykłym linkiem.