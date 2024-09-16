<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/sass/app.scss'])
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">TodoApp</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    @if(auth()->check())
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('todo.task.list', 'todo.task.*') ? 'active' : '' }}" aria-current="page" href="{{ route('todo.task.list') }}">Tasks</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('todo.category.list', 'todo.category.*') ? 'active' : '' }}" href="{{ route('todo.category.list') }}">Categories</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="/logout">Logout</a></li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('notification.list') ? 'active' : '' }}" href="{{ route('notification.list') }}">Notifications ({{ auth()->user()->unreadNotifications->count() }})</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('login') ? 'active' : '' }}" aria-current="page" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('register') ? 'active' : '' }}" href="{{ route('register') }}">Register</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <main class="py-4">
        @yield('content')
    </main>
</div>


@vite(['resources/js/app.js'])
</body>
</html>
