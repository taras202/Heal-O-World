@extends('layout.admin')

@section('title', 'Інформація про лікаря')

@section('content')
    <h2>Інформація про лікаря</h2>

    <div class="mb-4">
        <a href="{{ route('admin.doctors.index') }}" class="btn btn-secondary">Повернутись до списку лікарів</a>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <img src="{{ $doctor->photo ? asset('storage/' . $doctor->photo) : asset('images/default-avatar.png') }}"
                     alt="Фото" class="card-img-top" style="width: 100%; border-radius: 50%; height: 250px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">{{ $doctor->first_name }} {{ $doctor->last_name }}</h5>
                    
                    <div class="mb-3">
                        <label>email:</label>
                        <input type="text" class="form-control" value="{{ $doctor->user->email }}" readonly>
                        <input type="hidden" name="user_id" value="{{ $doctor->user_id }}">
                    </div>
 
                    <p class="card-text"><strong>Стать:</strong> {{ ucfirst($doctor->gender) }}</p>
                    <p class="card-text"><strong>Контакт:</strong> {{ $doctor->contact }}</p>
                    <p class="card-text"><strong>Часовий пояс:</strong> {{ $doctor->time_zone }}</p>
                    @if($doctor->bio)
                        <p class="card-text"><strong>Біографія:</strong> {{ $doctor->bio }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Спеціалізації</h5>
                    @foreach($doctor->specialties as $specialty)
                        <div class="mb-3">
                            <strong>{{ $specialty->name }}</strong><br>
                            <p>Досвід: {{ $specialty->pivot->experience }} років</p>
                            <p>Ціна: {{ $specialty->pivot->price }} грн</p>
                        </div>
                    @endforeach

                    <h5 class="card-title">Освіта</h5>
                    @foreach($doctor->educations as $edu)
                        <div class="mb-3">
                            <strong>{{ $edu->degree }} — {{ $edu->institution }}</strong><br>
                            <p>Роки: {{ $edu->start_year }} - {{ $edu->end_year }}</p>
                            <div>
                                @for($i = 1; $i <= 3; $i++)
                                    @php
                                        $photo = "diploma_photo_$i";
                                    @endphp
                                    @if($edu->$photo)
                                        <a href="{{ asset('storage/' . $edu->$photo) }}" target="_blank">Диплом {{ $i }}</a><br>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    @endforeach

                    <h5 class="card-title">Місце роботи</h5>
                    @if($doctor->placeOfWork)
                        <div class="mb-3">
                            <p><strong>Заклад:</strong> {{ $doctor->placeOfWork->workplace }}</p>
                            <p><strong>Посада:</strong> {{ $doctor->placeOfWork->position }}</p>
                            <p><strong>Місто:</strong> {{ $doctor->placeOfWork->city_of_residence }}</p>
                            <p><strong>Країна:</strong> {{ $doctor->placeOfWork->country_of_residence }}</p>
                        </div>
                    @else
                        <p>Місце роботи не зазначено.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
