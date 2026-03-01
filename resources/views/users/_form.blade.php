@php
    $isEdit = isset($user);
@endphp

<div class="row g-3">
    <div class="col-12">
        <label class="form-label" for="name">Name</label>
        <input
            type="text"
            id="name"
            name="name"
            class="form-control"
            value="{{ old('name', $user->name ?? '') }}"
            required
        >
    </div>

    <div class="col-12">
        <label class="form-label" for="email">Email</label>
        <input
            type="email"
            id="email"
            name="email"
            class="form-control"
            value="{{ old('email', $user->email ?? '') }}"
            required
        >
    </div>

    <div class="col-12">
        <label class="form-label" for="role">Role</label>
        <select id="role" name="role" class="form-select" required>
            @php
                $selectedRole = old('role', $user->role ?? 'user');
            @endphp
            <option value="user" {{ $selectedRole === 'user' ? 'selected' : '' }}>User</option>
            <option value="admin" {{ $selectedRole === 'admin' ? 'selected' : '' }}>Admin</option>
        </select>
    </div>

    <div class="col-12 col-md-6">
        <label class="form-label" for="password">
            Password
            @if ($isEdit)
                <small class="text-muted-x">(leave blank to keep current)</small>
            @endif
        </label>
        <input
            type="password"
            id="password"
            name="password"
            class="form-control"
            {{ $isEdit ? '' : 'required' }}
        >
    </div>

    <div class="col-12 col-md-6">
        <label class="form-label" for="password_confirmation">Confirm Password</label>
        <input
            type="password"
            id="password_confirmation"
            name="password_confirmation"
            class="form-control"
            {{ $isEdit ? '' : 'required' }}
        >
    </div>

    <div class="col-12 d-flex gap-2 mt-2">
        <button type="submit" class="btn btn-primary">{{ $submitLabel ?? 'Save User' }}</button>
        <a href="{{ route('users.index') }}" class="btn btn-outline-light">Cancel</a>
    </div>
</div>
