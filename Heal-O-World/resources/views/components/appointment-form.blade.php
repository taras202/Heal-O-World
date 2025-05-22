<div class="doctor-card">
    <div class="doctor-main">

        <!-- Правий блок — Розклад -->
        <div class="schedule">
            <h5>Запис на онлайн консультацію</h5>

            <div class="form-group">
                <label for="appointment_date_{{ $doctor->id }}">Дата консультації:</label>
                <div class="date-picker">
                    <button class="btn-change-date" onclick="changeDate({{ $doctor->id }}, -1)">←</button>
                    <input type="date" id="appointment_date_{{ $doctor->id }}" class="form-control" required>
                    <button class="btn-change-date" onclick="changeDate({{ $doctor->id }}, 1)">→</button>
                </div>
            </div>

            <div id="date-label-{{ $doctor->id }}" class="date-label"></div>

            <div class="available-times" id="available-times-{{ $doctor->id }}"></div>

        <div id="consultation-modal-{{ $doctor->id }}" class="modal">
            <div class="modal-content">
                <span class="close-modal" onclick="closeModal({{ $doctor->id }})">&times;</span>

                <form method="POST" action="{{ route('consultations.book') }}">
                    @csrf
                    <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                    <input type="hidden" name="patient_id" value="{{ auth()->user()?->patient?->id }}">
                    <input type="hidden" name="consultation_time" id="hidden-time-{{ $doctor->id }}">
                    <input type="hidden" name="appointment_date" id="hidden-date-{{ $doctor->id }}">

                    <div class="form-group">
                        <label for="first_name">Імʼя:</label>
                        <input type="text" class="form-control" name="first_name" value="{{ auth()->user()?->patient?->first_name }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="last_name">Прізвище:</label>
                        <input type="text" class="form-control" name="last_name" value="{{ auth()->user()?->patient?->last_name }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="note">Нотатка:</label>
                        <textarea class="form-control" name="notes" rows="3" placeholder="Опишіть ваш запит або симптоми..."></textarea>
                    </div>

                    <div class="form-group">
                        <label>Дата:</label>
                        <p id="modal-date-{{ $doctor->id }}"></p>
                    </div>

                    <div class="form-group">
                        <label>Час:</label>
                        <p id="modal-time-{{ $doctor->id }}"></p>
                    </div>

                    <button type="submit" class="btn-submit">Записатись</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function updateDateLabel(doctorId, dateStr) {
        const date = new Date(dateStr);
        const options = { day: 'numeric', month: 'long', year: 'numeric' };
        document.getElementById(`date-label-${doctorId}`).textContent = date.toLocaleDateString('uk-UA', options);
    }

    function fetchAvailableTimes(doctorId, date) {
        fetch(`/doctor/${doctorId}/free-times?appointment_date=${date}`)
            .then(response => {
                if (!response.ok) throw new Error('Помилка HTTP: ' + response.status);
                return response.json();
            })
            .then(times => {
                const container = document.getElementById(`available-times-${doctorId}`);
                container.innerHTML = '';

                if (!Array.isArray(times) || times.length === 0) {
                    container.innerHTML = '<p>Немає доступних годин на обрану дату.</p>';
                    return;
                }

                times.forEach(time => {
                    const button = document.createElement('button');
                    button.textContent = time.time;
                    button.className = 'btn btn-sm btn-outline-primary';
                    button.addEventListener('click', () => {
                    document.getElementById(`hidden-time-${doctorId}`).value = time.time;
                    document.getElementById(`modal-time-${doctorId}`).textContent = time.time;

                    const dateInput = document.getElementById(`appointment_date_${doctorId}`);
                    const selectedDate = dateInput.value;
                    document.getElementById(`hidden-date-${doctorId}`).value = selectedDate;
                    document.getElementById(`modal-date-${doctorId}`).textContent = new Date(selectedDate).toLocaleDateString('uk-UA');

                    document.getElementById(`consultation-modal-${doctorId}`).style.display = 'block';
                });

                    container.appendChild(button);
                });

                updateDateLabel(doctorId, date);
            })
            .catch(error => {
                console.error('Помилка при отриманні годин:', error);
                const container = document.getElementById(`available-times-${doctorId}`);
                container.innerHTML = '<p class="text-danger">Немає доступних годин на обрану дату.</p>';
            });
    }

    function changeDate(doctorId, offset) {
        const input = document.getElementById(`appointment_date_${doctorId}`);
        const current = new Date(input.value);
        current.setDate(current.getDate() + offset);

        const today = new Date();
        if (current < today) {
            return;
        }

        const newDate = current.toISOString().split('T')[0];
        input.value = newDate;

        input.setAttribute('min', newDate);
        
        fetchAvailableTimes(doctorId, newDate);
    }

    document.addEventListener('DOMContentLoaded', () => {
        const doctorId = {{ $doctor->id }};
        const input = document.getElementById(`appointment_date_${doctorId}`);
        const today = new Date().toISOString().split('T')[0];
        
        input.setAttribute('min', today); 
        input.value = today;
        
        fetchAvailableTimes(doctorId, today);

        input.addEventListener('change', () => {
            fetchAvailableTimes(doctorId, input.value);
        });
    });

    function closeModal(doctorId) {
            document.getElementById(`consultation-modal-${doctorId}`).style.display = 'none';
        }
        button.addEventListener('click', () => {
        document.getElementById(`hidden-time-${doctorId}`).value = time.time;
        document.getElementById(`hidden-date-${doctorId}`).value = date;
        document.getElementById(`consultation-modal-${doctorId}`).style.display = 'block';
    });
</script>

<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
        color: #333;
    }    

    /* Розклад консультацій */
    .schedule {
        margin-top: 20px;
    }

    .schedule h5 {
        font-size: 1.2rem;
        margin-bottom: 10px;
        color: #333;
    }

    /* Дата консультації */
    .form-group {
        margin-bottom: 15px;
    }

    .date-picker {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-change-date {
        background-color: #e0e0e0;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-change-date:hover {
        background-color: #d4d4d4;
    }

    .form-control {
        width: 200px;
    }

    .date-label {
        margin-bottom: 10px;
        font-weight: bold;
        font-size: 1.1rem;
    }

    /* Доступні години */
    .available-times {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .available-times button {
        background-color: #25639c;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }

    .available-times button:hover {
        background-color: #1d4d77;
    }

    /* Форма запису на консультацію */
    .consultation-form {
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        display: none;
    }

    .consultation-form .form-group {
        margin-bottom: 15px;
    }

    .consultation-form .form-control {
        width: 100%;
        padding: 10px;
        font-size: 1rem;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .consultation-form .form-control:focus {
        border-color: #25639c;
    }

    .btn-submit {
        display: inline-block;
        background-color: #28a745;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 5px;
        border: none;
        cursor: pointer;
    }

    .btn-submit:hover {
        background-color: #218838;
    }
    .doctor-main {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 30px;
    }

    .doctor-name {
        font-size: 1.5rem;
        font-weight: 600;
        color: #222;
        margin-bottom: 6px;
    }

    .specialties {
        padding-left: 1rem;
        margin: 0 0 8px 0;
    }

    .specialties li {
        list-style: disc;
        font-size: 1rem;
        color: #444;
    }

    .doctor-bio {
        font-size: 0.95rem;
        color: #555;
        margin-bottom: 10px;
    }

    .doctor-contact {
        font-weight: 500;
        color: #333;
    }
    .modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.5);
    }

    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 30px;
        border-radius: 10px;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        position: relative;
    }

    .close-modal {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 24px;
        font-weight: bold;
        color: #aaa;
        cursor: pointer;
    }

    .close-modal:hover {
        color: #000;
    }
</style>