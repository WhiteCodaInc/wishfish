<style type="text/css">
    #builder-data-table tr td,#builder-data-table tr th{
        text-align: center;
    }
</style>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style=" display: none">
            Email List Builder
        </h1>
        <a href="<?= site_url() ?>admin/email_list_builder/addList" class="create btn btn-success btn-sm">
            <i class="fa fa-plus"></i>
            New Email List
        </a>
        <button  value="Delete" class="delete btn btn-danger btn-sm" id="Delete" type="button" >Delete</button>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-xs-12">
                <div class="box" >
                    <div class="box-header">
                        <h3 class="box-title">Email List Detail</h3>
                    </div><!-- /.box-header -->
                    <div class="row">
                        <div class="col-xs-12" style="margin-left: 1%">
<!--                            <a href="<?= site_url() ?>admin/email_list_builder/addList" class="create btn btn-success btn-sm">
                                <i class="fa fa-plus"></i>
                                New Email List
                            </a>
                            <button style="margin-left: 10px" value="Delete" class="delete btn btn-danger btn-sm" id="Delete" type="button" >Delete</button>-->
                        </div>
                    </div>

                    <form name="checkForm" id="checkForm" action="" method="post">
                        <div class="box-body table-responsive" id="data-panel">

                            <table id="builder-data-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="padding: 10px;">
                                            <input type="checkbox"/>
                                        </th>
                                        <th>Email List</th>
                                        <th>Total Contacts</th>
                                        <th>Add Contacts</th>
                                        <th>Add Groups</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($groups as $value) { ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <label>
                                                        <input type="checkbox" name="group[]" value="<?= $value->group_id ?>"/>
                                                    </label>
                                                </div>
                                            </td>
                                            <td><?= $value->group_name ?></td>
                                            <td>
                                                <a style="cursor: pointer" id="<?= $value->group_id ?>" class="view" >
                                                    <?= $value->total ?>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="<?= site_url() ?>admin/email_list_builder/addContacts/<?= $value->group_id ?>" class="btn bg-navy">
                                                    <i class="fa fa-edit"></i>
                                                    Add Contacts
                                                </a>
                                            </td>
                                            <td>
                                                <a href="<?= site_url() ?>admin/email_list_builder/addGroups/<?= $value->group_id ?>" class="btn bg-navy">
                                                    <i class="fa fa-edit"></i>
                                                    Add Groups
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>Email List</th>
                                        <th class="hidden-xs hidden-sm">Total Contacts</th>
                                        <th>Add Contacts</th>
                                        <th>Add Groups</th>
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

<span style="display: none" id="list" data-toggle="modal" data-target="#list-preview"></span>
<!-- NEW EVENT MODAL -->
<div class="modal fade" id="list-preview" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Email List Detail</h4>
            </div>
            <div class="modal-body">
                <div class="row m-bot15">                        
                    <div id="list-view" class="col-md-12"></div>
                </div>
                <div class="modal-footer clearfix">
                    <button type="button" id="n_discard" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Discard</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div>
<!-- /.modal -->

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

<style type="text/css">
    .tooltip{
        width: 200px;
        height: auto;
        font-family: inherit;
        font-size: 15px;
    }
</style>
<!-- page script -->
<script type="text/javascript">
    $(function () {
        $("#builder-data-table").dataTable({
            aoColumnDefs: [{
                    bSortable: false,
                    aTargets: [0, 3, 4]
                }]
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('button.delete').click(function (e) {
            var email = "";
            var act = $(this).val();
            $('#builder-data-table tbody tr').each(function () {
                if ($(this).children('td:first').find('div.checked').length) {
                    $txt = $(this).children('td:nth-child(2)').text();
                    email += $txt.trim() + ",";
                }
            });

            email = email.substring(0, email.length - 1);

            alertify.confirm("Are you sure want to delete email list(s):<br/>" + email, function (e) {
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
            $('#checkForm').attr('action', "<?= site_url() ?>admin/email_list_builder/action");
            $('#checkForm').submit();
        }

        $('.view').click(function () {
            var groupid = $(this).attr('id');
            $.ajax({
                type: 'POST',
                url: "<?= site_url() ?>admin/email_list_builder/getGroupInfo?id=" + groupid,
                success: function (data, textStatus, jqXHR) {
                    $('#list-view').html(data);
                    $('#list').trigger('click');
                }
            });
        });
    });
</script>