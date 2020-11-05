@extends('front.layouts.app')

<!-- begin:: Content -->
@section('content')    

    <div class="site-section bg-light">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="section-title mb-5">
              <h2>Register Here</h2>
            </div>
            <form method="post" action="{{ route('register') }}">
              @csrf
              <div class="row">
                  <div class="col-md-6 form-group">
                      <label for="eaddress">Full Name</label>
                      <input type="name" id="eaddress" class="form-control form-control-lg @error('name') is-invalid @enderror" placeholder="Full Name" name="name" autocomplete="off" value="{{ old('name') }}" required autocomplete="name" autofocus>
                       @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                  </div>
                  
              </div>
              <div class="row">
                  <div class="col-md-6 form-group">
                      <label for="eaddress">Email Address</label>
                      <input type="email" id="eaddress" class="form-control form-control-lg @error('email') is-invalid @enderror" placeholder="Email" name="email" autocomplete="off" value="{{ old('email') }}" required autocomplete="email" autofocus>
                       @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                  </div>
                  
              </div>
              <div class="row">
                  <div class="col-md-6 form-group">
                      <label for="password">Password</label>
                      <input type="password" id="password" name="password" class="form-control form-control-lg">
                  </div>
              </div>
              <div class="row">
                  <div class="col-md-6 form-group">
                      <label for="password">Confirm Password</label>
                      <input type="password" id="password_confirmation" name="password_confirmation" class="form-control form-control-lg">
                      @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                  </div>
              </div>
              <div class="row">
                  <div class="col-12">
                      <input type="submit" value="Register" class="btn btn-primary py-3 px-5">
                  </div>
              </div>
            </form>
          </div>
          
        </div>

        
      </div>
    </div>
@endsection
<!-- end:: Content -->