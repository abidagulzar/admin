@extends('Admin.Layout.master')
@section('pagebreadcrumb')
<ol class="breadcrumb">
    <li>Store</li>
    <li>Store Setting</li>
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

<div class="jarviswidget" id="storeSettingsWidget" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">

    <header>
        <h2>Store Settings</h2>
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



            <form id="storeSettingsForm" action="{{ route('admin.storesetting.createpost') }}" enctype="multipart/form-data" method="POST">
                @csrf

                <br />
                @if (Auth::user()->isAdmin())
                <fieldset>
                    <legend>Seo Information (Only Change by Admin):<span data-toggle="modal" href="#systemValueModal" class="pull-right" style="cursor: pointer;">System Value Information : <span class="glyphicon glyphicon-info-sign"></span></span>
                    </legend>
                    <div class="row">
                        <div class="col-md-3">
                            <label class="control-label">Region</label>
                            <input type="text" class="form-control" name="RegionName" value="{{ old('RegionName') }}" data-bv-group=".col-md-3" placeholder="Region Name" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-9">
                            <label class="control-label">Header 1</label>
                            <input type="text" class="form-control" name="Header1" value="{{ old('Header1') }}" data-bv-group=".col-md-9" placeholder="Header 1" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Title</label>
                            <textarea rows="2" class="form-control" name="Title" placeholder="Title" data-bv-group=" .col-md-12" data-bv-notempty="true" data-bv-notempty-message="Information Required">{{ old('Title') }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Description</label>
                            <textarea rows="6" class="form-control" name="Description" placeholder="Description" " data-bv-group=" .col-md-12" data-bv-notempty="true" data-bv-notempty-message="Information Required">{{ old('Description') }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Keywords</label>
                            <textarea rows="8" class="form-control" name="Keywords" placeholder="Keywords" " data-bv-group=" .col-md-12" data-bv-notempty="true" data-bv-notempty-message="Information Required">{{ old('Keywords') }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Footer</label>
                            <textarea rows="8" class="form-control" name="Footer" placeholder="Footer" " data-bv-group=" .col-md-12" data-bv-notempty="true" data-bv-notempty-message="Information Required">{{ old('Footer') }}</textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Default Deal Text</label>
                            <textarea rows="4" class="form-control" name="DefaultDealText" placeholder="Default Deal Text" data-bv-group=" .col-md-12" data-bv-notempty="true" data-bv-notempty-message="Information Required">{{ old('DefaultDealText') }}</textarea>
                        </div>
                    </div>


                </fieldset>
                <br />
                <fieldset>
                    <legend>Keywords(Only Change by Admin):<span data-toggle="modal" href="#systemValueModal" class="pull-right" style="cursor: pointer;">System Value Information : <span class="glyphicon glyphicon-info-sign"></span></span>
                    </legend>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Default Content Keywords</label>
                            <input class="form-control tagsinput" name="DefaultContentKeywords" value="{{ old('DefaultContentKeywords') }}" data-role="tagsinput">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Q/A Keywords</label>
                            <input class="form-control tagsinput" name="QAKeywords" value="{{ old('QAKeywords') }}" data-role="tagsinput">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Related Store Keywords</label>
                            <input class="form-control tagsinput" name="RelatedStoreKeywords" value="{{ old('RelatedStoreKeywords') }}" data-role="tagsinput">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Footer Keywords</label>
                            <input class="form-control tagsinput" name="FooterKeywords" value="{{ old('FooterKeywords') }}" data-role="tagsinput">
                        </div>
                    </div>

                </fieldset>
                <br />
                <fieldset>
                    <legend>Other Information (Only Change by Admin):<span data-toggle="modal" href="#systemValueModal" class="pull-right" style="cursor: pointer;">System Value Information : <span class="glyphicon glyphicon-info-sign"></span></span>
                    </legend>
                    <div class="row">
                        <div class="col-md-3">
                            <label class="control-label">Related Store Heading</label>
                            <input type="text" class="form-control" name="RelatedStoreHeading" value="{{ old('RelatedStoreHeading') }}" data-bv-group=".col-md-3" placeholder="Related Store Heading" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Subscribe To Email Heading</label>
                            <input type="text" class="form-control" name="SubscribeToEmailHeading" value="{{ old('SubscribeToEmailHeading') }}" data-bv-group=".col-md-3" placeholder="Subscribe To Email Heading" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Subscribe To Email Text</label>
                            <textarea rows="4" class="form-control" name="SubscribeToEmailText" placeholder="Subscribe To Email Text" data-bv-group=".col-md-3" data-bv-notempty="true" data-bv-notempty-message="Information Required">{{ old('SubscribeToEmailText') }}</textarea>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Subscribe To Email Footer</label>
                            <textarea rows="4" class="form-control" name="SubscribeToEmailFooter" placeholder="Subscribe To Email Footer" data-bv-group=".col-md-3" data-bv-notempty="true" data-bv-notempty-message="Information Required">{{ old('SubscribeToEmailFooter') }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label class="control-label">Subscribe Translate</label>
                            <input type="text" class="form-control" name="SubscribeTranslate" value="{{ old('SubscribeTranslate') }}" data-bv-group=".col-md-3" placeholder="Subscribe Translate" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Email Address Translate</label>
                            <input type="text" class="form-control" name="EmailAddressTranslate" value="{{ old('EmailAddressTranslate') }}" data-bv-group=".col-md-3" placeholder="Email Address Translate" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Got Question Heading</label>
                            <input type="text" class="form-control" name="GotQuestionHeading" value="{{ old('GotQuestionHeading') }}" data-bv-group=".col-md-3" placeholder="Got Question Heading" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Got Question Text</label>
                            <textarea rows="4" class="form-control" name="GotQuestionText" placeholder="Got Question Text" data-bv-group=".col-md-3" data-bv-notempty="true" data-bv-notempty-message="Information Required">{{ old('GotQuestionText') }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label class="control-label">Drop Line Translate</label>
                            <input type="text" class="form-control" name="DropLineTranslate" value="{{ old('DropLineTranslate') }}" data-bv-group=".col-md-3" placeholder="Drop Line Translate" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Related Searches Translate</label>
                            <input type="text" class="form-control" name="RelatedSearchesTranslate" value="{{ old('RelatedSearchesTranslate') }}" data-bv-group=".col-md-3" placeholder="Related Searches Translate" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">General Translate</label>
                            <input type="text" class="form-control" name="GeneralTranslate" value="{{ old('GeneralTranslate') }}" data-bv-group=".col-md-3" placeholder="General Translate" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Connect Translate</label>
                            <input type="text" class="form-control" name="ConnectTranslate" value="{{ old('ConnectTranslate') }}" data-bv-group=".col-md-3" placeholder="Connect Translate" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label class="control-label">Special Pages Heading</label>
                            <input type="text" class="form-control" name="SpecialPagesHeading" value="{{ old('SpecialPagesHeading') }}" data-bv-group=".col-md-3" placeholder="Special Pages Heading" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Get Deal Translate</label>
                            <input type="text" class="form-control" name="GetDeal" value="{{ old('GetDeal') }}" data-bv-group=".col-md-3" placeholder="Get Deal Translate" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Show Code Translate</label>
                            <input type="text" class="form-control" name="ShowCode" value="{{ old('ShowCode') }}" data-bv-group=".col-md-3" placeholder="Show Code Translate" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Click Below Text And Paste</label>
                            <textarea rows="4" class="form-control" name="ClickBelowTextAndPast" placeholder="Click Below Text And Paste" data-bv-group=".col-md-3" data-bv-notempty="true" data-bv-notempty-message="Information Required">{{ old('ClickBelowTextAndPast') }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label class="control-label">Expires On</label>
                            <input type="text" class="form-control" name="ExpiresOn" value="{{ old('ExpiresOn') }}" data-bv-group=".col-md-3" placeholder="Expires On" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Unknown/OutGoing</label>
                            <input type="text" class="form-control" name="UnknownOutGoing" value="{{ old('UnknownOutGoing') }}" data-bv-group=".col-md-3" placeholder="Unknown/OutGoing" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Visit Our Store</label>
                            <input type="text" class="form-control" name="VisitOurStore" value="{{ old('VisitOurStore') }}" data-bv-group=".col-md-3" placeholder="Visit Our Store" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Continue To Store</label>
                            <input type="text" class="form-control" name="ContinueToStore" value="{{ old('ContinueToStore') }}" data-bv-group=".col-md-3" placeholder="Continue To Store" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label class="control-label">No Code Needed</label>
                            <input type="text" class="form-control" name="NoCodeNeeded" value="{{ old('NoCodeNeeded') }}" data-bv-group=".col-md-3" placeholder="No Code Needed" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Deal</label>
                            <input type="text" class="form-control" name="Deal" value="{{ old('Deal') }}" data-bv-group=".col-md-3" placeholder="Deal" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Coupon</label>
                            <input type="text" class="form-control" name="Coupon" value="{{ old('Coupon') }}" data-bv-group=".col-md-3" placeholder="Coupon" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Exclusive</label>
                            <input type="text" class="form-control" name="Exclusive" value="{{ old('Exclusive') }}" data-bv-group=".col-md-3" placeholder="Exclusive" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label class="control-label">Lang</label>
                            <input type="text" class="form-control" name="Lang" value="{{ old('Lang') }}" data-bv-group=".col-md-3" placeholder="Lang" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                    </div>

                </fieldset>


                @endif


                @can('Store Settings Edit')
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary" onsubmit="return validateForm()" type="submit">
                                <i class="fa fa-save"></i>
                                Create Settings
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
<script src="{{ URL::asset('js/plugin/bootstrap-tags/bootstrap-tagsinput.min.js') }}"></script>
<script>
    $('#storeSettingsForm').bootstrapValidator({
        excluded: ':disabled'
    });
</script>

@endsection