@extends('Admin.Layout.master')
@section('pagebreadcrumb')
<ol class="breadcrumb">
    <li>Category</li>
    <li>Edit</li>
</ol>
@endsection
@section('content')

<div class="jarviswidget" id="editCategoryWidget" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">

    <header>
        <h2>Edit Category </h2>
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



            <form id="editCategoryForm" action="{{ route('admin.category.editpost') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <fieldset>
                    <legend>Category Basic Info</legend>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Category Name</label>
                            <input type="text" class="form-control" id="Name" name="Name" value="{{old('Name', $Model->Name)}}" placeholder="Category Name" data-bv-group=".col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>

                        <div class="col-md-6">
                            <label class="control-label">Mother Category</label>
                            <select style="width:100%" id="MotherCategory" name="MotherCategory" class="select2">

                                <option value="">None</option>
                                @if(isset($categories))
                                @foreach($categories as $CategoryId => $Name)
                                {{ $seleced = '' }}

                                <option value="{{ $CategoryId }}" {{old('MotherCategory') == $CategoryId || $Model->MotherCategory == $CategoryId ? 'selected':''}}>{{ $Name }}</option>

                                @endforeach
                                @endif

                            </select>
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
                            <img style="width: 100px;" src="{{ url('/storage/categorylogo').'/'.$Model->LogoUrl }}">
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Other Options</label>
                            <div>
                                <label class="checkbox-inline ">
                                    <input id="IsTopCategory" {{ old('IsTopCategory') == 1 || $Model->IsTopCategory == 1 ?  'checked' : '' }} name="IsTopCategory" value="1" type="checkbox" class="checkbox style-0" />

                                    <span>Top Category</span>
                                </label>
                                <label class="checkbox-inline">
                                    <input id="Enabled" name="Enabled" {{ old('Enabled') == 1 || $Model->Enabled == 1 ?  'checked' : '' }} value="1" type="checkbox" class="checkbox style-0">

                                    <span>Enabled</span>
                                </label>
                                <label class="checkbox-inline">
                                    <input id="IsHomeCategory" name="IsHomeCategory" {{ old('IsHomeCategory') == 1 || $Model->IsHomeCategory == 1 ?  'checked' : '' }} value="1" type="checkbox" class="checkbox style-0">

                                    <span>Home Category(Show at Home)</span>
                                </label>
                                <!-- <input name="Enabled" value="1" type="hidden"></input>
                                <input name="IsTopCategory" value="0" type="hidden"></input> -->
                            </div>

                        </div>

                    </div>


                </fieldset>


                <fieldset>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Icon Class</label>
                            <input type="text" class="form-control" id="IconClass" name="IconClass" value="{{ old('IconClass',$Model->IconClass) }}" placeholder="Icon Class" data-bv-group=".col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                    </div>
                </fieldset>

                <br />
                <legend>Category Content Info</legend>
                <fieldset>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Header</label>

                            <input type="text" class="form-control" name="Header" value="{{old('Header', $Model->Header)}}" placeholder="Header" data-bv-group=".col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Description</label>

                            <textarea rows="4" class="form-control" name="Description" placeholder="Description">{{old('Description', $Model->Description)}}</textarea>
                        </div>
                    </div>

                </fieldset>

                <br />
                <legend>SEO Related Info</legend>
                <fieldset>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Keyword in Url</label>

                            <input type="text" value="{{old('Keyword', $Model->Keyword)}}" class="form-control" id="Keyword" name="Keyword" placeholder="Search Name" data-bv-group=".col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Meta Title</label>

                            <input type="text" class="form-control" name="MetaTitle" value="{{old('MetaTitle', $Model->MetaTitle)}}" placeholder="Meta Title" />
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Meta Keyword</label>

                            <input type="text" class="form-control" name="MetaKeyword" value="{{old('MetaKeyword', $Model->MetaKeyword)}}" placeholder="Meta Keyword" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Meta Description</label>

                            <textarea rows="4" class="form-control" name="MetaDescription" placeholder="Meta Description">{{old('MetaDescription', $Model->MetaDescription)}}</textarea>
                        </div>
                    </div>

                </fieldset>
                <input name="CategoryId" value="{{$Model->CategoryId}}" type="hidden"></input>
                @can('Category Delete')
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary" onsubmit="return validateForm()" type="submit">
                                <i class="fa fa-save"></i>
                                Update Category
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
    $('#editCategoryForm').bootstrapValidator({
        excluded: ':disabled'
    });
</script>

@endsection