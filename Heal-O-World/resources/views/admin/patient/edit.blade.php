@extends('layout.admin')

@section('title', 'Редагування пацієнта')

@section('content')
    <h2>Редагувати пацієнта</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.patients.update', $patient) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Фото:</label><br>
            <img src="{{ $patient->photo ? asset('storage/' . $patient->photo) : asset('photos/default-avatar.png') }}"
                width="80" height="80" style="border-radius: 50%; margin-bottom: 10px;">
            <input type="file" name="photo" class="form-control mt-2">
        </div>

        <div class="mb-3">
            <label for="first_name">Ім’я:</label>
            <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name', $patient->first_name) }}" required>
        </div>

        <div class="mb-3">
            <label for="last_name">Прізвище:</label>
            <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name', $patient->last_name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $patient->user?->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="date_of_birth">Дата народження:</label>
            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="{{ old('date_of_birth', $patient->date_of_birth) }}" required>
        </div>

        <div class="mb-3">
            <label for="gender">Стать:</label>
            <select name="gender" id="gender" class="form-control">
                <option value="male" {{ old('gender', $patient->gender) == 'male' ? 'selected' : '' }}>Чоловік</option>
                <option value="female" {{ old('gender', $patient->gender) == 'female' ? 'selected' : '' }}>Жінка</option>
                <option value="other" {{ old('gender', $patient->gender) == 'other' ? 'selected' : '' }}>Інше</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="contact">Контакт:</label>
            <input type="text" name="contact" id="contact" class="form-control" value="{{ old('contact', $patient->contact) }}">
        </div>

        <div class="mb-3">
            <label for="has_insurance">Наявність страхування:</label>
            <select name="has_insurance" id="has_insurance" class="form-control">
                <option value="1" {{ old('has_insurance', $patient->has_insurance) == 1 ? 'selected' : '' }}>Так</option>
                <option value="0" {{ old('has_insurance', $patient->has_insurance) == 0 ? 'selected' : '' }}>Ні</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="country_of_residence">Країна проживання:</label>
            <input type="text" name="country_of_residence" id="country_of_residence" class="form-control" value="{{ old('country_of_residence', $patient->country_of_residence) }}">
        </div>

        <div class="mb-3">
            <label for="city_of_residence">Місто проживання:</label>
            <input type="text" name="city_of_residence" id="city_of_residence" class="form-control" value="{{ old('city_of_residence', $patient->city_of_residence) }}">
        </div>

        <div class="mb-3">
            <label for="time_zone">Часовий пояс:</label>
            <input type="text" name="time_zone" id="time_zone" class="form-control" value="{{ old('time_zone', $patient->time_zone) }}">
        </div>

        <div class="mb-3">
            <label for="height">Ріст (см):</label>
            <input type="number" step="0.01" name="height" id="height" class="form-control" value="{{ old('height', $patient->height) }}">
        </div>

        <div class="mb-3">
            <label for="weight">Вага (кг):</label>
            <input type="number" step="0.01" name="weight" id="weight" class="form-control" value="{{ old('weight', $patient->weight) }}">
        </div>

        <div class="mb-3">
            <label for="notes">Примітки:</label>
            <textarea name="notes" id="notes" class="form-control">{{ old('notes', $patient->notes) }}</textarea>
        </div>

        <button type="submit" class="btn btn-success mt-3">Зберегти зміни</button>
    </form>

    <div class="mt-4">
    <a href="{{ route('admin.patients.index', $patient) }}" class="btn btn-secondary">Повернутись до списку пацієнтів</a>
    </div>
@endsection
