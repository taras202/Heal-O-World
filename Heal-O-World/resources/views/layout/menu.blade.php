<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Heal-O-World</title>
    <style>
        @yield('styles')
    </style>
</head>
<body>
    <header>
        <div class="nav-buttons">
            <a href="#">Головна</a>
            <a href="#">Лікарі</a>
            <a href="#">Про нас</a>
            <a href="#">Контакти</a>
            <a href="#">Вхід</a>
            <a href="#">Реєстрація</a>
        </div>
    </header>

    @yield('content')

    @yield('scripts')
</body>
</html>
