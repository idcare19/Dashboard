@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <section class="glass p-3 p-md-4" style="max-width: 540px; margin: 0 auto;">
        <h1 class="h3 mb-1">Login</h1>
        <p class="text-muted-x mb-4">Sign in to manage dashboard sessions and updates.</p>

        <form method="POST" action="{{ route('login.perform') }}" class="row g-3">
            @csrf

            <div class="col-12">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="col-12">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="col-12 form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">Remember me</label>
            </div>

            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Login</button>
                <a href="{{ route('portfolio') }}" class="btn btn-outline-light">Back to Portfolio</a>
            </div>

            <div class="col-12">
                <small class="text-muted-x">Admin account seeded: <strong>dream1mm113@gmail.com</strong></small>
            </div>
        </form>
    </section>
@endsection
