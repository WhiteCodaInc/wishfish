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
            Email Templates
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-xs-12">
                <div class="box" >
                    <div class="box-header">
                        <h3 class="box-title">Email Template</h3>
                    </div><!-- /.box-header -->
                    <!--                    <div class="row">
                                            <div class="col-xs-12" style="margin-left: 1%">
                                                <a href="<?= site_url() ?>automail/add" class="btn btn-success btn-sm">
                                                    <i class="fa fa-plus"></i>
                                                    Create New Email Template
                                                </a>
                                                <button style="margin-left: 10px" value="Delete" class="btn btn-danger btn-sm" id="Delete" type="button" >Delete</button>
                                            </div>
                                        </div>-->
                    <!--<form name="checkForm" id="checkForm" action="" method="post">-->
                    <div class="box-body table-responsive" id="data-panel">
                        <table id="email-data-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
<!--                                        <th style="font-size: 17px;padding-right: 18px;text-align: center;">
                                        <i class="fa fa-level-down"></i>
                                    </th>-->
                                    <th class="hidden-xs hidden-sm">Mail Type</th>
                                    <th class="hidden-xs hidden-sm">From</th>
                                    <th class="hidden-xs hidden-sm">Name</th>
                                    <th class="hidden-xs hidden-sm">Mail Subject</th>
                                    <th class="hidden-xs hidden-sm">Color</th>
                                    <th class="hidden-xs hidden-sm">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($automail as $value) { ?>
                                    <tr>
    <!--                                            <td>
                                            <div>
                                                <label>
                                                    <input type="checkbox" name="mailid[]" value="<?= $value->mail_id ?>"/>
                                                </label>
                                            </div>
                                        </td>-->
                                        <td class="hidden-xs hidden-sm"><?= $value->mail_type ?></td>
                                        <td class="hidden-xs hidden-sm"><?= $value->from ?></td>
                                        <td class="hidden-xs hidden-sm"><?= $value->name ?></td>
                                        <td class="hidden-xs hidden-sm"><?= $value->mail_subject ?></td>
                                        <td class="hidden-xs hidden-sm">
                                            <span class="btn" style ="background:<?= $value->color ?>;"></span>
                                        </td>
                                        <td>
                                            <a href="<?= site_url() ?>automail/edit/<?= $value->mail_id ?>" class="btn bg-navy btn-xs">
                                                <i class="fa fa-edit"></i>
                                                Edit
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <!--<th></th>-->
                                    <th class="hidden-xs hidden-sm">Mail Type</th>
                                    <th class="hidden-xs hidden-sm">From</th>
                                    <th class="hidden-xs hidden-sm">Name</th>
                                    <th class="hidden-xs hidden-sm">Mail Subject</th>
                                    <th class="hidden-xs hidden-sm">Color</th>
                                    <th class="hidden-xs hidden-sm">Action</th>
                                </tr>
                            </tfoot>
                        </table>
                        <!--<input type="hidden" id="actionType" name="actionType" value="" />-->
                    </div><!-- /.box-body -->
                    <!--</form>-->
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<?php $msg = $this->input->get('msg'); ?>
<?php
switch ($msg) {
//    case "I":
//        $m = "Email Template Successfully Created..!";
//        $t = "success";
//        break;
    case "U":
        $m = "Email Template Successfully Updated..!";
        $t = "success";
        break;
//    case "D":
//        $m = "Email Template(s) Successfully Deleted..!";
//        $t = "error";
//        break;
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
<script type="text/javascript">
    $(document).ready(function () {
//        $('#Delete').click(function (e) {
//            var act = $(this).val();
//            alertify.confirm("Are you sure you wish to delete Email Template(s)", function (e) {
//                if (e) {
//                    action(act);
//                    return true;
//                }
//                else {
//                    return false;
//                }
//            });
//        });
//        function action(actiontype) {
//            $('#actionType').val(actiontype);
//            $('#checkForm').attr('action', "<?= site_url() ?>automail/action");
//            $('#checkForm').submit();
//        }
    });

</script>