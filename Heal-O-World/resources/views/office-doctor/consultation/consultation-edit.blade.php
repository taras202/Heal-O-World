@extends('layout.menu')

@section('content')
    <h2>Редагувати консультацію</h2>

    @if(session('success'))
        <div class="text-green-600">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('doctor.consultation.update', $consultation->id) }}">
        @csrf

        <label>Статус:
            <select name="status">
                <option value="pending" {{ $consultation->status === 'pending' ? 'selected' : '' }}>Очікує</option>
                <option value="completed" {{ $consultation->status === 'completed' ? 'selected' : '' }}>Завершено</option>
                <option value="cancelled" {{ $consultation->status === 'cancelled' ? 'selected' : '' }}>Скасовано</option>
            </select>
        </label>

        <label>Діагноз:
            <textarea name="diagnosis">{{ old('diagnosis', $consultation->diagnosis) }}</textarea>
        </label>

        <label>Призначення:
            <textarea name="prescription">{{ old('prescription', $consultation->prescription) }}</textarea>
        </label>

        <label>Лікування:
            <textarea name="treatment">{{ old('treatment', $consultation->treatment) }}</textarea>
        </label>

        <label>Нотатки:
            <textarea name="notes">{{ old('notes', $consultation->notes) }}</textarea>
        </label>

        <button type="submit" class="btn-primary">Оновити</button>
    </form>
@endsection
