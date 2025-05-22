@extends('layout.menu')

@section('title', 'Лікарі')

@section('styles')
<style>
    .filter-bar {
        background-color: #e9f0fb;
        padding: 1rem;
        display: flex;
        flex-wrap: wrap;
        gap: 0.8rem;
        border-radius: 10px;
        margin-bottom: 2rem;
        justify-content: center;
    }

    .filter-bar a {
        background: #fff;
        border: 1px solid rgb(37, 79, 141);
        color:rgb(37, 79, 141);
        padding: 0.4rem 1rem;
        border-radius: 5px;
        font-weight: bold;
        text-decoration: none;
        transition: 0.2s ease-in-out;
        cursor: pointer;
    }

    .filter-bar a.active,
    .filter-bar a:hover {
        background-color:rgb(37, 79, 141);
        color: white;
    }

    .doctor-card {
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 0 12px rgba(0, 0, 0, 0.05);
        padding: 1.5rem;
        margin-bottom: 2rem;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .doctor-info {
        display: flex;
        gap: 1rem;
        flex: 1;
    }

    .doctor-info img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 10px;
        background-color: #f0f0f0;
    }

    .schedule {
        background: #f4f7fc;
        border-radius: 10px;
        padding: 1rem;
        text-align: center;
        min-width: 250px;
    }

    .schedule-times button {
        background-color: #dbeafe;
        border: none;
        padding: 0.5rem 1rem;
        margin: 0.25rem;
        border-radius: 5px;
        cursor: pointer;
    }

    .schedule-times button:hover {
        background-color:rgb(37, 79, 141);
        color: white;
    }
    .filter-bar {
    display: flex;
    overflow-x: auto;
    white-space: nowrap;
    gap: 8px;
    padding: 10px 0;
    border-bottom: 1px solid #ccc;
    }

    /* Додатково: стилі для посилань */
    .filter-bar a {
        flex: 0 0 auto;
        padding: 6px 12px;
        border: 1px solid #ddd;
        border-radius: 20px;
        background-color: #f7f7f7;
        text-decoration: none;
        color: #333;
        transition: background-color 0.2s ease;
    }

    .filter-bar a:hover {
        background-color: #e2e2e2;
    }

    .filter-bar a.active {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
    }
</style>
@endsection

@section('content')
<div class="container" style="max-width: 1200px; margin: auto; padding: 2rem;">
    <div class="filter-bar">
        <a href="#" data-specialty="Кардіолог">Кардіолог</a>
        <a href="#" data-specialty="Педіатр">Педіатр</a>
        <a href="#" data-specialty="Терапевт">Терапевт</a>
        <a href="#" data-specialty="Дерматолог">Дерматолог</a>
        <a href="#" data-specialty="Хірург">Хірург</a>
        <a href="#" data-specialty="Офтальмолог">Офтальмолог</a>
        <a href="#" data-specialty="Отоларинголог">Отоларинголог</a>
        <a href="#" data-specialty="Уролог">Уролог</a>
        <a href="#" data-specialty="Травматолог">Травматолог</a>
        <a href="#" data-specialty="Невропатолог">Невропатолог</a>
        <a href="#" data-specialty="Нарколог">Нарколог</a>
        <a href="#" data-specialty="Онколог">Онколог</a>
        <a href="#" data-specialty="Ендокринолог">Ендокринолог</a>
        <a href="#" data-specialty="Гастроентеролог">Гастроентеролог</a>
        <a href="#" data-specialty="Пульмонолог">Пульмонолог</a>
        <a href="#" data-specialty="Ревматолог">Ревматолог</a>
        <a href="#" data-specialty="Алерголог">Алерголог</a>
        <a href="#" data-specialty="Інфекціоніст">Інфекціоніст</a>
        <a href="#" data-specialty="Гінеколог">Гінеколог</a>
        <a href="#" data-specialty="Андролог">Андролог</a>
        <a href="#" data-specialty="Нефролог">Нефролог</a>
        <a href="#" data-specialty="Гематолог">Гематолог</a>
        <a href="#" data-specialty="Психіатр">Психіатр</a>
        <a href="#" data-specialty="Психотерапевт">Психотерапевт</a>
        <a href="#" data-specialty="Логопед">Логопед</a>
        <a href="#" data-specialty="Стоматолог">Стоматолог</a>
        <a href="#" data-specialty="Фізіотерапевт">Фізіотерапевт</a>
        <a href="#" data-specialty="Мамолог">Мамолог</a>
        <a href="#" data-specialty="Проктолог">Проктолог</a>
        <a href="#" data-specialty="Венеролог">Венеролог</a>
        <a href="#" data-specialty="all" class="active">Усі спеціальності</a>
    </div>

    <div id="doctors-list">
        @foreach($doctors as $doctor)
            @include('components.doctor-card', ['doctor' => $doctor])
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.querySelector('.container');

        container.addEventListener('click', function (e) {
            if (e.target.matches('.filter-bar a')) {
                e.preventDefault();
                const specialty = e.target.dataset.specialty;

                fetch(`{{ route('doctors.filter') }}?specialty=${encodeURIComponent(specialty === 'Усі спеціальності' ? 'all' : specialty)}`)
                    .then(response => response.text())
                    .then(html => {
                        document.querySelector('#doctors-list').innerHTML = html;

                        document.querySelectorAll('.filter-bar a').forEach(link => {
                            link.classList.remove('active');
                        });
                        e.target.classList.add('active');
                    });
            }
        });
    });
</script>

@endsection
