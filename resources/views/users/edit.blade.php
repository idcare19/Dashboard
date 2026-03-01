@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <section class="glass p-3 p-md-4">
        <h1 class="h3 mb-1">Edit User</h1>
        <p class="text-muted-x mb-4">Update user details.</p>

        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            @include('users._form', ['user' => $user, 'submitLabel' => 'Update User'])
        </form>
    </section>
@endsection
