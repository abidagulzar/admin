@if(isset($stores))
@if(count($stores) > 0)
<ul class="dropdown">
    @foreach($stores as $store)
    <li><a href="{{ url('view/'.$store->SearchName) }}">{{$store->SEOStoreName}}</a></li>
    @endforeach
</ul>
@endif
@endif