@extends('Admin.Layout.master')
@section('pagebreadcrumb')
<ol class="breadcrumb">
	<li>ExcludeTrafficIP</li>
	<li>List</li>
</ol>
@endsection
@section('content')
<div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		@can('VisitorIPExclude Create')
		<a class="btn btn-success" href="{{ route('admin.excludetrafficip.create') }}"> Add Exclude IP</a>
		@endcan
		@can('VisitorIPExclude Delete')
		<a class="btn btn-danger" id="btnDeleteExcludeTrafficIP"> Delete Exclude IP</a>
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
					<h2>ExcludeTrafficIP List</h2>

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
									<th><input type="checkbox" id="selectall" onclick="ExcludeTrafficIPModule.SelectAllList(this)" /> </th>
									<th>Title</th>
									<th>IP</th>
									<th>Created By</th>
									<th>Create Date/Time</th>
									<th>Update By</th>
									<th>Update Date/Time</th>
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
	@can('VisitorIPExclude Delete')
	<div id="deleteExcludeTrafficIPModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Delete ExcludeTrafficIP</h4>
				</div>
				<div class="modal-body">
					<div id="deleteExcludeTrafficIPText"></div>
				</div>

				<form class="form-horizontal" id="deleteExcludeTrafficIPForm" method="post" action="{{ route('admin.excludetrafficip.delete') }}">
					{{ csrf_field() }}
					<input type="hidden" id="ExcludeTrafficIPId" name="ExcludeTrafficIPId" class="delete" />
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
	var ExcludeTrafficIPModule = (function() {

			var responsiveHelper_store_table = undefined;
			var self = {};
			var editExcludeTrafficIPModelSelector = "#editExcludeTrafficIPModal";
			var editExcludeTrafficIPPasswordModelSelector = "#editExcludeTrafficIPPasswordModal";
			var createExcludeTrafficIPModelSelector = "#createExcludeTrafficIPModal";
			var deleteExcludeTrafficIPModelSelector = "#deleteExcludeTrafficIPModal";

			var storeTable = null;

			var breakpointDefinition = {
				tablet: 1024,
				phone: 480
			};

			self.deleteExcludeTrafficIPModal = function(storeId, storeName) {

				$("#deleteExcludeTrafficIPText").html("Do you want to delete Excluded IP <b>" + storeName + "</b> ?");

				$("#ExcludeTrafficIPId.delete").val(storeId);

				$(deleteExcludeTrafficIPModelSelector).modal('show');

			}



			self.BindEvents = function() {

				$("#btnDeleteExcludeTrafficIP").off().click(function() {

					var checked = $(".selectrowcheckbox:checked");
					if (checked.length == 0) {
						showErrorMessgae("Select some stores to delete.");
					} else {

						$("#deleteExcludeTrafficIPText").html("Do you want to delete selected Ips ?");

						var ids = checked.map(function() {
							return $(this).data('id');
						}).get().toString();

						$("#ExcludeTrafficIPId.delete").val(ids);

						$(deleteExcludeTrafficIPModelSelector).modal('show');
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

			self.BindExcludeTrafficIPTable = function() {
				storeTable = $('#store_table').DataTable({
					"deferRender": true,
					"sAjaxSource": "{{ route('admin.excludetrafficip.index') }}",
					"aoColumns": [{

							"sClass": "text-center",
							"render": function(data, type, row) {
								return '<input type="checkbox" class="selectrowcheckbox" data-id="' + row.ExcludeTrafficIPId + '" class=""/>';
							},
						},
						{
							"mData": "Title",
							"sClass": "text-center"
						},
						{
							"mData": "IP",
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
						},
						{

							"sWidth": "10%",
							"render": function(data, type, row, val) {

								var actions = '<div class="" style="cursor:pointer">';
								var editAction = "{{ route('admin.excludetrafficip.edit', 'id') }}";
								editAction = editAction.replace('id', row.ExcludeTrafficIPId);

								actions += '<a class="green"  href="' + editAction + '"  ><i class="fa fa-pencil datatable-Icon"></i></a>  <a class="red" onClick="ExcludeTrafficIPModule.deleteExcludeTrafficIPModal(' + "\'" + row.ExcludeTrafficIPId + "\'" + "," + "\'" + row.Title + '--' + row.IP + "\'" + ')"  ><i class="fa fa-trash-o datatable-Icon"></i></a></div>'

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
							responsiveHelper_store_table = new ResponsiveDatatablesHelper($('#store_table'), breakpointDefinition);
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
			}

			return self;
		}()

	);

	jQuery(function($) {
		ExcludeTrafficIPModule.BindExcludeTrafficIPTable();
		ExcludeTrafficIPModule.BindEvents();
	});
</script>

@endsection