<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Heal-O-World | @yield('title')</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(180deg,rgb(255, 255, 255),rgb(255, 255, 255));
            color: #212529;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background: linear-gradient(180deg,rgb(13, 54, 129),rgb(39, 95, 151));
            padding: 2rem 1rem 1rem;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            position: relative;
            z-index: 10;
        }

        .logo {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solidrgb(172, 175, 177);
            box-shadow: 0 6px 18px rgba(0,0,0,0.1);
            margin: 0 auto 1.5rem;
        }

        .nav-buttons {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .nav-buttons a {
            padding: 0.6rem 1.4rem;
            background: linear-gradient(135deg,rgb(254, 254, 255),rgb(255, 255, 255));
            border: none;
            border-radius: 12px;
            color: #212529;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 10px rgba(0,0,0,0.06);
        }

        .nav-buttons a:hover {
            background: linear-gradient(135deg,rgb(252, 252, 252), #bcc0c4);
            transform: translateY(-2px);
        }

        main {
            flex: 1;
            padding: 2rem;
            padding-bottom: 4rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        footer {
            background: linear-gradient(180deg,rgb(13, 54, 129),rgb(39, 95, 151));
            color: white;
            text-align: center;
            padding: 1.2rem;
            box-shadow: 0 -2px 10px rgba(20, 16, 231, 0.1);
        }


        @media (max-width: 600px) {
            .nav-buttons a {
                padding: 0.6rem 1rem;
                font-size: 0.9rem;
            }

            .logo {
                width: 70px;
                height: 70px;
                margin-bottom: 1rem;
            }
        }

        @yield('styles')
    </style>
</head>
<body>
    <header>
        <img src="{{ asset('images/logo.webp') }}" alt="GMS Logo" class="logo">
        <div class="nav-buttons">
            <a href="{{ route('landing') }}">Головна</a>
            <a href="{{ route('doctor.index') }}">Лікарі</a>
            <a href="{{ route('about') }}">Про нас</a>
            <a href="{{ route('contact') }}">Контакти</a>
            <a href="#">Вхід</a>
            <a href="#">Реєстрація</a>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Heal-O-World. Всі права захищено.</p>
    </footer>

    @yield('scripts')
</body>
</html>
