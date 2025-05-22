@extends('layout.menu-consultation-doctor')

@section('title', 'Редагування профілю лікаря')

<style>
    /* Глобальні стилі */
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #f4f7fc;
        margin: 0;
        padding: 0;
    }

    h1 {
        font-size: 30px;
        text-align: center;
        color: #2d3436;
        margin-bottom: 30px;
    }

    /* Контейнер для профілю */
    .profile-container {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    /* Бокова панель з фото */
    .profile-sidebar {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 180px; /* Зменшили ширину бокової панелі */
    }

    .profile-sidebar img {
        width: 100px; /* Зменшили розмір фото */
        height: 100px; /* Зменшили висоту фото */
        object-fit: cover;
        border-radius: 50%;
        margin-bottom: 15px;
        border: 3px solid #28a745;
    }

    /* Основна форма редагування */
    .profile-main {
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
        display: flex;
        flex-direction: column;
    }

    label {
        font-weight: 600;
        color: #333;
    }

    input, select, textarea {
        width: 100%;
        padding: 12px;
        margin-top: 6px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 16px;
        background-color: #f8f8f8;
        transition: border-color 0.3s ease;
    }

    input:focus, select:focus, textarea:focus {
        border-color: #28a745;
        outline: none;
    }

    button[type="submit"] {
        margin-top: 20px;
        background-color: #28a745;
        color: white;
        padding: 15px 25px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button[type="submit"]:hover {
        background-color: #218838;
    }

    .section-block {
        margin-bottom: 30px;
    }

    .section-block hr {
        margin-top: 15px;
        border-color: #ddd;
    }

    .specialty-block,
    .education-block,
    .workplace-block {
        margin-top: 20px;
        padding: 15px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
    }

    .specialty-block h4,
    .education-block h4,
    .workplace-block h4 {
        margin-bottom: 15px;
        font-size: 20px;
        color: #333;
    }

    /* Стилі для форми */
    .form-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr); /* Три поля в рядку */
        gap: 20px;
        margin-top: 12px;
    }

    .input-group {
        display: flex;
        flex-direction: column;
    }

    /* Стилі для мобільних пристроїв */
    @media (max-width: 768px) {
        .profile-container {
            grid-template-columns: 1fr;
        }

        .form-row {
            grid-template-columns: 1fr; /* В одне поле на рядок для мобільних */
        }
    }
</style>

@section('content')
<h1>Редагування профілю лікаря</h1>

@if ($errors->any())
    <div style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('doctor.profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="profile-container">
        
        <!-- Ліва частина: Фото лікаря -->
        <div class="profile-sidebar">
            <label for="photo">Фото профілю</label>
            <input type="file" name="photo" id="photo" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500" />
        </div>

        <!-- Права частина: Основні дані -->
        <div class="profile-main">
            <div class="section-block">
                <div class="form-row">
                    <div class="input-group">
                        <label>Ім’я</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $doctor->first_name) }}">
                    </div>
                    <div class="input-group">
                        <label>Прізвище</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $doctor->last_name) }}">
                    </div>
                    <div class="input-group">
                        <label>Стать</label>
                        <select name="gender">
                            <option value="male" {{ $doctor->gender == 'male' ? 'selected' : '' }}>Чоловік</option>
                            <option value="female" {{ $doctor->gender == 'female' ? 'selected' : '' }}>Жінка</option>
                            <option value="other" {{ $doctor->gender == 'other' ? 'selected' : '' }}>Інше</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="input-group">
                        <label>Контакт</label>
                        <input type="text" name="contact" value="{{ old('contact', $doctor->contact) }}">
                    </div>

                    <div class="input-group">
                        <label>Часовий пояс</label>
                        <select name="time_zone_id" class="...">
                            @foreach($timeZones as $tz)
                                <option value="{{ $tz->id }}" {{ old('time_zone_id', $doctor->time_zone_id) == $tz->id ? 'selected' : '' }}>
                                    {{ $tz->time_zone }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="input-group">
                        <label>Біографія</label>
                        <textarea name="bio" rows="3">{{ old('bio', $doctor->bio) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Спеціалізації -->
            <div class="section-block specialty-block">
                <h4>Спеціалізації</h4>
                @foreach($doctor->specialties as $index => $specialty)
                    <input type="hidden" name="specialties[]" value="{{ $specialty->id }}">
                    <label><strong>{{ $specialty->name }}</strong></label>
                    <div class="form-row">
                        <div class="input-group">
                            <label>Досвід (наприклад, 3 роки)</label>
                            <input type="text" name="specialty_data[{{ $index }}][experience]" value="{{ old("specialty_data.$index.experience", $specialty->pivot->experience) }}">
                        </div>
                        <div class="input-group">
                            <label>Ціна (грн)</label>
                            <input type="number" name="specialty_data[{{ $index }}][price]" value="{{ old("specialty_data.$index.price", $specialty->pivot->price) }}">
                        </div>
                    </div>
                    <hr>
                @endforeach
            </div>

            <!-- Освіта -->
            <div class="section-block education-block">
                <h4>Освіта</h4>
                @foreach($doctor->educations as $i => $edu)
                    <input type="hidden" name="educations[{{ $i }}][id]" value="{{ $edu->id }}">
                    <div class="form-row">
                        <div class="input-group">
                            <label>Заклад</label>
                            <input type="text" name="educations[{{ $i }}][institution]" value="{{ old("educations.$i.institution", $edu->institution) }}">
                        </div>
                        <div class="input-group">
                            <label>Ступінь</label>
                            <input type="text" name="educations[{{ $i }}][degree]" value="{{ old("educations.$i.degree", $edu->degree) }}">
                        </div>
                        <div class="input-group">
                            <label>Рік початку</label>
                            <input type="text" name="educations[{{ $i }}][start_year]" value="{{ old("educations.$i.start_year", $edu->start_year) }}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="input-group">
                            <label>Рік завершення</label>
                            <input type="text" name="educations[{{ $i }}][end_year]" value="{{ old("educations.$i.end_year", $edu->end_year) }}">
                        </div>
                    </div>

                    {{-- 🎓 Нові поля для фото дипломів --}}
                    <div class="form-row">
                        <div class="input-group">
                            <label>Диплом 1</label>
                            <input type="file" name="educations[{{ $i }}][diploma_photo_1]">
                            @if($edu->diploma_photo_1)
                                <p>Поточне: <a href="{{ asset('storage/' . $edu->diploma_photo_1) }}" target="_blank">Переглянути</a></p>
                            @endif
                        </div>
                        <div class="input-group">
                            <label>Диплом 2</label>
                            <input type="file" name="educations[{{ $i }}][diploma_photo_2]">
                            @if($edu->diploma_photo_2)
                                <p>Поточне: <a href="{{ asset('storage/' . $edu->diploma_photo_2) }}" target="_blank">Переглянути</a></p>
                            @endif
                        </div>
                        <div class="input-group">
                            <label>Диплом 3</label>
                            <input type="file" name="educations[{{ $i }}][diploma_photo_3]">
                            @if($edu->diploma_photo_3)
                                <p>Поточне: <a href="{{ asset('storage/' . $edu->diploma_photo_3) }}" target="_blank">Переглянути</a></p>
                            @endif
                        </div>
                    </div>

                    <hr>
                @endforeach
            </div>

            <!-- Місце роботи -->
            <div class="section-block workplace-block">
                <h4>Місце роботи</h4>
                <div class="form-row">
                    <div class="input-group">
                        <label>Назва закладу</label>
                        <input type="text" name="place_of_work[workplace]" value="{{ old('place_of_work.workplace', $doctor->placeOfWork->workplace ?? '') }}">
                    </div>
                    <div class="input-group">
                        <label>Посада</label>
                        <input type="text" name="place_of_work[position]" value="{{ old('place_of_work.position', $doctor->placeOfWork->position ?? '') }}">
                    </div>
                    <div class="input-group">
                        <label>Країна</label>
                        <input type="text" name="place_of_work[country_of_residence]" value="{{ old('place_of_work.country_of_residence', $doctor->placeOfWork->country_of_residence ?? '') }}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="input-group">
                        <label>Місто</label>
                        <input type="text" name="place_of_work[city_of_residence]" value="{{ old('place_of_work.city_of_residence', $doctor->placeOfWork->city_of_residence ?? '') }}">
                    </div>
                </div>
            </div>

            <button type="submit">Зберегти зміни</button>
        </div>

    </div>
</form>
@endsection
