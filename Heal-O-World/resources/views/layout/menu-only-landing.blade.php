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
        .dashboard-link {
            padding: 0.6rem 1.4rem;
            background: linear-gradient(135deg, rgb(254, 254, 255), rgb(255, 255, 255));
            border: none;
            border-radius: 12px;
            color: #212529;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06);
        }

        .dashboard-link:hover {
            background: linear-gradient(135deg, rgb(252, 252, 252), #bcc0c4);
            transform: translateY(-2px);
        }
        .search-header {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-top: 1rem;
        }

        .search-header input {
            padding: 0.4rem 0.8rem;
            border: 1px solid rgb(4, 50, 95);
            border-radius: 5px;
            font-size: 0.9rem;
            width: 200px;
        }
        .search-header button {
            padding: 0.4rem 1rem;
            background-color: rgb(37, 79, 141);
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .search-header button:hover {
            background-color: rgb(30, 65, 120);
        }
        .suggestion-list {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: white;
            border: 1px solid #ccc;
            border-top: none;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
            list-style: none;
            padding: 0;
            margin: 0;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .suggestion-list li {
            padding: 0.5rem 1rem;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .suggestion-list li:hover {
            background-color: #f0f0f0;
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

        <div class="search-header">
            <input type="text" id="searchBySpecialty" placeholder="Пошук по спеціальності...">
            <button id="btnSpecialty">Пошук спеціальності</button>

            <div class="search-container" style="position: relative; max-width: 400px; margin: 0 auto;">
                <div style="display: flex; gap: 0.5rem;">
                    <input
                        type="text"
                        id="doctorSearchInput"
                        placeholder="Введіть ім’я лікаря..."
                        class="form-control"
                        autocomplete="off"
                        style="flex: 1;"
                    />
                    <button id="btnDoctorSearch">Пошук</button>
                </div>
                <ul id="doctorSuggestions" class="suggestion-list"></ul>
            </div>
        </div>
    </header>


    <main class="@yield('main-class')">
        @yield('content')
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Heal-O-World. Всі права захищено.</p>
    </footer>

    @yield('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnSpecialty = document.getElementById('btnSpecialty');
        if (btnSpecialty) {
            btnSpecialty.addEventListener('click', function() {
                const specialtyInput = document.getElementById('searchBySpecialty');
                if (!specialtyInput) return;

                const specialty = specialtyInput.value.trim();
                if (specialty.length < 2) {
                    alert('Введіть спеціальність для пошуку.');
                    return;
                }

                window.location.href = `/doctor/search-by-specialty?q=${encodeURIComponent(specialty)}`;
            });
        }

        const btnDoctorSearch = document.getElementById('btnDoctorSearch');
        const doctorSearchInput = document.getElementById('doctorSearchInput');
        const suggestionBox = document.getElementById('doctorSuggestions');

        if (btnDoctorSearch && doctorSearchInput && suggestionBox) {
            btnDoctorSearch.addEventListener('click', function() {
                const query = doctorSearchInput.value.trim();
                if (query.length < 2) {
                    alert('Введіть щонайменше 2 символи для пошуку.');
                    return;
                }

                fetch(`/doctor/search-doctors?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        suggestionBox.innerHTML = '';
                        if (data.length === 0) {
                            suggestionBox.innerHTML = '<li>Нічого не знайдено</li>';
                            return;
                        }
                        data.forEach(doctor => {
                            const li = document.createElement('li');
                            li.textContent = `${doctor.first_name} ${doctor.last_name}`;
                            li.addEventListener('click', function() {
                                window.location.href = `/doctor/${doctor.id}`;
                            });
                            suggestionBox.appendChild(li);
                        });
                    })
                    .catch(() => {
                        suggestionBox.innerHTML = '<li>Помилка пошуку</li>';
                    });
            });

            doctorSearchInput.addEventListener('input', function() {
                const query = doctorSearchInput.value.trim();
                clearTimeout(window.searchTimeout);
                if (query.length < 2) {
                    suggestionBox.innerHTML = '';
                    return;
                }
                window.searchTimeout = setTimeout(() => {
                    fetch(`/doctor/search-doctors?q=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => {
                            suggestionBox.innerHTML = '';
                            if (data.length === 0) {
                                suggestionBox.innerHTML = '<li>Нічого не знайдено</li>';
                                return;
                            }
                            data.forEach(doctor => {
                                const li = document.createElement('li');
                                li.textContent = `${doctor.first_name} ${doctor.last_name}`;
                                li.addEventListener('click', function() {
                                    window.location.href = `/doctor/${doctor.id}`;
                                });
                                suggestionBox.appendChild(li);
                            });
                        })
                        .catch(() => {
                            suggestionBox.innerHTML = '<li>Помилка пошуку</li>';
                        });
                }, 300);
            });
        }
    });
</script>


<script>
    document.getElementById("btnSpecialty").addEventListener("click", function () {
        const specialty = document.getElementById("searchBySpecialty").value.trim();

        if (specialty.length < 2) {
            alert("Введіть спеціальність для пошуку.");
            return;
        }

        window.location.href = `/doctor/search-by-specialty?q=${encodeURIComponent(specialty)}`;
    });
</script>
</body>
