@extends('layout.admin')

@section('title', 'Деталі пацієнта')

@section('content')
    <h2>Деталі пацієнта</h2>

    <form>
        <div class="mb-3">
            <label>Фото:</label><br>
            <img src="{{ $patient->photo ? asset('public/' . $patient->photo) : asset('images/default-avatar.png') }}"
                 width="80" height="80" style="border-radius: 50%; margin-bottom: 10px;">
        </div>

        <div class="mb-3">
            <label for="first_name">Ім’я:</label>
            <input type="text" class="form-control" id="first_name" value="{{ $patient->first_name }}" readonly>
        </div>

        <div class="mb-3">
            <label for="last_name">Прізвище:</label>
            <input type="text" class="form-control" id="last_name" value="{{ $patient->last_name }}" readonly>
        </div>

        <div class="mb-3">
            <label for="email">Email:</label>
            <input type="text" class="form-control" id="email" value="{{ $patient->user?->email }}" readonly>
        </div>

        <div class="mb-3">
            <label for="date_of_birth">Дата народження:</label>
            <input type="text" class="form-control" id="date_of_birth" value="{{ \Carbon\Carbon::parse($patient->date_of_birth)->format('d-m-Y') }}" readonly>
        </div>

        <div class="mb-3">
            <label for="gender">Стать:</label>
            <input type="text" class="form-control" id="gender" value="{{ ucfirst($patient->gender) }}" readonly>
        </div>

        <div class="mb-3">
            <label for="contact">Контакт:</label>
            <input type="text" class="form-control" id="contact" value="{{ $patient->contact }}" readonly>
        </div>

        <div class="mb-3">
            <label for="has_insurance">Наявність страхування:</label>
            <input type="text" class="form-control" id="has_insurance" value="{{ $patient->has_insurance ? 'Так' : 'Ні' }}" readonly>
        </div>

        <div class="mb-3">
            <label for="country_of_residence">Країна проживання:</label>
            <input type="text" class="form-control" id="country_of_residence" value="{{ $patient->country_of_residence }}" readonly>
        </div>

        <div class="mb-3">
            <label for="city_of_residence">Місто проживання:</label>
            <input type="text" class="form-control" id="city_of_residence" value="{{ $patient->city_of_residence }}" readonly>
        </div>

        <div class="mb-3">
            <label for="time_zone">Часовий пояс:</label>
            <input type="text" class="form-control" id="time_zone" value="{{ $patient->time_zone }}" readonly>
        </div>

        <div class="mb-3">
            <label for="height">Ріст (см):</label>
            <input type="text" class="form-control" id="height" value="{{ $patient->height }}" readonly>
        </div>

        <div class="mb-3">
            <label for="weight">Вага (кг):</label>
            <input type="text" class="form-control" id="weight" value="{{ $patient->weight }}" readonly>
        </div>

        <div class="mb-3">
            <label for="notes">Примітки:</label>
            <textarea class="form-control" id="notes" readonly>{{ $patient->notes ?: 'Немає приміток' }}</textarea>
        </div>

        <hr>

        <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary">Повернутись до списку пацієнтів</a>
    </form>
@endsection
