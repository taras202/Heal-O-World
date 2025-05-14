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
</style>

<form method="POST" action="{{ isset($patientCard) ? route('patient-cards.update', $patientCard->id) : route('patient-cards.store') }}">
    @csrf
    @if($patientCard)
        @method('PUT')
    @endif

    <div class="form-section">
        <h4>Основна інформація</h4>

        <div class="form-group">
            <label>Пацієнт</label>
            <p>{{ $patient->last_name }} {{ $patient->first_name }} {{ $patient->middle_name ?? '' }}</p>
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
            'allergic_reactions' => 'Алергічні реакції',
            'chronic_diseases' => 'Хронічні захворювання',
            'diseases' => 'Історія хвороб',
            'diagnoses' => 'Діагнози'
        ];
    @endphp

    @foreach($sections as $key => $label)
        <div class="form-section" id="{{ $key }}-section">
            <h4>{{ $label }}</h4>
            <div id="{{ $key }}-container">
                @php
                    $oldItems = old($key, $patientCard?->$key ?? []);
                @endphp

                @foreach($oldItems as $i => $item)
                    <div class="form-group d-flex">
                        <input type="hidden" name="{{ $key }}[{{ $i }}][patient_card_id]" value="{{ $patientCard?->id }}">
                        <select name="{{ $key }}[{{ $i }}][{{ $key === 'diagnoses' ? 'diagnosis_id' : 'list_' . $key . '_id' }}]" required>
                            <option value="">Оберіть...</option>
                            @foreach($lists[$key] as $listItem)
                                <option value="{{ $listItem->id }}"
                                    @if(
                                        (isset($item['list_' . $key . '_id']) && $item['list_' . $key . '_id'] == $listItem->id)
                                        || (isset($item['diagnosis_id']) && $item['diagnosis_id'] == $listItem->id)
                                    )
                                        selected
                                    @endif
                                >
                                    {{ $listItem->name }}
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
function addItem(section) {
    const container = document.getElementById(`${section}-container`);
    const index = container.children.length;
    const lists = @json($lists);

    let options = `<option value="">Оберіть...</option>`;
    for (const item of lists[section]) {
        options += `<option value="${item.id}">${item.name}</option>`;
    }

    const fieldName = section === 'diagnoses' ? 'diagnosis_id' : `list_${section}_id`;

    const html = `
        <div class="form-group d-flex">
            <input type="hidden" name="${section}[${index}][patient_card_id]" value="{{ $patientCard?->id }}">
            <select name="${section}[${index}][${fieldName}]" required>
                ${options}
            </select>
            <button type="button" class="btn-remove" onclick="this.parentElement.remove()">✖</button>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', html);
}
</script>
@endsection
