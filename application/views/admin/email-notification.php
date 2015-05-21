<!-- Right side column. Contains the navbar and content of the page -->
<style type="text/css">
    #email-data-table tr td,#email-data-table tr th{
        text-align: center;
    }
</style>
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Email Notification
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-xs-12">
                <div class="box" >
                    <div class="box-header">
                        <h3 class="box-title">Email Notification</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive" id="data-panel">
                        <table id="email-data-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Mail Type</th>
                                    <th>Trigger By</th>
                                    <th class="hidden-xs hidden-sm">Mail Subject</th>
                                    <th class="hidden-xs hidden-sm">Color</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($automail as $value) { ?>
                                    <tr>
                                        <td><?= $value->mail_type ?></td>
                                        <td><?= $value->trigger_by ?></td>
                                        <td class="hidden-xs hidden-sm"><?= $value->mail_subject ?></td>
                                        <td class="hidden-xs hidden-sm">
                                            <span class="btn" style ="background:<?= $value->color ?>;"></span>
                                        </td>
                                        <td>
                                            <a href="<?= site_url() ?>admin/email_notification/edit/<?= $value->mail_id ?>" class="btn bg-navy btn-xs">
                                                <i class="fa fa-edit"></i>
                                                Edit
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Mail Type</th>
                                    <th>Trigger By</th>
                                    <th class="hidden-xs hidden-sm">Mail Subject</th>
                                    <th class="hidden-xs hidden-sm">Color</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<?php $msg = $this->input->get('msg'); ?>
<?php
switch ($msg) {
    case "U":
        $m = "Email Template Successfully Updated..!";
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
        $("#email-data-table").dataTable();
    });
</script>