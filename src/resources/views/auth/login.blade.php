@extends('base')

@section('content')
    <div class="container mt-5">
        <!-- Session Status -->
        @if(session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required autocomplete="current-password">
                @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                <label class="form-check-label" for="remember_me">Remember me</label>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <!-- Forgot Password Link -->
                @if (Route::has('password.request'))
                    <a class="text-decoration-none" href="{{ route('password.request') }}">
                        Forgot your password?
                    </a>
                @endif

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Log in</button>
            </div>
        </form>
    </div>
@endsection
