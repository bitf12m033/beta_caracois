@extends('front.layouts.app')

<!-- begin:: Content -->
@section('content')    

    <div class="site-section  pb-0">
      <div class="container">
        <div class="row mb-5 justify-content-center">
          <div class="col-7 section-title text-center mb-5">
            <h2 class="d-block">Cart</h2>
          </div>
        </div>
        <div class="row mb-5">
          <form class="col-md-12" id="update-cart" method="post"  action="{{ url('/update-atc')}}">
            @csrf
           
            <div class="site-blocks-table">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th class="product-thumbnail">Image</th>
                    <th class="product-name">Product</th>
                    <th class="product-price">Price</th>
                    <th class="product-quantity">Quantity</th>
                    <th class="product-total">Total</th>
                    <th class="product-remove">Remove</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($items as $item)

                    <tr>
                      <input type="hidden" name="productid[]" value="{{$item['id']}}">
                      <td class="product-thumbnail">
                        <img src="{{asset($item['product_image'])}}" alt="Image" class="img-fluid">
                      </td>
                      <td class="product-name">
                        <h2 class="h5 cart-product-title text-black">{{$item['product_name']}}</h2>
                      </td>
                      <td>${{$item['sell_price']}}</td>
                      <td>
                        <div class="input-group mb-3" style="max-width: 140px;">
                          <div class="input-group-prepend">
                            <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
                          </div>
                          <input type="text" class="form-control text-center border mr-0" value="{{$item['qty']}}" name="quantity[]" placeholder=""
                            aria-label="Example text with button addon" aria-describedby="button-addon1">
                          <div class="input-group-append">
                            <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
                          </div>
                        </div>
      
                      </td>
                      <td>${{$item['subtotal']}}</td>
                      <td><a href="#" class="btn btn-primary height-auto btn-sm">X</a></td>
                    </tr>
                  @endforeach
    
                </tbody>
              </table>
            </div>
          </form>
        </div>
    
      </div>
    </div>

    <div class="site-section pt-5 bg-light">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="row mb-5">
              <div class="col-md-6 mb-3 mb-md-0">
                <button onclick="updateCart();" class="btn btn-primary btn-md btn-block">Update Cart</button>
              </div>
              <div class="col-md-6">
                <button class="btn btn-outline-primary btn-md btn-block">Continue Shopping</button>
              </div>
            </div>
            <!-- <div class="row">
              <div class="col-md-12">
                <label class="text-black h4" for="coupon">Coupon</label>
                <p>Enter your coupon code if you have one.</p>
              </div>
              <div class="col-md-8 mb-3 mb-md-0">
                <input type="text" class="form-control py-3" id="coupon" placeholder="Coupon Code">
              </div>
              <div class="col-md-4">
                <button class="btn btn-primary btn-md px-4">Apply Coupon</button>
              </div>
            </div> -->
          </div>
          <div class="col-md-6 pl-5">
            <div class="row justify-content-end">
              <div class="col-md-7">
                <div class="row">
                  <div class="col-md-12 text-right border-bottom mb-5">
                    <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6">
                    <span class="text-black">Subtotal</span>
                  </div>
                  <div class="col-md-6 text-right">
                    <strong class="text-black">${{$total}}</strong>
                  </div>
                </div>
                <div class="row mb-5">
                  <div class="col-md-6">
                    <span class="text-black">Total</span>
                  </div>
                  <div class="col-md-6 text-right">
                    <strong class="text-black">${{$total}}</strong>
                  </div>
                </div>
    
                <div class="row">
                  <div class="col-md-12">
                    <button class="btn btn-primary btn-lg btn-block" onclick="window.location='/checkout'">Proceed To
                      Checkout</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
<!-- end:: Content -->