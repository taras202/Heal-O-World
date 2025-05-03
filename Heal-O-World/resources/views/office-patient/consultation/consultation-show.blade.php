@extends('layout.menu-consultation-patient')

<style>
    .consultation-details {
    background-color: #ffffff;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    padding: 2rem;
    max-width: 700px;
    margin: 2rem auto;
    }

    .consultation-details h2 {
        margin-bottom: 1.5rem;
        color: #0d3581;
    }

    .consultation-details ul {
        list-style: none;
        padding: 0;
        margin: 0 0 2rem 0;
    }

    .consultation-details li {
        padding: 0.8rem 1rem;
        border-left: 4px solid #4d8ef7;
        background-color: #f9f9f9;
        border-radius: 6px;
        margin-bottom: 1rem;
        line-height: 1.6;
    }

    .consultation-details li strong {
        color: #1a1a1a;
    }

    .btn-outline {
        display: inline-block;
        padding: 0.6rem 1.4rem;
        border: 2px solid #0d3581;
        border-radius: 8px;
        color: #0d3581;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.2s ease;
        margin-right: 1rem;
    }

    .btn-outline:hover {
        background-color: #0d3581;
        color: white;
    }

    .btn-outline.text-red-600 {
        border-color: #d11a2a;
        color: #d11a2a;
    }

    .btn-outline.text-red-600:hover {
        background-color: #d11a2a;
        color: white;
    }
</style>

@section('content')

<div class="consultation-details">
    <h2>Деталі консультації</h2>

    <ul>
        <li><strong>Дата:</strong> {{ \Carbon\Carbon::parse($consultation->appointment_date)->format('d.m.Y') }}</li>
        <li><strong>Час:</strong> {{ $consultation->consultation_time }}</li>
        <li><strong>Статус:</strong> {{ ucfirst($consultation->status) }}</li>
        <li><strong>Лікар:</strong> {{ $consultation->doctor->first_name ?? '—' }} {{ $consultation->doctor->last_name ?? '' }}</li>
        <li><strong>Діагноз:</strong> {{ $consultation->diagnosis ?? 'Немає' }}</li>
        <li><strong>Призначення:</strong> {{ $consultation->prescription ?? 'Немає' }}</li>
        <li><strong>Лікування:</strong> {{ $consultation->treatment ?? 'Немає' }}</li>
        <li><strong>Нотатки:</strong> {{ $consultation->notes ?? '—' }}</li>
        <li><strong>Посилання на консультацію:</strong>
            @if($consultation->google_meet_link)
                <a href="{{ $consultation->google_meet_link }}" target="_blank">Перейти</a>
            @else
                Немає
            @endif
        </li>
    </ul>

    <a href="{{ route('patient.consultations.index') }}" class="btn-outline">← Назад</a>

    @if($consultation->status !== 'cancelled')
        <form method="POST" action="{{ route('patient.consultations.cancel', $consultation->id) }}" onsubmit="return confirm('Ви впевнені, що хочете скасувати консультацію?')" style="display:inline;">
            @csrf
            <button type="submit" class="btn-outline text-red-600">Скасувати консультацію</button>
        </form>
    @endif
</div>
@endsection
