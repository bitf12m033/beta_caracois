@extends('front.layouts.app')

<!-- begin:: Content -->
@section('content')    

    <div class="site-section">
      <div class="container">
        @if(!Auth::check())
        <div class="row mb-5">
          <div class="col-md-12">
            <div class="bg-light rounded p-3">
              <p class="mb-0">Returning customer? <a href="/home-login" class="d-inline-block">Click here</a> to login</p>
            </div>
          </div>
        </div>
        @endif
        <form class="form" id="checkout-form" method="POST" action="/place-order">
          @csrf
        <div class="row">
          <div class="col-md-6 mb-5 mb-md-0">
            <h2 class="h3 mb-3 text-black font-heading-serif">Billing Details</h2>
            <div class="p-3 p-lg-5 border">
              <!-- <div class="form-group">
                <label for="c_country" class="text-black">Country <span class="text-danger">*</span></label>
                <select id="c_country" class="form-control">
                  <option value="1">Select a country</option>
                  <option value="2">bangladesh</option>
                  <option value="3">Algeria</option>
                  <option value="4">Afghanistan</option>
                  <option value="5">Ghana</option>
                  <option value="6">Albania</option>
                  <option value="7">Bahrain</option>
                  <option value="8">Colombia</option>
                  <option value="9">Dominican Republic</option>
                </select>
              </div> -->
              <div class="form-group row">
                <div class="col-md-12">
                  <label for="c_fname" class="text-black">Full Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="c_fname" name="name" value="{{ Auth::user()->name??  ''}}">
                </div>
               
              </div>
              <div class="form-group row ">
                <div class="col-md-6">
                  <label for="c_email_address" class="text-black">Email Address <span class="text-danger">*</span></label>
                  <input type="email" class="form-control" id="c_email_address" name="email" value="{{ Auth::user()->email??  ''}}">
                </div>
                <div class="col-md-6">
                  <label for="c_phone" class="text-black">Phone <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="c_phone" name="phone" value="{{ Auth::user()->phone??  ''}}" placeholder="Phone Number">
                </div>
              </div>
             
    
              <div class="form-group row">
                <div class="col-md-12">
                  <label for="c_address" class="text-black">Address <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="c_address" name="address1" value="{{ Auth::user()->address1??  ''}}"  placeholder="Street address">
                </div>
              </div>
    
              <div class="form-group">
                <input type="text" class="form-control" name="address2" value="{{ Auth::user()->address2??  ''}}" placeholder="Apartment, suite, unit etc. (optional)">
              </div>
    
              <div class="form-group row">
                <div class="col-md-6">
                  <label for="c_state_country" class="text-black">State <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="c_state_country" name="state" value="{{ Auth::user()->state??  ''}}">
                </div>
                <div class="col-md-6">
                  <label for="c_postal_zip" class="text-black">Postal / Zip <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="c_postal_zip" name="zip" value="{{ Auth::user()->zip??  ''}}">
                </div>
              </div>
    
              
              @if(!Auth::check())
              <div class="form-group">
                <label for="c_create_account" class="text-black" data-toggle="collapse" href="#create_an_account"
                  role="button" aria-expanded="false" aria-controls="create_an_account"><input type="checkbox" value="1"
                    id="c_create_account"  name="create_account"> Create an account?</label>
                <div class="collapse" id="create_an_account">
                  <div class="py-2">
                    <p class="mb-3">Create an account by entering the information below. If you are a returning customer
                      please login at the top of the page.</p>
                    <div class="form-group">
                      <label for="c_account_password" class="text-black">Account Password</label>
                      <input type="email" class="form-control" id="c_account_password" name="password"
                        placeholder="">
                    </div>
                  </div>
                </div>
              </div>
              @endif
    
              <!-- <div class="form-group">
                <label for="c_ship_different_address" class="text-black" data-toggle="collapse"
                  href="#ship_different_address" role="button" aria-expanded="false"
                  aria-controls="ship_different_address"><input type="checkbox" value="1" id="c_ship_different_address">
                  Ship To A Different Address?</label>
                <div class="collapse" id="ship_different_address">
                  <div class="py-2">
    
                    <div class="form-group">
                      <label for="c_diff_country" class="text-black">Country <span class="text-danger">*</span></label>
                      <select id="c_diff_country" class="form-control">
                        <option value="1">Select a country</option>
                        <option value="2">bangladesh</option>
                        <option value="3">Algeria</option>
                        <option value="4">Afghanistan</option>
                        <option value="5">Ghana</option>
                        <option value="6">Albania</option>
                        <option value="7">Bahrain</option>
                        <option value="8">Colombia</option>
                        <option value="9">Dominican Republic</option>
                      </select>
                    </div>
    
    
                    <div class="form-group row">
                      <div class="col-md-12">
                        <label for="c_diff_fname" class="text-black">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="c_diff_fname" name="o_name">
                      </div>
                      
                    </div>
    
                    <div class="form-group row ">
                      <div class="col-md-6">
                        <label for="c_diff_email_address" class="text-black">Email Address <span
                            class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="c_diff_email_address" name="o_email">
                      </div>
                      <div class="col-md-6">
                        <label for="c_diff_phone" class="text-black">Phone <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="c_diff_phone" name="o_phone"
                          placeholder="Phone Number">
                      </div>
                    </div>
    
                    <div class="form-group row">
                      <div class="col-md-12">
                        <label for="c_diff_address" class="text-black">Address <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="c_diff_address" name="o_address1"
                          placeholder="Street address">
                      </div>
                    </div>
    
                    <div class="form-group">
                      <input type="text" class="form-control" name="o_address2" placeholder="Apartment, suite, unit etc. (optional)">
                    </div>
    
                    <div class="form-group row">
                      <div class="col-md-6">
                        <label for="c_diff_state_country" class="text-black">State <span
                            class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="c_diff_state_country" name="o_state">
                      </div>
                      <div class="col-md-6">
                        <label for="c_diff_postal_zip" class="text-black">Postal / Zip <span
                            class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="c_diff_postal_zip" name="o_zip">
                      </div>
                    </div>
    
                    
    
                  </div>
    
                </div>
              </div>
    
              <div class="form-group">
                <label for="c_order_notes" class="text-black">Order Notes</label>
                <textarea name="c_order_notes" id="c_order_notes" cols="30" rows="5" class="form-control"
                  placeholder="Write your notes here..."></textarea>
              </div> -->
    
            </div>
          </div>
          <div class="col-md-6">
    
           <!--  <div class="row mb-5">
              <div class="col-md-12">
                <h2 class="h3 mb-3 text-black font-heading-serif">Coupon Code</h2>
                <div class="p-3 p-lg-5 border">
    
                  <label for="c_code" class="text-black mb-3">Enter your coupon code if you have one</label>
                  <div class="input-group w-75">
                    <input type="text" class="form-control" id="c_code" placeholder="Coupon Code" aria-label="Coupon Code"
                      aria-describedby="button-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary btn-sm rounded px-4" type="button" id="button-addon2">Apply</button>
                    </div>
                  </div>
    
                </div>
              </div>
            </div> -->
    
            <div class="row mb-5">
              <div class="col-md-12">
                <h2 class="h3 mb-3 text-black font-heading-serif">Your Order</h2>
                <div class="p-3 p-lg-5 border">
                  <table class="table site-block-order-table mb-5">
                    <thead>
                      <th>Product</th>
                      <th>Total</th>
                    </thead>
                    <tbody>
                      @foreach($items as $item)
                      <tr>
                        <td>{{$item['product_name']}} <strong class="mx-2">x</strong> {{$item['qty']}}</td>
                        <td>${{$item['subtotal']}}</td>
                      </tr>
                      @endforeach
                      
                      <tr>
                        <td class="text-black font-weight-bold"><strong>Cart Subtotal</strong></td>
                        <td class="text-black">${{$total}}</td>
                      </tr>
                      <tr>
                        <td class="text-black font-weight-bold"><strong>Order Total</strong></td>
                        <td class="text-black font-weight-bold"><strong>${{$total}}</strong></td>
                      </tr>
                    </tbody>
                  </table>
    
                 <!--  <div class="border mb-3 p-3 rounded">
                    <h3 class="h6 mb-0"><a class="d-block" data-toggle="collapse" href="#collapsebank" role="button"
                        aria-expanded="false" aria-controls="collapsebank">Direct Bank Transfer</a></h3>
    
                    <div class="collapse" id="collapsebank">
                      <div class="py-2 pl-0">
                        <p class="mb-0">Make your payment directly into our bank account. Please use your Order ID as the
                          payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                      </div>
                    </div>
                  </div> -->
    
                  <div class="border mb-3 p-3 rounded">
                    <h3 class="h6 mb-0"><a class="d-block" data-toggle="collapse" href="#collapsecheque" role="button"
                        aria-expanded="false" aria-controls="collapsecheque">Cash on Delivery</a></h3>
    
                    <div class="collapse" id="collapsecheque">
                      <div class="py-2 pl-0">
                        <p class="mb-0">Make your payment directly into our bank account. Please use your Order ID as the
                          payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                      </div>
                    </div>
                  </div>
    
                 <!--  <div class="border mb-5 p-3">
                    <h3 class="h6 mb-0"><a class="d-block" data-toggle="collapse" href="#collapsepaypal" role="button"
                        aria-expanded="false" aria-controls="collapsepaypal">Paypal</a></h3>
    
                    <div class="collapse" id="collapsepaypal">
                      <div class="py-2 pl-0">
                        <p class="mb-0">Make your payment directly into our bank account. Please use your Order ID as the
                          payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                      </div>
                    </div>
                  </div> -->
    
                  <div class="form-group">
                    <button class="btn btn-primary btn-lg btn-block" onclick="placeOrder();">Place
                      Order</button>
                  </div>
    
                </div>
              </div>
            </div>
    
          </div>
        </div>
        </form>
        <!-- </form> -->
      </div>
    </div>
@endsection
<!-- end:: Content -->