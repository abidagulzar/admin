@extends('Site.Layout.master')

@section('metadata')
<meta name="description" content="{{$categorySetting->Description}}">
<meta name="keywords" content="{{$categorySetting->Keywords}}">
<title>{{$categorySetting->Title}}</title>
@endsection

@section('specialevents')
@include('Site.Layout.specialeventsmenue', ['specialPage' => $specialPage])
@endsection

@section('footer')
@include('Site.Layout.footer', ['SmallFooterText' => $categorySetting->Footer,'relatedSearch' => $relatedSearch,'relatedSearchKeyword' => $category->Name])
@endsection


@section('content')



<div class="body-content outer-top-ts">
    <div class='container'>


        <div class='row'>
            <!-- ============================================== SIDEBAR ============================================== -->

            <div class="col-md-8 rht-col">
                <div class="category-product coupons-section coupons-section-inner">
                    <div class="whitepanel mb-30 text-center" style="padding: 0px;padding-bottom: 20px;">
                        <h2>{{$category->Name}} Discount and Coupons</h2>

                        <!-- <div class="mail-box"><a href="#">altam@themesground.com</a></div> -->

                    </div>
                    <div class="row coupons-deals">

                        @foreach($categoryCoupons as $categoryCoupon)
                        @if(isset($categoryCoupon->StoreName))
                        <div class="col-sm-6 col-md-6 col-lg-6 wow fadeInUp">
                            <div class="item">
                                <div class="products">
                                    <div class="product">
                                        <div class="product-image">
                                            <div class="image">
                                                <img class="img-responsive" src="{{ url('/storage/storelogo').'/'.$categoryCoupon->StoreLogoUrl }}" alt="">
                                                <div class="brand">{{$categoryCoupon->StoreName}}</div>
                                                <h3 class="name"><a data-affiliateurl="{{$categoryCoupon->CouponUrl}}" data-url="{{ route('site.couponPopUpUrl', ['store' => $categoryCoupon->StoreName,'couponid' => $categoryCoupon->CouponId]) }}" onclick="onCopounClick(this)">{{$categoryCoupon->Header}}</a></h3>

                                            </div>
                                            <!-- /.image -->


                                        </div>
                                        <!-- /.product-image -->

                                        <div class="product-info text-left">
                                            <div class="discount"><span>{{$categoryCoupon->OFF}}</span></div>
                                            <div class="show-code"><a data-affiliateurl="{{$categoryCoupon->CouponUrl}}" data-url="{{ route('site.couponPopUpUrl', ['store' => $categoryCoupon->StoreName,'couponid' => $categoryCoupon->CouponId]) }}" onclick="onCopounClick(this)">@if(empty($categoryCoupon->Code))Get Deal @else Show Code @endif</a></div>
                                            <p class="exp-date"><i class="fa fa-clock-o"></i> {{empty($categoryCoupon->ExpiryDate) ||$categoryCoupon->IsUnknownOutGoing == 1 ? 'Unknown/Ongoing':'Expires on '.date('d/m/Y', strtotime($categoryCoupon->ExpiryDate)) }}</p>
                                        </div>

                                    </div>
                                    <!-- /.product -->

                                </div>
                                <!-- /.products -->


                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>


            </div>


            <div class="col-md-4 sidebar">


                <div class="mb-10">
                    <div id="owl-main" class="owl-carousel owl-ui-sm" data-xxs-nav="true">

                        @if(count($categoryBanners)> 0)
                        @foreach($categoryBanners as $hB)
                        @if(isset($hB->StoreName))

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
                        @endif

                    </div>
                    <!-- /.owl-carousel -->
                </div>
                <div class="whitepanel mb-10 text-center" style="padding: 0px;padding-bottom: 10px;">
                    <h4 class="">Best Related Deals</h4>

                    <div class="category-product stores-list">
                        <div class="row coupons-deals">
                            @foreach($relatedDeals as $categoryCoupon)
                            @if(isset($categoryCoupon->StoreName))
                            <div class="col-sm-12 col-md-12 col-lg-12 wow fadeInUp">
                                <div class="item">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 logo-img">
                                            <a href="{{ url('view/'.$categoryCoupon->StoreSearchName) }}">
                                                <img class="img-responsive" src="{{ url('/storage/storelogo').'/'.$categoryCoupon->StoreLogoUrl }}" alt="">
                                            </a>
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">
                                            <h3><a data-affiliateurl="{{$categoryCoupon->CouponUrl}}" data-url="{{ route('site.couponPopUpUrl', ['store' => $categoryCoupon->StoreName,'couponid' => $categoryCoupon->CouponId]) }}" onclick="onCopounClick(this)">{{$categoryCoupon->Header}}</a></h3>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach

                        </div>
                    </div>

                </div>
                <div class="whitepanel mb-10 text-center" style="padding: 0px;padding-bottom: 10px;">
                    <h4 class="">Subscribe to mail</h4>

                    <section class="section subscribe-area ">
                        <div class="newsletter-form">
                            <h5 class="mb-20"><i class="fa fa-envelope-o color-green mr-10"></i>Sign up for our weekly email newsletter</h5>
                            <form id="subscribeForm" style="padding-left: 10px;padding-right: 10px;" action="{{ route('site.subscribe') }}" method="post">
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
                <div class="whitepanel mb-10 text-center" style="padding: 0px;padding-bottom: 10px;">
                    <h4 class="">Got any questions?
                    </h4>

                    <section class="section subscribe-area ">
                        <div class="drop-email" style="padding-left: 10px;padding-right: 10px;">
                            <h5 class="mb-20">If you are having any questions, please feel free to ask.</h5>
                            <a href="{{ url('contactus')}}" class="btn btn-block"><i class="mr-10 font-15 fa fa-envelope-o"></i>Drop Us a Line</a>

                        </div>
                    </section>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection