<style type="text/css">
    #affiliate-data-table tr td,#affiliate-data-table tr th{
        text-align: center;
    }
</style>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">
            Affiliate Groups
        </h1>
        <?php if ($p->affgi): ?>
            <a href="<?= site_url() ?>admin/affiliate_groups/addAffiliateGroup" class="create btn btn-success btn-sm">
                <i class="fa fa-plus"></i>
                Create New Affiliate Group
            </a>
        <?php endif; ?>
        <?php if ($p->affgd): ?>
            <button style="margin-left: 10px" value="Delete" class="delete btn btn-danger btn-sm" id="Delete" type="button" >Delete</button>
        <?php endif; ?>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box" >
                    <div class="box-header">
                        <h3 class="box-title">Affiliate Group Detail</h3>
                    </div><!-- /.box-header -->
                    <form name="checkForm" id="checkForm" action="" method="post">
                        <div class="box-body table-responsive" id="data-panel">

                            <table id="affiliate-data-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <?php if ($p->affgd): ?>
                                            <th style="padding: 10px;">
                                                <input type="checkbox"/>
                                            </th>
                                        <?php endif; ?>
                                        <th class="hidden-xs hidden-sm">Group Id</th>
                                        <th>Group Name</th>
                                        <?php if ($p->affgu): ?>
                                            <th>Edit</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($groups as $value) { ?>
                                        <tr>
                                            <?php if ($p->affgd): ?>
                                                <td>
                                                    <div>
                                                        <label>
                                                            <input type="checkbox" name="group[]" value="<?= $value->group_id ?>"/>
                                                        </label>
                                                    </div>
                                                </td>
                                            <?php endif; ?>
                                            <td class="hidden-xs hidden-sm"><?= $value->group_id ?></td>
                                            <td><?= $value->group_name ?></td>
                                            <?php if ($p->affgu): ?>
                                                <td>
                                                    <a href="<?= site_url() ?>admin/affiliate_groups/editAffiliateGroup/<?= $value->group_id ?>" class="btn bg-navy btn-xs">
                                                        <i class="fa fa-edit"></i>
                                                        Edit
                                                    </a>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <?php if ($p->affgd): ?>
                                            <th></th>
                                        <?php endif; ?>
                                        <th class="hidden-xs hidden-sm">Group Id</th>
                                        <th>Group Name</th>
                                        <?php if ($p->affgu): ?>
                                            <th>Edit</th>
                                        <?php endif; ?>
                                    </tr>
                                </tfoot>
                            </table>
                            <?php if ($p->affgd): ?>
                                <input type="hidden" id="actionType" name="actionType" value="" />
                            <?php endif; ?>
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
        $m = "Affiliate Group Successfully Created..!";
        $t = "success";
        break;
    case "U":
        $m = "Affiliate Group Successfully Updated..!";
        $t = "success";
        break;
    case "D":
        $m = "Affiliate Group(s) Successfully Deleted..!";
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
        $("#affiliate-data-table").dataTable({
            aoColumnDefs: [{
                    bSortable: false,
                    aTargets: [0, 3]
                }]
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {

<?php if ($p->affgd): ?>
            $('button.delete').click(function (e) {
                var agroup = "";
                var act = $(this).val();
                $('#affiliate-data-table tbody tr').each(function () {
                    if ($(this).children('td:first').find('div.checked').length) {
                        $txt = $(this).children('td:nth-child(3)').text();
                        agroup += $txt.trim() + ",";
                    }
                });
                agroup = agroup.substring(0, agroup.length - 1);
                alertify.confirm("Are you sure want to delete affiliate group(s):<br/>" + agroup, function (e) {
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
                $('#checkForm').attr('action', "<?= site_url() ?>admin/affiliate_groups/action");
                $('#checkForm').submit();
            }
<?php endif; ?>
    });

</script>