@extends('Admin.Layout.master')
@section('pagebreadcrumb')
<ol class="breadcrumb">
    <li>Home</li>
    <li>Home Setting</li>
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

<div class="jarviswidget" id="homeSettingsWidget" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">

    <header>
        <h2>Home Settings</h2>
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



            <form id="homeSettingsForm" action="{{ route('admin.homesetting.updatepost') }}" enctype="multipart/form-data" method="POST">
                @csrf


                <fieldset>
                    <legend>Banners</legend>
                    <div class="row">
                        <div class="col-md-3">

                            <label class="control-label">Banner 1 Heading Logo (1400 X 100)</label>
                            <div>
                                <input type="file" class="btn btn-default" id="Banner1Url" name="Banner1Url">
                                <p class="help-block">

                                </p>
                            </div>
                            @if(isset($Model->Banner1Url))
                            <img style="width: 100px;" src="{{ url('/storage/bannerlogo').'/'.$Model->Banner1Url }}">
                            @endif

                        </div>
                        <div class="col-md-4">
                            <label class="control-label">Banner 1 Heading</label>
                            <input type="text" class="form-control" name="Banner1HeaderText" value="{{ old('Banner1HeaderText',$Model->Banner1HeaderText) }}" data-bv-group=".col-md-4" placeholder="Banner 1 Header Text" />
                        </div>
                        <div class="col-md-5">
                            <label class="control-label">Banner 1 Affiliate Link</label>
                            <input type="text" class="form-control" name="AffiliateLink1" value="{{ old('AffiliateLink1',$Model->AffiliateLink1) }}" data-bv-group=".col-md-4" placeholder="Banner 1 Affiliate Link" />
                        </div>
                    </div>


                </fieldset>


                <fieldset>

                    <div class="row">
                        <div class="col-md-3">

                            <label class="control-label">Banner 2 Heading Logo (555 X 157)</label>
                            <div>
                                <input type="file" class="btn btn-default" id="Banner2Url" name="Banner2Url">
                                <p class="help-block">

                                </p>
                            </div>
                            @if(isset($Model->Banner2Url))
                            <img style="width: 100px;" src="{{ url('/storage/bannerlogo').'/'.$Model->Banner2Url }}">
                            @endif

                        </div>
                        <div class="col-md-4">
                            <label class="control-label">Banner 2 Heading</label>
                            <input type="text" class="form-control" name="Banner2HeaderText" value="{{ old('Banner2HeaderText',$Model->Banner2HeaderText) }}" data-bv-group=".col-md-4" placeholder="Banner 2 Header Text" />
                        </div>
                        <div class="col-md-5">
                            <label class="control-label">Banner 2 Affiliate Link</label>
                            <input type="text" class="form-control" name="AffiliateLink2" value="{{ old('AffiliateLink2',$Model->AffiliateLink2) }}" data-bv-group=".col-md-4" placeholder="Banner 2 Affiliate Link" />
                        </div>
                    </div>


                </fieldset>

                <fieldset>

                    <div class="row">
                        <div class="col-md-3">

                            <label class="control-label">Banner 3 Heading Logo (555 X 157)</label>
                            <div>
                                <input type="file" class="btn btn-default" id="Banner3Url" name="Banner3Url">
                                <p class="help-block">

                                </p>
                            </div>
                            @if(isset($Model->Banner3Url))
                            <img style="width: 100px;" src="{{ url('/storage/bannerlogo').'/'.$Model->Banner3Url }}">
                            @endif

                        </div>
                        <div class="col-md-4">
                            <label class="control-label">Banner 3 Heading</label>
                            <input type="text" class="form-control" name="Banner3HeaderText" value="{{ old('Banner3HeaderText',$Model->Banner3HeaderText) }}" data-bv-group=".col-md-4" placeholder="Banner 3 Header Text" />
                        </div>
                        <div class="col-md-5">
                            <label class="control-label">Banner 3 Affiliate Link</label>
                            <input type="text" class="form-control" name="AffiliateLink3" value="{{ old('AffiliateLink3',$Model->AffiliateLink3) }}" data-bv-group=".col-md-4" placeholder="Banner 3 Affiliate Link" />
                        </div>
                    </div>


                </fieldset>


                <fieldset>

                    <div class="row">
                        <div class="col-md-3">

                            <label class="control-label">Banner 4 Heading Logo (1410 X 280)</label>
                            <div>
                                <input type="file" class="btn btn-default" id="Banner4Url" name="Banner4Url">
                                <p class="help-block">

                                </p>
                            </div>
                            @if(isset($Model->Banner4Url))
                            <img style="width: 100px;" src="{{ url('/storage/bannerlogo').'/'.$Model->Banner4Url }}">
                            @endif

                        </div>
                        <div class="col-md-4">
                            <label class="control-label">Banner 4 Heading</label>
                            <input type="text" class="form-control" name="Banner4HeaderText" value="{{ old('Banner4HeaderText',$Model->Banner4HeaderText) }}" data-bv-group=".col-md-4" placeholder="Banner 4 Header Text" />
                        </div>
                        <div class="col-md-5">
                            <label class="control-label">Banner 4 Affiliate Link</label>
                            <input type="text" class="form-control" name="AffiliateLink4" value="{{ old('AffiliateLink4',$Model->AffiliateLink4) }}" data-bv-group=".col-md-4" placeholder="Banner 4 Affiliate Link" />
                        </div>
                    </div>


                </fieldset>


                <fieldset>
                    <legend>Show Above Headers:</legend>
                    <div class="row">
                        <div class="col-md-8">
                            <div>
                                <label class="checkbox-inline ">
                                    <input id="IsBanner1Show" {{ old('IsBanner1Show',$Model->IsBanner1Show) == 1 ?  'checked' : '' }} name="IsBanner1Show" value="1" type="checkbox" class="checkbox style-0" />
                                    <span>Show Banner 1</span>
                                </label>
                                <label class="checkbox-inline ">
                                    <input id="IsBanner2Show" {{ old('IsBanner2Show',$Model->IsBanner2Show) == 1 ?  'checked' : '' }} name="IsBanner2Show" value="1" type="checkbox" class="checkbox style-0" />
                                    <span>Show Banner 2</span>
                                </label>
                                <label class="checkbox-inline ">
                                    <input id="IsBanner3Show" {{ old('IsBanner3Show',$Model->IsBanner3Show) == 1 ?  'checked' : '' }} name="IsBanner3Show" value="1" type="checkbox" class="checkbox style-0" />
                                    <span>Show Banner 3</span>
                                </label>
                                <label class="checkbox-inline ">
                                    <input id="IsBanner4Show" {{ old('IsBanner4Show',$Model->IsBanner4Show) == 1 ?  'checked' : '' }} name="IsBanner4Show" value="1" type="checkbox" class="checkbox style-0" />
                                    <span>Show Banner 4</span>
                                </label>

                            </div>
                        </div>
                    </div>
                </fieldset>

                <br />
                <br />
                @if (Auth::user()->isAdmin())
                <fieldset>
                    <legend>Seo Information (Only Change by Admin):<span data-toggle="modal" href="#systemValueModal" class="pull-right" style="cursor: pointer;">System Value Information : <span class="glyphicon glyphicon-info-sign"></span></span>
                    </legend>
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
                            <label class="control-label">Schema Org</label>
                            <textarea rows="8" class="form-control" name="SchemaOrg" placeholder="Schema Org" " data-bv-group=" .col-md-12">{{ old('SchemaOrg',$Model->SchemaOrg) }}</textarea>
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


                @can('Home Settings Edit')
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
    $('#homeSettingsForm').bootstrapValidator({
        excluded: ':disabled'
    });
</script>

@endsection