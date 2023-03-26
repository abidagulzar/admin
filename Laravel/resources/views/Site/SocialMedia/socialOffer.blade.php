@extends('Site.Layout.master',['lang' => $storeSetting->Lang])

@section('metadata')
<meta name="description" content="{{$socialMediaEntity->Description}}">
<meta name="keywords" content="{{$storeSetting->Keywords}}">
<title>{{$socialMediaEntity->Title}}</title>


<meta property="og:image" content="{{ url('/storage/socialmedia').'/'.$socialMediaEntity->SocialImage }}" />
<meta property="og:title" content="{{$socialMediaEntity->Title}}" />
<meta property="og:description" content="{{$socialMediaEntity->Description}}" />

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:image" content="{{ url('/storage/socialmedia').'/'.$socialMediaEntity->SocialImage }}" />
<meta name="twitter:title" content="{{$socialMediaEntity->Title}}" />
<meta name="twitter:description" content="{{$socialMediaEntity->Description}}" />

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
        <div class='row single-product'>
            <!-- /.sidebar -->
            <div class='col-md-12'>

                <div class="detail-block">
                    <div class="row  wow fadeInUp">

                        <div class="col-xs-12 col-sm-5 col-md-4 gallery-holder">
                            <img onclick="openInNewTab(this)" data-url="{{$socialMediaEntity->AffiliateUrlToRedirect}}" class="img-responsive cur-pointer" src="{{ url('/storage/socialmedia').'/'.$socialMediaEntity->SocialImage }}" alt="{{$socialMediaEntity->Title}}">
                        </div><!-- /.gallery-holder -->
                        <div class='col-sm-7 col-md-5 product-info-block'>
                            <div class="product-info">
                                <h1 class="name cur-pointer" onclick="openInNewTab(this)" data-url="{{$socialMediaEntity->AffiliateUrlToRedirect}}">{{$socialMediaEntity->Title}}</h1>

                                <div class="rating-reviews m-t-20 hidden">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="pull-left">
                                                <div class="rating rateit-small"></div>
                                            </div>
                                            <div class="pull-left">
                                                <div class="reviews">
                                                    <a href="#" class="lnk">(13 Reviews)</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.row -->
                                </div><!-- /.rating-reviews -->




                                <div class="quantity-container info-container">
                                    <div class="row">
                                        <div class="add-btn">
                                            <a onclick="openInNewTab(this)" data-url="{{$socialMediaEntity->AffiliateUrlToRedirect}}" class="btn btn-primary cur-pointer"><i class="fa fa-shopping-cart inner-right-vs"></i> Buy Now</a>
                                        </div>


                                    </div><!-- /.row -->
                                </div><!-- /.quantity-container -->






                            </div><!-- /.product-info -->
                        </div><!-- /.col-sm-7 -->
                        <div class="col-lg-3 col-sm-12 col-md-3">
                            <div class="store-details">
                                <img class="img-responsive cur-pointer" onclick="openInNewTab(this)" data-url="{{$store->StoreNetworkLink}}" src="{{ url('/storage/storelogo').'/'.$store->LogoUrl }}" alt="{{$store->SEOStoreName}}">
                                <h2><a href="{{$store->StoreNetworkLink}}" target="_black">{{$store->SEOStoreName}}</a></h2>
                            </div>
                        </div>
                    </div><!-- /.row -->

                    @if(isset($store->ContentLinkText))
                    <a target="_blank" rel="nofollow" href="{{ url('view/'.$store->SearchName) }}">{{$store->ContentLinkText}}</a>
                    @else
                    <a target="_blank" rel="nofollow" href="{{ url('view/'.$store->SearchName) }}">{{$store->SEOStoreName}} coupons</a>
                    @endif
                </div>


                <!-- ============================================== RELATED PRODUCTS ============================================== -->
                <section class="section wow fadeInUp">
                    <h3 class="section-title">Related Offers</h3>



                    <div class="row">
                        <div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
                            <div class="category-product coupons-section coupons-section-inner">
                                <div id="storedeals" class="row coupons-deals">
                                    @if(count($storeCoupons)>0)
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
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">

                            @if(isset($cpcStores))
                            @if(count($cpcStores)>0)
                            <div class="sidebar-module-container">
                                <div class="sidebar-filter">
                                    <!-- ============================================== SIDEBAR CATEGORY ============================================== -->
                                    <div class="sidebar-widget wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">
                                        <h2 class="section-title">Stores in this Region</h2>


                                        <div class="sidebar-widget-body">
                                            <ul class="list list-bordered">
                                                @foreach($cpcStores as $cpcStore)
                                                <li><a href="{{ $cpcStore->TrackURL }}" target="_blank">{{$cpcStore->SEOStoreName}}</a></li>
                                                @endforeach
                                            </ul>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            @endif
                            @endif
                            <div class="sidebar-module-container">
                                <div class="sidebar-filter">
                                    <!-- ============================================== SIDEBAR CATEGORY ============================================== -->
                                    <div class="sidebar-widget wow fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">
                                        <h2 class="section-title">Same Category Stores</h2>

                                        @if(isset($relatedStores))
                                        <div class="sidebar-widget-body">
                                            <ul class="list list-bordered">
                                                @foreach($relatedStores as $relatedStore)
                                                <li><a href="{{ url('view/'.$relatedStore->SearchName) }}">{{$relatedStore->SEOStoreName}}</a></li>
                                                @endforeach
                                            </ul>

                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>



                </section>
                <!-- /.section -->
                <!-- ============================================== RELATED PRODUCTS : END ============================================== -->
            </div>
        </div>
    </div>

</div>


<div class="my-sizer-element"></div>

@endsection