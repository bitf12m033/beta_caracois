@extends('dashboard.layouts.app')

@section('content')
<!-- begin:: Content -->
<div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
	<div class="row">
		<div class="col-lg-12">
			<!--begin::Portlet-->
			<div class="kt-portlet">
				<div class="kt-portlet__head kt-portlet__head--lg">
					<div class="kt-portlet__head-label">
						<span class="kt-portlet__head-icon">
							<i class="kt-font-brand flaticon2-line-chart"></i>
						</span>
						<h3 class="kt-portlet__head-title">
							Edit Product
						</h3>
					</div>
					<div class="kt-portlet__head-toolbar">
						<div class="kt-portlet__head-wrapper">
							<a href="{!! route('products.index') !!}" class="btn btn-clean btn-icon-sm">
								<i class="la la-long-arrow-left"></i>
								Back
							</a>
							&nbsp;
							
						</div>
					</div>
				</div>

				@if ($errors->any())
			        <div class="alert alert-danger">
			            <strong>Whoops!</strong> There were some problems with your input.<br><br>
			            <ul>
			                @foreach ($errors->all() as $error)
			                    <li>{{ $error }}</li>
			                @endforeach
			            </ul>
			        </div>
			    @endif
				<!--begin::Form-->
				<form class="kt-form kt-form--label-right" method="POST" action="{{ route('products.update',$product->id) }}">
					@csrf
					@method('PUT')
					<div class="kt-portlet__body">
						<div class="form-group row">
							<div class="col-lg-4">
								<label for="product_name">Product Name:</label>
								<input type="text" id="product_name" name="product_name" class="form-control" value="{{ $product->product_name}}" placeholder="Enter product name">
								<span class="form-text text-muted">Please enter your full name</span>
							</div>
							<div class="col-lg-4">
								<label for="brand_name">Brand Name:</label>
								<input type="text" id="brand_name" name="brand_name" class="form-control" value="{{ $product->brand_name}}" placeholder="Enter brand name">
								<!-- <span class="form-text text-muted">Please enter your email</span> -->
							</div>

							<div class="col-lg-4">
								<label for="category">Category:</label>
								<input type="text" value="{{ $product->category}}" id="category" name="category" class="form-control" placeholder="Enter category">
								<!-- <span class="form-text text-muted">Please enter your email</span> -->
							</div>
						</div>
						<div class="form-group row">
							<div class="col-lg-4">
								<label class="">Receiving Date:</label>
								<div class="input-group date">
									<input type="text" name="receive_date" class="form-control" readonly value="{{ $product->receive_date}}" id="receive_date" />
									<div class="input-group-append">
										<span class="input-group-text">
											<i class="la la-calendar"></i>
										</span>
									</div>
								</div>
								<!-- <span class="form-text text-muted">Please enter your contact</span> -->
							</div>
							<div class="col-lg-4">
								<label class="">Expired Date:</label>
								<div class="input-group date">
									<input type="text" name="expired_date" class="form-control" readonly value="{{ $product->Expired_date}}" id="expired_date" />
									<div class="input-group-append">
										<span class="input-group-text">
											<i class="la la-calendar"></i>
										</span>
									</div>
								</div>
								<!-- <span class="form-text text-muted">Please enter your contact</span> -->
							</div>
							<div class="col-lg-4">
								<label for="original_price">Original Price:</label>
								<div class="kt-input-icon kt-input-icon--right">
									<input type="text" value="{{ $product->original_price}}" id="original_price" name="original_price" class="form-control" >
									<span class="kt-input-icon__icon kt-input-icon__icon--right"><span><i class="la la-dollar"></i></span></span>
								</div>
								<!-- <span class="form-text text-muted">Please enter fax</span> -->
							</div>

						</div>
						<div class="form-group row">
							<div class="col-lg-4">
								<label for="sell_price">Sell Price:</label>
								<div class="kt-input-icon kt-input-icon--right">
									<input type="text" value="{{ $product->sell_price}}" id="sell_price" name="sell_price" class="form-control" placeholder="Enter sell price">
									<span class="kt-input-icon__icon kt-input-icon__icon--right"><span><i class="la la-dollar"></i></span></span>
								</div>
								<!-- <span class="form-text text-muted">Please enter your postcode</span> -->
							</div>

							<div class="col-lg-4">
								<label for="quantity">Quantity:</label>
								<div class="kt-input-icon kt-input-icon--right">
									<input type="text" value="{{ $product->quantity}}" id="quantity" name="quantity" class="form-control" placeholder="Enter quantity">
									<span class="kt-input-icon__icon kt-input-icon__icon--right"><span><i class="la la-bookmark-o"></i></span></span>
								</div>
								<!-- <span class="form-text text-muted">Please enter your postcode</span> -->
							</div>
							<!-- <div class="col-lg-4">
								<label class="">User Group:</label>
								<div class="kt-radio-inline">
									<label class="kt-radio kt-radio--solid">
										<input type="radio" name="example_2" checked value="2"> Sales Person
										<span></span>
									</label>
									<label class="kt-radio kt-radio--solid">
										<input type="radio" name="example_2" value="2"> Customer
										<span></span>
									</label>
								</div>
								<span class="form-text text-muted">Please select user group</span>
							</div> -->
						</div>
					</div>
					<div class="kt-portlet__foot">
						<div class="kt-form__actions">
							<div class="row">
								<div class="col-lg-4"></div>
								<div class="col-lg-8">
									<button type="submit" class="btn btn-primary">Update</button>
									<button type="reset" onclick="location.href='/products'" class="btn btn-secondary">Cancel</button>
								</div>
							</div>
						</div>
					</div>
				</form>

				<!--end::Form-->
			</div>

			<!--end::Portlet-->

			
		</div>
	</div>
</div>

<!-- end:: Content -->
@endsection