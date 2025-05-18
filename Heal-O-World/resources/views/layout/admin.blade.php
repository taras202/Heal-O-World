<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>АДМІН ПАНЕЛЬ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
    html, body {
        height: 100%;
        margin: 0;
    }

    #wrapper {
        display: flex;
        min-height: 100vh;
    }

    #sidebar {
        width: 265px;
        background-color: #343a40;
        padding: 20px;
        color: white;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
    }

    #page-content-wrapper {
        flex-grow: 1;
        padding: 20px;
        display: flex;  
        flex-direction: column;
        align-items: flex-start; 
    }

    #sidebar h3 {
        text-align: center;
        margin-bottom: 30px;
        font-weight: bold;
        color: #00d1ff;
    }

        #sidebar a {
        display: block;
        color: #cfd8dc;
        padding: 12px 20px;
        border-radius: 8px;
        margin-bottom: 10px;
        text-decoration: none;
        transition: all 0.3s ease;
        text-align: center;
    }


    #sidebar .link-blue {
        background-color: #007bff;
    }

    #sidebar .link-blue:hover {
        background-color: #0056b3;
    }

    #sidebar .link-green {
        background-color: #28a745;
    }

    #sidebar .link-green:hover {
        background-color: #218838;
    }

    #sidebar a:hover, #sidebar a.active {
        background-color: #00bcd4;
        color: white;
    }

    .logout-btn button {
        margin-top: 30px;
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        transition: background-color 0.3s ease;
    }

        #sidebar .link-yellow {
        background-color: #ffc107;
        color: #212529; 
    }

    #sidebar .link-yellow:hover {
        background-color: #e0a800; 
        color: white;
    }

    #sidebar .link-yellow.active {
        font-weight: bold;
        border-left: 4px solid #e0a800;
        background-color: #e0a800;
        color: white;
    }

    .logout-btn button:hover {
        background-color: #c82333;
    }

        .navbar {
        position: fixed;
        top: 0;
        left: 265px;
        width: calc(100% - 265px); 
        height: 70px; 
        background-color: #0056b3;
        color: white;
        z-index: 1030;
        padding: 0 30px; 
        display: flex;
        align-items: center;
        justify-content: center;
        transition: none;
        box-sizing: border-box;
    }

        .navbar .navbar-brand {
        font-size: 1.5rem;
        font-weight: 600;
        color: #fff;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin: 0 auto;
    }

    .navbar-nav .nav-link {
        color: #fff !important;
    }

    .navbar-nav .nav-link:hover {
        color: #d1ecf1 !important;
    }
    .admin-sidebar-box {
    background-color: #495057;
    padding: 12px 16px;
    border-radius: 10px;
    color: #fff;
    animation: slideFadeIn 0.6s ease-out forwards;
    opacity: 0;
    transform: translateX(-10px);
}

    .admin-avatar-sidebar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #00d1ff;
    }

    @keyframes slideFadeIn {
        to {
            opacity: 1;
            transform: translateX(0);
        }
        .badge {
    font-size: 0.75rem;
    padding: 0.3em 0.6em;
    border-radius: 6px;
    }

    }
    #page-content-wrapper {
        margin-top: 80px;
        padding: 20px 30px;
        display: flex;
        flex-direction: column;
        align-items: flex-start; 
        flex-grow: 1;
    }

    .btn {
        border-radius: 10px;
    }

    .table th {
        background-color: #007bff;
        color: white;
    }

    .table td, .table th {
        vertical-align: middle;
    }

    @media (max-width: 768px) {
        #sidebar {
            display: none;
        }

        .navbar {
            left: 0;
            width: 100%;
        }

        #page-content-wrapper {
            margin-left: 0;
        }
    }
</style>



</head>
<body>
<div class="d-flex" id="wrapper">
    <div id="sidebar">
        <h3>АДМІН ПАНЕЛЬ</h3>
        <a href="{{ route('admin.patients.index') }}" class="sidebar-link link-blue {{ request()->routeIs('admin.patients.index') ? 'active' : '' }}">Пацієнти</a>
        <a href="{{ route('admin.doctors.index') }}" class="sidebar-link link-green {{ request()->routeIs('admin.doctors.index') ? 'active' : '' }}">Лікарі</a>
        <a href="{{ route('admin.patient.patient-consultation.index') }}" class="sidebar-link link-yellow {{ request()->routeIs('admin.patient.patient-consultation.index') ? 'active' : '' }}">Перегляд консультацій
    </a>

        <form method="POST" action="{{ route('admin.logout') }}" class="logout-btn mt-3">
            @csrf
            <button type="submit" class="btn btn-danger w-100">Вийти</button>
        </form>

        @php
        use Illuminate\Support\Facades\Auth;
        $admin = Auth::guard('admin')->user(); 
        @endphp

        <div class="admin-sidebar-box mt-3 mb-4 animate-entry">
            <div class="d-flex align-items-center gap-3">
                <div>
                    <strong>{{ $admin->name ?? 'Адміністратор' }}</strong><br>
                    <small class="text-light">{{ $admin->email ?? 'admin@example.com' }}</small><br>
                    <span class="badge bg-info text-dark mt-1">
                        {{ $admin->role ?? 'Головний адмін' }}
                    </span>
                </div>
            </div>
        </div>

        </div>
               
        <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-dark d-flex justify-content-center">
            <div class="container-fluid justify-content-center">
                <a class="navbar-brand mx-auto" href="#">ГОЛОВНА</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
        <div class="container-fluid mt-4">
            @yield('content')
        </div>
    </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
