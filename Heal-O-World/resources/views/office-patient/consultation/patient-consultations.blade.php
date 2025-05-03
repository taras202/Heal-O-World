@extends('layout.menu-consultation-patient')

@section('content')
<style> 
    .section-title {
    font-size: 1.8rem;
    margin-bottom: 1.5rem;
    color: #0d3b66;
    }

    .filter-form {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
        font-weight: 500;
    }

    .filter-form select {
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        border: 1px solid #ccc;
        background-color: #f8f9fa;
        font-size: 1rem;
    }

    .consultation-list {
        list-style: none;
        padding: 0;
        display: grid;
        gap: 1.5rem;
    }

    .consultation-card {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        background-color: #ffffff;
        padding: 1.5rem 2rem;
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(0,0,0,0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .consultation-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.1);
    }

    .card-content p {
        margin: 0.3rem 0;
        font-size: 1rem;
    }

    .btn-outline {
        background: transparent;
        color: #007bff;
        padding: 0.6rem 1.2rem;
        border: 2px solid #007bff;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-outline:hover {
        background-color: #007bff;
        color: #fff;
    }

    .empty-message {
        padding: 1.5rem;
        font-size: 1.1rem;
        color: #6c757d;
        background-color: #f1f3f5;
        border-radius: 8px;
        text-align: center;
    }
</style>

    <h2 class="section-title">Мої консультації</h2>

    <form method="GET" class="filter-form">
        <label for="status">Фільтр по статусу:</label>
        <select name="status" id="status" onchange="this.form.submit()">
            <option value="">Усі</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Очікує</option>
            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Завершена</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Скасована</option>
        </select>
    </form>

    <ul class="consultation-list">
        @forelse($consultations as $consultation)
            <li class="consultation-card">
                <div class="card-content">
                    <p><strong>Дата:</strong> {{ \Carbon\Carbon::parse($consultation->appointment_date)->format('d.m.Y') }}</p>
                    <p><strong>Час:</strong> {{ $consultation->consultation_time }}</p>
                    <p><strong>Лікар:</strong> {{ $consultation->doctor->full_name ?? '—' }}</p>
                    <p><strong>Статус:</strong> {{ ucfirst($consultation->status) }}</p>
                </div>
                <a href="{{ route('patient.consultations.show', $consultation->id) }}" class="btn-outline">Детальніше</a>
            </li>
        @empty
            <p class="empty-message">Консультацій не знайдено.</p>
        @endforelse
    </ul>
@endsection
