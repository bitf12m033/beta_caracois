@extends('front.layouts.app')

<!-- begin:: Content -->
@section('content')    

    <div class="site-section bg-light">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="section-title mb-5">
              <h2>Login Here</h2>
            </div>
            <form method="post" action="{{ route('login') }}">
              @csrf
              <div class="row">
                  <div class="col-md-6 form-group">
                      <label for="eaddress">Email Address</label>
                      <input type="email" id="eaddress" class="form-control form-control-lg @error('email') is-invalid @enderror" placeholder="Email" name="email" autocomplete="off" value="{{ old('email') }}" required autocomplete="email" autofocus>
                  </div>
                  
              </div>
              <div class="row">
                  <div class="col-md-6 form-group">
                      <label for="password">Password</label>
                      <input type="password" id="password" name="password" class="form-control form-control-lg">
                  </div>
              </div>
              <div class="row">
                  <div class="col-12">
                      <input type="submit" value="Login" class="btn btn-primary py-3 px-5">
                  </div>
              </div>
            </form>
          </div>
          
        </div>

        
      </div>
    </div>
@endsection
<!-- end:: Content -->