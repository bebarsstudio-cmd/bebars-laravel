<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BEBARS-GAMING - @yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">
                <a href="{{ route('home') }}">BEBARS<span>-GAMING</span></a>
            </div>
            <ul class="nav-menu">
                <li><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                <li><a href="{{ route('home') }}#news" class="nav-link">NEWS</a></li>
                <li><a href="{{ route('home') }}#about" class="nav-link">About</a></li>
                <li><a href="{{ route('home') }}#skills" class="nav-link">Skills</a></li>
                <li><a href="{{ route('home') }}#projects" class="nav-link">Projects</a></li>
                <li><a href="{{ route('home') }}#vs" class="nav-link">VS</a></li>
                <li><a href="{{ route('home') }}#feedback" class="nav-link">Feedback</a></li>
                <li><a href="{{ route('home') }}#contact" class="nav-link">Contact</a></li>
                @auth
                    @if(auth()->user()->is_admin)
                        <li><a href="{{ route('admin.dashboard') }}" class="nav-link">Admin</a></li>
                    @endif
                @endauth
            </ul>
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} BEBARS-GAMING. All rights reserved. | Built with <i class="fas fa-heart"></i> on Laravel</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>