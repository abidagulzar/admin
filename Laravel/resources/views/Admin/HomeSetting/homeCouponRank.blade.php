@extends('Admin.Layout.master')
@section('pagebreadcrumb')
<ol class="breadcrumb">
    <li>Home Setings</li>
    <li>Home Rank Coupon</li>
</ol>
@endsection
@section('content')

<div class="jarviswidget" id="rankCouponWidget" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-sortable="false">

    <header>
        <h2>Home Rank Coupon </h2>
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

            self.GetCouponForRank = function() {

                var url = "{{ route('admin.homesetting.getcouponforrank') }}";


                CallAjaxService('GET', null, url, 'html', '', function(data) {

                    $(couponslistSelector).html(data);
                    self.MakeSortable();
                });



            }

            self.BindEvents = function() {

                self.GetCouponForRank();
            }
            self.UpdateRanks = function() {
                var list = new Array();
                var i = 0;
                $("#couponslist li").each(function() {
                    // list.push(this.id);
                    list[i] = this.id;
                    i++;
                });

                var url = "{{ route('admin.homesetting.updaterank') }}";

                if (list.length > 0) {
                    $.ajax({
                        type: "POST",
                        data: {
                            'list': JSON.stringify(list),
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