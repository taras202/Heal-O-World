@extends('layout.admin')

@section('title', 'Список пацієнтів')

@section('content')

<h2 class="mt-5 text-center">СПИСОК ПАЦІЄНТІВ</h2>

    <a href="{{ route('admin.patients.create') }}" class="btn btn-success mb-3">Додати пацієнта</a>
    <a href="{{ route('admin.patients.analytics') }}" class="btn btn-info mb-3">Переглянути аналітику</a>

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
