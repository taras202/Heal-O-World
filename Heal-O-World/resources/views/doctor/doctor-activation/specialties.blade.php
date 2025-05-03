@extends('layout.menu')

@section('content')

@section('styles')
<style>
        /* Загальний стиль для форми */
        form {
            background-color: #f9fafb;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: auto;
        }

        /* Заголовок */
        h2 {
            color: #1e3a8a;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 30px;
        }

        /* Стиль для елементів форми */
        label {
            font-size: 1rem;
            color: #4b5563;
            font-weight: 500;
        }

        input, select {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            background-color: #fff;
            font-size: 1rem;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 5px rgba(59, 130, 246, 0.5);
        }

        /* Кнопка "Додати спеціальність" */
        #add-specialty {
            display: inline-block;
            background-color: #10b981;
            color: #fff;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

        #add-specialty:hover {
            background-color: #059669;
        }

        /* Кнопки "Назад" та "Далі" */
        button[type="submit"], a {
            display: inline-block;
            padding: 12px 24px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 8px;
            text-align: center;
            transition: all 0.3s ease;
        }

        button[type="submit"] {
            background-color: #3b82f6;
            color: white;
            border: none;
        }

        button[type="submit"]:hover {
            background-color: #2563eb;
        }

        a {
            background-color: #f3f4f6;
            color: #374151;
            text-decoration: none;
        }

        a:hover {
            background-color: #e5e7eb;
        }

        /* Для додаткових полів спеціальностей */
        .specialty-item {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        /* Адаптивний дизайн */
        @media (max-width: 768px) {
            form {
                padding: 20px;
            }

            #add-specialty {
                font-size: 0.9rem;
                padding: 6px 12px;
            }

            h2 {
                font-size: 1.25rem;
            }

            button[type="submit"], a {
                font-size: 0.9rem;
                padding: 10px 20px;
            }
        }
    </style>
@endsection

    @include('components.activation-steps', ['step' => 2])

    <div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow">
        <h2 class="text-xl font-semibold mb-4 text-blue-700">Спеціалізація</h2>

        <form method="POST" enctype="multipart/form-data" action="{{ route('activation.specialties') }}" class="space-y-10">
            @csrf

            <div id="specialty-container">
                <div class="specialty-item mb-4">
                    <label class="block mb-1">Спеціальність</label>
                    <select name="specialties[0][specialty_id]" class="w-full border rounded p-3 mb-4 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach ($specialties as $specialty)
                            <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
                        @endforeach
                    </select>

                    <label class="block mb-1">Стаж</label>
                    <input type="text" name="specialties[0][experience]" class="w-full border rounded p-3 mb-4 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500">

                    <label class="block mb-1">Ціна консультації (грн)</label>
                    <input type="number" step="0.01" name="specialties[0][price]" class="w-full border rounded p-3 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <button type="button" id="add-specialty" class="mt-2 mb-6 text-blue-600 hover:text-blue-800">+ Додати спеціальність</button>

            <div class="flex justify-between">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition duration-200">Далі</button>
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
                <select name="specialties[${index}][specialty_id]" class="w-full border rounded p-3 mb-4 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach ($specialties as $specialty)
                        <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
                    @endforeach
                </select>
                <label class="block mb-1">Стаж</label>
                <input type="text" name="specialties[${index}][experience]" class="w-full border rounded p-3 mb-4 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500">
                <label class="block mb-1">Ціна консультації (грн)</label>
                <input type="number" step="0.01" name="specialties[${index}][price]" class="w-full border rounded p-3 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500">
            `;
            container.appendChild(newItem);
            index++;
        });
    </script>

@endsection
