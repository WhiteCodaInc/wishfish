<style type="text/css">
    #contacts-data-table tr td,#contacts-data-table tr th{
        text-align: center;
    }
    #groups-data-table tr td,#groups-data-table tr th{
        text-align: center;
    }
</style>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header" style="display: none">
        <h1 style=" display: none">
            Email List Detail
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-6">
                <div class="box" >
                    <div class="box-header">
                        <h3 class="box-title">Email List Contacts</h3>
                    </div><!-- /.box-header -->
                    <form name="checkForm" action="<?= site_url() ?>admin/email_list_builder/delete/contacts" method="post">
                        <div class="box-body table-responsive" id="data-panel">
                            <div class="row">
                                <div class="col-xs-12" style="margin-left: 1%">
                                    <button  value="Delete" class="delete btn btn-danger btn-sm"  type="submit" >Delete</button>
                                </div>
                            </div>
                            <br/>
                            <table id="contacts-data-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="font-size: 17px;padding-right: 18px;text-align: center;">
                                            <i class="fa fa-level-down"></i>
                                        </th>
                                        <th>Contacts</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($contacts as $value) { ?>
                                        <?php $contactInfo = $this->common->getContactInfo($value); ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <label>
                                                        <input type="checkbox" name="contacts[]" value="<?= $contactInfo->contact_id ?>"/>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <?= $contactInfo->fname . ' ' . $contactInfo->lname . ' | ', $contactInfo->email ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>Contacts</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div><!-- /.box-body -->
                        <input type="hidden" name="groupid" value="<?= $this->input->get('id') ?>" />
                    </form>
                </div><!-- /.box -->
            </div>
            <div class="col-md-6">
                <div class="box" >
                    <div class="box-header">
                        <h3 class="box-title">Email List Groups</h3>
                    </div><!-- /.box-header -->
                    <form name="checkForm" action="<?= site_url() ?>admin/email_list_builder/delete/groups" method="post">
                        <div class="box-body table-responsive" id="data-panel">
                            <div class="row">
                                <div class="col-xs-12" style="margin-left: 1%">
                                    <button  value="Delete" class="delete btn btn-danger btn-sm"  type="submit" >Delete</button>
                                </div>
                            </div>
                            <br/>
                            <table id="groups-data-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="font-size: 17px;padding-right: 18px;text-align: center;">
                                            <i class="fa fa-level-down"></i>
                                        </th>
                                        <th>Groups</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($groups as $value) { ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <label>
                                                        <input type="checkbox" name="groups[]" value="<?= $value->group_id ?>"/>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <?= $value->group_name ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>Groups</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div><!-- /.box-body -->
                        <input type="hidden" name="groupid" value="<?= $this->input->get('id') ?>" />
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
    case "DC":
        $m = "Email List Contact(s) Successfully Deleted..!";
        $t = "error";
        break;
    case "DG":
        $m = "Email List Group(s) Successfully Deleted..!";
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
        $("#contacts-data-table").dataTable();
        $("#groups-data-table").dataTable();
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {


    });
</script>