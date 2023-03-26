<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">

        <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <div>
                <img class="img-responsive" src="{{ url('/storage/storelogo').'/'.$Model->StoreLogoUrl }}" alt="">
                <h3 class="mb-20">{{$Model->Header}}</h3>
                <div class="coupon-content">{{$Model->Description}}
                    <span style="color: #ed6663; display:block; margin-top:10px;"><a style="color: #ed6663; text-decoration:underline" href="{{ $Model->CouponUrl }}" target="_blank">{{$storeSetting->VisitOurStore}}</a></span>
                </div>

            </div>

            <div>
                @if($Model->Code == '')
                <h6 class="color-mid">{{ $storeSetting->NoCodeNeeded }}</h6>
                <div class="copy-coupon-wrap">
                    <a class="coupon-code" href="{{ $Model->CouponUrl }}" target="_blank">{{ $storeSetting->ContinueToStore }}</a>
                    <br />
                    <span style="color: #ed6663; display:block; margin-top:10px;"><a style="color: #ed6663; text-decoration:underline" href="{{ url('suggestion') }}" target="_blank">Feedback for Savee Coupons</a></span>
                </div>

                @else
                <h6 class="color-mid">{{$storeSetting->ClickBelowTextAndPast}} <a href="{{ $Model->CouponUrl }}" target="_blank">{{$Model->StoreName}}.com</a></h6>
                <br />
                <span style="color: #ed6663; display:block; margin-top:10px;"><a style="color: #ed6663; text-decoration:underline" href="{{ url('suggestion') }}" target="_blank">Feedback for Savee Coupons</a></span>
                <div class="copy-coupon-wrap">
                    <input type="text" value="{{$Model->Code}}" readonly style="cursor: pointer;" class="coupon-code js-textareacopybtn js-copytextarea">
                </div>
                @endif
            </div>
        </div>

        <div class="modal-footer">
            <h4>{{$storeSetting->SubscribeToEmailHeading}}</h4>
            <p>{{$storeSetting->SubscribeToEmailText}}</p>
            <div class="newsletter-form1">
                <form id="subscribeForm1" class="mc4wp-form mc4wp-form-1257" action="{{ route('site.subscribe') }}" method="post">
                    @csrf
                    <div class="mc4wp-form-fields">
                        <div id="container_form_news">
                            <div id="container_form_news2">
                                <input type="Email" id="newsletter1" name="Email" placeholder="{{$storeSetting->EmailAddressTranslate}}" required>
                                <button type="submit" class="button subscribe"><span>{{$storeSetting->SubscribeTranslate}}</span></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>


    </div>

</div>