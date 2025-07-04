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
      <a href="{{ route('doctor.index', ['specialty' => $specialty->name]) }}" class="specialty">
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

  <section class="doctors">
    @foreach($doctors as $doctor)
      <div class="doctor" data-name="{{ strtolower($doctor->first_name . ' ' . $doctor->last_name) }}" data-specialty="{{ strtolower($doctor->specialties->pluck('name')->join(' ')) }}">
        <img src="{{ $doctor->photo ? asset('storage/' . $doctor->photo) : asset('default-avatar.png') }}" alt="Фото {{ $doctor->first_name }}" style="width:100px; height:100px; border-radius: 50%; object-fit: cover;">
        <h3>{{ $doctor->first_name }} {{ $doctor->last_name }}</h3>
        <p>{{ $doctor->specialties->pluck('name')->join(', ') }}</p>
        <a href="{{ route('doctor.show', $doctor->id) }}" class="btn-doctor-list">Переглянути профіль</a>
      </div>
    @endforeach
  </section>


<section class="mission">
  <h2>{{ $content->mission_title }}</h2>
  <p>{{ $content->mission_text }}</p>
</section>

<section class="why-us">
  <h2>{{ $content->why_us_title }}</h2>
  <ul>
    @foreach (explode("\n", $content->why_us_list) as $item)
      <li>{{ trim($item) }}</li>
    @endforeach
  </ul>
</section>

<section class="reviews">
  <h2>{{ $content->reviews_title }}</h2>
  <p>{{ $content->reviews_text }}</p>
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
