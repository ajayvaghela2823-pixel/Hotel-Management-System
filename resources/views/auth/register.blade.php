@extends('layouts.layout')

@section('title', 'Register - Sona Hotel')

@section('content')
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="hero-text">
                    <h1>Register</h1>
                    <p>Create an account to book your perfect stay at Sona Hotel.</p>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5 offset-xl-2 offset-lg-1">
                <div class="booking-form">
                    <h3>Create Account</h3>
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="check-date">
                            <label for="name">Full Name:</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="check-date">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="check-date">
                            <label for="phone">Phone:</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}">
                            @error('phone')
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
                        <div class="check-date">
                            <label for="password_confirmation">Confirm Password:</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required>
                        </div>
                        <button type="submit">Register</button>
                    </form>
                    <div class="mt-3 text-center">
                        <a href="{{ route('login') }}" style="color: #dfa974;">Already have an account? Login here</a>
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
