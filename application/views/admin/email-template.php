<style type="text/css">
    #template-data-table tr td,#template-data-table tr th{
        text-align: center;
    }
</style>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style=" display: none">
            Email Template
        </h1>
        <a href="<?= site_url() ?>admin/email_template/addTemplate" class="create btn btn-success btn-sm">
            <i class="fa fa-plus"></i>
            Create New Email Template
        </a>
        <button value="Delete" class="delete btn btn-danger btn-sm" id="Delete" type="button" >Delete</button>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Email Template</h3>
                    </div><!-- /.box-header -->
                    <div class="row">
                        <div class="col-xs-12" style="margin-left: 1%">
<!--                            <a href="<?= site_url() ?>admin/email_template/addTemplate" class="create btn btn-success btn-sm">
                                <i class="fa fa-plus"></i>
                                Create New Email Template
                            </a>
                            <button style="margin-left: 10px" value="Delete" class="delete btn btn-danger btn-sm" id="Delete" type="button" >Delete</button>-->
                        </div>
                    </div>

                    <form name="checkForm" id="checkForm" action="" method="post">
                        <div class="box-body table-responsive" id="data-panel">

                            <table id="template-data-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="padding: 10px;">
                                            <input type="checkbox"/>
                                        </th>
                                        <th>Email Template</th>
                                        <th class="hidden-xs hidden-sm">Email Subject</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($template as $value) { ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <label>
                                                        <input type="checkbox" name="template[]" value="<?= $value->template_id ?>"/>
                                                    </label>
                                                </div>
                                            </td>
                                            <td><?= $value->name ?></td>
                                            <td class="hidden-xs hidden-sm"><?= $value->subject ?></td>
                                            <td>
                                                <a href="<?= site_url() ?>admin/email_template/editTemplate/<?= $value->template_id ?>" class="btn bg-navy btn-xs">
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
                                        <th>Email Template</th>
                                        <th class="hidden-xs hidden-sm">Email Subject</th>
                                        <th>Edit</th>
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
        $m = "Email Template Successfully Created..!";
        $t = "success";
        break;
    case "U":
        $m = "Email Template Successfully Updated..!";
        $t = "success";
        break;
    case "D":
        $m = "Email Template(s) Successfully Deleted..!";
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
        $("#template-data-table").dataTable({
            aoColumnDefs: [{
                    bSortable: false,
                    aTargets: [0, 2, 3]
                }]
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {



        $('button.delete').click(function (e) {
            if (confirm("Are you show want to delete ?") == true) {
                action($(this).val());
            } else {
                return false;
            }
            e.preventDefault();
        });

        function action(actiontype) {
            $('#actionType').val(actiontype);
            $('#checkForm').attr('action', "<?= site_url() ?>admin/email_template/action");
            $('#checkForm').submit();
        }
    });

</script>