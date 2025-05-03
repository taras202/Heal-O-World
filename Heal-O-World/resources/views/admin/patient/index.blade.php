@extends('layout.admin')

@section('title', 'Список пацієнтів')

@section('content')
    <h2>Аналітика пацієнтів</h2>

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
                <label>Лікар</label>
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

    <canvas id="consultationChart" height="100"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    const ctx = document.getElementById('consultationChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($monthsFormatted) !!},  
            datasets: [{
                label: 'Кількість консультацій по місяцях',
                data: {!! json_encode($consultationsData) !!},  
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Кількість консультацій по місяцях'
                    }
                }
            }
        }
    });
</script>

<h2>Список пацієнтів</h2>

    <a href="{{ route('admin.patients.create') }}" class="btn btn-success mb-3">Створити пацієнта</a>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Ім’я</th>
                <th>Прізвище</th>
                <th>Дата народження</th>
                <th>Стать</th>
                <th>Контакт</th>
                <th>Страхування</th>
                <th>Місце проживання</th>
                <th>Часовий пояс</th>
                <th>Вага</th>
                <th>Ріст</th>
                <th>Примітки</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            @foreach($patients as $patient)
                <tr>
                    <td>{{ $patient->first_name }}</td>
                    <td>{{ $patient->last_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($patient->date_of_birth)->format('d-m-Y') }}</td>
                    <td>{{ ucfirst($patient->gender) }}</td>
                    <td>{{ $patient->contact }}</td>
                    <td>{{ $patient->has_insurance ? 'Так' : 'Ні' }}</td>
                    <td>{{ $patient->city_of_residence }}, {{ $patient->country_of_residence }}</td>
                    <td>{{ $patient->time_zone }}</td>
                    <td>{{ $patient->weight }} кг</td>
                    <td>{{ $patient->height }} см</td>
                    <td>{{ $patient->notes }}</td>
                    <td>
                        <a href="{{ route('admin.patients.show', $patient) }}" class="btn btn-sm btn-info">Перегляд</a>
                        <a href="{{ route('admin.patients.edit', $patient) }}" class="btn btn-sm btn-primary">Редагувати</a>
                        <form action="{{ route('admin.patients.destroy', $patient) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Ви впевнені, що хочете видалити цього пацієнта?');">
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
