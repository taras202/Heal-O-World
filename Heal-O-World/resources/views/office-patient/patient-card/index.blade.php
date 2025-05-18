@extends('layout.menu-consultation-patient')

@section('content')
<style>
    .form-section {
        margin-bottom: 2rem;
        background: #f8f9fa;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .form-section h4 {
        margin-bottom: 1.5rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    input, select, textarea {
        width: 100%;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 14px;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: bold;
        margin-top: 1rem;
    }

    .btn-add {
        margin-top: 10px;
        background: #28a745;
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }

    .btn-remove {
        margin-left: 10px;
        background: #dc3545;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 6px;
        cursor: pointer;
    }

    .d-flex {
        display: flex;
        gap: 10px;
        align-items: center;
    }
</style>

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ isset($patientCard) ? route('patient-cards.update', $patientCard->id) : route('patient-cards.store') }}">
    @csrf
    @if($patientCard)
        @method('PUT')
    @endif

    <div class="form-section">
        <h4>Основна інформація</h4>

        <div class="form-group">
            <label>Пацієнт</label>
            <p>{{ $patient->first_name }} {{ $patient->last_name ?? '' }}</p>
            <input type="hidden" name="patient_id" value="{{ $patient->id }}">
        </div>

        <div class="form-group">
            <label for="notes">Нотатки</label>
            <textarea name="notes" id="notes" rows="3">{{ old('notes', $patientCard?->notes) }}</textarea>
        </div>

        <div class="form-group">
            <label for="height">Зріст (см)</label>
            <input type="number" name="height" id="height" value="{{ old('height', $patientCard?->height) }}" step="0.1" min="0">
        </div>

        <div class="form-group">
            <label for="weight">Вага (кг)</label>
            <input type="number" name="weight" id="weight" value="{{ old('weight', $patientCard?->weight) }}" step="0.1" min="0">
        </div>
    </div>

@php
    $sections = [
        'diagnoses' => 'Діагнози',
        'chronic_diseases' => 'Хронічні захворювання',
        'diseases' => 'Захворювання',
        'allergic_reactions' => 'Алергічні реакції',
    ];

    $fieldMap = [
        'diagnoses' => 'list_diagnoses_id',
        'chronic_diseases' => 'list_chronic_diseases_id',
        'diseases' => 'list_of_diseases_id',
        'allergic_reactions' => 'list_allergic_reactions_id',
    ];
@endphp

<script>
    window.selectOptions = {
        @foreach($sections as $key => $label)
            "{{ $key }}": `
                @foreach($lists[$key] as $item)
                    <option value="{{ $item->id }}">{{ $item->title }}</option>
                @endforeach
            `,
        @endforeach
    };
</script>

@foreach($sections as $key => $label)
    <div class="form-section" id="{{ $key }}-section">
        <h4>{{ $label }}</h4>
        <div id="{{ $key }}-container">
            @php
                $fieldName = $fieldMap[$key];
                $relationItems = $patientCard ? ($patientCard->{\Illuminate\Support\Str::camel($key)} ?? collect()) : collect();
                $oldItems = old($key, $relationItems->map(fn($item) => [$fieldName => $item->$fieldName])->toArray());
            @endphp

            @foreach($oldItems as $i => $item)
                @php
                    $selectedId = is_array($item) ? $item[$fieldName] ?? null : $item;
                @endphp
                <div class="form-group d-flex">
                    <input type="hidden" name="{{ $key }}[{{ $i }}][patient_card_id]" value="{{ $patientCard?->id }}">
                    <select name="{{ $key }}[{{ $i }}][{{ $fieldName }}]" required>
                        <option value="">Оберіть...</option>
                        @foreach($lists[$key] as $listItem)
                            <option value="{{ $listItem->id }}" @if($selectedId == $listItem->id) selected @endif>
                                {{ $listItem->title }}
                            </option>
                        @endforeach
                    </select>
                    <button type="button" class="btn-remove" onclick="this.parentElement.remove()">✖</button>
                </div>
            @endforeach
        </div>
        <button type="button" class="btn-add" onclick="addItem('{{ $key }}')">+ Додати</button>
    </div>
@endforeach

    <button type="submit" class="btn-primary">
        {{ $patientCard ? 'Оновити карту' : 'Створити карту' }}
    </button>
</form>

<script>
    const fieldMap = {
        diagnoses: 'list_diagnoses_id',
        chronic_diseases: 'list_chronic_diseases_id',
        diseases: 'list_of_diseases_id',
        allergic_reactions: 'list_allergic_reactions_id',
    };

    function addItem(section) {
        const fieldName = fieldMap[section];
        const container = document.getElementById(`${section}-container`);
        const index = container.children.length;

        const wrapper = document.createElement('div');
        wrapper.classList.add('form-group', 'd-flex');

        wrapper.innerHTML = `
            <input type="hidden" name="${section}[${index}][patient_card_id]" value="">
            <select name="${section}[${index}][${fieldName}]" required>
                <option value="">Оберіть...</option>
                ${window.selectOptions[section] || ''}
            </select>
            <button type="button" class="btn-remove" onclick="this.parentElement.remove()">✖</button>
        `;

        container.appendChild(wrapper);
    }
</script>
@endsection
