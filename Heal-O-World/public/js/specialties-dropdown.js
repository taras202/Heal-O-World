document.addEventListener('DOMContentLoaded', () => {
    // Завантажуємо спеціальності
    fetch('/api/specialties')
        .then(res => {
            console.log('Статус відповіді:', res.status);
            return res.json();
        })
        .then(data => {
            console.log('Отримані спеціальності:', data);
            const select = document.getElementById('searchBySpecialty');
            data.forEach(spec => {
                const option = document.createElement('option');
                option.value = spec.name;
                option.textContent = spec.name;
                select.appendChild(option);
            });
        })
        .catch(err => {
            console.error('Не вдалося завантажити спеціальності:', err);
        });

    // Обробник кнопки пошуку спеціальності
    const btnSpecialty = document.getElementById('btnSpecialty');
    const selectSpecialty = document.getElementById('searchBySpecialty');

    btnSpecialty.addEventListener('click', () => {
        const specialty = selectSpecialty.value.trim();
        if (specialty.length < 2) {
            alert('Введіть спеціальність для пошуку.');
            return;
        }
        window.location.href = `/doctor/search-by-specialty?q=${encodeURIComponent(specialty)}`;
    });

    // Пошук лікаря та автопідказки
    const btnDoctorSearch = document.getElementById('btnDoctorSearch');
    const doctorSearchInput = document.getElementById('doctorSearchInput');
    const suggestionBox = document.getElementById('doctorSuggestions');

    btnDoctorSearch.addEventListener('click', () => {
        const query = doctorSearchInput.value.trim();
        if (query.length < 2) {
            alert('Введіть щонайменше 2 символи для пошуку.');
            return;
        }

        fetch(`/doctor/search-doctors?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                suggestionBox.innerHTML = '';
                if (data.length === 0) {
                    suggestionBox.innerHTML = '<li>Нічого не знайдено</li>';
                    return;
                }
                data.forEach(doctor => {
                    const li = document.createElement('li');
                    li.textContent = `${doctor.first_name} ${doctor.last_name}`;
                    li.addEventListener('click', () => {
                        window.location.href = `/doctor/${doctor.id}`;
                    });
                    suggestionBox.appendChild(li);
                });
            })
            .catch(() => {
                suggestionBox.innerHTML = '<li>Помилка пошуку</li>';
            });
    });

    doctorSearchInput.addEventListener('input', () => {
        const query = doctorSearchInput.value.trim();
        clearTimeout(window.searchTimeout);
        if (query.length < 2) {
            suggestionBox.innerHTML = '';
            return;
        }
        window.searchTimeout = setTimeout(() => {
            fetch(`/doctor/search-doctors?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    suggestionBox.innerHTML = '';
                    if (data.length === 0) {
                        suggestionBox.innerHTML = '<li>Нічого не знайдено</li>';
                        return;
                    }
                    data.forEach(doctor => {
                        const li = document.createElement('li');
                        li.textContent = `${doctor.first_name} ${doctor.last_name}`;
                        li.addEventListener('click', () => {
                            window.location.href = `/doctor/${doctor.id}`;
                        });
                        suggestionBox.appendChild(li);
                    });
                })
                .catch(() => {
                    suggestionBox.innerHTML = '<li>Помилка пошуку</li>';
                });
        }, 300);
    });
});
