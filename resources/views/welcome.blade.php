<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Laravel</a>

            <div class="ms-auto">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-warning">Register</a>
                @else
                    <a href="{{ url('/home') }}" class="btn btn-success">Dashboard</a>
                @endguest
            </div>
        </div>
    </nav>

    <div class="container text-center mt-5">
        <h1>Welcome to Laravel 12 + Bootstrap</h1>
        <p class="lead">Authentication powered by Laravel UI</p>
    </div>
</body>
</html>
