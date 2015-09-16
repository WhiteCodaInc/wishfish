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
        <a href="<?= site_url() ?>admin/email_list/addEmailList" class="create btn btn-success btn-sm">
            <i class="fa fa-plus"></i>
            Create New Email List
        </a>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row elist">
            <div class="col-xs-12">
                <div class="box" >
                    <div class="box-header">
                        <h3 class="box-title">Email List Detail</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive" id="data-panel">

                        <table id="list-data-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Email List Name</th>
                                    <th>No. of Contacts</th>
                                    <th>View Contacts</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($lists as $value) { ?>
                                    <tr>
                                        <td><?= $value->name ?></td>
                                        <td><?= $value->total ?></td>
                                        <td>
                                            <a href="<?= site_url() ?>admin/email_list/view/<?= $value->list_id ?>" class="btn btn-info btn-xs">
                                                <i class="fa fa-edit"></i>
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Email List Name</th>
                                    <th>No. of Contacts</th>
                                    <th>View Contacts</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div><!-- /.box-body -->
                    <div style="display: none" class="overlay"></div>
                    <div style="display: none" class="loading-img"></div>
                </div><!-- /.box -->
            </div>
        </div>
        <div class="row lcontacts" style="display: none">
            <div class="col-xs-12">
                <div class="box" >
                    <div class="box-header">
                        <h3 class="box-title">Email List Detail</h3>
                    </div><!-- /.box-header -->
                    <div class="row">
                        <div class="col-xs-12" style="margin-left: 1%">
<!--                            <a href="<?= site_url() ?>admin/email_list/addEmailList" class="create btn btn-success btn-sm">
                                <i class="fa fa-plus"></i>
                                Create New Email List
                            </a>
                            <button style="margin-left: 10px" value="Delete" class="delete btn btn-danger btn-sm" id="Delete" type="button" >Delete</button>-->
                        </div>
                    </div>

                    <div class="box-body table-responsive" id="data-panel">

                        <table id="lcontact-data-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Contact Name</th>
                                    <th>Contact Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($lists as $value) { ?>
                                    <tr>
                                        <td>
                                            <div>
                                                <label>
                                                    <input type="checkbox" name="group[]" value="<?= $value->group_id ?>"/>
                                                </label>
                                            </div>
                                        </td>
                                        <td class="hidden-xs hidden-sm"><?= $value->group_id ?></td>
                                        <td><?= $value->group_name ?></td>
                                        <td>
                                            <a href="<?= site_url() ?>admin/email_list/editEmailList/<?= $value->group_id ?>" class="btn bg-navy btn-xs">
                                                <i class="fa fa-edit"></i>
                                                Edit
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Contact Name</th>
                                    <th>Contact Email</th>
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
            aoColumnDefs: [{
                    bSortable: false,
                    aTargets: [0, 3]
                }]
        });
        $("#lcontact-data-table").dataTable({
            aoColumnDefs: [{
                    bSortable: false,
                    aTargets: [0, 3]
                }]
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {

    });
    F
</script>