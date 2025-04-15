<div class="doctor-card">
    <div class="doctor-info">
        @if ($doctor->photo)
            <img src="{{ asset('storage/' . $doctor->photo) }}" alt="{{ $doctor->first_name }}">
        @else
            <div style="width: 100px; height: 100px; display: flex; justify-content: center; align-items: center; background-color: #e0e0e0; border-radius: 10px; font-size: 0.9rem; color: #555;">
                немає фото
            </div>
        @endif

        <div class="doctor-details">
            <h4>{{ $doctor->first_name }} {{ $doctor->last_name }}</h4>

            @if($doctor->specialties->count())
                <p><strong>Спеціальності:</strong></p>
                <ul>
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
            @endif

            <p><strong>Місто:</strong> {{ $doctor->city_of_residence }}</p>
            <p><strong>Країна:</strong> {{ $doctor->country_of_residence }}</p>
            <p>{{ $doctor->bio }}</p>
            <p><strong>Контакт:</strong> {{ $doctor->contact ?? 'Немає' }}</p>

            <a href="{{ route('doctor.show', ['id' => $doctor->id]) }}" 
               style="margin-top: 10px; display: inline-block; background-color:rgb(37, 79, 141); color: white; padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none;">
                Показати повністю
            </a>
        </div>
    </div>

    <div class="schedule">
        <h5>Запис на онлайн консультацію</h5>
        <div class="schedule-times">
            <button>10:00</button>
            <button>11:00</button>
            <button>13:00</button>
            <button>15:00</button>
            <button>17:00</button>
        </div>
    </div>
</div>
