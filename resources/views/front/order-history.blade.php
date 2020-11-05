@extends('front.layouts.app')

<!-- begin:: Content -->
@section('content')    

    <div class="site-section">
      <div class="container">
        <div class="row mb-5 justify-content-center">
          <div class="col-7 section-title text-center mb-5">
            <h2 class="d-block">Order History</h2>
          </div>
        </div>
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Customer Name</th>
              <th>Address</th>
              <th>Phone</th>
              <th>Products</th>
              <th>Price</th>
              <th>Delivery Status</th>
              <th>Payment Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orders as $order)
              <tr>
                  <td>{{ $order->rownum }}</td>
                  <td>{{ $order->customer_name }}</td>
                  <td>{{ $order->customer_address }}</td>
                  <td>{{ $order->customer_phone }}</td>
                  <td> <a href="javascript:void(0);" data-href="{!! route('all_order_product', ['order_id'=>$order->id]) !!}" class="openPopup"><i class="fa fa-eye" aria-hidden="true"></i></a> </td>
                  <td>{{ $order->total_amount }}</td>
                  <td>@if($order->order_status == 0)<span class="kt-badge kt-badge--dark kt-badge--inline kt-badge--pill kt-badge--rounded">pending</span>
                      @else
                          <span class="kt-badge kt-badge--danger kt-badge--inline kt-badge--pill kt-badge--rounded">completed</span>
                      @endif</td>
                  <td>@if($order->payment_status == 0)<span class="kt-badge kt-badge--dark kt-badge--inline kt-badge--pill kt-badge--rounded">pending</span>
                      @else
                          <span class="kt-badge kt-badge--danger kt-badge--inline kt-badge--pill kt-badge--rounded">
                              completed
                          </span>
                      @endif</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
@endsection
<!-- end:: Content -->