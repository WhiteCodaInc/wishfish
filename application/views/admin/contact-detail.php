<style type="text/css">
    #contact-data-table tr td,#contact-data-table tr th{
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
        <h1 style="display: none">Contacts</h1>
        <?php if ($p->coni): ?>
            <a style="float: left" href="<?= site_url() ?>admin/contacts/addContact" class="btn btn-success btn-sm create">
                <i class="fa fa-plus"></i>
                Create New Contact
            </a>
        <?php endif; ?>
        <?php if ($p->conu): ?>
            <div style="float: left;margin-right: 2% ">
                <select id="group"  class="form-control m-bot15">
                    <option value="-1">Select Group</option>
                    <?php foreach ($groups as $value) { ?>
                        <option value="<?= $value->group_id ?>">
                            <?= $value->group_name ?></option>
                    <?php } ?>
                </select>
            </div>
            <button  value="Add" class="btn btn-info btn-sm add" id="Add" type="button" >Add To Group</button>
            <button  value="Remove" class="btn btn-info btn-sm remove" id="Remove" type="button" >Remove From Group</button>
        <?php endif; ?>
        <?php if ($p->cond): ?>
            <button  value="Delete" class="btn btn-danger btn-sm delete" id="Delete" type="button" >Delete</button>
        <?php endif; ?>
        <?php if ($p->coni): ?>
            <a class="btn btn-primary btn-sm create" href="<?= site_url() ?>admin/import">
                <span> Import Google Contact</span>
            </a>
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
                        <form action="<?= site_url() ?>admin/contacts/search" method="post">
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
                                    <label>Contact Group</label>
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

                            <table id="contact-data-table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <?php if ($p->conu || $p->cond): ?>
                                            <th style="padding: 10px;">
                                                <input type="checkbox"/>
                                            </th>
                                        <?php endif; ?>
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th class="hidden-xs hidden-sm">Email</th>
                                        <th class="hidden-xs hidden-sm">Phone</th>
                                        <th class="hidden-xs hidden-sm">Birthday</th>
                                        <th class="hidden-xs hidden-sm">Zodiac</th>
                                        <th class="hidden-xs hidden-sm">Contact Groups</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($contacts)) {
                                        $result = $contacts;
                                    } elseif (isset($searchResult)) {
                                        $result = $searchResult;
                                    }
                                    ?>
                                    <?php foreach ($result as $value) { ?>
                                        <?php
                                        $img_src = ($value->contact_avatar != "") ?
                                                "http://mikhailkuznetsov.s3.amazonaws.com/" . $value->contact_avatar :
                                                base_url() . 'assets/dashboard/img/default-avatar.png';
                                        ?>
                                        <tr>
                                            <?php if ($p->conu || $p->cond): ?>
                                                <td >
                                                    <div>
                                                        <label>
                                                            <input type="checkbox" name="contact[]" value="<?= $value->contact_id ?>"/>
                                                        </label>
                                                    </div>
                                                </td>
                                            <?php endif; ?>
                                            <td >
                                                <img style="width:60px;height:60px" src="<?= $img_src ?>" class="img-circle" alt="User Image" />
                                            </td>
                                            <td>
                                                <a href="<?= site_url() . 'admin/contacts/profile/' . $value->contact_id ?>" class="name">
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
                                            <td class="hidden-xs hidden-sm"><?= ($value->birthday != NULL) ? date('d-m-Y', strtotime($value->birthday)) : 'N/A' ?></td>
                                            <td class="hidden-xs hidden-sm"><?= $value->zodiac ?></td>
                                            <td class="hidden-xs hidden-sm"><?= $value->group_name ?></td>
                                            <td >
                                                <?php if ($p->conu): ?>
                                                    <a href="<?= site_url() ?>admin/contacts/editContact/<?= $value->contact_id ?>" class="btn bg-navy btn-xs">
                                                        <i class="fa fa-edit"></i>
                                                        Edit
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <?php if ($p->conu || $p->cond): ?>
                                            <th></th>
                                        <?php endif; ?>
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th class="hidden-xs hidden-sm">Email</th>
                                        <th class="hidden-xs hidden-sm">Phone</th>
                                        <th class="hidden-xs hidden-sm">Birthday</th>
                                        <th class="hidden-xs hidden-sm">Zodiac</th>
                                        <th class="hidden-xs hidden-sm">Profile Rating(1-10)</th>
                                        <th>Edit</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <?php if ($p->conu || $p->cond): ?>
                                <input type="hidden" id="actionType" name="actionType" value="" />
                                <input type="hidden" id="groupid" name="groupid" value="" />
                            <?php endif; ?>
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
    case "I":
        $m = "Contact Profile Successfully Created..!";
        $t = "success";
        break;
    case "A":
        $m = "Contact(s) Successfully Added Into Group..!";
        $t = "success";
        break;
    case "U":
        $m = "Contact Profile Successfully Updated..!";
        $t = "success";
        break;
    case "UF":
        $m = "Contact Avatar not uploaded..!";
        $t = "error";
        break;
    case "IF":
        $m = "Invalid File Format..!";
        $t = "error";
        break;
    case "D":
        $m = "Contact Profile(s) Successfully Deleted..!";
        $t = "error";
        break;
    case "R":
        $m = "Contact(s) Successfully Removed From Group..!";
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
        oTable = $("#contact-data-table").dataTable({
            aLengthMenu: [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, "All"]
            ],
            aoColumnDefs: [{
                    bSortable: false,
                    aTargets: [0, 1, 3, 4, 7, 8]
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
<?php if ($p->conu || $p->cond): ?>
            $('button.add').click(function (e) {
                action($(this).val());
                e.preventDefault();
            });
            $('button.remove').click(function (e) {
                action($(this).val());
                e.preventDefault();
            });

            $('button.delete').click(function (e) {
                var contact = "";
                var act = $(this).val();
                $('#contact-data-table tbody tr').each(function () {
                    if ($(this).children('td:first').find('div.checked').length) {
                        $txt = $(this).children('td:nth-child(3)').children('a').text();
                        contact += $txt.trim() + ",";
                    }
                });
                contact = contact.substring(0, contact.length - 1);

                alertify.confirm("Are you sure want to delete contact(s):<br/>" + contact, function (e) {
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
                $('#groupid').val($('#group').val());
                if (actiontype == "Add" || actiontype == "Remove") {
                    if ($('#group').val() == "-1") {
                        alertify.error("Please Select Group First..!");
                        return false;
                    }
                }
                $('#checkForm').attr('action', "<?= site_url() ?>admin/contacts/action");
                $('#checkForm').submit();
            }
<?php endif; ?>
    });
</script>