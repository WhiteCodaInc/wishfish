<style type="text/css">
    #list-data-table tr td,#list-data-table tr th{
        text-align: center;
    }
    #lcontact-data-table tr td,#lcontact-data-table tr th{
        text-align: center;
    }
</style>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style=" display: none">
            Email Lists
        </h1>
        <?php if ($p->funi): ?>
            <a href="<?= site_url() ?>admin/email_list/addEmailList" class="create btn btn-success btn-sm">
                <i class="fa fa-plus"></i>
                Create New Email List
            </a>
        <?php endif; ?>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Email List Detail</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive" id="data-panel">

                        <table id="list-data-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Email List Name</th>
                                    <th>No. of Contacts</th>
                                    <?php if ($p->funu || $p->funv): ?>
                                        <th>Action</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($lists as $value) { ?>
                                    <tr>
                                        <td><?= $value->name ?></td>
                                        <td><?= $value->total ?></td>
                                        <?php if ($p->funu || $p->funv): ?>
                                            <td>
                                                <?php if ($p->funu): ?>
                                                    <a href="<?= site_url() ?>admin/email_list/editEmailList/<?= $value->list_id ?>" class="btn bg-navy btn-xs">
                                                        <i class="fa fa-pencil"></i>
                                                        Edit
                                                    </a>
                                                <?php endif; ?>
                                                <?php if ($p->funv): ?>
                                                    <?php if ($value->total > 0): ?>
                                                        <a href="<?= site_url() ?>admin/email_list/view/<?= $value->list_id ?>" class="btn bg-navy btn-xs">
                                                            <i class="fa fa-eye"></i>
                                                            View
                                                        </a>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Email List Name</th>
                                    <th>No. of Contacts</th>
                                    <?php if ($p->funu || $p->funv): ?>
                                        <th>Action</th>
                                    <?php endif; ?>
                                </tr>
                            </tfoot>
                        </table>
                    </div><!-- /.box-body -->
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
        $m = "Email List Successfully Created..!";
        $t = "success";
        break;
    case "U":
        $m = "Email List Successfully Updated..!";
        $t = "success";
        break;
    case "D":
        $m = "Email List(s) Successfully Deleted..!";
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
        $("#list-data-table").dataTable({
            bSort: false,
//            aoColumnDefs: [{
//                    bSortable: false,
//                    aTargets: [0, 1, 2]
//                }]
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {

    });
</script>