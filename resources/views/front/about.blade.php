@extends('front.layouts.app')

<!-- begin:: Content -->
@section('content')    

    <div class="hero-2" style="background-image: url('assets/front/images/hero_2.jpg');">
     <div class="container">
        <div class="row justify-content-center text-center align-items-center">
          <div class="col-md-8">
            <span class="sub-title">Welcome</span>
            <h2>About Us</h2>
          </div>
        </div>
      </div>
    </div>


    <div class="site-section py-5 custom-border-bottom" data-aos="fade">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md-6">
            <div class="block-16">
              <figure>
                <img src="{{asset('assets/front/images/hero_1.jpg')}}" alt="Image placeholder" class="img-fluid">
    
              </figure>
            </div>
          </div>
          <div class="col-md-1"></div>
          <div class="col-md-5">
    
    
            <div class="site-section-heading pt-3 mb-4">
              <h2 class="text-black font-heading-serif">How We Started</h2>
            </div>
            <p>Rerum quis soluta, esse, cupiditate voluptate ipsum? Sunt unde eos vitae suscipit harum eligendi reprehenderit, illo eaque sit!</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus consequuntur hic quaerat cupiditate tempore temporibus nulla at eum!</p>
    
          </div>
        </div>
      </div>
    </div>
@endsection
<!-- end:: Content -->