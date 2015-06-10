<style type="text/css">
    #coupon-data-table tr td,#coupon-data-table tr th{
        text-align: center;
    }
</style>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">
            Coupons
        </h1>
        <a href="<?= site_url() ?>admin/coupons/addCoupon" class="create btn btn-success btn-sm">
            <i class="fa fa-plus"></i>&nbsp;
            Create New Coupon
        </a>
        <button value="Active" class="add btn btn-info btn-sm" id="Active" type="button" >Active</button>
        <button value="Deactive" class="remove btn btn-warning btn-sm" id="Deactive" type="button" >Deactive</button>
        <button value="Delete" class="delete btn btn-danger btn-sm" id="Delete" type="button" >Delete</button>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box" >
                    <div class="box-header">
                        <h3 class="box-title">Coupon Detail</h3>
                    </div><!-- /.box-header -->
                    <div class="row">
                        <div class="col-xs-12" style="margin-left: 1%">
<!--                            <a href="<?= site_url() ?>admin/coupons/addCoupon" class="create btn btn-success btn-sm">
                                <i class="fa fa-plus"></i>
                                Create New Coupon
                            </a>
                            <button style="margin-left: 10px" value="Delete" class="delete btn btn-danger btn-sm" id="Delete" type="button" >Delete</button>-->
                        </div>
                    </div>

                    <form name="checkForm" id="checkForm" action="" method="post">
                        <div class="box-body table-responsive" id="data-panel">
                            <table id="coupon-data-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="padding: 10px;">
                                            <input type="checkbox"/>
                                        </th>
                                        <th class="hidden-xs hidden-sm">Coupon Name</th>
                                        <th>Coupon Code</th>
                                        <th>Discount</th>
                                        <th>Duration</th>
                                        <th>Expires On</th>
                                        <th>Max Redemption</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($coupons as $value) { ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <label>
                                                        <input type="checkbox" name="coupon[]" value="<?= $value->coupon_id ?>"/>
                                                        <input type="hidden" name="code[]" value="<?= $value->coupon_code ?>"/>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="hidden-xs hidden-sm"><?= $value->coupon_name ?></td>
                                            <td><?= $value->coupon_code ?></td>
                                            <?php
                                            $disc = ($value->disc_type == "F") ?
                                                    "$ {$value->disc_amount}" : "{$value->disc_amount} %";
                                            ?>
                                            <td><?= $disc ?></td>
                                            <?php
                                            $validity = ($value->coupon_validity == "1") ?
                                                    "One Time" : (($value->coupon_validity == "2") ?
                                                            "Disc For {$value->month_duration} Month" : "Life Time");
                                            ?>
                                            <td><?= $validity ?></td>
                                            <td><?= ($value->expiry_date) ? date('d-m-Y', strtotime($value->expiry_date)) : 'Never Expired' ?></td>
                                            <td><?= $value->no_of_use ?></td>
                                            <td>
                                                <?php if ($value->status): ?>
                                                    <span class="btn btn-success btn-xs">Active</span>
                                                <?php else: ?>
                                                    <span class="btn btn-danger btn-xs">Deactive</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th class="hidden-xs hidden-sm">Coupon Name</th>
                                        <th>Coupon Code</th>
                                        <th>Discount</th>
                                        <th>Duration</th>
                                        <th>Expires On</th>
                                        <th>Max Redemption</th>
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
<?php
switch ($msg) {
    case "I":
        $m = "Coupon Successfully Created..!";
        $t = "success";
        break;
    case "IF":
        $m = "Coupon has not been created..!";
        $t = "error";
        break;
    case "U":
        $m = "Coupon Successfully Updated..!";
        $t = "success";
        break;
    case "D":
        $m = "Coupon(s) Successfully Deleted..!";
        $t = "error";
        break;
    case "DA":
        $m = "Coupon(s) Successfully Deactivated..!";
        $t = "error";
        break;
    case "A":
        $m = "Coupon(s) Successfully Activated..!";
        $t = "success";
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
        $("#coupon-data-table").dataTable({
            aLengthMenu: [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, "All"]
            ],
            aoColumnDefs: [{
                    bSortable: false,
                    aTargets: [0, 1, 2, 3, 4, 7]
                }],
            iDisplayLength: -1,
            aaSorting: [[5, 'desc']]
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
            var agroup = "";
            var act = $(this).val();
            $('#coupon-data-table tbody tr').each(function () {
                if ($(this).children('td:first').find('div.checked').length) {
                    $txt = $(this).children('td:nth-child(3)').text();
                    agroup += $txt.trim() + ",";
                }
            });
            agroup = agroup.substring(0, agroup.length - 1);
            alertify.confirm("Are you sure want to delete coupon(s):<br/>" + agroup, function (e) {
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
            $('#checkForm').attr('action', "<?= site_url() ?>admin/coupons/action");
            $('#checkForm').submit();
        }
    });

</script>