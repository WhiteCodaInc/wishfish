<style type="text/css">
    #plan-data-table tr td,#plan-data-table tr th{
        text-align: center;
    }
</style>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">
            Payment Plans
        </h1>
        <a href="<?= site_url() ?>admin/plans/addPlan" class="create btn btn-success btn-sm">
            <i class="fa fa-plus"></i>
            Create New Payment Plan
        </a>
        <button  value="Delete" class="delete btn btn-danger btn-sm" id="Delete" type="button" >Delete</button>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box" >
                    <div class="box-header">
                        <h3 class="box-title">Payment Plan Detail</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <form name="checkForm" id="checkForm" action="" method="post">
                            <div class="box-body table-responsive" id="data-panel">
                                <table id="plan-data-table" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="padding: 10px;">
                                                <input type="checkbox"/>
                                            </th>
                                            <th>Payment Plan</th>
                                            <th>Description</th>
                                            <th>Product</th>
                                            <th>Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($plans as $value) { ?>
                                            <tr id="<?= $value->payment_plan_id ?>">
                                                <td>
                                                    <div>
                                                        <label>
                                                            <input type="checkbox" name="plan[]" value="<?= $value->payment_plan_id ?>"/>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td><?= $value->payment_plan ?></td>
                                                <td>
                                                    <strong>$ <?= $value->initial_amt ?></strong> immediately,
                                                    and <strong>$ <?= $value->amount . ' / ' . $value->interval ?></strong> 
                                                    after <strong><?= $value->trial_period ?> days.</strong>
                                                </td>
                                                <td>
                                                    <select class="form-control m-bot15 product">
                                                        <option value="-1">-------Assign To-------</option>
                                                        <?php foreach ($products as $val) { ?>
                                                            <option value="<?= $val->plan_id ?>" <?= ($value->assign_to == $val->plan_id) ? 'selected' : '' ?>>
                                                                <?= $val->plan_name ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <a href="<?= site_url() ?>admin/plans/editPlan/<?= $value->payment_plan_id ?>" class="btn bg-navy btn-xs">
                                                        <i class="fa fa-edit"></i>
                                                        Edit
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th>Payment Plan</th>
                                            <th>Description</th>
                                            <th>Product</th>
                                            <th>Edit</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <input type="hidden" id="actionType" name="actionType" value="" />
                            </div><!-- /.box-body -->
                        </form>
                    </div>
                    <div style="display: none" class="overlay"></div>
                    <div style="display: none" class="loading-img"></div>
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->
<?php $msg = $this->input->get('msg'); ?>
<?php
switch ($msg) {
    case "I":
        $m = "Payment Plan Successfully Created..!";
        $t = "success";
        break;
    case "U":
        $m = "Payment Plan Successfully Updated..!";
        $t = "success";
        break;
    case "D":
        $m = "Payment Plan(s) Successfully Deleted..!";
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
</script>

<!-- DATA TABES SCRIPT -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<!-- page script -->
<script type="text/javascript">
    $(function () {
        $("#plan-data-table").dataTable({
            aoColumnDefs: [{
                    bSortable: false,
                    aTargets: [0, 1, 2, 3, 4]
                }]
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {

        $('select.product').change(function () {
            var productid = $(this).val();
            var planid = $(this).parents('tr').prop('id');
            $alertPro = false;
            $select = $(this);
            $('#plan-data-table tr:not(#' + planid + ') select.product]').each(function () {
                if (productid == $(this).val()) {
                    $alertPro = true;
                    $select.val("-1");
                }
            });
            if ($alertPro) {
                alertify.error("Product is already assigned..!");
            }

            $('.overlay').show();
            $('.loading-img').show();

            $.ajax({
                type: 'POST',
                data: {productid: productid, planid: planid},
                url: "<?= site_url() ?>admin/plans/assignPlan",
                success: function (data, textStatus, jqXHR) {
                    $('.overlay').hide();
                    $('.loading-img').hide();
                    alertify.success("Payment Plan Successfully Assigned..!");
                }
            });
        });

        $('button.delete').click(function (e) {
            var plans = "";
            var act = $(this).val();
            $('#plan-data-table tbody tr').each(function () {
                if ($(this).children('td:first').find('div.checked').length) {
                    $txt = $(this).children('td:nth-child(2)').text();
                    plans += $txt.trim() + ",";
                }
            });
            plans = plans.substring(0, plans.length - 1);
            alertify.confirm("Are you sure want to delete payment plan(s):<br/>" + plans, function (e) {
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
            $('#productid').val($('#product').val());
            $('#checkForm').attr('action', "<?= site_url() ?>admin/plans/action");
            $('#checkForm').submit();
        }
    });

</script>