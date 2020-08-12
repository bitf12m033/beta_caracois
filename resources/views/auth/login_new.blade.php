@extends('auth.layouts.auth_layout')

@section('content')

	<div class="kt-login__signin">
		<div class="kt-login__head">
			<h3 class="kt-login__title">Sign In To Admin</h3>
		</div>
		<form class="kt-form" method="POST" action="{{ route('login') }}">
			@csrf
			<div class="input-group">
				<input class="form-control @error('email') is-invalid @enderror" type="email"  placeholder="Email" name="email" autocomplete="off" value="{{ old('email') }}" required autocomplete="email" autofocus>
			</div>
			<div class="input-group">
				<input class="form-control" type="password" placeholder="Password" name="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
			</div>
			<div class="row kt-login__extra">
				<div class="col">
					<label class="kt-checkbox">
						<input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Remember me
						<span></span>
					</label>
				</div>
				<div class="col kt-align-right">
					<a href="/password/reset" id="kt_login_forgot" class="kt-login__link">Forget Password ?</a>
				</div>
			</div>
			<div class="kt-login__actions">
				<button id="kt_login_signin_submit" class="btn btn-brand btn-pill kt-login__btn-primary">Sign In</button>
			</div>
		</form>
	</div>

@endsection