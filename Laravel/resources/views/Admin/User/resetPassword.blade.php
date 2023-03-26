@extends('Admin.Layout.master')
@section('pagebreadcrumb')
<ol class="breadcrumb">
    <li>User</li>
    <li>Reset Passsword</li>
</ol>
@endsection
@section('content')

<div class="jarviswidget" id="resetUserPasswordWidget" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">

    <header>
        <h2>Reset User Password </h2>
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



            <form id="resetUserPasswordForm" action="{{ route('admin.user.updatepassword') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <fieldset>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Name</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" readonly placeholder="Name" data-bv-group=".col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>

                        <div class="col-md-6">
                            <label class="control-label">Email</label>

                            <input type="text" class="form-control" name="email" value="{{ old('email', $user->email) }}" readonly placeholder="Email" data-bv-group=".col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required" />

                        </div>
                    </div>

                </fieldset>
                <fieldset>


                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label">Password</label>
                            <input type="password" class="form-control" name="password" value="{{ old('password') }}" data-bv-group=".col-md-6" placeholder="Password" data-bv-notempty="true" data-bv-notempty-message="Information Required" data-bv-identical="true" data-bv-identical-field="confirm-password" data-bv-identical-message="Password and confirm Password are not the same" />
                        </div>
                        <div class="col-md-6">
                            <label class="control-label">Confirm Password</label>
                            <input type="password" class="form-control" name="confirm-password" value="{{ old('confirm-password') }}" data-bv-identical="true" data-bv-identical-field="password" data-bv-identical-message="Password and confirm Password are not the same" data-bv-group=".col-md-6" placeholder="Confirm Password" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>


                    </div>

                </fieldset>


                <input name="UserId" value="{{$user->id}}" type="hidden"></input>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-save"></i>
                                Reset User Password
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
    $('#resetUserPasswordForm').bootstrapValidator({
        excluded: ':disabled'
    });
</script>

@endsection