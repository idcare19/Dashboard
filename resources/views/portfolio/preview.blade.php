@extends('layouts.app')

@section('title', 'Dashboard Preview')

@section('content')
    <section class="glass p-3 p-md-4 mb-3">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
            <div>
                <h1 class="h3 mb-1">Dashboard Preview</h1>
                <p class="text-muted-x mb-0">Preview graphs, upcoming projects, and latest updates.</p>
            </div>

            @if (! auth()->check())
                <form action="{{ route('access.session.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light">End Temporary Session</button>
                </form>
            @endif
        </div>
    </section>

    <section class="glass p-3 p-md-4 mb-3">
        <h2 class="h5 mb-3">Graph Showcase</h2>
        @php
            $points = $portfolio->graph_points ?? [];
            $max = max($points ?: [1]);
        @endphp
        <div class="d-flex align-items-end gap-2" style="height:220px;">
            @foreach ($points as $p)
                <div class="bg-info rounded-top" style="width: 100%; max-width: 56px; height: {{ max(8, (int) (($p / $max) * 100)) }}%;" title="{{ $p }}"></div>
            @endforeach
        </div>
    </section>

    <section class="glass p-3 p-md-4 mb-3">
        <h2 class="h5 mb-3">Upcoming Projects</h2>
        <div class="row g-3">
            @foreach (($portfolio->upcoming_projects ?? []) as $item)
                <div class="col-12 col-md-6">
                    <div class="border rounded p-3 h-100">
                        <h3 class="h6 mb-1">{{ $item['title'] ?? '' }}</h3>
                        <div class="text-muted-x small mb-2">ETA: {{ $item['eta'] ?? '' }}</div>
                        <p class="mb-0">{{ $item['details'] ?? '' }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="glass p-3 p-md-4">
        <h2 class="h5 mb-3">Latest Updates</h2>
        <ul class="list-group">
            @foreach (($portfolio->updates_feed ?? []) as $update)
                <li class="list-group-item bg-transparent text-light border-secondary">
                    <div class="fw-semibold">{{ $update['title'] ?? '' }}</div>
                    <small class="text-muted-x">{{ $update['date'] ?? '' }}</small>
                </li>
            @endforeach
        </ul>

        @auth
            @if (auth()->user()->isAdmin() && filled($portfolio->admin_notes))
                <div class="alert alert-warning mt-3 mb-0">
                    <strong>Admin-only notes:</strong> {{ $portfolio->admin_notes }}
                </div>
            @endif
        @endauth
    </section>
@endsection
