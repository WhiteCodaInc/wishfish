<style type="text/css">
    #offer-data-table tr td,#offer-data-table tr th{
        text-align: center;
    }
</style>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style=" display: none">
            Offers
        </h1>
        <button value="Active" class="add btn btn-success btn-sm" id="Active" type="button" >Active</button>
        <button value="Deactive" class="remove btn btn-warning btn-sm" id="Deactive" type="button" >Deactivate</button>
        <button value="Delete" class="delete btn btn-danger btn-sm" id="Delete" type="button" >Delete</button>
        <div class="search" style="float:right;width: 24%">
            <select id="page_length" class="form-control" style="float: left;width: 28%;margin-right: 2%">
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="200">200</option>
                <option value="-1" selected="">All</option>
            </select>
            <input class="form-control" type="text" id="searchbox" placeholder="Search" style="float: left;width: 70%">
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box" >
                    <form name="checkForm" id="checkForm" action="" method="post">
                        <div class="box-body table-responsive" id="data-panel">
                            <table id="offer-data-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="padding: 10px;">
                                            <input type="checkbox"/>
                                        </th>
                                        <th>Offer Name</th>
                                        <th>Product</th>
                                        <th>Payment Plan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($offers as $value) { ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <label>
                                                        <input type="checkbox" class="check"  name="offer[]" value="<?= $value->offer_id ?>"/>
                                                    </label>
                                                </div>
                                            </td>

                                            <td><?= $value->offer_name ?></td>
                                            <td><?= $value->product_name ?></td>
                                            <td>
                                                <strong><?= $value->payment_plan ?></strong><br/>
                                                <strong>$ <?= $value->initial_amt ?></strong> immediately,
                                                and <strong>$ <?= $value->amount . ' / ' . $value->interval ?></strong> 
                                                after <strong><?= $value->trial_period ?> days.</strong>
                                            </td>
                                            <td>
                                                <?php if ($value->status): ?>
                                                    <span class="btn btn-success btn-xs">Active</span>
                                                <?php else : ?>
                                                    <span class="btn btn-danger btn-xs">Deactivate</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>Offer Name</th>
                                        <th>Product</th>
                                        <th>Payment Plan</th>
                                        <th>Status</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <input type="hidden" id="actionType" name="actionType" value="" />
                        </div><!-- /.box-body -->
                    </form>
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->
<?php $msg = $this->input->get('msg'); ?>
<?php $data = $this->input->post(); ?>
<?php
switch ($msg) {
    case "A":
        $m = "Offer Successfully Activated..!";
        $t = "success";
        break;
    case "DA":
        $m = "Offer Successfully Deactivated..!";
        $t = "success";
        break;
    case "U":
        $m = "Offer Successfully Updated..!";
        $t = "success";
        break;
    case "D":
        $m = "Offer(s) Successfully Deleted..!";
        $t = "error";
        break;
    default:
        $m = 0;
        break;
}
?>
<script type="text/javascript">
<?php if ($msg): ?>
        alertify.<?= $t ?>("<?= $m ?>");
<?php endif; ?>
    $('.input-daterange').datepicker({
        format: "mm-dd-yyyy",
        todayBtn: "linked",
        autoclose: true,
        todayHighlight: true
    });
</script>

<!-- DATA TABES SCRIPT -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<!-- page script -->
<script type="text/javascript">
    $(function () {
        oTable = $("#offer-data-table").dataTable({
            aoColumnDefs: [{
                    bSortable: false,
                    aTargets: [0, 1, 2, 3, 4]
                }]
        });
        $("#searchbox").on("keyup search input paste cut", function () {
            oTable.fnFilter(this.value);
        });
        $('#page_length').change(function () {
            var length = parseInt($(this).val());
            console.log(length);
            var oSettings = oTable.fnSettings();
            oSettings._iDisplayLength = length;
            oTable.fnPageChange("first");
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {

        $('button.add').click(function (e) {
            action($(this).val());
            e.preventDefault();
        });
        $('button.remove').click(function (e) {
            action($(this).val());
            e.preventDefault();
        });
        $('button.delete').click(function (e) {
            var offer = "";
            var act = $(this).val();
            $('#offer-data-table tbody tr').each(function () {
                if ($(this).children('td:first').find('div.checked').length) {
                    $txt = $(this).children('td:nth-child(4)').text();
                    offer += $txt.trim() + "<br/>";
                }
            });
            offer = offer.substring(0, offer.length - 1);
            alertify.confirm("Are you sure want to delete offer(s):<br/>" + offer, function (e) {
                if (e) {
                    action(act);
                    return true;
                }
                else {
                    return false;
                }
            });
        });
        function action(actiontype) {
            $('#actionType').val(actiontype);
            $('#checkForm').attr('action', "<?= site_url() ?>admin/offers/action");
            $('#checkForm').submit();
        }
    });

</script>