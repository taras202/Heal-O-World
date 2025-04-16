@extends('layout.menu')

@section('title', 'Контакти')

@section('main-class', 'no-padding-full-width')

@section('styles')
<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    }

    .no-padding-full-width {
    max-width: 100% !important;
    padding: 0 !important;
    margin: 0 !important;
    }

    html, body {
        height: 100%;
        width: 100%;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
        background-color: #f8f9fa;
        color: #212529;
        font-family: 'Segoe UI', sans-serif;
    }

        .about-container {
        width: 100vw;
        min-height: 100vh;
        background-image: url("{{ asset('images/doctor2.png') }}");
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 20px;
        position: relative;
    }

    .about-content {
        background-color: rgba(255, 255, 255, 0.6); 
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        text-align: center;
        max-width: 600px;
        width: 100%;
        
        transform: translateY(50%);
    }


    .about-header {
        font-size: 2rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 20px;
    }

    .about-content p {
        font-size: 1.1rem;
        line-height: 1.6;
        color: #555;
    }

    .about-content a {
        color: #007bff;
        text-decoration: none;
    }

    .about-content a:hover {
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
<div class="about-container">
    <div class="about-content">
        <h1 class="about-header">Контакти</h1>
        <p><strong>Адреса:</strong> вул. Герценова 13, Братислава, Словакія</p>
        <p><strong>Телефон:</strong> <a href="tel:+42193980888">+421 (093) 980888</a></p>
        <p><strong>Email:</strong> <a href="mailto:doktor@healoworld.sk">doktor@healoworld.sk</a></p>
        <p><strong>Графік роботи:</strong><br>
            Пн-Пт: 09:00 — 18:00<br>
            Сб: 10:00 — 15:00<br>
            Нд: вихідний
        </p>
        <p>Ви можете залишити запит, і наші фахівці зв'яжуться з вами якнайшвидше.</p>
    </div>
</div>
@endsection
