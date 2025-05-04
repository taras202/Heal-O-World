@extends('layout.admin')

@section('title', 'Список лікарів')

@section('content')
    
<h2 class="mt-5 text-center">СПИСОК ЛІКАРІВ</h2>

    <a href="{{ route('admin.doctors.create') }}" class="btn btn-success mb-3">Створити лікаря</a>
    <a href="{{ route('admin.doctors.analytics') }}" class="btn btn-info mb-3">Переглянути аналітику</a>


    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Фото</th>
                <th>Ім’я</th>
                <th>Прізвище</th>
                <th>Стать</th>
                <th>Контакт</th>
                <th>Часовий пояс</th>
                <th>Спеціалізації</th>
                <th>Освіта</th>
                <th>Місце роботи</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            @foreach($doctors as $doctor)
                <tr>
                    <td>
                        <img src="{{ $doctor->photo ? asset('storage/' . $doctor->photo) : asset('images/default-avatar.png') }}"
                             alt="Фото" width="60" height="60" style="border-radius: 50%;">
                    </td>
                    <td>{{ $doctor->first_name }}</td>
                    <td>{{ $doctor->last_name }}</td>
                    <td>{{ $doctor->gender }}</td>
                    <td>{{ $doctor->contact }}</td>
                    <td>{{ $doctor->time_zone }}</td>
                    <td>
                        @foreach($doctor->specialties as $specialty)
                            <strong>{{ $specialty->name }}</strong><br>
                            Досвід: {{ $specialty->pivot->experience }} років<br>
                            Ціна: {{ $specialty->pivot->price }} грн<br><br>
                        @endforeach
                    </td>
                    <td>
                        @foreach($doctor->educations as $edu)
                            {{ $edu->degree }} — {{ $edu->institution }}<br>
                            ({{ $edu->start_year }} - {{ $edu->end_year }})<br><br>
                        @endforeach
                    </td>
                    <td>
                        @if($doctor->placeOfWork)
                            {{ $doctor->placeOfWork->workplace }}<br>
                            {{ $doctor->placeOfWork->position }}<br>
                            {{ $doctor->placeOfWork->city_of_residence }}, {{ $doctor->placeOfWork->country_of_residence }}
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.doctors.show', $doctor) }}" class="btn btn-sm btn-info">Перегляд</a>
                        
                        <a href="{{ route('admin.doctors.edit', $doctor) }}" class="btn btn-sm btn-primary">Редагувати</a>

                        <form action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Ви впевнені, що хочете видалити цього лікаря?');">
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
