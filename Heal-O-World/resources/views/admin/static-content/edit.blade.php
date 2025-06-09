@extends('layout.admin')

@push('styles')
<style>
    .form-container {
        background: #f8f9fa;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
        width: 100%;
        max-width: 900px;
        max-height: 95vh;
        overflow-y: auto;
        padding: 40px 50px;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        margin: 40px auto;
    }

    h1 {
        margin-bottom: 40px;
        text-align: center;
        color: #343a40;
        font-weight: 700;
        font-size: 2.5rem;
    }

    label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
        display: block;
    }

    .form-control {
        width: 100%;
        border-radius: 8px;
        border: 1.5px solid #ced4da;
        padding: 10px 15px;
        font-size: 1rem;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        resize: vertical;
    }

    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 8px rgba(13, 110, 253, 0.5);
        outline: none;
    }

    .form-text {
        font-size: 0.9rem;
        color: #6c757d;
        margin-top: 4px;
        margin-bottom: 20px;
        display: block;
    }

    .mb-3, .mb-4 {
        margin-bottom: 1.5rem;
    }

    .btn-group {
        display: flex;
        justify-content: center;
        gap: 16px;
        margin-top: auto;
        padding-top: 10px;
        border-top: 1px solid #dee2e6;
    }

    .btn {
        padding: 12px 28px;
        font-size: 1.1rem;
        border-radius: 8px;
        cursor: pointer;
        border: none;
        transition: background-color 0.3s ease;
        min-width: 140px;
    }

    .btn-primary {
        background-color: #0d6efd;
        color: white;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
    }

    .btn-warning {
        background-color: #ffc107;
        color: #212529;
    }

    .btn-warning:hover {
        background-color: #e0a800;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
    }

    .alert {
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
        padding: 15px 20px;
    }
</style>
@endpush

@section('content')
<div class="form-container">
    <h2 class="mt-5 text-center">РЕДАГУВАННЯ СТАТИЧНИХ РОЗДІЛІВ</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.static-contents.update') }}" method="POST" novalidate>
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="mission_title">ЗАГОЛОВОК (Наша місія)</label>
            <input type="text" id="mission_title" name="mission_title" class="form-control" value="{{ old('mission_title', $staticContent->mission_title) }}" required>
        </div>

        <div class="mb-4">
            <label for="mission_text">ТЕКСТ (Наша місія)</label>
            <textarea id="mission_text" name="mission_text" class="form-control" rows="5" required>{{ old('mission_text', $staticContent->mission_text) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="why_us_title">ЗАГОЛОВОК (Чому варто обрати нас)</label>
            <input type="text" id="why_us_title" name="why_us_title" class="form-control" value="{{ old('why_us_title', $staticContent->why_us_title) }}" required>
        </div>

        <div class="mb-4">
            <label for="why_us_list">ПУНКТИ СПИСКУ (Чому варто обрати нас)</label>
            <textarea id="why_us_list" name="why_us_list" class="form-control" rows="5" placeholder="Кожен пункт з нового рядка" required>{{ old('why_us_list', $staticContent->why_us_list) }}</textarea>
            <small class="form-text">Напишіть кожен пункт з нового рядка.</small>
        </div>

        <div class="mb-3">
            <label for="reviews_title">ЗАГОЛОВОК (Відгуки)</label>
            <input type="text" id="reviews_title" name="reviews_title" class="form-control" value="{{ old('reviews_title', $staticContent->reviews_title) }}" required>
        </div>

        <div class="mb-4">
            <label for="reviews_text">ТЕКСТ ВІДГУКІВ</label>
            <textarea id="reviews_text" name="reviews_text" class="form-control" rows="5" required>{{ old('reviews_text', $staticContent->reviews_text) }}</textarea>
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-primary">Зберегти зміни</button>
            <button type="button" class="btn btn-warning" onclick="window.location='{{ route('admin.static-contents.edit') }}'">Скасувати</button>
            <button type="button" class="btn btn-secondary" onclick="window.location='{{ route('admin.patients.index') }}'">Повернутись назад</button>
        </div>
    </form>
</div>
@endsection
