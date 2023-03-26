@extends('Site.Layout.master')

@section('metadata')
<meta name="description" content="{{$homeSetting->Description}}">
<meta name="keywords" content="{{$homeSetting->Keywords}}">
<title>{{$homeSetting->Title}}</title>
@endsection

@section('specialevents')
@include('Site.Layout.specialeventsmenue', ['specialPage' => $specialPage])
@endsection

@section('footer')
@include('Site.Layout.footer', ['SmallFooterText' => $homeSetting->Footer,'relatedSearch' => $relatedSearch,'relatedSearchKeyword' => ''])
@endsection


@section('content')



<div class="body-content outer-top-ts">
    <div class='container'>
        <section class="stores-area stores-area-v2">
            <div class="row mb-40">
                <div class="whitepanel">
                    <div class="col-md-12 col-sm-12">
                        <h4 class="">VIEW DEALS BY STORE</h4>
                        <div class="letters-toolbar p-10 panel mb-40 no-border">

                            <?php $a = range("A", "Z"); ?>
                            <?php foreach ($a as $char) : ?>
                                <span><a href="{{ '/stores/'.$char }}">
                                        <?php echo $char; ?>
                                    </a></span>
                            <?php endforeach; ?>
                            <span><a href="{{ '/stores/'.'num' }}">
                                    #
                                </a></span>

                        </div>
                    </div>
                </div>
            </div>

            <div class='row'>
                @include('Site.Store.storelistpartial', ['stores' => $stores])
            </div>
        </section>
    </div>

</div>

@endsection