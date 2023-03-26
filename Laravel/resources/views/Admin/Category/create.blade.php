@extends('Admin.Layout.master')
@section('pagebreadcrumb')
<ol class="breadcrumb">
    <li>Category</li>
    <li>Create</li>
</ol>
@endsection
@section('content')

<div class="jarviswidget" id="createCategoryWidget" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">

    <header>
        <h2>Create Category </h2>
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



            <form id="createCategoryForm" action="{{ route('admin.category.createpost') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <fieldset>
                    <legend>Category Basic Info</legend>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Category Name</label>
                            <input type="text" class="form-control" id="Name" name="Name" value="{{ old('Name') }}" placeholder="Category Name" data-bv-group=".col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>

                        <div class="col-md-6">
                            <label class="control-label">Mother Category</label>
                            <select style="width:100%" id="MotherCategory" name="MotherCategory" class="select2">

                                <option value="">None</option>
                                @if(isset($categories))
                                @foreach($categories as $CategoryId => $Name)
                                {{ $seleced = '' }}

                                <option value="{{ $CategoryId }}" {{old('MotherCategory')==$CategoryId? 'selected':''}}>{{ $Name }}</option>

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

                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Other Options</label>
                            <div>
                                <label class="checkbox-inline ">
                                    <input id="IsTopCategory" {{ old('IsTopCategory') == 1 ?  'checked' : '' }} name="IsTopCategory" value="1" type="checkbox" class="checkbox style-0" />

                                    <span>Top Category</span>
                                </label>
                                <label class="checkbox-inline">
                                    <input checked="checked" id="Enabled" name="Enabled" {{ old('Enabled') == 1 ?  'checked' : '' }} value="1" type="checkbox" class="checkbox style-0">

                                    <span>Enabled</span>
                                </label>
                                <label class="checkbox-inline">
                                    <input checked="checked" id="IsHomeCategory" name="IsHomeCategory" {{ old('IsHomeCategory') == 1 ?  'checked' : '' }} value="1" type="checkbox" class="checkbox style-0">
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
                            <input type="text" class="form-control" id="IconClass" name="IconClass" value="{{ old('IconClass') }}" placeholder="Icon Class" data-bv-group=".col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                    </div>
                </fieldset>

                <br />
                <legend>Category Content Info</legend>
                <fieldset>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Header</label>

                            <input type="text" class="form-control" name="Header" value="{{ old('Header') }}" placeholder="Header" data-bv-group=".col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Description</label>

                            <textarea rows="4" class="form-control" name="Description" placeholder="Description">{{ old('Description') }}</textarea>
                        </div>
                    </div>

                </fieldset>

                <br />
                <legend>SEO Related Info</legend>
                <fieldset>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Keyword in Url</label>

                            <input type="text" value="{{ old('Keyword') === null ?  'coupon-codes' : old('Keyword') }}" class="form-control" id="Keyword" name="Keyword" placeholder="Search Name" data-bv-group=".col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Meta Title</label>

                            <input type="text" class="form-control" name="MetaTitle" value="{{ old('MetaTitle') }}" placeholder="Meta Title" />
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Meta Keyword</label>

                            <input type="text" class="form-control" name="MetaKeyword" value="{{ old('MetaKeyword') }}" placeholder="Meta Keyword" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Meta Description</label>

                            <textarea rows="4" class="form-control" name="MetaDescription" placeholder="Meta Description">{{ old('MetaDescription') }}</textarea>
                        </div>
                    </div>

                </fieldset>

                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary" onsubmit="return validateForm()" type="submit">
                                <i class="fa fa-save"></i>
                                Create Category
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
<script>
    $('#createCategoryForm').bootstrapValidator({
        excluded: ':disabled'
    });
</script>

@endsection