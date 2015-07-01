<style type="text/css">
    #comment-data-table tr td,#comment-data-table tr th{
        text-align: center;
    }
</style>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style=" display: none">
            Feedback / Support
        </h1>
        <button  value="Delete" class="btn btn-danger btn-sm delete" id="Delete" type="button" >Delete</button>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box" >
                    <div class="box-header">
                        <h3 class="box-title">Feedback / Support</h3>
                    </div><!-- /.box-header -->
                    <form name="checkForm" id="checkForm" action="" method="post">
                        <div class="box-body table-responsive" id="data-panel">
                            <table id="comment-data-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="padding: 10px;">
                                            <input type="checkbox"/>
                                        </th>
                                        <th>Name</th>                             
                                        <th class="hidden-xs hidden-sm">Email</th>
                                        <th>Country</th>
                                        <th >Query</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($feedback as $value) { ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <label>
                                                        <input type="checkbox" name="feedback[]" value="<?= $value->feedback_id ?>"/>
                                                    </label>
                                                </div>
                                            </td>
                                            <td><?= $value->name ?></td>
                                            <td class="hidden-xs hidden-sm"><?= $value->email ?></td>
                                            <td><?= $value->country ?></td>
                                            <td><?= $value->query ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>                             
                                        <th class="hidden-xs hidden-sm">Email</th>
                                        <th>Country</th>
                                        <th >Query</th>
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
    case "D":
        $m = "Feedback(s) Successfully Deleted..!";
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
        format: "dd-mm-yyyy",
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
        $("#comment-data-table").dataTable({
            aLengthMenu: [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, "All"]
            ],
            aoColumnDefs: [{
                    bSortable: false,
                    aTargets: [0, 2, 3]
                }],
            iDisplayLength: -1,
            aaSorting: [[1, 'asc']]
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('button.delete').click(function (e) {
            var act = $(this).val();
            action(act);
        });

        function action(actiontype) {
            $('#actionType').val(actiontype);
            $('#checkForm').attr('action', "<?= site_url() ?>admin/feedback/action");
            $('#checkForm').submit();
        }
    });
</script>