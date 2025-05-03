@extends('layout.admin')

@section('title', 'Додати нового лікаря')

@section('content')
    <h2>Додати нового лікаря</h2>

    <form action="{{ route('admin.doctors.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Фото:</label><br>
            <input type="file" name="photo" class="form-control mt-2">
        </div>

        <div class="mb-3">
            <label>Ім’я:</label>
            <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}">
        </div>

        <div class="mb-3">
            <label>Прізвище:</label>
            <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}">
        </div>

        <div class="mb-3">
            <label>Стать:</label>
            <select name="gender" class="form-control">
                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Чоловік</option>
                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Жінка</option>
                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Інше</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Контакт:</label>
            <input type="text" name="contact" class="form-control" value="{{ old('contact') }}">
        </div>

        <div class="mb-3">
            <label>Часовий пояс:</label>
            <input type="text" name="time_zone" class="form-control" value="{{ old('time_zone') }}">
        </div>

        <hr>

        <h4>Спеціалізації</h4>
        <div class="mb-2">
            <label>Спеціалізація:</label>
            <input type="text" name="specialties[0][name]" class="form-control" value="{{ old('specialties.0.name') }}">
            <label>Досвід (роки):</label>
            <input type="number" name="specialties[0][experience]" class="form-control" value="{{ old('specialties.0.experience') }}">
            <label>Ціна (грн):</label>
            <input type="number" name="specialties[0][price]" class="form-control" value="{{ old('specialties.0.price') }}">
        </div>

        <hr>

        <h4>Освіта</h4>
        <div class="mb-2">
            <label>Заклад:</label>
            <input type="text" name="educations[0][institution]" class="form-control" value="{{ old('educations.0.institution') }}">
            <label>Ступінь:</label>
            <input type="text" name="educations[0][degree]" class="form-control" value="{{ old('educations.0.degree') }}">
            <label>Рік початку:</label>
            <input type="text" name="educations[0][start_year]" class="form-control" value="{{ old('educations.0.start_year') }}">
            <label>Рік завершення:</label>
            <input type="text" name="educations[0][end_year]" class="form-control" value="{{ old('educations.0.end_year') }}">
        </div>

        <hr>

        <h4>Місце роботи</h4>
        <div class="mb-2">
            <label>Назва закладу:</label>
            <input type="text" name="place_of_work[workplace]" class="form-control" value="{{ old('place_of_work.workplace') }}">
            <label>Посада:</label>
            <input type="text" name="place_of_work[position]" class="form-control" value="{{ old('place_of_work.position') }}">
            <label>Країна:</label>
            <input type="text" name="place_of_work[country_of_residence]" class="form-control" value="{{ old('place_of_work.country_of_residence') }}">
            <label>Місто:</label>
            <input type="text" name="place_of_work[city_of_residence]" class="form-control" value="{{ old('place_of_work.city_of_residence') }}">
        </div>

        <button type="submit" class="btn btn-success mt-3">Створити лікаря</button>

        <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary mt-3 ms-3">Повернутись до списку лікарів</a>
    </form>
@endsection
