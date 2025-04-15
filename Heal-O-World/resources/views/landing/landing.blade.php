@extends('layout.menu')

@section('styles')
<style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }
    body {
      background-color:rgb(255, 255, 255);
      color: #212529;
    }
    .search {
      margin-top: 1rem;
      display: flex;
      justify-content: center;
    }
    .search input {
      padding: 0.5rem;
      width: 300px;
      border: 1px solidrgb(4, 50, 95);
      border-radius: 5px;
    }
    .section {
      padding: 2rem;
      text-align: center;
    }
    .specialties {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 1rem;
      margin-top: 1rem;
    }
    .specialty {
      background:rgb(152, 173, 194);
      border-radius: 50%;
      width: 100px;
      height: 100px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.9rem;
      cursor: pointer;
      transition: background 0.3s;
    }
    .specialty:hover {
      background: #adb5bd;
    }
    .choose-doctor-info {
      margin-top: 2rem;
    }
    .contact-button {
      background:rgb(37, 79, 141);
      color: white;
      border: none;
      padding: 0.75rem 1.5rem;
      font-size: 1rem;
      border-radius: 5px;
      cursor: pointer;
    }

    .btn-doctor-list {
    background-color: rgb(37, 79, 141);
    color: white;
    padding: 0.6rem 1.2rem;
    font-weight: bold;
    border-radius: 8px;
    text-decoration: none;
    transition: 0.2s ease-in-out;
    display: inline-block;
    }

    .btn-doctor-list:hover {
        background-color: rgb(37, 79, 141);
    }

    .btn-doctor-list:focus {
        background-color: rgb(37, 79, 141);
        outline: none;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
    }
    .modal-content {
      background: white;
      padding: 2rem;
      border-radius: 10px;
      width: 90%;
      max-width: 500px;
    }
    .modal-content input,
    .modal-content textarea {
      width: 100%;
      margin-bottom: 1rem;
      padding: 0.5rem;
      border: 1px solidrgb(100, 105, 109);
      border-radius: 5px;
    }
    .mission, .why-us, .reviews{
      padding: 2rem;
      background: white;
      margin-top: 1rem;
    }
  </style>
@endsection

@section('content')
<div class="search">
  <input type="text" placeholder="Пошук лікаря за ПІБ...">
</div>

<section class="section">
  <h2>Виберіть лікаря</h2>
  <div class="specialties">
    <div class="specialty">Кардіолог</div>
    <div class="specialty">Педіатр</div>
    <div class="specialty">Терапевт</div>
    <div class="specialty">Дерматолог</div>
    <div class="specialty">Хірург</div>
    <div class="specialty">Офтальмолог</div>
    <div class="specialty">Отоларинголог</div>
    <div class="specialty">Уролог</div>
    <div class="specialty">Травматолог</div>
    <div class="specialty">Невропатолог</div>
    <div class="specialty">Нарколог</div>
    <div class="specialty">Онколог</div>
    <div class="specialty">Ендокринолог</div>
    <div class="specialty">Гастроентеролог</div>
    <div class="specialty">Пульмонолог</div>
    <div class="specialty">Ревматолог</div>
    <div class="specialty">Алерголог</div>
    <div class="specialty">Інфекціоніст</div>
    <div class="specialty">Гінеколог</div>
    <div class="specialty">Андролог</div>
    <div class="specialty">Нефролог</div>
    <div class="specialty">Гематолог</div>
    <div class="specialty">Психіатр</div>
    <div class="specialty">Психотерапевт</div>
    <div class="specialty">Логопед</div>
    <div class="specialty">Стоматолог</div>
    <div class="specialty">Фізіотерапевт</div>
    <div class="specialty">Мамолог</div>
    <div class="specialty">Проктолог</div>
    <div class="specialty">Венеролог</div>
  </div>

  {{-- Кнопка весь список лікарів --}}
    <div class="doctor-list-button">
        <a href="{{ route('doctor.index') }}" class="btn-doctor-list">
            Весь список лікарів
        </a>
    </div>
</section>

<section class="mission">
  <h2>Наша місія</h2>
  <p>Ми прагнемо зробити медицину доступною та якісною для кожного.</p>
</section>

<section class="why-us">
  <h2>Чому варто обрати нас?</h2>
  <ul>
    <li>Сертифіковані лікарі</li>
    <li>Швидкий запис</li>
    <li>Достовірні відгуки</li>
  </ul>
</section>

<section class="mission">
    <div class="choose-doctor-info">
        <h3>Як правильно обрати лікаря?</h3>
        <p>Зверніть увагу на спеціалізацію, досвід та відгуки пацієнтів.</p>
        <button class="contact-button" onclick="document.getElementById('modal').style.display='flex'">Зв'язатися</button>
    </div>

    <div class="modal" id="modal">
    <div class="modal-content">
        <h3>Зв'язатися з нами</h3>
        <input type="text" placeholder="Ім'я">
        <input type="tel" placeholder="Телефон">
        <textarea rows="4" placeholder="Опис проблеми..."></textarea>
        <button class="contact-button" onclick="document.getElementById('modal').style.display='none'">Надіслати</button>
    </div>
    </div>
</section>

<section class="reviews">
  <h2>Відгуки</h2>
  <p>"Дуже зручний сервіс, рекомендую всім!" - Ірина</p>
</section>

@endsection

