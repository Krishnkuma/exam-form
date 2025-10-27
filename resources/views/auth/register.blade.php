@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <h3 class="form-title">Student Register</h3>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <input type="hidden" name="role" value="student">

        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" required>
        </div>

        <button type="submit" class="btn btn-success w-100">Register</button>

        <div class="text-center mt-3">
            <p>
                Already have an account?
                <a href="{{ route('login') }}">Login here</a>
            </p>
        </div>
    </form>
@endsection
