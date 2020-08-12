@extends('auth.layouts.auth_layout')

@section('content')

    <div class="kt-login__signup">
        <div class="kt-login__head">
            <h3 class="kt-login__title">Sign Up</h3>
            <div class="kt-login__desc">Enter your details to create your account:</div>
        </div>
        <form class="kt-form" method="POST" action="{{ route('register') }}">
             @csrf
            <div class="input-group">
                <input placeholder="Fullname" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
            </div>
            <div class="input-group">
                <input  placeholder="Email"  autocomplete="off" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
            </div>
            <div class="input-group">
                <input  type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="password">
            </div>
            <div class="input-group">
                <input class="form-control" type="password" placeholder="Confirm Password" name="password_confirmation">
            </div>
            <div class="row kt-login__extra">
                <div class="col kt-align-left">
                    <label class="kt-checkbox">
                        <input type="checkbox" name="agree">I Agree the <a href="#" class="kt-link kt-login__link kt-font-bold">terms and conditions</a>.
                        <span></span>
                    </label>
                    <span class="form-text text-muted"></span>
                </div>
            </div>
            <div class="kt-login__actions">
                <button id="kt_login_signup_submit" type="submit" class="btn btn-brand btn-pill kt-login__btn-primary">Sign Up</button>&nbsp;&nbsp;
                <button id="kt_login_signup_cancel" onclick="location.href='/login'" class="btn btn-secondary btn-pill kt-login__btn-secondary">Cancel</button>
            </div>
        </form>
    </div>

@endsection