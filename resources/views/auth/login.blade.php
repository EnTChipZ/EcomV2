@extends('layouts.storefront')

@section('title', 'Login')
@section('crumb')
    <a href="{{ route('about') }}">pages</a>
    <span>/</span>
    <span>login</span>
@endsection

@section('content')
<section class="s3-main s3-auth" data-figma="Login 1:3362">
    <div class="s3-auth-art">
        <img src="{{ asset('images/storefront/login.svg') }}" alt="">
    </div>
    <div class="s3-auth-form">
        <h2>Welcome Back</h2>
        <p class="lede">login to continue</p>
        @if ($errors->any())
            <p class="err">{{ $errors->first() }}</p>
        @endif
        <form method="post" action="{{ route('login') }}">
            @csrf
            <div class="s3-field">
                <label>Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Example@gmail.com" required>
            </div>
            <div class="s3-field">
                <label>Password</label>
                <div class="s3-pass">
                    <input type="password" name="password" placeholder="...." required>
                </div>
            </div>
            <p><a class="s3-link" href="{{ route('login') }}">Forget Password ?</a></p>
            <p style="margin: 24px 0 12px;"><button class="s3-btn" type="submit">login</button></p>
            <p><a class="s3-link" href="{{ route('register') }}">new user ? Register Now</a></p>
            <p><a class="s3-link" href="{{ route('register.seller') }}">Sell on JEAP</a> · <a class="s3-link" href="{{ route('register.rider') }}">Become a rider</a> · <a class="s3-link" href="{{ route('register.logistics') }}">Sorting center</a></p>
        </form>
    </div>
</section>
@endsection
