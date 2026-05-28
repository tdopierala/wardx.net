@extends('layouts.public')

@section('title', 'Login')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-4">
                <h4 class="mb-4 text-center" style="font-family: var(--font-mono); color: var(--accent);">
                    // admin login
                </h4>

                <form method="POST" action="/login">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label" style="font-family: var(--font-mono); font-size: 0.85rem;">email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label" style="font-family: var(--font-mono); font-size: 0.85rem;">password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember" style="font-family: var(--font-mono); font-size: 0.85rem;">remember_me</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100" style="font-family: var(--font-mono);">
                        $ login --auth
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
