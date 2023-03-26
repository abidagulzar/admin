@extends('Site.Layout.master')

@section('metadata')
<meta name="description" content="{{$homeSetting->Description}}">
<meta name="keywords" content="{{$homeSetting->Keywords}}">
<title>{{$homeSetting->Title}}</title>
@endsection


@section('footer')
@include('Site.Layout.footer', ['SmallFooterText' => $homeSetting->Footer,'relatedSearch' => $relatedSearch,'relatedSearchKeyword' => ''])
@endsection


@section('specialevents')
@include('Site.Layout.specialeventsmenue', ['specialPage' => $specialPage])
@endsection

@section('metadata')
<meta name="description" content="{{$homeSetting->Description}}">
<meta name="keywords" content="{{$homeSetting->Keywords}}">
<title>{{$homeSetting->Title}}</title>
@endsection

@section('schemaOrg')
@if(isset($homeSetting->SchemaOrg))
{!! $homeSetting->SchemaOrg !!}
@endif
@endsection

@section('content')




<div class="outer-top-ts top-banner">
    <div class="container">
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- AD Home1 -->
        <ins class="adsbygoogle" style="display:inline-block;width:1160px;height:102px" data-ad-client="ca-pub-5358982852113526" data-ad-slot="6744709899"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
</div>

<div class="body-content outer-top-ts" id="top-banner-and-menu">
    <div class="container">
        <div class="slider-section">

            <!-- ============================================== SIDEBAR ============================================== -->
            <div class="col-xs-12 col-sm-3 col-md-2 sidebar">

                <!-- ================================== TOP NAVIGATION ================================== -->
                <div class="side-menu side-menu-inner animate-dropdown outer-bottom-xs">
                    <nav class="yamm megamenu-horizontal">
                        <ul class="nav">
                            @foreach($homeCategory as $hC)
                            <li class="menu-item">

                                <a href="{{ url('category/'.$hC->SearchName) }}" target="_blank"><i class="fa {{$hC->IconClass}}"></i> {{$hC->Name}}

                                </a> </li>
                            <!-- /.menu-item -->
                            @endforeach
                        </ul>
                        <!-- /.nav -->
                    </nav>
                    <!-- /.megamenu-horizontal -->
                </div>

                <!-- /.side-menu -->
                <!-- ================================== TOP NAVIGATION : END ================================== -->
            </div>

            <!-- /.sidemenu-holder -->



            <!-- ============================================== SIDEBAR : END ============================================== -->

            <div class="col-xs-12 col-sm-9 col-md-10 homebanner-holder">
                <div id="hero">
                    <div id="owl-main" class="owl-carousel owl-inner-nav owl-ui-sm">

                        @foreach($homeCouponBannerDeal as $hB)

                        @if($hB->IsBanner == 1 && $hB->IsHomeBanner == 1 && $hB->IsTopDeal != 1)
                        <div class="item owl-lazy" style="background-image: url({{ url('/storage/bannerlogo').'/'.$hB->BannerUrl }});">
                            <div class="container-fluid">
                                <div class="caption bg-color vertical-center text-left">
                                    <div class="slider-header fadeInDown-1">{{ $hB->CopounTypeText }}</div>
                                    <div class="big-text fadeInDown-1"> {{ $hB->OFF }} </div>
                                    <div class="excerpt fadeInDown-2 hidden-xs"> <span>{{ $hB->Header }}</span> </div>
                                    <div class="button-holder fadeInDown-3"> <a data-affiliateurl="{{$hB->CouponUrl}}" data-url="{{ route('site.couponPopUpUrl', ['store' => $hB->StoreName,'couponid' => $hB->CouponId]) }}" onclick="onCopounClick(this)" class="btn-lg btn btn-uppercase btn-primary shop-now-button">Shop Now</a> </div>
                                </div>
                                <!-- /.caption -->
                            </div>
                            <!-- /.container-fluid -->
                        </div>
                        <!-- /.item -->
                        @endif
                        @endforeach

                    </div>
                    <!-- /.owl-carousel -->
                </div>
            </div>
            <!-- /.homebanner-holder -->
        </div>
    </div>
    <div class="container">
        <div class="row">
            <!-- ============================================== CONTENT ============================================== -->
            <div class="col-xs-12 col-sm-12 col-md-12">
                <!-- ========================================== SECTION – HERO ========================================= -->



                <!-- ========================================= SECTION – HERO : END ========================================= -->


                <!-- ============================================== STORES SECTION ============================================== -->
                <section class="section featured-section wow fadeInUp">
                    <h2>Stores For You</h2>
                    <div class="featured-product">
                        <div class="owl-carousel homepage-owl-carousel custom-carousel owl-theme outer-top-xs">

                            @foreach($homeStore as $hS)
                            <div class="item item-carousel">
                                <div class="products">
                                    <div class="product">
                                        <div class="product-image">
                                            <div class="image">
                                                <a href="{{ url('view/'.$hS->SearchName) }}">

                                                    <img class="img-responsive" src="{{ url('/storage/storelogo').'/'.$hS->LogoUrl }}" alt="">
                                                </a>

                                            </div>
                                            <!-- /.image -->

                                        </div>
                                        <div class="product-info">
                                            <h3 class="name"><a href="{{ url('view/'.$hS->SearchName) }}">{{ $hS->Name }}</a></h3>
                                        </div>

                                    </div>
                                    <!-- /.product -->

                                </div>
                                <!-- /.products -->
                            </div>
                            @endforeach

                        </div>

                        <!-- /.home-owl-carousel -->
                    </div>
                </section>
                <!-- /.section -->
                <!-- ============================================== stores : END ============================================== -->

                @if($homeSetting->IsBanner2Show == 1 || $homeSetting->IsBanner3Show == 1)
                <!-- ============================================== WIDE PRODUCTS ============================================== -->

                <div class="wide-banners wow fadeInUp outer-bottom-bs">
                    <div class="row">
                        @if($homeSetting->IsBanner2Show == 1)
                        <div class="col-md-6 col-sm-6">
                            <div class="wide-banner cnt-strip">
                                <div class="image"> <img class="img-responsive" src="{{ url('/storage/bannerlogo').'/'.$homeSetting->Banner2Url }}" alt=""> </div>
                            </div>
                            <!-- /.wide-banner -->
                        </div>
                        @endif
                        @if($homeSetting->IsBanner3Show == 1)
                        <div class="col-md-6 col-sm-6">
                            <div class="wide-banner cnt-strip">
                                <div class="image"> <img class="img-responsive" src="{{ url('/storage/bannerlogo').'/'.$homeSetting->Banner3Url }}" alt=""> </div>
                            </div>
                            <!-- /.wide-banner -->
                        </div>
                        @endif
                    </div>

                </div>
                <!-- /.wide-banners -->
                @endif

                <!-- ============================================== WIDE PRODUCTS : END ============================================== -->


                <!-- ============================================== SCROLL TABS ============================================== -->
                <div id="product-tabs-slider" class="scroll-tabs wow fadeInUp">
                    <div class="more-info-tab clearfix ">
                        <h3 class="new-product-title pull-left">Trending Deals</h3>
                        <ul class="nav nav-tabs nav-tab-line pull-right hidden" id="new-products-1">
                            <li class="active"><a data-transition-type="backSlide" href="#all" data-toggle="tab">All</a></li>
                            <li><a data-transition-type="backSlide" href="#smartphone" data-toggle="tab">Clothing</a></li>
                            <li><a data-transition-type="backSlide" href="#laptop" data-toggle="tab">Electronics</a></li>
                            <li><a data-transition-type="backSlide" href="#apple" data-toggle="tab">Shoes</a></li>
                        </ul>
                        <!-- /.nav-tabs -->
                    </div>
                    <div class="tab-content outer-top-xs">
                        <div class="tab-pane in active" id="all">
                            <div class="product-slider">
                                <div class="owl-carousel home-owl-carousel custom-carousel owl-theme">

                                    @foreach($homeCouponBannerDeal as $hD)

                                    @if($hD->HomeCoupon == 1 && empty($hD->Code) && !empty($hD->LogoUrl))
                                    <div class="item item-carousel">
                                        <div class="products">
                                            <div class="product">
                                                <div class="product-image">
                                                    <div class="image">
                                                        <a data-affiliateurl="{{$hD->CouponUrl}}" data-url="{{ route('site.couponPopUpUrl', ['store' => $hD->StoreName,'couponid' => $hD->CouponId]) }}" onclick="onCopounClick(this)">
                                                            <img src="{{ url('/storage/couponlogo').'/'.$hD->LogoUrl }}" alt="">
                                                        </a>
                                                    </div>
                                                    <!-- /.image -->

                                                    <div class="tag new"><span>{{ $hD->OFF }}</span></div>
                                                </div>
                                                <!-- /.product-image -->

                                                <div class="product-info text-left">
                                                    <div class="brand">{{ $hD->StoreName }}</div>
                                                    <h3 class="name"><a data-affiliateurl="{{$hD->CouponUrl}}" data-url="{{ route('site.couponPopUpUrl', ['store' => $hD->StoreName,'couponid' => $hD->CouponId]) }}" onclick="onCopounClick(this)">{{ $hD->Header }}</a></h3>
                                                    <div class="rating rateit-small"></div>
                                                    <div class="description"></div>
                                                    <div class="product-price hidden"> <span class="price"> $450.99 </span> <span class="price-before-discount">$ 800</span> </div>
                                                    <!-- /.product-price -->

                                                </div>
                                                <!-- /.product-info -->
                                                <div class="cart clearfix animate-effect">
                                                    <div class="action">
                                                        <ul class="list-unstyled">
                                                            <!-- <li class="add-cart-button btn-group">
                                                                <button data-toggle="tooltip" class="btn btn-primary icon" type="button" title="Add Cart"> <i class="fa fa-shopping-cart"></i> </button>
                                                                <button class="btn btn-primary cart-btn" type="button">Buy Now</button>
                                                            </li> -->
                                                            <li class="lnk wishlist"> <a data-toggle="tooltip" class="add-to-cart" data-affiliateurl="{{$hD->CouponUrl}}" data-url="{{ route('site.couponPopUpUrl', ['store' => $hD->StoreName,'couponid' => $hD->CouponId]) }}" onclick="onCopounClick(this)" title="Buy Now"> <i class="icon fa fa-shopping-cart"></i> </a> </li>
                                                            <!-- <li class="lnk wishlist"> <a data-toggle="tooltip" class="add-to-cart" href="deals-detail.html" title="Wishlist"> <i class="icon fa fa-heart"></i> </a> </li> -->
                                                            <!-- <li class="lnk"> <a data-toggle="tooltip" class="add-to-cart" href="deals-detail.html" title="Compare"> <i class="fa fa-signal" aria-hidden="true"></i> </a> </li> -->
                                                        </ul>
                                                    </div>
                                                    <!-- /.action -->
                                                </div>
                                                <!-- /.cart -->
                                            </div>
                                            <!-- /.product -->

                                        </div>
                                        <!-- /.products -->
                                    </div>
                                    <!-- /.item -->
                                    @endif
                                    @endforeach

                                </div>
                                <!-- /.home-owl-carousel -->
                            </div>
                            <!-- /.product-slider -->
                        </div>


                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.scroll-tabs -->
                <!-- ============================================== SCROLL TABS : END ============================================== -->

                @if($homeSetting->IsBanner4Show == 1)
                <!-- ============================================== WIDE PRODUCTS ============================================== -->
                <div class="wide-banners wow fadeInUp outer-bottom-bs">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="cnt-strip">
                                <div class="image1"> <img class="img-responsive" src="{{ url('/storage/bannerlogo').'/'.$homeSetting->Banner4Url }}" alt=""> </div>
                                <div class="strip strip-text">
                                    <div class="strip-inner">
                                        <h2 class="text-right"><br>
                                            <span class="shopping-needs">{{$homeSetting->Banner4HeaderText}}</span></h2>
                                    </div>
                                </div>
                                <div class="new-label">
                                    <div class="text"></div>
                                </div>
                                <!-- /.new-label -->
                            </div>
                            <!-- /.wide-banner -->
                        </div>
                        <!-- /.col -->

                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.wide-banners -->
                <!-- ============================================== WIDE PRODUCTS : END ============================================== -->
                @endif

            </div>
        </div>
    </div>





    {{count($homeCoupon) }}

    <!-- ============================================== Coupons  ============================================== -->
    <section class="section coupons-section">
        <div class="container">
            <h3 class="section-title">Best Online Promo Codes</h3>

            <div class="coupons-deals">
                <div class="owl-carousel home-owl-carousel1 custom-carousel owl-theme outer-top-xs">

                    @while(count($homeCoupon) > 0)
                    @include('Site.Home.homecouponcarousel', ['homeCoupon1' => $homeCoupon->pop(),'homeCoupon2' => $homeCoupon->pop()])
                    @endwhile


                </div>

            </div>

    </section>
    <!-- /.section -->

    <!-- /.row -->











    <!-- ============================================== BLOG SLIDER ============================================== -->
    <div class="container">
        <div class="row">
            <section class="section blog-section outer-bottom-xs wow fadeInUp">
                <h3 class="section-title">Top Offers</h3>
                <div class="latest-blog">
                    <div class="blog-slider-container outer-top-xs">
                        <div class="owl-carousel blog-slider custom-carousel">
                            @foreach($homeCouponBannerDeal as $hB)
                            @if($hB->IsTopDeal == 1)
                            <div class="item">
                                <div class="blog-post">
                                    <div class="blog-post-image">
                                        @if(isset($hB->LogoUrl) && !empty($hB->LogoUrl))
                                        <div class="topoffer image" style="cursor: pointer;"> <a data-affiliateurl="{{$hB->CouponUrl}}" data-url="{{ route('site.couponPopUpUrl', ['store' => $hB->StoreName,'couponid' => $hB->CouponId]) }}" onclick="onCopounClick(this)"><img src="{{ url('/storage/couponlogo').'/'.$hB->LogoUrl }}" alt=""></a> </div>
                                        @else
                                        <div class="image"> <a data-affiliateurl="{{$hB->CouponUrl}}" data-url="{{ route('site.couponPopUpUrl', ['store' => $hB->StoreName,'couponid' => $hB->CouponId]) }}" onclick="onCopounClick(this)"><img src="{{ url('/storage/storelogo').'/'.$hB->StoreLogoUrl }}" alt=""></a> </div>
                                        @endif
                                    </div>
                                    <!-- /.blog-post-image -->

                                    <div class="blog-post-info text-left" style="cursor: pointer;">
                                        <h3 class="name"><a data-affiliateurl="{{$hB->CouponUrl}}" data-url="{{ route('site.couponPopUpUrl', ['store' => $hB->StoreName,'couponid' => $hB->CouponId]) }}" onclick="onCopounClick(this)">Code</a></h3>
                                        <span class="info">{{$hB->Header}}</span>
                                        <p class="text"></p>
                                    </div>
                                    <!-- /.blog-post-info -->

                                </div>
                                <!-- /.blog-post -->
                            </div>
                            <!-- /.item -->
                            @endif
                            @endforeach

                        </div>
                        <!-- /.owl-carousel -->
                    </div>
                    <!-- /.blog-slider-container -->
                </div>
            </section>
            <!-- /.section -->
        </div>
    </div>



    <section class="section subscribe-area ptb-40 t-center">
        <div class="newsletter-form">
            <h4 class="mb-20"><i class="fa fa-envelope-o color-green mr-10"></i>Sign up for our weekly email newsletter</h4>
            <form id="subscribeForm" action="{{ route('site.subscribe') }}" method="post">
                @csrf
                <div class="input-group mb-10">
                    <input type="email" name="Email" id="Email" class="form-control bg-white" placeholder="Email Address" required="">
                    <span class="input-group-btn">
                        <button class="btn" type="submit">Subscribe</button>
                    </span>
                </div>
            </form>
            <p class="color-muted"><small>We’ll never share your email address with a third-party.</small> </p>
        </div>
    </section>



</div>




<!-- /#top-banner-and-menu -->


@endsection