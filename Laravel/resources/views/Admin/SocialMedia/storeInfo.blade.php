<div class="jarviswidget" id="createCouponWidget" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">

    <header>
        <h2>Store Info </h2>
    </header>

    <!-- widget div-->

    <div>
        <!-- widget edit box -->
        <div class="jarviswidget-editbox">
            <!-- This area used as dropdown edit box -->
            <input class="form-control" type="text">
        </div>
        <!-- end widget edit box -->

        <!-- widget content -->
        <div class="widget-body">

            <form id="updateStoreForm" action="" enctype="multipart/form-data">

                <fieldset>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="control-label">Store Name</label>
                            <input type="text" class="form-control" name="Name" value="{{old('Name', $Model->Name)}}" placeholder="Store Name" data-bv-group=".col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="control-label">Store Site Url</label>

                            <input type="text" class="form-control" name="SiteUrl" value="{{ old('SiteUrl', $Model->SiteUrl) }}" placeholder="Store Site Url" data-bv-group=".col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required" />

                        </div>
                    </div>

                </fieldset>
                <fieldset>


                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="control-label">Store Network Link</label>
                            <input type="text" class="form-control" id="StoreNetworkLink" name="StoreNetworkLink" value="{{ old('StoreNetworkLink', $Model->StoreNetworkLink) }}" data-bv-group=".col-md-6" placeholder="Store Network Link" data-bv-notempty="true" data-bv-notempty-message="Information Required" />

                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="control-label">Category</label>
                            <select multiple style="width:100%" id="CategoryId" name="CategoryId[]" class="select2" data-bv-group=".col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required">

                                @if(isset($categories))
                                @foreach($categories as $CategoryId => $Name)
                                {{ $seleced = '' }}

                                <option value="{{ $CategoryId }}" {{ (collect(old('CategoryId',$storecategories))->contains($CategoryId)) ? 'selected':'' }}>{{ $Name }}</option>

                                @endforeach
                                @endif

                            </select>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="control-label">Deal Description</label>
                            <select style="width:100%" id="DealDescription" onchange="onDealDescriptionChange()" class="select2" data-bv-group=".col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required">

                                <option value="Save your money up to *(required)*% OFF with your order at <?php echo str_replace(".com", "", $Model->Name); ?>.com! Use this provided <?php echo str_replace(".com", "", $Model->Name); ?> Promo Code at checkout and enjoy your discount now.">Promo Code 1</option>
                                <option value="There is an amazing chance of saving up to*(required)*% discount on your all orders just at <?php echo str_replace(".com", "", $Model->Name); ?>.  Use this <?php echo str_replace(".com", "", $Model->Name); ?> Coupon Code and save your money.">Coupon Code 2</option>
                                <option value="Grab flat *(required)* OFF on your order at <?php echo str_replace(".com", "", $Model->Name); ?>! You can only get this flat discount by the use of <?php echo str_replace(".com", "", $Model->Name); ?> Voucher Code.">Voucher Code 3</option>
                                <option value="Amazing opportunity for savings i.e. up to *(required)* % OFF with <?php echo str_replace(".com", "", $Model->Name); ?> Coupon Code.">Coupon Code 4</option>
                                <option value="<?php echo str_replace(".com", "", $Model->Name); ?> offering  upto *(required)*% OFF on *(required)* Products. Just use <?php echo str_replace(".com", "", $Model->Name); ?> Coupon Code  at checkout and get discount instantly on your order.">Coupon Code 5</option>
                                <option value="Don’t miss this chance for up to *(required)*% savings at <?php echo str_replace(".com", "", $Model->Name); ?>.com! There is no need for <?php echo str_replace(".com", "", $Model->Name); ?> Coupon Code just visit the site and enjoy discount now.">Offer/Deal 1</option>
                                <option value="Hurry Up for not missing this amazing discount of up to *(required)*% OFF just at <?php echo str_replace(".com", "", $Model->Name); ?>.com! Don’t miss this amazing chance and get discount now by clicking on Get Deal !!.">Offer/Deal 2</option>
                                <option value="Flat sale up to *(required)*% OFF on your orders at  <?php echo str_replace(".com", "", $Model->Name); ?>.  No worry about searching any <?php echo str_replace(".com", "", $Model->Name); ?> Coupon Code just click on shop now and grab discount now.">Offer/Deal 3</option>
                                <option value="Wanna *(required)*% OFF or more discount with your order at <?php echo str_replace(".com", "", $Model->Name); ?>? Don’t worry just click on shop now and enjoy savings according to your want.">Offer/Deal 4</option>
                                <option value="Grab up to *(required)*% OFF on your order at <?php echo str_replace(".com", "", $Model->Name); ?>.com! Try not to miss this amazing offer that’s why hurry up and shop your needs now.">Offer/Deal 5</option>
                                <option value="Looking for *(required)*% OFF for saving your money with buying products from  <?php echo str_replace(".com", "", $Model->Name); ?>? So don’t need to wait more because you can get discount as much as you wants  by just clicking on shop now.">Offer/Deal 6</option>

                            </select>
                        </div>
                    </div>

                </fieldset>

        </div>
    </div>
</div>
<script>
    function onDealDescriptionChange() {
        $("[name='Description']").html($("#DealDescription").val());
    }
</script>