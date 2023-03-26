@extends('Admin.Layout.master')
@section('pagebreadcrumb')
<ol class="breadcrumb">
    <li>Traffoc Analysis</li>
    <li>Visitor IP Exclude</li>
    <li>Edit</li>
</ol>
@endsection
@section('content')

<div class="jarviswidget" id="updateExcludeTrafficIPWidget" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">

    <header>
        <h2>Update Exclude Traffic IP </h2>
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



            <form id="updateExcludeTrafficIPForm" action="{{ route('admin.excludetrafficip.updatepost') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <fieldset>
                    <legend>Exclude Traffic IP Basic Info</legend>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Title</label>
                            <input type="text" class="form-control" name="Title" value="{{old('Title', $Model->Title)}}" placeholder="Title" data-bv-group=".col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>

                        <div class="col-md-6">
                            <label class="control-label">IP</label>

                            <input type="text" class="form-control" name="IP" value="{{ old('IP', $Model->IP) }}" placeholder="IP" data-bv-group=".col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required" />

                        </div>
                    </div>
                    <input name="ExcludeTrafficIPId" value="{{$Model->ExcludeTrafficIPID}}" type="hidden"></input>
                </fieldset>

                @can('VisitorIPExclude Edit')
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary" onsubmit="return validateForm()" type="submit">
                                <i class="fa fa-save"></i>
                                Update Exclude Traffic IP
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
    $('#updateExcludeTrafficIPForm').bootstrapValidator({
        excluded: ':disabled'
    });
</script>

@endsection