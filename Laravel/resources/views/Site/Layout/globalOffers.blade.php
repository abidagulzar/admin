@foreach($globalOffers as $globalOffer)
<div class="slide-out-div" style="z-index: 1000;">
    <div class="action-content custome-scrollbar">
        <a class="handle" style="top: {{ (($loop->iteration - 1) * 175)+75 }}px;" data-affiliateurl="{{$globalOffer->CouponUrl}}" data-url="{{ route('site.couponPopUpUrl', ['store' => 'Global','couponid' => $globalOffer->CouponId]) }}" onclick="onCopounClick(this)" aria-expanded="false">
            <!-- <span class="fa fa-angle-up"></span> -->
            <span class="label">{{$globalOffer->Header}}</span>
        </a>
    </div>
</div>
@endforeach