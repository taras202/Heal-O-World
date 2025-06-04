@extends('layout.menu-only-landing')

@section('styles')
<style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }
    body {
      background-color: rgb(255, 255, 255);
      color: #212529;
    }
    .search {
      margin-top: 1rem;
      display: flex;
      justify-content: center;
      gap: 1rem;
      flex-wrap: wrap;
    }
    .search input {
      padding: 0.5rem;
      width: 300px;
      border: 1px solid rgb(4, 50, 95);
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
      background: rgb(152, 173, 194);
      border-radius: 50%;
      width: 100px;
      height: 100px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.9rem;
      text-align: center;
      text-decoration: none;
      color: #000;
      font-weight: 600;
      transition: background 0.3s;
    }
    .specialty:hover {
      background: #adb5bd;
    }

    .doctors {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 1rem;
      margin-top: 2rem;
    }
    .doctor {
      border: 1px solid #ccc;
      padding: 1rem;
      border-radius: 10px;
      width: 220px;
      text-align: center;
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
      margin-top: 1rem;
    }

    .btn-doctor-list:hover,
    .btn-doctor-list:focus {
      background-color: rgb(30, 65, 120);
      outline: none;
    }

    .mission, .why-us, .reviews {
      padding: 2rem;
      background: white;
      margin-top: 1rem;
    }

    .no-results {
      display: none;
      margin-top: 1rem;
      color: red;
      font-weight: bold;
    }
</style>
@endsection

@section('content')

<section class="section">
  <h2>Виберіть лікаря</h2>

  <div class="specialties" id="specialtyList">
    @foreach($specialties as $specialty)
      <a href="{{ route('doctor.index', ['specialty' => $specialty->id]) }}" class="specialty">
        {{ $specialty->name }}
      </a>
    @endforeach
  </div>

  <div class="no-results" id="noResults">Нічого не знайдено</div>

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

<section class="reviews">
  <h2>Відгуки</h2>
  <p>"Дуже зручний сервіс, рекомендую всім!" - Ірина</p>
</section>
@endsection

@section('scripts')
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const specialtyInput = document.getElementById('specialtySearch');
    const doctorInput = document.getElementById('doctorSearch');
    const specialties = document.querySelectorAll('.specialty');
    const doctors = document.querySelectorAll('.doctor');
    const noResults = document.getElementById('noResults');

    function filterSpecialties() {
      const value = specialtyInput.value.trim().toLowerCase();
      let count = 0;
      specialties.forEach(item => {
        const match = item.textContent.toLowerCase().includes(value);
        item.style.display = match ? 'flex' : 'none';
        if (match) count++;
      });
      noResults.style.display = count === 0 ? 'block' : 'none';
    }

    function filterDoctors() {
      const text = doctorInput.value.trim().toLowerCase();
      const spec = specialtyInput.value.trim().toLowerCase();
      let count = 0;

      doctors.forEach(doctor => {
        const name = doctor.dataset.name;
        const specialty = doctor.dataset.specialty;

        const matchName = name.includes(text);
        const matchSpec = specialty.includes(spec);

        const visible = matchName && matchSpec;
        doctor.style.display = visible ? 'block' : 'none';
        if (visible) count++;
      });
    }

    specialtyInput.addEventListener('input', () => {
      filterSpecialties();
      filterDoctors();
    });

    doctorInput.addEventListener('input', filterDoctors);
  });
</script>
@endsection
