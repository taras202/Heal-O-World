@extends('layout.menu')

@section('title', 'Контакти')

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
            flex-grow: 1; 
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
            padding: 10px 0;
            margin-top: auto; 
        }
    </style>
@endsection

@section('content')
    <div class="about-container">
        <h1 class="about-header">Контакти</h1>
        <div class="about-content">
            <p>
                Ви можете записатися на консультацію через наш вебсайт або звернутися до нашого кол-центру для отримання додаткової інформації.
            </p>

        </div>
    </div>

    <footer>
        <p>&copy; 2025 Heal-O-World. Всі права захищено.</p>
    </footer>
@endsection
