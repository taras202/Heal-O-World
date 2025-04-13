@extends('layout.menu')

@section('title', 'Про нас')

@section('styles')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background-color: #f8f9fa;
            color: #212529;
        }

        header {
            background: #0d6efd;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        .nav-buttons a {
            margin: 0 1rem;
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .about-container {
            padding: 30px;
            background-color: #f9f9f9;
        }

        .about-header {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
            text-align: center;
        }

        .about-content {
            margin-top: 20px;
            font-size: 1.1rem;
            line-height: 1.6;
            color: #555;
        }

        .about-image {
            margin-top: 20px;
            max-width: 100%;
            height: auto;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        footer {
            background: #343a40;
            color: white;
            text-align: center;
            padding: 1rem;
            margin-top: 2rem;
        }
    </style>
@endsection

@section('content')

    

    <div class="about-container">
        <h1 class="about-header">Про нас</h1>
        <div class="about-content">
            <p>
                Ласкаво просимо до Heal-O-World! Ми команда професіоналів, які надають якісну медичну допомогу
                і робимо все можливе, щоб забезпечити здоров’я наших пацієнтів на найвищому рівні.
            </p>
            <p>
                Наша місія — надавати доступну медичну допомогу для кожної людини, використовуючи сучасні технології
                і перевірені методи лікування.
            </p>
            <p>
                Ми пропонуємо широкий спектр медичних послуг, які охоплюють всі основні спеціальності та напрямки.
                Наша команда лікарів готова допомогти вам отримати найкраще лікування та підтримку.
            </p>
            <p>
                Ви можете записатися на консультацію через наш вебсайт або звернутися до нашого кол-центру для отримання додаткової інформації.
            </p>
            <img src="{{ asset('images/about-image.jpg') }}" alt="Про нас" class="about-image">
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Heal-O-World. Всі права захищено.</p>
    </footer>
@endsection

@section('scripts')
    <script>
        // Тут можна додати JavaScript, якщо він потрібен для цієї сторінки
    </script>
@endsection
