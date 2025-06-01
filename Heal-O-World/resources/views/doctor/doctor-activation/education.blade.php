@extends('layout.menu')

@section('content')

@section('styles')
<style>
    /* Основні стилі форми */
    form {
        background-color: #f9fafb;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        max-width: 900px;
        margin: auto;
    }

    /* Заголовок */
    h2 {
        color: #1e3a8a;
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 30px;
    }

    /* Стиль для міток */
    label {
        font-size: 1rem;
        color: #4b5563;
        font-weight: 500;
    }

    /* Стиль для полів вводу */
    input[type="text"], input[type="number"], input[type="file"] {
        width: 100%;
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
        background-color: #fff;
        font-size: 1rem;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }

    /* Стиль при фокусуванні */
    input:focus, select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 5px rgba(59, 130, 246, 0.5);
    }

    /* Кнопка "Завершити" */
    button[type="submit"] {
        display: inline-block;
        padding: 12px 24px;
        font-size: 1.125rem;
        font-weight: 600;
        border-radius: 8px;
        background-color: #3b82f6;
        color: white;
        text-align: center;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button[type="submit"]:hover {
        background-color: #2563eb;
    }

    /* Стилі для кнопок при наведенні */
    button[type="submit"]:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
    }

    /* Кнопка для додавання фото */
    input[type="file"] {
        cursor: pointer;
    }

    /* Адаптивний дизайн */
    @media (max-width: 768px) {
        form {
            padding: 20px;
        }

        h2 {
            font-size: 1.5rem;
        }

        button[type="submit"] {
            font-size: 1rem;
            padding: 10px 20px;
        }
    }
</style>
@endsection

@include('components.activation-steps', ['step' => 3])

    <h2 class="text-2xl font-bold mb-6 text-blue-700">Освіта</h2>

    <form method="POST" enctype="multipart/form-data" action="{{ route('activation.education') }}" class="space-y-10">
        @csrf

        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Навчальний заклад</label>
            <input type="text" name="institution" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out" required>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-medium mb-2">Ступінь</label>
            <input type="text" name="degree" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out" required>
        </div>

        <div class="mb-6 grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-medium mb-2">Рік початку</label>
                <input type="number" name="start_year" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out" min="1950" max="{{ date('Y') }}" required>
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Рік завершення</label>
                <input type="number" name="end_year" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out" min="1950" max="{{ date('Y') }}">
            </div>
        </div>

        <div class="mb-3">
            <label for="diploma_photo_1" class="form-label">Photo</label>
            <input type="file" class="form-control" id="diploma_photo_1" name="diploma_photo_1" 
            class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-4">
        </div>

        <div class="mb-3">
            <label for="diploma_photo_2" class="form-label">Photo</label>
            <input type="file" class="form-control" id="diploma_photo_2" name="diploma_photo_2" 
            class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-4">
        </div>

        <div class="mb-3">
            <label for="diploma_photo_3" class="form-label">Photo</label>
            <input type="file" class="form-control" id="diploma_photo_3" name="diploma_photo_3" 
            class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-4">
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500">Завершити</button>
        </div>
    </form>

@endsection
