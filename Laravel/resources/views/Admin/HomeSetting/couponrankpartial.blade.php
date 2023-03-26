@if(isset($copouns))
@foreach($copouns as $coupon)

<li class="list" id="{{$coupon->CouponId}}" data-rank="{{$coupon->GlobalRank}}">
    {{$coupon->Header}}
    <p>{{$coupon->Code}}</p>
    <p>Expiry Date:
        @if ($coupon->IsUnknownOutGoing == 1)
        Unknown/Ongoing
        @elseif (isset($coupon->ExpiryDate))
        {{$coupon->ExpiryDate}}
        @else
        Unknown
        @endif
    </p>
</li> @endforeach @endif