@extends('Admin.Layout.master')
@section('pagebreadcrumb')
<ol class="breadcrumb">
    <li>Coupon</li>
    <li>Copy</li>
</ol>
@endsection
@section('content')


<div class="row">
    <div class="col-md-12">
        <div class="jarviswidget" id="copyCouponWidget" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">

            <header>
                <h2>Copy Coupon </h2>
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



                    <form id="copyCouponForm" action="{{ route('admin.coupon.copypost') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <fieldset>
                            <legend>Select Stores</legend>

                            <div class="row">


                                <div class="col-md-6">
                                    <label class="control-label">From Store</label>
                                    <select data-placeholder="Please Select" style="width:100%" id="FromStoreId" name="FromStoreId" class="select2" data-bv-group=".col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required">

                                        <option></option>
                                        @if(isset($stores))
                                        @foreach($stores as $StoreId => $RegionalName)
                                        {{ $seleced = '' }}

                                        <option value="{{ $StoreId }}" {{old('StoreId')==$StoreId? 'selected':''}}>{{ $RegionalName }}</option>

                                        @endforeach
                                        @endif

                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label">To Store</label>
                                    <select data-placeholder="Please Select" style="width:100%" id="ToStoreId" name="ToStoreId" class="select2" data-bv-group=".col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required">

                                        <option></option>
                                        @if(isset($stores))
                                        @foreach($stores as $StoreId => $Name)
                                        {{ $seleced = '' }}

                                        <option value="{{ $StoreId }}" {{old('StoreId')==$StoreId? 'selected':''}}>{{ $Name }}</option>

                                        @endforeach
                                        @endif

                                    </select>
                                </div>






                            </div>

                        </fieldset>


                        <br />

                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-primary" onsubmit="return validateForm()" type="submit">
                                        <i class="fa fa-save"></i>
                                        Copy Coupon
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

</div>
@endsection
@section('pagescripts')

<script>
    $('#copyCouponForm').bootstrapValidator({
        excluded: ':disabled'
    });
</script>

@endsection