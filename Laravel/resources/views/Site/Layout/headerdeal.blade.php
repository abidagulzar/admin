<div class="cnt-account cur-pointer" data-affiliateurl="{{$headerdeal->CouponUrl}}" data-url="{{ route('site.couponPopUpUrl', ['store' => $storeName,'couponid' => $headerdeal->CouponId]) }}" onclick="onCopounClick(this)">

    <div class="box-timer">
        <h5 class="blink" style="color: #FFF">{{$headerdeal->Header}}</h5>
        @if(isset($headerdeal->ExpiryDate))
        <div class="countbox_1 timer-grid" id="countbox_1" data-enddtime="{{is_null($headerdeal->ExpiryDate) ? '': date('m/d/Y h:i:s A', strtotime($headerdeal->ExpiryDate)) }}"></div>
        @endif
    </div>

</div>