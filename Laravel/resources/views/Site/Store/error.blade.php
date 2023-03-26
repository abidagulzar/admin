@extends('Site.Layout.master',['lang' => $storeSetting->Lang])

@section('metadata')
<meta name="description" content="{{$storeSetting->Description}}">
<meta name="keywords" content="{{$storeSetting->Keywords}}">
<title>{{$storeSetting->Title}}</title>
<meta property="og:url" content="{{ url('view/'.$store->SearchName) }}" />
<meta property="og:title" content="{{$storeSetting->Title}}" />
<meta property="og:description" content="{{$storeSetting->Description}}" />
<meta property="og:image" content="{{ url('/storage/storelogo').'/'.$store->LogoUrl }}" />
<link rel="canonical" href="{{ url('view/'.$store->SearchName) }}" />

@endsection




@section('content')
{{$errorCode}}
{{$errorMessage}}


@endsection