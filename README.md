# Sklep internetowy (Laravel)

Projekt zaliczeniowy z przedmiotu Programowanie zaawansowane.

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
- [x] Middleware ról i różne strony dla klienta, moderatora i admina
- [x] Panel administratora (CRUD użytkowników)
- [x] Produkty (dodawanie i usuwanie: moderator, admin)
- [x] Koszyk w sesji i składanie zamówień
- [x] Wyrażenia regularne w walidacji
- [ ] Zabezpieczenie przed SQL Injection
- [ ] (opcjonalnie) Aktywacja konta przez e-mail

## Notatki

### Migracje
- Migracja to wersjonowana zmiana struktury bazy: `up()` ją wprowadza, `down()` cofa.
- Wykonanej migracji nie poprawia się edycją pliku. Laravel zapisuje ją w tabeli `migrations`, więc nie uruchomi jej drugi raz. Zmianę robimy nową migracją.
- Zasada pracy: najpierw uzupełnić `up()` i zapisać plik, dopiero potem `php artisan migrate`.
- `Schema::hasColumn(...)` pozwala zrobić migrację bezpieczną, gdy nie wiadomo, czy kolumna już istnieje.

### Model User
- `#[Fillable([...])]` określa pola, które wolno wypełniać masowo (`User::create`).
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

### Middleware ról (RoleMiddleware)
- Middleware to filtr wykonywany przed trasą. Sprawdza, czy rola zalogowanego użytkownika jest na liście dozwolonych, jeśli nie, zwraca 403.
- `role:moderator,admin` w trasie przekazuje dozwolone role jako argumenty.
- `auth` przekierowuje niezalogowanych na /login.

### Panel admina (Admin\UserController)
- `Route::resource` generuje 7 tras CRUD. Grupa tras ma middleware `auth` i `role:admin`.
- `User $user` w metodzie to route model binding: Laravel sam pobiera użytkownika z bazy po ID z adresu.
- `Rule::unique(...)->ignore($user->id)` pozwala zachować własny e-mail przy edycji.
- Puste hasło przy edycji jest pomijane (`unset`), więc się nie zmienia.
- `@method('PUT')` i `@method('DELETE')`: formularze HTML znają tylko GET i POST, Laravel symuluje resztę.
- Admin nie może usunąć własnego konta.

### Produkty (ProductController)
- `make:model Product -m` tworzy model i migrację naraz.
- Trasy zarządzania mają middleware `role:moderator,admin`, widok sklepu tylko `auth`.
- `decimal('price', 8, 2)` przechowuje cenę z dokładnością do groszy.

### Koszyk i zamówienia
- Koszyk jest tablicą `[id_produktu => ilość]` w sesji (`session('cart')`), nie w bazie.
- Zamówienie jest zapisywane w `DB::transaction`: jeśli cokolwiek się nie uda (np. brak towaru), baza wraca do stanu sprzed zamówienia.
- `lockForUpdate()` blokuje wiersze produktów na czas transakcji, żeby dwie osoby nie kupiły ostatniej sztuki naraz.
- W `order_items` kopiujemy nazwę i cenę, żeby historia nie zmieniła się po edycji lub usunięciu produktu.
- `abort_unless(...)` w `OrderController::show` pilnuje, żeby klient widział tylko własne zamówienia.

### Wyrażenia regularne
- Reguła `regex:/wzorzec/` w walidacji Laravela sprawdza pole wzorcem.
- Imię: `/^[\p{L}\s\-]+$/u` (`\p{L}` to dowolna litera, także polska; flaga `u` włącza Unicode).
- Cena: `/^\d{1,6}(\.\d{1,2})?$/` (do 6 cyfr, opcjonalnie kropka i 1-2 miejsca po przecinku).
- Telefon: `/^\d{9}$/` (dokładnie 9 cyfr).
- `^` i `$` oznaczają początek i koniec tekstu, `\d` cyfrę, `?` element opcjonalny.
- Przy regex używamy tablicy reguł, bo znak `|` we wzorcu kolidowałby z separatorem reguł.

