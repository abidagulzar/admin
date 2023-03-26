@extends('Admin.Layout.master')
@section('pagebreadcrumb')
<ol class="breadcrumb">
    <li>CPC Store</li>
    <li>Edit</li>
</ol>
@endsection
@section('content')

<div class="jarviswidget" id="updateStoreWidget" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">

    <header>
        <h2>Update CPC Store </h2>
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



            <form id="updateStoreForm" action="{{ route('admin.cpcstore.updatepost') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <fieldset>
                    <legend>CPC Store Info</legend>

                    <div class="row">
                        <div class="col-md-4">
                            <label class="control-label">Store Name</label>
                            <select disabled data-placeholder="Please Select" style="width:100%" id="StoreId" name="StoreId" class="select2" data-bv-group=".col-md-4" data-bv-notempty="true" data-bv-notempty-message="Information Required">

                                <option></option>
                                @if(isset($stores))
                                @foreach($stores as $StoreId => $Name)
                                {{ $seleced = '' }}

                                <option value="{{ $StoreId }}" {{old('StoreId',$Model->StoreId)==$StoreId? 'selected':''}}>{{ $Name }}</option>

                                @endforeach
                                @endif

                            </select>
                        </div>


                        <div class="col-md-4">
                            <label class="control-label">Countries</label>

                            <select disabled multiple data-placeholder="Please Select" style="width:100%" id="CountryId" name="CountryId[]" class="select2" data-bv-group=".col-md-4" data-bv-notempty="true" data-bv-notempty-message="Information Required">


                                @if(isset($countries))
                                @foreach($countries as $CountryId => $Name)
                                {{ $seleced = '' }}

                                <option value="{{ $CountryId }}" {{old('CountryId',$Model->CountryId)==$CountryId? 'selected':''}}>{{ $Name }}</option>

                                @endforeach
                                @endif

                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="control-label">Commission</label>

                            <input class="form-control" name="Commission" value="{{ old('Commission', $Model->Commission) }}" placeholder="Commission" data-bv-group=".col-md-4" data-bv-notempty="true" data-bv-notempty-message="Information Required" />


                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Track Url</label>

                            <input class="form-control" name="TrackURL" value="{{ old('TrackURL', $Model->TrackURL) }}" placeholder="Track Url" data-bv-group=".col-md-12" data-bv-notempty="true" data-bv-notempty-message="Information Required" />

                        </div>
                    </div>

                </fieldset>


                <input name="CPCStoreId" value="{{$Model->CPCStoreId}}" type="hidden"></input>

                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary" onsubmit="return validateForm()" type="submit">
                                <i class="fa fa-save"></i>
                                Update CPC Store
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

@endsection
@section('pagescripts')
<script src="{{ URL::asset('js/plugin/bootstrap-tags/bootstrap-tagsinput.min.js') }}"></script>
<script>
    $('#updateStoreForm').bootstrapValidator({
        excluded: ':disabled'
    });
</script>

@endsection