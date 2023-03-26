@extends('Admin.Layout.master')
@section('pagebreadcrumb')
<ol class="breadcrumb">
    <li>Store</li>
    <li>Edit</li>
</ol>
@endsection
@section('content')

<div class="jarviswidget" id="updateStoreWidget" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">

    <header>
        <h2>Update Store </h2>
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



            <form id="updateStoreForm" action="{{ route('admin.store.updatepost') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <fieldset>
                    <legend>Store Basic Info</legend>

                    <div class="row">
                        <div class="col-md-3">
                            <label class="control-label">Store Name</label>
                            <input type="text" class="form-control" name="Name" value="{{old('Name', $Model->Name)}}" placeholder="Store Name" data-bv-group=".col-md-3" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Regional Store Name</label>
                            <input type="text" class="form-control" name="RegionalName" value="{{old('RegionalName', $Model->RegionalName)}}" placeholder="Regional Store Name" data-bv-group=".col-md-3" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Store Name In Network</label>
                            <input type="text" class="form-control" name="StoreNetworkName" value="{{old('StoreNetworkName', $Model->StoreNetworkName)}}" placeholder="Store Name In Network" data-bv-group=".col-md-3" />
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Store Site Url</label>

                            <input type="text" class="form-control" name="SiteUrl" value="{{ old('SiteUrl', $Model->SiteUrl) }}" placeholder="Store Site Url" data-bv-group=".col-md-3" data-bv-notempty="true" data-bv-notempty-message="Information Required" />

                        </div>
                    </div>

                </fieldset>
                <fieldset>


                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Store Network Link</label>
                            <input type="text" class="form-control" name="StoreNetworkLink" value="{{ old('StoreNetworkLink', $Model->StoreNetworkLink) }}" data-bv-group=".col-md-6" placeholder="Store Network Link" data-bv-notempty="true" data-bv-notempty-message="Information Required" />

                        </div>

                        <div class="col-md-6">
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
                    </div>

                </fieldset>

                <fieldset>


                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Target Country</label>
                            <select multiple style="width:100%" id="CountryId" name="CountryId[]" class="select2" data-bv-group=".col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required">

                                @if(isset($countries))
                                @foreach($countries as $CountryId => $Name)
                                {{ $seleced = '' }}

                                <option value="{{ $CountryId }}" {{ (collect(old('CountryId',$storeCountries))->contains($CountryId)) ? 'selected':'' }}>{{ $Name }}</option>

                                @endforeach
                                @endif

                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">Store Setting</label>
                            <select data-placeholder="Please Select" style="width:100%" id="StoreSettingID" name="StoreSettingID" class="select2" data-bv-group=".col-md-3" data-bv-notempty="true" data-bv-notempty-message="Information Required">

                                <option></option>
                                @if(isset($storeSettings))
                                @foreach($storeSettings as $StoreSettingID => $Name)
                                {{ $seleced = '' }}

                                <option value="{{ $StoreSettingID }}" {{old('StoreSettingID', $Model->StoreSettingID)==$StoreSettingID? 'selected':''}}>{{ $Name }}</option>

                                @endforeach
                                @endif

                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">User Assigned</label>
                            <select data-placeholder="Please Select" style="width:100%" id="UserAssignedID" name="UserAssignedID" class="select2" data-bv-group=".col-md-3">

                                <option></option>
                                @if(isset($users))
                                @foreach($users as $id => $name)
                                {{ $seleced = '' }}

                                <option value="{{ $id }}" {{old('UserAssignedID', $Model->UserAssignedID)==$id? 'selected':''}}>{{ $name }}</option>

                                @endforeach
                                @endif

                            </select>
                        </div>
                    </div>

                </fieldset>


                <fieldset>


                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Exlude Country</label>
                            <select multiple style="width:100%" id="ExcludeCountryId" name="ExcludeCountryId[]" class="select2" data-bv-group=".col-md-6">

                                @if(isset($countries))
                                @foreach($countries as $CountryId => $Name)
                                {{ $seleced = '' }}

                                <option value="{{ $CountryId }}" {{ (collect(old('ExcludeCountryId',$storeExcludeCountries))->contains($CountryId)) ? 'selected':'' }}>{{ $Name }}</option>

                                @endforeach
                                @endif

                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="control-label">Revenue Model</label>
                            <select data-placeholder="Please Select" style="width:100%" id="RevenueModelID" name="RevenueModelID" class="select2" data-bv-group=".col-md-2" data-bv-notempty="true" data-bv-notempty-message="Information Required">

                                <option></option>
                                @if(isset($revenueModels))
                                @foreach($revenueModels as $RevenueModelID => $Name)
                                {{ $seleced = '' }}

                                <option value="{{ $RevenueModelID }}" {{old('RevenueModelID', $Model->RevenueModelID)==$RevenueModelID? 'selected':''}}>{{ $Name }}</option>

                                @endforeach
                                @endif

                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="control-label">Update Frequency (Days)</label>

                            <input type="number" class="form-control" name="StoreUpdateFrequency" value="{{ old('StoreUpdateFrequency', $Model->StoreUpdateFrequency) }}" placeholder="Update Frequency (Days)" data-bv-group=".col-md-2" data-bv-notempty="true" data-bv-notempty-message="Information Required" />

                        </div>
                        <div class="col-md-2">
                            <label class="control-label">Merchant ID</label>

                            <input type="number" class="form-control" name="MerchantID" value="{{ old('MerchantID', $Model->MerchantID) }}" placeholder="Merchant ID" data-bv-group=".col-md-2" />

                        </div>

                    </div>

                </fieldset>



                <fieldset>

                    <div class="row">
                        <div class="col-md-6">

                            <label class="control-label">Logo(200x200)</label>
                            <div>
                                <input type="file" class="btn btn-default" id="LogoUrl" name="LogoUrl">
                                <p class="help-block">

                                </p>
                            </div>
                            @if(isset($Model->LogoUrl))
                            <img style="width: 100px;" src="{{ url('/storage/storelogo').'/'.$Model->LogoUrl }}">
                            @endif



                        </div>
                        <div class="col-md-6">

                            <label class="control-label">Logo(600x400)</label>
                            <div>
                                <input type="file" class="btn btn-default" id="LogoUrl600X400" name="LogoUrl600X400">
                                <p class="help-block">

                                </p>
                            </div>
                            @if(isset($Model->LogoUrl600X400))
                            <img style="width: 100px;" src="{{ url('/storage/storelogo').'/'.$Model->LogoUrl600X400 }}">
                            @endif

                        </div>
                    </div>


                </fieldset>


                <fieldset>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Other Options</label>
                            <div>
                                <label class="checkbox-inline ">
                                    <input id="IsTopStore" {{ old('IsTopStore') == 1 || $Model->IsTopStore == 1 ?  'checked' : '' }} name="IsTopStore" value="1" type="checkbox" class="checkbox style-0" />

                                    <span>Top Store</span>
                                </label>
                                <label class="checkbox-inline">
                                    <input id="Enabled" name="Enabled" {{ old('Enabled') == 1 || $Model->Enabled == 1 ?  'checked' : '' }} value="1" type="checkbox" class="checkbox style-0">

                                    <span>Enabled</span>
                                </label>
                                <label class="checkbox-inline">
                                    <input id="IsHomeStore" name="IsHomeStore" {{ old('IsHomeStore') == 1 || $Model->IsHomeStore == 1 ?  'checked' : '' }} value="1" type="checkbox" class="checkbox style-0">

                                    <span>Home Store (Show at Home)</span>
                                </label>
                                <label class="checkbox-inline ">
                                    <input id="IsShowAdd" {{ old('IsShowAdd') == 1 || $Model->IsShowAdd == 1 ?  'checked' : '' }} name="IsShowAdd" value="1" type="checkbox" class="checkbox style-0" />

                                    <span>Show Add</span>
                                </label>
                                <!-- <input name="Enabled" value="1" type="hidden"></input>
                                <input name="IsTopCategory" value="0" type="hidden"></input> -->
                            </div>

                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Network</label>
                            <select style="width:100%" id="NetworkId" name="NetworkId" class="select2" data-bv-group=".col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required">

                                @if(isset($networks))
                                @foreach($networks as $NetworkId => $Name)
                                {{ $seleced = '' }}

                                <option value="{{ $NetworkId }}" {{old('NetworkId', $Model->NetworkId)==$NetworkId? 'selected':''}}>{{ $Name }}</option>

                                @endforeach
                                @endif

                            </select>
                        </div>
                    </div>
                </fieldset>


                <fieldset>


                    <div class="row">
                        <div class="col-md-6">

                            <label class="control-label">Similar Store</label>
                            <select multiple style="width:100%" id="SimilarStoreId" name="SimilarStoreId[]" class="select2" data-bv-group=".col-md-6">

                                @if(isset($storesList))
                                @foreach($storesList as $StoreId => $RegionalName)
                                {{ $seleced = '' }}

                                <option value="{{ $StoreId }}" {{ (collect(old('StoreId',$similarstores))->contains($StoreId)) ? 'selected':'' }}>{{ $RegionalName }}</option>

                                @endforeach
                                @endif

                            </select>



                        </div>
                    </div>

                </fieldset>



                <br />
                <legend>Store Content Info</legend>
                <fieldset>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Header 1</label>

                            <input type="text" class="form-control" name="Header1" value="{{ old('Header1', $Model->Header1) }}" placeholder="Header 1" data-bv-group=".col-md-6" />
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Description 1</label>

                            <textarea rows="4" class="form-control" name="Description1" placeholder="Description 1">{{ old('Description1', $Model->Description1) }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Header 2</label>

                            <input type="text" class="form-control" name="Header2" value="{{ old('Header2', $Model->Header2) }}" placeholder="Header 2" />
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Description 2</label>

                            <textarea rows="4" class="form-control" name="Description2" placeholder="Description 2">{{ old('Description2', $Model->Description2) }}</textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Header 3</label>

                            <input type="text" class="form-control" name="Header3" value="{{ old('Header3', $Model->Header3) }}" placeholder="Header 3" />
                        </div>

                        <div class="col-md-6">
                            <label class="control-label">Description 3</label>

                            <textarea rows="4" class="form-control" name="Description3" placeholder="Description 3">{{ old('Description3', $Model->Description3) }}</textarea>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Header 4</label>

                            <input type="text" class="form-control" name="Header4" value="{{ old('Header4', $Model->Header4) }}" placeholder="Header 4" />
                        </div>
                        <div class="col-md-6">

                            <label class="control-label">Description 4</label>

                            <textarea rows="4" class="form-control" name="Description4" placeholder="Description 4">{{ old('Description4', $Model->Description4) }}</textarea>

                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Header 5</label>

                            <input type="text" class="form-control" name="Header5" value="{{ old('Header5', $Model->Header5) }}" placeholder="Header 5" />
                        </div>

                        <div class="col-md-6">
                            <label class="control-label">Description 5</label>

                            <textarea rows="4" class="form-control" name="Description5" placeholder="Description 5">{{ old('Description5', $Model->Description5) }}</textarea>

                        </div>
                    </div>
                </fieldset>

                <br />
                <legend>SEO Related Info</legend>
                <fieldset>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Keyword in Url</label>

                            <input type="text" class="form-control" id="Keyword" name="Keyword" value="{{ old('Keyword', $Model->Keyword) }}" placeholder="Search Name" data-bv-group=".col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Display Name</label>
                            <input type="text" class="form-control" id="SEOStoreName" name="SEOStoreName" value="{{ old('SEOStoreName', $Model->SEOStoreName) }}" placeholder="Display Name" data-bv-group=".col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Content Link Text</label>
                            <input type="text" class="form-control" id="ContentLinkText" name="ContentLinkText" value="{{ old('ContentLinkText', $Model->ContentLinkText) }}" placeholder="Content Link Text" data-bv-group=".col-md-6" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Meta Title</label>

                            <input type="text" class="form-control" name="MetaTitle" value="{{ old('MetaTitle', $Model->MetaTitle) }}" placeholder="Meta Title" />
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Meta Keyword</label>

                            <input type="text" class="form-control tagsinput" name="MetaKeyword" value="{{ old('MetaKeyword', $Model->MetaKeyword) }}" placeholder="" data-role="tagsinput" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Meta Description</label>

                            <textarea rows="4" class="form-control" name="MetaDescription" placeholder="Meta Description">{{ old('MetaDescription', $Model->MetaDescription) }}</textarea>
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
                            <label class="control-label">Footer Text</label>
                            <textarea rows="2" class="form-control" name="FooterText" placeholder="FooterText">{{ old('FooterText', $Model->FooterText) }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Related Stores Text</label>

                            <textarea rows="2" class="form-control" name="RelatedStoresText" placeholder="Related Stores Text">{{ old('RelatedStoresText', $Model->RelatedStoresText) }}</textarea>
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
                <input name="StoreId" value="{{$Model->StoreId}}" type="hidden"></input>
                @can('Store Edit')
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary" onsubmit="return validateForm()" type="submit">
                                <i class="fa fa-save"></i>
                                Update Store
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
    $('#updateStoreForm').bootstrapValidator({
        excluded: ':disabled'
    });
</script>

@endsection