@extends('Admin.Layout.master')
@section('pagebreadcrumb')
<ol class="breadcrumb">
    <li>Site Info</li>

</ol>
@endsection
@section('content')

<div class="modal fade" id="systemValueModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title">
                    System Value Information (Use Small Letters)
                </h4>
            </div>
            <div class="modal-body no-padding">
                <div class="table-responsive">

                    @include('Admin.Layout.systemvalue')

                </div>

            </div>
        </div>
    </div>
</div>

<div class="jarviswidget" id="siteInfoWidget" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">

    <header>
        <h2>Site Info</h2>
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



            <form id="siteInfoForm" action="{{ route('admin.siteinfo.updatepost') }}" enctype="multipart/form-data" method="POST">
                @csrf


                <fieldset>

                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">About Us</label>
                            <textarea rows="8" class="form-control" name="AboutUs" placeholder="About Us" data-bv-group=".col-md-12" data-bv-notempty="true" data-bv-notempty-message="Information Required">{{ old('AboutUs',$Model->AboutUs) }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Contact Us</label>
                            <textarea rows="8" class="form-control" name="ContactUs" placeholder="Contact Us" data-bv-group=".col-md-12" data-bv-notempty="true" data-bv-notempty-message="Information Required">{{ old('ContactUs',$Model->ContactUs) }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Suggestion Text</label>
                            <textarea rows="8" class="form-control" name="SuggestionText" placeholder="Suggestion Text" data-bv-group=".col-md-12" data-bv-notempty="true" data-bv-notempty-message="Information Required">{{ old('SuggestionText',$Model->SuggestionText) }}</textarea>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-12">
                            <label class="control-label">Privacy Policy</label>
                            <textarea rows="8" class="form-control" name="PrivacyPolicy" placeholder="Privacy Policy" data-bv-group=".col-md-12" data-bv-notempty="true" data-bv-notempty-message="Information Required">{{ old('PrivacyPolicy',$Model->PrivacyPolicy) }}</textarea>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-12">
                            <label class="control-label">Terms Of Use</label>
                            <textarea rows="8" class="form-control" name="TermsOfUse" placeholder="Terms Of Use" data-bv-group=" .col-md-12" data-bv-notempty="true" data-bv-notempty-message="Information Required">{{ old('TermsOfUse',$Model->TermsOfUse) }}</textarea>
                        </div>
                    </div>


                </fieldset>

                <fieldset>
                    <legend>Update Infromation
                    </legend>
                    <div class="row">

                        <div class="col-md-6">
                            <label class="control-label">Created By</label>
                            <input type="text" class="form-control" value="{{ $Model->CreatedByUser }}" placeholder="Created By" readonly />
                        </div>
                        <div class="col-md-5">
                            <label class="control-label">Created Date</label>
                            <input type="text" class="form-control" value="{{is_null($Model->CreateDate) ? '': date('d/m/Y h:i:s A', strtotime($Model->CreateDate)) }}" placeholder="Created Date" readonly />
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <label class="control-label">Update By</label>
                            <input type="text" class="form-control" value="{{ $Model->UpdatedByUser }}" placeholder="Update By" readonly />
                        </div>
                        <div class="col-md-5">
                            <label class="control-label">Updated Date</label>
                            <input type="text" class="form-control" value="{{is_null($Model->UpdateDate) ? '': date('d/m/Y h:i:s A', strtotime($Model->UpdateDate)) }}" placeholder="Updated Date" readonly />
                        </div>
                    </div>

                </fieldset>


                @can('Site Info Edit')
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary" onsubmit="return validateForm()" type="submit">
                                <i class="fa fa-save"></i>
                                Update Settings
                            </button>
                        </div>
                    </div>
                </div>
                @endcan

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
<script>
    $('#siteInfoForm').bootstrapValidator({
        excluded: ':disabled'
    });
</script>

@endsection