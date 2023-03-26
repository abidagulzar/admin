@extends('Admin.Layout.master')

@section('pagebreadcrumb')
<ol class="breadcrumb">
	<li>Coupon</li>
	<li>List</li>
</ol>
@endsection
@section('content')
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		@can('Coupon Create')
		<a class="btn btn-success" href="{{ route('admin.coupon.create') }}"> Create New Coupon</a>
		<a class="btn btn-success" href="{{ route('admin.coupon.copycoupon') }}" id="copyCoupon"> Copy Coupons</a>
		@endcan
		@can('Coupon Delete')
		<a class="btn btn-danger" id="btnDeleteCoupon"> Delete Coupon</a>
		<a class="btn btn-danger" id="btnDeleteUserCoupon"> Delete Coupons By User</a>
		@endcan

	</div>
</div>

<!-- <div class="row">
	<div class="col-md-12">
		<div class="input-group pull-right">
			<button id="btnSearch" type="button" class="btn btn-primary">Search</button>
		</div>
		@if (Auth::user()->isAdmin())

		@endif
	</div>
</div> -->
<br />
<section id="widget-grid" class="">


	<div class="row">


		<div class="col-md-4">
			<label class="control-label">Store Name</label>
			<select style="width:100%" id="StoreId" name="StoreId" class="select2">


				@if(isset($stores))
				@foreach($stores as $StoreId => $Name)
				{{ $seleced = '' }}

				<option value="{{ $StoreId }}">{{ $Name }}</option>

				@endforeach
				@endif

			</select>
		</div>

		<div class="col-md-3">
			<div class="input-group pull-right">
				<button id="btnSearch" type="button" class="btn btn-primary">Search</button>
			</div>
			<div class="input-group pull-left">
				<button id="btnExcelExport" type="button" class="btn btn-primary">Export Excel</button>
			</div>
		</div>
	</div>
	<br />
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
					<h2>Coupon List</h2>

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

						<table id="coupon_table" class="table table-striped table-bordered table-hover" width="100%">
							<thead>
								<tr>
									<th><input type="checkbox" id="selectall" onclick="CouponModule.SelectAllList(this)" /> </th>
									<th>Action</th>
									<th>Header</th>
									<th>Description</th>
									<th>CouponUrl</th>
									<th>Code</th>
									<th>OFF</th>
									<th>Expiry Date</th>
									<th>Is Banner</th>
									<th>Is Home Coupon</th>
									<th>Is Header Coupon</th>
									<th>Is Home Banner</th>
									<th>Is Top Deal</th>
									<th>Store Rank</th>
									<th>Country</th>
									<th>Created By</th>
									<th>Create Date/Time</th>
									<th>Updated By</th>
									<th>Update Date/Time</th>

								</tr>
							</thead>
							<tbody>
							</tbody>
							<tfoot>
								<tr>
									<th></th>
									<th></th>
									<th class="searchable"></th>
									<th class="searchable"></th>
									<th class="searchable"></th>
									<th class="searchable"></th>
									<th class="searchable"></th>
									<th class="searchable"></th>
									<th class="searchable"></th>
									<th class="searchable"></th>
									<th class="searchable"></th>
									<th class="searchable"></th>
									<th class="searchable"></th>
									<th class="searchable"></th>
									<th class="searchable"></th>
									<th class="searchable"></th>
									<th class="searchable"></th>
									<th class="searchable"></th>
									<th class="searchable"></th>
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
	@can('Coupon Delete')
	<div id="deleteCouponModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Delete Coupon</h4>
				</div>
				<div class="modal-body">
					<div id="deleteCouponText"></div>
				</div>

				<form class="form-horizontal" id="deleteCouponForm" method="post" action="{{ route('admin.coupon.delete') }}">
					{{ csrf_field() }}
					<input type="hidden" id="CouponId" name="CouponId" class="delete" />
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
						<button type="submit" class="btn btn-danger">Yes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div id="deleteUserCouponModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Delete Coupon By User</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" id="deleteUserCouponForm" method="post" action="{{ route('admin.coupon.deletebyuser') }}">

						<div>Delete Coupon For Store <span id="storeName"></span> Added BY</div>
						<div class="row">


							<div class="col-md-12">
								<label class="control-label">User Name</label>
								<select style="width:100%" id="UserId" name="UserId" class="select2">


									@if(isset($users))
									@foreach($users as $id => $name)
									{{ $seleced = '' }}

									<option value="{{ $id }}">{{ $name }}</option>

									@endforeach
									@endif

								</select>
							</div>
						</div>

						{{ csrf_field() }}
						<input type="hidden" id="DeleteUserStoreId" name="DeleteUserStoreId" class="delete" />
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
	var CouponModule = (function() {

			var responsiveHelper_coupon_table = undefined;
			var self = {};
			var editCouponModelSelector = "#editCouponModal";
			var editCouponPasswordModelSelector = "#editCouponPasswordModal";
			var createCouponModelSelector = "#createCouponModal";
			var deleteCouponModelSelector = "#deleteCouponModal";
			var deleteUserCouponModalSelector = "#deleteUserCouponModal";


			var couponTable = null;

			var breakpointDefinition = {
				tablet: 1024,
				phone: 480
			};

			self.deleteCouponModal = function(couponId, couponName) {

				$("#deleteCouponText").html("Do you want to delete Coupon with Header <b>" + couponName + "</b> ?");

				$("#CouponId.delete").val(couponId);

				$(deleteCouponModelSelector).modal('show');
			}



			self.BindEvents = function() {


				$("#btnExcelExport").off().click(function() {
					$(".dt-button.buttons-excel.buttons-html5").trigger("click");
				});

				$('#StoreId').on("select2:select", function(e) {
					couponTable.ajax.reload();
				});

				$("#btnSearch").off().click(function() {
					couponTable.ajax.reload();
				});

				$("#btnDeleteUserCoupon").off().click(function() {

					var data = $("#StoreId").select2('data')

					$("#DeleteUserStoreId").val($("#StoreId").val());
					$("#storeName").html(data[0].text);
					$(deleteUserCouponModalSelector).modal('show');
				});

				$("#btnDeleteCoupon").off().click(function() {

					var checked = $(".selectrowcheckbox:checked");
					if (checked.length == 0) {
						showErrorMessgae("Select some coupons to delete.");
					} else {

						$("#deleteCouponText").html("Do you want to delete selected coupons ?");

						var ids = checked.map(function() {
							return $(this).data('id');
						}).get().toString();

						$("#CouponId.delete").val(ids);

						$(deleteCouponModelSelector).modal('show');
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
			//'CouponId', 'Code', 'Header', 'ExpiryDate', 'IsBanner', 'HomeCoupon', 'IsHeaderDeal'
			self.BindCouponTable = function() {
				couponTable = $('#coupon_table').DataTable({
					"deferRender": true,
					"sAjaxSource": "{{ route('admin.coupon.index') }}",
					"fnServerParams": function(aoData) {
						aoData.push({
							"name": "StoreId",
							"value": $("#StoreId").val()

						});
					},
					"aoColumns": [{
							"sWidth": "5%",
							"sClass": "text-center",
							"render": function(data, type, row) {
								return '<input type="checkbox" class="selectrowcheckbox" data-id="' + row.CouponId + '" class=""/>';
							},
						},

						{

							"sWidth": "5%",
							"render": function(data, type, row, val) {

								var actions = '<div class="" style="cursor:pointer">';
								var editAction = "{{ route('admin.coupon.edit', 'id') }}";
								editAction = editAction.replace('id', row.CouponId);
								var dataTitle = row.Header;
								var DealPageUrl = "";
								if (row.DealPageUrl)
									DealPageUrl = '<a target="_blank" class="green" href="' + row.DealPageUrl + '" ) ><i class="fa fa-eye datatable-Icon"></i></a>';
								actions += DealPageUrl + '<a target="_blank" class="green" href="' + row.CouponUrl + '" ) ><i class="fa fa-eye datatable-Icon"></i></a><a class="green"  href="' + editAction + '"  ><i class="fa fa-pencil datatable-Icon"></i></a>  <a class="red" onClick="CouponModule.deleteCouponModal(' + "\'" + row.CouponId + "\'" + "," + "\'" + dataTitle + "\'" + ')"  ><i class="fa fa-trash-o datatable-Icon"></i></a></div>'

								return actions;
							},
							"sClass": "text-center"
						},







						{
							"mData": "Header",
							"sClass": "text-center"
						},
						{
							"mData": "Description",
							"sClass": "text-center"
						},
						{
							"mData": "CouponUrl",
							"sClass": "text-center"
						},
						{
							"mData": "Code",
							"sClass": "text-center"
						},
						{
							"mData": "OFF",
							"sClass": "text-center"
						},

						{

							"render": function(data, type, row, val) {
								if (row.IsUnknownOutGoing == 1)
									return "Unknown/OutGoing";
								else {
									if (row.ExpiryDate && !row.ExpiryDate.includes("1999")) {
										var splited = row.ExpiryDate.split(' ')[0].split('-');

										return splited[2] + "/" + splited[1] + "/" + splited[0]
									}

									return "";
								}
							},
							"sClass": "text-center"
						},

						{

							"render": function(data, type, row, val) {
								if (row.IsBanner == 1) {
									return "Yes";
								}

								return "No";
							},
							"sClass": "text-center"
						},
						{

							"render": function(data, type, row, val) {
								if (row.HomeCoupon == 1) {
									return "Yes";
								}

								return "No";
							},
							"sClass": "text-center"
						},
						{

							"render": function(data, type, row, val) {
								if (row.IsHeaderDeal == 1) {
									return "Yes";
								}

								return "No";
							},
							"sClass": "text-center"
						},
						{

							"render": function(data, type, row, val) {
								if (row.IsHomeBanner == 1) {
									return "Yes";
								}

								return "No";
							},
							"sClass": "text-center"
						},
						{

							"render": function(data, type, row, val) {
								if (row.IsTopDeal == 1) {
									return "Yes";
								}

								return "No";
							},
							"sClass": "text-center"
						},

						{
							"mData": "StoreRank",
							"sClass": "text-center"
						},
						{

							"render": function(data, type, row, val) {
								if (row.CouponCountryName) {
									return row.CouponCountryName;
								}

								return "All";
							},
							"sClass": "text-center"
						},
						{
							"mData": "CreatedByUser",
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
							"mData": "UpdatedByUser",
							"sClass": "text-center"
						},
						{

							"render": function(data, type, row, val) {

								if (row.UpdateDate) {

									try {
										return (new Date(row.UpdateDate)).toLocaleString();
									} catch {
										return "";

									}
								}

								return "";
							},
							"sClass": "text-center"
						}
					],
					"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
						"Btf" +
						"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
					"autoWidth": true,
					"preDrawCallback": function() {
						// Initialize the responsive datatables helper once.
						if (!responsiveHelper_coupon_table) {
							responsiveHelper_coupon_table = new ResponsiveDatatablesHelper($('#coupon_table'), breakpointDefinition);
						}
					},
					buttons: [
						'copyHtml5',
						'excelHtml5',
						'csvHtml5',
						'pdfHtml5'
					],
					"rowCallback": function(nRow) {
						responsiveHelper_coupon_table.createExpandIcon(nRow);
					},
					"drawCallback": function(oSettings) {
						responsiveHelper_coupon_table.respond();
					}

				});



				// Apply the filter
				$("#coupon_table thead th input[type=text]").on('keyup change', function() {

					otable
						.column($(this).parent().index() + ':visible')
						.search(this.value)
						.draw();

				});

				// Setup - add a text input to each footer cell
				$('#coupon_table tfoot th.searchable').each(function() {
					var title = $(this).text();
					$(this).html('<input type="text" placeholder="Search ' + title + '" />');
				});



				// Apply the search
				couponTable.columns().every(function() {
					var that = this;

					$('input', this.footer()).on('keyup change clear', function() {
						if (that.search() !== this.value) {
							that
								.search(this.value)
								.draw();
						}
					});
				});

				$(".dt-buttons").addClass("hidden");
			}

			return self;
		}()

	);

	jQuery(function($) {
		CouponModule.BindCouponTable();
		CouponModule.BindEvents();
	});
</script>

@endsection