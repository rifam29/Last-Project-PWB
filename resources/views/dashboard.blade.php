<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container text-center mt-5">
        @csrf
        <!-- Dashboard Konten -->

        @if (Auth::check())
            <h1>Welcome to Your Dashboard, {{ Auth::user()->name }}!</h1>
            <p>Your email: {{ Auth::user()->email }}</p>

            <!-- Tombol Register hanya untuk admin -->
            @if (Auth::user()->role_id == 1)
                <a href="{{ route('auth.register') }}" class="btn btn-primary">Register</a>
            @endif

            <a href="{{ route('logout') }}" class="btn btn-danger mt-3">Logout</a>
        @else
            <h1>Welcome, Guest!</h1>
            <p>Please <a href="{{ route('login.view') }}" class="btn btn-primary">Login</a> to access your dashboard.
            </p>
        @endif
    </div>
</body>

</html>