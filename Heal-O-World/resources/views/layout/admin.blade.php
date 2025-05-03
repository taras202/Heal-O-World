<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>АДМІН ПАНЕЛЬ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<style>
    body, html {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    #wrapper {
        display: flex;
        height: 100vh;
    }

    #sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 250px;
        background-color: #343a40;
        padding-top: 20px;
        z-index: 1000;
    }

    #sidebar h3 {
        margin-bottom: 30px;
        text-align: center;
    }

    #sidebar ul {
        padding-left: 0;
        list-style-type: none;
    }

    #sidebar ul li {
        padding: 10px 20px;
    }

    #sidebar ul li a {
        display: block;
        padding: 10px 20px;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        margin-bottom: 10px;
        background-color: #007bff;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    #sidebar ul li a:hover {
        background-color: #0056b3;
    }

    
    .navbar {
        z-index: 1050;
        position: fixed;
        top: 0;
        width: 100%;
        left: 0;
        padding: 10px 0;
        background-color: rgb(10, 54, 102);
        color: white;
        margin-left: 250px; 
    }

        .navbar {
        display: flex;
        justify-content: center; 
    }

    .navbar .navbar-brand {
        flex-grow: 3;
        text-align: center;
    }

    #page-content-wrapper {
        margin-top: 80px;
        margin-left: 250px; 
        width: calc(100% - 250px); 
    }

    .nav-link.btn-danger {
        background-color: #dc3545;
        color: white;
        padding: 8px 15px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .nav-link.btn-danger:hover {
        background-color: #c82333;
    }

    .navbar a.navbar-brand {
        color: black;
        font-weight: bold;
    }

    .navbar-nav .nav-item .nav-link {
        color: white !important;
    }

    .navbar-nav .nav-item .nav-link:hover {
        color: rgb(23, 78, 133) !important;
    }

    
</style>


<body>
    <div class="d-flex" id="wrapper">
        <div class="bg-dark text-white p-4" id="sidebar">
            <h3>АДМІН ПАНЕЛЬ</h3>
            <ul class="list-unstyled">
                <li>
                    <a href="{{ route('admin.patients.index') }}" class="text-white">Пацієнти</a>
                </li>
                <li>
                    <a href="{{ route('admin.doctors.index') }}" class="text-white">Лікарі</a>
                </li>
            </ul>

            <form method="POST" action="{{ route('admin.logout') }}" class="logout-btn">
                @csrf
                <button type="submit" class="btn btn-danger w-100">Вийти</button>
            </form>
        </div>

        <div id="page-content-wrapper" class="container-fluid">
            
            <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">ГОЛОВНА</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Перемикач навігації">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container mt-4">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
