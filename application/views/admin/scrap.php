<style type="text/css">
    #access tr td,#access tr th{
        text-align: center;
    }
</style>
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">
            Assigned Twilio Number
        </h1>
        <a href="<?= site_url() ?>admin/setting/twilioNumber" class="btn btn-success create">
            <i class="fa fa-plus"></i>
            Assign New Twilio Number
        </a>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Admin Access Class List</h3>
                    </div><!-- /.box-header -->
                    <div class="row">
                        <div class="col-md-12" style="margin-left: 10px">

                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <table id="access" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Admin Access Class</th>
                                    <th>Assigned Twilio Number</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($twilio as $value) { ?>
                                    <tr>
                                        <td><?= $value->class_name ?></td>
                                        <?php
                                        $phone = "(" . substr($value->twilio_number, 0, 2) . ') ';
                                        $phone .= substr($value->twilio_number, 2, 3) . '-';
                                        $phone .= substr($value->twilio_number, 5, 3) . '-';
                                        $phone .= substr($value->twilio_number, 8, 4);
                                        ?>
                                        <td><?= $phone ?></td>
                                        <td>
                                            <a href="<?= site_url() ?>admin/setting/editTwilioNumber/<?= $value->twilio_id ?>" class="btn bg-navy btn-xs">
                                                <i class="fa fa-edit"></i>
                                                Edit
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Admin Access Class</th>
                                    <th>Assigned Twilio Number</th>
                                    <th>Edit</th>

                                </tr>
                            </tfoot>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->

<?php
$msg = $this->input->get('msg');
switch ($msg) {
    case "I":
        $m = "New Twilio Number Successfully Assigned..!";
        $t = "success";
        break;
    case "U":
        $m = "Twilio Number Successfully Updated..!";
        $t = "success";
        break;
    case "F":
        $m = "Twilio Number not Successfully Updated..!";
        $t = "error";
        break;
    default:
        $m = 0;
        break;
}
?>
<script type = "text/javascript" >
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
        $('#example2').dataTable({
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": false,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        });
    });
</script>
