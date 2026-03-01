@extends('layouts.app')

@section('title', 'Create User')

@section('content')
    <section class="glass p-3 p-md-4">
        <h1 class="h3 mb-1">Create User</h1>
        <p class="text-muted-x mb-4">Add a new user account.</p>

        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            @include('users._form', ['submitLabel' => 'Create User'])
        </form>
    </section>
@endsection
