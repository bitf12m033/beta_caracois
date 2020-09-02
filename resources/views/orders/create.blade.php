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
                                All Products
                            </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <div class="kt-portlet__head-wrapper">
                                <a href="{!! route('orders.index') !!}" class="btn btn-clean btn-icon-sm">
                                    <i class="la la-long-arrow-left"></i>
                                    Back
                                </a>
                                &nbsp;

                            </div>
                        </div>
                    </div>

                    <!--begin::Form-->
                  {{--  <form class="kt-form kt-form--label-right" method="POST" action="{!! url('orders') !!}">
                        @csrf--}}
                        <div class="kt-portlet__body">
                          {{--  <div class="form-group row">
                                <div class="col-lg-4">
                                    <label for="product_name">Customer Name:</label>
                                    <input type="text" id="product_name" name="customer_name" class="form-control" placeholder="Enter Customer name">
                                </div>
                                <div class="col-lg-4">
                                    <label for="brand_name">Customer Address:</label>
                                    <input type="text" id="brand_name" name="customer_add" class="form-control" placeholder="Enter Customer Address">
                                    <!-- <span class="form-text text-muted">Please enter your email</span> -->
                                </div>

                                <div class="col-lg-4">
                                    <label for="validation-contactno">Contact no.</label>
                                    <input id="validation-contactno" class="form-control"  placeholder="e.g 447712345678"   name="contact"  type="text">
                                    <!-- <span class="form-text text-muted">Please enter your email</span> -->
                                </div>
                            </div>--}}
                            <div class="form-group row">

                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-12 main-section">
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-info" data-toggle="dropdown">
                                            <i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart <span class="badge badge-pill badge-danger">@if(session('cart'))
                                                    {{ count(session('cart')) }}
                                                @endif</span>
                                        </button>
                                        <div class="dropdown-menu">
                                            <div class="row total-header-section">
                                                <div class="col-lg-6 col-sm-6 col-6">
                                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span class="badge badge-pill badge-danger">@if(session('cart'))
                                                            {{ count(session('cart')) }}
                                                        @endif</span>
                                                </div>

                                                <?php $total = 0 ?>
                                                @if(session('cart'))
                                                    @foreach(session('cart') as $id => $details)
                                                        <?php $total += $details['price'] * $details['quantity'] ?>
                                                    @endforeach
                                                @endif
                                                <div class="col-lg-6 col-sm-6 col-6 total-section text-right">
                                                    <p>Total: <span class="text-info">$ {{ $total }}</span></p>
                                                </div>
                                            </div>

                                            @if(session('cart'))
                                                @foreach(session('cart') as $id => $details)
                                                    <div class="row cart-detail">
                                                        <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                                                           {{-- <img src="{{ $details['photo'] }}" />--}}
                                                        </div>
                                                        <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                                                            <p>{{ $details['name'] }}</p>
                                                            <span class="price text-info"> ${{ $details['price'] }}</span> <span class="count"> Quantity:{{ $details['quantity'] }}</span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                            <div class="row">
                                                <div class="col-lg-12 col-sm-12 col-12 text-center checkout">
                                                    <a href="{{ url('cart') }}" class="btn btn-primary btn-block">View all</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if(session('success'))

                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>

                            @endif
                            <div class="row">

                                @foreach($products as $product)
                                    <div class="col-xs-18 col-sm-6 col-md-3">
                                        <div class="thumbnail">
                                           {{-- <img src="{{ $product->photo }}" width="500" height="300">--}}
                                            <div class="caption">
                                                <h4>{{ $product->product_name }}</h4>
                                              {{--  <p>{{ str_limit(strtolower($product->description), 50) }}</p>--}}
                                                <p><strong>Brand: </strong> {{ $product->brand_name }}$</p>
                                                <p><strong>Price: </strong> {{ $product->sell_price }}$</p>
                                                <p><strong>Category: </strong> {{ $product->category }}$</p>
                                                <p class="btn-holder"><a href="{{ url('add-to-cart/'.$product->id) }}" class="btn btn-warning btn-block text-center" role="button">Add to cart</a> </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div><!-- End row -->
                        </div>
                      {{--  <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <div class="row">
                                    <div class="col-lg-4"></div>
                                    <div class="col-lg-8">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button onclick="location.href='/orders'" type="reset" class="btn btn-secondary">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>--}}
                   {{-- </form>--}}

                    <!--end::Form-->
                </div>

                <!--end::Portlet-->


            </div>
        </div>
    </div>

    <!-- end:: Content -->
@endsection
@section('scripts')

@endsection
