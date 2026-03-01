@extends('layouts.app')

@section('title', 'Enter Access Key')

@section('content')
    <section class="glass p-3 p-md-4" style="max-width: 680px; margin: 0 auto;">
        <h1 class="h3 mb-1">Enter Access Key</h1>
        <p class="text-muted-x mb-4">Use your approved email + access key to preview dashboard for up to 1 hour.</p>

        <form method="POST" action="{{ route('access.key.verify') }}" class="row g-3">
            @csrf

            <div class="col-12">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="col-12">
                <label class="form-label">Access Key</label>
                <input type="text" name="access_key" class="form-control" required>
            </div>

            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Verify Key</button>
                <a href="{{ route('access.request.form') }}" class="btn btn-outline-light">Request a key</a>
            </div>
        </form>
    </section>
@endsection
