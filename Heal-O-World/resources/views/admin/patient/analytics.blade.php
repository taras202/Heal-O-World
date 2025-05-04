@extends('layout.admin')

@section('title', 'Аналітика консультацій по пацієнтах')

@section('content')

<h2 class="mt-5 text-center">Аналітика консультацій пацієнтів</h2>

<div class="mb-3">
    <a href="{{ route('admin.patients.index') }}" class="btn btn-primary float-start">Повернутися до списку пацієнтів</a>
</div>

<div style="margin-bottom: 80px;"></div>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Пацієнт</th>
            <th>Кількість консультацій</th>
            <th>Кількість унікальних лікарів</th>
            <th>Середній рейтинг</th>
            <th>Середня тривалість (хв)</th>
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
                <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                <td>{{ $consultations->count() }}</td>
                <td>{{ $uniqueDoctors }}</td>
                <td>{{ $averageRating ? number_format($averageRating, 1) : '—' }}</td>
                <td>{{ $averageDuration ? number_format($averageDuration, 1) : '—' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<form method="GET" action="{{ route('admin.patients.analytics') }}" class="mb-4">
    <div class="row">
        <div class="col-md-4">
            <label for="patient_id">Оберіть пацієнта</label>
            <select name="patient_id" id="patient_id" class="form-control">
                <option value="">Всі пацієнти</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}" {{ request('patient_id') == $patient->id ? 'selected' : '' }}>
                        {{ $patient->first_name }} {{ $patient->last_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary me-2">Застосувати</button>
            <a href="{{ route('admin.patients.analytics') }}" class="btn btn-secondary">Зняти фільтр</a>
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

@endsection
