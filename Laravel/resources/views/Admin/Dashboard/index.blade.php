@extends('Admin.Layout.master')
@section('pagebreadcrumb')
<ol class="breadcrumb">
	<li>Dashboard</li>
</ol>
@endsection
@section('content')

<section id="widget-grid" class="">

	<div class="row">

		<div class="col-md-3">
			<label>Start Date:</label>
			<div class="input-group">
				<input type="text" id="StartDate" name="StartDate" value="{{ old('StartDate') }}" autocomplete="off" placeholder="Start Date" class="form-control datepicker" data-dateformat="dd/mm/yy">
				<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			</div>
		</div>
		<div class="col-md-3">
			<label>End Date:</label>
			<div class="input-group">
				<input type="text" id="EndDate" name="EndDate" value="{{ old('EndDate') }}" autocomplete="off" placeholder="End Date" class="form-control datepicker" data-dateformat="dd/mm/yy">
				<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			</div>
		</div>
	</div>
	<br />
	<div class="row">
		<div class="col-md-12">
			<div class="input-group pull-right">
				<button id="btnSearch" type="button" class="btn btn-primary">Search</button>
			</div>
		</div>
	</div>
	<div class="row">
		<article class="col-sm-12 col-md-6 col-lg-6">

			<!-- new widget -->
			<div class="jarviswidget" id="wid-id-2" data-widget-colorbutton="false" data-widget-editbutton="false">

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
					<span class="widget-icon"> <i class="fa fa-map-marker"></i> </span>
					<h2>Birds Eye</h2>
				</header>

				<!-- widget div-->
				<div>
					<!-- widget edit box -->
					<div class="jarviswidget-editbox">
						<div>
							<label>Title:</label>
							<input type="text" />
						</div>
					</div>
					<!-- end widget edit box -->

					<div class="widget-body no-padding">
						<!-- content goes here -->

						<div id="vector-map" class="vector-map"></div>
						<div id="heat-fill">
							<span class="fill-a">0</span>

							<span class="fill-b">5,000</span>
						</div>

						<table class="table table-striped table-hover table-condensed">
							<thead>
								<tr>
									<th>Country</th>
									<th>Visits</th>
									<th class="text-align-center">User Activity</th>
								</tr>
							</thead>
							<tbody id="tableBody">

							</tbody>
							<tfoot>

							</tfoot>
						</table>

						<!-- end content -->

					</div>

				</div>
				<!-- end widget div -->
			</div>
			<!-- end widget -->



		</article>







	</div>
</section>



@endsection
@section('pagescripts')

<script type="text/javascript">
	var DashboardModule = (function() {

			self.BindEvents = function() {

				$("#StartDate").datepicker("setDate", new Date());
				$("#EndDate").datepicker("setDate", new Date());
				$("#btnSearch").off().click(function() {

					var splitedStart = $("#StartDate").val().split('/');
					var splitedEnd = $("#EndDate").val().split('/');
					var startDate = splitedStart[2] + "-" + splitedStart[1] + "-" + splitedStart[0];
					var endDate = splitedEnd[2] + "-" + splitedEnd[1] + "-" + splitedEnd[0];
					var queryString = "StartDate=" + startDate + "&EndDate=" + endDate;

					self.LoadVisitorMap(queryString);
				});

				$("#btnSearch").trigger("click");

			}
			self.LoadVisitorMap = function(queryString) {

				CallAjaxService("GET", false, "{{ route('admin.dashboard.loadVisitorsMap') }}" + "?" + queryString, "JSON", null, function(data) {

					var data_array = new Object();

					if (data && data.length > 0) {
						for (i = 0; i < data.length; i++) {
							data_array[data[i]["CountryCode"]] = data[i]["Visitors"];
						}
					}
					$('#vector-map').html("");
					$('#vector-map').vectorMap({
						map: 'world_mill_en',
						backgroundColor: '#fff',
						regionStyle: {
							initial: {
								fill: '#c4c4c4'
							},
							hover: {
								"fill-opacity": 1
							}
						},
						series: {
							regions: [{
								values: data_array,
								scale: ['#85a8b6', '#4d7686'],
								normalizeFunction: 'polynomial'
							}]
						},
						onRegionLabelShow: function(e, el, code) {
							if (typeof data_array[code] == 'undefined') {
								e.preventDefault();
							} else {
								var countrylbl = data_array[code];
								el.html(el.html() + ': ' + countrylbl + ' visits');
							}
						}
					});
				});



				CallAjaxService("GET", false, "{{ route('admin.dashboard.loadVisitorsTable') }}" + "?" + queryString, "HTML", null, function(data) {
					$("#tableBody").html(data);
					runAllCharts();
				});

			}




			return self;
		}()

	);

	jQuery(function($) {
		DashboardModule.BindEvents();
		//DashboardModule.LoadVisitorMap();
	});
</script>

@endsection