@extends('Admin.Layout.master')
@section('pagebreadcrumb')
<ol class="breadcrumb">
	<li>Coupon</li>
	<li>Submitted Coupon</li>
</ol>
@endsection
@section('content')
<div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		@can('Submitted Coupon Delete')
		<a class="btn btn-danger" id="btnDeleteSubmittedCoupon"> Delete Submitted Coupon</a>
		@endcan

	</div>
</div>
<br />
<section id="widget-grid" class="">

	<!-- row -->
	<div class="row">

		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
				<!-- widget options:
								usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">
				
								data-widget-colorbutton="false"
								data-widget-editbutton="false"
								data-widget-togglebutton="false"
								data-widget-deletebutton="false"
								data-widget-fullscreenbutton="false"
								data-widget-custombutton="false"
								data-widget-collapsed="true"
								data-widget-sortable="false"
				
								-->
				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Submitted Coupon List</h2>

				</header>

				<!-- widget div-->
				<div>

					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<!-- This area used as dropdown edit box -->

					</div>
					<!-- end widget edit box -->

					<!-- widget content -->
					<div class="widget-body no-padding">

						<table id="submittedcoupon_table" class="table table-striped table-bordered table-hover" width="100%">
							<thead>
								<tr>
									<th><input type="checkbox" id="selectall" onclick="SubmittedCouponModule.SelectAllList(this)" /> </th>
									<th>Store Name</th>
									<th>Code</th>
									<th>Description</th>
									<th>Expiry Date</th>
									<th>Submite Date/Time</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
							<tfoot>
								<tr>
									<th></th>
									<th class="searchable"></th>
									<th class="searchable"></th>
									<th class="searchable"></th>
									<th class="searchable"></th>
									<th class="searchable"></th>
									<th></th>
								</tr>
							</tfoot>
						</table>

					</div>
					<!-- end widget content -->

				</div>
				<!-- end widget div -->

			</div>
			<!-- end widget -->

		</article>
		<!-- WIDGET END -->

	</div>

	<!-- end row -->

	<!-- end row -->
	@can('Submitted Coupon Delete')
	<div id="deleteSubmittedCouponModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Delete Submitted Coupon</h4>
				</div>
				<div class="modal-body">
					<div id="deleteSubmittedCouponText"></div>
				</div>

				<form class="form-horizontal" id="deleteSubmittedCouponForm" method="post" action="{{ route('admin.submittedcoupon.delete') }}">
					{{ csrf_field() }}
					<input type="hidden" id="SubmittedCouponId" name="SubmittedCouponId" class="delete" />
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
						<button type="submit" class="btn btn-danger">Yes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	@endcan

</section>

@endsection
@section('pagescripts')
<script type="text/javascript">
	var SubmittedCouponModule = (function() {

			var responsiveHelper_submittedcoupon_table = undefined;
			var self = {};
			var editSubmittedCouponModelSelector = "#editSubmittedCouponModal";
			var editSubmittedCouponPasswordModelSelector = "#editSubmittedCouponPasswordModal";
			var createSubmittedCouponModelSelector = "#createSubmittedCouponModal";
			var deleteSubmittedCouponModelSelector = "#deleteSubmittedCouponModal";

			var submittedcouponTable = null;

			var breakpointDefinition = {
				tablet: 1024,
				phone: 480
			};

			self.deleteSubmittedCouponModal = function(submittedcouponId, submittedcouponName) {

				$("#deleteSubmittedCouponText").html("Do you want to delete Submitted Coupon <b>" + submittedcouponName + "</b> ?");

				$("#SubmittedCouponId.delete").val(submittedcouponId);

				$(deleteSubmittedCouponModelSelector).modal('show');

			}



			self.BindEvents = function() {

				$("#btnDeleteSubmittedCoupon").off().click(function() {

					var checked = $(".selectrowcheckbox:checked");
					if (checked.length == 0) {
						showErrorMessgae("Select some submittedcoupons to delete.");
					} else {

						$("#deleteSubmittedCouponText").html("Do you want to delete selected submittedcoupons ?");

						var ids = checked.map(function() {
							return $(this).data('id');
						}).get().toString();

						$("#SubmittedCouponId.delete").val(ids);

						$(deleteSubmittedCouponModelSelector).modal('show');
					}
				});



			}

			self.SelectAllList = function(obj) {
				if ($(obj).is(":checked")) {
					$(".selectrowcheckbox").attr("checked", "checked").prop("checked", "checked");
				} else {

					$(".selectrowcheckbox").removeAttr("checked")
				}

			}

			self.BindSubmittedCouponTable = function() {
				submittedcouponTable = $('#submittedcoupon_table').DataTable({
					"deferRender": true,
					"sAjaxSource": "{{ route('admin.submittedcoupon.index') }}",
					"aoColumns": [{

							"sClass": "text-center",
							"render": function(data, type, row) {
								return '<input type="checkbox" class="selectrowcheckbox" data-id="' + row.SubmittedCouponId + '" class=""/>';
							},
						},
						{
							"mData": "StoreName",
							"sClass": "text-center"
						},
						{
							"mData": "Code",
							"sClass": "text-center"
						},

						{
							"mData": "Description",
							"sClass": "text-center"
						},

						{

							"render": function(data, type, row, val) {

								if (row.ExpiryDate) {
									var splited = row.ExpiryDate.split(' ')[0].split('-');

									return splited[2] + "/" + splited[1] + "/" + splited[0]
								}

								return "";
							},
							"sClass": "text-center"
						},
						{

							"render": function(data, type, row, val) {

								if (row.CreateDate) {

									try {
										return (new Date(row.CreateDate)).toLocaleString();
									} catch {
										return "";

									}
								}

								return "";
							},
							"sClass": "text-center"
						},

						{

							"sWidth": "10%",
							"render": function(data, type, row, val) {

								var actions = '<div class="" style="cursor:pointer">';

								var dataTitle = row.Description;
								actions += '<a class="red" onClick="SubmittedCouponModule.deleteSubmittedCouponModal(' + "\'" + row.SubmittedCouponId + "\'" + "," + "\'" + dataTitle + "\'" + ')"  ><i class="fa fa-trash-o datatable-Icon"></i></a></div>'

								return actions;
							},
							"sClass": "text-center"
						}
					],
					"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
						"t" +
						"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
					"autoWidth": true,
					"preDrawCallback": function() {
						// Initialize the responsive datatables helper once.
						if (!responsiveHelper_submittedcoupon_table) {
							responsiveHelper_submittedcoupon_table = new ResponsiveDatatablesHelper($('#submittedcoupon_table'), breakpointDefinition);
						}
					},
					"rowCallback": function(nRow) {
						responsiveHelper_submittedcoupon_table.createExpandIcon(nRow);
					},
					"drawCallback": function(oSettings) {
						responsiveHelper_submittedcoupon_table.respond();
					}

				});

				// custom toolbar


				// Apply the filter
				$("#submittedcoupon_table thead th input[type=text]").on('keyup change', function() {

					otable
						.column($(this).parent().index() + ':visible')
						.search(this.value)
						.draw();

				});


				// Setup - add a text input to each footer cell
				$('#submittedcoupon_table tfoot th.searchable').each(function() {
					var title = $(this).text();
					$(this).html('<input type="text" placeholder="Search ' + title + '" />');
				});



				// Apply the search
				submittedcouponTable.columns().every(function() {
					var that = this;

					$('input', this.footer()).on('keyup change clear', function() {
						if (that.search() !== this.value) {
							that
								.search(this.value)
								.draw();
						}
					});
				});
			}

			return self;
		}()

	);

	jQuery(function($) {
		SubmittedCouponModule.BindSubmittedCouponTable();
		SubmittedCouponModule.BindEvents();
	});
</script>

@endsection