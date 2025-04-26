@extends('layout.menu')

@section('content')
@include('components.activation-steps', ['step' => 3])

    <h2 class="text-xl font-bold mb-4">Освіта</h2>

    <form method="POST" action="{{ url('/activation/education') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block font-medium mb-1">Навчальний заклад</label>
            <input type="text" name="institution" class="w-full border rounded p-2" required>
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Ступінь</label>
            <input type="text" name="degree" class="w-full border rounded p-2" required>
        </div>

        <div class="mb-4 grid grid-cols-2 gap-4">
            <div>
                <label class="block font-medium mb-1">Рік початку</label>
                <input type="number" name="start_year" class="w-full border rounded p-2" min="1950" max="{{ date('Y') }}" required>
            </div>
            <div>
                <label class="block font-medium mb-1">Рік завершення</label>
                <input type="number" name="end_year" class="w-full border rounded p-2" min="1950" max="{{ date('Y') }}">
            </div>
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Фото диплома 1</label>
            <input type="file" name="diploma_photo_1" accept="image/*" class="w-full">
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Фото диплома 2</label>
            <input type="file" name="diploma_photo_2" accept="image/*" class="w-full">
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Фото диплома 3</label>
            <input type="file" name="diploma_photo_3" accept="image/*" class="w-full">
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">Завершити</button>
        </div>
    </form>
@endsection
