@extends('Site.Layout.master',['lang' => $storeSetting->Lang])

@section('metadata')
<meta name="description" content="{{$storeSetting->Description}}">
<meta name="keywords" content="{{$storeSetting->Keywords}}">
<title>{{$storeSetting->Title}}</title>
<meta property="og:url" content="{{ url('view/'.$store->SearchName) }}" />
<meta property="og:title" content="{{$storeSetting->Title}}" />
<meta property="og:description" content="{{$storeSetting->Description}}" />
<meta property="og:image" content="{{ url('/storage/storelogo').'/'.$store->LogoUrl }}" />
<link rel="canonical" href="{{ url('view/'.$store->SearchName) }}" />

@endsection

@section('specialevents')
@include('Site.Layout.specialeventsmenue', ['specialPage' => $specialPage])
@endsection

@section('footer')
@include('Site.Layout.footer', ['SmallFooterText' => $storeSetting->Footer,'relatedSearch' => $relatedSearch,'relatedSearchKeyword' => $store->SEOStoreName,'customRelatedSearch'=>$customRelatedSearch,'RelatedSearchesTranslate'=>$storeSetting->RelatedSearchesTranslate,'GeneralTranslate'=>$storeSetting->GeneralTranslate,'ConnectTranslate'=>$storeSetting->ConnectTranslate,'SpecialPagesHeading'=>$storeSetting->SpecialPagesHeading])
@endsection

@section('headerdeal')
@if(isset($headerdeal))
@include('Site.Layout.headerdeal', ['headerdeal' => $headerdeal,'storeName' => $store->SEOStoreName])
@endif
@endsection

@section('globalOffers')
@if(isset($globalOffers))
@include('Site.Layout.globalOffers', ['globalOffers' => $globalOffers])
@endif
@endsection



@section('content')



<div class="body-content outer-top-ts">
    <div class='container'>

        <div class='row'>
            <!-- ============================================== SIDEBAR ============================================== -->

            <div class="col-md-9 rht-col">
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        <div class="whitepanel mb-10 text-center filter-options" style="padding: 5px;padding-bottom: 10px;">

                            @if(isset($store->Header1) && $store->Header1 != '')
                            <h1 class="mb-10 lnr">{{$store->Header1}}</h1>
                            @else
                            <h1 class="mb-10 lnr">{{$store->SEOStoreName}} Coupon Codes & Promo Codes </h1>
                            @endif
                            <button class="btn btn-primary" data-group="Coupon">{{$storeSetting->Coupon}} ({{ count($storeCoupons->where('Code', '!=' , '')) }})</button>
                            <button class="btn btn-primary" data-group="Deal">{{$storeSetting->Deal}} ({{ count($storeCoupons->where("Code",'')) }})</button>
                            <button class="btn btn-primary" data-group="Exclusive">{{$storeSetting->Exclusive}} ({{ count($storeCoupons->where('IsExclusive', 1)) }})</button>
                            @if(isset($similarStoreCoupons) & count($similarStoreCoupons) > 0)
                            <button class="btn btn-primary" data-group="SimilarStoreCoupon">Similar Store Offers</button>
                            @endif
                            @if(isset($distinctCountries))
                            <br />
                            <br />
                            @foreach($distinctCountries as $disC)
                            @if(isset($disC->CountryName))
                            <button class="btn btn-primary" data-group="{{$disC->CountryName}}">{{$disC->CountryName}}</button>
                            @endif
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>


                @if(isset($trueCountry) && $trueCountry == 1)
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                        <div class="category-product coupons-section coupons-section-inner">
                            <div id="storedeals" class="row coupons-deals">

                                @if(count($cpcStores)>0 && count($storeCoupons)>0)

                                @foreach($storeCoupons as $storeCoupon)

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 wow fadeInUp shufflefilter1" data-groups='[@if(empty($storeCoupon->Code))"Deal"@else"Coupon"@endif @if($storeCoupon->IsExclusive == 1),"Exclusive"@endif,"{{$storeCoupon->CountryName}}"]'>
                                    <div class="item">
                                        <div class="products">
                                            <div class="product">
                                                <div class="product-image">
                                                    <div class="image">
                                                        <img class="img-responsive" src="{{ url('/storage/storelogo').'/'.$store->LogoUrl }}" alt="">
                                                        <div class="brand">{{$store->SEOStoreName}}</div>
                                                        <h3 class="name"><a data-affiliateurl="{{$storeCoupon->CouponUrl}}" data-url="{{ route('site.cpcPopUrl', ['targetstoreid' => $storeCoupon->CPCStoreId,'sourcestoreid' => $store->StoreId]) }}" onclick="onOfflineCopounClick(this)">{{$storeCoupon->Header}}</a></h3>

                                                    </div>
                                                    <!-- /.image -->


                                                </div>
                                                <!-- /.product-image -->

                                                <div class="product-info text-left">
                                                    <div class="discount"><span>{{$storeCoupon->OFF}}</span></div>
                                                    <div class="show-code"><a data-affiliateurl="{{$storeCoupon->CouponUrl}}" data-url="{{ route('site.cpcPopUrl', ['targetstoreid' => $storeCoupon->CPCStoreId,'sourcestoreid' => $store->StoreId]) }}" onclick="onOfflineCopounClick(this)">@if(empty($storeCoupon->Code)){{$storeSetting->GetDeal}} @else {{$storeSetting->ShowCode}} @endif</a></div>
                                                    <p class="exp-date"><i class="fa fa-clock-o"></i> {{empty($storeCoupon->ExpiryDate) ||$storeCoupon->IsUnknownOutGoing == 1 ? $storeSetting->UnknownOutGoing:$storeSetting->ExpiresOn.' '.date('d/m/Y', strtotime($storeCoupon->ExpiryDate)) }}</p>
                                                </div>

                                            </div>
                                            <!-- /.product -->

                                        </div>
                                        <!-- /.products -->


                                    </div>
                                </div>
                                @endforeach






                                @elseif(count($storeCoupons)>0)
                                @foreach($storeCoupons as $storeCoupon)

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 wow fadeInUp shufflefilter1" data-groups='[@if(empty($storeCoupon->Code))"Deal"@else"Coupon"@endif @if($storeCoupon->IsExclusive == 1),"Exclusive"@endif,"{{$storeCoupon->CountryName}}"]'>
                                    <div class="item">
                                        <div class="products">
                                            <div class="product">
                                                <div class="product-image">
                                                    <div class="image">
                                                        <img class="img-responsive" src="{{ url('/storage/storelogo').'/'.$store->LogoUrl }}" alt="">
                                                        <div class="brand">{{$store->SEOStoreName}}</div>
                                                        <h3 class="name"><a data-affiliateurl="{{$storeCoupon->CouponUrl}}" data-url="{{ route('site.couponPopUpUrl', ['store' => $store->SEOStoreName,'couponid' => $storeCoupon->CouponId]) }}" onclick="onCopounClick(this)">{{$storeCoupon->Header}}</a></h3>

                                                    </div>
                                                    <!-- /.image -->


                                                </div>
                                                <!-- /.product-image -->

                                                <div class="product-info text-left">
                                                    <div class="discount"><span>{{$storeCoupon->OFF}}</span></div>
                                                    <div class="show-code"><a data-affiliateurl="{{$storeCoupon->CouponUrl}}" data-url="{{ route('site.couponPopUpUrl', ['store' => $store->SEOStoreName,'couponid' => $storeCoupon->CouponId]) }}" onclick="onCopounClick(this)">@if(empty($storeCoupon->Code)){{$storeSetting->GetDeal}} @else {{$storeSetting->ShowCode}} @endif</a></div>
                                                    <p class="exp-date"><i class="fa fa-clock-o"></i> {{empty($storeCoupon->ExpiryDate) ||$storeCoupon->IsUnknownOutGoing == 1 ? $storeSetting->UnknownOutGoing:$storeSetting->ExpiresOn.' '.date('d/m/Y', strtotime($storeCoupon->ExpiryDate)) }}</p>
                                                </div>

                                            </div>
                                            <!-- /.product -->

                                        </div>
                                        <!-- /.products -->


                                    </div>
                                </div>
                                @endforeach
                                @else

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 wow fadeInUp shufflefilter1 ">
                                    <div class="item">
                                        <div class="products">
                                            <div class="product">
                                                <div class="product-image">
                                                    <div class="image">
                                                        <img class="img-responsive" src="{{ url('/storage/storelogo').'/'.$store->LogoUrl }}" alt="">
                                                        <div class="brand">{{$store->SEOStoreName}}</div>
                                                        <h3 class="name"><a href="{{$store->StoreNetworkLink}}" target="_blank">{{$storeSetting->DefaultDealText}}</a></h3>

                                                    </div>
                                                    <!-- /.image -->


                                                </div>
                                                <!-- /.product-image -->

                                                <div class="product-info text-left">
                                                    <div class="discount"><span>{{$storeSetting->Deal}}</span></div>
                                                    <div class="show-code"><a href="{{$store->StoreNetworkLink}}" target="_blank">{{$storeSetting->GetDeal}}</a></div>
                                                </div>

                                            </div>
                                            <!-- /.product -->

                                        </div>
                                        <!-- /.products -->


                                    </div>
                                </div>






                                @endif
                                @if(isset($similarStoreCoupons) )

                                @foreach($similarStoreCoupons as $storeCoupon)
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 wow fadeInUp shufflefilter1" data-groups='["SimilarStoreCoupon"]'>
                                    <div class="item">
                                        <div class="products">
                                            <div class="product">
                                                <div class="product-image">
                                                    <div class="image">
                                                        <img class="img-responsive" src="{{ url('/storage/storelogo').'/'.$storeCoupon->LogoUrl }}" alt="">
                                                        <div class="brand">{{$storeCoupon->SEOStoreName}}</div>
                                                        <h3 class="name"><a data-cpcstoreid="{{$storeCoupon->CPCStoreId}}" data-affiliateurl="{{$storeCoupon->CouponUrl}}" data-url="{{ route('site.couponPopUpUrl', ['store' => $storeCoupon->SEOStoreName,'couponid' => $storeCoupon->CouponId]) }}" onclick="onCopounClick(this)">{{$storeCoupon->Header}}</a></h3>

                                                    </div>
                                                    <!-- /.image -->


                                                </div>
                                                <!-- /.product-image -->

                                                <div class="product-info text-left">
                                                    <div class="discount"><span>{{$storeCoupon->OFF}}</span></div>
                                                    <div class="show-code"><a data-cpcstoreid="{{$storeCoupon->CPCStoreId}}" data-affiliateurl="{{$storeCoupon->CouponUrl}}" data-url="{{ route('site.couponPopUpUrl', ['store' => $storeCoupon->SEOStoreName,'couponid' => $storeCoupon->CouponId]) }}" onclick="onCopounClick(this)">@if(empty($storeCoupon->Code)){{$storeSetting->GetDeal}} @else {{$storeSetting->ShowCode}} @endif</a></div>
                                                    <p class="exp-date"><i class="fa fa-clock-o"></i> {{empty($storeCoupon->ExpiryDate) ||$storeCoupon->IsUnknownOutGoing == 1 ? $storeSetting->UnknownOutGoing:$storeSetting->ExpiresOn.' '.date('d/m/Y', strtotime($storeCoupon->ExpiryDate)) }}</p>
                                                </div>

                                            </div>
                                            <!-- /.product -->

                                        </div>
                                        <!-- /.products -->


                                    </div>
                                </div>
                                @endforeach
                                @endif




                            </div>
                        </div>
                        @if(isset($store->Description3) && $store->Description3 != '')
                        <div class="text-center p-10 panel">

                            @if(isset($store->Header3) && $store->Header3 != '')
                            <h2 class="mb-10 lnr">{{$store->Header3}}</h2>
                            @else
                            <h2 class="mb-10 lnr">More About {{$store->SEOStoreName}} Promo Code</h2>
                            @endif


                            <div class=" panel" style="margin-top:10px;font-size:17px;color:black;">
                                <p class="mb-15" style="text-align:justify;">{!! $store->Description3 !!}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>


            <div class="col-md-3 sidebar">

                <div class="store-box">
                    <img onclick="openInNewTab(this)" data-url="{{$store->StoreNetworkLink}}" class="img-responsive cur-pointer" src="{{ url('/storage/storelogo').'/'.$store->LogoUrl }}" alt="{{$store->SEOStoreName}}">
                    <h2><a href="{{$store->StoreNetworkLink}}" target="_black" class="cur-pointer">{{$store->SEOStoreName}}</a></h2>
                    <!-- <div class="mail-box"><a href="#">altam@themesground.com</a></div> -->
                    <div class="social">
                        <ul class="link">
                            <li class="fb"><a target="_blank" rel="nofollow" href="https://web.facebook.com/saveecoupons" title="Facebook"></a></li>
                            <li class="tw"><a target="_blank" rel="nofollow" href="https://twitter.com/saveecoupons" title="Twitter"></a></li>
                            <li class="pintrest"><a target="_blank" rel="nofollow" href="https://www.pinterest.com/saveecoupons" title="PInterest"></a></li>
                            <li class="instagram"><a target="_blank" rel="nofollow" href="https://www.instagram.com/saveecoupons" title="Instagram"></a></li>
                        </ul>
                    </div>
                    <p align="justify" style="font-size:17px;color:black;">{!! $storeSetting->DefaultContent !!}</p>
                    @if(isset($store->ContentLinkText))
                    <a target="_blank" rel="nofollow" href="<?php echo $store->StoreNetworkLink; ?>">{{$store->ContentLinkText}}</a>
                    @else
                    <a target="_blank" rel="nofollow" href="<?php echo $store->StoreNetworkLink; ?>">{{$store->SEOStoreName}} coupons</a>
                    @endif
                    <br /><br />
                    <p align="justify" style="font-size:17px;color:black;">{!! $store->Description2 !!}<br />{!! $store->Description1 !!}</p>

                </div>


                <div class="sidebar-module-container">
                    <div class="sidebar-filter">
                        <!-- ============================================== SIDEBAR CATEGORY ============================================== -->
                        <div class="sidebar-widget wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">
                            <h2 class="section-title">{{$storeSetting->RelatedStoreHeading}}</h2>
                            <!-- <div class="widget-header">
                                <h4 class="widget-title">Category</h4>
                            </div> -->
                            <p style="margin-top: 10px !important;">
                                {{$storeSetting->RelatedStoresText}}
                            </p>
                            @if(isset($relatedStores))
                            <div class="sidebar-widget-body">
                                <ul class="list list-bordered">
                                    @foreach($relatedStores as $relatedStore)
                                    <li><a href="{{ url('view/'.$relatedStore->SearchName) }}">{{$relatedStore->SEOStoreName}}</a></li>
                                    @endforeach
                                </ul>
                                <!--<a href="#" class="lnk btn btn-primary">Show Now</a>-->
                            </div>
                            @endif
                            <!-- /.sidebar-widget-body -->
                        </div>
                        <!-- /.sidebar-widget -->
                        <!-- ============================================== SIDEBAR CATEGORY : END ============================================== -->




                    </div>
                    <!-- /.sidebar-filter -->
                </div>
                <!-- /.sidebar-module-container -->

                <div class="whitepanel mb-10 text-center" style="margin-top:10px; padding: 0px;padding-bottom: 10px;">
                    <h4 class="">{{$storeSetting->SubscribeToEmailHeading}}</h4>

                    <section class="section subscribe-area ">
                        <div class="newsletter-form">
                            <h5 class="mb-20"><i class="fa fa-envelope-o color-green mr-10"></i>{{$storeSetting->SubscribeToEmailText}}</h5>
                            <form id="subscribeForm" style="padding-left: 10px;padding-right: 10px;" action="{{ route('site.subscribe') }}" method="post">
                                @csrf
                                <div class="input-group mb-10">
                                    <input type="email" name="Email" id="Email" class="form-control bg-white" placeholder="{{$storeSetting->EmailAddressTranslate}}" required="">
                                    <span class="input-group-btn">
                                        <button class="btn" type="submit">{{$storeSetting->SubscribeTranslate}}</button>
                                    </span>
                                </div>
                            </form>
                            <p class="color-muted"><small>{{$storeSetting->SubscribeToEmailFooter}}</small> </p>
                        </div>
                    </section>

                </div>
                <div class="whitepanel mb-10 text-center" style="padding: 0px;padding-bottom: 10px;">
                    <h4 class="">{{$storeSetting->GotQuestionHeading}}
                    </h4>

                    <section class="section subscribe-area ">
                        <div class="drop-email" style="padding-left: 10px;padding-right: 10px;">
                            <h5 class="mb-20">{{$storeSetting->GotQuestionText}}</h5>
                            <a href="{{ url('contactus')}}" class="btn btn-block"><i class="mr-10 font-15 fa fa-envelope-o"></i>{{$storeSetting->DropLineTranslate}}</a>

                        </div>
                    </section>

                </div>



                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5358982852113526" crossorigin="anonymous"></script>
                <!-- Link Add_Responsive -->
                <ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-5358982852113526" data-ad-slot="8723944855" data-ad-format="auto" data-full-width-responsive="true"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>



            </div>
        </div>
    </div>
</div>
<div class="my-sizer-element"></div>

@endsection