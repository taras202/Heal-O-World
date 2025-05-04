@extends('layout.admin')

@section('title', 'Аналітика консультацій лікарів')

@section('content')
<h2 class="mt-5 text-center">Аналітика консультацій лікарів</h2>

<div class="mb-3">
    <a href="{{ route('admin.doctors.index') }}" class="btn btn-primary float-start">Повернутися до списку лікарів</a>
</div>
<div style="margin-bottom: 80px;"></div>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Лікар</th>
            <th>Кількість консультацій</th>
            <th>Унікальних пацієнтів</th>
            <th>Середній рейтинг</th>
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
                <td>{{ $averageRating ? number_format($averageRating, 1) : '—' }}</td>
                <td>{{ $averageDuration ? number_format($averageDuration, 1) : '—' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<form method="GET" action="{{ route('admin.doctors.analytics') }}" class="mb-4">
    <div class="row">
        <div class="col-md-4">
            <label for="doctor_id">Оберіть лікаря</label>
            <select name="doctor_id" id="doctor_id" class="form-control">
                <option value="">Всі лікарі</option>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}" {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>
                        {{ $doctor->first_name }} {{ $doctor->last_name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary me-2">Застосувати</button>
            <a href="{{ route('admin.doctors.analytics') }}" class="btn btn-secondary">Зняти фільтр</a>
        </div>
    </div>
</form>

<canvas id="doctorConsultationChart" height="100"></canvas>

<canvas id="doctorRatingChart" height="100"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctxConsultation = document.getElementById('doctorConsultationChart').getContext('2d');
    const consultationChart = new Chart(ctxConsultation, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_values(array_unique($doctorChartLabels))) !!},
            datasets: {!! json_encode($doctorChartDatasets) !!}
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Кількість консультацій по місяцях'
                }
            },
        }
    });

    const ctxRating = document.getElementById('doctorRatingChart').getContext('2d');
    const ratingChart = new Chart(ctxRating, {
    type: 'line',
    data: {
        labels: {!! json_encode(array_values(array_unique($doctorChartLabels))) !!},
        datasets: {!! json_encode($doctorChartRatingDatasets) !!}  
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Середній рейтинг лікарів по місяцях'
            }
        },
    }
});
</script>
@endsection
