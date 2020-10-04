<div class="header-top">
		<div class="container">
		<div class="row align-items-center">
				<div class="col-12 text-center">
	            <a href="index.html" class="site-logo">
	              	<img src="{{asset('/assets/front/images/logo.png')}}" alt="Image" class="img-fluid">
	            </a>
				</div>
				<a href="#" class="mx-auto d-inline-block d-lg-none site-menu-toggle js-menu-toggle text-black">
					<span class="icon-menu h3"></span>
				</a>
		</div>
		</div>
		<div class="site-navbar py-2 js-sticky-header site-navbar-target d-none pl-0 d-lg-block" role="banner">
			<div class="container">
			<div class="d-flex align-items-center">
  				<div class="mx-auto">
		            <nav class="site-navigation position-relative text-left" role="navigation">
		              	<ul class="site-menu main-menu js-clone-nav mx-auto d-none pl-0 d-lg-block border-none">
		                	<li class="active">
		                		<a href="/" class="nav-link text-left">Home</a>
		                	</li>
			                <li><a href="/about-us" class="nav-link text-left">About</a></li>
			                <li><a href="/products-list" class="nav-link text-left">Products</a></li>
			                <li><a href="/products-list" class="nav-link text-left">Shop</a></li>
			                <li><a href="/contact-us" class="nav-link text-left">Contact</a></li>
		                	<li class="active">
		                		<a href="/cart-detail" class="nav-link text-left cart-link" id="cart-count">Cart
		                			@if(session()->has('cart'))
		                				<span class="badge badge-pill badge-danger">{{ count(Session::get('cart')) }}</span>
		                			@else
		                				<span class="badge badge-pill badge-danger">0</span>
		                			@endif
		                		</a>
		                	</li>
			            </ul>
			        </nav>
  				</div>
  				<div class="mx-auto">
  					@guest
  					<a href="/home-login" class="btn btn-primary btn-sm">Login</a>
  					<a href="/home-register" class="btn btn-default btn-sm">Register</a>
  					@endguest
  					@auth
				        Welcome {{Auth::user()->name}},
				        <a href="{{ route('logout') }}"
                   			onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();" target="_blank" class="btn btn-label-brand btn-sm btn-bold btn-danger">Logout</a>
                        <form id="logout-form" 
                        	action="{{ route('logout') }}" 
                        	method="POST" style="display: none;">
                            @csrf
                        </form>
				    @endauth
  					
  				</div>
			</div>
		</div>
	</div>
</div>