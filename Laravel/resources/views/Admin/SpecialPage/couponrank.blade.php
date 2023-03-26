@extends('Admin.Layout.master')
@section('pagebreadcrumb')
<ol class="breadcrumb">
    <li>Coupon</li>
    <li>Rank Coupon</li>
</ol>
@endsection
@section('content')
<section id="widget-grid" class="">
    <div class="row">
        <div class="col-md-4">
            <label class="control-label">Page Name</label>
            <select style="width:100%" id="SpecialPageId" name="SpecialPageId" class="select2">


                @if(isset($specialPages))
                @foreach($specialPages as $SpecialPageId => $Name)
                {{ $seleced = '' }}

                <option value="{{ $SpecialPageId }}">{{ $Name }}</option>

                @endforeach
                @endif

            </select>
        </div>
        <div class="col-md-3">
            <div class="input-group pull-right">
                <button id="btnSearch" type="button" class="btn btn-primary">Search</button>
            </div>
        </div>
    </div>
</section>
<br />
<div class="jarviswidget" id="rankCouponWidget" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">

    <header>
        <h2>Rank Coupon </h2>
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
            <div>
                <ul id="couponslist">

                </ul>
            </div>

        </div>
        <!-- end widget content -->

    </div>
    <!-- end widget div -->

</div>
<div class="row">
    <div class="col-md-12">
        <button class="btn btn-primary" onclick="CouponRankModule.UpdateRanks()" type="button">
            <i class="fa fa-save"></i>
            Update Rank
        </button>
    </div>
</div>
<!-- end widget -->

@endsection
@section('pagestyles')
<style type="text/css">
    .list {
        background-color: pink;
        font-size: 13px;
        text-align: center;
        cursor: pointer;
        font-family: Geneva, Arial, Helvetica, sans-serif;
        border: 1px solid gray;
    }

    #couponslist .ui-selected {
        background: red;
        color: white;
        font-weight: bold;
    }

    #couponslist {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    #couponslist li {
        float: left;
        margin: 2px;
        padding: 2px;
        width: 150px;
        height: 150px;
        line-height: 30px;
    }

    .highlight {
        border: 2px solid red;
        font-weight: bold;
        font-size: 10px;
        background-color: lightblue;
    }
</style>
@endsection
@section('pagescripts')

<script>
    var CouponRankModule = (function() {

            var self = {};
            var couponslistSelector = "#couponslist";

            self.BindEvents = function() {
                $('#SpecialPageId').on("select2:select", function(e) {

                    var url = "{{ route('admin.specialpage.getcouponforrank',':id') }}";
                    url = url.replace(':id', $('#SpecialPageId').val());

                    CallAjaxService('GET', null, url, 'html', '', function(data) {

                        $(couponslistSelector).html(data);
                        self.MakeSortable();
                    });

                });
                $('#SpecialPageId').trigger("select2:select");

                $("#btnSearch").off().click(function() {
                    $('#SpecialPageId').trigger("select2:select");
                });
            }
            self.UpdateRanks = function() {
                var list = new Array();
                var specialPageId = $('#SpecialPageId').val();
                var i = 0;
                $("#couponslist li").each(function() {
                    // list.push(this.id);
                    list[i] = this.id;
                    i++;
                });

                var url = "{{ route('admin.specialpage.updaterank') }}";

                if (list.length > 0) {
                    $.ajax({
                        type: "POST",
                        data: {
                            'list': JSON.stringify(list),
                            'specialPageId': specialPageId
                        },
                        url: url,
                        dataType: 'json',
                        success: function(res) {
                            if (res == 1) {
                                $('#StoreId').trigger("select2:select");
                                showSuccessMessgae("Rank Updated Successfully!!!");
                            } else {
                                showSuccessMessgae("An Error has occured!!!");
                            }
                        }
                    });
                }
            }

            self.MakeSortable = function() {
                $(couponslistSelector).sortable({
                    start: function(event, ui) {
                        ui.item.toggleClass("highlight");
                    },
                    stop: function(event, ui) {
                        ui.item.toggleClass("highlight");
                    }
                });
                $(couponslistSelector).disableSelection();

            }
            return self;
        }()

    );

    jQuery(function($) {
        CouponRankModule.BindEvents();

    });
</script>
@endsection