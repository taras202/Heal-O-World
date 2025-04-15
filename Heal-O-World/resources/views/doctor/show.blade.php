@extends('layout.menu')

@section('content')

<style>
    .doctor-profile-wrapper {
        border: 2px solid #e0e0e0;
        border-radius: 15px;
        padding: 2rem;
        max-width: 2500px;
        margin: 2rem auto;
        background-color: #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .doctor-info-container {
        display: flex;
        flex-wrap: nowrap;
        gap: 2rem;
    }

    .doctor-left {
        flex: 2;
        min-width: 300px;
        padding-right: 2rem;
    }

    .divider {
        width: 1px;
        background-color: #ccc;
        margin: 0 1rem;
    }

    .doctor-right {
        flex: 1.2;
        min-width: 300px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        padding: 1.5rem;
        border-radius: 10px;
        height: fit-content;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }

    .doctor-photo {
        width: 100%;
        max-width: 250px;
        border-radius: 10px;
    }

    .doctor-placeholder {
        width: 250px;
        height: 250px;
        background-color: #e0e0e0;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #555;
        font-size: 14px;
    }

    .specialties-list li {
        margin-bottom: 0.5rem;
    }

    .document-thumbnails {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 0.5rem;
    }

    .document-thumbnails img {
        width: 100px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .appointment-button {
        padding: 0.5rem 1rem;
        background-color:rgb(37, 79, 141);
        color: white;
        border-radius: 5px;
        text-decoration: none;
        display: inline-block;
    }

    .appointment-button:hover {
        background-color:rgb(37, 79, 141);
    }

    .no-appointments {
        margin-top: 1rem;
        color: red;
        text-align: center;
    }

    @media (max-width: 992px) {
        .doctor-info-container {
            flex-direction: column;
        }

        .divider {
            display: none;
        }
    }
</style>

<div class="doctor-profile-wrapper">
    <div class="doctor-info-container">

        {{-- Ліва колонка --}}
        <div class="doctor-left">
            {{-- Фото --}}
            <div style="margin-bottom: 1rem;">
                @if ($doctor->photo)
                    <img src="{{ asset('storage/' . $doctor->photo) }}" alt="{{ $doctor->first_name }}" class="doctor-photo">
                @else
                    <div class="doctor-placeholder">
                        немає фото
                    </div>
                @endif
            </div>

            {{-- Інформація --}}
            <h2>{{ $doctor->last_name }} {{ $doctor->first_name }}</h2>
            <p><strong>Рейтинг:</strong> ⭐ {{ number_format($doctor->rating, 2) }} ({{ $doctor->reviews_count }} відгуків)</p>

            {{-- Спеціальності --}}
            <ul class="specialties-list">
                @foreach($doctor->specialties as $specialty)
                    <li>
                        <strong>{{ $specialty->name }}</strong>
                        @if(!empty($specialty->pivot->experience) || !empty($specialty->pivot->price))
                            — 
                            @if(!empty($specialty->pivot->experience))
                                {{ $specialty->pivot->experience }}
                            @endif
                            @if(!empty($specialty->pivot->price))
                                {{ !empty($specialty->pivot->experience) ? ',' : '' }} {{ $specialty->pivot->price }} грн
                            @endif
                        @endif
                    </li>
                @endforeach
            </ul>

            {{-- Документи --}}
            @if($doctor->documents && count($doctor->documents))
                <p><strong>Фото дипломів / сертифікатів:</strong></p>
                <div class="document-thumbnails">
                    @foreach($doctor->documents as $doc)
                        <img src="{{ asset('storage/' . $doc) }}" alt="Документ">
                    @endforeach
                </div>
            @endif

            {{-- Детальна інформація --}}
            <div style="margin-top: 1.5rem;">
                <p><strong>Країна:</strong> {{ $doctor->country_of_residence }}</p>
                <p><strong>Місто:</strong> {{ $doctor->city_of_residence }}</p>
                <p><strong>Місце роботи:</strong> {{ $doctor->workplace ?? 'Приватна практика' }}</p>
                <p><strong>Посада:</strong> {{ $doctor->position ?? 'Психолог' }}</p>
                <p><strong>Володіння мовами:</strong> {{ $doctor->languages ?? 'RU, UK' }}</p>
                <p><strong>Контакт:</strong> {{ $doctor->contact ?? 'Немає' }}</p>
            </div>
        </div>

        {{-- Вертикальна лінія між блоками --}}
        <div class="divider"></div>

        {{-- Права колонка — запис на консультацію --}}
        <div class="doctor-right">
            <h4>Запис на online консультацію</h4>

            {{--
            @if(isset($available_dates) && count($available_dates)) 
                <div style="display: flex; gap: 1rem; flex-wrap: wrap; margin-top: 1rem;">
                    @foreach($available_dates as $date)
                        <a href="{{ route('appointments.create', ['doctor' => $doctor->id, 'date' => $date]) }}" class="appointment-button">
                            {{ \Carbon\Carbon::parse($date)->translatedFormat('D d M') }}
                        </a>
                    @endforeach
                </div>
            @else
                <div class="no-appointments">
                    На обрану дату запис недоступний
                </div>
            @endif
            --}}
        </div>
    </div>
</div>

@endsection
