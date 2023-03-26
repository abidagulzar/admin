@extends('Admin.Layout.master')
@section('pagebreadcrumb')
<ol class="breadcrumb">
	<li>Subscribed</li>
	<li>User Messages</li>
</ol>
@endsection
@section('content')
<div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<a class="btn btn-danger" id="btnDeleteUserMessage"> Delete User Message</a>

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

				<header>
					<span class="widget-icon"> <i class="fa fa-table"></i> </span>
					<h2>User Message</h2>

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

						<table id="userMessage_table" class="table table-striped table-bordered table-hover" width="100%">
							<thead>
								<tr>
									<th><input type="checkbox" id="selectall" onclick="UserMessageModule.SelectAllList(this)" /> </th>
									<th>Name</th>
									<th>Email</th>
									<th>Website</th>
									<th>IP Address</th>
									<th>Location</th>
									<th>Message Date</th>
									<th width="100px">Action</th>
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

	<div id="deleteUserMessageModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Delete User Message</h4>
				</div>
				<div class="modal-body">
					<div id="deleteUserMessageText"></div>
				</div>

				<form class="form-horizontal" id="deleteUserMessageForm" method="post" action="{{ route('admin.usermessage.delete') }}">
					{{ csrf_field() }}
					<input type="hidden" id="UserMessageId" name="UserMessageId" class="delete" />
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
						<button type="submit" class="btn btn-danger">Yes</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div id="viewUserMessageModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">View User Message</h4>
				</div>
				<div class="modal-body">

					<form id="usermessage-form" class="smart-form" novalidate="viewUserMessageForm">

						<fieldset>
							<section>
								<div class="row">
									<label class="label col col-2">Message</label>
									<div class="col col-10">
										<label class="input">
											<textarea readonly type="text" id="viewMessage" rows="10" cols="65"></textarea>
										</label>
									</div>
								</div>
							</section>
							<section>
								<div class="row">
									<label class="label col col-2">Name</label>
									<div class="col col-10">
										<label class="input">
											<input type="text" id="viewName" readonly>
										</label>
									</div>
								</div>
							</section>
							<section>
								<div class="row">
									<label class="label col col-2">Email</label>
									<div class="col col-10">
										<label class="input">
											<input type="text" id="viewEmail" readonly>
										</label>
									</div>
								</div>
							</section>
							<section>
								<div class="row">
									<label class="label col col-2">Website</label>
									<div class="col col-10">
										<label class="input">
											<input type="text" id="viewWebsite" readonly>
										</label>
									</div>
								</div>
							</section>
							<section>
								<div class="row">
									<label class="label col col-2">Message Date</label>
									<div class="col col-10">
										<label class="input">
											<input type="text" id="viewMessageDate" readonly>
										</label>
									</div>
								</div>
							</section>
							<section>
								<div class="row">
									<label class="label col col-2">IP Address</label>
									<div class="col col-10">
										<label class="input">
											<input type="text" id="viewIPAddress" readonly>
										</label>
									</div>
								</div>
							</section>
							<section>
								<div class="row">
									<label class="label col col-2">Location</label>
									<div class="col col-10">
										<label class="input">
											<input type="text" id="viewLocation" readonly>
										</label>
									</div>
								</div>
							</section>





						</fieldset>

						<footer>
							<button type="button" class="btn btn-default" data-dismiss="modal">
								Close
							</button>

						</footer>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- end row -->

	<!-- end row -->

</section>

@endsection
@section('pagescripts')
<script type="text/javascript">
	var UserMessageModule = (function() {

			var responsiveHelper_userMessage_table = undefined;
			var self = {};
			var editUserMessageModelSelector = "#editUserMessageModal";
			var editUserMessagePasswordModelSelector = "#editUserMessagePasswordModal";
			var createUserMessageModelSelector = "#createUserMessageModal";
			var deleteUserMessageModelSelector = "#deleteUserMessageModal";
			var viewUserMessageModalSelector = "#viewUserMessageModal";

			var userMessageTable = null;

			var breakpointDefinition = {
				tablet: 1024,
				phone: 480
			};

			self.deleteUserMessageModal = function(userMessageId, userMessageName) {

				$("#deleteUserMessageText").html("Do you want to delete User Message <b>" + userMessageName + "</b> ?");

				$("#UserMessageId.delete").val(userMessageId);

				$(deleteUserMessageModelSelector).modal('show');
			}
			self.ViewUserMessageModal = function(UserMessageId) {

				$("#viewName").val("");
				$("#viewEmail").val("");
				$("#viewWebsite").val("");
				$("#viewMessageDate").val("");
				$("#viewIPAddress").val("");
				$("#viewLocation").val("");
				$("#viewMessage").html("");


				var url = "{{ route('admin.usermessage.getbyid',':id') }}";
				url = url.replace(':id', UserMessageId);

				CallAjaxService('GET', null, url, 'json', '', function(data) {
					if (data.Name && data.Name != 'null')
						$("#viewName").val(data.Name);
					if (data.Email && data.Email != 'null')
						$("#viewEmail").val(data.Email);
					if (data.Website && data.Website != 'null')
						$("#viewWebsite").val(data.Website);
					if (data.MessageDate && data.MessageDate != 'null')
						$("#viewMessageDate").val(data.MessageDate);
					if (data.IPAddress && data.IPAddress != 'null')
						$("#viewIPAddress").val(data.IPAddress);
					if (data.Location && data.Location != 'null')
						$("#viewLocation").val(data.Location);
					if (data.Message && data.Message != 'null')
						$("#viewMessage").html(data.Message);
					$(viewUserMessageModalSelector).modal('show');
				});

			}


			self.BindEvents = function() {

				$("#btnDeleteUserMessage").off().click(function() {

					var checked = $(".selectrowcheckbox:checked");
					if (checked.length == 0) {
						showErrorMessgae("Select some categories to delete.");
					} else {

						$("#deleteUserMessageText").html("Do you want to delete selected User Messages ?");

						var ids = checked.map(function() {
							return $(this).data('id');
						}).get().toString();

						$("#UserMessageId.delete").val(ids);

						$(deleteUserMessageModelSelector).modal('show');
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

			self.BindUserMessageTable = function() {
				userMessageTable = $('#userMessage_table').DataTable({
					"deferRender": true,
					"sAjaxSource": "{{ route('admin.usermessage.index') }}",
					"aoColumns": [{

							"bSortable": false,
							"sClass": "text-center",
							"render": function(data, type, row) {
								return '<input type="checkbox" class="selectrowcheckbox" data-id="' + row.UserMessageId + '" class=""/>';
							},
						},
						{
							"mData": "Name",
							"sClass": "text-center"
						},
						{
							"mData": "Email",
							"sClass": "text-center"
						},
						{
							"mData": "Website",
							"sClass": "text-center"
						},
						{
							"mData": "IPAddress",
							"sClass": "text-center"
						},
						{
							"mData": "Location",
							"sClass": "text-center"
						},
						{
							"mData": "CreateDate",

							"render": function(data, type, row, val) {

								if (row.CreateDate) {
									var splited1 = row.CreateDate.split(' ');
									var splited = splited1[0].split('-');

									return splited[2] + "/" + splited[1] + "/" + splited[0] + ' ' + splited1[1]
								}

								return "";

							},
							"sClass": "text-center"
						},


						{

							"sWidth": "10%",
							"render": function(data, type, row, val) {

								var actions = '<div class="" style="cursor:pointer">';
								var messageDate = "";

								if (row.CreateDate) {
									var splited1 = row.CreateDate.split(' ');
									var splited = splited1[0].split('-');

									messageDate = splited[2] + "/" + splited[1] + "/" + splited[0] + ' ' + splited1[1]
								}

								var dataTitle = row.Name;
								actions += '<a class="green"  onClick="UserMessageModule.ViewUserMessageModal(' + "\'" + row.UserMessageId + "\'" + ')" ><i class="fa fa-eye datatable-Icon"></i></a>  <a class="red" onClick="UserMessageModule.deleteUserMessageModal(' + "\'" + row.UserMessageId + "\'" + "," + "\'" + dataTitle + "\'" + ')"  ><i class="fa fa-trash-o datatable-Icon"></i></a></div>'

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
						if (!responsiveHelper_userMessage_table) {
							responsiveHelper_userMessage_table = new ResponsiveDatatablesHelper($('#userMessage_table'), breakpointDefinition);
						}
					},
					"rowCallback": function(nRow) {
						responsiveHelper_userMessage_table.createExpandIcon(nRow);
					},
					"drawCallback": function(oSettings) {
						responsiveHelper_userMessage_table.respond();
					}

				});

				// custom toolbar


				// Apply the filter
				$("#userMessage_table thead th input[type=text]").on('keyup change', function() {

					otable
						.column($(this).parent().index() + ':visible')
						.search(this.value)
						.draw();

				});

				// Setup - add a text input to each footer cell
				$('#userMessage_table tfoot th.searchable').each(function() {
					var title = $(this).text();
					$(this).html('<input type="text" placeholder="Search ' + title + '" />');
				});



				// Apply the search
				userMessageTable.columns().every(function() {
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



		UserMessageModule.BindUserMessageTable();
		UserMessageModule.BindEvents();
	});

	// @if($message = Session::get('success'))

	// alert("{{ $message }}")

	// @endif
</script>

@endsection