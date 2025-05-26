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

    .doctor-info-container {
        display: flex;
        justify-content: space-between;
        gap: 2rem;
        border: 1px solid black;
        border-radius: 1rem;
        padding: 1.5rem;
        background-color: #f8fcff;
    }

    .doctor-left {
        flex: 1;
    }

    .doctor-right {
        width: 600px;
        flex-shrink: 0;
        background-color: #fff;
        padding: 1rem;
        border-radius: 1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    .doctor-right img {
        border: 1px solid #ccc;
        border-radius: 0.5rem;
    }
    .reviews-section {
    margin-top: 3rem;
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
    }

    .review-block {
        background-color: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 1rem;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .review-author {
        font-size: 1.125rem;
        font-weight: bold;
        color: #2d3748;
    }

    .review-rating {
        color: #f6ad55;
        font-size: 0.95rem;
        font-weight: 600;
    }

    .review-comment {
        color: #4a5568;
        line-height: 1.6;
        font-size: 1rem;
    }

    .review-date {
        margin-top: 0.5rem;
        font-size: 0.85rem;
        color: #a0aec0;
    }
</style>

<div class="doctor-profile-wrapper">
    <div class="doctor-info-container">
        {{-- Ліва колонка --}}
        <div class="doctor-left">
            {{-- Фото --}}
            <div style="margin-bottom: 1rem;">
                @if ($doctor->photo)
                    <img src="{{ asset('storage/' . $doctor->photo) }}" alt="Фото"
                         class="w-16 h-16 object-cover rounded-lg">
                @else
                    <span class="text-gray-500">Немає фото</span>
                @endif
            </div>

            {{-- Основна інфа --}}
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
                    {{ $doctor->timeZone->time_zone ?? 'Не вказано' }}</p>

                <p><strong>Контакт:</strong> {{ $doctor->contact ?? 'Не вказано' }}</p>
            </ul>

            {{-- Вкладки --}}
            <div class="tabs mt-6">
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
                    @foreach($doctor->educations as $edu)
                        <div class="mb-4">
                            <p><strong>Заклад:</strong> {{ $edu->institution }}</p>
                            <p><strong>Ступінь:</strong> {{ $edu->degree }}</p>
                            <p><strong>Роки:</strong> {{ $edu->start_year }} – {{ $edu->end_year ?? 'тепер' }}</p>
                            <div class="flex gap-2 mt-2">
                                @foreach (['diploma_photo_1', 'diploma_photo_2', 'diploma_photo_3'] as $field)
                                    @if (!empty($edu->$field))
                                        <img src="{{ asset('storage/' . $edu->$field) }}" alt="Диплом" width="48" height="48" class="rounded shadow-sm">
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>Інформація про освіту відсутня</p>
                @endif
            </div>
        </div>

        {{-- Права колонка --}}
        <div class="doctor-right">
            <x-appointment-form :doctor="$doctor" />
        </div>
    </div>
</div>

{{-- Відгуки --}}
<div class="reviews-section">
    <h2 style="font-size: 1.75rem; font-weight: bold; margin-bottom: 1rem; color: #2c5282;">
        Відгуки пацієнтів
    </h2>

    @forelse($doctor->reviews as $review)
        <div class="review-block">
            <div class="review-header">
                <div class="review-author">{{ $review->user->name ?? 'Анонім' }}</div>
                <div class="review-rating">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $review->rating)
                            ★
                        @else
                            ☆
                        @endif
                    @endfor
                    <span style="color: #718096; margin-left: 0.25rem;">({{ $review->rating }}/5)</span>
                </div>
            </div>
            <div class="review-comment">
                {{ $review->comment }}
            </div>
            <div class="review-date">
                {{ $review->created_at->translatedFormat('d M Y, H:i') }}
            </div>
        </div>
    @empty
        <div style="color: #718096; font-style: italic;">Ще немає відгуків від пацієнтів.</div>
    @endforelse
</div>

{{-- JavaScript для вкладок --}}
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
