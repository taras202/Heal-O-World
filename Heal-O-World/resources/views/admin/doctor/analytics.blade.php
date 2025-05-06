@extends('layout.admin')

@section('title', 'Аналітика консультацій лікарів')

@section('content')
<h2 class="mt-5 text-center">Аналітика консультацій лікарів</h2>

<div class="row text-center my-4">
    <div class="col-md-2">
        <div class="card shadow-sm bg-primary text-black">
            <div class="card-body">
                <h6 class="card-title">Пацієнтів</h6>
                <h3>{{ $totalPatients }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card shadow-sm bg-success text-black">
            <div class="card-body">
                <h6 class="card-title">Лікарів</h6>
                <h3>{{ $totalDoctors }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-2">
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
                <h3>{{ $averageRating ? number_format($averageRating, 1) : '—' }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="mb-3">
    <a href="{{ route('admin.doctors.index') }}" class="btn btn-primary float-start">Повернутися до списку лікарів</a>
</div>
    <div style="margin-bottom: 80px;"></div>

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
                    <a href="{{ route('admin.doctors.analytics') }}" class="btn btn-secondary">Скинути фільтри</a>
                </div>
            </div>
        </form>

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
                    $ratings = \App\Models\Review::whereIn('consultation_id', $consultations->pluck('id'))->pluck('rating');
                    $averageRating = $ratings->isNotEmpty() ? $ratings->avg() : null;
                    $averageDuration = $consultations->avg('consultation_time');
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

    <canvas id="doctorConsultationChart" height="100"></canvas>

    <canvas id="doctorRatingChart" height="100"></canvas>

    <canvas id="doctorConsultationBarChart" height="100"></canvas>

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

        const ctxConsultationBar = document.getElementById('doctorConsultationBarChart').getContext('2d');
        const consultationBarChart = new Chart(ctxConsultationBar, {
            type: 'bar',
            data: {
                labels: {!! json_encode($doctorNames) !!},
                datasets: [{
                    label: 'Кількість консультацій',
                    data: {!! json_encode($doctorConsultationCounts) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Кількість консультацій по лікарях'
                    },
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>

@endsection
