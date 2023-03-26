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
            <div class="whitepanel">
                <div class="row">
                    <!-- Sign-in -->
                    <div class="col-md-12 col-sm-12">
                        <h4 class="">VIEW DEALS BY CATEGORY</h4>

                        <div class="letters-toolbar p-10 panel mb-40 no-border">

                            <?php $a = range("A", "Z"); ?>
                            <?php foreach ($a as $char) : ?>
                                <span><a href="<?php echo '#str-' . $char; ?>">
                                        <?php echo $char; ?>
                                    </a></span>
                            <?php endforeach; ?>

                        </div>

                        @foreach ($a as $ltr)


                        <h4 id="str-{{$ltr}}" class="">{{$ltr}}</h4>

                        <ul class="row stores-cat-body">
                            @foreach ($categories as $category)
                            @if(substr(strtoupper($category->Name), 0, 1 ) == $ltr)
                            <li class="col-sm-4"><a href="{{ url('category/'.$category->SearchName) }}">
                                    {{$category->Name}} </a> </li>
                            @else
                            @continue
                            @endif
                            @endforeach
                        </ul>


                        @endforeach


                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

@endsection