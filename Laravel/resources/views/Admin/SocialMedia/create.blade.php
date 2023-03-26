@extends('Admin.Layout.master')
@section('pagebreadcrumb')
<ol class="breadcrumb">
    <li>Social Media</li>
    <li>Create</li>
</ol>
@endsection
@section('content')


<div class="row">
    <div class="col-md-9">
        <div class="jarviswidget" id="createSocialMediaWidget" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">

            <header>
                <h2>Create Social Media Entity </h2>
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



                    <form id="createSocialMediaForm" action="{{ route('admin.socialmedia.createpost') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <fieldset>
                            <legend>Social Media Store</legend>

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

                                <div class="col-md-7">
                                    <label class="control-label">Track Url</label>

                                    <input class="form-control" id=AffiliateUrlToRedirect name="AffiliateUrlToRedirect" value="{{ old('AffiliateUrlToRedirect') }}" placeholder="Track Url" data-bv-group=".col-md-7" data-bv-notempty="true" data-bv-notempty-message="Information Required" />

                                </div>

                            </div>


                        </fieldset>

                        <fieldset>


                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label">Title</label>
                                    <input type="text" class="form-control" name="Title" value="{{ old('Title') }}" placeholder="Title" data-bv-group=".col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                                </div>

                                <div class="col-md-6">
                                    <label class="control-label">Description</label>

                                    <textarea rows="4" class="form-control" name="Description" placeholder="Description">{{ old('Description') }}</textarea>
                                </div>


                            </div>

                        </fieldset>

                        <fieldset>

                            <div class="row">
                                <div class="col-md-12">

                                    <label class="control-label">Upload Social Image</label>
                                    <div>
                                        <input type="file" class="btn btn-default" id="SocialImage" name="SocialImage">
                                        <p class="help-block">

                                        </p>
                                    </div>

                                </div>
                            </div>


                        </fieldset>

                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-primary" onsubmit="return validateForm()" type="submit">
                                        <i class="fa fa-save"></i>
                                        Create Social Media Entity
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
    $('#createSocialMediaForm').bootstrapValidator({
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
            $("#createSocialMediaForm #AffiliateUrlToRedirect").val($("#StoreNetworkLink").val());

        });

    });
</script>

@endsection