<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Heal-O-World | @yield('title')</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(180deg, #fff, #fff);
            color: #212529;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background: linear-gradient(180deg, rgb(13, 54, 129), rgb(39, 95, 151));
            padding: 1rem 2rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            position: relative;
            z-index: 10;
        }

        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .logo {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgb(172, 175, 177);
            box-shadow: 0 6px 18px rgba(0,0,0,0.1);
            flex-shrink: 0;
        }

        .search-wrapper {
            flex: 1 1 500px;
            display: flex;
            gap: 1rem;
            align-items: center;
            justify-content: center;
        }

        .search-box {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
        }

        .search-box select,
        .search-box input {
            padding: 0.4rem 0.8rem;
            border: 1px solid rgb(4, 50, 95);
            border-radius: 5px;
            font-size: 0.9rem;
        }

        .search-box select {
            min-width: 180px;
        }

        .search-box input {
            width: 200px;
        }

        .search-box button {
            padding: 0.4rem 1rem;
            background-color: rgb(37, 79, 141);
            color: black;
            border: none;
            border-radius: 5px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
            user-select: none;
        }

        .search-box button:hover {
            background-color: rgb(30, 65, 120);
        }

        nav.nav-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: nowrap;
            align-items: center;
            justify-content: flex-end;
            flex-shrink: 0;
        }

        nav.nav-buttons a,
        .btn {
            padding: 0.6rem 1.4rem;
            background: linear-gradient(135deg, #fefeFF, #fff);
            border-radius: 12px;
            color: #212529;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 4px 10px rgba(28, 50, 122, 0.06);
            transition: all 0.3s ease-in-out;
            border: none;
            cursor: pointer;
            display: inline-block;
            user-select: none;
            white-space: nowrap;
        }

        nav.nav-buttons a:hover,
        .btn:hover {
            background: linear-gradient(135deg,rgb(252, 252, 252), #bcc0c4);
            transform: translateY(-2px);
        }

        @media (max-width: 900px) {
            .header-container {
                flex-direction: column;
                align-items: center;
            }
            .search-wrapper {
                justify-content: center;
                flex-wrap: wrap;
                gap: 0.75rem;
                margin: 1rem 0;
            }
            nav.nav-buttons {
                justify-content: center;
                flex-wrap: wrap;
                gap: 0.5rem;
            }
        }

        @media (max-width: 600px) {
            .logo {
                width: 70px;
                height: 70px;
            }
            nav.nav-buttons a {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
            .search-box input {
                width: 150px;
            }
            .search-box select {
                min-width: 140px;
            }
        }

        /* Додаткові стилі для списку підказок */
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
        footer {
            background: linear-gradient(180deg,rgb(13, 54, 129),rgb(39, 95, 151));
            color: white;
            text-align: center;
            padding: 1.2rem;
            box-shadow: 0 -2px 10px rgba(20, 16, 231, 0.1);
        }
        

        @yield('styles')
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <a href="{{ route('landing') }}" aria-label="Перейти на головну">
                <img src="{{ asset('images/logo.webp') }}" alt="GMS Logo" class="logo" />
            </a>

            <div class="search-wrapper" role="search" aria-label="Пошук лікарів та спеціальностей">
                <div class="search-box" aria-label="Пошук по спеціальності">
                    <select name="specialty" id="specialtySelect" aria-label="Виберіть спеціальність">
                        <option value="">Виберіть спеціальність</option>
                        @foreach($specialties as $spec)
                            <option value="{{ $spec->name }}" {{ (isset($specialtyFilter) && $spec->name === $specialtyFilter) ? 'selected' : '' }}>
                                {{ $spec->name }}
                            </option>
                        @endforeach
                    </select>
                    <button id="btnSpecialty" type="button" class="btn search-btn">Пошук спеціальності</button>
                </div>

                <div class="search-box" aria-label="Пошук лікаря за прізвищем" style="position:relative;">
                    <input
                        type="text"
                        id="doctorSearchInput"
                        placeholder="Введіть прізвище лікаря..."
                        autocomplete="off"
                        aria-autocomplete="list"
                        aria-controls="doctorSuggestions"
                        aria-expanded="false"
                        aria-haspopup="listbox"
                        role="combobox"
                    />
                    <button id="btnDoctorSearch" type="button" class="btn search-btn">Пошук</button>
                    <ul id="doctorSuggestions" class="suggestion-list" role="listbox" aria-label="Підказки лікарів" tabindex="-1"></ul>
                </div>
            </div>

            <nav class="nav-buttons" aria-label="Головна навігація">
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
                    <a href="{{ $dashboardRoute }}" class="btn">Мій кабінет</a>
                @else
                    <a href="{{ route('auth.select-role') }}" class="btn">Вхід</a>
                @endif
            </nav>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const select = document.getElementById('specialtySelect');
                const btnSpecialty = document.getElementById('btnSpecialty');
                const btnDoctorSearch = document.getElementById('btnDoctorSearch');
                const doctorSearchInput = document.getElementById('doctorSearchInput');
                const suggestionBox = document.getElementById('doctorSuggestions');

                btnSpecialty.addEventListener('click', () => {
                    const specialty = select.value.trim();
                    if (specialty.length < 2) {
                        showMessage('Виберіть спеціальність для пошуку.', true);
                        return;
                    }
                    window.location.href = `/doctor/search-by-specialty?q=${encodeURIComponent(specialty)}`;
                });

                function showMessage(message, isError = false) {
                    suggestionBox.innerHTML = `<li style="color: ${isError ? 'red' : 'gray'};">${message}</li>`;
                    suggestionBox.style.display = 'block';
                    doctorSearchInput.setAttribute('aria-expanded', 'true');
                }

                function clearSuggestions() {
                    suggestionBox.innerHTML = '';
                    suggestionBox.style.display = 'none';
                    doctorSearchInput.setAttribute('aria-expanded', 'false');
                }

                function performDoctorSearch(query) {
                    fetch(`/doctor/search-doctors?q=${encodeURIComponent(query)}`)
                        .then(res => {
                            if (!res.ok) throw new Error('Network response was not ok');
                            return res.json();
                        })
                        .then(data => {
                            suggestionBox.innerHTML = '';
                            if (data.length === 0) {
                                showMessage('Нічого не знайдено');
                                return;
                            }
                            data.forEach(doc => {
                                const li = document.createElement('li');
                                li.textContent = `${doc.first_name} ${doc.last_name}`;
                                li.setAttribute('role', 'option');
                                li.tabIndex = 0;
                                li.addEventListener('click', () => {
                                    window.location.href = `/doctor/${doc.id}`;
                                });
                                li.addEventListener('keydown', (e) => {
                                    if (e.key === 'Enter' || e.key === ' ') {
                                        e.preventDefault();
                                        window.location.href = `/doctor/${doc.id}`;
                                    }
                                });
                                suggestionBox.appendChild(li);
                            });
                            suggestionBox.style.display = 'block';
                            doctorSearchInput.setAttribute('aria-expanded', 'true');
                        })
                        .catch(() => {
                            showMessage('Помилка пошуку', true);
                        });
                }

                function debounce(fn, delay) {
                    let timeoutId;
                    return function(...args) {
                        clearTimeout(timeoutId);
                        timeoutId = setTimeout(() => fn.apply(this, args), delay);
                    };
                }

                btnDoctorSearch.addEventListener('click', () => {
                    const query = doctorSearchInput.value.trim();
                    if (query.length < 2) {
                        showMessage('Введіть щонайменше 2 символи для пошуку.', true);
                        return;
                    }
                    performDoctorSearch(query);
                });

                doctorSearchInput.addEventListener('input', debounce(() => {
                    const query = doctorSearchInput.value.trim();
                    if (query.length < 2) {
                        clearSuggestions();
                        return;
                    }
                    performDoctorSearch(query);
                }, 300));

                doctorSearchInput.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const query = doctorSearchInput.value.trim();
                        if (query.length < 2) {
                            showMessage('Введіть щонайменше 2 символи для пошуку.', true);
                            return;
                        }
                        performDoctorSearch(query);
                    } else if (e.key === 'ArrowDown') {
                        const firstItem = suggestionBox.querySelector('li');
                        if (firstItem) {
                            firstItem.focus();
                            e.preventDefault();
                        }
                    }
                });

                document.addEventListener('click', (e) => {
                    if (!suggestionBox.contains(e.target) && e.target !== doctorSearchInput) {
                        clearSuggestions();
                    }
                });
            });
        </script>
    </header>

    <main class="@yield('main-class')">
        @yield('content')
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Heal-O-World. Всі права захищено.</p>
    </footer>

    @yield('scripts')
</body>
</html>
