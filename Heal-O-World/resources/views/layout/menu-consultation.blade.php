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
            display: flex;
            flex-direction: column;
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

        footer {
            background: linear-gradient(180deg,rgb(13, 54, 129),rgb(39, 95, 151));
            color: white;
            text-align: center;
            padding: 1.2rem;
            box-shadow: 0 -2px 10px rgba(20, 16, 231, 0.1);
            margin-top: auto; 
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

        .profile-container {
            display: flex;
            gap: 2rem;
            padding: 2rem 4rem;
            font-family: 'Segoe UI', sans-serif;
            max-width: 100%;
        }

        .sidebar {
        min-width: 220px;
        background: linear-gradient(180deg,rgb(13, 54, 129),rgb(39, 95, 151));
        border-radius: 12px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1); 
        flex-shrink: 0;
        transition: width 0.3s ease-in-out;
        }

        .sidebar:hover {
            width: 250px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
            color: white;
        }

        .sidebar li {
            padding: 15px 20px;
            border-bottom: 1px solid rgb(26, 72, 126);
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .sidebar li.active,
        .sidebar li:hover {
            background-color:rgb(27, 94, 136); 
            color: #fff;
            font-weight: bold;
            transform: translateX(10px);
        }

        .sidebar li a {
            text-decoration: none;
            color: white;
            font-size: 1.1rem;
            transition: color 0.3s ease-in-out; 
        }

        .sidebar li a:hover {
            color: #f1faee; 
        }

        .sidebar li form {
            display: flex;
            justify-content: center;
        }

        .sidebar li button {
            background-color: transparent;
            color: #e63946;
            border: none;
            padding: 0;
            font-size: 1rem;
            cursor: pointer;
            font-weight: bold;
            transition: color 0.3s ease-in-out;
        }

        .sidebar li button:hover {
            color: #f1faee;
            transform: translateX(5px);
        }

        @media (max-width: 768px) {
            .sidebar {
                min-width: 200px;
            }
        }

        .profile-form {
            flex-grow: 1;
            background-color: white;
            border-radius: 12px;
            padding: 2.5rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            min-width: 0;
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
            
            @if(Auth::check())
            @php
                $role = Auth::user()->role;
                $dashboardRoute = match ($role) {
                    'doctor' => route('doctor.office'),
                    'patient' => route('patient.office'),
                    default => '#',
                };
            @endphp

            <a href="{{ $dashboardRoute }}" class="dashboard-link">Мій кабінет</a>
            @else
            <a href="{{ route('auth.select-role') }}">Вхід</a>
            @endif
        </div>
    </header>

    <div class="profile-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <ul>
                <li class="{{ request()->routeIs('patient.office') ? 'active' : '' }}">
                    <a href="{{ route('patient.office') }}">Мій профіль</a>
                </li>
                <li class="{{ request()->routeIs('patient.office.consultations') ? 'active' : '' }}">
                    <a href="{{ route('patient.office.consultations') }}">Мої консультації</a>
                </li>
                <li>Карта пацієнта</li>
                <li>Обране</li>
                <li>Баланс</li>
                <li>
                    <form method="POST" action="{{ route('auth.logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" style="color: red; background: none; border: none; padding: 0; font: inherit; cursor: pointer;">
                            Вийти з облікового запису
                        </button>
                    </form>
                </li>
            </ul>
        </div>

        <!-- Main content -->
        <main class="@yield('main-class')">
            @yield('content')
        </main>
    </div>

    <footer>
        <p>&copy; {{ date('Y') }} Heal-O-World. Всі права захищено.</p>
    </footer>

    @yield('scripts')
</body>
</html>
