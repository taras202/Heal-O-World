@extends('layout.menu')

@section('title', 'Про нас')

@section('styles')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background-color: #f8f9fa;
            color: #212529;
        }

        .about-container {
            padding: 30px;
            background-color: #f9f9f9;
        }

        .about-header {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
            text-align: center;
        }

        .about-content {
            margin-top: 20px;
            font-size: 1.1rem;
            line-height: 1.6;
            color: #555;
        }

        .about-image {
            margin-top: 20px;
            max-width: 100%;
            height: auto;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .team-member img {
            transition: transform 0.3s ease;
        }
        .team-member img:hover {
            transform: scale(1.05);
        }
    </style>
@endsection

@section('content')

    

    <div class="about-container">
        <h1 class="about-header">Про нас</h1>
        <div class="about-content">
            <p>
                <strong>Heal-O-World</strong> — це сучасна онлайн-платформа, яка надає доступ до високоякісної медичної допомоги у зручному форматі. 
                Ми створені для того, щоб ви могли отримати консультацію лікаря, не виходячи з дому — швидко, безпечно та комфортно.
            </p>
            <p>
                Наша команда включає сертифікованих лікарів з багаторічним досвідом, які завжди готові допомогти у вирішенні ваших медичних питань. 
                Ми працюємо 24/7, щоб бути поруч саме тоді, коли ви цього потребуєте.
            </p>
            <p>
                У <strong>Heal-O-World</strong> ми поєднуємо сучасні технології з людяністю, забезпечуючи індивідуальний підхід та турботу до кожного пацієнта.
                Наші цінності — довіра, професіоналізм і доступність для всіх.
            </p>
            <img src="/images/doctor2.webp" alt="Команда лікарів Heal-O-World" class="about-image">
        </div>
    </div>

    </div>
    <div class="about-team" style="margin-top: 40px;">
        <h2 class="about-header">Наша команда</h2>
        <div class="team-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 20px;">
            <div class="team-member" style="text-align: center;">
                <img src="images/doctor2.png" alt="Dr. Ірина Коваль" style="width: 100%; border-radius: 10px;">
                <p><strong>Д-р Ірина Коваль</strong><br>Терапевт</p>
            </div>
            <div class="team-member" style="text-align: center;">
                <img src="images/doctor2.png" alt="Dr. Олександр Бондар" style="width: 100%; border-radius: 10px;">
                <p><strong>Д-р Олександр Бондар</strong><br>Педіатр</p>
            </div>
            <div class="team-member" style="text-align: center;">
                <img src="images/doctor2.png" alt="Dr. Наталія Романюк" style="width: 100%; border-radius: 10px;">
                <p><strong>Д-р Наталія Романюк</strong><br>Кардіолог</p>
            </div>
    </div>
</div>


@endsection


@section('scripts')
    <script>
        // Тут можна додати JavaScript, якщо він потрібен для цієї сторінки
    </script>
@endsection
