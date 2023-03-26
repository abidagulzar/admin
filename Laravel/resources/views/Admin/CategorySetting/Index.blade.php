@extends('Admin.Layout.master')

@section('pagebreadcrumb')
<ol class="breadcrumb">
    <li>Category</li>
    <li>Category Settings</li>
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

<div class="jarviswidget" id="categorySettingsWidget" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">

    <header>
        <h2>Category Settings</h2>
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



            <form id="categorySettingsForm" action="{{ route('admin.categorysetting.updatepost') }}" enctype="multipart/form-data" method="POST">
                @csrf

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


                @can('Category Settings Edit')
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
    $('#categorySettingsForm').bootstrapValidator({
        excluded: ':disabled'
    });
</script>

@endsection