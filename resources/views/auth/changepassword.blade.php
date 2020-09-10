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
                                Edit User
                            </h3>
                        </div>
                        <div class="kt-portlet__head-toolbar">
                            <div class="kt-portlet__head-wrapper">
                                <a href="{!! route('home') !!}" class="btn btn-clean btn-icon-sm">
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
                    <form action="{{ route('password.update') }}" id="changePassword" method="post">
                        @csrf
                        <div class="form-group" style="margin: 30px;">
                            <label for="existingPassword">Existing Password</label>
                            <input type="password" class="form-control" data-bv-field="existingpassword"  name="current_password" id="existingPassword" required placeholder="Existing Password">
                        </div>
                        <div class="form-group" style="margin: 30px;">
                            <label for="newPassword">New Password</label>
                            <input type="password" class="form-control" data-bv-field="newpassword" name="new_password" id="newPassword" required placeholder="New Password">
                        </div>
                        <div class="form-group" style="margin: 30px;">
                            <label for="existingPassword">Confirm Password</label>
                            <input type="password" class="form-control" data-bv-field="confirmgpassword" name="confirm_password" id="confirmPassword" required placeholder="Confirm Password">
                        </div>
                        <div class="form-group" style="margin: 30px;">
                            <button class="btn btn-primary" type="submit">Update Password</button>
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
    <script>
        $(document).ready(function(){
            $('#mobileNumber').attr("disabled", true);
            $('#emailID').attr("disabled", true);
        });
    </script>
    <script>
        $('#admindob').daterangepicker({
            showDropdowns: true,

            singleDatePicker: true,
            maxDate: moment(),
            autoUpdateInput: false,
        }, function(chosen_date) {
            $('#admindob').val(chosen_date.format('DD-MM-YYYY'));
        });
    </script>

@endsection