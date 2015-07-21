<style type="text/css">
    #payment-data-table tr td,
    #payment-data-table tr th,
    #pdetail-data-table tr td,
    #pdetail-data-table tr th{
        text-align: center;
    }
    .dataTables_wrapper > div.row:first-child{
        display: none
    }
</style>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">
            Payment Detail
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row payments">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="box" >
                    <div class="box-header" style="margin: 20px 10px;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-large input-daterange" >
                                    <input type="text" na class="form-control" placeholder="Select Start Date" id="from">
                                    <span class="input-group-addon">To</span>
                                    <input type="text" class="form-control" placeholder="Select End Date" id="to">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button id="search" type="button" class="btn btn-success">Search</button>
                            </div>
                        </div>
                    </div><!-- /.box-header -->

                    <div class="box-body table-responsive" id="data-panel">
                        <table id="payment-data-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Payment Date </th>
                                    <th>Total Payment</th>
                                    <th>Total Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Payment Date </th>
                                    <th>Total Payment</th>
                                    <th>Total Amount</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div><!-- /.box-body -->
                    <div style="display: none" class="overlay"></div>
                    <div style="display: none" class="loading-img"></div>
                </div><!-- /.box -->
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="row pdetail" style="display: none">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="box" >
                    <div class="box-header">
                        <h3 class="box-title">Payment Detail</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive" id="data-panel">
                        <table id="pdetail-data-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Payment Date </th>
                                    <th>Total Payment</th>
                                    <th>Total Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Payment Date </th>
                                    <th>Total Payment</th>
                                    <th>Total Amount</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div><!-- /.box-body -->
                    <div style="display: none" class="overlay"></div>
                    <div style="display: none" class="loading-img"></div>
                </div><!-- /.box -->
            </div>
            <div class="col-md-2"></div>
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<!-- DATA TABES SCRIPT -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<!-- page script -->
<script type="text/javascript">
    $(function () {
        $('.input-daterange').datepicker({
            format: "mm-dd-yyyy",
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        var oTable;

        $("#pdetail-data-table").dataTable({
            order: [],
            bDestroy: true,
            aLengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            aoColumnDefs: [{
                    targets: 'no-sort',
                    bSortable: false,
                    aTargets: [0, 1, 2]
                }],
            iDisplayLength: 10,
//            aaSorting: [[0, 'desc']]
        });

        function datatable() {
            oTable = $("#payment-data-table").dataTable({
                order: [],
                bDestroy: true,
                aLengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                aoColumnDefs: [{
                        targets: 'no-sort',
                        bSortable: false,
                        aTargets: [1, 2]
                    }],
                iDisplayLength: 10,
                aaSorting: [[0, 'desc']]
            });
        }
        datatable();
        $('#search').click(function () {
            $('.overlay').show();
            $('.loading-img').show();
            var from = $('#from').val();
            var to = $('#to').val();
            $.ajax({
                type: 'POST',
                data: {from: from, to: to},
                url: "<?= site_url() ?>admin/analytics/getPayments",
                success: function (data, textStatus, jqXHR) {
                    $('.overlay').hide();
                    $('.loading-img').hide();
                    oTable.fnClearTable();
                    $('#payment-data-table tbody').html(data);
                    datatable();
                }
            });
        });



        $('a.totalP').on('click', function () {
            $('.overlay').show();
            $('.loading-img').show();
            var dt = $(this).parents('tr').prop('id');
            console.log(dt);
            $.ajax({
                type: 'POST',
                data: {pdate: dt},
                url: "<?= site_url() ?>admin/analytics/getPaymentDetail",
                success: function (data, textStatus, jqXHR) {
                    $('.payments').hide();
                    $('.overlay').hide();
                    $('.loading-img').hide();
                    $('.pdetail').show();
                    $('#pdetail-data-table tbody').html(data);
                }
            });
        });

    });
</script>