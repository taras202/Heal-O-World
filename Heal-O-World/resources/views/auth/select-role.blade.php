@extends('layout.menu')

@section('title', 'Вибір ролі')

@section('styles')
<style>
    .btn {
    padding: 12px 24px;
    border-radius: 30px;
    font-size: 16px;
    font-weight: bold;
    transition: all 0.3s ease;
    text-align: center;
    display: inline-block;
    margin-top: 20px;
    }

    .btn-primary {
        background-color: #007bff;
        color: #fff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-secondary {
        background-color: #28a745;
        color: #fff;
        border: none;
    }

    .btn-secondary:hover {
        background-color: #218838;
    }
</style>

@section('content')
    <div class="container">
        <h1>Виберіть роль</h1>
        <a href="{{ route('auth.doctor.login.form') }}" class="btn btn-primary">Лікар</a>
        <a href="{{ route('auth.patient.login.form') }}" class="btn btn-secondary">Пацієнт</a>
    </div>
@endsection
