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



            <form id="storeSettingsForm" action="{{ route('admin.storesetting.updatepost') }}" enctype="multipart/form-data" method="POST">
                @csrf

                <br />
                @if (Auth::user()->isAdmin())
                <fieldset>
                    <legend>Seo Information (Only Change by Admin):<span data-toggle="modal" href="#systemValueModal" class="pull-right" style="cursor: pointer;">System Value Information : <span class="glyphicon glyphicon-info-sign"></span></span>
                    </legend>
                    <div class="row">
                        <div class="col-md-3">
                            <label class="control-label">Region</label>
                            <input type="text" class="form-control" name="RegionName" value="{{ old('RegionName',$Model->RegionName) }}" data-bv-group=".col-md-3" placeholder="Region Name" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-9">
                            <label class="control-label">Header 1</label>
                            <input type="text" class="form-control" name="Header1" value="{{ old('Header1',$Model->Header1) }}" data-bv-group=".col-md-9" placeholder="Header 1" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Title</label>
                            <textarea rows="2" class="form-control" name="Title" placeholder="Title" " data-bv-group=" .col-md-12" data-bv-notempty="true" data-bv-notempty-message="Information Required">{{ old('Title',$Model->Title) }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Description</label>
                            <textarea rows="6" class="form-control" name="Description" placeholder="Description" " data-bv-group=" .col-md-12" data-bv-notempty="true" data-bv-notempty-message="Information Required">{{ old('Description',$Model->Description) }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Keywords</label>
                            <textarea rows="8" class="form-control" name="Keywords" placeholder="Keywords" " data-bv-group=" .col-md-12" data-bv-notempty="true" data-bv-notempty-message="Information Required">{{ old('Keywords',$Model->Keywords) }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Footer</label>
                            <textarea rows="8" class="form-control" name="Footer" placeholder="Footer" " data-bv-group=" .col-md-12" data-bv-notempty="true" data-bv-notempty-message="Information Required">{{ old('Footer',$Model->Footer) }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Default Deal Text</label>
                            <textarea rows="4" class="form-control" name="DefaultDealText" placeholder="Default Deal Text" data-bv-group=" .col-md-12" data-bv-notempty="true" data-bv-notempty-message="Information Required">{{ old('DefaultDealText',$Model->DefaultDealText) }}</textarea>
                        </div>
                    </div>



                </fieldset>
                <br />
                <fieldset>
                    <legend>Default(Only Change by Admin):<span data-toggle="modal" href="#systemValueModal" class="pull-right" style="cursor: pointer;">System Value Information : <span class="glyphicon glyphicon-info-sign"></span></span>
                    </legend>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Default Content</label>
                            <textarea rows="10" class="form-control" name="DefaultContent" placeholder="Default Content" data-bv-group=" .col-md-12" data-bv-notempty="false" data-bv-notempty-message="Information Required">{{ old('DefaultContent',$Model->DefaultContent) }}</textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="control-label">Default QA</label>
                            <textarea rows="10" class="form-control" name="DefaultQA" placeholder="Default QA" data-bv-group=" .col-md-12" data-bv-notempty="false" data-bv-notempty-message="Information Required">{{ old('DefaultQA',$Model->DefaultQA) }}</textarea>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Related Searches</label>
                            <input class="form-control tagsinput" name="RelatedSearches" value="{{ old('RelatedSearches', $Model->RelatedSearches) }}" data-role="tagsinput">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Related Stores Text</label>

                            <textarea rows="2" class="form-control" name="RelatedStoresText" placeholder="Related Stores Text">{{ old('RelatedStoresText', $Model->RelatedStoresText) }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Months Short</label>
                            <input class="form-control tagsinput" name="MonthsShort" value="{{ old('MonthsShort', $Model->MonthsShort) }}" data-role="tagsinput">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Months Full</label>
                            <input class="form-control tagsinput" name="MonthsFull" value="{{ old('MonthsFull', $Model->MonthsFull) }}" data-role="tagsinput">
                        </div>
                    </div>
                </fieldset>


                <fieldset>
                    <legend>Keywords (Only Change by Admin):<span data-toggle="modal" href="#systemValueModal" class="pull-right" style="cursor: pointer;">System Value Information : <span class="glyphicon glyphicon-info-sign"></span></span>
                    </legend>
                    <div class="row">
                        <div class="col-md-3">
                            <label class="control-label">Related Store Heading</label>
                            <input type="text" class="form-control" name="RelatedStoreHeading" value="{{ old('RelatedStoreHeading', $Model->RelatedStoreHeading) }}" data-bv-group=".col-md-3" placeholder="Related Store Heading" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Subscribe To Email Heading</label>
                            <input type="text" class="form-control" name="SubscribeToEmailHeading" value="{{ old('SubscribeToEmailHeading', $Model->SubscribeToEmailHeading) }}" data-bv-group=".col-md-3" placeholder="Subscribe To Email Heading" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Subscribe To Email Text</label>
                            <textarea rows="4" class="form-control" name="SubscribeToEmailText" placeholder="Subscribe To Email Text" data-bv-group=".col-md-3" data-bv-notempty="true" data-bv-notempty-message="Information Required">{{ old('SubscribeToEmailText', $Model->SubscribeToEmailText) }}</textarea>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Subscribe To Email Footer</label>
                            <textarea rows="4" class="form-control" name="SubscribeToEmailFooter" placeholder="Subscribe To Email Footer" data-bv-group=".col-md-3" data-bv-notempty="true" data-bv-notempty-message="Information Required">{{ old('SubscribeToEmailFooter', $Model->SubscribeToEmailFooter) }}</textarea>
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
                            <input class="form-control tagsinput" name="DefaultContentKeywords" value="{{ old('DefaultContentKeywords', $Model->DefaultContentKeywords) }}" data-role="tagsinput">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Q/A Keywords</label>
                            <input class="form-control tagsinput" name="QAKeywords" value="{{ old('QAKeywords', $Model->QAKeywords) }}" data-role="tagsinput">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Related Store Keywords</label>
                            <input class="form-control tagsinput" name="RelatedStoreKeywords" value="{{ old('RelatedStoreKeywords', $Model->RelatedStoreKeywords) }}" data-role="tagsinput">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Footer Keywords</label>
                            <input class="form-control tagsinput" name="FooterKeywords" value="{{ old('FooterKeywords', $Model->FooterKeywords) }}" data-role="tagsinput">
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
                            <input type="text" class="form-control" name="RelatedStoreHeading" value="{{ old('RelatedStoreHeading', $Model->RelatedStoreHeading) }}" data-bv-group=".col-md-3" placeholder="Related Store Heading" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Subscribe To Email Heading</label>
                            <input type="text" class="form-control" name="SubscribeToEmailHeading" value="{{ old('SubscribeToEmailHeading', $Model->SubscribeToEmailHeading) }}" data-bv-group=".col-md-3" placeholder="Subscribe To Email Heading" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Subscribe To Email Text</label>
                            <textarea rows="4" class="form-control" name="SubscribeToEmailText" placeholder="Subscribe To Email Text" data-bv-group=".col-md-3" data-bv-notempty="true" data-bv-notempty-message="Information Required">{{ old('SubscribeToEmailText', $Model->SubscribeToEmailText) }}</textarea>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Subscribe To Email Footer</label>
                            <textarea rows="4" class="form-control" name="SubscribeToEmailFooter" placeholder="Subscribe To Email Footer" data-bv-group=".col-md-3" data-bv-notempty="true" data-bv-notempty-message="Information Required">{{ old('SubscribeToEmailFooter', $Model->SubscribeToEmailFooter) }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label class="control-label">Subscribe Translate</label>
                            <input type="text" class="form-control" name="SubscribeTranslate" value="{{ old('SubscribeTranslate', $Model->SubscribeTranslate) }}" data-bv-group=".col-md-3" placeholder="Subscribe Translate" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Email Address Translate</label>
                            <input type="text" class="form-control" name="EmailAddressTranslate" value="{{ old('EmailAddressTranslate', $Model->EmailAddressTranslate) }}" data-bv-group=".col-md-3" placeholder="Email Address Translate" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Got Question Heading</label>
                            <input type="text" class="form-control" name="GotQuestionHeading" value="{{ old('GotQuestionHeading', $Model->GotQuestionHeading) }}" data-bv-group=".col-md-3" placeholder="Got Question Heading" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Got Question Text</label>
                            <textarea rows="4" class="form-control" name="GotQuestionText" placeholder="Got Question Text" data-bv-group=".col-md-3" data-bv-notempty="true" data-bv-notempty-message="Information Required">{{ old('GotQuestionText', $Model->GotQuestionText) }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label class="control-label">Drop Line Translate</label>
                            <input type="text" class="form-control" name="DropLineTranslate" value="{{ old('DropLineTranslate', $Model->DropLineTranslate) }}" data-bv-group=".col-md-3" placeholder="Drop Line Translate" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Related Searches Translate</label>
                            <input type="text" class="form-control" name="RelatedSearchesTranslate" value="{{ old('RelatedSearchesTranslate', $Model->RelatedSearchesTranslate) }}" data-bv-group=".col-md-3" placeholder="Related Searches Translate" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">General Translate</label>
                            <input type="text" class="form-control" name="GeneralTranslate" value="{{ old('GeneralTranslate', $Model->GeneralTranslate) }}" data-bv-group=".col-md-3" placeholder="General Translate" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Connect Translate</label>
                            <input type="text" class="form-control" name="ConnectTranslate" value="{{ old('ConnectTranslate', $Model->ConnectTranslate) }}" data-bv-group=".col-md-3" placeholder="Connect Translate" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label class="control-label">Special Pages Heading</label>
                            <input type="text" class="form-control" name="SpecialPagesHeading" value="{{ old('SpecialPagesHeading', $Model->SpecialPagesHeading) }}" data-bv-group=".col-md-3" placeholder="Special Pages Heading" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Get Deal Translate</label>
                            <input type="text" class="form-control" name="GetDeal" value="{{ old('GetDeal', $Model->GetDeal) }}" data-bv-group=".col-md-3" placeholder="Get Deal Translate" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Show Code Translate</label>
                            <input type="text" class="form-control" name="ShowCode" value="{{ old('ShowCode', $Model->ShowCode) }}" data-bv-group=".col-md-3" placeholder="Show Code Translate" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Click Below Text And Paste</label>
                            <textarea rows="4" class="form-control" name="ClickBelowTextAndPast" placeholder="Click Below Text And Paste" data-bv-group=".col-md-3" data-bv-notempty="true" data-bv-notempty-message="Information Required">{{ old('ClickBelowTextAndPast', $Model->ClickBelowTextAndPast) }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label class="control-label">Expires On</label>
                            <input type="text" class="form-control" name="ExpiresOn" value="{{ old('ExpiresOn', $Model->ExpiresOn) }}" data-bv-group=".col-md-3" placeholder="Expires On" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Unknown/OutGoing</label>
                            <input type="text" class="form-control" name="UnknownOutGoing" value="{{ old('UnknownOutGoing', $Model->UnknownOutGoing) }}" data-bv-group=".col-md-3" placeholder="Unknown/OutGoing" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Visit Our Store</label>
                            <input type="text" class="form-control" name="VisitOurStore" value="{{ old('VisitOurStore', $Model->VisitOurStore) }}" data-bv-group=".col-md-3" placeholder="Visit Our Store" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Continue To Store</label>
                            <input type="text" class="form-control" name="ContinueToStore" value="{{ old('ContinueToStore', $Model->ContinueToStore) }}" data-bv-group=".col-md-3" placeholder="Continue To Store" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label class="control-label">No Code Needed</label>
                            <input type="text" class="form-control" name="NoCodeNeeded" value="{{ old('NoCodeNeeded',$Model->NoCodeNeeded) }}" data-bv-group=".col-md-3" placeholder="No Code Needed" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Deal</label>
                            <input type="text" class="form-control" name="Deal" value="{{ old('Deal', $Model->Deal) }}" data-bv-group=".col-md-3" placeholder="Deal" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Coupon</label>
                            <input type="text" class="form-control" name="Coupon" value="{{ old('Coupon', $Model->Coupon) }}" data-bv-group=".col-md-3" placeholder="Coupon" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Exclusive</label>
                            <input type="text" class="form-control" name="Exclusive" value="{{ old('Exclusive', $Model->Exclusive) }}" data-bv-group=".col-md-3" placeholder="Exclusive" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label class="control-label">Lang</label>
                            <input type="text" class="form-control" name="Lang" value="{{ old('Lang', $Model->Lang) }}" data-bv-group=".col-md-3" placeholder="Lang" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                    </div>

                </fieldset>


                @endif
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

                <input name="StoreSettingId" value="{{$Model->StoreSettingId}}" type="hidden"></input>
                @can('Store Settings Edit')
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
<script src="{{ URL::asset('js/plugin/bootstrap-tags/bootstrap-tagsinput.min.js') }}"></script>
<script>
    $('#storeSettingsForm').bootstrapValidator({
        excluded: ':disabled'
    });
</script>

@endsection