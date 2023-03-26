<!DOCTYPE html>
<html lang="en-us">

<head>
	<meta charset="utf-8">
	<!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

	<title> Saveecoupons </title>
	<meta name="description" content="">
	<meta name="author" content="">

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

	<!-- Basic Styles -->
	<link rel="stylesheet" type="text/css" media="screen" href="{{ URL::asset('css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" media="screen" href="{{ URL::asset('css/font-awesome.min.css') }}">

	<!-- SmartAdmin Styles : Caution! DO NOT change the order -->
	<link rel="stylesheet" type="text/css" media="screen" href="{{ URL::asset('css/smartadmin-production-plugins.min.css') }}">
	<link rel="stylesheet" type="text/css" media="screen" href="{{ URL::asset('css/smartadmin-production.min.css') }}">
	<link rel="stylesheet" type="text/css" media="screen" href="{{ URL::asset('css/smartadmin-skins.min.css') }}">

	<!-- SmartAdmin RTL Support  -->
	<link rel="stylesheet" type="text/css" media="screen" href="{{ URL::asset('css/smartadmin-rtl.min.css') }}">

	<!-- We recommend you use "your_style.css" to override SmartAdmin
		     specific styles this will also ensure you retrain your customization with each SmartAdmin update.
		<link rel="stylesheet" type="text/css" media="screen" href="{{ URL::asset('css/your_style.css') }}"> -->

	<!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
	<link rel="stylesheet" type="text/css" media="screen" href="{{ URL::asset('css/demo.min.css') }}">

	<!-- FAVICONS -->
	<link rel="shortcut icon" href="{{ URL::asset('img/favicon/favicon.ico') }}" type=" image/x-icon">
	<link rel="icon" href="{{ URL::asset('img/favicon/favicon.ico') }}" type="image/x-icon">

	<!-- GOOGLE FONT -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

	<!-- Specifying a Webpage Icon for Web Clip 
			 Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
	<link rel="apple-touch-icon" href="{{ URL::asset('img/splash/sptouch-icon-iphone.png') }}">
	<link rel="apple-touch-icon" sizes="76x76" href="{{ URL::asset('img/splash/touch-icon-ipad.png') }}">
	<link rel="apple-touch-icon" sizes="120x120" href="{{ URL::asset('img/splash/touch-icon-iphone-retina.png') }}">
	<link rel="apple-touch-icon" sizes="152x152" href="{{ URL::asset('img/splash/touch-icon-ipad-retina.png') }}">

	<!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">

	<!-- Startup image for web apps -->
	<link rel="apple-touch-startup-image" href="{{ URL::asset('img/splash/ipad-landscape.png') }}" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
	<link rel="apple-touch-startup-image" href="{{ URL::asset('img/splash/ipad-portrait.png') }}" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
	<link rel="apple-touch-startup-image" href="{{ URL::asset('img/splash/iphone.png') }}" media="screen and (max-device-width: 320px)">
	@yield('pagestyles')
</head>

<!--

	TABLE OF CONTENTS.
	
	Use search to find needed section.
	
	===================================================================
	
	|  01. #CSS Links                |  all CSS links and file paths  |
	|  02. #FAVICONS                 |  Favicon links and file paths  |
	|  03. #GOOGLE FONT              |  Google font link              |
	|  04. #APP SCREEN / ICONS       |  app icons, screen backdrops   |
	|  05. #BODY                     |  body tag                      |
	|  06. #HEADER                   |  header tag                    |
	|  07. #PROJECTS                 |  project lists                 |
	|  08. #TOGGLE LAYOUT BUTTONS    |  layout buttons and actions    |
	|  09. #MOBILE                   |  mobile view dropdown          |
	|  10. #SEARCH                   |  search field                  |
	|  11. #NAVIGATION               |  left panel & navigation       |
	|  12. #RIGHT PANEL              |  right panel userlist          |
	|  13. #MAIN PANEL               |  main panel                    |
	|  14. #MAIN CONTENT             |  content holder                |
	|  15. #PAGE FOOTER              |  page footer                   |
	|  16. #SHORTCUT AREA            |  dropdown shortcuts area       |
	|  17. #PLUGINS                  |  all scripts and plugins       |
	
	===================================================================
	
	-->

<!-- #BODY -->
<!-- Possible Classes

		* 'smart-style-{SKIN#}'
		* 'smart-rtl'         - Switch theme mode to RTL
		* 'menu-on-top'       - Switch to top navigation (no DOM change required)
		* 'no-menu'			  - Hides the menu completely
		* 'hidden-menu'       - Hides the main menu but still accessable by hovering over left edge
		* 'fixed-header'      - Fixes the header
		* 'fixed-navigation'  - Fixes the main menu
		* 'fixed-ribbon'      - Fixes breadcrumb
		* 'fixed-page-footer' - Fixes footer
		* 'container'         - boxed layout mode (non-responsive: will not work with fixed-navigation & fixed-ribbon)
	-->

<body class="">

	<!-- HEADER -->
	<header id="header">
		<div id="logo-group">

			<!-- PLACE YOUR LOGO HERE -->
			<span id="logo"> <img src="{{ URL::asset('img/logo.png') }}" alt="SaveeCoupons"> </span>
			<!-- END LOGO PLACEHOLDER -->

		</div>



		<!-- pulled right: nav area -->
		<div class="pull-right">

			<!-- collapse menu button -->
			<div id="hide-menu" class="btn-header pull-right">
				<span> <a href="javascript:void(0);" data-action="toggleMenu" title="Collapse Menu"><i class="fa fa-reorder"></i></a> </span>
			</div>
			<!-- end collapse menu -->

			<!-- #MOBILE -->
			<!-- Top menu profile link : this shows only when top menu is active -->
			<ul id="mobile-profile-img" class="header-dropdown-list hidden-xs padding-5">
				<li class="">
					<a href="#" class="dropdown-toggle no-margin userdropdown" data-toggle="dropdown">
						<img src="{{ URL::asset('img/avatars/male.png') }}" alt="" class="online" />
					</a>
					<ul class="dropdown-menu pull-right">
						<li>
							<a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0"><i class="fa fa-cog"></i> Setting</a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="profile.html" class="padding-10 padding-top-0 padding-bottom-0"> <i class="fa fa-user"></i> <u>P</u>rofile</a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0" data-action="toggleShortcut"><i class="fa fa-arrow-down"></i> <u>S</u>hortcut</a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0" data-action="launchFullscreen"><i class="fa fa-arrows-alt"></i> Full <u>S</u>creen</a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="{{ route('logout') }}" class="padding-10 padding-top-5 padding-bottom-5" data-action="userLogout"><i class="fa fa-sign-out fa-lg"></i> <strong><u>L</u>ogout</strong></a>
						</li>
					</ul>
				</li>
			</ul>

			<!-- logout button -->
			<div id="logout" class="btn-header transparent pull-right">
				<span> <a href="{{ route('logout') }}" title="Sign Out" data-action="userLogout" data-logout-msg="You can improve your security further after logging out by closing this opened browser"><i class="fa fa-sign-out"></i></a> </span>
			</div>
			<!-- end logout button -->

			<!-- search mobile button (this is hidden till mobile view port) -->
			<div id="search-mobile" class="btn-header transparent pull-right">
				<span> <a href="javascript:void(0)" title="Search"><i class="fa fa-search"></i></a> </span>
			</div>
			<!-- end search mobile button -->


			<!-- fullscreen button -->
			<div id="fullscreen" class="btn-header transparent pull-right">
				<span> <a href="javascript:void(0);" data-action="launchFullscreen" title="Full Screen"><i class="fa fa-arrows-alt"></i></a> </span>
			</div>
			<!-- end fullscreen button -->





		</div>
		<!-- end pulled right: nav area -->

	</header>
	<!-- END HEADER -->

	<!-- Left panel : Navigation area -->
	<!-- Note: This width of the aside area can be adjusted through LESS variables -->
	<aside id="left-panel">

		<!-- User info -->
		<div class="login-info">
			<span>
				<!-- User image size is adjusted inside CSS, it should stay as it -->

				<a href="javascript:void(0);" id="show-shortcut">
					<img src="{{ URL::asset('img/avatars/male.png') }}" alt="" class="online" />
					<span>
						{{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email }}}
					</span>
					<!-- <i class="fa fa-angle-down"></i> -->
				</a>

			</span>
		</div>
		<!-- end user info -->

		<!-- NAVIGATION : This navigation is also responsive-->
		@include('Admin.Layout.sidebar')


		<span class="minifyme" data-action="minifyMenu">
			<i class="fa fa-arrow-circle-left hit"></i>
		</span>

	</aside>
	<!-- END NAVIGATION -->

	<!-- MAIN PANEL -->
	<div id="main" role="main">

		<!-- RIBBON -->
		<div id="ribbon">

			<span class="ribbon-button-alignment">
				<span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh" rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
					<i class="fa fa-refresh"></i>
				</span>
			</span>

			<!-- breadcrumb -->


			@yield('pagebreadcrumb')
			<!-- end breadcrumb -->

			<!-- You can also add more buttons to the
				ribbon for further usability

				Example below:

				<span class="ribbon-button-alignment pull-right">
				<span id="search" class="btn btn-ribbon hidden-xs" data-title="search"><i class="fa-grid"></i> Change Grid</span>
				<span id="add" class="btn btn-ribbon hidden-xs" data-title="add"><i class="fa-plus"></i> Add</span>
				<span id="search" class="btn btn-ribbon" data-title="search"><i class="fa-search"></i> <span class="hidden-mobile">Search</span></span>
				</span> -->

		</div>
		<!-- END RIBBON -->

		<!-- MAIN CONTENT -->
		<div id="content">

			@if(session()->has('success'))
			<div class="alert alert-success">
				{{ session()->get('success') }}
			</div>
			@endif

			@yield('content')


		</div>
		<!-- END MAIN CONTENT -->

	</div>
	<!-- END MAIN PANEL -->

	<!-- PAGE FOOTER -->
	<div class="page-footer">
		<div class="row">
			<div class="col-xs-12 col-sm-6">
				<span class="txt-color-white">SaveeCoupons <span class="hidden-xs"> </span> © 2019-2020</span>
			</div>
		</div>
	</div>
	<!-- END PAGE FOOTER -->

	<!-- SHORTCUT AREA : With large tiles (activated via clicking user name tag)
		Note: These tiles are completely responsive,
		you can add as many as you like
		-->
	<div id="shortcut">
		<ul>
			<li>
				<a href="inbox.html" class="jarvismetro-tile big-cubes bg-color-blue"> <span class="iconbox"> <i class="fa fa-envelope fa-4x"></i> <span>Mail <span class="label pull-right bg-color-darken">14</span></span> </span> </a>
			</li>
			<li>
				<a href="calendar.html" class="jarvismetro-tile big-cubes bg-color-orangeDark"> <span class="iconbox"> <i class="fa fa-calendar fa-4x"></i> <span>Calendar</span> </span> </a>
			</li>
			<li>
				<a href="gmap-xml.html" class="jarvismetro-tile big-cubes bg-color-purple"> <span class="iconbox"> <i class="fa fa-map-marker fa-4x"></i> <span>Maps</span> </span> </a>
			</li>
			<li>
				<a href="invoice.html" class="jarvismetro-tile big-cubes bg-color-blueDark"> <span class="iconbox"> <i class="fa fa-book fa-4x"></i> <span>Invoice <span class="label pull-right bg-color-darken">99</span></span> </span> </a>
			</li>
			<li>
				<a href="gallery.html" class="jarvismetro-tile big-cubes bg-color-greenLight"> <span class="iconbox"> <i class="fa fa-picture-o fa-4x"></i> <span>Gallery </span> </span> </a>
			</li>
			<li>
				<a href="profile.html" class="jarvismetro-tile big-cubes selected bg-color-pinkDark"> <span class="iconbox"> <i class="fa fa-user fa-4x"></i> <span>My Profile </span> </span> </a>
			</li>
		</ul>
	</div>
	<!-- END SHORTCUT AREA -->

	<!--================================================== -->
	<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
	<script data-pace-options='{ "restartOnRequestAfter": true }' src="{{ URL::asset('js/plugin/pace/pace.min.js') }}">
	</script>

	<!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

	<script>
		if (!window.jQuery) {

			var src = "{{ URL::asset('js/libs/jquery-2.1.1.min.js') }}";
			document.write('<script src="' + src + '"><//script>');
		}
	</script>

	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script>
		if (!window.jQuery.ui) {
			var src = "{{ URL::asset('js/libs/jquery-ui-1.10.3.min.js') }}";
			document.write('<script src="' + src + '"><//script>');

		}
	</script>

	<!-- IMPORTANT: APP CONFIG -->
	<script src="{{ URL::asset('js/app.config.js') }}"></script>

	<!-- JS TOUCH : include this plugin for mobile drag / drop touch events-->
	<script src="{{ URL::asset('js/plugin/jquery-touch/jquery.ui.touch-punch.min.js') }}"></script>

	<!-- BOOTSTRAP JS -->
	<script src="{{ URL::asset('js/bootstrap/bootstrap.min.js') }}"></script>

	<!-- CUSTOM NOTIFICATION -->
	<script src="{{ URL::asset('js/notification/SmartNotification.min.js') }}"></script>

	<!-- JARVIS WIDGETS -->
	<script src="{{ URL::asset('js/smartwidgets/jarvis.widget.min.js') }}"></script>

	<!-- EASY PIE CHARTS -->
	<script src="{{ URL::asset('js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js') }}"></script>

	<!-- SPARKLINES -->
	<script src="{{ URL::asset('js/plugin/sparkline/jquery.sparkline.min.js') }}"></script>

	<!-- JQUERY VALIDATE -->
	<script src="{{ URL::asset('js/plugin/jquery-validate/jquery.validate.min.js') }}"></script>

	<!-- JQUERY MASKED INPUT -->
	<script src="{{ URL::asset('js/plugin/masked-input/jquery.maskedinput.min.js') }}"></script>

	<!-- JQUERY SELECT2 INPUT -->
	<script src="{{ URL::asset('js/plugin/select2/select2.min.js') }}"></script>

	<!-- JQUERY UI + Bootstrap Slider -->
	<script src="{{ URL::asset('js/plugin/bootstrap-slider/bootstrap-slider.min.js') }}"></script>

	<!-- browser msie issue fix -->
	<script src="{{ URL::asset('js/plugin/msie-fix/jquery.mb.browser.min.js') }}"></script>

	<!-- FastClick: For mobile devices -->
	<script src="{{ URL::asset('js/plugin/fastclick/fastclick.min.js') }}"></script>

	<!--[if IE 8]>

		<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

		<![endif]-->

	<!-- Demo purpose only -->
	<script src="{{ URL::asset('js/demo.min.js') }}"></script>

	<!-- MAIN APP JS FILE -->
	<script src="{{ URL::asset('js/adminlayout.js') }}"></script>

	<!-- MAIN APP JS FILE -->
	<script src="{{ URL::asset('js/app.min.js') }}"></script>

	<!-- ENHANCEMENT PLUGINS : NOT A REQUIREMENT -->
	<!-- Voice command : plugin -->
	<script src="{{ URL::asset('js/speech/voicecommand.min.js') }}"></script>

	<!-- SmartChat UI : plugin -->
	<script src="{{ URL::asset('js/smart-chat-ui/smart.chat.ui.min.js') }}"></script>
	<script src="{{ URL::asset('js/smart-chat-ui/smart.chat.manager.min.js') }}"></script>

	<!-- PAGE RELATED PLUGIN(S) -->

	<!-- Flot Chart Plugin: Flot Engine, Flot Resizer, Flot Tooltip -->
	<script src="{{ URL::asset('js/plugin/flot/jquery.flot.cust.min.js') }}"></script>
	<script src="{{ URL::asset('js/plugin/flot/jquery.flot.resize.min.js') }}"></script>
	<script src="{{ URL::asset('js/plugin/flot/jquery.flot.time.min.js') }}"></script>
	<script src="{{ URL::asset('js/plugin/flot/jquery.flot.tooltip.min.js') }}"></script>

	<!-- Vector Maps Plugin: Vectormap engine, Vectormap language -->
	<script src="{{ URL::asset('js/plugin/vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
	<script src="{{ URL::asset('js/plugin/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>

	<!-- Full Calendar -->
	<script src="{{ URL::asset('js/plugin/moment/moment.min.js') }}"></script>
	<script src="{{ URL::asset('js/plugin/fullcalendar/jquery.fullcalendar.min.js') }}"></script>


	<script src="{{ URL::asset('js/plugin/datatables/jquery.dataTables.min.js') }}"></script>
	<script src="{{ URL::asset('js/plugin/datatables/dataTables.colVis.min.js') }}"></script>
	<script src="{{ URL::asset('js/plugin/datatables/dataTables.tableTools.min.js') }}"></script>
	<script src="{{ URL::asset('js/plugin/datatables/dataTables.bootstrap.min.js') }}"></script>
	<script src="{{ URL::asset('js/plugin/datatable-responsive/datatables.responsive.min.js') }}"></script>
	<script src="{{ URL::asset('js/plugin/bootstrapvalidator/bootstrapValidator.min.js') }}"></script>

	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>

	<script>
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': '{{ csrf_token() }}'
			}
		});

		$(document).ready(function() {

			// DO NOT REMOVE : GLOBAL FUNCTIONS!
			pageSetUp();
			setTimeout(function() {
				$(".alert.alert-success").alert('close');
			}, 2000);
		});
	</script>

	<!-- Your GOOGLE ANALYTICS CODE Below -->
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-XXXXXXXX-X']);
		_gaq.push(['_trackPageview']);
	</script>

	@yield('pagescripts')

</body>

</html>