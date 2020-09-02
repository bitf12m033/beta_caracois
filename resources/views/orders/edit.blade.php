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
                    <form class="kt-form kt-form--label-right" method="PATCH" action="{!! route('orders.update',$order->id) !!}">
                        @csrf
                        <div class="kt-portlet__body">
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label for="product_name">Customer Name:</label>
                                    <input type="text" id="product_name" value={{ $order->customer_name }} name="customer_name" class="form-control" placeholder="Enter Customer name">
                                </div>
                                <div class="col-lg-4">
                                    <label for="brand_name">Customer Address:</label>
                                    <input type="text" id="brand_name" value={{ $order->customer_address }} name="customer_add" class="form-control" placeholder="Enter Customer Address">
                                    <!-- <span class="form-text text-muted">Please enter your email</span> -->
                                </div>

                                <div class="col-lg-4">
                                    <label for="validation-contactno">Contact no.</label>
                                    <input id="validation-contactno" value={{ $order->customer_phone }} class="form-control"  placeholder="e.g 447712345678"   name="contact"  type="text">
                                    <!-- <span class="form-text text-muted">Please enter your email</span> -->
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <label for="validation-product">Products<span style="color:red; font-weight:900; font-size:20px;">*</span></label>
                                    <select id="validation-product" class="form-control products" name="product[]" multiple="multiple" type="text" data-validation="[NOTEMPTY]" data-validation-message="Product must not be empty!">
                                        @foreach($product as $pro)
                                            <option value="{{ $pro->product_id }}" selected="selected">{{ get_product_name($pro->product_id) }}</option>
                                            @endforeach
                                    </select>
                                    <!-- <span class="form-text text-muted">Please enter your contact</span> -->
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__foot">
                            <div class="kt-form__actions">
                                <div class="row">
                                    <div class="col-lg-4"></div>
                                    <div class="col-lg-8">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button onclick="location.href='/orders'" type="reset" class="btn btn-secondary">Cancel</button>
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
@section('scripts')
    <script type="text/javascript">
        var counter = 0;
        $('.products').select2({
            placeholder: 'Select Products',
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
            multiple: true,
            closeOnSelect: true
        });
    </script>
@endsection
