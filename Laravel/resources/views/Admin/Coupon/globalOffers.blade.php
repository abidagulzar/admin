@extends('Admin.Layout.master')
@section('pagebreadcrumb')
<ol class="breadcrumb">
    <li>Coupons</li>
    <li>Global Coupon/Deals</li>
</ol>
@endsection
@section('content')

<section id="widget-grid" class="">

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
                    <h2>Coupon List</h2>

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

                        <table id="coupon_table" class="table table-striped table-bordered table-hover" width="100%">
                            <thead>
                                <tr>

                                    <th>Store Name</th>
                                    <th>Header</th>
                                    <th>Code</th>
                                    <th>Expiry Date</th>
                                    <th>Is Banner</th>
                                    <th>Is Home Coupon</th>
                                    <th>Is Header Coupon</th>
                                    <th>Is Home Banner</th>
                                    <th>Is Top Deal</th>
                                    <th>Deal Logo</th>
                                    <th>Type</th>
                                    <th>Created By</th>
                                    <th>Create Date/Time</th>
                                    <th>Update By</th>
                                    <th>Update Date/Time</th>
                                    <th>Action</th>
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
                                    <th class="searchable"></th>
                                    <th class="searchable"></th>
                                    <th class="searchable"></th>
                                    <th class="searchable"></th>
                                    <th class=""></th>
                                    <th class="searchable"></th>
                                    <th class="searchable"></th>
                                    <th class="searchable"></th>
                                    <th class="searchable"></th>
                                    <th class="searchable"></th>
                                    <th></th>
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

</section>

@endsection
@section('pagescripts')
<script type="text/javascript">
    var CouponModule = (function() {

            var responsiveHelper_coupon_table = undefined;
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

                $('#StoreId').on("select2:select", function(e) {
                    couponTable.ajax.reload();
                });

                $("#btnDeleteCoupon").off().click(function() {

                    var checked = $(".selectrowcheckbox:checked");
                    if (checked.length == 0) {
                        showErrorMessgae("Select some coupons to delete.");
                    } else {

                        $("#deleteCouponText").html("Do you want to delete selected coupons ?");

                        var ids = checked.map(function() {
                            return $(this).data('id');
                        }).get().toString();

                        $("#CouponId.delete").val(ids);

                        $(deleteCouponModelSelector).modal('show');
                    }
                });

            }

            self.SelectAllList = function(obj) {
                if ($(obj).is(":checked")) {
                    $(".selectrowcheckbox").attr("checked", "checked").prop("checked", "checked");
                } else {

                    $(".selectrowcheckbox").removeAttr("checked")
                }

            }

            self.BindCouponTable = function() {
                couponTable = $('#coupon_table').DataTable({
                    "deferRender": true,
                    "sAjaxSource": "{{ route('admin.coupon.globaloffers') }}",

                    "aoColumns": [{
                            "mData": "StoreName",
                            "sClass": "text-center"
                        },
                        {
                            "mData": "Header",
                            "sClass": "text-center"
                        },
                        {
                            "mData": "Code",
                            "sClass": "text-center"
                        },

                        {

                            "render": function(data, type, row, val) {
                                if (row.IsUnknownOutGoing == 1)
                                    return "Unknown/OutGoing";
                                else {
                                    if (row.ExpiryDate) {
                                        var splited = row.ExpiryDate.split(' ')[0].split('-');

                                        return splited[2] + "/" + splited[1] + "/" + splited[0]
                                    }

                                    return "";
                                }
                            },
                            "sClass": "text-center"
                        },

                        {

                            "render": function(data, type, row, val) {
                                if (row.IsBanner == 1) {
                                    return "Yes";
                                }

                                return "No";
                            },
                            "sClass": "text-center"
                        },
                        {

                            "render": function(data, type, row, val) {
                                if (row.HomeCoupon == 1) {
                                    return "Yes";
                                }

                                return "No";
                            },
                            "sClass": "text-center"
                        },
                        {

                            "render": function(data, type, row, val) {
                                if (row.IsHeaderDeal == 1) {
                                    return "Yes";
                                }

                                return "No";
                            },
                            "sClass": "text-center"
                        },
                        {

                            "render": function(data, type, row, val) {
                                if (row.IsHomeBanner == 1) {
                                    return "Yes";
                                }

                                return "No";
                            },
                            "sClass": "text-center"
                        },
                        {

                            "render": function(data, type, row, val) {
                                if (row.IsTopDeal == 1) {
                                    return "Yes";
                                }

                                return "No";
                            },
                            "sClass": "text-center"
                        },
                        {
                            "render": function(data, type, row, val) {
                                var imagePath = "{{ url('/path_to_image') }}" + "content/img/avatars/male.png";

                                if (row.LogoUrl) {
                                    imagePath = "{{ url('/storage/couponlogo') }}/" + row.LogoUrl;
                                    return '<img style="width: 100px;" src="' + imagePath + '">';
                                }

                                return '';
                            },
                            "sClass": "text-center"
                        },
                        {

                            "render": function(data, type, row, val) {
                                if (row.Code) {
                                    return "Coupon";
                                }

                                return "Deal/Offer";
                            },
                            "sClass": "text-center"
                        },
                        {
                            "mData": "CreatedByUser",
                            "sClass": "text-center"
                        },
                        {

                            "render": function(data, type, row, val) {

                                if (row.CreateDate) {

                                    try {
                                        return (new Date(row.CreateDate)).toLocaleString();
                                    } catch {
                                        return "";

                                    }
                                }

                                return "";
                            },
                            "sClass": "text-center"
                        },
                        {
                            "mData": "UpdatedByUser",
                            "sClass": "text-center"
                        },
                        {

                            "render": function(data, type, row, val) {

                                if (row.UpdateDate) {

                                    try {
                                        return (new Date(row.UpdateDate)).toLocaleString();
                                    } catch {
                                        return "";

                                    }
                                }

                                return "";

                            },
                            "sClass": "text-center"
                        },
                        {

                            "sWidth": "5%",
                            "render": function(data, type, row, val) {

                                var actions = '<div class="" style="cursor:pointer">';
                                var editAction = "{{ route('admin.coupon.edit', 'id') }}";
                                editAction = editAction.replace('id', row.CouponId);
                                var dataTitle = row.Header;
                                actions += '<a class="green"  href="' + editAction + '"  ><i class="fa fa-pencil datatable-Icon"></i></a>  <a class="red" onClick="CouponModule.deleteCouponModal(' + "\'" + row.CouponId + "\'" + "," + "\'" + dataTitle + "\'" + ')"  ><i class="fa fa-trash-o datatable-Icon"></i></a></div>'

                                return actions;
                            },
                            "sClass": "text-center"
                        }
                    ],
                    "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
                        "t" +
                        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
                    "autoWidth": true,
                    "preDrawCallback": function() {
                        // Initialize the responsive datatables helper once.
                        if (!responsiveHelper_coupon_table) {
                            responsiveHelper_coupon_table = new ResponsiveDatatablesHelper($('#coupon_table'), breakpointDefinition);
                        }
                    },
                    "rowCallback": function(nRow) {
                        responsiveHelper_coupon_table.createExpandIcon(nRow);
                    },
                    "drawCallback": function(oSettings) {
                        responsiveHelper_coupon_table.respond();
                    }

                });

                // custom toolbar
                $("div.toolbar").html('<div class="text-right"><img src="/Content/img/logo.png" alt="SmartAdmin" style="height: 40px;margin-right: 10px;"></div>');

                // Apply the filter
                $("#coupon_table thead th input[type=text]").on('keyup change', function() {

                    otable
                        .column($(this).parent().index() + ':visible')
                        .search(this.value)
                        .draw();

                });

                // Setup - add a text input to each footer cell
                $('#coupon_table tfoot th.searchable').each(function() {
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
        CouponModule.BindCouponTable();
        CouponModule.BindEvents();
    });
</script>

@endsection