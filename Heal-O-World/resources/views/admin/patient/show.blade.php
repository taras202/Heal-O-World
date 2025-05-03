@extends('layout.admin')

@section('title', 'Деталі пацієнта')

@section('content')
    <h2>Деталі пацієнта</h2>

    <div class="mb-3">
        <strong>Ім’я:</strong> {{ $patient->first_name }}
    </div>
    <div class="mb-3">
        <strong>Прізвище:</strong> {{ $patient->last_name }}
    </div>
    <div class="mb-3">
        <strong>Дата народження:</strong> {{ \Carbon\Carbon::parse($patient->date_of_birth)->format('d-m-Y') }}
    </div>
    <div class="mb-3">
        <strong>Стать:</strong> {{ ucfirst($patient->gender) }}
    </div>
    <div class="mb-3">
        <strong>Контакт:</strong> {{ $patient->contact }}
    </div>
    <div class="mb-3">
        <strong>Наявність страхування:</strong> {{ $patient->has_insurance ? 'Так' : 'Ні' }}
    </div>
    <div class="mb-3">
        <strong>Країна проживання:</strong> {{ $patient->country_of_residence }}
    </div>
    <div class="mb-3">
        <strong>Місто проживання:</strong> {{ $patient->city_of_residence }}
    </div>
    <div class="mb-3">
        <strong>Часовий пояс:</strong> {{ $patient->time_zone }}
    </div>
    <div class="mb-3">
        <strong>Ріст:</strong> {{ $patient->height }} см
    </div>
    <div class="mb-3">
        <strong>Вага:</strong> {{ $patient->weight }} кг
    </div>
    <div class="mb-3">
        <strong>Примітки:</strong> {{ $patient->notes ? $patient->notes : 'Немає приміток' }}
    </div>

    <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary">Повернутись до списку пацієнтів</a>
@endsection
