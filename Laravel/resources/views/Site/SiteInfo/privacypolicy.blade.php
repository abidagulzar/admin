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

                <div class="checkout-box faq-page">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="heading-title text-uppercase">Privacy Policy</h2>
                            {!! $siteInfo->PrivacyPolicy !!}
                        </div>
                    </div><!-- /.row -->
                </div>

            </div>
        </div>
    </div>
</div>


@endsection