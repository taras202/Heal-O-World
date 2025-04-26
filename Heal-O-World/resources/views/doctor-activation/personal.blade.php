@extends('layout.menu')

@section('content')

<style>
  .stepper {
    border-left: 3px solid #d1d5db;
    padding-left: 20px;
    margin-left: 20px;
    margin-top: 50px;
  }

  .step {
    display: flex;
    align-items: center;
    margin-bottom: 30px;
  }

  .circle {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #d1d5db;
    color: white;
    text-align: center;
    line-height: 30px;
    font-weight: bold;
    margin-right: 15px;
    flex-shrink: 0;
  }

  .step span {
    color: #4b5563;
    font-size: 16px;
  }

  .step.active .circle {
    background: #3b82f6;
  }

  .step.active span {
    font-weight: 600;
    color: #3b82f6;
  }
</style>

<div class="flex min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-100">

    <!-- Сторона: Stepper -->
    <div class="hidden lg:flex w-1/4 justify-center">
        <div class="stepper">
            <div class="step active">
                <div class="circle">1</div>
                <span>Персональні дані</span>
            </div>
            <div class="step">
                <div class="circle">2</div>
                <span>Додаткові відомості</span>
            </div>
            <div class="step">
                <div class="circle">3</div>
                <span>Підтвердження</span>
            </div>
        </div>
    </div>

    <!-- Сторона: Форма -->
    <div class="flex flex-col flex-grow items-center justify-center px-6 py-12">
        <div class="w-full max-w-6xl bg-white p-12 rounded-3xl shadow-2xl ring-1 ring-blue-100">
            <h2 class="text-4xl font-bold text-center text-blue-700 mb-10">
                Заповніть персональні дані
            </h2>

            <form method="POST" enctype="multipart/form-data" action="{{ url('/activation/personal-data') }}" class="space-y-10">
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

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div>
                        <label for="gender" class="block text-base font-medium text-gray-700">Стать</label>
                        <select name="gender" id="gender"
                            class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-4">
                            <option value="">Оберіть стать</option>
                            <option value="male">Чоловік</option>
                            <option value="female">Жінка</option>
                        </select>
                    </div>

                    <div>
                        <label for="photo" class="block text-base font-medium text-gray-700">Фото</label>
                        <input type="file" name="photo" id="photo"
                            class="mt-2 block w-full text-base text-gray-600 file:bg-blue-100 file:text-blue-800 file:border-none file:px-5 file:py-3 file:rounded-lg hover:file:bg-blue-200 transition duration-200">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div>
                        <label for="country_of_residence" class="block text-base font-medium text-gray-700">Країна</label>
                        <input type="text" name="country_of_residence" id="country_of_residence" placeholder="Україна"
                            class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-4">
                    </div>

                    <div>
                        <label for="city_of_residence" class="block text-base font-medium text-gray-700">Місто</label>
                        <input type="text" name="city_of_residence" id="city_of_residence" placeholder="Київ"
                            class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-4">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div>
                        <label for="contact" class="block text-base font-medium text-gray-700">Контактний телефон</label>
                        <input type="text" name="contact" id="contact" placeholder="+380..."
                            class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-4">
                    </div>

                    <div>
                        <label for="time_zone" class="block text-base font-medium text-gray-700">Часовий пояс</label>
                        <input type="number" name="time_zone" id="time_zone" placeholder="+2"
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
