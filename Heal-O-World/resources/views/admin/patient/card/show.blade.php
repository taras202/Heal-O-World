@extends('layout.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Деталі картки пацієнта</h1>

    <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary mb-4">Назад до списку</a>

        <div class="card mb-4">
            <div class="card-header">
                <strong>Пацієнт:</strong> {{ $patientCard->patient->first_name }} {{ $patientCard->patient->last_name ?? '' }}
            </div>
        </div>
        <div class="card-body">
            <p><strong>Нотатки:</strong> {{ $patientCard->notes ?? '—' }}</p>
            <p><strong>Зріст:</strong> {{ $patientCard->height ?? '—' }} см</p>
            <p><strong>Вага:</strong> {{ $patientCard->weight ?? '—' }} кг</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <h4>Діагнози</h4>
            <ul class="list-group mb-3">
                @forelse ($patientCard->diagnoses as $diagnosis)
                    <li class="list-group-item">{{ $diagnosis->diagnoses->title ?? '—' }}</li>
                @empty
                    <li class="list-group-item">Немає записів</li>
                @endforelse
            </ul>
        </div>

        <div class="col-md-6">
            <h4>Хронічні захворювання</h4>
            <ul class="list-group mb-3">
                @forelse ($patientCard->chronicDiseases as $chronic)
                    <li class="list-group-item">{{ $chronic->chronicDisease->title ?? '—' }}</li>
                @empty
                    <li class="list-group-item">Немає записів</li>
                @endforelse
            </ul>
        </div>

        <div class="col-md-6">
            <h4>Захворювання</h4>
            <ul class="list-group mb-3">
                @forelse ($patientCard->diseases as $disease)
                    <li class="list-group-item">{{ $disease->disease->title ?? '—' }}</li>
                @empty
                    <li class="list-group-item">Немає записів</li>
                @endforelse
            </ul>
        </div>

        <div class="col-md-6">
            <h4>Алергічні реакції</h4>
            <ul class="list-group mb-3">
                @forelse ($patientCard->allergicReactions as $reaction)
                    <li class="list-group-item">{{ $reaction->allergicReaction->title ?? '—' }}</li>
                @empty
                    <li class="list-group-item">Немає записів</li>
                @endforelse
            </ul>
        </div>
@endsection
