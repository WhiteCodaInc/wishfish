<style type="text/css">
    #video-data-table tr td,#video-data-table tr th{
        text-align: center;
    }
</style>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Videos
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-xs-12">
                <div class="box" >
                    <div class="box-header">
                        <h3 class="box-title">Videos List</h3>
                    </div><!-- /.box-header -->
                    <div class="row">
                        <div class="col-xs-12" style="margin-left: 1%">
                            <a href="<?= site_url() ?>admin/cms/upload_video" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i>
                                Upload New Video
                            </a>
                            <button style="margin-left: 10px" value="Delete" class="btn btn-danger btn-sm" id="Delete" type="button" >Delete</button>
                        </div>
                    </div>

                    <form name="checkForm" id="checkForm" action="" method="post">
                        <div class="box-body table-responsive" id="data-panel">

                            <table id="video-data-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="font-size: 17px;padding-right: 18px;text-align: center;">
                                            <i class="fa fa-level-down"></i>
                                        </th>
                                        <th>Video Name</th>
                                        <th>Video URL</th>
                                        <th>Unique Key</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($video as $value) { ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <label>
                                                        <input type="checkbox" name="video[]" value="<?= $value->video_id ?>"/>
                                                    </label>
                                                </div>
                                            </td>
                                            <td><?= $value->name ?></td>
                                            <td><?= $value->url ?></td>
                                            <td><?= $value->unique_key ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>Video Name</th>
                                        <th>Video URL</th>
                                        <th>Unique Key</th>
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
        $m = "Video Successfully Uploaded..!";
        $t = "success";
        break;
    case "UF":
        $m = "Video not uploaded..!";
        $t = "error";
        break;
    case "IF":
        $m = "Invalid Video Format..!";
        $t = "error";
        break;
    case "D":
        $m = "Video(s) Successfully Deleted..!";
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
        $("#video-data-table").dataTable();
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {

        $('#Delete').click(function (e) {
            if (confirm("Are you show want to delete ?") == true) {
                action($(this).val());
            } else {
                return false;
            }
            e.preventDefault();
        });

        function action(actiontype) {
            $('#actionType').val(actiontype);
            $('#checkForm').attr('action', "<?= site_url() ?>admin/cms/deleteVideo");
            $('#checkForm').submit();
        }
    });

</script>