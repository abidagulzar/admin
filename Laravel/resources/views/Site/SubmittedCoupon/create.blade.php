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

@section('pagestyles')

<link rel="stylesheet" href="{{ URL::asset('site/assets/css/chosen.min.css')}}">
<link rel="stylesheet" href="{{ URL::asset('site/assets/css/bootstrap-datepicker3.css')}}" />

@endsection

@section('content')

<div class="body-content outer-top-ts">
    <div class="container">
        <div class="row">
            <div class="col-md-12">


                <div class="row">
                    <div class="col-md-12">
                        <div class="sign-in-page">
                            <h2 class="heading-title text-uppercase">Submit Coupon</h2>
                            <div class="col-lg-offset-3 col-md-offset-3 col-lg-6 col-md-6 col-sm-12 col-xs-12 create-new-account">
                                @if(session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                                @endif
                                <form class="register-form outer-top-xs" role="form" action="{{ route('site.submittedcoupon') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label class="info-title" for="StoreWebsite">Store Website <span>*</span></label>
                                        <select style="width:100%" id="StoreWebsite" name="StoreWebsite" class="chosen-select">


                                            @if(isset($stores))
                                            @foreach($stores as $StoreId => $Name)
                                            {{ $seleced = '' }}

                                            <option value="{{ $StoreId }}">{{ $Name }}</option>

                                            @endforeach
                                            @endif

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="info-title" for="Code">Code </label>
                                        <input type="text" class="form-control unicase-form-control text-input" name="Code" id="Code">
                                    </div>

                                    <div class="form-group">
                                        <label>Discount Description <span>*</span></label>
                                        <textarea rows="5" class="form-control" name="DiscountDescription" id="DiscountDescription" required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label class="info-title" for="ExpiryDate">Expiry Date</label>
                                        <input autocomplete="off" class="form-control unicase-form-control text-input" placeholder="DD/MM/YYYY" type="text" name="ExpiryDate" id="ExpiryDate">
                                    </div>

                                    <button type="submit" class="btn-upper btn btn-primary checkout-page-button">Submit Offer</button>
                                </form>


                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>


@endsection

@section('pagescripts')
<script src="{{ URL::asset('site/assets/js/chosen.jquery.min.js')}}"></script>

<script type="text/javascript" src="{{ URL::asset('site/assets/js/bootstrap-datepicker.min.js')}}"></script>

<script>
    function updateSelectTochosen(id) {
        $(" select").removeClass("chosen-select").addClass("chosen-select");
        var config = {
            '.chosen-select': {},
            '.chosen-select-deselect': {
                allow_single_deselect: true
            },
            '.chosen-select-no-single': {
                disable_search_threshold: 10
            },
            '.chosen-select-no-results': {
                no_results_text: 'Oops, nothing found!'
            },
            '.chosen-select-rtl': {
                rtl: true
            },
            '.chosen-select-width': {
                width: '95%'
            }
        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }
    }
    $(function() {
        var date_input = $('input[name="ExpiryDate" ]'); //our date input has the name "date" 
        var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
        var options = {
            format: 'dd/mm/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,
        };
        date_input.datepicker(options);
        updateSelectTochosen();

        setTimeout(function() {
            $(".alert").alert('close');
        }, 2000);
    });
</script>
@endsection