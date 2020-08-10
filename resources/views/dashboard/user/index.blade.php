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
					Users Listing
				</h3>
			</div>
			<div class="kt-portlet__head-toolbar">
				<div class="kt-portlet__head-wrapper">
					<div class="kt-portlet__head-actions">
						<div class="dropdown dropdown-inline">
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
						&nbsp;
						<a href="{{ route('users.create')}}" class="btn btn-brand btn-elevate btn-icon-sm">
							<i class="la la-plus"></i>
							New Record
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="kt-portlet__body">

			<!--begin: Datatable -->
			<table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_user">
				<thead>
					<tr>
						<th>ID</th>
						<th>Full Name</th>
						<th>Email</th>
						<th>Phone</th>
						<th>Address</th>
						<th>Status</th>
						<th>Type</th>
						<th>Actions</th>
					</tr>
				</thead>
			</table>
			<!--end: Datatable -->
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

@endsection
<!-- end:: Content -->