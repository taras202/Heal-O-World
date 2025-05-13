@extends('layout.menu-consultation-patient')

@section('content')
<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #f1f4f9;
    }

    .consultation-details {
        background-color: #ffffff;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
        padding: 2rem 2.5rem;
        max-width: 760px;
        margin: 3rem auto;
        animation: fadeIn 0.4s ease;
    }

    .consultation-details h2 {
        margin-bottom: 2rem;
        color: #003366;
        font-size: 1.8rem;
        text-align: center;
        font-weight: 700;
    }

    .consultation-details ul {
        list-style: none;
        padding: 0;
        margin: 0 0 2rem 0;
    }

    .consultation-details li {
        padding: 1rem 1.2rem;
        border-left: 4px solid #4d8ef7;
        background-color: #f7faff;
        border-radius: 8px;
        margin-bottom: 1.2rem;
        line-height: 1.6;
        font-size: 1rem;
        display: flex;
        flex-wrap: wrap;
    }

    .consultation-details li strong {
        color: #212529;
        min-width: 160px;
        font-weight: 600;
    }

    .consultation-details li a {
        color: #0077cc;
        font-weight: 600;
        text-decoration: none;
    }

    .consultation-details li a:hover {
        text-decoration: underline;
    }

    .btn-outline {
        display: inline-block;
        padding: 0.6rem 1.4rem;
        border: 2px solid #0d3581;
        border-radius: 10px;
        color: #0d3581;
        background-color: transparent;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.25s ease-in-out;
        margin-right: 1rem;
        margin-top: 0.5rem;
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

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

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
                <a href="{{ $consultation->google_meet_link }}" target="_blank">Перейти до Meet</a>
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
