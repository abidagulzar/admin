@extends('Admin.Layout.master')
@section('pagebreadcrumb')
<ol class="breadcrumb">
	<li>CPC Store</li>
	<li>List</li>
</ol>
@endsection
@section('content')
<div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">

		<a class="btn btn-success" href="{{ route('admin.cpcstore.create') }}"> Create New CPC Store</a>

		<a class="btn btn-danger" id="btnDeleteCPCStore"> Delete CPC Store</a>


	</div>
</div>

<section id="widget-grid" class="">

	<div class="row">

		<div class="col-md-3">
			<label class="control-label">Country</label>
			<select multiple style="width:100%" id="CountryId" name="CountryId" class="select2">

				@if(isset($countries))
				@foreach($countries as $CountryId => $Name)
				<option value="{{ $CountryId }}">{{ $Name }}</option>

				@endforeach
				@endif

			</select>
		</div>

		<br />
		<div class="col-md-3">
			<div class="input-group pull-right">
				<button id="btnSearch" type="button" class="btn btn-primary">Search</button>
			</div>
			@if (Auth::user()->isAdmin())
			<div class="input-group pull-left">
				<button id="btnExcelExport" type="button" class="btn btn-primary">Export Excel</button>
			</div>
			@endif
		</div>
	</div>

	<br />

	<!-- row -->
	<div class="row">

		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">

				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Store List</h2>

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

						<table id="store_table" class="table table-striped table-bordered table-hover" width="100%">
							<thead>
								<tr>
									<th><input type="checkbox" id="selectall" onclick="StoreModule.SelectAllList(this)" /> </th>
									<th>Action</th>
									<th>Store Regional Name</th>
									<th>Country</th>
									<th>Track Url</th>
									<th>Commission</th>
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
	@can('Store Delete')
	<div id="deleteStoreModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Delete CPC Store</h4>
				</div>
				<div class="modal-body">
					<div id="deleteStoreText"></div>
				</div>

				<form class="form-horizontal" id="deleteCPCStoreForm" method="post" action="{{ route('admin.cpcstore.delete') }}">
					{{ csrf_field() }}
					<input type="hidden" id="CPCStoreId" name="CPCStoreId" class="delete" />
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
	var StoreModule = (function() {

			var responsiveHelper_store_table = undefined;
			var self = {};
			var editStoreModelSelector = "#editStoreModal";
			var editStorePasswordModelSelector = "#editStorePasswordModal";
			var createStoreModelSelector = "#createStoreModal";
			var deleteStoreModelSelector = "#deleteStoreModal";

			var storeTable = null;

			var breakpointDefinition = {
				tablet: 1024,
				phone: 480
			};

			self.deleteStoreModal = function(CPCStoreId, storeName) {

				$("#deleteStoreText").html("Do you want to delete CPC Store <b>" + storeName + "</b> ?");

				$("#CPCStoreId.delete").val(CPCStoreId);

				$(deleteStoreModelSelector).modal('show');

			}



			self.BindEvents = function() {

				$("#btnDeleteCPCStore").off().click(function() {

					var checked = $(".selectrowcheckbox:checked");
					if (checked.length == 0) {
						showErrorMessgae("Select some CPC stores to delete.");
					} else {

						$("#deleteStoreText").html("Do you want to delete selected stores ?");

						var ids = checked.map(function() {
							return $(this).data('id');
						}).get().toString();

						$("#CPCStoreId.delete").val(ids);

						$(deleteStoreModelSelector).modal('show');
					}
				});

				$("#btnSearch").off().click(function() {

					storeTable.ajax.reload();

				});

				$("#btnExcelExport").off().click(function() {
					$(".dt-button.buttons-excel.buttons-html5").trigger("click");
				});


			}

			self.SelectAllList = function(obj) {
				if ($(obj).is(":checked")) {
					$(".selectrowcheckbox").attr("checked", "checked").prop("checked", "checked");
				} else {

					$(".selectrowcheckbox").removeAttr("checked")
				}

			}

			self.BindStoreTable = function() {
				storeTable = $('#store_table').DataTable({
					"deferRender": true,
					"sAjaxSource": "{{ route('admin.cpcstore.index') }}",
					"fnServerParams": function(aoData) {

						if ($("#CountryId").val()) {
							aoData.push({
								"name": "CountryId",
								"value": $("#CountryId").val().toString()
							});
						}
					},
					"aoColumns": [{

							"sClass": "text-center",
							"render": function(data, type, row) {
								return '<input type="checkbox" class="selectrowcheckbox" data-id="' + row.CPCStoreId + '" class=""/>';
							},
						},
						{

							"sWidth": "7%",
							"render": function(data, type, row, val) {

								var actions = '<div class="" style="cursor:pointer">';
								var editAction = "{{ route('admin.cpcstore.edit', 'id') }}";
								editAction = editAction.replace('id', row.CPCStoreId);
								var editAllAction = "{{ route('admin.cpcstore.editall', 'id') }}";
								editAllAction = editAllAction.replace('id', row.CPCStoreId);
								var dataTitle = row.RegionalName;
								actions += '<a title="Edit All" class="red" style="display:none;"  href="' + editAllAction + '"  ><i class="fa fa-pencil datatable-Icon"></i></a> <a class="green" title="Edit"  href="' + editAction + '"  ><i class="fa fa-pencil datatable-Icon"></i></a>  <a class="red" onClick="StoreModule.deleteStoreModal(' + "\'" + row.CPCStoreId + "\'" + "," + "\'" + dataTitle + "\'" + ')"  ><i class="fa fa-trash-o datatable-Icon"></i></a></div>'

								return actions;
							},
							"sClass": "text-center"
						}, {
							"mData": "RegionalName",
							"sClass": "text-center"
						},
						{
							"mData": "CountryName",
							"sClass": "text-center"
						},
						{
							"mData": "TrackURL",
							"sClass": "text-center"
						},
						{
							"mData": "Commission",
							"sClass": "text-center"
						},


					],
					"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
						"Btf" +
						"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
					"autoWidth": true,
					"preDrawCallback": function() {
						// Initialize the responsive datatables helper once.
						if (!responsiveHelper_store_table) {
							responsiveHelper_store_table = new ResponsiveDatatablesHelper($('#store_table'), breakpointDefinition);
						}
					},
					buttons: [
						'copyHtml5',
						'excelHtml5',
						'csvHtml5',
						'pdfHtml5'
					],
					"rowCallback": function(nRow) {
						responsiveHelper_store_table.createExpandIcon(nRow);
					},
					"drawCallback": function(oSettings) {
						responsiveHelper_store_table.respond();
					}

				});

				// custom toolbar


				// Apply the filter
				$("#store_table thead th input[type=text]").on('keyup change', function() {

					otable
						.column($(this).parent().index() + ':visible')
						.search(this.value)
						.draw();

				});


				// Setup - add a text input to each footer cell
				$('#store_table tfoot th.searchable').each(function() {
					var title = $(this).text();
					$(this).html('<input type="text" placeholder="Search ' + title + '" />');
				});



				// Apply the search
				storeTable.columns().every(function() {
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

		StoreModule.BindStoreTable();

		StoreModule.BindEvents();
	});
</script>

@endsection