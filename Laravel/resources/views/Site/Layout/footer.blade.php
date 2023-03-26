@if(isset($topStores))
<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
        <div class="whitepanel popular">
            <h5>Popular Stores</h5>
            <hr>
            <section>
                @foreach($topStores as $topStore)
                <a href="{{ url('view/'.$topStore->SearchName) }}">{{$topStore->Name}}</a>
                @endforeach
            </section>
        </div>
    </div>
</div>
@endif
@if(isset($topCategories))
<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
        <div class="whitepanel popular">
            <h5>Popular Categories</h5>
            <hr>
            <section>
                @foreach($topCategories as $topCategory)
                <a href="{{ url('category/'.$topCategory->SearchName) }}">{{$topCategory->Name}}</a>
                @endforeach
            </section>
        </div>
    </div>
</div>
@endif


<!-- ============================================================= FOOTER ============================================================= -->
<footer id="footer" class="footer color-bg">
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="module-heading">
                        @if(isset($SpecialPagesHeading))
                        <h4 class="module-title">{{$SpecialPagesHeading}}</h4>
                        @else
                        <h4 class="module-title">SPECIALTY PAGES</h4>
                        @endif
                    </div>
                    <!-- /.module-heading -->

                    <div class="module-body">
                        <ul class='list-unstyled'>
                            <li class="first"><a href="#" title="Travel Coupons & Deals">Travel Coupons & Deals</a></li>
                            <li><a href="#" title="Summer Deals & Sales">Summer Deals & Sales</a></li>
                            <li><a href="#" title="Cyber Monday Deals">Cyber Monday Deals</a></li>
                            <li><a href="#" title="Valentine's Day Deals">Valentine's Day Deals</a></li>
                            <li class="last"><a href="#" title="Halloween Deals & Sales">Halloween Deals & Sales</a></li>
                        </ul>
                    </div>
                    <!-- /.module-body -->
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="module-heading">
                        @if(isset($ConnectTranslate))
                        <h4 class="module-title">{{$ConnectTranslate}}</h4>
                        @else
                        <h4 class="module-title">CONNECT</h4>
                        @endif
                    </div>
                    <!-- /.module-heading -->

                    <div class="module-body">
                        <ul class='list-unstyled'>
                            <li class="first"><a href="https://web.facebook.com/saveecoupons" target="_blank" rel="nofollow" title="Facebook">Facebook</a></li>
                            <li><a href="https://twitter.com/saveecoupons" target="_blank" rel="nofollow" title="Twitter">Twitter</a></li>
                            <li><a href="https://www.pinterest.com/saveecoupons" target="_blank" rel="nofollow" title="PInterest">PInterest</a></li>
                            <li class="last"><a href="https://www.instagram.com/saveecoupons" target="_blank" rel="nofollow" title="Instagram">Instagram</a></li>
                        </ul>
                    </div>
                    <!-- /.module-body -->
                </div>
                <!-- /.col -->

                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="module-heading">
                        @if(isset($ConnectTranslate))
                        <h4 class="module-title">{{$GeneralTranslate}}</h4>
                        @else
                        <h4 class="module-title">General</h4>
                        @endif
                    </div>
                    <!-- /.module-heading -->

                    <div class="module-body">
                        <ul class='list-unstyled'>
                            <li class="first"><a title="Blog" href="{{ url('blog') }}" target="_blank">Blog</a></li>
                            <li><a title="Submit Coupon" href="{{ url('submitcoupon') }}" target="_blank">Submit Coupon</a></li>
                            <li class="last"><a title="Contact Us" href="{{ url('contactus') }}" target="_blank">Contact Us</a></li>
                            <li class="last"><a title="About Us" href="{{ url('aboutus') }}" target="_blank">About Us</a></li>
                            <li class="last"><a title="Sitemap" href="{{ url('sitemap.xml') }}" target="_blank">Sitemap</a></li>
                        </ul>
                    </div>
                    <!-- /.module-body -->
                </div>
                <!-- /.col -->

                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div class="module-heading">
                        @if(isset($ConnectTranslate))
                        <h4 class="module-title">{{$RelatedSearchesTranslate}}</h4>
                        @else
                        <h4 class="module-title">RELATED SEARCHES</h4>
                        @endif
                    </div>
                    <!-- /.module-heading -->

                    <div class="module-body">
                        <ul class='list-unstyled'>

                            @if(isset($customRelatedSearch))
                            @foreach($customRelatedSearch as $rS)
                            <li><a href="#" title="{{$rS}}">{{$rS}}</a></li>
                            @endforeach
                            @else
                            @foreach($relatedSearch as $rS)
                            <li><a href="#" title="{{$relatedSearchKeyword.' '.$rS->Value}}">{{$relatedSearchKeyword.' '.$rS->Value}}</a></li>
                            @endforeach
                            @endif

                        </ul>
                    </div>
                    <!-- /.module-body -->
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-bar white-bg">
        <div class="container">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                {{$SmallFooterText}}
            </div>
        </div>
    </div>
    <div class="copyright-bar">
        <div class="container">
            <div class="col-xs-12 col-sm-12 no-padding social">
                <ul class="link">
                    <li class="fb"><a target="_blank" rel="nofollow" href="https://web.facebook.com/saveecoupons" title="Facebook"></a></li>
                    <li class="tw"><a target="_blank" rel="nofollow" href="https://twitter.com/saveecoupons" title="Twitter"></a></li>
                    <li class="pintrest"><a target="_blank" rel="nofollow" href="https://www.pinterest.com/saveecoupons" title="PInterest"></a></li>
                    <li class="instagram"><a target="_blank" rel="nofollow" href="https://www.instagram.com/saveecoupons" title="Instagram"></a></li>

                    <!-- <li class="linkedin"><a target="_blank" rel="nofollow" href="#" title="Linkedin"></a></li>
                        <li class="youtube"><a target="_blank" rel="nofollow" href="#" title="Youtube"></a></li>
                    -->
                </ul>
            </div>
            <div class="col-xs-12 col-sm-12 no-padding copyright">&copy; {{date("Y")}} Saveecoupons. All Rights Reserved. <a href="{{ url('termsofuse') }}" target="_blank">Terms &amp; Conditions</a> | <a href="{{ url('privacypolicy') }}" target="_blank">Privacy Policy</a> </div>
        </div>
    </div>
</footer>
<!--=============================================================FOOTER : END=============================================================-->