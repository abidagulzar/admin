@extends('Admin.Layout.master')

@section('pagebreadcrumb')
<ol class="breadcrumb">
    <li>Coupon</li>
    <li>List</li>
</ol>
@endsection
@section('content')

<section id="widget-grid" class="">


    <div class="row">


        <div class="col-md-3">
            <label class="control-label">User Name</label>
            <select style="width:100%" id="UserId" name="UserId" @if (!Auth::user()->isAdmin())
                disabled="disabled"
                @endif
                class="select2">


                @if(isset($users))
                @foreach($users as $id => $name)
                {{ $seleced = '' }}

                <option value="{{ $id }}" {{Auth::user()->id == $id ? 'selected':''}}>{{ $name }}</option>

                @endforeach
                @endif

            </select>
        </div>
        <div class="col-md-3">
            <label>Start Date:</label>
            <div class="input-group">
                <input type="text" id="StartDate" name="StartDate" value="{{ old('StartDate') }}" autocomplete="off" placeholder="Start Date" class="form-control datepicker" data-dateformat="dd/mm/yy">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            </div>
        </div>
        <div class="col-md-3">
            <label>End Date:</label>
            <div class="input-group">
                <input type="text" id="EndDate" name="EndDate" value="{{ old('EndDate') }}" autocomplete="off" placeholder="End Date" class="form-control datepicker" data-dateformat="dd/mm/yy">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            </div>
        </div>
        <div class="col-md-3">
            <label class="control-label">Group BY</label>
            <select style="width:100%" id="GroupBy" name="GroupBy" class="select2">
                <option value="day">Day</option>
                <option value="store">Store</option>
            </select>
        </div>
    </div>
    <br />
    <div class="row">
        <div class="col-md-12">
            <div class="input-group pull-right">
                <button id="btnSearch" type="button" class="btn btn-primary">Search</button>
            </div>

        </div>
    </div>
    <br />
    <!-- row -->
    <div class="row">

        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">
                <!-- widget options:
								usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">
				
								data-widget-colorbutton="false"
								data-widget-editbutton="false"
								data-widget-togglebutton="false"
								data-widget-deletebutton="false"
								data-widget-fullscreenbutton="false"
								data-widget-custombutton="false"
								data-widget-collapsed="true"
								data-widget-sortable="false"
				
								-->
                <header>
                    <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                    <h2>User Coupons</h2>

                </header>

                <!-- widget div-->
                <div>

                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">
                        <!-- This area used as dropdown edit box -->

                    </div>
                    <!-- end widget edit box -->

                    <!-- widget content -->
                    <div class="widget-body no-padding">

                        <table id="usercoupon_table" class="table table-striped table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th id="tableStoreHeader">Store</th>
                                    <th>Network</th>
                                    <th>User Name</th>
                                    <th>Created Coupon (<span id="totalCreatedHeader"></span>) </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>

                                    <th class="searchable"></th>
                                    <th class="searchable"></th>
                                    <th class="searchable"></th>
                                    <th class="searchable"></th>
                                    <th class="searchable"></th>

                                </tr>
                            </tfoot>
                        </table>

                    </div>
                    <!-- end widget content -->

                </div>
                <!-- end widget div -->

            </div>
            <!-- end widget -->

        </article>
        <!-- WIDGET END -->

    </div>

    <!-- end row -->

    <!-- end row -->
    @can('Coupon Delete')
    <div id="deleteCouponModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Coupon</h4>
                </div>
                <div class="modal-body">
                    <div id="deleteCouponText"></div>
                </div>

                <form class="form-horizontal" id="deleteCouponForm" method="post" action="{{ route('admin.coupon.delete') }}">
                    {{ csrf_field() }}
                    <input type="hidden" id="CouponId" name="CouponId" class="delete" />
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-danger">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan

</section>

@endsection
@section('pagescripts')
<script type="text/javascript">
    var CouponModule = (function() {

            var responsiveHelper_usercoupon_table = undefined;
            var self = {};
            var editCouponModelSelector = "#editCouponModal";
            var editCouponPasswordModelSelector = "#editCouponPasswordModal";
            var createCouponModelSelector = "#createCouponModal";
            var deleteCouponModelSelector = "#deleteCouponModal";

            var couponTable = null;

            var breakpointDefinition = {
                tablet: 1024,
                phone: 480
            };

            self.deleteCouponModal = function(couponId, couponName) {

                $("#deleteCouponText").html("Do you want to delete Coupon with Header <b>" + couponName + "</b> ?");

                $("#CouponId.delete").val(couponId);

                $(deleteCouponModelSelector).modal('show');
            }



            self.BindEvents = function() {

                $('#UserId').on("select2:select", function(e) {
                    couponTable.ajax.reload();
                });

                $('#GroupBy').on("select2:select", function(e) {
                    couponTable.ajax.reload();
                });


                $("#btnSearch").off().click(function() {
                    couponTable.ajax.reload();
                });


                // $("#btnDeleteCoupon").off().click(function() {

                //     var checked = $(".selectrowcheckbox:checked");
                //     if (checked.length == 0) {
                //         showErrorMessgae("Select some coupons to delete.");
                //     } else {

                //         $("#deleteCouponText").html("Do you want to delete selected coupons ?");

                //         var ids = checked.map(function() {
                //             return $(this).data('id');
                //         }).get().toString();

                //         $("#CouponId.delete").val(ids);

                //         $(deleteCouponModelSelector).modal('show');
                //     }
                // });

            }

            self.SelectAllList = function(obj) {
                if ($(obj).is(":checked")) {
                    $(".selectrowcheckbox").attr("checked", "checked").prop("checked", "checked");
                } else {

                    $(".selectrowcheckbox").removeAttr("checked")
                }

            }
            //'CouponId', 'Code', 'Header', 'ExpiryDate', 'IsBanner', 'HomeCoupon', 'IsHeaderDeal'
            self.BindCouponTable = function() {
                couponTable = $('#usercoupon_table').DataTable({
                    "deferRender": true,
                    "sAjaxSource": "{{ route('admin.usercoupon.index') }}",
                    "fnServerParams": function(aoData) {

                        var splitedStart = $("#StartDate").val().split('/');
                        var splitedEnd = $("#EndDate").val().split('/');
                        var startDate = splitedStart[2] + "-" + splitedStart[1] + "-" + splitedStart[0];
                        var endDate = splitedEnd[2] + "-" + splitedEnd[1] + "-" + splitedEnd[0];
                        aoData.push({
                            "name": "UserId",
                            "value": $("#UserId").val()
                        }, {
                            "name": "StartDate",
                            "value": startDate
                        }, {
                            "name": "GroupBy",
                            "value": $("#GroupBy").val()
                        }, {
                            "name": "EndDate",
                            "value": endDate
                        });
                    },
                    "aoColumns": [{

                            "render": function(data, type, row, val) {
                                {
                                    if (row.CreateDate) {
                                        var splited = row.CreateDate.split(' ')[0].split('-');

                                        return splited[2] + "/" + splited[1] + "/" + splited[0]
                                    }

                                    return "";
                                }
                            },
                            "sClass": "text-center"
                        },
                        {
                            "render": function(data, type, row, val) {

                                if ($("#GroupBy").val() == "day") {

                                    $("#tableStoreHeader").html("Day of Week");
                                    var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                                    var d = new Date(row.CreateDate);
                                    var dayName = days[d.getDay()]

                                    return dayName;
                                } else {
                                    $("#tableStoreHeader").html("Store");
                                    return row.StoreName;
                                }

                            },
                            "sClass": "text-center"
                        },
                        {
                            "mData": "NetworkName",
                            "sClass": "text-center"
                        },

                        {
                            "mData": "UserName",
                            "sClass": "text-center"
                        },
                        {
                            "mData": "TotalCreated",
                            "sClass": "text-center"
                        }
                    ],
                    "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
                        "t" +
                        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
                    "autoWidth": true,
                    "preDrawCallback": function() {
                        // Initialize the responsive datatables helper once.
                        if (!responsiveHelper_usercoupon_table) {
                            responsiveHelper_usercoupon_table = new ResponsiveDatatablesHelper($('#usercoupon_table'), breakpointDefinition);
                        }
                    },
                    "rowCallback": function(nRow) {
                        responsiveHelper_usercoupon_table.createExpandIcon(nRow);
                    },
                    "drawCallback": function(oSettings) {
                        responsiveHelper_usercoupon_table.respond();
                    },
                    "fnFooterCallback": function(nFoot, aaData, iStart, iEnd, aiDisplay) {
                        var total = 0;
                        for (i = 0; i < aaData.length; i++) {
                            total += parseInt(aaData[i].TotalCreated);
                        }

                        $("#totalCreatedHeader").html(total);
                    }

                });



                // Apply the filter
                $("#usercoupon_table thead th input[type=text]").on('keyup change', function() {

                    otable
                        .column($(this).parent().index() + ':visible')
                        .search(this.value)
                        .draw();

                });

                // Setup - add a text input to each footer cell
                $('#usercoupon_table tfoot th.searchable').each(function() {
                    var title = $(this).text();
                    $(this).html('<input type="text" placeholder="Search ' + title + '" />');
                });



                // Apply the search
                couponTable.columns().every(function() {
                    var that = this;

                    $('input', this.footer()).on('keyup change clear', function() {
                        if (that.search() !== this.value) {
                            that
                                .search(this.value)
                                .draw();
                        }
                    });
                });
            }

            return self;
        }()

    );

    jQuery(function($) {
        $(".datepicker").datepicker("setDate", new Date());
        CouponModule.BindCouponTable();
        CouponModule.BindEvents();

    });
</script>

@endsection