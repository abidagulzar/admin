<!DOCTYPE html>

@if(isset($lang))
<html lang="{{$lang}}">
@else
<html lang="en">
@endif

<head>
    <link async rel="stylesheet" href="{{ URL::asset('site/assets/css/bootstrap.min.css')}}">
    <link async rel="stylesheet" href="{{ mix('css/site.css') }}">
    <link async rel="stylesheet" href="{{ URL::asset('site/assets/css/font-awesome.css')}}">
    <style>
        .handle {
            height: 40px;
            color: #fff;
            text-decoration: none;
            text-indent: inherit !important;
            background-color: #d73a4d;
            border-radius: 3px 3px 0 0;
            background-position: 12px 20px !important;
            right: 169px;
            position: absolute;
            width: 170px;
            padding: 6px 10px 0 3px;
            transition: all .5s ease;
            transform: rotate(-90deg);
            top: 125px
        }

        .handle:hover {
            background-color: #d73a4d;
            color: #fff !important;
        }

        div.slide-out-div.open .handle {
            background-color: #013243
        }

        .handle .label {
            text-align: left;
            display: inline-block;
            color: #fff !important;
            cursor: pointer;
            font-size: 100%;
            padding: 0 !important;
        }

        .slide-out-div {
            padding: 10px 10px 10px 20px;
            width: 230px;
            background: #fff;
            border: 1px solid #d7d7d7;
            position: fixed;
            top: 85px;
            right: -231px;
            -webkit-transition: right .3s ease;
            -webkit-box-shadow: -9px 1px 27px -8px rgba(0, 0, 0, .24);
            -moz-box-shadow: -9px 1px 27px -8px rgba(0, 0, 0, .24);
            box-shadow: -9px 1px 27px -8px rgba(0, 0, 0, .24);
            border-radius: 10px;
            z-index: 111;
            transition: right .3s ease
        }

        .for-index .slide-out-div {
            z-index: 1
        }

        div.slide-out-div.open {
            right: -3px !important
        }

        .action-content {
            float: left;
            width: 100%;
            box-sizing: border-box;
            padding: 15px 0;
            position: relative
        }

        .action-content h2 {
            color: #6c798a;
            font-size: 18px;
            margin-bottom: 5px;
            font-weight: bold
        }


        .main-header {
            background: #4a3538 !important;
        }

        .sign {

            justify-content: center;
            align-items: center;
            width: 50%;
            height: 50%;
            background-image: radial-gradient(ellipse 50% 35% at 50% 50%,
                    #6b1839,
                    transparent);

            letter-spacing: 2;
            left: 50%;
            top: 50%;
            font-family: "Clip";
            text-transform: uppercase;
            font-size: 15.6px;
            color: #ffe6ff;
            text-shadow: 0 0 0.6rem #ffe6ff, 0 0 1.5rem #ff65bd,
                -0.2rem 0.1rem 1rem #ff65bd, 0.2rem 0.1rem 1rem #ff65bd,
                0 -0.5rem 2rem #ff2483, 0 0.5rem 3rem #ff2483;
            animation: shine 2s forwards, flicker 3s infinite;
        }

        @keyframes blink {

            0%,
            22%,
            36%,
            75% {
                color: #ffe6ff;
                text-shadow: 0 0 0.6rem #ffe6ff, 0 0 1.5rem #ff65bd,
                    -0.2rem 0.1rem 1rem #ff65bd, 0.2rem 0.1rem 1rem #ff65bd,
                    0 -0.5rem 2rem #ff2483, 0 0.5rem 3rem #ff2483;
            }

            28%,
            33% {
                color: #ff65bd;
                text-shadow: none;
            }

            82%,
            97% {
                color: #ff2483;
                text-shadow: none;
            }
        }

        .flicker {
            animation: shine 2s forwards, blink 3s 2s infinite;
        }

        .fast-flicker {
            animation: shine 2s forwards, blink 10s 1s infinite;
        }

        @keyframes shine {
            0% {
                color: #6b1839;
                text-shadow: none;
            }

            100% {
                color: #ffe6ff;
                text-shadow: 0 0 0.6rem #ffe6ff, 0 0 1.5rem #ff65bd,
                    -0.2rem 0.1rem 1rem #ff65bd, 0.2rem 0.1rem 1rem #ff65bd,
                    0 -0.5rem 2rem #ff2483, 0 0.5rem 3rem #ff2483;
            }
        }

        @keyframes flicker {
            from {
                opacity: 1;
            }

            4% {
                opacity: 0.9;
            }

            6% {
                opacity: 0.85;
            }

            8% {
                opacity: 0.95;
            }

            10% {
                opacity: 0.9;
            }

            11% {
                opacity: 0.922;
            }

            12% {
                opacity: 0.9;
            }

            14% {
                opacity: 0.95;
            }

            16% {
                opacity: 0.98;
            }

            17% {
                opacity: 0.9;
            }

            19% {
                opacity: 0.93;
            }

            20% {
                opacity: 0.99;
            }

            24% {
                opacity: 1;
            }

            26% {
                opacity: 0.94;
            }

            28% {
                opacity: 0.98;
            }

            37% {
                opacity: 0.93;
            }

            38% {
                opacity: 0.5;
            }

            39% {
                opacity: 0.96;
            }

            42% {
                opacity: 1;
            }

            44% {
                opacity: 0.97;
            }

            46% {
                opacity: 0.94;
            }

            56% {
                opacity: 0.9;
            }

            58% {
                opacity: 0.9;
            }

            60% {
                opacity: 0.99;
            }

            68% {
                opacity: 1;
            }

            70% {
                opacity: 0.9;
            }

            72% {
                opacity: 0.95;
            }

            93% {
                opacity: 0.93;
            }

            95% {
                opacity: 0.95;
            }

            97% {
                opacity: 0.93;
            }

            to {
                opacity: 1;
            }
        }
    </style>

    <script>
        function lazyLoadCSS(e) {
            fetch(e).then(function(e) {
                return e.text()
            }).then(function(e) {
                document.head.appendChild(document.createElement("style")).textContent = e, console.log("style loaded")
            }).catch(function(e) {
                console.error("style load failed with error", e)
            })
        }

        lazyLoadCSS('https://fonts.googleapis.com/css?family=Barlow:200,300,300i,400,400i,500,500i,600,700,800&display=swap');
        lazyLoadCSS('https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap');
        lazyLoadCSS('https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,600italic,700,700italic,800&display=swap');
        lazyLoadCSS('https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap');
    </script>

    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-109857527-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-109857527-1');
    </script>
    <!-- Meta -->
    <meta charset="utf-8">


    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="commission-factory-verification" content="a5461ff1bbac46a2bd184d44701c8bfb" />
    <meta name="verify-admitad" content="68f2cce45e" />
    <meta name="google-site-verification" content="hu2PHfo24R6-U1hWkz4y0aThJz2SKAbIEBDgJt-vkBs" />


    <meta name="robots" content="index, follow">


    @yield('metadata')




    <!-- FAVICONS -->
    <link rel="shortcut icon" href="{{ URL::asset('img/favicon/favicon.ico') }}" type=" image/x-icon">



    @yield('pagestyles')
</head>

<body class="cnt-home">
    <noscript>
        <div class="noscript alert-error"> For full functionality of this site it is necessary to enable JavaScript. Here are the <a href="http://www.enable-javascript.com/" target="_blank"> instructions how to enable JavaScript in your web browser</a>. </div>
    </noscript>
    <!-- ============================================== HEADER ============================================== -->
    <header class="header-style-1">

        <!-- ============================================== TOP MENU ============================================== -->
        <div class="top-bar animate-dropdown">
            <div class="container">
                <div class="header-top-inner">
                    @yield('headerdeal')
                    <!-- /.cnt-account -->

                    <!-- /.list-unstyled -->
                    <!-- /.cnt-cart -->
                    <div class="clearfix"></div>
                </div>
                <!-- /.header-top-inner -->
            </div>
            <!-- /.container -->
        </div>
        <!-- /.header-top -->
        <!-- ============================================== TOP MENU : END ============================================== -->
        <div class="main-header">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-lg-2 col-sm-12 col-md-3 logo-holder">
                        <!-- ============================================================= LOGO ============================================================= -->
                        <div class="logo"> <a href="{{ url('') }}"> <img src="{{ URL::asset('site/assets/images/logo.png')}}" alt="logo"> </a> </div>
                        <!-- /.logo -->
                        <!-- ============================================================= LOGO : END ============================================================= -->
                    </div>
                    <!-- /.logo-holder -->

                    <div class="col-lg-5 col-md-4 col-sm-5 col-xs-12 top-search-holder">
                        <!-- /.contact-row -->
                        <!-- ============================================================= SEARCH AREA ============================================================= -->
                        <div class="search-area">
                            <!-- <form>
                                <div class="control-group">
                                    <input class="search-field" placeholder="Search here..." />
                                    <a class="search-button" href="#"></a> </div>
                            </form> -->
                            <form onsubmit="onSearch(); return false;">
                                <div class="control-group">
                                    <input type="text" name="searchStoreInput" autocomplete="off" id="searchStoreInput" class="search-field" placeholder="Enter Keyword Here ..." onKeyUp="onSearch()" required>
                                    <button type="submit" class="search-button"> </button>
                                </div>
                                <div class=" input-group col-lg-12 col-md-12 col-sm-12 col-xs-12" style="z-index:10000;position:absolute;">
                                    <div id="suggesionDiv"> </div>
                                </div>
                            </form>

                            <!-- <form onsubmit="onSearch(); return false;">
                                <div class="input-group">
                                    <input type="text" name="searchStoreInput" autocomplete="off" id="searchStoreInput" class="form-control input-lg search-input" placeholder="Enter Keyword Here ..." onKeyUp="onSearch()" required>
                                    <div class="input-group-btn">
                                        <div class="input-group">
                                            <div class="input-group-btn">
                                                <button type="submit" class="btn btn-lg btn-search btn-block"> <i class="fa fa-search font-16"></i> </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class=" input-group col-lg-12 col-md-12 col-sm-12 col-xs-12" style="z-index:10000;position:absolute;">
                                    <div id="suggesionDiv"> </div>
                                </div>
                            </form> -->
                        </div>
                        <!-- /.search-area -->
                        <!-- ============================================================= SEARCH AREA : END ============================================================= -->
                    </div>
                    <!-- /.top-search-holder -->

                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 navmenu">
                        <div class="yamm navbar navbar-default" role="navigation">
                            <div class="navbar-header">
                                <button data-target="#mc-horizontal-menu-collapse" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                                    <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                            </div>
                            <div class="nav-bg-class">
                                <div class="navbar-collapse collapse" id="mc-horizontal-menu-collapse">
                                    <div class="nav-outer">
                                        <ul class="nav navbar-nav">
                                            <li class="dropdown"> <a href="{{ url('') }}" data-hover="dropdown">Home</a>
                                            </li>
                                            <li class="dropdown"> <a href="{{ url('stores') }}" data-hover="dropdown">Store</a>

                                            </li>
                                            <!-- <li class="dropdown"> <a href="{{ url('categories') }}" data-hover="dropdown">Category</a>

                                            </li> -->
                                            <!-- <li class="dropdown"> <a href="{{ url('event/halloween-coupons') }}" data-hover="dropdown">Halloween</a> -->


                                            <li class="dropdown">

                                                <a href="{{ url('event/halloween-coupons') }}" data-hover="dropdown">
                                                    <div class="sign">
                                                        <span class="fast-flicker">H</span>a<span class="flicker">LL</span>o<span class="flicker">W</span>ee<span class="flicker">N</span>
                                                    </div>
                                                </a>

                                            </li>


                                            </li>
                                            @yield('specialevents')

                                        </ul>

                                        <!-- /.navbar-nav -->
                                        <div class="clearfix"></div>
                                    </div>
                                    <!-- /.nav-outer -->
                                </div>
                                <!-- /.navbar-collapse -->

                            </div>
                            <!-- /.nav-bg-class -->
                        </div>
                        <!-- /.navbar-default -->
                        <div class="top-cart-row">
                            <!-- ============================================================= SHOPPING CART DROPDOWN ============================================================= -->

                            <div class="dropdown dropdown-cart"> <a href="{{ url('blog') }}" class="dropdown-toggle lnk-cart">
                                    <div class="items-cart-inner">
                                        <div class="total-price-basket"> <span class="lbl">Blog</span> </div>
                                    </div>
                                </a>
                            </div>
                            <!-- /.dropdown-cart -->

                            <!-- ============================================================= SHOPPING CART DROPDOWN : END============================================================= -->
                        </div>
                    </div>
                    <!-- /.container-class -->



                </div>

                <!-- /.row -->

            </div>
            <!-- /.container -->

        </div>
        <!-- /.main-header -->



    </header>

    <!-- ============================================== HEADER : END ============================================== -->

    @yield('content')

    @yield('globalOffers')




    <!-- /.homebanner-holder -->



    <!-- /.row -->


    </div>
    <!-- /#top-banner-and-menu -->
    <section class="section coupons-section" style="background-image: none;position: absolute;">
        <div id="CouponModal" class="modal fade" role="dialog">

        </div>
    </section>


    @yield('footer')


    <script src="{{ mix('js/site.js') }}"></script>

    <script>
        function onOfflineCopounClick(obj) {
            logCPC($(obj).data('url'));
            window.open($(obj).data('affiliateurl'), "_blank");
        }

        function onCopounClick(obj) {
            showCouponPopup($(obj).data('url'));
            window.open($(obj).data('affiliateurl'), "_blank");
        }

        function openInNewTab(obj) {
            window.open($(obj).data('url'), "_blank");
        }


        function logCPC(t, u) {

            $.ajax({
                type: "Get",
                cache: !1,
                contentType: "text/html",
                url: t,
                success: function(u) {

                }
            })
        }

        function showCouponPopup(t, u) {

            $.ajax({
                type: "Get",
                cache: !1,
                contentType: "text/html",
                url: t,
                success: function(u) {
                    $("#CouponModal").html(u);
                    $("#CouponModal").modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    setAutoCopy();

                    $("#subscribeForm1").ajaxForm(function() {
                        $("#subscribeForm1").trigger("reset");
                        $(".newsletter-form1").html('<i class="fa fa-check-circle siteIcon" aria-hidden="true"></i> Thanks! You\'re subscribed to the Saveecoupons weekly email newsletter!')
                    });
                }
            })
        }

        function setAutoCopy() {
            var e = document.querySelector(".js-textareacopybtn");
            null != e && e.addEventListener("click", function(e) {
                var t = document.querySelector(".js-copytextarea");
                t.select();
                try {
                    document.execCommand("copy");
                } catch (c) {}
            })
        }

        $(function() {
            $("#subscribeForm").ajaxForm(function() {
                $("#subscribeForm").trigger("reset");
                $(".newsletter-form").html('<i class="fa fa-check-circle siteIcon" aria-hidden="true"></i> Thanks! You\'re subscribed to the Saveecoupons weekly email newsletter!')
            });
        });



        $(document).ready(function() {
            var dthen1 = new Date($(".countbox_1").data("enddtime"));

            var start_date = new Date();
            var dnow1 = new Date(start_date);
            if (CountStepper > 0)
                ddiff = new Date((dnow1) - (dthen1));
            else
                ddiff = new Date((dthen1) - (dnow1));
            gsecs1 = Math.floor(ddiff.valueOf() / 1000);

            var iid1 = "countbox_1";
            CountBack_slider(gsecs1, "countbox_1", 1);

        });

        function onSearch() {
            var e = $("#searchStoreInput").val();
            if ("" != e.trim()) {
                var n = "{{ route('site.siteSearch','keyword') }}".replace("keyword", e);

                $.ajax({
                    type: "Get",
                    cache: !1,
                    contentType: "text/html",
                    url: n,
                    success: function(u) {
                        $("#suggesionDiv").html(u);
                    }
                });

            } else {
                $("#suggesionDiv").html("");
                return
            }

        }
    </script>

    @yield('pagescripts')

    @yield('schemaOrg')
</body>

</html>