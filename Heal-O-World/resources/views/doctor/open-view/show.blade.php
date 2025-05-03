@extends('layout.menu')

@section('content')

<style>
    .tabs {
        display: flex;
        border-bottom: 2px solid #ccc;
        margin-bottom: 2rem;
    }

    .tab {
        padding: 1rem;
        cursor: pointer;
        border-bottom: 3px solid transparent;
        transition: border-color 0.3s;
        font-weight: bold;
    }

    .tab.active {
        border-color: #254f8d;
        color: #254f8d;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }
    .doctor-right button:hover {
    background-color: #d0e2ff;
    }
    .doctor-info-container {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 2rem;
    margin-bottom: 2rem;
    border: 1px solid black; 
    border-radius: 1rem;      
    padding: 1.5rem;          
    background-color: #f8fcff; 
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); 
    }

    .doctor-left {
        flex: 1;
    }

    .doctor-right {
        width: 320px;
        flex-shrink: 0;
    }

    .divider {
        width: 2px;
        background-color: #ddd;
        margin: 0 1rem;
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
                <p><strong>Часовий пояс:</strong>
                    @if(isset($doctor->time_zone))
                        UTC{{ $doctor->time_zone >= 0 ? '+' : '' }}{{ $doctor->time_zone }}
                    @else
                        Не вказано
                    @endif
                </p>
                <p><strong>Контакт:</strong> {{ $doctor->contact ?? 'Не вказано' }}</p>
            </ul>
        </div>

        {{-- Вертикальна лінія --}}
        <div class="divider"></div>

        {{-- Права колонка --}}
        <div class="doctor-right">
            <x-appointment-form :doctor="$doctor" />
        </div>
    </div>

    {{-- Вкладки --}}
    <div class="tabs">
        <div class="tab active" data-tab="workplace">Місце роботи</div>
        <div class="tab" data-tab="additional">Додаткова інформація</div>
        <div class="tab" data-tab="education">Освіта</div>
    </div>

    {{-- Вміст вкладок --}}
    <div class="tab-content active" id="workplace">
        <h3 class="text-xl font-semibold mb-4">Місце роботи</h3>
        @if($doctor->placeOfWork)
            <p><strong>Країна:</strong> {{ $doctor->placeOfWork->country_of_residence }}</p>
            <p><strong>Місто:</strong> {{ $doctor->placeOfWork->city_of_residence }}</p>
            <p><strong>Поточне місце роботи:</strong> {{ $doctor->placeOfWork->workplace }}</p>
            <p><strong>Посада:</strong> {{ $doctor->placeOfWork->position }}</p>
            <p><strong>Володіння мовами:</strong> {{ $doctor->languages ?? 'Не вказано' }}</p>
        @else
            <p>Інформація про місце роботи відсутня</p>
        @endif
    </div>

    <div class="tab-content" id="additional">
        <h3 class="text-xl font-semibold mb-4">Додаткова інформація</h3>
        <p><strong>Про себе:</strong> {{ $doctor->bio ?? 'Не вказано' }}</p>
    </div>

    <div class="tab-content" id="education">
    <h3 class="text-xl font-semibold mb-4">Освіта</h3>

        @if($doctor->educations->isNotEmpty())
            <ul class="list-disc list-inside space-y-6">
                @foreach($doctor->educations as $edu)
                    <li>
                        <p><strong>Навчальний заклад:</strong> {{ $edu->institution }}</p>
                        <p><strong>Ступінь:</strong> {{ $edu->degree }}</p>
                        <p><strong>Роки навчання:</strong> {{ $edu->start_year }}–{{ $edu->end_year ?? 'т.ч.' }}</p>

                        {{-- Дипломи --}}
                        <div class="flex flex-wrap gap-4 mt-2">
                            @foreach (['diploma_photo_1', 'diploma_photo_2', 'diploma_photo_3'] as $diplomaField)
                                @if(!empty($edu->$diplomaField))
                                    <div class="w-32 h-32 overflow-hidden rounded-md shadow-md border">
                                        <img src="{{ asset('storage/' . $edu->$diplomaField) }}" alt="Диплом" class="w-full h-full object-cover">
                                    </div>
                                @endif
                            @endforeach
                        </div>

                    </li>
                @endforeach
            </ul>
        @else
            <p>Інформація про освіту відсутня</p>
        @endif
    </div>

</div>

{{-- Невеликий скрипт для перемикання вкладок --}}
<script>
    const tabs = document.querySelectorAll('.tab');
    const contents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(item => item.classList.remove('active'));
            tab.classList.add('active');

            contents.forEach(content => {
                content.classList.remove('active');
                if (content.id === tab.dataset.tab) {
                    content.classList.add('active');
                }
            });
        });
    });
</script>

@endsection
