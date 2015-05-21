<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header" style="display: none">
        <h1 style="display: none">
            SMS Inbox
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12" >
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">SMS Inbox</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive" id="data-panel">
                        <table id="inbox-data-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Profile</th>
                                    <th>Contact Name</th>
                                    <th class="hidden-xs hidden-sm">Message</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                ?>
                                <?php foreach ($inbox as $key => $sms) { ?>
                                    <?php
                                    $img_src = "";
                                    $img_src = ($sms->contact_avatar != "") ?
                                            "http://mikhailkuznetsov.s3.amazonaws.com/" . $sms->contact_avatar :
                                            base_url() . 'assets/dashboard/img/default-avatar.png';
                                    ?>
                                    <tr >
                                        <td >
                                            <a href="<?= site_url() . 'admin/contacts/profile/' . $sms->contact_id ?>" class="name">
                                                <img style="width:60px;height:60px" src="<?= $img_src ?>" class="img-circle" alt="User Image" />
                                            </a>
                                        </td>
                                        <td >
                                            <a href="<?= site_url() . 'admin/contacts/profile/' . $sms->contact_id ?>" class="name">
                                                <?= $sms->fname . ' ' . $sms->lname ?>
                                            </a>
                                        </td>
                                        <td class="hidden-xs hidden-sm" style="width:40%" ><?= $sms->body ?></td>
                                        <td >
                                            <?php if ($sms->status == 0) { ?>
                                                <span class="btn btn-success btn-xs">Replied</span>
                                            <?php } else if ($sms->status == 1) { ?>
                                                <span class="btn btn-danger btn-xs">Unread</span>
                                            <?php } else if ($sms->status == 2) { ?>
                                                <span class="btn btn-warning btn-xs">Read</span>
                                            <?php } ?>
                                        </td>
                                        <td >
                                            <a href="<?= site_url() ?>admin/sms/loadConversation?from=<?= $sms->from ?>" class="btn btn-primary btn-sm">
                                                Messages
                                            </a> 
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Profile</th>
                                    <th>Contact Name</th>
                                    <th class="hidden-xs hidden-sm">Message</th>
                                    <th>Status</th>
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
    case "send":
        $m = "SMS Successfully Delivered..!";
        $t = "success";
        break;
    case "fail":
        $m = "SMS Sending Failed..!";
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

<!--<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>-->
<!-- DATA TABES SCRIPTS -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<!-- page script -->
<script type="text/javascript">


    $(function () {
        $("#inbox-data-table").dataTable({
            aLengthMenu: [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, "All"]
            ],
            iDisplayLength: -1,
            aaSorting: [[1, 'asc']]
        });
    });
</script>