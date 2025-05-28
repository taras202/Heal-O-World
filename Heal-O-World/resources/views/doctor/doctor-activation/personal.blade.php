@extends('layout.menu')

@section('content')

@section('styles')
<style>
  body {
    font-family: 'Inter', sans-serif;
    background: #f9fafb;
  }

  .form-container {
    background: white;
    padding: 3rem;
    border-radius: 2rem;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
    border: 1px solid #bfdbfe;
  }

  input[type="text"],
  input[type="number"],
  input[type="file"],
  select,
  textarea {
    border-radius: 1rem;
    border: 1px solid #d1d5db;
    padding: 1rem;
    width: 100%;
    transition: all 0.3s ease;
    background: #f9fafb;
  }

  input[type="text"]:focus,
  input[type="number"]:focus,
  input[type="file"]:focus,
  select:focus,
  textarea:focus {
    border-color: #3b82f6;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
    outline: none;
  }

  button[type="submit"] {
    background: #d1d5db;
    border: none;
    padding: 1rem;
    width: 100%;
    font-size: 1.25rem;
    font-weight: 700;
    color: white;
    border-radius: 1rem;
    transition: background 0.3s ease;
  }

  button[type="submit"]:hover {
    background: #d1d5db;
    box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4);
  }

  /* Адаптивність */
  @media (max-width: 1024px) {
    .stepper {
      display: none;
    }
  }
</style>
@endsection

<div class="flex min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-100">

    <!-- Компонент з лівої сторони -->
    <div class="flex-shrink-0 w-1/4 p-6">
        @include('components.activation-steps', ['step' => 1])
    </div>

    <!-- Сторона: Форма -->
    <div class="flex flex-col flex-grow items-center justify-center px-6 py-12">
        <div class="w-full max-w-6xl bg-white p-12 rounded-3xl shadow-2xl ring-1 ring-blue-100">
            <h2 class="text-4xl font-bold text-center text-blue-700 mb-10">
                Заповніть персональні дані
            </h2>
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" enctype="multipart/form-data" action="{{ route('activation.personal') }}" class="space-y-10">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div>
                        <label for="first_name" class="block text-base font-medium text-gray-700">Ім’я</label>
                        <input type="text" name="first_name" id="first_name" placeholder="Ім’я"
                            class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-4">
                    </div>

                    <div>
                        <label for="last_name" class="block text-base font-medium text-gray-700">Прізвище</label>
                        <input type="text" name="last_name" id="last_name" placeholder="Прізвище"
                            class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-4">
                    </div>
                </div>

                <div>
                    <label for="bio" class="block text-base font-medium text-gray-700">Про себе</label>
                    <textarea name="bio" id="bio" rows="4" placeholder="Короткий опис"
                        class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-4"></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                    <div>
                        <label for="gender" class="block text-base font-medium text-gray-700">Стать</label>
                        <select name="gender" id="gender" class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-4">
                            <option value="">Оберіть стать</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Чоловік</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Жінка</option>
                        </select>
                    </div>

                    <div>
                        <label for="language" class="block text-base font-medium text-gray-700">Мови</label>
                        <select name="language[]" id="language" multiple
                            class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-4" size="4">
                            <option value="uk" {{ in_array('uk', old('language', [])) ? 'selected' : '' }}>Українська</option>
                            <option value="ru" {{ in_array('ru', old('language', [])) ? 'selected' : '' }}>Російська</option>
                            <option value="en" {{ in_array('en', old('language', [])) ? 'selected' : '' }}>Англійська</option>
                        </select>
                    </div>

                    <div>
                        <label for="photo" class="block text-base font-medium text-gray-700">Фото</label>
                        <input type="file" class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-4" id="photo" name="photo" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div>
                        <label for="contact" class="block text-base font-medium text-gray-700">Контактний телефон</label>
                        <input type="text" name="contact" id="contact" placeholder="+380..."
                            class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-4">
                    </div>

                    <div>
                        <label for="time_zone_id" class="block text-base font-medium text-gray-700">Часовий пояс</label>
                        <select name="time_zone_id" id="time_zone_id"
                            class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-4">
                            @foreach ($timeZones as $zone)
                                <option value="{{ $zone->id }}" {{ old('time_zone_id', $doctor->time_zone_id) == $zone->id ? 'selected' : '' }}>
                                    {{ $zone->time_zone }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Поля з PlaceOfWork -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div>
                        <label for="workplace" class="block text-base font-medium text-gray-700">Місце роботи</label>
                        <input type="text" name="workplace" id="workplace" placeholder="Місце роботи"
                            class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-4">
                    </div>

                    <div>
                        <label for="position" class="block text-base font-medium text-gray-700">Посада</label>
                        <input type="text" name="position" id="position" placeholder="Посада"
                            class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-4">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div>
                        <label for="country_of_residence" class="block text-base font-medium text-gray-700">Країна проживання</label>
                        <input type="text" name="country_of_residence" id="country_of_residence" placeholder="Країна"
                            class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-4">
                    </div>

                    <div>
                        <label for="city_of_residence" class="block text-base font-medium text-gray-700">Місто проживання</label>
                        <input type="text" name="city_of_residence" id="city_of_residence" placeholder="Місто"
                            class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-4">
                    </div>
                </div>

                <div class="pt-10">
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white text-lg font-semibold py-4 px-6 rounded-xl transition duration-300 ease-in-out shadow-xl">
                        Далі
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
