<div>
    <h4 class="text-lg font-semibold mb-2">Запис на онлайн консультацію</h4>

    <div style="background-color: #f0f6ff; padding: 1rem; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <p class="mb-2 font-medium">Оберіть зручний час:</p>
        <div style="display: flex; flex-wrap: wrap; gap: 10px;">
            @foreach(['10:00', '11:00', '13:00', '15:00', '17:00'] as $time)
                <button type="button" class="open-modal-btn"
                        data-time="{{ $time }}"
                        style="padding: 0.5rem 1rem; border-radius: 6px; background-color: #e5efff; border: 1px solid #aac4e9; cursor: pointer;">
                    {{ $time }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- Модальне вікно -->
    <div id="appointment-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
            <button id="close-modal" class="absolute top-2 right-2 text-gray-500 hover:text-red-600 text-2xl">&times;</button>

            <h3 class="text-xl font-semibold mb-4">Заповніть дані для запису</h3>

            <form method="POST" action="{{ route('doctor.consultations.store') }}">
                @csrf
                <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                <input type="hidden" name="consultation_time" id="modal-time" required>

                <div class="mb-2">
                    <label for="appointment_date">Дата консультації:</label>
                    <input type="date" name="appointment_date" required class="w-full border px-2 py-1 rounded">
                </div>

                <div class="mb-2">
                    <label for="diagnosis">Причина звернення:</label>
                    <input type="text" name="diagnosis" class="w-full border px-2 py-1 rounded" required>
                </div>

                <div class="mb-2">
                    <label for="notes">Коментар:</label>
                    <textarea name="notes" rows="2" class="w-full border px-2 py-1 rounded"></textarea>
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Підтвердити запис
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('appointment-modal');
    const closeModal = document.getElementById('close-modal');
    const modalTimeInput = document.getElementById('modal-time');

    document.querySelectorAll('.open-modal-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const selectedTime = btn.getAttribute('data-time');
            modalTimeInput.value = selectedTime;
            modal.classList.remove('hidden');
        });
    });

    closeModal.addEventListener('click', () => {
        modal.classList.add('hidden');
    });

    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
        }
    });
});
</script>
@endpush
