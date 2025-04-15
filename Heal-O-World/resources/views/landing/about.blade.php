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
    </style>
@endsection

@section('content')

    

    <div class="about-container">
        <h1 class="about-header">Про нас</h1>
        <div class="about-content">
            
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        // Тут можна додати JavaScript, якщо він потрібен для цієї сторінки
    </script>
@endsection
