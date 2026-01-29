@extends('layouts.layout')

@section('title', 'Login - Sona Hotel')

@section('content')
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="hero-text">
                    <h1>Login</h1>
                    <p>Welcome back to Sona Hotel. Please login to manage your bookings.</p>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5 offset-xl-2 offset-lg-1">
                <div class="booking-form">
                    <h3>Login</h3>
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="check-date">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="check-date">
                            <label for="password">Password:</label>
                            <input type="password" name="password" id="password" required>
                            @error('password')
                                <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="select-option">
                            <label for="remember">
                                <input type="checkbox" name="remember" id="remember"> Remember Me
                            </label>
                        </div>
                        <button type="submit">Login</button>
                    </form>
                    <div class="mt-3 text-center">
                        <a href="{{ route('register') }}" style="color: #dfa974;">Don't have an account? Register here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-slider owl-carousel">
        <div class="hs-item set-bg" data-setbg="{{ asset('img/hero/hero-1.jpg') }}"></div>
        <div class="hs-item set-bg" data-setbg="{{ asset('img/hero/hero-2.jpg') }}"></div>
        <div class="hs-item set-bg" data-setbg="{{ asset('img/hero/hero-3.jpg') }}"></div>
    </div>
</section>
@endsection
