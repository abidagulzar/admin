@extends('Admin.Layout.master')
@section('pagebreadcrumb')
<ol class="breadcrumb">
	<li>Store Stats</li>
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


		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

			<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

				<header>
					<span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
					<h2>Bar Chart</h2>

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

						<div id="bar-chart" class="chart"></div>

					</div>
					<!-- end widget content -->

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
	var $chrt_border_color = "#efefef";
	var $chrt_grid_color = "#DDD"
	var $chrt_main = "#E24913";
	/* red       */
	var $chrt_second = "#6595b4";
	/* blue      */
	var $chrt_third = "#FF9F01";
	/* orange    */
	var $chrt_fourth = "#7e9d3a";
	/* green     */
	var $chrt_fifth = "#BD362F";
	/* dark red  */
	var $chrt_mono = "#000";
	var StoreStatsModule = (function() {

			self.BindEvents = function() {

				$("#StartDate").datepicker("setDate", new Date());
				$("#EndDate").datepicker("setDate", new Date());
				$("#btnSearch").off().click(function() {

					var splitedStart = $("#StartDate").val().split('/');
					var splitedEnd = $("#EndDate").val().split('/');
					var startDate = splitedStart[2] + "-" + splitedStart[1] + "-" + splitedStart[0];
					var endDate = splitedEnd[2] + "-" + splitedEnd[1] + "-" + splitedEnd[0];
					var queryString = "StartDate=" + startDate + "&EndDate=" + endDate;

					//self.LoadVisitorMap(queryString);
				});

				$("#btnSearch").trigger("click");


				if ($("#bar-chart").length) {

					var data1 = [];
					for (var i = 0; i <= 12; i += 1)
						data1.push(["i" + i, parseInt(Math.random() * 30)]);

					var data2 = [];
					for (var i = 0; i <= 12; i += 1)
						data2.push([i, parseInt(Math.random() * 30)]);

					var data3 = [];
					for (var i = 0; i <= 12; i += 1)
						data3.push([i, parseInt(Math.random() * 30)]);

					var ds = new Array();

					ds.push({
						data: data1,
						bars: {
							show: true,
							barWidth: 0.2,
							order: 1,
						}
					});
					// ds.push({
					// 	data: data2,
					// 	bars: {
					// 		show: true,
					// 		barWidth: 0.2,
					// 		order: 2
					// 	}
					// });
					// ds.push({
					// 	data: data3,
					// 	bars: {
					// 		show: true,
					// 		barWidth: 0.2,
					// 		order: 3
					// 	}
					// });

					//Display graph
					$.plot($("#bar-chart"), ds, {
						colors: [$chrt_second, $chrt_fourth, "#666", "#BBB"],
						grid: {
							show: true,
							hoverable: true,
							clickable: true,
							tickColor: $chrt_border_color,
							borderWidth: 0,
							borderColor: $chrt_border_color,
						},
						legend: true,
						tooltip: true,
						tooltipOpts: {
							content: "<b>%x</b> = <span>%y</span>",
							defaultTheme: false
						}

					});

				}


			}
			// self.LoadVisitorMap = function(queryString) {

			// 	CallAjaxService("GET", false, "" + "?" + queryString, "JSON", null, function(data) {

			// 		var data_array = new Object();

			// 		if (data && data.length > 0) {
			// 			for (i = 0; i < data.length; i++) {
			// 				data_array[data[i]["CountryCode"]] = data[i]["Visitors"];
			// 			}
			// 		}
			// 		$('#vector-map').html("");
			// 		$('#vector-map').vectorMap({
			// 			map: 'world_mill_en',
			// 			backgroundColor: '#fff',
			// 			regionStyle: {
			// 				initial: {
			// 					fill: '#c4c4c4'
			// 				},
			// 				hover: {
			// 					"fill-opacity": 1
			// 				}
			// 			},
			// 			series: {
			// 				regions: [{
			// 					values: data_array,
			// 					scale: ['#85a8b6', '#4d7686'],
			// 					normalizeFunction: 'polynomial'
			// 				}]
			// 			},
			// 			onRegionLabelShow: function(e, el, code) {
			// 				if (typeof data_array[code] == 'undefined') {
			// 					e.preventDefault();
			// 				} else {
			// 					var countrylbl = data_array[code];
			// 					el.html(el.html() + ': ' + countrylbl + ' visits');
			// 				}
			// 			}
			// 		});
			// 	});



			// 	CallAjaxService("GET", false, "" + "?" + queryString, "HTML", null, function(data) {
			// 		$("#tableBody").html(data);
			// 		runAllCharts();
			// 	});

			// }




			return self;
		}()

	);

	jQuery(function($) {
		StoreStatsModule.BindEvents();
	});
</script>

@endsection