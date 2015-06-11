<style type="text/css">
    #customer-data-table tr td,#customer-data-table tr th{
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
        <h1 style=" display: none">
            Customers
        </h1>
        <button value="Active" class="add btn btn-success btn-sm" id="Active" type="button" >Active</button>
        <button value="Deactive" class="remove btn btn-warning btn-sm" id="Deactive" type="button" >Deactive</button>
        <button value="Delete" class="delete btn btn-danger btn-sm" id="Delete" type="button" >Delete</button>
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
            <div class="col-md-12">
                <!-- Primary box -->
                <div class="box box-solid box-primary collapsed-box">
                    <div class="box-header" data-widget="collapse"  style="cursor: pointer">
                        <h3 class="box-title">Filterable Search</h3>
                    </div>
                    <div class="box-body" style="display: none">
                        <form action="<?= site_url() ?>admin/customers/search" method="post">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Registration</label>
                                    <div class="input-group input-large input-daterange" >
                                        <input type="text" na class="form-control" name="from_search">
                                        <span class="input-group-addon">To</span>
                                        <input type="text" class="form-control" name="to_search">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label>First Name</label>
                                    <input name="name_search" class="form-control" placeholder="Full Name" type="text">
                                </div>
                                <div class="col-md-4">
                                    <label>Email</label>
                                    <input name="email_search" class="form-control" placeholder="Email" type="text">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Plan</label>
                                    <select name="plan_search" class="form-control m-bot15">
                                        <option value="-1">--Select--</option>
                                        <?php foreach ($plans as $value) { ?>
                                            <option value="<?= $value->plan_id ?>">
                                                <?= $value->plan_name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Join Via</label>
                                    <select name="join_search" class="form-control m-bot15">
                                        <option value="-1">--Select--</option>
                                        <option value="Join Now">Join Now</option>
                                        <option value="Register">Register</option>
                                        <option value="Google">Google</option>
                                        <option value="Facebook">Facebook</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Status</label>
                                    <select name="status_search" class="form-control m-bot15">
                                        <option value="-1">--Select--</option>
                                        <option value="1">Active</option>
                                        <option value="2">Deactivated</option>
                                    </select>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="submit" name="search" id="search" value="Search" class="btn btn-success" />
                                    <input type="reset" value="Reset"  class="btn btn-danger"/>
                                </div>
                            </div>
                        </form>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box" >
                    <form name="checkForm" id="checkForm" action="" method="post">
                        <div class="box-body table-responsive" id="data-panel">
                            <table id="customer-data-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="padding: 10px;">
                                            <input type="checkbox"/>
                                        </th>
                                        <th>Profile</th>
                                        <th class="hidden-xs hidden-sm">Date & Time</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Plan</th>
                                        <th class="hidden-xs hidden-sm">Join Via</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($customers)) {
                                        $result = $customers;
                                    } elseif (isset($searchResult)) {
                                        $result = $searchResult;
                                    }
                                    ?>
                                    <?php foreach ($result as $value) { ?>
                                        <?php
                                        $img_src = ($value->profile_pic != "") ?
                                                "http://mikhailkuznetsov.s3.amazonaws.com/" . $value->profile_pic :
                                                base_url() . 'assets/dashboard/img/default-avatar.png';
                                        ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <label>
                                                        <input type="checkbox" class="check"  name="customer[]" value="<?= $value->user_id ?>"/>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="<?= site_url() . 'admin/customers/profile/' . $value->user_id ?>">
                                                    <img style="width:60px;height:60px" src="<?= $img_src ?>" class="img-circle" alt="User Image" />
                                                </a>
                                            </td>
                                            <td><?= date('d-m-Y H:i:s', strtotime($value->register_date)) ?></td>
                                            <td>
                                                <a href="<?= site_url() . 'admin/customers/profile/' . $value->user_id ?>" class="name">
                                                    <?= $value->name ?>
                                                </a>
                                            </td>
                                            <td><?= $value->email ?></td>

                                            <td><?= $value->plan_name ?></td>
                                            <td><?= $value->join_via ?></td>
                                            <td class="hidden-xs hidden-sm">
                                                <?php if ($value->status): ?>
                                                    <span class="btn btn-success btn-xs">Active</span>
                                                <?php else : ?>
                                                    <span class="btn btn-danger btn-xs">Deactive</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th>Profile</th>
                                        <th class="hidden-xs hidden-sm">Date & Time</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Plan</th>
                                        <th class="hidden-xs hidden-sm">Join Via</th>
                                        <th>Status</th>
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
    case "A":
        $m = "Customer Profile Successfully Activated..!";
        $t = "success";
        break;
    case "DA":
        $m = "Customer Profile Successfully Deactivated..!";
        $t = "success";
        break;
    case "D":
        $m = "Customer Profile(s) Successfully Deleted..!";
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
        oTable = $("#customer-data-table").dataTable({
            aLengthMenu: [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, "All"]
            ],
            aoColumnDefs: [{
                    bSortable: false,
                    aTargets: [0, 1, 2, 4, 5, 6, 7]
                }],
            iDisplayLength: -1,
            aaSorting: [[3, 'asc']]
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
<?php if (is_array($data)) { ?>
            $('input[name="name_search"]').val("<?= $data['name_search'] ?>");
            $('input[name="email_search"]').val("<?= $data['email_search'] ?>");
            $('input[name="from_search"]').val("<?= $data['from_search'] ?>");
            $('input[name="to_search"]').val("<?= $data['to_search'] ?>");
            $('select[name="plan_search"]').val("<?= $data['plan_search'] ?>");
            $('select[name="join_search"]').val("<?= $data['join_search'] ?>");
            $('select[name="status_search"]').val("<?= $data['status_search'] ?>");
<?php } ?>
        $('#customer-data-table tbody tr').each(function () {
            $(this).children('td.sorting_1').find('div.checked');
        });
        $('button.add').click(function (e) {
            action($(this).val());
            e.preventDefault();
        });
        $('button.remove').click(function (e) {
            action($(this).val());
            e.preventDefault();
        });
        $('button.delete').click(function (e) {
            var customer = "";
            var act = $(this).val();
            $('#customer-data-table tbody tr').each(function () {
                if ($(this).children('td:first').find('div.checked').length) {
                    $txt = $(this).children('td:nth-child(4)').text();
                    customer += $txt.trim() + ",";
                }
            });
            customer = customer.substring(0, customer.length - 1);
            alertify.confirm("Are you sure want to delete customer(s):<br/>" + customer, function (e) {
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
            $('#checkForm').attr('action', "<?= site_url() ?>admin/customers/action");
            $('#checkForm').submit();
        }
    });

</script>