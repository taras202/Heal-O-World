@extends('layout.menu-consultation-patient')

@section('content')
<style>
    .profile-container {
        display: flex;
        gap: 2rem;
        padding: 2rem 4rem;
        font-family: 'Segoe UI', sans-serif;
        max-width: 100%;
    }

    .profile-form {
        flex-grow: 1;
        background-color: white;
        border-radius: 12px;
        padding: 2.5rem;
        box-shadow: 0 0 10px rgba(0,0,0,0.05);
        min-width: 0;
    }

    .form-group,
    .form-row {
        margin-bottom: 1.5rem;
    }

    .form-row {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .form-row .col {
        flex: 1;
        min-width: 200px;
    }

    label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: block;
    }

    input[type="text"],
    input[type="date"],
    input[type="number"],
    select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
        transition: border 0.2s;
    }

    input:focus,
    select:focus {
        border-color: #007bff;
        outline: none;
    }

    .form-check {
        margin-bottom: 1rem;
    }

    .form-check-label {
        margin-left: 8px;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        padding: 10px 25px;
        border-radius: 8px;
        color: white;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .profile-block {
        background-color: #f8f9fa;
        border-radius: 12px;
        padding: 1.5rem;
        margin-top: 2rem;
        box-shadow: 0 0 8px rgba(0,0,0,0.03);
    }

    .profile-info {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-top: 1rem;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #ffffff;
        padding: 1rem;
        border: 1px solid #ddd;
        border-radius: 8px;
    }

    .info-item p {
        margin: 0.5rem 0 0 0;
        color: #555;
    }

    .btn-outline {
        background: none;
        border: 1px solid #007bff;
        color: #007bff;
        padding: 8px 18px;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-outline:hover {
        background: #007bff;
        color: white;
    }

    @media (max-width: 992px) {
        .profile-container {
            flex-direction: column;
            padding: 1rem;
        }

        .profile-form {
            padding: 1.5rem;
        }
    }
</style>

    <!-- Main form -->
    <div class="profile-form">
        <form method="POST" action="{{ $patient ? route('patient.update') : route('patient.store') }}">

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

            @csrf
            @if($patient)
                @method('PUT')
            @endif

        <h4 style="margin-bottom: 2rem;">Контактні дані</h4>

        <div class="form-row">
            <div class="col">
                <label for="first_name">Ім'я</label>
                <input type="text" name="first_name" id="first_name" required value="{{ old('first_name', $patient?->first_name) }}">
            </div>
            <div class="col">
                <label for="last_name">Прізвище</label>
                <input type="text" name="last_name" id="last_name" required value="{{ old('last_name', $patient?->last_name) }}">
            </div>
        </div>

        <div class="form-row">
            <div class="col">
                <label for="date_of_birth">Дата народження</label>
                <input type="date" name="date_of_birth" id="date_of_birth" required value="{{ old('date_of_birth', $patient?->date_of_birth) }}">
            </div>
            <div class="col">
                <label for="gender">Стать</label>
                <select name="gender" id="gender" required>
                    <option value="">Оберіть</option>
                    <option value="male" {{ old('gender', $patient?->gender) === 'male' ? 'selected' : '' }}>Чоловік</option>
                    <option value="female" {{ old('gender', $patient?->gender) === 'female' ? 'selected' : '' }}>Жінка</option>
                </select>
            </div>
            <div class="col">
                    <label for="has_insurance">Має страховку?</label>
                    <select name="has_insurance" id="has_insurance" required>
                        <option value="1" {{ old('has_insurance', $patient?->has_insurance) == 1 ? 'selected' : '' }}>Так</option>
                        <option value="0" {{ old('has_insurance', $patient?->has_insurance) == 0 ? 'selected' : '' }}>Ні</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="col">
                    <label for="country_of_residence">Країна</label>
                    <input type="text" name="country_of_residence" id="country_of_residence" required value="{{ old('country_of_residence', $patient?->country_of_residence) }}">
                </div>
                <div class="col">
                    <label for="city_of_residence">Місто</label>
                    <input type="text" name="city_of_residence" id="city_of_residence" required value="{{ old('city_of_residence', $patient?->city_of_residence) }}">
                </div>
            </div>

            <div class="input-group">
                <label>Часовий пояс</label>
                <select name="time_zone_id" class="...">
                    @foreach($timeZones as $tz)
                        <option value="{{ $tz->id }}"
                            {{ old('time_zone_id', $patient?->time_zone_id) == $tz->id ? 'selected' : '' }}>
                            {{ $tz->time_zone }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="notes">Примітки</label>
                <textarea name="notes" id="notes" rows="3">{{ old('notes', $patient?->notes) }}</textarea>
            </div>

            <button type="submit" class="btn-primary mt-3" id="submitBtn">
                {{ $patient ? 'Оновити дані' : 'Зберегти пацієнта' }}
            </button>
        </form>

        <!-- Phone & Email Section -->
        <div class="profile-block">
            <h4>Телефон та E-mail</h4>
            <div class="profile-info">
                <!-- PHONE -->
                <div class="info-item" data-type="phone">
                    <p class="display-text">{{ auth()->user()->phone }}</p>
                    <input type="text" class="edit-input" style="display:none;" value="{{ auth()->user()->phone }}">
                    <button type="button" class="btn-outline toggle-edit">Змінити</button>
                    <button type="button" class="btn-outline save-edit" style="display:none;">Зберегти</button>
                </div>

                <!-- EMAIL -->
                <div class="info-item" data-type="email">
                    <p class="display-text">{{ auth()->user()->email }}</p>
                    <input type="email" class="edit-input" style="display:none;" value="{{ auth()->user()->email }}">
                    <button type="button" class="btn-outline toggle-edit">Змінити</button>
                    <button type="button" class="btn-outline save-edit" style="display:none;">Зберегти</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('.info-item').forEach(item => {
        const toggleBtn = item.querySelector('.toggle-edit');
        const saveBtn = item.querySelector('.save-edit');
        const text = item.querySelector('.display-text');
        const input = item.querySelector('.edit-input');
        const type = item.dataset.type;

        toggleBtn.addEventListener('click', () => {
            input.style.display = 'inline-block';
            text.style.display = 'none';
            toggleBtn.style.display = 'none';
            saveBtn.style.display = 'inline-block';
        });

        saveBtn.addEventListener('click', async () => {
            const value = input.value.trim();

            if (!value) {
                alert('Поле не може бути порожнім');
                return;
            }

            try {
                const response = await fetch(`/patient/update-${type}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ [type]: value })
                });

                const data = await response.json();

                if (response.ok) {
                    text.textContent = value;
                    input.style.display = 'none';
                    text.style.display = 'inline-block';
                    toggleBtn.style.display = 'inline-block';
                    saveBtn.style.display = 'none';
                } else {
                    alert(data.message || 'Помилка збереження');
                }
            } catch (e) {
                console.error(e);
                alert('Помилка при збереженні');
            }
        });
    });

    // Додавання валідації паролю
    const passwordField = document.getElementById("password");
    const passwordConfirmationField = document.getElementById("password_confirmation");
    const submitBtn = document.getElementById("submitBtn");

    submitBtn.addEventListener("click", (event) => {
        const password = passwordField.value;
        const passwordConfirmation = passwordConfirmationField.value;

        const passwordPattern = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/;

        if (!passwordPattern.test(password)) {
            alert("Пароль повинен бути довжиною не менше 8 символів, містити цифри та спеціальні символи.");
            event.preventDefault();
            return;
        }

        if (password !== passwordConfirmation) {
            alert("Паролі не збігаються.");
            event.preventDefault();
            return;
        }
    });
});

// Функція для динамічного оновлення часового поясу
function updateTimezone() {
    const timezoneSelect = document.getElementById('timezone');
    const selectedTimezone = timezoneSelect.value;
    console.log("Оновлений часовий пояс:", selectedTimezone);
}
</script>

<script>
function updateTimezone() {
    const tz = document.getElementById('timezone').value;
    const now = new Date().toLocaleString("uk-UA", { timeZone: tz });
    alert("Обраний час: " + now);
}
</script>

@endsection
