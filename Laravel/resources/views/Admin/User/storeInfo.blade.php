<div class="jarviswidget" id="createCouponWidget" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">

    <header>
        <h2>Store Info </h2>
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

            <form id="updateStoreForm" action="" enctype="multipart/form-data">

                <fieldset>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="control-label">Store Name</label>
                            <input type="text" class="form-control" name="Name" value="{{old('Name', $Model->Name)}}" placeholder="Store Name" data-bv-group=".col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required" />
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="control-label">Store Site Url</label>

                            <input type="text" class="form-control" name="SiteUrl" value="{{ old('SiteUrl', $Model->SiteUrl) }}" placeholder="Store Site Url" data-bv-group=".col-md-6" data-bv-notempty="true" data-bv-notempty-message="Information Required" />

                        </div>
                    </div>

                </fieldset>
                <fieldset>


                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="control-label">Store Network Link</label>
                            <input type="text" class="form-control" id="StoreNetworkLink" name="StoreNetworkLink" value="{{ old('StoreNetworkLink', $Model->StoreNetworkLink) }}" data-bv-group=".col-md-6" placeholder="Store Network Link" data-bv-notempty="true" data-bv-notempty-message="Information Required" />

                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
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

        </div>
    </div>
</div>