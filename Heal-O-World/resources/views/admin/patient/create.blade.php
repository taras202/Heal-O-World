@extends('layout.admin')

@section('title', 'Додати пацієнта')

@section('content')
    <h2>Додати нового пацієнта</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.patients.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="first_name">Ім’я:</label>
            <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name') }}" required>
        </div>

        <div class="mb-3">
            <label for="last_name">Прізвище:</label>
            <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name') }}" required>
        </div>

        <div class="mb-3">
            <label for="date_of_birth">Дата народження:</label>
            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}" required>
        </div>

        <div class="mb-3">
            <label for="gender">Стать:</label>
            <select name="gender" id="gender" class="form-control">
                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Чоловік</option>
                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Жінка</option>
                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Інше</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="contact">Контакт:</label>
            <input type="text" name="contact" id="contact" class="form-control" value="{{ old('contact') }}">
        </div>

        <div class="mb-3">
            <label for="has_insurance">Наявність страхування:</label>
            <select name="has_insurance" id="has_insurance" class="form-control">
                <option value="1" {{ old('has_insurance') == '1' ? 'selected' : '' }}>Так</option>
                <option value="0" {{ old('has_insurance') == '0' ? 'selected' : '' }}>Ні</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="country_of_residence">Країна проживання:</label>
            <input type="text" name="country_of_residence" id="country_of_residence" class="form-control" value="{{ old('country_of_residence') }}">
        </div>

        <div class="mb-3">
            <label for="city_of_residence">Місто проживання:</label>
            <input type="text" name="city_of_residence" id="city_of_residence" class="form-control" value="{{ old('city_of_residence') }}">
        </div>

        <div class="mb-3">
            <label for="time_zone">Часовий пояс:</label>
            <input type="text" name="time_zone" id="time_zone" class="form-control" value="{{ old('time_zone') }}">
        </div>

        <div class="mb-3">
            <label for="height">Ріст (см):</label>
            <input type="number" name="height" id="height" class="form-control" value="{{ old('height') }}">
        </div>

        <div class="mb-3">
            <label for="weight">Вага (кг):</label>
            <input type="number" name="weight" id="weight" class="form-control" value="{{ old('weight') }}">
        </div>

        <div class="mb-3">
            <label for="notes">Примітки:</label>
            <textarea name="notes" id="notes" class="form-control">{{ old('notes') }}</textarea>
        </div>

        <hr>

        <button type="submit" class="btn btn-success">Додати пацієнта</button>
        <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary">Повернутись до списку пацієнтів</a>
    </form>
@endsection
