<!DOCTYPE html>
<html lang="en">
 	@include('front.includes.head')
	<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">
  		<div class="site-wrap">
    		
  			@include('front.includes.mobile-header')
  			@include('front.includes.content-header')

  			@yield('content')
    
    		@include('front.includes.footer')

  		</div>
  		<!-- .site-wrap -->


	  	<!-- loader -->
	  	<div id="loader" class="show fullscreen">
		  	<svg class="circular" width="48px" height="48px">
		  		<circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#ff5e15"/>
		  	</svg>
	  	</div>
  		@include('front.includes.foot')

	</body>

</html>