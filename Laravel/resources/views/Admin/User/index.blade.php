@extends('Admin.Layout.master')
@section('pagebreadcrumb')
<ol class="breadcrumb">
	<li>User</li>
	<li>List</li>
</ol>
@endsection
@section('content')
<div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		@can('User Create')
		<a class="btn btn-success" href="{{ route('admin.user.create') }}"> Create New User</a>
		@endcan
		@can('User Delete')
		<a class="btn btn-danger" id="btnDeleteUser"> Delete User</a>
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
					<h2>User List</h2>

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

						<table id="user_table" class="table table-striped table-bordered table-hover" width="100%">
							<thead>
								<tr>
									<th><input type="checkbox" id="selectall" onclick="UserModule.SelectAllList(this)" /> </th>
									<th>User Name</th>
									<th>Email</th>
									<!-- <th>Enabled</th> -->
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
	@can('User Delete')
	<div id="deleteUserModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Delete User</h4>
				</div>
				<div class="modal-body">
					<div id="deleteUserText"></div>
				</div>

				<form class="form-horizontal" id="deleteUserForm" method="post" action="{{ route('admin.user.delete') }}">
					{{ csrf_field() }}
					<input type="hidden" id="UserId" name="UserId" class="delete" />
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
	var UserModule = (function() {

			var responsiveHelper_user_table = undefined;
			var self = {};
			var editUserModelSelector = "#editUserModal";
			var editUserPasswordModelSelector = "#editUserPasswordModal";
			var createUserModelSelector = "#createUserModal";
			var deleteUserModelSelector = "#deleteUserModal";
			var updateUserPasswordModalSelector = "#updateUserPasswordModal";


			var userTable = null;

			var breakpointDefinition = {
				tablet: 1024,
				phone: 480
			};

			self.deleteUserModal = function(userId, userName) {

				$("#deleteUserText").html("Do you want to delete User <b>" + userName + "</b> ?");

				$("#UserId.delete").val(userId);

				$(deleteUserModelSelector).modal('show');
			}

			self.updateUserPasswordModal = function(userId, userName, email) {

				$("#UserId.updatepassword").val(userId);
				$("#name.updatepassword").val(userName);
				$("#email.updatepassword").val(email);
				$("#password.updatepassword").val("");
				$("#confirm-password.updatepassword").val("");

				$(updateUserPasswordModalSelector).modal('show');


			}



			self.BindEvents = function() {

				$("#btnDeleteUser").off().click(function() {

					var checked = $(".selectrowcheckbox:checked");
					if (checked.length == 0) {
						showErrorMessgae("Select some users to delete.");
					} else {

						$("#deleteUserText").html("Do you want to delete selected users ?");

						var ids = checked.map(function() {
							return $(this).data('id');
						}).get().toString();

						$("#UserId.delete").val(ids);

						$(deleteUserModelSelector).modal('show');
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

			self.BindUserTable = function() {
				userTable = $('#user_table').DataTable({
					"deferRender": true,
					"sAjaxSource": "{{ route('admin.user.index') }}",
					"aoColumns": [{

							"sClass": "text-center",
							"render": function(data, type, row) {
								if (row.id == 1) return "";
								return '<input type="checkbox" class="selectrowcheckbox" data-id="' + row.id + '" class=""/>';
							},
						},
						{
							"mData": "name",
							"sClass": "text-center"
						},
						{
							"mData": "email",
							"sClass": "text-center"
						},

						{

							"sWidth": "10%",
							"render": function(data, type, row, val) {



								if (row.id == 1)
									return "";
								var actions = '<div class="" style="cursor:pointer">';
								var editAction = "{{ route('admin.user.edit', 'id') }}";
								editAction = editAction.replace('id', row.id);

								var updatePassword = "{{ route('admin.user.resetpassword', 'id') }}";
								updatePassword = updatePassword.replace('id', row.id);

								var dataTitle = row.name;
								var passwordUpdate = "";
								@can('User Edit')
								passwordUpdate = '<a class="green" href="' + updatePassword + '" ><i class="fa fa-key datatable-Icon"></i></a>';
								@endcan
								actions += passwordUpdate + '<a class="green"  href="' + editAction + '"  ><i class="fa fa-pencil datatable-Icon"></i></a>  <a class="red" onClick="UserModule.deleteUserModal(' + "\'" + row.id + "\'" + "," + "\'" + dataTitle + "\'" + ')"  ><i class="fa fa-trash-o datatable-Icon"></i></a></div>'

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
						if (!responsiveHelper_user_table) {
							responsiveHelper_user_table = new ResponsiveDatatablesHelper($('#user_table'), breakpointDefinition);
						}
					},
					"rowCallback": function(nRow) {
						responsiveHelper_user_table.createExpandIcon(nRow);
					},
					"drawCallback": function(oSettings) {
						responsiveHelper_user_table.respond();
					}

				});

				// custom toolbar


				// Apply the filter
				$("#user_table thead th input[type=text]").on('keyup change', function() {

					otable
						.column($(this).parent().index() + ':visible')
						.search(this.value)
						.draw();

				});


				// Setup - add a text input to each footer cell
				$('#user_table tfoot th.searchable').each(function() {
					var title = $(this).text();
					$(this).html('<input type="text" placeholder="Search ' + title + '" />');
				});



				// Apply the search
				userTable.columns().every(function() {
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
		UserModule.BindUserTable();
		UserModule.BindEvents();
	});
</script>

@endsection