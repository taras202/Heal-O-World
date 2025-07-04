@extends('layout.menu-consultation-patient')

@section('content')
<style>
    body {
        font-family: 'Segoe UI', sans-serif;
    }

    .section-title {
        font-size: 2rem;
        margin-bottom: 1.5rem;
        color: #1d3557;
        font-weight: bold;
        text-align: center;
    }

    .filter-form {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-bottom: 2.5rem;
        flex-wrap: wrap;
    }

    .filter-form label {
        font-weight: 600;
        font-size: 1.05rem;
    }

    .filter-form select {
        padding: 0.6rem 1rem;
        border-radius: 10px;
        border: 1px solid #ced4da;
        background-color: #f1f3f5;
        font-size: 1rem;
    }

    .consultation-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .consultation-card {
        background-color: #ffffff;
        border-radius: 14px;
        padding: 1.5rem 2rem;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
        transition: 0.3s ease all;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .consultation-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    }

    .card-content p {
        margin: 0.4rem 0;
        font-size: 1rem;
        color: #343a40;
    }

    .card-content p strong {
        color: #495057;
        display: inline-block;
        min-width: 100px;
    }

    .btn-outline {
        align-self: flex-start;
        margin-top: 1rem;
        background: transparent;
        color: #1d3557;
        padding: 0.6rem 1.2rem;
        border: 2px solid #1d3557;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-outline:hover {
        background-color: #1d3557;
        color: #fff;
    }

    .status-pending {
        color: #f0ad4e;
        font-weight: bold;
    }

    .status-completed {
        color: #5cb85c;
        font-weight: bold;
    }

    .status-cancelled {
        color: #d9534f;
        font-weight: bold;
    }

    .empty-message {
        padding: 1.5rem;
        font-size: 1.1rem;
        color: #6c757d;
        background-color: #f8f9fa;
        border-radius: 10px;
        text-align: center;
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 2rem;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .pagination .page-item {
        list-style: none;
    }

    .pagination .page-link {
        display: inline-block;
        padding: 0.5rem 0.9rem;
        font-size: 1rem;
        font-weight: 500;
        color: #1d3557;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        text-decoration: none;
        transition: 0.3s;
    }

    .pagination .page-link:hover {
        background-color: #1d3557;
        color: #fff;
        border-color: #1d3557;
    }

    .pagination .page-item.active .page-link {
        background-color: #1d3557;
        border-color: #1d3557;
        color: #fff;
        font-weight: 600;
    }

    .pagination .page-item.disabled .page-link {
        color: #adb5bd;
        pointer-events: none;
        background-color: #f8f9fa;
        border-color: #dee2e6;
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
        @php
            $patientId = auth()->user()->patient->id;
            $doctorId = $consultation->doctor_id;
            $hasReviewed = \App\Models\Review::where('doctor_id', $doctorId)
                ->where('patient_id', $patientId)
                ->exists();
        @endphp

        <li class="consultation-card">
            <div class="card-content">
                <p><strong>Дата:</strong> {{ \Carbon\Carbon::parse($consultation->appointment_date)->format('d.m.Y') }}</p>
                <p><strong>Час:</strong> {{ $consultation->consultation_time }}</p>
                <p><strong>Лікар:</strong> {{ $consultation->doctor->first_name ?? '—' }} {{ $consultation->doctor->last_name ?? '' }}</p>
                <p><strong>Статус:</strong>
                    <span class="status-{{ $consultation->status }}">
                        {{ ucfirst($consultation->status) }}
                    </span>
                </p>
            </div>

            <a href="{{ route('patient.consultations.show', $consultation->id) }}" class="btn-outline">Детальніше</a>

            @if($consultation->status === 'completed')
                @php
                    $hasReviewed = \App\Models\Review::where('doctor_id', $consultation->doctor_id)
                        ->where('patient_id', auth()->user()->patient->id)
                        ->exists();
                @endphp

                @if(! $hasReviewed)
                    <a href="{{ route('reviews.create', ['doctor' => $consultation->doctor_id, 'consultation' => $consultation->id]) }}" class="btn-outline" style="margin-top: 10px;">
                        Залишити відгук
                    </a>
                @endif
            @endif
        </li>
    @empty
        <p class="empty-message">Консультацій не знайдено.</p>
    @endforelse
</ul>

<div class="pagination">
    {{ $consultations->withQueryString()->links() }}
</div>
@endsection
