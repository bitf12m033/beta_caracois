"use strict";
var KTDatatablesDataSourceAjaxServer = function() {

	var initTable1 = function() {
		var table = $('#kt_table_1');

		// begin first table
		table.DataTable({
			responsive: true,
			// searchDelay: 500,
			// processing: true,
			// serverSide: true,
			ajax: {
				// url: 'https://keenthemes.com/metronic/themes/themes/metronic/dist/preview/inc/api/datatables/demos/default.php',
				url: '/ajax/products',
				type: 'GET',
				data: {
					pagination: {
						perpage: 50,
					},
				},
			},
			columns: [
				{data: 'sr'},
				{data: 'product_name'},
				{data: 'expired_date'},
				{data: 'quantity'},
				{data: 'sell_price'},
				{data: 'Status'},
				{data: 'Type'},
				{data: 'Actions', responsivePriority: -1},
			],
			columnDefs: [
				{
					targets: -1,
					title: 'Actions',
					orderable: false,
					render: function(data, type, full, meta) {
						return `
                        <span class="dropdown">
                            <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="true">
                              <i class="la la-ellipsis-h"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="products/`+full.id+`/edit"><i class="la la-edit"></i> Edit Details</a>
                                <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>
                                <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>
                            </div>
                        </span>
                        <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View">
                          <i class="la la-edit"></i>
                        </a>
                        <a href="javascript:;" onclick="deleteModal(`+full.id+`)" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">\
								<i class="la la-trash"></i>
							</a>
                        `;
					},
				},
				{
					targets: -3,
					render: function(data, type, full, meta) {
						var status = {
							1: {'title': 'Pending', 'class': 'kt-badge--brand'},
							2: {'title': 'Delivered', 'class': ' kt-badge--danger'},
							3: {'title': 'Canceled', 'class': ' kt-badge--primary'},
							4: {'title': 'Success', 'class': ' kt-badge--success'},
							5: {'title': 'Info', 'class': ' kt-badge--info'},
							6: {'title': 'Danger', 'class': ' kt-badge--danger'},
							7: {'title': 'Warning', 'class': ' kt-badge--warning'},
						};
						if (typeof status[data] === 'undefined') {
							return data;
						}
						return '<span class="kt-badge ' + status[data].class + ' kt-badge--inline kt-badge--pill">' + status[data].title + '</span>';
					},
				},
				{
					targets: -2,
					render: function(data, type, full, meta) {
						var status = {
							1: {'title': 'Online', 'state': 'danger'},
							2: {'title': 'Retail', 'state': 'primary'},
							3: {'title': 'Direct', 'state': 'success'},
						};
						if (typeof status[data] === 'undefined') {
							return data;
						}
						return '<span class="kt-badge kt-badge--' + status[data].state + ' kt-badge--dot"></span>&nbsp;' +
							'<span class="kt-font-bold kt-font-' + status[data].state + '">' + status[data].title + '</span>';
					},
				},
			],
		});
	};

	return {

		//main function to initiate the module
		init: function() {
			initTable1();
		},

	};

}();

jQuery(document).ready(function() {
	KTDatatablesDataSourceAjaxServer.init();
});

function deleteModal(id)
{
	var modal = '<div class="modal fade" id="kt_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">\
				<div class="modal-dialog" role="document">\
					<div class="modal-content">\
						<div class="modal-header">\
							<h5 class="modal-title" id="exampleModalLabel">Delete Product/h5>\
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">\
							</button>\
						</div>\
						<div class="modal-body">\
							<p>Are you sure?Do you really want to delete this?.</p>\
						</div>\
						<div class="modal-footer">\
							<form action="products/'+id+'" method="POST">\
							<input type="hidden" name="_token" value="zhinwXNmwHZB9l8uPr8KQLOCfuNKRW4QG6D5FVSz">\
							<input type="hidden" name="_method" value="DELETE">\
							<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>\
							<button type="submit" class="btn btn-danger">Yes</button>\
							</form>\
						</div>\
					</div>\
				</div>\
			</div>';
$('body').append(modal);

$("#kt_modal_1").modal("show");
// $('#myModal').modal('toggle');
}