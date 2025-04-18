@extends('layout.menu')

@section('title', 'Реєстрація')

@section('styles')
    <style>
        .registration-container {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .registration-container h1 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .form-label {
            font-size: 1rem;
            margin-bottom: 5px;
            color: #555;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #4CAF50;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #45a049;
        }

        p {
            margin-top: 10px;
        }

        p a {
            color: #4CAF50;
            font-weight: bold;
        }

        p a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            font-size: 0.9rem;
            margin-top: 5px;
        }
    </style>
@endsection

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


        <form method="POST" action="{{ route('auth.' . $role . '.register', $role) }}">
            @csrf
            <input type="hidden" name="role" value="{{ $role }}">

            <div class="form-group">
                <label for="phone" class="form-label">Телефон</label>
                <input type="phone" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" required>
                @error('phone')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Електронна пошта</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autocomplete="username">
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Пароль</label>
                <input type="password" name="password" id="password" class="form-control" required autocomplete="new-password">
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Підтвердження пароля</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required autocomplete="new-password">
                @error('password_confirmation')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn">Зареєструватися</button>
        </form>

        <p>Вже є акаунт? <a href="{{ route('auth.' . $role . '.login.form') }}">Увійти</a></p>
    </div>
@endsection
