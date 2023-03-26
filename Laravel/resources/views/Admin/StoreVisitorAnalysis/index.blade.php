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
            <label class="control-label">Network</label>
            <select style="width:100%" id="NetworkId" name="NetworkId" class="select2">
                <option value="0">All</option>
                @if(isset($network))
                @foreach($network as $NetworkId => $Name)
                <option value="{{ $NetworkId }}" selected>{{ $Name }}</option>

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
    </div>
    <br />
    <div class="row">
        <div class="col-md-12">
            <div class="input-group pull-right">
                <button id="btnSearch" type="button" class="btn btn-primary">Search</button>
            </div>
            @if (Auth::user()->isAdmin())
            <div class="input-group pull-left">
                <button id="btnExcelExport" type="button" class="btn btn-primary">Export Excel</button>
            </div>
            @endif
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
                    <h2>Store Visitors</h2>

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

                        <table id="visitor_table" class="table table-striped table-bordered table-hover" width="100%">
                            <thead>
                                <tr>


                                    <th>Network</th>
                                    <th>Store</th>
                                    <th>Network Link</th>
                                    <th>Total Visitors</th>
                                    <th>Last Coupon Added</th>

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

            var responsiveHelper_visitor_table = undefined;
            var self = {};
            var editCouponModelSelector = "#editCouponModal";
            var editCouponPasswordModelSelector = "#editCouponPasswordModal";
            var createCouponModelSelector = "#createCouponModal";
            var deleteCouponModelSelector = "#deleteCouponModal";

            var visitorTable = null;

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

                $('#NetworkId').on("select2:select", function(e) {
                    visitorTable.ajax.reload();
                });


                $("#btnSearch").off().click(function() {
                    visitorTable.ajax.reload();
                });

                $("#btnExcelExport").off().click(function() {
                    $(".dt-button.buttons-excel.buttons-html5").trigger("click");
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
                visitorTable = $('#visitor_table').DataTable({
                    "deferRender": true,
                    "order": [
                        [0, "desc"]
                    ],
                    "sAjaxSource": "{{ route('admin.storevisitoranalysis.index') }}",
                    "fnServerParams": function(aoData) {

                        var splitedStart = $("#StartDate").val().split('/');
                        var splitedEnd = $("#EndDate").val().split('/');
                        var startDate = splitedStart[2] + "-" + splitedStart[1] + "-" + splitedStart[0];
                        var endDate = splitedEnd[2] + "-" + splitedEnd[1] + "-" + splitedEnd[0];
                        aoData.push({
                            "name": "NetworkId",
                            "value": $("#NetworkId").val().toString()
                        }, {
                            "name": "StartDate",
                            "value": startDate
                        }, {
                            "name": "EndDate",
                            "value": endDate
                        });
                    },
                    "aoColumns": [{
                            "mData": "NetworkName",
                            "sClass": "text-center"
                        },
                        {
                            "mData": "StoreName",
                            "sClass": "text-center"
                        },
                        {
                            "mData": "StoreNetworkLink",
                            "sClass": "text-center"
                        },

                        {
                            "mData": "TotalVisitor",
                            "sClass": "text-center"
                        },
                        {

                            "render": function(data, type, row, val) {
                                {
                                    if (row.LastCouponAdded) {
                                        var splited = row.LastCouponAdded.split(' ')[0].split('-');

                                        return splited[2] + "/" + splited[1] + "/" + splited[0] + ' ' + row.LastCouponAdded.split(' ')[1];
                                    }

                                    return "";
                                }
                            },
                            "sClass": "text-center"
                        },
                    ],
                    "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
                        "Btf" +
                        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
                    "autoWidth": true,
                    "preDrawCallback": function() {
                        // Initialize the responsive datatables helper once.
                        if (!responsiveHelper_visitor_table) {
                            responsiveHelper_visitor_table = new ResponsiveDatatablesHelper($('#visitor_table'), breakpointDefinition);
                        }
                    },
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5'
                    ],
                    "rowCallback": function(nRow) {
                        responsiveHelper_visitor_table.createExpandIcon(nRow);
                    },
                    "drawCallback": function(oSettings) {
                        responsiveHelper_visitor_table.respond();
                    },
                    "fnFooterCallback": function(nFoot, aaData, iStart, iEnd, aiDisplay) {

                    }

                });



                // Apply the filter
                $("#visitor_table thead th input[type=text]").on('keyup change', function() {

                    otable
                        .column($(this).parent().index() + ':visible')
                        .search(this.value)
                        .draw();

                });

                // Setup - add a text input to each footer cell
                $('#visitor_table tfoot th.searchable').each(function() {
                    var title = $(this).text();
                    $(this).html('<input type="text" placeholder="Search ' + title + '" />');
                });



                // Apply the search
                visitorTable.columns().every(function() {
                    var that = this;

                    $('input', this.footer()).on('keyup change clear', function() {
                        if (that.search() !== this.value) {
                            that
                                .search(this.value)
                                .draw();
                        }
                    });
                });

                $(".dt-buttons").addClass("hidden");
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