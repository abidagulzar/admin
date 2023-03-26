@extends('Site.Layout.master')

@section('metadata')
<meta name="description" content="{{$homeSetting->Description}}">
<meta name="keywords" content="{{$homeSetting->Keywords}}">
<title>{{$homeSetting->Title}}</title>
@endsection


@section('footer')
@include('Site.Layout.footer', ['SmallFooterText' => $homeSetting->Footer,'relatedSearch' => $relatedSearch,'relatedSearchKeyword' => ''])
@endsection


@section('specialevents')
@include('Site.Layout.specialeventsmenue', ['specialPage' => $specialPage])
@endsection


@section('content')

<div class="body-content outer-top-ts">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="sign-in-page">
                    <div class="row">
                        <!-- Sign-in -->
                        <div class="col-md-6 col-sm-6 sign-in">
                            <h4 class="">Reviews</h4>
                            <p class="" style="color: #3e3439 !important;">@if(isset($siteInfo)){!! $siteInfo->SuggestionText !!}@endif</p>
                            <h4 class="mb-20"><i class="fa fa-envelope-o color-green mr-10"></i><a href="mailto:support@saveecoupons.com">support@saveecoupons.com</a></h4>

                            <div class="social">
                                <ul class="link">
                                    <li class="fb"><a target="_blank" rel="nofollow" href="https://web.facebook.com/saveecoupons" title="Facebook"></a></li>
                                    <li class="tw"><a target="_blank" rel="nofollow" href="https://twitter.com/saveecoupons" title="Twitter"></a></li>
                                    <li class="pintrest"><a target="_blank" rel="nofollow" href="https://www.pinterest.com/saveecoupons" title="PInterest"></a></li>
                                    <li class="instagram"><a target="_blank" rel="nofollow" href="https://www.instagram.com/saveecoupons" title="Instagram"></a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- Sign-in -->

                        <!-- create a new account -->
                        <div class="col-md-6 col-sm-6 create-new-account">
                            @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                            @endif

                            <h4 class="checkout-subtitle">GET IN TOUCH</h4>
                            <form class="register-form outer-top-xs" role="form" action="{{ route('site.contactuspost') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label>Review for Savee Coupons</label>
                                    <textarea rows="5" class="form-control" name="Message" id="Message" required></textarea>
                                </div>
                                <input id="IsSuggestion" name="IsSuggestion" class="hidden" value="1" />
                                <button type="submit" class="btn-upper btn btn-primary checkout-page-button">Send</button>
                            </form>


                        </div>
                        <!-- create a new account -->
                    </div><!-- /.row -->
                </div>

            </div>
        </div>
    </div>
</div>


@endsection
@section('pagescripts')
<script>
    $(document).ready(function() {
        // show the alert
        setTimeout(function() {
            $(".alert").alert('close');
        }, 2000);
    });
</script>
@endsection