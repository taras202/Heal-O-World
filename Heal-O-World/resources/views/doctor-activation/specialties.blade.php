@extends('layout.menu')

@section('content')
    @include('components.activation-steps', ['step' => 2])

    <div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow">
        <h2 class="text-xl font-semibold mb-4">Спеціалізація</h2>

        <form method="POST" action="{{ url('/activation/specialties') }}">
            @csrf

            <div id="specialty-container">
                <div class="specialty-item mb-4">
                    <label class="block mb-1">Спеціальність</label>
                    <select name="specialties[0][specialty_id]" class="w-full border rounded p-2 mb-2">
                        @foreach ($specialties as $specialty)
                            <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
                        @endforeach
                    </select>

                    <label class="block mb-1">Стаж</label>
                    <input type="text" name="specialties[0][experience]" class="w-full border rounded p-2 mb-2">

                    <label class="block mb-1">Ціна консультації (грн)</label>
                    <input type="number" step="0.01" name="specialties[0][price]" class="w-full border rounded p-2">
                </div>
            </div>

            <button type="button" id="add-specialty" class="mt-2 mb-6 text-blue-600">+ Додати спеціальність</button>

            <div class="flex justify-between">
                <a href="{{ url('/activation/personal-data') }}" class="px-4 py-2 bg-gray-200 rounded">Назад</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Далі</button>
            </div>
        </form>
    </div>

    <script>
        let index = 1;
        document.getElementById('add-specialty').addEventListener('click', function () {
            const container = document.getElementById('specialty-container');
            const newItem = document.createElement('div');
            newItem.classList.add('specialty-item', 'mb-4');
            newItem.innerHTML = `
                <label class="block mb-1">Спеціальність</label>
                <select name="specialties[${index}][specialty_id]" class="w-full border rounded p-2 mb-2">
                    @foreach ($specialties as $specialty)
                        <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
                    @endforeach
                </select>
                <label class="block mb-1">Стаж</label>
                <input type="text" name="specialties[${index}][experience]" class="w-full border rounded p-2 mb-2">
                <label class="block mb-1">Ціна консультації (грн)</label>
                <input type="number" step="0.01" name="specialties[${index}][price]" class="w-full border rounded p-2">
            `;
            container.appendChild(newItem);
            index++;
        });
    </script>
@endsection
