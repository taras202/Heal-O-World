@extends('layout.admin')

@section('title', 'Аналітика пацієнтів')

@section('content')
    <h2>Аналітика пацієнтів</h2>

    <div class="row">
        <!-- Загальна кількість пацієнтів -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5>Загальна кількість пацієнтів</h5>
                </div>
                <div class="card-body">
                    <h2>{{ $totalPatients ?? 'Немає даних' }}</h2>
                </div>
            </div>
        </div>

        <!-- Пацієнти з медичним страхуванням -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5>Пацієнти з медичним страхуванням</h5>
                </div>
                <div class="card-body">
                    <h2>{{ $insuredPatients ?? 'Немає даних' }}</h2>
                </div>
            </div>
        </div>

        <!-- Пацієнти по статі -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5>Пацієнти по статі</h5>
                </div>
                <div class="card-body">
                    <ul>
                        <li>Чоловіків: {{ $malePatients ?? 'Немає даних' }}</li>
                        <li>Жінок: {{ $femalePatients ?? 'Немає даних' }}</li>
                        <li>Інші: {{ $otherPatients ?? 'Немає даних' }}</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Пацієнти за віковими групами -->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-white">
                    <h5>Пацієнти за віковими групами</h5>
                </div>
                <div class="card-body">
                    <ul>
                        <li>0-18 років: {{ $ageGroupUnder18 ?? 'Немає даних' }}</li>
                        <li>19-40 років: {{ $ageGroup19to40 ?? 'Немає даних' }}</li>
                        <li>41-60 років: {{ $ageGroup41to60 ?? 'Немає даних' }}</li>
                        <li>60+: {{ $ageGroupOver60 ?? 'Немає даних' }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <!-- Графік за кількістю консультацій -->
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5>Графік за кількістю консультацій по місяцях</h5>
                </div>
                <div class="card-body">
                    <canvas id="consultationChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <!-- Список пацієнтів з останніми консультаціями -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5>Список пацієнтів з останніми консультаціями</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Ім'я</th>
                                <th>Прізвище</th>
                                <th>Стать</th>
                                <th>Контакт</th>
                                <th>Остання консультація</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($patientsWithConsultations as $patient)
                                <tr>
                                    <td>{{ $patient->first_name }}</td>
                                    <td>{{ $patient->last_name }}</td>
                                    <td>{{ $patient->gender }}</td>
                                    <td>{{ $patient->contact }}</td>
                                    <td>{{ $patient->consultations->last()->created_at->format('d-m-Y') ?? 'Немає консультацій' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Немає пацієнтів з консультаціями</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('consultationChart').getContext('2d');
        var consultationChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($months) !!},  
                datasets: [{
                    label: 'Кількість консультацій',
                    data: {!! json_encode($consultationsData) !!}, 
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
            }
        }
    }
});
    </script>

@endsection
