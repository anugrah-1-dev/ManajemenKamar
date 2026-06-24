@extends('layouts.app')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="bg-white p-4 rounded shadow-sm" style="width: 100%; max-width: 500px;">
            <div class="text-center mb-4">
                <img src="{{ asset('asset/icon/kitty.png') }}" id="catHead" width="120" alt="Cat Head">

                <h4 class="mt-3">{{ __('Login Admin') }}</h4>
            </div>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autofocus>

                    @error('email')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3 position-relative">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <div class="input-group">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required>

                        <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>
                    </div>

                    @error('password')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const togglePassword = document.getElementById('togglePassword');
                        const passwordInput = document.getElementById('password');
                        const eyeIcon = document.getElementById('eyeIcon');

                        togglePassword.addEventListener('click', function() {
                            const isPassword = passwordInput.type === 'password';
                            passwordInput.type = isPassword ? 'text' : 'password';
                            eyeIcon.classList.toggle('bi-eye');
                            eyeIcon.classList.toggle('bi-eye-slash');
                        });
                    });
                </script>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Login') }}
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
