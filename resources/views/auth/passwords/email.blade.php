@extends('auth.layouts.auth_layout')

@section('content')
<div class="kt-login__forgot">
    <div class="kt-login__head">
        <h3 class="kt-login__title">{{ __('Reset Password') }}</h3>
        <div class="kt-login__desc">Enter your email to reset your password:</div>
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
    </div>
    <form class="kt-form" method="POST" action="{{ route('password.email') }}">
         @csrf
        <div class="input-group">
            <input  placeholder="Email"  autocomplete="off" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="kt-login__actions">
            <button id="kt_login_forgot_submit" class="btn btn-brand btn-pill kt-login__btn-primary" type="submit">Request</button>&nbsp;&nbsp;
            <button id="kt_login_forgot_cancel" class="btn btn-secondary btn-pill kt-login__btn-secondary">Cancel</button>
        </div>
    </form>
</div>
@endsection
