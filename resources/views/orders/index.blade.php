@extends('dashboard.layouts.app')

@section('content')

    <!-- begin:: Content -->
    <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
        @if ($message = Session::get('success'))
            <div class="alert alert-light alert-elevate" role="alert">
                <!-- <div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div> -->
                <!-- <div class="alert-text">
                    DataTables has the ability to read data from virtually any JSON data source that can be obtained by Ajax. This can be done, in its most simple form, by setting the ajax option to the address of the JSON data source.
                    See official documentation <a class="kt-link kt-font-bold" href="https://datatables.net/examples/data_sources/ajax.html" target="_blank">here</a>.
                </div> -->

                <!-- <div class="alert alert-success"> -->
                <p>{{ $message }}</p>
                <!-- </div> -->
            </div>
        @endif
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head kt-portlet__head--lg">
                <div class="kt-portlet__head-label">
				<span class="kt-portlet__head-icon">
					<i class="kt-font-brand flaticon2-line-chart"></i>
				</span>
                    <h3 class="kt-portlet__head-title">
                        Orders Listing 
                    </h3>
                </div>
                <div class="kt-portlet__head-toolbar">
                    <div class="kt-portlet__head-wrapper">
                        <div class="kt-portlet__head-actions">
                            <div class="dropdown dropdown-inline kt-hidden" >
                                <button type="button" class="btn btn-default btn-icon-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="la la-download"></i> Export
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="kt-nav">
                                        <li class="kt-nav__section kt-nav__section--first">
                                            <span class="kt-nav__section-text">Choose an option</span>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a href="#" class="kt-nav__link">
                                                <i class="kt-nav__link-icon la la-print"></i>
                                                <span class="kt-nav__link-text">Print</span>
                                            </a>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a href="#" class="kt-nav__link">
                                                <i class="kt-nav__link-icon la la-copy"></i>
                                                <span class="kt-nav__link-text">Copy</span>
                                            </a>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a href="#" class="kt-nav__link">
                                                <i class="kt-nav__link-icon la la-file-excel-o"></i>
                                                <span class="kt-nav__link-text">Excel</span>
                                            </a>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a href="#" class="kt-nav__link">
                                                <i class="kt-nav__link-icon la la-file-text-o"></i>
                                                <span class="kt-nav__link-text">CSV</span>
                                            </a>
                                        </li>
                                        <li class="kt-nav__item">
                                            <a href="#" class="kt-nav__link">
                                                <i class="kt-nav__link-icon la la-file-pdf-o"></i>
                                                <span class="kt-nav__link-text">PDF</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div> 
                            &nbsp;@if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role_type == 'admin')
                            <a href="{{ route('order.cart')}}" class="btn btn-brand btn-elevate btn-icon-sm">
                                <i class="la la-plus"></i>
                                New Order
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__body">

                <!--begin: Datatable -->
                <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_order">
                    <thead class="thead-default">
                    <tr>
                        <th>ID</th>
                        <th>Customer Name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Products</th>
                        <th>Price</th>
                        <th>Delivery Status</th>
                        <th>Payment Status</th>
                        <th style="padding-right: 42px; !important;">Signature</th>
                        <th>Actions</th>
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
                            <td>
                                @if($order->signature == null)
                                    <span class="kt-badge kt-badge--warning kt-badge--inline kt-badge--pill kt-badge--rounded">Not Available</span>
                                @else
                                        <img id="myImg" src="{{\Illuminate\Support\Facades\URL::asset('/uploads/signatures/'. $order->signature)}}" alt="Customer Signature" onClick="image_large('{{\Illuminate\Support\Facades\URL::asset('/uploads/signatures/'. $order->signature)}}')" style="width:100%;max-width:300px">
                                @endif
                            </td>
                            <td style="width:250px;">
                                &nbsp;@if(\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role_type == 'admin')
                                <a href="{{ route('orders.edit',$order->id ) }}" ><i class="la la-edit"></i></a>
                                {!! Form::open(['method' => 'DELETE','route' => ['orders.destroy', $order->id],'style'=>'display:inline','role'=>'form','onsubmit' => 'return confirm(" Do you want to delete this Order?")']) !!}
                                <a href="#" onclick="$(this).closest('form').submit()"><i class="la la-trash"></i></a>
                                {!! Form::close() !!}
                                @endif
                                <a href="javascript:void(0);" data-toggle="tooltip" data-original-title="Click to Change Status"   class="btn btn-primary" data-cost="{{ $order->id }}"  onClick="change_order_status({{$order->id }})"> Sign Here</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
                <!--end: Datatable -->
            </div>
        </div>
    </div>
    <div id="sig_Modal" class="modal fade" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel2">Signature</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <img class="modal-content" id="img01" src="">
                    <div id="caption"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div id="po_shift" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Order Items</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body2">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="kt_modal_user_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deleting User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure?Do you really want to delete this?.</p>
                </div>
                <div class="modal-footer">
                    <form action="" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-danger">Yes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="change_status" class="modal fade" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Change Order Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert-warning" style="padding: 8px;margin-bottom: 14px;opacity: 0.8;" id="warning_alert">
                        <strong>Warning!</strong> You are about to change Status of order.
                    </div>
                    <div class="alert-success" style="padding: 8px;margin-bottom: 14px;opacity: 0.8;display: none" id="success_alert">
                        <strong>Success!</strong> Shift Timings has been updated successfully.
                    </div>
                    <form action="" id="order_status_form" method="post" enctype="multipart/form-data">
                    <div class="col-md-12">
                        <label class="" for="">Signature:</label>
                        <br/>
                        <div id="signature-pad" class="jay-signature-pad">
                            <div class="jay-signature-pad--body">
                                <canvas id="jay-signature-pad"  width="400" height="280" style="border:1px solid"></canvas>
                            </div>
                            <div class="signature-pad--footer txt-center">
                                <div class="description"><strong> SIGN ABOVE </strong></div>
                                <div class="signature-pad--actions txt-center">
                                    <div>
                                        <button type="button" class="button clear btn btn-success" data-action="clear">Clear</button>
                                        {{--<button type="button" class="button" data-action="change-color">Change color</button>--}}
                                    </div><br/>
                                    {{--<div>
                                        <button type="button" class="button save" data-action="save-png">Save as PNG</button>
                                        <button type="button" class="button save" data-action="save-jpg">Save as JPG</button>
                                        <button type="button" class="button save" data-action="save-svg">Save as SVG</button>
                                    </div>--}}
                                </div>
                            </div>
                        </div>
                    </div>

                        <input type="checkbox" required="required" id="payment_received" name="payment_received" value="1" checked>
                        <label for="payment_received"> Payment Received</label><br>
                  {{--  <button class="btn btn-success">Save</button> <br>--}}
                    <input type="hidden" id="order_id" name="order_id">
                        <br/>
                    <button type="submit" class="btn btn-success">Update Order Status</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function image_large(srrc){

                $("#warning_alert").css('display','block');
                $("#success_alert").css('display','none');
                $('.tooltip').not(this).hide();
                var modalImg = document.getElementById("img01");
                modalImg.src = srrc;
                $("#sig_Modal").modal();

                debugger;
        }

    </script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
    <script>
        var wrapper = document.getElementById("signature-pad");
        var clearButton = wrapper.querySelector("[data-action=clear]");
        var changeColorButton = wrapper.querySelector("[data-action=change-color]");
        var savePNGButton = wrapper.querySelector("[data-action=save-png]");
        var saveJPGButton = wrapper.querySelector("[data-action=save-jpg]");
        var saveSVGButton = wrapper.querySelector("[data-action=save-svg]");
        var canvas = wrapper.querySelector("canvas");
        var signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgb(255, 255, 255)'
        });
        // Adjust canvas coordinate space taking into account pixel ratio,
        // to make it look crisp on mobile devices.
        // This also causes canvas to be cleared.
        function resizeCanvas() {
            // When zoomed out to less than 100%, for some very strange reason,
            // some browsers report devicePixelRatio as less than 1
            // and only part of the canvas is cleared then.
            var ratio =  Math.max(window.devicePixelRatio || 1, 1);
            // This part causes the canvas to be cleared
            /*canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;*/
            canvas.width = 300 * ratio;
            canvas.height = 200 * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
            // This library does not listen for canvas changes, so after the canvas is automatically
            // cleared by the browser, SignaturePad#isEmpty might still return false, even though the
            // canvas looks empty, because the internal data of this library wasn't cleared. To make sure
            // that the state of this library is consistent with visual state of the canvas, you
            // have to clear it manually.
            signaturePad.clear();
        }
        // On mobile devices it might make more sense to listen to orientation change,
        // rather than window resize events.
        window.onresize = resizeCanvas;
        resizeCanvas();
        function download(dataURL, filename) {
            var blob = dataURLToBlob(dataURL);
            var url = window.URL.createObjectURL(blob);
            var a = document.createElement("a");
            a.style = "display: none";
            a.href = url;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
        }
        // One could simply use Canvas#toBlob method instead, but it's just to show
        // that it can be done using result of SignaturePad#toDataURL.
        function dataURLToBlob(dataURL) {
            var parts = dataURL.split(';base64,');
            var contentType = parts[0].split(":")[1];
            var raw = window.atob(parts[1]);
            var rawLength = raw.length;
            var uInt8Array = new Uint8Array(rawLength);
            for (var i = 0; i < rawLength; ++i) {
                uInt8Array[i] = raw.charCodeAt(i);
            }
            return new Blob([uInt8Array], { type: contentType });
        }
        clearButton.addEventListener("click", function (event) {
            signaturePad.clear();
        });
     /*   changeColorButton.addEventListener("click", function (event) {
            var r = Math.round(Math.random() * 255);
            var g = Math.round(Math.random() * 255);
            var b = Math.round(Math.random() * 255);
            var color = "rgb(" + r + "," + g + "," + b +")";
            signaturePad.penColor = color;
        });*/
        savePNGButton.addEventListener("click", function (event) {
            if (signaturePad.isEmpty()) {
                alert("Please provide a signature first.");
            } else {
                var dataURL = signaturePad.toDataURL();
                download(dataURL, "signature.png");
            }
        });
        saveJPGButton.addEventListener("click", function (event) {
            if (signaturePad.isEmpty()) {
                alert("Please provide a signature first.");
            } else {
                var dataURL = signaturePad.toDataURL("image/jpeg");
                download(dataURL, "signature.jpg");
            }
        });
        saveSVGButton.addEventListener("click", function (event) {
            if (signaturePad.isEmpty()) {
                alert("Please provide a signature first.");
            } else {
                var dataURL = signaturePad.toDataURL('image/svg+xml');
                download(dataURL, "signature.svg");
            }
        });
    </script>
    <script>
        function change_order_status(order_id){
            if(order_id != ''){
                $("#warning_alert").css('display','block');
                $("#success_alert").css('display','none');
                $('.tooltip').not(this).hide();
                $("#change_status").modal();
                $("#order_id").val(order_id);
            }
        }
        $('#payment_received').on('change', function() {
            var val = this.checked ? this.value : '';
            $("#payment_received").val(val);
        });
    </script>
    <script>
        $(document).on('submit', '#order_status_form', function (e) {
            if (signaturePad.isEmpty()) {
                alert("Please provide a signature first.");
                e.preventDefault();
            } else {
                e.preventDefault();
                var order_id = $("#order_id").val();
                var dataURL = signaturePad.toDataURL();
                var payment_received = $("#payment_received").val();
                var token = "{{ csrf_token() }}";
                $.ajax({
                    url: "{{route('orders.change_status')}}",
                    type: "POST",
                    data: {_token:token,dataURL: dataURL,order_id: order_id,payment_received:payment_received},
                    success:function (e) {
                        $("#change_status").modal('hide');
                        location.reload();
                    }
                });
            }
        });
    </script>
    <script>
        $(function () {

            // Datatables
            var table = $('#kt_table_order').DataTable({
                "lengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25,50, 100, 200, "All"]],
                responsive: true,
                "autoWidth": false,
                dom: 'Bflrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
            table.buttons().container()
                .appendTo( '#kt_table_order .col-md-6:eq(0)' );
        })
    </script>
    <script>
        $(document).ready(function(){
            $('.openPopup').on('click',function(){
                var dataURL = $(this).attr('data-href');
                $('.modal-body2').load(dataURL,function(){
                    $('#po_shift').modal({show:true});
                });
            });
        });
    </script>
@endsection

<!-- end:: Content -->