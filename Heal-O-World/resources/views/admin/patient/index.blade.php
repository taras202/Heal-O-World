@extends('layout.admin')

@section('title', 'Аналітика консультацій по пацієнтах')

@section('content')

<h2 class="mt-5 text-center">Аналітика консультацій пацієнтів</h2>


    <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Пацієнт</th>
                        <th>Кількість консультацій</th>
                        <th>Середня тривалість (хв)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($doctors as $doctor)
                        @php
                            $consultations = $doctor->consultations ?? collect();
                            $uniquePatients = $consultations->pluck('patient_id')->unique()->count();
                            $averageRating = $consultations->avg('rating');
                            $averageDuration = $consultations->avg('duration_minutes');
                        @endphp
                        <tr>
                            <td>{{ $doctor->first_name }} {{ $doctor->last_name }}</td>
                            <td>{{ $consultations->count() }}</td>
                            <td>{{ $uniquePatients }}</td>
                            <td>{{ number_format($averageRating, 1) ?? '—' }}</td>
                            <td>{{ number_format($averageDuration, 1) ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <form method="GET" action="{{ route('admin.patients.index') }}" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <label for="patient_name">Оберіть пацієнта</label>
                    <input type="text" name="patient_name" id="patient_name" class="form-control" value="{{ request('patient_name') }}" placeholder="Введіть ім’я пацієнта">
                </div>
                <div class="col-md-2 align-self-end">
                    <button type="submit" class="btn btn-primary">Застосувати</button>
                </div>
            </div>
        </form>

    
    <canvas id="patientConsultationChart" height="100"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    const ctx = document.getElementById('patientConsultationChart').getContext('2d');
    const patientChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_values(array_unique($patientChartLabels))) !!},
            datasets: {!! json_encode($patientChartDatasets) !!}
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
                    text: 'Кількість консультацій пацієнтів по місяцях'
                }
            },
        }
    });
    </script>

    <h2>Список пацієнтів</h2>

    <a href="{{ route('admin.patients.create') }}" class="btn btn-success mb-3">Додати пацієнта</a>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Фото</th>
                <th>Ім’я</th>
                <th>Прізвище</th>
                <th>Контакт</th>
                <th>Лікар</th>
                <th>Кількість консультацій</th>
                <th>Середній рейтинг</th>
                <th>Середня тривалість (хв)</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            @foreach($patients as $patient)
                @php
                    $consultations = $patient->consultations ?? collect();
                    $uniqueDoctors = $consultations->pluck('doctor_id')->unique()->count();
                    $averageRating = $consultations->avg('rating');
                    $averageDuration = $consultations->avg('duration_minutes');
                @endphp
                <tr>
                    <td>
                        <img src="{{ $patient->photo ? asset('storage/' . $patient->photo) : asset('images/default-avatar.png') }}"
                             alt="Фото" width="60" height="60" style="border-radius: 50%;">
                    </td>
                    <td>{{ $patient->first_name }}</td>
                    <td>{{ $patient->last_name }}</td>
                    <td>{{ $patient->contact }}</td>
                    <td>
                        @foreach($consultations as $consultation)
                            <strong>{{ $consultation->doctor->first_name }} {{ $consultation->doctor->last_name }}</strong><br>
                        @endforeach
                    </td>
                    <td>{{ $consultations->count() }}</td>
                    <td>{{ number_format($averageRating, 1) ?? '—' }}</td>
                    <td>{{ number_format($averageDuration, 1) ?? '—' }}</td>
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
