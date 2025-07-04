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
        flex-wrap: wrap;
        gap: 0.5rem;
        margin: 1rem 0;
        overflow-x: auto;
    }
    .filter-bar a {
        padding: 0.4rem 1rem;
        background: #f3f4f6;
        border-radius: 8px;
        text-decoration: none;
        color: #111;
        white-space: nowrap;
        transition: background 0.2s;
    }
    .filter-bar a:hover,
    .filter-bar a.active {
        background: #d0e3fa;
    }
</style>
@endsection

@section('content')
<div class="container" style="max-width: 1200px; margin: auto; padding: 2rem;">

    <div class="filter-bar">
        @foreach($specialties as $specialty)
            <a href="{{ route('doctor.index', ['specialty' => $specialty->name]) }}"
            data-specialty="{{ $specialty->name }}"
            class="{{ ($specialtyFilter ?? '') === $specialty->name ? 'active' : '' }}">
                {{ $specialty->name }}
            </a>
        @endforeach

        <a href="{{ route('doctor.index', ['specialty' => 'all']) }}"
        data-specialty="all"
        class="{{ ($specialtyFilter ?? '') === 'all' || empty($specialtyFilter) ? 'active' : '' }}">
            Усі спеціальності
        </a>
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
