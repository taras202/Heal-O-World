@extends('layout.admin')

@section('title', 'Інформація про лікаря')

@section('content')
    <h2>Інформація про лікаря</h2>

    <form>

        <div class="mb-3">
            <label>Фото:</label><br>
            <img src="{{ $doctor->photo ? asset('storage/' . $doctor->photo) : asset('images/default-avatar.png') }}"
                 width="80" height="80" style="border-radius: 50%; margin-bottom: 10px;">
        </div>

        <div class="mb-3">
            <label for="first_name">Ім’я:</label>
            <input type="text" class="form-control" id="first_name" value="{{ $doctor->first_name }}" readonly>
        </div>

        <div class="mb-3">
            <label for="last_name">Прізвище:</label>
            <input type="text" class="form-control" id="last_name" value="{{ $doctor->last_name }}" readonly>
        </div>

        <div class="mb-3">
            <label for="email">Email:</label>
            <input type="text" class="form-control" id="email" value="{{ $doctor->user?->email }}" readonly>
            <input type="hidden" name="user_id" value="{{ $doctor->user_id }}">
        </div>

        <div class="mb-3">
            <label for="gender">Стать:</label>
            <input type="text" class="form-control" id="gender" value="{{ ucfirst($doctor->gender) }}" readonly>
        </div>

        <div class="mb-3">
            <label for="contact">Контакт:</label>
            <input type="text" class="form-control" id="contact" value="{{ $doctor->contact }}" readonly>
        </div>

        <div class="mb-3">
            <label for="time_zone">Часовий пояс:</label>
            <input type="text" class="form-control" id="time_zone" value="{{ $doctor->time_zone }}" readonly>
        </div>

        <div class="mb-3">
            <label for="bio">Біографія:</label>
            <textarea class="form-control" id="bio" rows="4" readonly>{{ $doctor->bio ?: 'Немає біографії' }}</textarea>
        </div>

        <hr>

        <h4>Спеціалізації</h4>
        @forelse($doctor->specialties as $specialty)
            <div class="mb-3">
                <label>Спеціалізація:</label>
                <input type="text" class="form-control mb-2" value="{{ $specialty->name }}" readonly>
                <input type="text" class="form-control mb-2" value="Досвід: {{ $specialty->pivot->experience }} років" readonly>
                <input type="text" class="form-control" value="Ціна: {{ $specialty->pivot->price }} грн" readonly>
            </div>
        @empty
            <p>Спеціалізації відсутні.</p>
        @endforelse

        <hr>

        <h4>Освіта</h4>
        @forelse($doctor->educations as $edu)
            <div class="mb-3">
                <label>Освіта:</label>
                <input type="text" class="form-control mb-2" value="{{ $edu->degree }} — {{ $edu->institution }}" readonly>
                <input type="text" class="form-control mb-2" value="Роки: {{ $edu->start_year }} - {{ $edu->end_year }}" readonly>

                @for($i = 1; $i <= 3; $i++)
                    @php $photo = "diploma_photo_$i"; @endphp
                    @if($edu->$photo)
                        <a href="{{ asset('storage/' . $edu->$photo) }}" target="_blank">Диплом {{ $i }}</a><br>
                    @endif
                @endfor
            </div>
        @empty
            <p>Інформація про освіту відсутня.</p>
        @endforelse

        <hr>

        <h4>Місце роботи</h4>
        @if($doctor->placeOfWork)
            <div class="mb-3">
                <label>Заклад:</label>
                <input type="text" class="form-control mb-2" value="{{ $doctor->placeOfWork->workplace }}" readonly>

                <label>Посада:</label>
                <input type="text" class="form-control mb-2" value="{{ $doctor->placeOfWork->position }}" readonly>

                <label>Місто:</label>
                <input type="text" class="form-control mb-2" value="{{ $doctor->placeOfWork->city_of_residence }}" readonly>

                <label>Країна:</label>
                <input type="text" class="form-control" value="{{ $doctor->placeOfWork->country_of_residence }}" readonly>
            </div>
        @else
            <p>Місце роботи не зазначено.</p>
        @endif

        <hr>

        <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary">Повернутись до списку лікарів</a>
    </form>
@endsection
