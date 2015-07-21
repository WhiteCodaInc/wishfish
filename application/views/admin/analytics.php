<style type="text/css">
    #payment-data-table tr td,#payment-data-table tr th{
        text-align: center;
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
            <div class="col-xs-4"></div>
            <div class="col-xs-4">
                <div class="box" >
                    <div class="box-header">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-large input-daterange" >
                                    <input type="text" na class="form-control" placeholder="Select Start Date" name="from">
                                    <span class="input-group-addon">To</span>
                                    <input type="text" class="form-control" placeholder="Select End Date" name="to">
                                </div>
                            </div>
                            <!--<div class="col-md-5"></div>-->
                            <div class="col-md-2"></div>
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
                                <?php foreach ($phistory as $value) { ?>
                                    <tr>
                                        <td><?= date('m-d-Y', strtotime($value->payment_date)) ?></td>
                                        <td><?= $value->totalP ?></td>
                                        <td><?= $value->totalA ?></td>
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
                </div><!-- /.box -->
            </div>
            <div class="col-xs-4"></div>
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
            aLengthMenu: [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, "All"]
            ],
            aoColumnDefs: [{
                    targets: 'no-sort',
                    bSortable: false,
                    aTargets: [0, 1, 2]
                }],
            iDisplayLength: -1,
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {


    });
</script>