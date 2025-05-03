@extends('layout.admin')

@section('title', 'Список лікарів')

@section('content')
    
    <h2>Аналітика консультацій по лікарях</h2>

    <form method="GET" action="{{ route('admin.patients.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-2">
                <label>Вік від</label>
                <input type="number" name="age_from" class="form-control" value="{{ request('age_from') }}">
            </div>
            <div class="col-md-2">
                <label>Вік до</label>
                <input type="number" name="age_to" class="form-control" value="{{ request('age_to') }}">
            </div>
            <div class="col-md-2">
                <label>Стать</label>
                <select name="gender" class="form-control">
                    <option value="">Всі</option>
                    <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Чоловік</option>
                    <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Жінка</option>
                </select>
            </div>
            <div class="col-md-3">
                <label>Пацієнт</label>
                <select name="doctor_id" class="form-control">
                    <option value="">Всі</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->first_name }} {{ $doctor->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label>Пошук</label><br>
                <button type="submit" class="btn btn-primary mt-2">Застосувати</button>
            </div>
        </div>
    </form>
<canvas id="doctorConsultationChart" height="100"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('doctorConsultationChart').getContext('2d');

    const doctorChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_values(array_unique($doctorChartLabels))) !!},
            datasets: {!! json_encode($doctorChartDatasets) !!}
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            stacked: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Кількість консультацій по місяцях'
                }
            },
            
        }
    });
</script>

<h2>Список лікарів</h2>

    <a href="{{ route('admin.doctors.create') }}" class="btn btn-success mb-3">Створити лікаря</a>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Фото</th>
                <th>Ім’я</th>
                <th>Прізвище</th>
                <th>Стать</th>
                <th>Контакт</th>
                <th>Часовий пояс</th>
                <th>Спеціалізації</th>
                <th>Освіта</th>
                <th>Місце роботи</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            @foreach($doctors as $doctor)
                <tr>
                    <td>
                        <img src="{{ $doctor->photo ? asset('storage/' . $doctor->photo) : asset('images/default-avatar.png') }}"
                             alt="Фото" width="60" height="60" style="border-radius: 50%;">
                    </td>
                    <td>{{ $doctor->first_name }}</td>
                    <td>{{ $doctor->last_name }}</td>
                    <td>{{ $doctor->gender }}</td>
                    <td>{{ $doctor->contact }}</td>
                    <td>{{ $doctor->time_zone }}</td>
                    <td>
                        @foreach($doctor->specialties as $specialty)
                            <strong>{{ $specialty->name }}</strong><br>
                            Досвід: {{ $specialty->pivot->experience }} років<br>
                            Ціна: {{ $specialty->pivot->price }} грн<br><br>
                        @endforeach
                    </td>
                    <td>
                        @foreach($doctor->educations as $edu)
                            {{ $edu->degree }} — {{ $edu->institution }}<br>
                            ({{ $edu->start_year }} - {{ $edu->end_year }})<br><br>
                        @endforeach
                    </td>
                    <td>
                        @if($doctor->placeOfWork)
                            {{ $doctor->placeOfWork->workplace }}<br>
                            {{ $doctor->placeOfWork->position }}<br>
                            {{ $doctor->placeOfWork->city_of_residence }}, {{ $doctor->placeOfWork->country_of_residence }}
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.doctors.show', $doctor) }}" class="btn btn-sm btn-info">Перегляд</a>
                        
                        <a href="{{ route('admin.doctors.edit', $doctor) }}" class="btn btn-sm btn-primary">Редагувати</a>

                        <form action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Ви впевнені, що хочете видалити цього лікаря?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Видалити</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
