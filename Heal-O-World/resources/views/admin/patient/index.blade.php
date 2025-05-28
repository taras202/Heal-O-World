@extends('layout.admin')

@section('title', 'Список пацієнтів')

@section('content')
    <h2 class="mt-5 text-center">СПИСОК ПАЦІЄНТІВ</h2>

        <a href="{{ route('admin.patients.create') }}" class="btn btn-success mb-3">Додати пацієнта</a>
        <a href="{{ route('admin.patients.analytics') }}" class="btn btn-info mb-3">Переглянути аналітику</a>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Фото</th>
                    <th>Ім’я</th>
                    <th>Прізвище</th>
                    <th>Контакт</th>
                    <th>Лікар(і)</th>
                    <th>К-сть консультацій</th>
                    <th>Середній рейтинг</th>
                    <th>Середня тривалість (хв)</th>
                    <th>Дії</th>
                </tr>
            </thead>
            <tbody>
                @foreach($patients as $patient)
                    @php
                        $consultations = $patient->consultations ?? collect();
                        $averageRating = $consultations->avg('rating');
                        $averageDuration = $consultations->avg('duration_minutes');
                        $doctorNames = $consultations->pluck('doctor')->filter()->unique('id')->map(fn($d) => $d->first_name . ' ' . $d->last_name)->implode(', ');
                    @endphp
                    <tr>
                        <td>{{ $patient->id }}</td>
                        <td>
                            <img src="{{ $patient->photo_url }}"
                                 alt="Фото"
                                 width="60"
                                 height="60"
                                 class="rounded-circle object-fit-cover">
                        </td>
                        <td>{{ $patient->first_name }}</td>
                        <td>{{ $patient->last_name }}</td>
                        <td>{{ $patient->contact }}</td>
                        <td>{{ $doctorNames ?: '—' }}</td>
                        <td>{{ $consultations->count() }}</td>
                        <td>{{ $averageRating ? number_format($averageRating, 1) : '—' }}</td>
                        <td>{{ $averageDuration ? number_format($averageDuration, 1) : '—' }}</td>
                        <td>
                            <a href="{{ route('admin.patients.show', $patient) }}" class="btn btn-sm btn-info mb-1">Перегляд</a>
                            <a href="{{ route('admin.patients.edit', $patient) }}" class="btn btn-sm btn-primary mb-1">Редагувати</a>
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
    </div>
@endsection
