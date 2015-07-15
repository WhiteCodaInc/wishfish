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
            SMS List Builder
        </h1>
        <a href="<?= site_url() ?>admin/sms_list_builder/addList" class="create btn btn-success btn-sm">
            <i class="fa fa-plus"></i>
            New SMS List
        </a>
        <button value="Delete" class="delete btn btn-danger btn-sm" id="Delete" type="button" >Delete</button>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-xs-12">
                <div class="box" >
                    <div class="box-header">
                        <h3 class="box-title">SMS List Detail</h3>
                    </div><!-- /.box-header -->
                    <form name="checkForm" id="checkForm" action="" method="post">
                        <div class="box-body table-responsive" id="data-panel">

                            <table id="builder-data-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="padding: 10px;">
                                            <input type="checkbox"/>
                                        </th>
                                        <th>SMS List</th>
                                        <th class="hidden-xs hidden-sm">Total Contacts</th>
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
                                            <td class="hidden-xs hidden-sm"><?= $value->total ?></td>
                                            <td>
                                                <a href="<?= site_url() ?>admin/sms_list_builder/addContacts/<?= $value->group_id ?>" class="btn bg-navy">
                                                    <i class="fa fa-edit"></i>
                                                    Add Contacts
                                                </a>
                                            </td>
                                            <td>
                                                <a href="<?= site_url() ?>admin/sms_list_builder/addGroups/<?= $value->group_id ?>" class="btn bg-navy">
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
                                        <th>SMS List</th>
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
<?php $msg = $this->input->get('msg'); ?>
<?php
switch ($msg) {
    case "I":
        $m = "SMS List Successfully Created..!";
        $t = "success";
        break;
    case "U":
        $m = "SMS List Successfully Updated..!";
        $t = "success";
        break;
    case "D":
        $m = "SMS List(s) Successfully Deleted..!";
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
            var sms = "";
            var act = $(this).val();
            $('#builder-data-table tbody tr').each(function () {
                if ($(this).children('td:first').find('div.checked').length) {
                    $txt = $(this).children('td:nth-child(2)').text();
                    sms += $txt.trim() + ",";
                }
            });

            sms = sms.substring(0, sms.length - 1);

            alertify.confirm("Are you sure want to delete sms list(s):<br/>" + sms, function (e) {
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
            $('#checkForm').attr('action', "<?= site_url() ?>admin/sms_list_builder/action");
            $('#checkForm').submit();
        }
    });

</script>