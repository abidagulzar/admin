@extends('Admin.Layout.master')
@section('pagebreadcrumb')
<ol class="breadcrumb">
	<li>Store Settings</li>
	<li>List</li>
</ol>
@endsection
@section('content')
<div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		@can('Store Settings Create')
		<a class="btn btn-success" href="{{ route('admin.storesetting.create') }}"> Create New Store Settings</a>
		@endcan
		@can('Store Settings Delete')
		<a class="btn btn-danger" id="btnDeleteStore"> Delete Store Settings</a>
		@endcan

	</div>
</div>

<section id="widget-grid" class="">

	<div class="row">
		<div class="col-md-3">
			<div class="input-group pull-right">
				<button id="btnSearch" type="button" class="btn btn-primary">Search</button>
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

				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>Store Settings List</h2>

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

						<table id="storesettings_table" class="table table-striped table-bordered table-hover" width="100%">
							<thead>
								<tr>
									<th><input type="checkbox" id="selectall" onclick="StoreSettingModule.SelectAllList(this)" /> </th>
									<th>Region</th>
									<th>Title</th>
									<th>Keywords</th>
									<th>Created By</th>
									<th>Create Date/Time</th>

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
	@can('Store Settings Delete')
	<div id="deleteStoreModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Delete Store Settings</h4>
				</div>
				<div class="modal-body">
					<div id="deleteStoreText"></div>
				</div>

				<form class="form-horizontal" id="deleteStoreForm" method="post" action="{{ route('admin.storesetting.delete') }}">
					{{ csrf_field() }}
					<input type="hidden" id="StoreId" name="StoreId" class="delete" />
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
	var StoreSettingModule = (function() {

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

			self.deleteStoreModal = function(storeId, storeName) {

				$("#deleteStoreText").html("Do you want to delete Store Settings <b>" + storeName + "</b> ?");

				$("#StoreId.delete").val(storeId);

				$(deleteStoreModelSelector).modal('show');

			}



			self.BindEvents = function() {

				$("#btnDeleteStore").off().click(function() {

					var checked = $(".selectrowcheckbox:checked");
					if (checked.length == 0) {
						showErrorMessgae("Select some stores to delete.");
					} else {

						$("#deleteStoreText").html("Do you want to delete selected stores ?");

						var ids = checked.map(function() {
							return $(this).data('id');
						}).get().toString();

						$("#StoreId.delete").val(ids);

						$(deleteStoreModelSelector).modal('show');
					}
				});

				$("#btnSearch").off().click(function() {
					storeTable.ajax.reload();
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
				storeTable = $('#storesettings_table').DataTable({
					"deferRender": true,
					"sAjaxSource": "{{ route('admin.storesetting.index') }}",
					"fnServerParams": function(aoData) {},
					"aoColumns": [{

							"sClass": "text-center",
							"render": function(data, type, row) {
								return '<input type="checkbox" class="selectrowcheckbox" data-id="' + row.StoreId + '" class=""/>';
							},
						},
						{
							"mData": "RegionName",
							"sClass": "text-center"
						},
						{
							"mData": "Title",
							"sClass": "text-center"
						},

						{
							"mData": "Keywords",
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

							"sWidth": "10%",
							"render": function(data, type, row, val) {

								var actions = '<div class="" style="cursor:pointer">';
								var editAction = "{{ route('admin.storesetting.edit', 'id') }}";
								editAction = editAction.replace('id', row.StoreSettingId);
								var dataTitle = row.Name;
								actions += '<a class="green"  href="' + editAction + '"  ><i class="fa fa-pencil datatable-Icon"></i></a>  <a class="red" onClick="StoreSettingModule.deleteStoreModal(' + "\'" + row.StoreId + "\'" + "," + "\'" + dataTitle + "\'" + ')"  ><i class="fa fa-trash-o datatable-Icon"></i></a></div>'

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
						if (!responsiveHelper_store_table) {
							responsiveHelper_store_table = new ResponsiveDatatablesHelper($('#storesettings_table'), breakpointDefinition);
						}
					},
					"rowCallback": function(nRow) {
						responsiveHelper_store_table.createExpandIcon(nRow);
					},
					"drawCallback": function(oSettings) {
						responsiveHelper_store_table.respond();
					}

				});

				// custom toolbar


				// Apply the filter
				$("#storesettings_table thead th input[type=text]").on('keyup change', function() {

					otable
						.column($(this).parent().index() + ':visible')
						.search(this.value)
						.draw();

				});


				// Setup - add a text input to each footer cell
				$('#storesettings_table tfoot th.searchable').each(function() {
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
			}

			return self;
		}()

	);

	jQuery(function($) {
		StoreSettingModule.BindStoreTable();
		StoreSettingModule.BindEvents();
	});
</script>

@endsection