@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <h3 class="form-title">Login</h3>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="role" class="form-label">Login As</label>
            <select name="role" id="role" class="form-select" required>
                <option value="admin">Admin</option>
                <option value="student">Student</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>

        <div class="text-center mt-3">
            <p>
                Don’t have an account?
                <a href="{{ route('register') }}">Register as Student</a>
            </p>
        </div>
    </form>
@endsection
