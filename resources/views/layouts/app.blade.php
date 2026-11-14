<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sklep') – LUMA</title>
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shop.css') }}">
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
    <link rel="stylesheet" href="{{ asset('css/panel.css') }}">
</head>
<body>
    <div class="topbar">Darmowa dostawa od 200 zł</div>

    <header class="header">
        <div class="container header-row">
            <a href="{{ route('shop') }}" class="logo"><img src="{{ asset('images/logo.svg') }}" alt="LUMA"></a>

            <form class="search" method="GET" action="{{ route('shop') }}">
                <input type="text" name="q" placeholder="Szukaj produktów" value="{{ request('q') }}">
                <button type="submit">Szukaj</button>
            </form>

            <nav class="icons">
                @auth
                    <a href="{{ route('profile.edit') }}">Konto</a>
                    @if (auth()->user()->role === 'klient')
                        <a href="{{ route('orders.index') }}">Zamówienia</a>
                    @else
                        <a href="/dashboard">Panel</a>
                    @endif
                    <form method="POST" action="/logout" class="inline">
                        @csrf
                        <button type="submit" class="link-btn">Wyloguj</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Zaloguj</a>
                    <a href="{{ route('register') }}">Utwórz konto</a>
                @endauth
                <a href="{{ route('cart.index') }}" class="cart">Koszyk <span class="badge">{{ array_sum(session('cart', [])) }}</span></a>
            </nav>
        </div>
    </header>

    <nav class="categories">
        <div class="container">
            <a href="{{ route('shop') }}" class="{{ request()->routeIs('shop') && ! request('kategoria') ? 'active' : '' }}">Wszystko</a>
            @foreach (\App\Models\Product::CATEGORIES as $cat)
                <a href="{{ route('shop', ['kategoria' => $cat]) }}" class="{{ request('kategoria') === $cat ? 'active' : '' }}">{{ $cat }}</a>
            @endforeach
        </div>
    </nav>

    <main class="page">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-cols">
                <div>
                    <h4>LUMA</h4>
                    <a href="{{ route('shop') }}">Sklep</a>
                    <a href="{{ route('cart.index') }}">Koszyk</a>
                </div>
                <div>
                    <h4>Obsługa klienta</h4>
                    <a href="#">Dostawa i płatności</a>
                    <a href="#">Zwroty</a>
                    <a href="#">Kontakt</a>
                </div>
                <div>
                    <h4>Konto</h4>
                    <a href="{{ route('login') }}">Logowanie</a>
                    <a href="{{ route('register') }}">Rejestracja</a>
                </div>
            </div>
            <div class="footer-bottom">© {{ date('Y') }} LUMA. Projekt zaliczeniowy.</div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>