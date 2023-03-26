@extends('Admin.Layout.master')
@section('pagebreadcrumb')
<ol class="breadcrumb">
    <li>Role</li>
    <li>Create</li>
</ol>
@endsection
@section('content')

<div class="jarviswidget" id="createRoleWidget" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">

    <header>
        <h2>Create Role </h2>
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



            <form id="createRoleForm" action="{{ route('admin.role.createpost') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <fieldset>
                    <legend>Role Basic Info</legend>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Name</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Name" data-bv-group=".col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>


                    </div>

                </fieldset>
                <br />
                <fieldset>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Permissions</label>


                                @foreach($permission as $value)


                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="permission[]" value="{{$value->id}}" data-bv-message="Please select at least one Permission." data-bv-notempty="true" />
                                        {{$value->name}} </label>
                                </div>

                                @endforeach

                            </div>
                        </div>
                    </div>

                </fieldset>



                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-save"></i>
                                Create Role
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
    $('#createRoleForm').bootstrapValidator({
        excluded: ':disabled'
    });
</script>

@endsection