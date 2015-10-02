<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/checkbox.css"/>
<style type="text/css">
    #affiliate-data-table tr td,#affiliate-data-table tr th{
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
            Affiliates
        </h1>
        <?php if ($p->affu): ?>
            <button value="Active" class="add btn btn-success btn-sm" id="Active" type="button" >Active</button>
            <button value="Deactive" class="remove btn btn-warning btn-sm" id="Deactive" type="button" >Deactivate</button>
            <button type="button" class="create btn btn-info btn-sm setting">Payout Setting</button>
        <?php endif; ?>
        <?php if ($p->affd): ?>
            <button style="margin-left: 10px" value="Delete" class="btn btn-danger btn-sm delete" id="Delete" type="button" >Delete</button>
        <?php endif; ?>
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
                        <form action="<?= site_url() ?>admin/affiliates/search" method="post">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>First Name</label>
                                            <input name="fname_search" class="form-control" placeholder="First Name" type="text">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Last Name</label>
                                            <input name="lname_search" class="form-control" placeholder="Last Name" type="text">
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <label>Email</label>
                                    <input name="email_search" class="form-control" placeholder="Email" type="text">
                                </div>
                                <div class="col-md-4">
                                    <label>Age</label>
                                    <input name="age_search" class="form-control" placeholder="Age" type="text">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Birthday</label>
                                    <div class="input-group input-large input-daterange" >
                                        <input type="text" na class="form-control" name="from_search">
                                        <span class="input-group-addon">To</span>
                                        <input type="text" class="form-control" name="to_search">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label>Affiliate Group</label>
                                    <select name="group_search" class="form-control m-bot15">
                                        <option value="-1">--Select--</option>
                                        <?php foreach ($groups as $value) { ?>
                                            <option value="<?= $value->group_id ?>">
                                                <?= $value->group_name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Zodiac</label>
                                    <select name="zodiac_search" class="form-control m-bot15">
                                        <option value="-1">--Select--</option>
                                        <?php foreach ($zodiac as $value) { ?>
                                            <option value="<?= $value->zodiac_name ?>"><?= $value->zodiac_name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Country</label>
                                    <input name="country_search" class="form-control" placeholder="Country" type="text">
                                </div>
                                <div class="col-md-4">
                                    <label>City</label>
                                    <input name="city_search" class="form-control" placeholder="City" type="text">
                                </div>
                                <div class="col-md-4">
                                    <label>Address</label>
                                    <input name="address_search" class="form-control" placeholder="Address" type="text">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Profile Rating(1-10)</label>
                                    <select name="rating_search" class="form-control m-bot15">
                                        <option value="-1">--Select--</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
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

                            <table id="affiliate-data-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <?php if ($p->affd): ?>
                                            <th style="padding: 10px;">
                                                <input type="checkbox"/>
                                            </th>
                                        <?php endif; ?>
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th class="hidden-xs hidden-sm">Email</th>
                                        <th class="hidden-xs hidden-sm">Phone</th>
                                        <th>Payout Setting</th>
                                        <th>Join Date & Time</th>
                                        <th>Affiliate Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($affiliates)) {
                                        $result = $affiliates;
                                    } elseif (isset($searchResult)) {
                                        $result = $searchResult;
                                    }
                                    ?>
                                    <?php foreach ($result as $value) { ?>
                                        <?php
                                        $img_src = ($value->affiliate_avatar != "") ?
                                                "http://mikhailkuznetsov.s3.amazonaws.com/" . $value->affiliate_avatar :
                                                base_url() . 'assets/dashboard/img/default-avatar.png';
                                        ?>
                                        <tr>
                                            <?php if ($p->affd): ?>
                                                <td>
                                                    <div>
                                                        <label>
                                                            <input type="checkbox" name="affiliate[]" value="<?= $value->affiliate_id ?>"/>
                                                        </label>
                                                    </div>
                                                </td>
                                            <?php endif; ?>
                                            <td >
                                                <img style="width:60px;height:60px" src="<?= $img_src ?>" class="img-circle" alt="User Image" />
                                            </td>
                                            <td>
                                                <a href="<?= site_url() . 'admin/affiliates/profile/' . $value->affiliate_id ?>" class="name">
                                                    <?= $value->fname . ' ' . $value->lname ?>
                                                </a>
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
                                            <td class=""><?= ($value->payout_type == 1) ? "Global" : "Affiliate Specific" ?></td>
                                            <td class=""><?= $value->register_date ?></td>
                                            <td>
                                                <?php if ($value->status): ?>
                                                    <span class="btn btn-success btn-xs">Active</span>
                                                <?php else : ?>
                                                    <span class="btn btn-danger btn-xs">Deactivate</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <?php if ($p->affd): ?>
                                            <th></th>
                                        <?php endif; ?>
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th class="hidden-xs hidden-sm">Email</th>
                                        <th class="hidden-xs hidden-sm">Phone</th>
                                        <th>Payout Setting</th>
                                        <th>Join Date & Time</th>
                                        <th>Affiliate Status</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <?php if ($p->affd): ?>
                                <input type="hidden" id="actionType" name="actionType" value="" />
                            <?php endif; ?>
                        </div><!-- /.box-body -->
                    </form>
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<a href="javascript:void(0);" id="payoutModal" class="create btn btn-info btn-sm" data-toggle="modal" data-target="#payout-modal"></a>
<!-------------------------------Card Detail Model------------------------------------>
<div class="modal fade" id="payout-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 400px">
        <div class="modal-content">
            <form id="payoutForm" role="form" action="<?= site_url() ?>admin/affiliate/updateSetting"  method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Payout Setting</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div style="float: left;padding-right: 5px;cursor: pointer">
                            <input type="radio" value="global"  name="payouttype" checked="" class="simple form-control">                          
                            <span class="lbl padding-8">Global&nbsp;</span>
                        </div>
                        <div style="float: left;padding:0 5px;cursor: pointer">
                            <input type="radio" value="aff"  name="payouttype" class="simple form-control">
                            <span  class="lbl padding-8">Affiliate Specific&nbsp;</span>
                        </div>
                    </div><br/>
                    <div class="form-group aff-specific" style="display: none">
                        <label>Payout On Recurring Purchase </label>
                        <input value=""  type="number" name="normal" class="form-control" placeholder="PER(%)" />
                    </div>
                    <div class="form-group aff-specific" style="display: none">
                        <label>Payout On Recurring Purchase </label>
                        <input value=""  type="number" name="recurring" class="form-control" placeholder="PER(%)" />
                    </div>
                    <div class="form-group">
                        <span style="color: red;" id="msgPayout"></span>
                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <div class="row">
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary pull-left">Save</button>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-danger discard" data-dismiss="modal">
                                <i class="fa fa-times"></i> Discard
                            </button>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="payoutid" value="" />
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!------------------------------------------------------------------------>


<?php $msg = $this->input->get('msg'); ?>
<?php $data = $this->input->post(); ?>
<?php
switch ($msg) {
    case "A":
        $m = "Affiliate Profile Successfully Activated..!";
        $t = "success";
        break;
    case "DA":
        $m = "Affiliate Profile Successfully Deactivated..!";
        $t = "success";
        break;
//    case "I":
//        $m = "Affiliate Profile Successfully Created..!";
//        $t = "success";
//        break;
    case "U":
        $m = "Affiliate Profile Successfully Updated..!";
        $t = "success";
        break;
    case "UF":
        $m = "Affiliate Avatar not uploaded..!";
        $t = "error";
        break;
    case "IF":
        $m = "Invalid File Format..!";
        $t = "error";
        break;
    case "D":
        $m = "Affiliate Profile(s) Successfully Deleted..!";
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
        format: "mm-dd-yyyy",
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
        oTable = $("#affiliate-data-table").dataTable({
            bSort: false,
            aLengthMenu: [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, "All"]
            ],
            iDisplayLength: -1
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

        $('span.lbl.padding-8').click(function () {
            $(this).prev('input:radio').trigger('click');
        });

        $('button.setting').click(function () {
            var len = $('#affiliate-data-table tbody :checkbox').filter(':checked').length;
            if (len > 0) {
                $('#payoutModal').trigger('click');
                return true;
            } else {
                alertify.error('Minimum one affiliate must be selected..!');
                return false;
            }
        });

        $('input[name="payouttype"]').change(function () {
            if ($(this).val() == "aff") {
                $('.aff-specific').show();
            } else {
                $('.aff-specific').hide();
            }
        });

        $('#payoutForm').on('submit', function () {
            var type = $('input[name="payouttype"]:checked').val();
            var normal = $('input[name="normal"]').val();
            var recur = $('input[name="recurring"]').val();

            if (type == "global") {
                $('#payoutForm input').empty();
            } else {
                if (normal < 0 || normal > 100) {
                    $('#msgPayout').text("Invalid Immediate Purchase Value..!");
                    return false;
                } else {
                    $('#msgPayout').empty();
                }
                if (recur < 0 || recur > 100) {
                    $('#msgPayout').text("Invalid Recurring Purchase Value..!");
                    return false;
                } else {
                    $('#msgPayout').empty();
                }
            }
        });

<?php if (is_array($data)) { ?>
            $('input[name="fname_search"]').val("<?= $data['fname_search'] ?>");
            $('input[name="lname_search"]').val("<?= $data['lname_search'] ?>");
            $('input[name="email_search"]').val("<?= $data['email_search'] ?>");
            $('input[name="age_search"]').val("<?= $data['age_search'] ?>");
            $('input[name="from_search"]').val("<?= $data['from_search'] ?>");
            $('input[name="to_search"]').val("<?= $data['to_search'] ?>");
            $('select[name="group_search"]').val("<?= $data['group_search'] ?>");
            $('select[name="zodiac_search"]').val("<?= $data['zodiac_search'] ?>");
            $('input[name="country_search"]').val("<?= $data['country_search'] ?>");
            $('input[name="city_search"]').val("<?= $data['city_search'] ?>");
            $('input[name="address_search"]').val("<?= $data['address_search'] ?>");
            $('select[name="rating_search"]').val("<?= $data['rating_search'] ?>");
<?php } ?>

<?php if ($p->affd): ?>
            $('button.add').click(function (e) {
                action($(this).val());
                e.preventDefault();
            });
            $('button.remove').click(function (e) {
                action($(this).val());
                e.preventDefault();
            });
<?php endif; ?>
<?php if ($p->affd): ?>

            $('button.delete').click(function (e) {
                var affiliate = "";
                var act = $(this).val();
                $('#affiliate-data-table tbody tr').each(function () {
                    if ($(this).children('td:first').find('div.checked').length) {
                        $txt = $(this).children('td:nth-child(3)').children('a').text();
                        affiliate += $txt.trim() + ",";
                    }
                });

                affiliate = affiliate.substring(0, affiliate.length - 1);
                alertify.confirm("Are you sure want to delete affiliate(s):<br/>" + affiliate, function (e) {
                    if (e) {
                        action(act);
                        return true;
                    }
                    else {
                        return false;
                    }
                });
            });
<?php endif; ?>
        function action(actiontype) {
            $('#actionType').val(actiontype);
            $('#checkForm').attr('action', "<?= site_url() ?>admin/affiliates/action");
            $('#checkForm').submit();
        }
    });
</script>