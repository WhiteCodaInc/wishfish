<style type="text/css">
    #payment-data-table tr td,#payment-data-table tr th{
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
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="box" >
                    <div class="box-header" style="margin: 20px 10px;">
                        <form action="<?= site_url() ?>/admin/analytics/getPayments" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group input-large input-daterange" >
                                        <input type="text" na class="form-control" placeholder="Select Start Date" name="from">
                                        <span class="input-group-addon">To</span>
                                        <input type="text" class="form-control" placeholder="Select End Date" name="to">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-success">Search</button>
                                </div>
                            </div>
                        </form>`
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
                                <?php foreach ($phistory as $value) { ?>
                                    <tr>
                                        <td><?= date('m-d-Y', strtotime($value->pdate)) ?></td>
                                        <td><?= $value->totalP ?></td>
                                        <td><?= number_format($value->totalA, 2) ?></td>
                                    </tr>
                                <?php } ?>
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
        $("#payment-data-table").dataTable({
            order: [],
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
        });
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

    });
</script>