@extends('Admin.Layout.master')
@section('pagebreadcrumb')
<ol class="breadcrumb">
    <li>Special Page</li>
    <li>Edit</li>

</ol>
@endsection
@section('content')

<div class="jarviswidget" id="updateStoreWidget" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">

    <header>
        <h2>Update Special Page </h2>
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



            <form id="updateStoreForm" action="{{ route('admin.specialpage.updatepost') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <fieldset>
                    <legend>Special Page Basic Info</legend>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Name</label>
                            <input type="text" class="form-control" name="Name" value="{{ old('Name', $Model->Name) }}" placeholder="Name" data-bv-group=".col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Title</label>
                            <input type="text" class="form-control" name="Title" value="{{ old('Title', $Model->Title) }}" placeholder="Title" data-bv-group=".col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>


                    </div>

                </fieldset>
                <fieldset>


                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">URL(Must not Contain Special Charaters and Spaces)</label>
                            <input type="text" class="form-control" name="URL" value="{{ old('URL', $Model->URL) }}" data-bv-group=".col-md-6" placeholder="URL" data-bv-notempty="true" data-bv-notempty-message="Information Required" />

                        </div>

                        <div class="col-md-6">
                            <label class="control-label">Category</label>
                            <select style="width:100%" id="CategoryId" name="CategoryId" class="select2" data-bv-group=".col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required">

                                @if(isset($categories))
                                @foreach($categories as $CategoryId => $Name)
                                {{ $seleced = '' }}

                                <option value="{{ $CategoryId }}" {{old('CategoryId', $Model->CategoryId)==$CategoryId? 'selected':''}} }}>{{ $Name }}</option>

                                @endforeach
                                @endif

                            </select>
                        </div>
                    </div>

                </fieldset>

                <fieldset>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Big Title</label>
                            <input type="text" class="form-control" name="BigTitle" value="{{ old('BigTitle',$Model->BigTitle) }}" placeholder="Big Title" data-bv-group=".col-md-6" />
                        </div>

                        <div class="col-md-6">
                            <label class="control-label">Sub Title</label>
                            <input type="text" class="form-control" name="SubTitle" value="{{ old('SubTitle',$Model->SubTitle) }}" placeholder="Sub Title" data-bv-group=".col-md-6" />
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Filter with Keywords in Heading/Description</label>
                            <input class="form-control tagsinput" name="FilterKeywords" value="{{ old('FilterKeywords',$Model->FilterKeywords) }}" data-role="tagsinput">
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
                            @if(isset($Model->LogoUrl))
                            <img style="width: 100px;" src="{{ url('/storage/specialpagelogo').'/'.$Model->LogoUrl }}">
                            @endif


                        </div>
                        <div class="col-md-6">

                            <label class="control-label">Banner</label>
                            <div>
                                <input type="file" class="btn btn-default" id="BannerUrl" name="BannerUrl">
                                <p class="help-block">

                                </p>
                            </div>
                            @if(isset($Model->BannerUrl))
                            <img style="width: 100px;" src="{{ url('/storage/specialpagelogo').'/'.$Model->BannerUrl }}">
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
                                    <input id="IsCurrentEventPage" {{ old('IsCurrentEventPage',$Model->IsCurrentEventPage) == 1 ?  'checked' : '' }} name="IsCurrentEventPage" value="1" type="checkbox" class="checkbox style-0" />
                                    <span>Current Event Page</span>
                                </label>
                                <label class="checkbox-inline">
                                    <input id="IsActive" name="IsActive" {{ old('IsActive',$Model->IsActive) == 1 ?  'checked' : '' }} value="1" type="checkbox" class="checkbox style-0">
                                    <span>Enabled</span>
                                </label>
                            </div>

                        </div>
                    </div>
                </fieldset>
                <br />
                <legend>SpecialPage Content Info</legend>
                <fieldset>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Description</label>

                            <textarea rows="4" class="form-control" name="Description" placeholder="Description">{{ old('Description',$Model->Description) }}</textarea>
                        </div>
                    </div>
                </fieldset>

                <br />
                <legend>SEO Related Info</legend>
                <fieldset>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Meta Title</label>

                            <input type="text" class="form-control" name="MetaTitle" value="{{ old('MetaTitle',$Model->MetaTitle) }}" placeholder="Meta Title" />
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Meta Keyword</label>

                            <input type="text" class="form-control" name="MetaKeyword" value="{{ old('MetaKeyword',$Model->MetaKeyword) }}" placeholder="Meta Keyword" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Meta Description</label>

                            <textarea rows="4" class="form-control" name="MetaDescription" placeholder="Meta Description">{{ old('MetaDescription',$Model->MetaDescription) }}</textarea>
                        </div>
                    </div>
                </fieldset>
                <input name="SpecialPageId" value="{{$Model->SpecialPageId}}" type="hidden"></input>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary" onsubmit="return validateForm()" type="submit">
                                <i class="fa fa-save"></i>
                                Update Special Page
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