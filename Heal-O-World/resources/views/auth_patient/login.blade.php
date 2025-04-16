@extends('layout.menu')

@section('title', 'Вхід пацієнта')

@section('content')
    <style>
        .container {
            max-width: 400px;
            margin: 4rem auto;
            background: #ffffff;
            padding: 2.5rem;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #0d3681;
            margin-bottom: 2rem;
        }

        label {
            font-weight: 600;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            margin-top: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 12px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-control:focus {
            border-color: #3c8dfc;
            box-shadow: 0 0 5px rgba(60, 141, 252, 0.4);
            outline: none;
        }

        .is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 0.9rem;
            margin-top: -0.5rem;
            margin-bottom: 1rem;
        }

        .btn-primary {
            width: 100%;
            background: linear-gradient(135deg, #1e60c2, #3c8dfc);
            color: white;
            padding: 0.75rem;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #154798, #2c72d4);
            transform: translateY(-2px);
        }

        .mt-3 {
            margin-top: 1rem;
            text-align: center;
        }

        .mt-3 a {
            color: #1e60c2;
            text-decoration: none;
            font-weight: 500;
        }

        .mt-3 a:hover {
            text-decoration: underline;
        }
    </style>

    <div class="container">
        <h2>Вхід для пацієнта</h2>
        
        <form method="POST" action="{{ route('patient.login') }}">
            @csrf

            <div>
                <label for="email">Електронна пошта</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" value="{{ old('email') }}" required>
                
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div>
                <label for="password">Пароль</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                       id="password" name="password" required autocomplete="off">
                
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn-primary">Увійти</button>
        </form>
        
        <p class="mt-3">Ще немає акаунта? <a href="{{ route('login') }}">Повернутись</a></p>
    </div>
@endsection
