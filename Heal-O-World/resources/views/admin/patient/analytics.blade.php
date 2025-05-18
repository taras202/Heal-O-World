@extends('layout.admin')

@section('title', 'Аналітика консультацій пацієнтів')

@section('content')
<h2 class="mt-5 text-center">Аналітика консультацій пацієнтів</h2>

<div class="row text-center my-4">
    <div class="col-md-3">
        <div class="card shadow-sm bg-primary text-black">
            <div class="card-body">
                <h6 class="card-title">Пацієнтів</h6>
                <h3>{{ $totalPatients }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm bg-info text-black">
            <div class="card-body">
                <h6 class="card-title">Консультацій</h6>
                <h3>{{ $totalConsultations }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm bg-warning text-black">
            <div class="card-body">
                <h6 class="card-title">Середня тривалість (хв)</h6>
                <h3>{{ $averageDuration ? number_format($averageDuration, 1) : '—' }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm bg-danger text-black">
            <div class="card-body">
                <h6 class="card-title">Середній рейтинг</h6>
                <h3>{{ is_numeric($averageRating) ? number_format($averageRating, 1) : '—' }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="mb-3">
    <a href="{{ route('admin.patients.index') }}" class="btn btn-primary float-start">Повернутися до списку пацієнтів</a>
</div>
<div style="margin-bottom: 80px;"></div>

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

        <div class="col-md-3">
            <label for="year">Оберіть рік</label>
            <select name="year" id="year" class="form-control">
                <option value="">Всі роки</option>
                @foreach($years as $year)
                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label for="month">Оберіть місяць</label>
            <select name="month" id="month" class="form-control">
                <option value="">Всі місяці</option>
                @foreach(range(1, 12) as $month)
                    <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4 mt-4">
            <button type="submit" class="btn btn-primary">Застосувати</button>
            <a href="{{ route('admin.patients.analytics') }}" class="btn btn-secondary">Скинути фільтри</a>
        </div>
    </div>
</form>

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
                $ratings = $consultations->pluck('rating')->filter(fn($r) => is_numeric($r))->map(fn($r) => (float)$r);
                $averageRating = $ratings->isNotEmpty() ? $ratings->avg() : null;
                $durations = $consultations->pluck('duration_minutes')->filter(fn($d) => is_numeric($d));
                $averageDuration = $durations->isNotEmpty() ? $durations->avg() : null;
            @endphp
            <tr>
                <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                <td>{{ $consultations->count() }}</td>
                <td>{{ $uniqueDoctors }}</td>
                <td>{{ is_numeric($averageRating) ? number_format($averageRating, 1) : '—' }}</td>
                <td>{{ $averageDuration ? number_format($averageDuration, 1) : '—' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

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
        plugins: {
            title: {
                display: true,
                text: 'Кількість консультацій пацієнтів по місяцях'
            },
            legend: {
                labels: {
                    fontColor: 'rgb(0, 123, 255)',
                }
            }
        },
        elements: {
            line: {
                tension: 0.4,
                borderWidth: 3
            },
            point: {
                radius: 5
            }
        },
    }
});
</script>

@endsection
