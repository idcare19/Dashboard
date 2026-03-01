@extends('layouts.app')

@section('title', 'Request Temporary Access')

@section('content')
    <section class="glass p-3 p-md-4" style="max-width: 680px; margin: 0 auto;">
        <h1 class="h3 mb-1">Request Temporary Dashboard Access</h1>
        <p class="text-muted-x mb-4">Send your email. If admin approves, you will get a key valid for 1 hour.</p>

        <form method="POST" action="{{ route('access.request.submit') }}" class="row g-3">
            @csrf

            <div class="col-12">
                <label class="form-label">Your Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="col-12">
                <label class="form-label">Message (optional)</label>
                <textarea name="message" class="form-control" rows="4" placeholder="Tell why you need temporary access">{{ old('message') }}</textarea>
            </div>

            <div class="col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Send Request</button>
                <a href="{{ route('access.key.form') }}" class="btn btn-outline-light">I already have a key</a>
            </div>
        </form>
    </section>
@endsection
