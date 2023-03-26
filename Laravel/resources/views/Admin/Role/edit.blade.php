@extends('Admin.Layout.master')
@section('pagebreadcrumb')
<ol class="breadcrumb">
    <li>Role</li>
    <li>Edit</li>
</ol>
@endsection
@section('content')

<div class="jarviswidget" id="updateRoleWidget" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">

    <header>
        <h2>Update Role </h2>
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



            <form id="updateRoleForm" action="{{ route('admin.role.updatepost') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <fieldset>
                    <legend>Role Basic Info</legend>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Name</label>
                            <input type="text" class="form-control" name="name" value="{{old('name', $role->name)}}" placeholder="Name" data-bv-group=".col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
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
                                        <input type="checkbox" name="permission[]" value="{{$value->id}}" data-bv-message="Please select at least one Permission." data-bv-notempty="true" {{ (collect(old('id',$rolePermissions))->contains($value->id)) ? 'checked':'' }} />
                                        {{$value->name}} </label>
                                </div>

                                @endforeach

                            </div>
                        </div>
                    </div>

                </fieldset>

                <input name="RoleId" value="{{$role->id}}" type="hidden"></input>
                <!-- @can('Role Edit') -->
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-save"></i>
                                Update Role
                            </button>
                        </div>
                    </div>
                </div>
                <!-- @endcan -->

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
    $('#updateRoleForm').bootstrapValidator({
        excluded: ':disabled'
    });
</script>

@endsection