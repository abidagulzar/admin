@extends('Admin.Layout.master')
@section('pagebreadcrumb')
<ol class="breadcrumb">
    <li>CPC Store</li>
    <li>Create</li>
</ol>
@endsection
@section('content')


<div class="row">
    <div class="col-md-9">
        <div class="jarviswidget" id="createCPCStoreWidget" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">

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



                    <form id="createCouponForm" action="{{ route('admin.cpcstore.createpost') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <fieldset>
                            <legend>CPC Store Basic Info</legend>

                            <div class="row">


                                <div class="col-md-5">
                                    <label class="control-label">Store Name</label>
                                    <select data-placeholder="Please Select" style="width:100%" id="StoreId" name="StoreId" class="select2" data-bv-group=".col-md-5" data-bv-notempty="true" data-bv-notempty-message="Information Required">

                                        <option></option>
                                        @if(isset($stores))
                                        @foreach($stores as $StoreId => $Name)
                                        {{ $seleced = '' }}

                                        <option value="{{ $StoreId }}" {{old('StoreId')==$StoreId? 'selected':''}}>{{ $Name }}</option>

                                        @endforeach
                                        @endif

                                    </select>
                                </div>


                                <div class="col-md-5">
                                    <label class="control-label">Countries</label>

                                    <select multiple data-placeholder="Please Select" style="width:100%" id="CountryId" name="CountryId[]" class="select2" data-bv-group=".col-md-5" data-bv-notempty="true" data-bv-notempty-message="Information Required">


                                        @if(isset($countries))
                                        @foreach($countries as $CountryId => $Name)
                                        {{ $seleced = '' }}

                                        <option value="{{ $CountryId }}" {{old('CountryId')==$CountryId? 'selected':''}}>{{ $Name }}</option>

                                        @endforeach
                                        @endif

                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="control-label">Commission</label>
                                    <input type="text" class="form-control" name="Commission" value="{{ old('Commission') }}" placeholder="Commission" data-bv-group=".col-md-2" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                                </div>


                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <label class="control-label">Track Url</label>

                                    <input class="form-control" name="TrackURL" value="{{ old('TrackURL') }}" placeholder="Track Url" data-bv-group=".col-md-12" data-bv-notempty="true" data-bv-notempty-message="Information Required" />

                                </div>
                            </div>

                        </fieldset>

                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-primary" onsubmit="return validateForm()" type="submit">
                                        <i class="fa fa-save"></i>
                                        Create CPC Store
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