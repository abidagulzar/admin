<div class="col-md-12">
    <div class="category-product stores-list">
        <div class="row coupons-deals">
            @foreach($stores as $store)
            <div class="col-sm-6 col-md-6 col-lg-6 wow fadeInUp">
                <div class="item">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 logo-img">
                            <img class="img-responsive" src="{{ url('/storage/storelogo').'/'.$store->LogoUrl }}" alt="">
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">
                            <h3><a href="{{ url('view/'.$store->SearchName) }}">{{$store->Name}}</a></h3>
                            <p>{!! substr($store->Description1, 0, 100) !!}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>