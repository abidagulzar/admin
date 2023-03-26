<li class="dropdown"> <a href="#" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown">Special Events</a>
    <ul class="dropdown-menu pages">
        <li>
            <div class="yamm-content">
                <div class="row">
                    <div class="col-xs-12 col-menu">
                        <ul class="links">
                            @foreach($specialPage as $sP)
                            <li><a href="{{ url('event/'.$sP->URL) }}">{{$sP->Name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</li>