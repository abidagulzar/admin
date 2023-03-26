@extends('Admin.Layout.master')
@section('pagebreadcrumb')
<ol class="breadcrumb">
    <li>Coupon</li>
    <li>Create</li>
</ol>
@endsection
@section('content')


<div class="row">
    <div class="col-md-9">
        <div class="jarviswidget" id="createCouponWidget" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">

            <header>
                <h2>Create Coupon </h2>
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
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif



                    <form id="createCouponForm" action="{{ route('admin.coupon.createpost') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <fieldset>
                            <legend>Coupon Basic Info</legend>

                            <div class="row">


                                <div class="col-md-6">
                                    <label class="control-label">Store Name</label>
                                    <select data-placeholder="Please Select" style="width:100%" id="StoreId" name="StoreId" class="select2" data-bv-group=".col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required">

                                        <option></option>
                                        @if(isset($stores))
                                        @foreach($stores as $StoreId => $Name)
                                        {{ $seleced = '' }}

                                        <option value="{{ $StoreId }}" {{old('StoreId')==$StoreId? 'selected':''}}>{{ $Name }}</option>

                                        @endforeach
                                        @endif

                                    </select>
                                </div>



                                <div class="col-md-6">
                                    <label class="control-label">Coupon Url</label>
                                    <input type="text" class="form-control" id="CouponUrl" name="CouponUrl" value="{{ old('CouponUrl') }}" placeholder="Coupon Url" data-bv-group=".col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                                </div>


                            </div>

                        </fieldset>
                        <fieldset>


                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label">Header</label>
                                    <input type="text" class="form-control" name="Header" value="{{ old('Header') }}" placeholder="Header" data-bv-group=".col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                                </div>

                                <div class="col-md-6">
                                    <label class="control-label">Code</label>
                                    <input type="text" class="form-control" name="Code" value="{{ old('Code') }}" placeholder="Code" data-bv-group=".col-md-6" />
                                </div>


                            </div>

                        </fieldset>

                        <fieldset>

                            <div class="row">

                                <div class="col-md-6">
                                    <label class="control-label">Description</label>

                                    <textarea rows="4" class="form-control" name="Description" placeholder="Description" " data-bv-group=" .col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required">{{ old('Description') }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">Category</label>
                                    <select multiple style="width:100%" id="CategoryId" name="CategoryId[]" class="select2" data-bv-group=".col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required">

                                        @if(isset($categories))
                                        @foreach($categories as $CategoryId => $Name)
                                        {{ $seleced = '' }}

                                        <option value="{{ $CategoryId }}" {{ (collect(old('CategoryId'))->contains($CategoryId)) ? 'selected':'' }}>{{ $Name }}</option>

                                        @endforeach
                                        @endif

                                    </select>
                                </div>

                            </div>


                        </fieldset>
                        <fieldset>
                            <div class="row">
                                <div class="col-md-6">

                                    <label class="control-label">Logo</label>
                                    <div>
                                        <input type="file" class="btn btn-default" id="LogoUrl" name="LogoUrl">
                                        <p class="help-block">

                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label">Coupon Type Text</label>
                                    <input type="text" class="form-control" name="CopounTypeText" value="{{ old('CopounTypeText') }}" placeholder="Copoun Type Text" data-bv-group=".col-md-4" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label">OFF</label>
                                    <input type="text" class="form-control" name="OFF" value="{{ old('OFF') }}" placeholder="OFF" data-bv-group=".col-md-2" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label">Deal Page Url</label>
                                    <input type="text" class="form-control" name="DealPageUrl" value="{{ old('DealPageUrl') }}" placeholder="Deal Page Url" />
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">Coupon For Country</label>

                                    <select data-placeholder="Please Select" style="width:100%" id="CountryId" name="CountryId" class="select2" data-bv-group=".col-md-6">

                                        <option value="0">All</option>
                                        @if(isset($countries))
                                        @foreach($countries as $CountryId => $Name)
                                        {{ $seleced = '' }}

                                        <option value="{{ $CountryId }}" {{old('CountryId')==$CountryId? 'selected':''}}>{{ $Name }}</option>

                                        @endforeach
                                        @endif

                                    </select>
                                </div>

                            </div>
                        </fieldset>

                        <br />
                        <legend>Offer Date Info</legend>
                        <fieldset>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Start Date:</label>
                                    <div class="input-group">
                                        <input type="text" id="StartDate" name="StartDate" value="{{ old('StartDate') }}" placeholder="Start Date" class="form-control datepicker" data-dateformat="dd/mm/yy">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Expiry Date:</label>
                                    <div class="input-group">
                                        <input type="text" id="ExpiryDate" name="ExpiryDate" value="{{ old('ExpiryDate') }}" placeholder="Expiry Date" class="form-control datepicker" data-dateformat="dd/mm/yy">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Expiry Date Unknown/Ongoing:</label>
                                    <div>
                                        <label class="checkbox-inline ">
                                            <input id="IsUnknownOutGoing" {{ old('IsUnknownOutGoing') == 1 ?  'checked' : '' }} name="IsUnknownOutGoing" value="1" type="checkbox" class="checkbox style-0" />
                                            <span>Unknown/Ongoing</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </fieldset>
                        <br />
                        <legend>Use This Deal/Coupon As Banner (Store Slider):
                            <label class="checkbox-inline ">
                                <input id="IsBanner" {{ old('IsBanner') == 1 ?  'checked' : '' }} name="IsBanner" value="1" type="checkbox" class="checkbox style-0" />
                                <span></span>
                            </label>
                        </legend>


                        <fieldset>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="control-label">Upload Banner (800X500)</label>
                                    <div>
                                        <input type="file" class="btn btn-default" id="BannerUrl" name="BannerUrl">
                                        <p class="help-block">

                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="checkbox-inline ">
                                        <input id="IsHomeBanner" {{ old('IsHomeBanner') == 1 ?  'checked' : '' }} name="IsHomeBanner" value="1" type="checkbox" class="checkbox style-0" />
                                        <span>
                                            Also Use As Home Banner (Home Sider)
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </fieldset>

                        <br />
                        <legend>Other Information</legend>
                        <fieldset>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Header Deal Colour</label>
                                    <input class="form-control" id="CopounTypeColour" style="background-color: {{old('CopounTypeColour','')}} " value="{{old('CopounTypeColour')}}" name="CopounTypeColour" readonly type="text" data-color-format="hex">
                                </div>

                                <div class="col-md-8">
                                    <label>Other Options:</label>
                                    <div>
                                        <label class="checkbox-inline ">
                                            <input id="Enabled" {{ old('Enabled') == 1 ?  'checked' : '' }} name="Enabled" value="1" type="checkbox" class="checkbox style-0" />
                                            <span>Enabled</span>
                                        </label>
                                        <label class="checkbox-inline ">
                                            <input id="Expired" {{ old('Expired') == 1 ?  'checked' : '' }} name="Expired" value="1" type="checkbox" class="checkbox style-0" />
                                            <span>Expired</span>
                                        </label>
                                        <label class="checkbox-inline ">
                                            <input id="IsExclusive" {{ old('IsExclusive') == 1 ?  'checked' : '' }} name="IsExclusive" value="1" type="checkbox" class="checkbox style-0" />
                                            <span>Exclusive</span>
                                        </label>
                                        <label class="checkbox-inline ">
                                            <input id="IsHeaderDeal" {{ old('IsHeaderDeal') == 1 ?  'checked' : '' }} name="IsHeaderDeal" value="1" type="checkbox" class="checkbox style-0" />
                                            <span>Header Deal</span>
                                        </label>
                                        <label class="checkbox-inline ">
                                            <input id="HomeCoupon" {{ old('HomeCoupon') == 1 ?  'checked' : '' }} name="HomeCoupon" value="1" type="checkbox" class="checkbox style-0" />
                                            <span>Best Online Promo Codes (At Home)</span>
                                        </label>
                                        <label class="checkbox-inline ">
                                            <input id="IsShowAtHome" {{ old('IsShowAtHome') == 1 ?  'checked' : '' }} name="IsShowAtHome" value="1" type="checkbox" class="checkbox style-0" />
                                            <span>Show At Home List</span>
                                        </label>
                                        <label class="checkbox-inline ">
                                            <input id="IsGlobalOffer" {{ old('IsGlobalOffer') == 1 ?  'checked' : '' }} name="IsGlobalOffer" value="1" type="checkbox" class="checkbox style-0" />
                                            <span>Global Offer</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <input id="StoreName" name="StoreName" class="hidden" value="{{old('StoreName')}}" />


                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-primary" onsubmit="return validateForm()" type="submit">
                                        <i class="fa fa-save"></i>
                                        Create Coupon
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <!-- end widget content -->

            </div>
            <!-- end widget div -->

        </div>
        <!-- end widget -->
    </div>
    <div class="col-md-3">
        <div id="storeinfo">

        </div>


    </div>
</div>
@endsection
@section('pagescripts')

<script src="{{ URL::asset('js/plugin/colorpicker/bootstrap-colorpicker.min.js') }}"></script>
<script>
    $('#createCouponForm').bootstrapValidator({
        excluded: ':disabled'
    });


    $('#CopounTypeColour').colorpicker().on('changeColor', function(event) {
        $('#CopounTypeColour').css('background-color', event.color.toHex());
    });


    $('#StoreId').on("select2:select", function(e) {
        $("#StoreName").val($('#StoreId').select2('data')[0].text);

        var url = "{{ route('admin.store.storeinfo',':id') }}";
        url = url.replace(':id', $('#StoreId').val());

        CallAjaxService('GET', null, url, 'html', '', function(data) {
            $("#storeinfo").html(data);
            $("#storeinfo #CategoryId").select2();
            $("#createCouponForm #CouponUrl").val($("#StoreNetworkLink").val());
            $("#createCouponForm #CategoryId").val($("#storeinfo #CategoryId").val()).trigger('change');

        });

    });
</script>

@endsection