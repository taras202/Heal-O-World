@extends('layout.menu')

@section('title', 'Лікарі онлайн')

@section('styles')
    <style>
        /* Стилі для картки лікаря */
        .doctor-list-container {
            padding: 30px;
        }
        .doctor-header {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
        }
        .doctor-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
        }
        .doctor-info {
            display: flex;
            align-items: center;
            flex: 1 1 60%;
        }
        .doctor-info img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-right: 20px;
        }
        .doctor-info .details {
            flex: 1;
        }
        .doctor-info h3 {
            font-size: 1.5rem;
            color: #2c3e50;
            margin: 0;
        }
        .doctor-info p {
            color: #7f8c8d;
            margin: 5px 0;
        }
        .doctor-info .specialty {
            color: #16a085;
            font-weight: 500;
        }
        .doctor-info .price {
            font-weight: bold;
            color: #e74c3c;
        }
        .doctor-info .workplace {
            font-size: 0.9rem;
            color: #7f8c8d;
        }
        .book-button {
            background-color: #3498db;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1rem;
            margin-left: 20px;
            transition: background-color 0.3s;
        }
        .book-button:hover {
            background-color: #2980b9;
        }
        .rating {
            display: flex;
            align-items: center;
            color: #f39c12;
        }
        .rating span {
            font-size: 1.2rem;
            margin-left: 5px;
        }
        .doctor-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .doctor-card-header h4 {
            font-size: 1.2rem;
            color: #2c3e50;
        }
        .doctor-card-header .review-count {
            font-size: 1rem;
            color: #7f8c8d;
        }
    </style>
@endsection

@section('content')
    <div class="doctor-list-container">
        <h1 class="doctor-header">Лікарі онлайн</h1>

        @foreach($doctors as $doctor)
            <div class="doctor-card">
                <div class="doctor-info">
                <img src="{{ $doctor->photo ? asset('storage/' . $doctor->photo) : Vite::asset('resources/images/logo.png') }}" alt="Фото лікаря">
                    <div class="details">
                        <h3>{{ $doctor->first_name }} {{ $doctor->last_name }}</h3>
                        <p class="specialty">{{ $doctor->specialty ?? 'Не вказана спеціальність' }}</p>
                        <p class="price">{{ $doctor->price }} грн</p>
                        <p class="workplace">Місце роботи: {{ $doctor->workplace }}</p>
                        <div class="doctor-card-header">
                            <div class="rating">
                                <span>⭐ {{ $doctor->average_rating }} ({{ $doctor->review_count }} відгуків)</span>
                            </div>
                            <div class="review-count">
                                Відгуки: {{ $doctor->review_count }}
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('doctors.show', $doctor->id) }}" class="book-button">Записатись на консультацію</a>
                </div>
            </div>
        @endforeach
    </div>
    <footer>
        <p>&copy; 2025 Heal-O-World. Всі права захищено.</p>
    </footer>
@endsection

@section('scripts')
    <script>
        // Можна додати JavaScript функції для більш інтерактивної поведінки
    </script>
@endsection
