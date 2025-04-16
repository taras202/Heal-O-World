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
            border: 3px solid rgb(172, 175, 177);
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

        .role-selection-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 80vh;
            text-align: center;
            padding: 1rem 1rem 1rem 1rem;
        }

        .role-selection-container h2 {
            font-size: 1rem;
            margin-bottom: 1rem;
            color: #0d3681;
        }

        .role-buttons {
            display: flex;
            gap: 2rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .role-buttons a {
            background: linear-gradient(135deg, #1e60c2, #3c8dfc);
            color: #fff;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1rem;
            transition: background 0.3s, transform 0.2s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .role-buttons a:hover {
            background: linear-gradient(135deg, #154798, #2c72d4);
            transform: translateY(-2px);
        }

        .back-button {
            display: inline-block;
            margin-top: 1rem;
            color: #fff;
            background-color: #1e60c2;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: bold;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .back-button:hover {
            background-color: #154798;
            color: #fff;
            transform: translateY(-3px);  
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);  
            text-decoration: none;
        }

        .back-button:active {
            transform: translateY(1px);  
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
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
        
    </header>
   
    <div class="role-selection-container">
        <h1>Авторизація</h1>
        <h2>Оберіть ваш тип користувача</h2>

        <div class="role-buttons">
            <a href="{{ route('patient.login') }}"> Вхід як пацієнт</a>
            <a href="{{ route('doctor.login') }}"> Вхід як лікар</a>
        </div>

        <a href="{{ route('landing') }}" class="back-button">← Повернутися на головну</a>
    </div>
    <main>
        @yield('content')
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Heal-O-World. Всі права захищено.</p>
    </footer>

    @yield('scripts')
</body>
</html>
