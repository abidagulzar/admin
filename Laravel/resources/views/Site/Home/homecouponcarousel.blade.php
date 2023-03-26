<div class="item item-carousel">
    @if(isset($homeCoupon1))
    <div class="products">
        <div class="product">
            <div class="product-image">
                <div class="image">
                    <img class="img-responsive" src="{{ url('/storage/storelogo').'/'.$homeCoupon1->StoreLogoUrl }}" alt="">
                    <div class="brand">{{$homeCoupon1->StoreName}}</div>
                    <h3 class="name"><a data-affiliateurl="{{$homeCoupon1->CouponUrl}}" data-url="{{ route('site.couponPopUpUrl', ['store' => $homeCoupon1->StoreName,'couponid' => $homeCoupon1->CouponId]) }}" onclick="onCopounClick(this)">{{$homeCoupon1->Header}}</a></h3>

                </div>
                <!-- /.image -->


            </div>
            <!-- /.product-image -->

            <div class="product-info text-left">
                <div class="discount">{{$homeCoupon1->OFF}} <span>OFF</span></div>
                <div class="show-code"><a data-affiliateurl="{{$homeCoupon1->CouponUrl}}" data-url="{{ route('site.couponPopUpUrl', ['store' => $homeCoupon1->StoreName,'couponid' => $homeCoupon1->CouponId]) }}" onclick="onCopounClick(this)">Show Code</a></div>
                <p class="exp-date"><i class="fa fa-clock-o"></i> {{empty($homeCoupon1->ExpiryDate) ||$homeCoupon1->IsUnknownOutGoing == 1 ? 'Unknown/Ongoing':'Expires on '.date('d/m/Y', strtotime($homeCoupon1->ExpiryDate)) }}</p>
            </div>

        </div>
        <!-- /.product -->

    </div>
    @endif
    @if(isset($homeCoupon2))
    <div class="products">
        <div class="product">
            <div class="product-image">
                <div class="image">
                    <img class="img-responsive" src="{{ url('/storage/storelogo').'/'.$homeCoupon2->StoreLogoUrl }}" alt="">
                    <div class="brand">{{$homeCoupon2->StoreName}}</div>
                    <h3 class="name"><a data-affiliateurl="{{$homeCoupon2->CouponUrl}}" data-url="{{ route('site.couponPopUpUrl', ['store' => $homeCoupon2->StoreName,'couponid' => $homeCoupon2->CouponId]) }}" onclick="onCopounClick(this)">{{$homeCoupon2->Header}}</a></h3>

                </div>
                <!-- /.image -->


            </div>
            <!-- /.product-image -->

            <div class="product-info text-left">
                <div class="discount">{{$homeCoupon2->OFF}} <span>OFF</span></div>
                <div class="show-code"><a data-affiliateurl="{{$homeCoupon2->CouponUrl}}" data-url="{{ route('site.couponPopUpUrl', ['store' => $homeCoupon2->StoreName,'couponid' => $homeCoupon2->CouponId]) }}" onclick="onCopounClick(this)">Show Code</a></div>
                <p class="exp-date"><i class="fa fa-clock-o"></i> {{empty($homeCoupon2->ExpiryDate) ||$homeCoupon2->IsUnknownOutGoing == 1 ? 'Unknown/Ongoing':'Expires on '.date('d/m/Y', strtotime($homeCoupon2->ExpiryDate)) }}</p>
            </div>

        </div>
        <!-- /.product -->

    </div>
    @endif
</div>