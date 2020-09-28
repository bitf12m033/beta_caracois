@extends('front.layouts.app')

<!-- begin:: Content -->
@section('content')    

    <div class="site-section mt-5">
      <div class="container">

        <div class="row mb-5">
          <div class="col-12 section-title text-center mb-5">
            <h2 class="d-block">Our Products</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi, perspiciatis!</p>
          </div>
        </div>

        <div class="row">
         
          @foreach($products as $product)
            <div class="col-lg-4 mb-5 col-md-6">

              <div class="wine_v_1 text-center pb-4">
                <a href="shop-single.html" class="thumbnail d-block mb-4"><img src="{{asset($product->product_image)}}" alt="Image" class="img-fluid">
                </a>
                <div>
                  <h3 class="heading mb-1"><a href="#">{{$product->product_name}}</a></h3>
                  <span class="price">{{$product->sell_price}}</span>
                </div>
                <div class="wine-actions">  
                  <h3 class="heading-2"><a href="#">{{$product->product_name}}</a></h3>
                  <span class="price d-block">{{$product->sell_price}}</span>
                  <a href="javascript:;" onClick="addToCart({{$product->id}})" class="btn add"><span class="icon-shopping-bag mr-3"></span> Add to Cart</a>
                </div>
              </div>
            </div>
          @endforeach          
        </div>
      </div>
    </div>

    <div class="hero-2" style="background-image: url('assets/front/images/hero_2.jpg');">
     <div class="container">
        <div class="row justify-content-center text-center align-items-center">
          <div class="col-md-8">
            <span class="sub-title">Welcome</span>
            <h2>Wines For Everyone</h2>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section bg-light">
      <div class="container">
        <div class="owl-carousel owl-slide-3 owl-slide">
        
          <blockquote class="testimony">
            <img src="{{asset('/assets/front/images/person_1.jpg')}}" alt="Image">
            <p>&ldquo;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero sapiente beatae, nemo quasi quo neque consequatur rem porro reprehenderit, a dignissimos unde ut enim fugiat deleniti quae placeat in cumque?&rdquo;</p>
            <p class="small text-primary">&mdash; Collin Miller</p>
          </blockquote>
          <blockquote class="testimony">
            <img src="{{asset('/assets/front/images/person_2.jpg')}}" alt="Image">
            <p>&ldquo;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero sapiente beatae, nemo quasi quo neque consequatur rem porro reprehenderit, a dignissimos unde ut enim fugiat deleniti quae placeat in cumque?&rdquo;</p>
            <p class="small text-primary">&mdash; Harley Perkins</p>
          </blockquote>
          <blockquote class="testimony">
            <img src="{{asset('/assets/front/images/person_3.jpg')}}" alt="Image">
            <p>&ldquo;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero sapiente beatae, nemo quasi quo neque consequatur rem porro reprehenderit, a dignissimos unde ut enim fugiat deleniti quae placeat in cumque?&rdquo;</p>
            <p class="small text-primary">&mdash; Levi Morris</p>
          </blockquote>
          <blockquote class="testimony">
            <img src="{{asset('/assets/front/images/person_1.jpg')}}" alt="Image">
            <p>&ldquo;Lorem ipsum dolor sit amet, consectetur adipisicing elit. Libero sapiente beatae, nemo quasi quo neque consequatur rem porro reprehenderit, a dignissimos unde ut enim fugiat deleniti quae placeat in cumque?&rdquo;</p>
            <p class="small text-primary">&mdash; Allie Smith</p>
          </blockquote>
        
        </div>
      </div>
    </div>
@endsection
<!-- end:: Content -->