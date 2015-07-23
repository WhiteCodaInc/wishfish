
<style type="text/css">
    #profile-data-table tr td,#profile-data-table tr th{
        text-align: center;
    }
    .dataTables_wrapper > div.row:first-child{
        display: none
    }
</style>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">
            Admin Profiles
        </h1>
        <div style="float:left;margin-right:20px">
            <select id="atype" class="form-control">
                <option value="-1">----------Select---------</option>
                <option value="ee">Enable Daily Email Report</option>
                <option value="es">Enable Daily SMS Report</option>
                <option value="de">Disable Daily Email Report</option>
                <option value="ds">Disable Daily SMS Report</option>
                <option value="ea">Enable All</option>
                <option value="da">Disable All</option>
            </select>
        </div>
        <button value="Action" id="action" class="btn btn-primary" type="button" >Submit</button>
        <div class="search" style="float:right;width: 25%">
            <select id="page_length" class="form-control" style="float: left;width: 30%">
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="200">200</option>
                <option value="-1" selected="">All</option>
            </select>
            <input class="form-control" type="text" id="searchbox" placeholder="Search" style="float: left;width: 70%">
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box" >
                    <form name="checkForm" id="checkForm" action="" method="post">
                        <div class="box-body table-responsive" id="data-panel">
                            <table id="profile-data-table"  class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="font-size: 17px;padding-right: 18px;text-align: center;">
                                            <i class="fa fa-level-down"></i>
                                        </th>
<!--                                        <th>Profile</th>-->
                                        <th>Full Name</th>
                                        <th class="hidden-xs hidden-sm">Username</th>
                                        <th class="hidden-xs hidden-sm">Assign Admin Access Class</th>
                                        <th class="hidden-xs hidden-sm">Email</th>
                                        <th class="hidden-xs hidden-sm">Phone</th>
                                        <th>Email Report Status</th>
                                        <th>SMS Report Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($profiles as $value) { ?>
                                        <?php
//                                        $img_src = ($value->admin_avatar != "") ?
//                                                "http://mikhailkuznetsov.s3.amazonaws.com/" . $value->admin_avatar :
//                                                base_url() . 'assets/dashboard/img/default-avatar.png';
                                        ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <label>
                                                        <input type="checkbox" name="profile[]" value="<?= $value->profile_id ?>"/>
                                                    </label>
                                                </div>
                                            </td>
    <!--                                            <td>
                                                <img style="width:60px;height:60px" src="<?= $img_src ?>" class="img-circle" alt="User Image" />
                                            </td>-->
                                            <td>
                                                <a href="<?= site_url() . 'admin/admin_profile/profile/' . $value->profile_id ?>" class="name">
                                                    <?= $value->fname . ' ' . $value->lname ?>
                                                </a>
                                            </td>
                                            <td class="hidden-xs hidden-sm"><?= $value->userid ?></td>
                                            <!--<td class="hidden-xs hidden-sm"><?= $value->password ?></td>-->
                                            <td class="hidden-xs hidden-sm">
                                                <?php
                                                foreach ($class as $cls) {
                                                    if ($value->class_id == $cls->class_id)
                                                        echo $cls->class_name;
                                                }
                                                ?>
                                            </td>
                                            <td class="hidden-xs hidden-sm"><?= $value->email ?></td>
                                            <?php
                                            if ($value->phone) {
                                                $phone = "(" . substr($value->phone, 0, 2) . ') ';
                                                $phone .= substr($value->phone, 2, 3) . '-';
                                                $phone .= substr($value->phone, 5, 3) . '-';
                                                $phone .= substr($value->phone, 8, 4);
                                            } else {
                                                $phone = "N/A";
                                            }
                                            ?>
                                            <td class="hidden-xs hidden-sm"><?= $phone ?></td>
                                            <td>
                                                <?php if ($value->email_report): ?>
                                                    <span class="btn btn-success btn-xs">Enable</span>
                                                <?php else : ?>
                                                    <span class="btn btn-danger btn-xs">Disable</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($value->sms_report): ?>
                                                    <span class="btn btn-success btn-xs">Enable</span>
                                                <?php else : ?>
                                                    <span class="btn btn-danger btn-xs">Disable</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <!--<th>Profile</th>-->
                                        <th>Full Name</th>
                                        <th class="hidden-xs hidden-sm">Username</th>
                                        <th class="hidden-xs hidden-sm">Assign Admin Access Class</th>
                                        <th class="hidden-xs hidden-sm">Email</th>
                                        <th class="hidden-xs hidden-sm">Phone</th>
                                        <th>Email Report Status</th>
                                        <th>SMS Report Status</th>
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
    case "ES":
        $m = "SMS Daily Report Successfully Enable..!";
        $t = "success";
        break;
    case "DS":
        $m = "SMS Daily Report Successfully Disable..!";
        $t = "error";
        break;
    case "EE":
        $m = "Email Daily Report Successfully Enable..!";
        $t = "success";
        break;
    case "DE":
        $m = "Email Daily Report Successfully Disable..!";
        $t = "error";
        break;
    case "DA":
        $m = "All Daily Report Successfully Disable..!";
        $t = "error";
    case "EA":
        $m = "All Daily Report Successfully Enable..!";
        $t = "success";
        break;
    default:
        $m = 0;
        break;
}
?>
<script type="text/javascript">
    $('.input-daterange').datepicker({
        format: "dd-mm-yyyy",
        todayBtn: "linked",
        autoclose: true,
        todayHighlight: true
    });
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
        oTable = $("#profile-data-table").dataTable({
            aLengthMenu: [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, "All"]
            ],
            aoColumnDefs: [{
                    bSortable: false,
                    aTargets: [0, 1, 4, 5, 6, 7]
                }],
            iDisplayLength: -1,
            aaSorting: [[2, 'asc']]
        });
        $("#searchbox").on("keyup search input paste cut", function () {
            oTable.fnFilter(this.value);
        });
        $('#page_length').change(function () {
            var length = parseInt($(this).val());
            console.log(length);
            var oSettings = oTable.fnSettings();
            oSettings._iDisplayLength = length;
            oTable.fnPageChange("first");
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {

        $('#action').click(function (e) {
            var act = $('#atype').val();
            if (act == "-1") {
                alertify.error("Please Select Option..!");
                return false;
            }
            action(act);
        });

        function action(actiontype) {
            $('#actionType').val(actiontype);
            $('#checkForm').attr('action', "<?= site_url() ?>admin/analytics/action");
            $('#checkForm').submit();
        }
    });

</script>