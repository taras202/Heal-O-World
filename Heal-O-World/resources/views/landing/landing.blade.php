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
    .search {
      margin-top: 1rem;
      display: flex;
      justify-content: center;
    }
    .search input {
      padding: 0.5rem;
      width: 300px;
      border: 1px solid #ced4da;
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
      background: #e9ecef;
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
      background: #0d6efd;
      color: white;
      border: none;
      padding: 0.75rem 1.5rem;
      font-size: 1rem;
      border-radius: 5px;
      cursor: pointer;
    }
    .modal {
      display: none;
      position: fixed;
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
      border: 1px solid #ced4da;
      border-radius: 5px;
    }
    .mission, .why-us, .reviews, footer {
      padding: 2rem;
      background: white;
      margin-top: 1rem;
    }
    footer {
      background: #343a40;
      color: white;
      text-align: center;
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
    <div class="specialty">Дієтолог</div>

  </div>
  <div class="choose-doctor-info">
    <h3>Як правильно обрати лікаря?</h3>
    <p>Зверніть увагу на спеціалізацію, досвід та відгуки пацієнтів.</p>
    <button class="contact-button" onclick="document.getElementById('modal').style.display='flex'">Зв'язатися</button>
  </div>
</section>

<div class="modal" id="modal">
  <div class="modal-content">
    <h3>Зв'язатися з нами</h3>
    <input type="text" placeholder="Ім'я">
    <input type="tel" placeholder="Телефон">
    <textarea rows="4" placeholder="Опис проблеми..."></textarea>
    <button class="contact-button" onclick="document.getElementById('modal').style.display='none'">Надіслати</button>
  </div>
</div>

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

<section class="reviews">
  <h2>Відгуки</h2>
  <p>"Дуже зручний сервіс, рекомендую всім!" - Ірина</p>
</section>

<footer>
  <p>&copy; 2025 Heal-O-World. Всі права захищено.</p>
</footer>
@endsection

