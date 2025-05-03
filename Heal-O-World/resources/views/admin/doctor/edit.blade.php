@extends('layout.admin')

@section('title', 'Редагування лікаря')

@section('content')
    <h2>Редагування лікаря</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.doctors.update', $doctor) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Фото:</label><br>
            <img src="{{ $doctor->photo ? asset('storage/' . $doctor->photo) : asset('images/default-avatar.png') }}"
                 width="80" height="80" style="border-radius: 50%; margin-bottom: 10px;">
            <input type="file" name="photo" class="form-control mt-2">
        </div>

        <div class="mb-3">
            <label>Ім’я:</label>
            <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $doctor->first_name) }}" required>
        </div>

        <div class="mb-3">
            <label>Прізвище:</label>
            <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $doctor->last_name) }}">
        </div>

        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $doctor->email) }}" required>
        </div>

        <div class="mb-3">
            <label>Стать:</label>
            <select name="gender" class="form-control">
                <option value="male" {{ old('gender', $doctor->gender) == 'male' ? 'selected' : '' }}>Чоловік</option>
                <option value="female" {{ old('gender', $doctor->gender) == 'female' ? 'selected' : '' }}>Жінка</option>
                <option value="other" {{ old('gender', $doctor->gender) == 'other' ? 'selected' : '' }}>Інше</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Контакт:</label>
            <input type="text" name="contact" class="form-control" value="{{ old('contact', $doctor->contact) }}">
        </div>

        <div class="mb-3">
            <label>Часовий пояс:</label>
            <input type="text" name="time_zone" class="form-control" value="{{ old('time_zone', $doctor->time_zone) }}">
        </div>

        <hr>

        <h4>Спеціалізації</h4>
        @foreach($doctor->specialties as $index => $specialty)
            <input type="hidden" name="specialties[{{ $index }}][id]" value="{{ $specialty->id }}">
            <div class="mb-2">
                <strong>{{ $specialty->name }}</strong><br>
                <label>Досвід (роки):</label>
                <input type="number" name="specialties[{{ $index }}][experience]" class="form-control"
                       value="{{ old("specialties.$index.experience", $specialty->pivot->experience) }}" required>
                <label>Ціна (грн):</label>
                <input type="number" name="specialties[{{ $index }}][price]" class="form-control"
                       value="{{ old("specialties.$index.price", $specialty->pivot->price) }}" required>
            </div>
        @endforeach

        <hr>

        <h4>Освіта</h4>
        @foreach($doctor->educations as $i => $edu)
            <input type="hidden" name="educations[{{ $i }}][id]" value="{{ $edu->id }}">
            <div class="mb-2">
                <label>Заклад:</label>
                <input type="text" name="educations[{{ $i }}][institution]" class="form-control"
                       value="{{ old("educations.$i.institution", $edu->institution) }}">
                <label>Ступінь:</label>
                <input type="text" name="educations[{{ $i }}][degree]" class="form-control"
                       value="{{ old("educations.$i.degree", $edu->degree) }}">
                <label>Рік початку:</label>
                <input type="text" name="educations[{{ $i }}][start_year]" class="form-control"
                       value="{{ old("educations.$i.start_year", $edu->start_year) }}">
                <label>Рік завершення:</label>
                <input type="text" name="educations[{{ $i }}][end_year]" class="form-control"
                       value="{{ old("educations.$i.end_year", $edu->end_year) }}">
            </div>
        @endforeach

        <hr>

        <h4>Місце роботи</h4>
        <div class="mb-2">
            <label>Назва закладу:</label>
            <input type="text" name="place_of_work[workplace]" class="form-control"
                   value="{{ old('place_of_work.workplace', $doctor->placeOfWork->workplace ?? '') }}">
            <label>Посада:</label>
            <input type="text" name="place_of_work[position]" class="form-control"
                   value="{{ old('place_of_work.position', $doctor->placeOfWork->position ?? '') }}">
            <label>Країна:</label>
            <input type="text" name="place_of_work[country_of_residence]" class="form-control"
                   value="{{ old('place_of_work.country_of_residence', $doctor->placeOfWork->country_of_residence ?? '') }}">
            <label>Місто:</label>
            <input type="text" name="place_of_work[city_of_residence]" class="form-control"
                   value="{{ old('place_of_work.city_of_residence', $doctor->placeOfWork->city_of_residence ?? '') }}">
        </div>

        <button type="submit" class="btn btn-success mt-3">Зберегти зміни</button>
    </form>

    <div class="mt-4">
        <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary">Повернутись до списку лікарів</a>
    </div>
@endsection
