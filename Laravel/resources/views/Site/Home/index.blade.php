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
    <div class='container'>
        <h3 class="section-title">Trending Coupons and Deals</h3>
        <br />
        <div class='row'>

            <div class="col-md-12 rht-col">


                <div class="category-product coupons-section coupons-section-inner">
                    <div class="row coupons-deals">
                        @foreach($homeCoupon as $coupon)


                        <div class="col-sm-4 col-md-4 col-lg-4 wow fadeInUp">
                            <div class="item">
                                <div class="products">
                                    <div class="product">
                                        <div class="product-image">
                                            <div class="image">
                                                <img class="img-responsive" src="{{ url('/storage/storelogo').'/'.$coupon->StoreLogoUrl }}" alt="">
                                                <div class="brand">{{$coupon->StoreName}}</div>
                                                <h3 class="name"><a data-affiliateurl="{{$coupon->CouponUrl}}" data-url="{{ route('site.couponPopUpUrl', ['store' => $coupon->StoreName,'couponid' => $coupon->CouponId]) }}" onclick="onCopounClick(this)">{{$coupon->Header}}</a></h3>

                                            </div>
                                            <!-- /.image -->


                                        </div>
                                        <!-- /.product-image -->

                                        <div class="product-info text-left">
                                            <div class="discount"><span>{{$coupon->OFF}}</span></div>
                                            <div class="show-code"><a data-affiliateurl="{{$coupon->CouponUrl}}" data-url="{{ route('site.couponPopUpUrl', ['store' => $coupon->StoreName,'couponid' => $coupon->CouponId]) }}" onclick="onCopounClick(this)">@if(empty($coupon->Code))GET DEAL @else SHOW CODE @endif</a></div>
                                            <p class="exp-date"><i class="fa fa-clock-o"></i> {{empty($coupon->ExpiryDate) ||$coupon->IsUnknownOutGoing == 1 ? 'Unknown/OutGoing':'Expire On'.' '.date('d/m/Y', strtotime($coupon->ExpiryDate)) }}</p>
                                        </div>

                                    </div>
                                    <!-- /.product -->

                                </div>
                                <!-- /.products -->


                            </div>
                        </div>
                        <!-- /.item -->


                        @endforeach
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.category-product -->


                <!-- /.tab-pane -->

            </div>
        </div>
    </div>





    <div class="container">
        <div class="row">
            <!-- ============================================== CONTENT ============================================== -->
            <div class="col-xs-12 col-sm-12 col-md-12">
                <!-- ========================================== SECTION – HERO ========================================= -->



                <!-- ========================================= SECTION – HERO : END ========================================= -->


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
                                            <span class="shopping-needs">{{$homeSetting->Banner4HeaderText}}</span>
                                        </h2>
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
</div>




{{count($crousalCoupon) }}

<!-- ============================================== Coupons  ============================================== -->
<section class="section coupons-section">
    <div class="container">
        <h3 class="section-title">Best Online Promo Codes</h3>

        <div class="coupons-deals">
            <div class="owl-carousel home-owl-carousel1 custom-carousel owl-theme outer-top-xs">

                @while(count($crousalCoupon) > 0)
                @include('Site.Home.homecouponcarousel', ['homeCoupon1' => $crousalCoupon->pop(),'homeCoupon2' => $crousalCoupon->pop()])
                @endwhile


            </div>

        </div>

</section>
<!-- /.section -->

<!-- /.row -->











<!-- ============================================== BLOG SLIDER ============================================== -->



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