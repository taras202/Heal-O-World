@extends('layout.menu-consultation-doctor')

@section('title', 'Редагування профілю лікаря')

@section('content')
<style>
    .profile-container {
        display: grid;
        grid-template-columns: 1fr 3fr;
        gap: 30px;
        font-family: 'Segoe UI', sans-serif;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .profile-sidebar {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .profile-sidebar img {
        width: 130px;
        height: 130px;
        object-fit: cover;
        border-radius: 50%;
        margin-bottom: 15px;
        border: 3px solid #28a745;
    }

    .profile-main {
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    h1 {
        text-align: center;
        font-size: 26px;
        margin-bottom: 30px;
        color: #2d3436;
    }

    label {
        display: block;
        margin-top: 12px;
        font-weight: 600;
    }

    input, select, textarea {
        width: 100%;
        padding: 12px;
        margin-top: 6px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 15px;
        background-color: #f8f8f8;
    }

    button[type="submit"] {
        margin-top: 25px;
        background-color: #28a745;
        color: #fff;
        padding: 14px;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    button[type="submit"]:hover {
        background-color: #218838;
    }

    .section-block {
        margin-bottom: 30px;
    }

    .section-block hr {
        margin-top: 15px;
    }

    .specialty-block,
    .education-block,
    .workplace-block {
        margin-top: 15px;
        padding: 15px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
    }

    .specialty-block h4,
    .education-block h4,
    .workplace-block h4 {
        margin-bottom: 10px;
        font-size: 18px;
        color: #333;
    }

    .specialty-block input,
    .education-block input,
    .workplace-block input {
        margin-top: 8px;
    }

    @media (max-width: 768px) {
        .profile-container {
            grid-template-columns: 1fr;
        }

        .profile-sidebar, .profile-main {
            width: 100%;
        }
    }
</style>

<h1>Редагування профілю лікаря</h1>

<form action="{{ route('doctor.profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="profile-container">
        {{-- Sidebar: Фото профілю --}}
        <div class="profile-sidebar">
            <img src="{{ $doctor->photo ? asset('storage/' . $doctor->photo) : asset('images/default-avatar.png') }}" alt="Фото профілю">
            <label for="photo">Завантажити нове фото:</label>
            <input type="file" name="photo" accept="image/*">
        </div>

        {{-- Main Form --}}
        <div class="profile-main">

            <div class="section-block">
                <label>Ім’я</label>
                <input type="text" name="first_name" value="{{ $doctor->first_name }}">

                <label>Прізвище</label>
                <input type="text" name="last_name" value="{{ $doctor->last_name }}">

                <label>Біографія</label>
                <textarea name="bio" rows="3">{{ $doctor->bio }}</textarea>

                <label>Стать</label>
                <select name="gender">
                    <option value="male" {{ $doctor->gender == 'male' ? 'selected' : '' }}>Чоловік</option>
                    <option value="female" {{ $doctor->gender == 'female' ? 'selected' : '' }}>Жінка</option>
                    <option value="other" {{ $doctor->gender == 'other' ? 'selected' : '' }}>Інше</option>
                </select>

                <label>Контакт</label>
                <input type="text" name="contact" value="{{ $doctor->contact }}">

                <label>Часовий пояс</label>
                <input type="text" name="time_zone" value="{{ $doctor->time_zone }}">
            </div>

            <div class="section-block specialty-block">
                <h4>Спеціалізації</h4>
                @foreach($doctor->specialties as $index => $specialty)
                    <input type="hidden" name="specialties[{{ $index }}][id]" value="{{ $specialty->id }}">
                    <label>Спеціальність: <strong>{{ $specialty->name }}</strong></label>
                    <label>Досвід (роки)</label>
                    <input type="number" name="specialties[{{ $index }}][experience]" value="{{ $specialty->pivot->experience }}">
                    <label>Ціна (грн)</label>
                    <input type="number" name="specialties[{{ $index }}][price]" value="{{ $specialty->pivot->price }}">
                    <hr>
                @endforeach
            </div>

            <div class="section-block education-block">
                <h4>Освіта</h4>
                @foreach($doctor->educations as $i => $edu)
                    <input type="hidden" name="educations[{{ $i }}][id]" value="{{ $edu->id }}">
                    <label>Заклад</label>
                    <input type="text" name="educations[{{ $i }}][institution]" value="{{ $edu->institution }}">
                    <label>Ступінь</label>
                    <input type="text" name="educations[{{ $i }}][degree]" value="{{ $edu->degree }}">
                    <label>Рік початку</label>
                    <input type="text" name="educations[{{ $i }}][start_year]" value="{{ $edu->start_year }}">
                    <label>Рік завершення</label>
                    <input type="text" name="educations[{{ $i }}][end_year]" value="{{ $edu->end_year }}">
                    <hr>
                @endforeach
            </div>

            <div class="section-block workplace-block">
                <h4>Місце роботи</h4>
                <label>Назва закладу</label>
                <input type="text" name="place_of_work[workplace]" value="{{ $doctor->placeOfWork->workplace ?? '' }}">
                <label>Посада</label>
                <input type="text" name="place_of_work[position]" value="{{ $doctor->placeOfWork->position ?? '' }}">
                <label>Країна</label>
                <input type="text" name="place_of_work[country_of_residence]" value="{{ $doctor->placeOfWork->country_of_residence ?? '' }}">
                <label>Місто</label>
                <input type="text" name="place_of_work[city_of_residence]" value="{{ $doctor->placeOfWork->city_of_residence ?? '' }}">
            </div>

            <button type="submit">Зберегти зміни</button>
        </div>
    </div>
</form>
@endsection
