@extends('layouts.app')

@section('content')
    <style>
        :root {
            --unair-blue: #004C9D;
            --unair-blue-light: #0F7BFF;
            --unair-yellow: #FFD100;
            --unair-yellow-light: #FFF2B3;
        }

        .login-wrapper {
            position: relative;
            min-height: 80vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            background: radial-gradient(1200px 800px at 50% 0%, rgba(255, 209, 0, 0.10), transparent 70%),
                        radial-gradient(900px 700px at 100% 100%, rgba(15, 123, 255, 0.14), transparent 65%),
                        linear-gradient(160deg, #0A1B35 0%, #11294C 55%, #0D2147 100%);
        }

        .login-bg {
            position: absolute;
            inset: 0;
            overflow: hidden;
            z-index: 0;
            pointer-events: none;
        }

        .bg-shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(40px);
            opacity: .3;
            animation: bgFloat 9s ease-in-out infinite alternate;
        }

        .bg-shape-blue {
            width: 420px;
            height: 420px;
            left: -120px;
            top: -80px;
            background: radial-gradient(circle at 40% 40%, var(--unair-blue-light), var(--unair-blue));
            animation-delay: 0s;
        }

        .bg-shape-yellow {
            width: 360px;
            height: 360px;
            right: -80px;
            bottom: -60px;
            background: radial-gradient(circle at 60% 40%, var(--unair-yellow-light), var(--unair-yellow));
            animation-delay: 2s;
        }

        .bg-line {
            position: absolute;
            height: 2px;
            width: 180px;
            background: linear-gradient(90deg, transparent, rgba(120, 180, 255, .45), transparent);
            transform: rotate(-45deg);
            opacity: .35;
            animation: lineSlide 9s linear infinite;
        }

        .bg-line-1 { top: 20%; left: -10%; animation-delay: 0s; }
        .bg-line-2 { top: 60%; left: -20%; animation-delay: 3s; }
        .bg-line-3 { top: 40%; right: -15%; transform: rotate(45deg); animation-delay: 6s; }

        @keyframes bgFloat {
            0% { transform: translate(0,0) scale(1); }
            50% { transform: translate(26px,-22px) scale(1.08); }
            100% { transform: translate(-18px,16px) scale(1.03); }
        }

        @keyframes lineSlide {
            0% { transform: translateX(-120%) rotate(-45deg); opacity: 0; }
            20% { opacity: .35; }
            80% { opacity: .35; }
            100% { transform: translateX(120%) rotate(-45deg); opacity: 0; }
        }

        /* ===== Latar belakang khas BIEPLUS (BIE+) ===== */
        .brand-float {
            position: absolute;
            opacity: .3;
            color: #5AA9FF;
            user-select: none;
            pointer-events: none;
            font-weight: 800;
            line-height: 1;
            animation: elemIn .9s ease backwards;
            filter: drop-shadow(0 8px 22px rgba(15, 123, 255, .35));
        }

        .brand-float::after {
            content: '';
            position: absolute;
            inset: -20%;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 209, 0, .3), transparent 65%);
            z-index: -1;
            animation: haloPulse 3s ease-in-out infinite;
        }

        .fb-wordmark {
            font-size: clamp(40px, 6.5vw, 72px);
            letter-spacing: -.02em;
        }

        .fb-1 {
            top: 11%;
            left: 7%;
            color: #5AA9FF;
            transform-origin: bottom center;
            animation: elemIn .9s ease backwards, floatY 6s ease-in-out 1s infinite;
        }

        .fb-2 {
            bottom: 13%;
            right: 7%;
            color: var(--unair-yellow);
            transform-origin: top center;
            animation: elemIn .9s .2s ease backwards, swing 5s ease-in-out 1.2s infinite;
        }

        .fb-plus {
            font-size: clamp(56px, 9vw, 108px);
            font-weight: 900;
        }

        .fp-1 {
            top: 15%;
            right: 11%;
            color: var(--unair-blue-light);
            animation: elemIn .9s .35s ease backwards, pulsePlus 3.6s ease-in-out 1.3s infinite;
        }

        .fp-2 {
            bottom: 18%;
            left: 11%;
            color: var(--unair-yellow);
            animation: elemIn .9s .5s ease backwards, spinSlow 16s linear 1.2s infinite;
        }

        .fb-tag {
            top: 4%;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: clamp(12px, 1.5vw, 16px);
            font-weight: 700;
            letter-spacing: .45em;
            text-transform: uppercase;
            color: #A8CFFF;
            opacity: .35;
            animation: elemIn .9s .65s ease backwards, driftX 7s ease-in-out 1.5s infinite;
        }

        .fb-tag::after {
            display: none;
        }

        @keyframes floatY {
            0%, 100% { transform: translateY(0) rotate(-4deg); }
            50% { transform: translateY(-18px) rotate(4deg); }
        }

        @keyframes swing {
            0%, 100% { transform: rotate(-10deg); }
            50% { transform: rotate(10deg); }
        }

        @keyframes driftX {
            0%, 100% { transform: translateX(-20px) rotate(-3deg); }
            50% { transform: translateX(20px) rotate(3deg); }
        }

        @keyframes pulsePlus {
            0%, 100% { transform: scale(1) rotate(0deg); }
            50% { transform: scale(1.18) rotate(90deg); }
        }

        @keyframes spinSlow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @keyframes elemIn {
            0% { opacity: 0; transform: scale(.5) translateY(24px); }
            100% { opacity: .3; transform: none; }
        }

        @keyframes haloPulse {
            0%, 100% { transform: scale(.9); opacity: .55; }
            50% { transform: scale(1.15); opacity: .95; }
        }

        .login-card {
            position: relative;
            z-index: 1;
            background: rgba(255,255,255, .98);
            backdrop-filter: saturate(140%) blur(4px);
            border: 1px solid rgba(0,76,157,.08);
            border-radius: 1rem;
            box-shadow: 0 20px 60px -20px rgba(0, 76, 157, .25);
            transition: transform .3s ease, box-shadow .3s ease;
            width: 100%;
            max-width: 500px;
            padding: 2rem 1.5rem;
            overflow: hidden;
        }

        /* kilau ala kartun: kilau cahaya jalan dari pojok kanan ke kiri */
        .login-card::before {
            content: '';
            position: absolute;
            top: -25%;
            bottom: -25%;
            left: 0;
            width: 38%;
            z-index: -1;
            background: linear-gradient(100deg,
                transparent 0%,
                rgba(255, 209, 0, .20) 30%,
                rgba(255, 255, 255, .95) 50%,
                rgba(15, 123, 255, .20) 70%,
                transparent 100%);
            transform: translateX(260%) rotate(14deg);
            animation: gleamSweep 5s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes gleamSweep {
            0%, 8%   { transform: translateX(260%) rotate(14deg); }
            55%, 100% { transform: translateX(-220%) rotate(14deg); }
        }

        .login-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 24px 70px -20px rgba(0, 76, 157, .35);
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: .5rem .75rem;
            border-radius: 999px;
            background: linear-gradient(135deg, rgba(0,76,157,.08) 0%, rgba(255,209,0,.12) 100%);
            border: 1px solid rgba(0,76,157,.12);
            margin-bottom: .5rem;
            animation: pulseGlow 3.2s ease-in-out infinite;
        }

        @keyframes pulseGlow {
            0%,100% { box-shadow: 0 0 0 0 rgba(255,209,0,.25); }
            50% { box-shadow: 0 0 0 6px rgba(255,209,0,0); }
        }

        .login-title {
            color: var(--unair-blue);
            font-weight: 700;
            letter-spacing: -.01em;
            margin-top: .75rem;
        }

        .form-label {
            color: #1f3f63;
            font-weight: 500;
        }

        .form-control {
            border-color: rgba(31,63,99,.12);
            border-radius: .75rem;
            padding: .625rem .875rem;
            transition: border-color .2s ease, box-shadow .2s ease, transform .15s ease;
        }

        .form-control:focus {
            border-color: var(--unair-blue);
            box-shadow: 0 0 0 .25rem rgba(0, 76, 157, .12);
            transform: translateY(-1px);
        }

        .input-group .btn {
            border-radius: 0 .75rem .75rem 0;
        }

        .btn-login {
            background: linear-gradient(135deg, var(--unair-yellow) 0%, #FFE44D 100%);
            border: none;
            color: var(--unair-blue);
            font-weight: 700;
            letter-spacing: .02em;
            border-radius: .75rem;
            padding: .7rem 1rem;
            transition: color .3s ease, transform .15s ease, box-shadow .3s ease;
            position: relative;
            overflow: hidden;
            isolation: isolate;
        }

        .btn-login > span {
            position: relative;
            z-index: 3;
            transition: color .35s ease;
        }

        /* lapisan biru yang muncul saat kursor masuk (kuning -> biru) */
        .btn-login::after {
            content: '';
            position: absolute;
            inset: 0;
            z-index: 1;
            background: linear-gradient(135deg, var(--unair-blue) 0%, var(--unair-blue-light) 100%);
            opacity: 0;
            transition: opacity .35s ease;
            pointer-events: none;
        }

        .btn-login:hover {
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 14px 34px -16px rgba(0, 76, 157, .75),
                        0 0 0 4px rgba(255, 209, 0, .28);
            filter: brightness(1.02);
        }

        .btn-login:hover::after {
            opacity: 1;
        }

        .btn-login:active {
            transform: translateY(1px) scale(.99);
        }

        .btn-login:focus-visible {
            box-shadow: 0 0 0 .25rem rgba(0, 76, 157, .35);
        }

        .toggle-btn {
            border-color: rgba(31,63,99,.12);
            border-radius: 0 .75rem .75rem 0 !important;
            color: #4b5b72;
        }

        .toggle-btn:hover {
            background-color: rgba(0,76,157,.06);
            border-color: rgba(0,76,157,.25);
            color: var(--unair-blue);
        }

        .login-logo {
            width: clamp(100px, 16vw, 140px);
            height: auto;
            transition: transform .4s ease;
            will-change: transform;
            filter: drop-shadow(0 10px 40px rgba(0,76,157,.15));
        }

        .brand-badge:hover ~ .text-center .login-logo,
        .login-card:hover .login-logo {
            transform: scale(1.03) translateY(-1px);
        }

        .accent-bar {
            height: 4px;
            width: 72px;
            margin: .5rem auto 0;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--unair-blue) 0%, var(--unair-blue) 40%, var(--unair-yellow) 40%, var(--unair-yellow) 100%);
            opacity: .9;
        }

        @media (max-width: 576px) {
            .brand-float { opacity: .16; }
            .fb-tag { display: none; }
        }
    </style>

    <div class="login-wrapper">
        <div class="login-bg">
            <span class="bg-shape bg-shape-blue"></span>
            <span class="bg-shape bg-shape-yellow"></span>
            <span class="bg-line bg-line-1"></span>
            <span class="bg-line bg-line-2"></span>
            <span class="bg-line bg-line-3"></span>

            <span class="brand-float fb-wordmark fb-1" aria-hidden="true">BIE+</span>
            <span class="brand-float fb-wordmark fb-2" aria-hidden="true">BIE+</span>
            <span class="brand-float fb-plus fp-1" aria-hidden="true">+</span>
            <span class="brand-float fb-plus fp-2" aria-hidden="true">+</span>
            <span class="brand-float fb-tag" aria-hidden="true">Your Future Is Brilliant</span>
        </div>

        <div class="login-card">
            <div class="text-center mb-4">
                <span class="brand-badge">
                    <img src="{{ asset('asset/img/bietest.png') }}" id="catHead" class="login-logo" alt="BiePlus Logo">
                </span>
                <h4 class="login-title mt-3">{{ __('Login Admin') }}</h4>
                <div class="accent-bar"></div>
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

                        <button type="button" class="btn btn-outline-secondary toggle-btn" id="togglePassword">
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

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-login" id="btnLogin">
                        <span>{{ __('Login') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection