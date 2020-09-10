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
                                Add New Order
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
                    <form class="kt-form kt-form--label-right" method="POST" action="{!! route('orders_update',$order->id) !!}">
                        @csrf
                        <div class="kt-portlet__body">
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <div class="kt-form__group--inline">
                                        <div class="kt-form__label">
                                            <label class="kt-label m-label--single">Product:</label>
                                        </div>
                                        <div class="kt-form__control">
                                            <select id="product" class="form-control products" name="product" type="text"></select>
                                        </div>
                                    </div>
                                    <div class="d-md-none kt-margin-b-10"></div>

                                </div>

                            </div>
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label for="product_name">Customer Name:</label>
                                    <input type="text" id="product_name" value={{ $order->customer_name }} name="customer_name" class="form-control" placeholder="Enter Customer name">
                                </div>

                                <div class="col-lg-4">
                                    <label for="validation-contactno">Contact no.</label>
                                    <input id="validation-contactno" value="{{ $order->customer_phone }}" class="form-control"  placeholder="e.g 447712345678"   name="contact"  type="text">
                                    <!-- <span class="form-text text-muted">Please enter your email</span> -->
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-8">
                                    <label for="brand_name">Customer Address:</label>
                                    <input type="text" id="brand_name" value="{{ $order->customer_address }}" name="customer_add" class="form-control" placeholder="Enter Customer Address">
                                    <!-- <span class="form-text text-muted">Please enter your email</span> -->
                                </div>
                            </div>

                        </div>
                        @if(session('success'))

                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>

                        @endif
                        <table id="cart" class="table table-hover table-condensed">
                            <thead>
                            <tr>
                                <th style="width:50%">Product</th>
                                <th style="width:10%">Price</th>
                                <th style="width:8%">Quantity</th>
                                <th style="width:22%" class="text-center">Subtotal</th>
                                <th style="width:10%"></th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php $total = 0 ?>

                            @if(session('cart'))
                                @foreach(session('cart') as $id => $details)

                                    <?php $total += $details['price'] * $details['quantity'] ?>

                                    <tr>
                                        <td data-th="Product">
                                            <div class="row">
                                                <div class="col-sm-3 hidden-xs">{{--<img src="{{ $details['photo'] }}" width="100" height="100" class="img-responsive"/>--}}</div>
                                                <div class="col-sm-9">
                                                    <h4 class="nomargin">{{ $details['name'] }}</h4>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-th="Price">${{ $details['price'] }}</td>
                                        <td data-th="Quantity">
                                            <input type="number" name="quantity[]" value="{{ $details['quantity'] }}" class="form-control quantity" />
                                        </td>
                                        <td data-th="Subtotal" class="text-center">${{ $details['price'] * $details['quantity'] }}</td>
                                        <td class="actions" data-th="">
                                            <button class="btn btn-info btn-sm update-cart" data-id="{{ $id }}"><i class="fa fa-refresh"></i></button>
                                            <button class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $id }}"><i class="fa fa-trash-o"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                            </tbody>
                            <tfoot>

                            <tr class="visible-xs">
                                <td colspan="5" class="text-center"><strong>Total {{ $total }}</strong></td>

                            </tr>
                            </tfoot>
                        </table>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary btn-lg" >Submit</button>
                        </div>
                       {{-- <div class="kt-portlet__foot">
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
                    </form>

                    <!--end::Form-->
                </div>

                <!--end::Portlet-->


            </div>
        </div>
    </div>

    <!-- end:: Content -->
@endsection
@section('scripts')
    <script type="text/javascript">

        $(".update-cart").click(function (e) {
            e.preventDefault();

            var ele = $(this);

            $.ajax({
                url: '{{ url('update-cart') }}',
                method: "patch",
                data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id"), quantity: ele.parents("tr").find(".quantity").val()},
                success: function (response) {

                    window.location.reload();
                }
            });
        });

        $(".remove-from-cart").click(function (e) {
            e.preventDefault();

            var ele = $(this);

            if(confirm("Are you sure")) {
                $.ajax({
                    url: '{{ url('remove-from-cart') }}',
                    method: "DELETE",
                    data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id")},
                    success: function (response) {
                        window.location.reload();
                    }
                });
            }
        });

    </script>
    <script type="text/javascript">
        var counter = 0;

        $('.products').select2({
            placeholder: 'Select Product',
            ajax: {
                url: '/product-ajax',
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results:  $.map(data, function (item) {
                            return {
                                amount: item.sell_price,
                                text: item.product_name,
                                id: item.id
                            }
                        })
                    };
                }
            },
        });
    </script>
    <script>
        $(function(){
            // bind change event to select
            $('#product').on('change', function () {
                var url = $(this).val(); // get selected value
                if (url) { // require a URL
                    let url2 = "{{ url('add-to-cart', 'id') }}";
                    url2 = url2.replace('id', url);
                    document.location.href=url2;
                }
                return false;
            });
        });
    </script>
@endsection
