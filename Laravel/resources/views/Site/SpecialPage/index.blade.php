@extends('Site.Layout.master')

@section('metadata')
<meta name="description" content="{{$metaSetting->Description}}">
<meta name="keywords" content="{{$metaSetting->Keywords}}">
<title>{{$metaSetting->Title}}</title>
@endsection

@section('specialevents')
@include('Site.Layout.specialeventsmenue', ['specialPage' => $specialPage])
@endsection

@section('footer')
@include('Site.Layout.footer', ['SmallFooterText' => $metaSetting->Footer,'relatedSearch' => $relatedSearch,'relatedSearchKeyword' => ''])
@endsection


@section('content')
<div class="body-content outer-top-ts">
    <div class='container'>

        <div class='row'>

            <div class="col-md-9 rht-col">

                <!-- ========================================== SECTION – HERO ========================================= -->

                @if(isset($selectedSpecialPage->LogoUrl))
                <div id="category" class="category-carousel hidden-xs">
                    <div class="item">
                        <div class="image"> <img src="{{ url('/storage/specialpagelogo').'/'.$selectedSpecialPage->BannerUrl }}" alt="" class="img-responsive"> </div>
                        <div class="container-fluid">
                            <div class="caption vertical-top text-left">
                                <div class="big-text">{{$selectedSpecialPage->BigTitle}}</div>
                                <div class="excerpt hidden-sm hidden-md">{{$selectedSpecialPage->SubTitle}}</div>
                            </div>
                            <!-- /.caption -->
                        </div>
                        <!-- /.container-fluid -->
                    </div>
                </div>
                @endif



                <div class="category-product coupons-section coupons-section-inner">
                    <div class="row coupons-deals">
                        @foreach($selectedSpecialPageCoupons as $coupon)


                        <div class="col-sm-6 col-md-6 col-lg-6 wow fadeInUp">
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








                <!-- /.search-result-container -->


            </div>
            <!-- /.col -->
            <!-- ============================================== SIDEBAR ============================================== -->

            <div class="col-md-3 sidebar">

                <div class="store-box">
                    <img class="img-responsive" src="{{ url('/storage/specialpagelogo').'/'.$selectedSpecialPage->LogoUrl }}" alt="{{$selectedSpecialPage->Title}}">
                    <h2><a href="{{$selectedSpecialPage->URL}}">{{$selectedSpecialPage->Title}}</a></h2>
                    <!-- <div class="mail-box"><a href="#">altam@themesground.com</a></div> -->
                    <div class="social">
                        <ul class="link">
                            <li class="fb"><a target="_blank" rel="nofollow" href="https://web.facebook.com/saveecoupons" title="Facebook"></a></li>
                            <li class="tw"><a target="_blank" rel="nofollow" href="https://twitter.com/saveecoupons" title="Twitter"></a></li>
                            <li class="pintrest"><a target="_blank" rel="nofollow" href="https://www.pinterest.com/saveecoupons" title="PInterest"></a></li>
                            <li class="instagram"><a target="_blank" rel="nofollow" href="https://www.instagram.com/saveecoupons" title="Instagram"></a></li>
                        </ul>
                    </div>
                    <p>{!! $selectedSpecialPage->Description !!}</p>
                </div>

                @if(count($specialPageRelatedStores) > 0)
                <div class="sidebar-module-container">
                    <div class="sidebar-filter">
                        <!-- ============================================== SIDEBAR CATEGORY ============================================== -->
                        <div class="sidebar-widget wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">
                            <h3 class="section-title">Related Stores</h3>
                            <!-- <div class="widget-header">
                                <h4 class="widget-title">Category</h4>
                            </div> -->
                            <div class="sidebar-widget-body">
                                <ul class="list list-bordered">
                                    @foreach($specialPageRelatedStores as $specialPageRelatedStore)
                                    @if(isset($specialPageRelatedStore->StoreName))
                                    <li><a href="{{ url('view/'.$specialPageRelatedStore->StoreSearchName) }}">{{$specialPageRelatedStore->StoreName}}</a></li>
                                    @endif
                                    @endforeach
                                </ul>
                                <!--<a href="#" class="lnk btn btn-primary">Show Now</a>-->
                            </div>
                            <!-- /.sidebar-widget-body -->
                        </div>
                        <!-- /.sidebar-widget -->
                        <!-- ============================================== SIDEBAR CATEGORY : END ============================================== -->




                    </div>
                    <!-- /.sidebar-filter -->
                </div>
                <!-- /.sidebar-module-container -->
                @endif
                <div class="whitepanel mb-10 text-center" style="margin-top:10px; padding: 0px;padding-bottom: 10px;">
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
            <!-- /.sidemenu-holder -->
            <!-- ============================================== SIDEBAR : END ============================================== -->

        </div>
    </div>
</div>

@endsection