@extends('Admin.Layout.master')
@section('pagebreadcrumb')
<ol class="breadcrumb">
	<li>Special Page</li>
	<li>List</li>

</ol>
@endsection
@section('content')
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		@can('SpecialPage Create')
		<a class="btn btn-success" href="{{ route('admin.specialpage.create') }}"> Create New Special Page</a>
		@endcan
		@can('SpecialPage Delete')
		<a class="btn btn-danger" id="btnDeleteSpecialPage"> Delete Special Page</a>
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
					<h2>Special Page List</h2>

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

						<table id="specialpage_table" class="table table-striped table-bordered table-hover" width="100%">
							<thead>
								<tr>
									<th><input type="checkbox" id="selectall" onclick="SpecialPageModule.SelectAllList(this)" /> </th>
									<th>Name</th>
									<th>Title</th>
									<th>Category</th>
									<th>Logo</th>
									<th>Url</th>
									<th>Current Event Page</th>
									<th>Enabled</th>
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
									<th></th>
									<th class="searchable"></th>
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
	@can('SpecialPage Delete')
	<div id="deleteSpecialPageModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Delete SpecialPage</h4>
				</div>
				<div class="modal-body">
					<div id="deleteSpecialPageText"></div>
				</div>

				<form class="form-horizontal" id="deleteSpecialPageForm" method="post" action="{{ route('admin.specialpage.delete') }}">
					{{ csrf_field() }}
					<input type="hidden" id="SpecialPageId" name="SpecialPageId" class="delete" />
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
	var SpecialPageModule = (function() {

			var responsiveHelper_specialpage_table = undefined;
			var self = {};
			var editSpecialPageModelSelector = "#editSpecialPageModal";
			var editSpecialPagePasswordModelSelector = "#editSpecialPagePasswordModal";
			var createSpecialPageModelSelector = "#createSpecialPageModal";
			var deleteSpecialPageModelSelector = "#deleteSpecialPageModal";

			var specialpageTable = null;

			var breakpointDefinition = {
				tablet: 1024,
				phone: 480
			};

			self.deleteSpecialPageModal = function(specialpageId, specialpageName) {

				$("#deleteSpecialPageText").html("Do you want to delete SpecialPage <b>" + specialpageName + "</b> ?");

				$("#SpecialPageId.delete").val(specialpageId);

				$(deleteSpecialPageModelSelector).modal('show');

			}



			self.BindEvents = function() {

				$("#btnDeleteSpecialPage").off().click(function() {

					var checked = $(".selectrowcheckbox:checked");
					if (checked.length == 0) {
						showErrorMessgae("Select some specialpages to delete.");
					} else {

						$("#deleteSpecialPageText").html("Do you want to delete selected specialpages ?");

						var ids = checked.map(function() {
							return $(this).data('id');
						}).get().toString();

						$("#SpecialPageId.delete").val(ids);

						$(deleteSpecialPageModelSelector).modal('show');
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




			self.BindSpecialPageTable = function() {
				specialpageTable = $('#specialpage_table').DataTable({
					"deferRender": true,
					"sAjaxSource": "{{ route('admin.specialpage.index') }}",
					"aoColumns": [{

							"sClass": "text-center",
							"render": function(data, type, row) {
								return '<input type="checkbox" class="selectrowcheckbox" data-id="' + row.SpecialPageId + '" class=""/>';
							},
						},
						{
							"mData": "Name",
							"sClass": "text-center"
						},
						{
							"mData": "Title",
							"sClass": "text-center"
						},

						{
							"mData": "CategoryName",
							"sClass": "text-center"
						},


						{

							"render": function(data, type, row, val) {
								var imagePath = "{{ url('/path_to_image') }}" + "content/img/avatars/male.png";

								if (row.LogoUrl) {
									imagePath = "{{ url('/storage/specialpagelogo') }}/" + row.LogoUrl;
									return '<img style="width: 100px;" src="' + imagePath + '">';
								}

								return '';
							},
							"sClass": "text-center"
						},
						{
							"mData": "URL",
							"sClass": "text-center"
						},

						{

							"render": function(data, type, row, val) {
								if (row.IsCurrentEventPage == 1) {
									return "Yes";
								}

								return "No";
							},
							"sClass": "text-center"
						},
						{

							"render": function(data, type, row, val) {
								if (row.IsActive == 1) {
									return "Yes";
								}

								return "No";
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
						},
						{

							"sWidth": "10%",
							"render": function(data, type, row, val) {

								var actions = '<div class="" style="cursor:pointer">';
								var editAction = "{{ route('admin.specialpage.edit', 'id') }}";
								editAction = editAction.replace('id', row.SpecialPageId);
								var dataTitle = row.Name;
								actions += '<a class="green"  href="' + editAction + '"  ><i class="fa fa-pencil datatable-Icon"></i></a>  <a class="red" onClick="SpecialPageModule.deleteSpecialPageModal(' + "\'" + row.SpecialPageId + "\'" + "," + "\'" + dataTitle + "\'" + ')"  ><i class="fa fa-trash-o datatable-Icon"></i></a></div>'

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
						if (!responsiveHelper_specialpage_table) {
							responsiveHelper_specialpage_table = new ResponsiveDatatablesHelper($('#specialpage_table'), breakpointDefinition);
						}
					},
					"rowCallback": function(nRow) {
						responsiveHelper_specialpage_table.createExpandIcon(nRow);
					},
					"drawCallback": function(oSettings) {
						responsiveHelper_specialpage_table.respond();
					}

				});


				// Apply the filter
				$("#specialpage_table thead th input[type=text]").on('keyup change', function() {

					otable
						.column($(this).parent().index() + ':visible')
						.search(this.value)
						.draw();

				});


				// Setup - add a text input to each footer cell
				$('#specialpage_table tfoot th.searchable').each(function() {
					var title = $(this).text();
					$(this).html('<input type="text" placeholder="Search ' + title + '" />');
				});



				// Apply the search
				specialpageTable.columns().every(function() {
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
		SpecialPageModule.BindSpecialPageTable();
		SpecialPageModule.BindEvents();
	});
</script>

@endsection