@extends('layout.admin')

@section('title', 'Список пацієнтів')

@section('content')
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
