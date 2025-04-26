@extends('layout.menu')

@section('title', 'Кабінет лікаря')

@section('content')
    <form method="POST" action="{{ route('auth.logout') }}" style="display: inline;">
        @csrf
        <button type="submit" class="logout-button">Вихід</button>
    </form>

    <h1>Вітаємо, {{ $user->name ?? $user->email }}</h1>
    <p>Це ваш особистий кабінет.</p>

    @if (is_null($user->specialization) || is_null($user->education) || is_null($user->workplace))
        <div class="alert alert-warning">
            Ви ще не заповнили всі необхідні дані. <a href="{{ route('activation.personal') }}">Перейдіть до заповнення</a>.
        </div>
    @endif
@endsection
