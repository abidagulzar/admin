@extends('Admin.Layout.master')
@section('pagebreadcrumb')
<ol class="breadcrumb">
	<li>Subscribed</li>
	<li>Subscribed Users</li>
</ol>
@endsection
@section('content')
<div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<a class="btn btn-danger" id="btnDeleteSubscribedUser"> Delete Subscribed User</a>

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
					<h2>Subscribed User</h2>

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

						<table id="subscribedUser_table" class="table table-striped table-bordered table-hover" width="100%">
							<thead>
								<tr>
									<th><input type="checkbox" id="selectall" onclick="SubscribedUserModule.SelectAllList(this)" /> </th>
									<th>Email</th>
									<th>IP Address</th>
									<th>Location</th>
									<th>Subscribe Date</th>
									<th>Active</th>
									<th>Leave Reason</th>
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

	<div id="deleteSubscribedUserModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Delete Subscribed User</h4>
				</div>
				<div class="modal-body">
					<div id="deleteSubscribedUserText"></div>
				</div>

				<form class="form-horizontal" id="deleteSubscribedUserForm" method="post" action="{{ route('admin.subscribe.delete') }}">
					{{ csrf_field() }}
					<input type="hidden" id="SubscribedUserId" name="SubscribedUserId" class="delete" />
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
						<button type="submit" class="btn btn-danger">Yes</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div id="viewSubscribedUserModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">View Subscribed User</h4>
				</div>
				<div class="modal-body">

					<form id="subscribe-form" class="smart-form" novalidate="viewSubscribedUserForm">

						<fieldset>
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
	var SubscribedUserModule = (function() {

			var responsiveHelper_subscribedUser_table = undefined;
			var self = {};
			var editSubscribedUserModelSelector = "#editSubscribedUserModal";
			var editSubscribedUserPasswordModelSelector = "#editSubscribedUserPasswordModal";
			var createSubscribedUserModelSelector = "#createSubscribedUserModal";
			var deleteSubscribedUserModelSelector = "#deleteSubscribedUserModal";
			var viewSubscribedUserModalSelector = "#viewSubscribedUserModal";

			var subscribedUserTable = null;

			var breakpointDefinition = {
				tablet: 1024,
				phone: 480
			};

			self.deleteSubscribedUserModal = function(subscribedUserId, subscribedUserName) {

				$("#deleteSubscribedUserText").html("Do you want to delete Subscribed User <b>" + subscribedUserName + "</b> ?");

				$("#SubscribedUserId.delete").val(subscribedUserId);

				$(deleteSubscribedUserModelSelector).modal('show');
			}
			self.ViewSubscribedUserModal = function(Name, Email, Website, Message, MessageDate, IPAddress, Location) {

				$("#viewName").val("");
				$("#viewEmail").val("");
				$("#viewWebsite").val("");
				$("#viewMessageDate").val("");
				$("#viewIPAddress").val("");
				$("#viewLocation").val("");
				$("#viewMessage").html("");
				if (Name && Name != 'null')
					$("#viewName").val(Name);
				if (Email && Email != 'null')
					$("#viewEmail").val(Email);
				if (Website && Website != 'null')
					$("#viewWebsite").val(Website);
				if (MessageDate && MessageDate != 'null')
					$("#viewMessageDate").val(MessageDate);
				if (IPAddress && IPAddress != 'null')
					$("#viewIPAddress").val(IPAddress);
				if (Location && Location != 'null')
					$("#viewLocation").val(Location);
				if (Message && Message != 'null')
					$("#viewMessage").html(Message);

				$(viewSubscribedUserModalSelector).modal('show');
			}


			self.BindEvents = function() {

				$("#btnDeleteSubscribedUser").off().click(function() {

					var checked = $(".selectrowcheckbox:checked");
					if (checked.length == 0) {
						showErrorMessgae("Select some categories to delete.");
					} else {

						$("#deleteSubscribedUserText").html("Do you want to delete selected Subscribed Users ?");

						var ids = checked.map(function() {
							return $(this).data('id');
						}).get().toString();

						$("#SubscribedUserId.delete").val(ids);

						$(deleteSubscribedUserModelSelector).modal('show');
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

			self.BindSubscribedUserTable = function() {
				subscribedUserTable = $('#subscribedUser_table').DataTable({
					"deferRender": true,
					"sAjaxSource": "{{ route('admin.subscribe.index') }}",
					"aoColumns": [{

							"bSortable": false,
							"sClass": "text-center",
							"render": function(data, type, row) {
								return '<input type="checkbox" class="selectrowcheckbox" data-id="' + row.SubscribedUserId + '" class=""/>';
							},
						},

						{
							"mData": "Email",
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

							"render": function(data, type, row, val) {

								if (row.IsActive == 1) {
									return "Yes";
								}

								return "No";

							},
							"sClass": "text-center"
						},
						{
							"mData": "Reason",
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

								var dataTitle = row.Email;
								actions += '<a class="red" onClick="SubscribedUserModule.deleteSubscribedUserModal(' + "\'" + row.SubscribedUserId + "\'" + "," + "\'" + dataTitle + "\'" + ')"  ><i class="fa fa-trash-o datatable-Icon"></i></a></div>'

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
						if (!responsiveHelper_subscribedUser_table) {
							responsiveHelper_subscribedUser_table = new ResponsiveDatatablesHelper($('#subscribedUser_table'), breakpointDefinition);
						}
					},
					"rowCallback": function(nRow) {
						responsiveHelper_subscribedUser_table.createExpandIcon(nRow);
					},
					"drawCallback": function(oSettings) {
						responsiveHelper_subscribedUser_table.respond();
					}

				});

				// custom toolbar


				// Apply the filter
				$("#subscribedUser_table thead th input[type=text]").on('keyup change', function() {

					otable
						.column($(this).parent().index() + ':visible')
						.search(this.value)
						.draw();

				});

				// Setup - add a text input to each footer cell
				$('#subscribedUser_table tfoot th.searchable').each(function() {
					var title = $(this).text();
					$(this).html('<input type="text" placeholder="Search ' + title + '" />');
				});



				// Apply the search
				subscribedUserTable.columns().every(function() {
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



		SubscribedUserModule.BindSubscribedUserTable();
		SubscribedUserModule.BindEvents();
	});

	// @if($message = Session::get('success'))

	// alert("{{ $message }}")

	// @endif
</script>

@endsection