<!-- Autocomplete Dropdown -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/autocomplete/jquery-ui.css"/>


<style>
    .ui-autocomplete { 
        cursor:pointer; 
        height:120px; 
        overflow-y:scroll;
    }    
</style>

<!-- Normal Checkbox -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/checkbox.css"/>

<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">
            Send New SMS
        </h1>
        <button type="button" id="send" class="btn btn-primary">SEND</button>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">New SMS</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form id="smsForm" role="form" action="<?= site_url() ?>admin/sms/send_message" method="post" >
                        <div class="box-body">
                            <div class="row m-bot15">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Choose User</label>
                                        <select id="user" name="user" class="form-control" >
                                            <option value="1">Admin</option>
                                            <option value="2" selected="">Company Contact</option>
                                            <option value="3">Affiliates</option>
                                            <option value="4">Customer</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row m-bot15">                        
                                <div class="col-md-12">
                                    <label>Choose Option</label>
                                    <div class="form-group">
                                        <div id="individual"  style="float: left;padding-right: 5px;cursor: pointer">
                                            <input id="rd_individual"  type="radio" value="all_c"  name="assign"  class="simple">                          
                                            <span class="lbl padding-8">
                                                Individual <span class="lb_individual">Contacts&nbsp;</span>
                                            </span>
                                        </div>
                                        <div id="group"  style="float: left;padding:0 5px;cursor: pointer;">
                                            <input id="rd_group" type="radio" value="all_gc"  name="assign" class="simple">                          
                                            <span class="lbl padding-8">
                                                Group <span class="lb_individual">Contacts&nbsp;</span>
                                            </span>
                                        </div>
                                        <div id="list"   style="float: left;padding:0 5px;cursor: pointer;">
                                            <input id="rd_list" type="radio" value="all_l"  name="assign" class="simple">                          
                                            <span class="lbl padding-8">SMS List&nbsp;</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-5">
                                    <label>Choose <span id="lbl_select">Contact </span></label>
                                    <div class="form-group" id="user-tag">
                                        <input type="text" class="form-control"  id="users" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Choose SMS Template</label>
                                        <select name="template_id" class="form-control" >
                                            <option value="-1">--Select--</option>
                                            <?php foreach ($template as $value) { ?>
                                                <option value="<?= $value->template_id ?>"><?= $value->title ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <div class='row'>
                                            <div class='col-md-12'>
                                                <div class='box box-info'>
                                                    <div class='box-header'>
                                                        <h3 class='box-title'>Editor</h3>
                                                    </div><!-- /.box-header -->
                                                    <div class='box-body pad'>
                                                        <textarea id="body"  name="body" style="width: 100%;height: 200px" required=""></textarea>
                                                    </div>
                                                </div><!-- /.box -->
                                            </div>
                                        </div><!-- /.box-body -->
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <!-- Default box -->
                                    <div class="box collapsed-box">
                                        <div class="box-header">
                                            <h3 class="box-title">Token List</h3>
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="box-body" style="display: none">
                                            <strong>{FIRST_NAME}</strong><br/>
                                            <strong>{LAST_NAME}</strong><br/>
                                            <strong>{EMAIL}</strong><br/>
                                            <strong>{PHONE}</strong><br/>
                                            <!--<strong>{GROUP}</strong><br/>-->
                                            <strong>{BIRTHDAY}</strong><br/>
                                            <strong>{ZODIAC}</strong><br/>
                                            <strong>{AGE}</strong><br/>
                                            <strong>{BIRTHDAY_ALERT}</strong><br/>
                                            <strong>{SOCIAL}</strong><br/>
                                            <strong>{CONTACT}</strong><br/>
                                            <strong>{COUNTRY}</strong><br/>
                                            <strong>{CITY}</strong><br/>
                                            <strong>{ADDRESS}</strong><br/>
                                            <strong>{RATING}</strong><br/>
                                        </div><!-- /.box-body -->
                                    </div><!-- /.box -->
                                </div><!-- /.col -->
                            </div>
                        </div>
                        <input type="hidden" name="user_id" value="" />
                    </form>
                </div><!-- /.box -->
            </div><!--/.col (left) -->
            <!-- right column -->
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<?php $msg = $this->input->get('msg'); ?>
<?php
switch ($msg) {
    case "send":
        $m = "SMS has been successfully sent..!";
        $t = "success";
        break;
    case "fail":
        $m = "SMS has not been successfully sent..!";
        $t = "error";
        break;
    case "F":
        $m = "This contact does not have phone number..!";
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

<script>
    var contact = new Array();
    var ids = new Array();
    function BindControls(ar1, ar2) {
        contact = ar1;
        ids = ar2;
        $('#users').autocomplete({
            source: ar1,
            minLength: 0,
            scroll: true
        }).focus(function () {
            $(this).autocomplete("search", "");
        });
    }
</script>
<script type="text/javascript">

    $('input[name="assign"]').change(function () {
        var user = $('#user').val();
        if ($(this).val() == "all_c") {
            $.ajax({
                type: 'POST',
                url: "<?= site_url() ?>admin/sms/allUser/" + user,
                success: function (json, textStatus, jqXHR) {
                    var data = JSON.parse(json);
                    var ar1 = data['user'];
                    var ar2 = data['ids'];
                    var lbl = "";
                    switch (user) {
                        case "1":
                            lbl = "Admin";
                            break;
                        case "2":
                            lbl = "Contact";
                            break;
                        case "3":
                            lbl = "Affiliate";
                            break;
                        case "4":
                            lbl = "Customer";
                            break;
                    }
                    $("#lbl_select").text(lbl);
                    $('#user-tag').html('<input type="text" class="form-control"  id="users" />');
                    BindControls(ar1, ar2);
                }
            });
        } else if ($(this).val() == "all_gc") {
            var user = $('#user').val();
            $.ajax({
                type: 'POST',
                url: "<?= site_url() ?>admin/sms/allGroup/" + user,
                success: function (data, textStatus, jqXHR) {
                    $("#lbl_select").text("Group");
                    $('#user-tag').html(data);
                }
            });
        } else if ($(this).val() == "all_l") {
            $.ajax({
                type: 'POST',
                url: "<?= site_url() ?>admin/sms/allSMSlist",
                success: function (data, textStatus, jqXHR) {
                    $("#lbl_select").text("Group");
                    $('#user-tag').html(data);
                }
            });
        }
        else {
            return false;
        }
    });

</script>

<script type="text/javascript">
    $(document).ready(function () {

        $('#send').click(function () {
            $('#smsForm').submit();
        });

        $('#rd_individual').trigger('click');
        $('#smsForm').submit(function () {
            if ($('#body').val().trim() == "")
                alertify.error("Please add some sms content..!");
            $('input[name="user_id"]').val(ids[contact.indexOf($('#users').val())]);
        });

        $('#user').change(function () {
            var user = $(this).val();
            $('#rd_individual').removeAttr('checked');
            switch (user) {
                case "1":
                    $("#lbl_select").text("Admin");
                    $('.lb_individual').text("Admins");
                    $('#rd_individual').trigger('click');
                    $('#individual').css('display', 'block');
                    $('#group').css('display', 'none');
                    $('#list').css('display', 'none');
                    break;
                case "2":
                    $("#lbl_select").text("Contact");
                    $('.lb_individual').text("Contacts");
                    $('#rd_individual').trigger('click');
                    $('#individual').css('display', 'block');
                    $('#group').css('display', 'block');
                    $('#list').css('display', 'block');
                    break;
                case "3":
                case "4":
                    var lbl = (user == "3") ? "Affiliates" : "Customers";
                    var lbl1 = (user == "3") ? "Affiliate" : "Customer";
                    $("#lbl_select").text(lbl1);
                    $('.lb_individual').text(lbl);
                    $('#rd_individual').trigger('click');
                    $('#individual').css('display', 'block');
                    $('#group').css('display', 'block');
                    $('#list').css('display', 'none');
                    break;
            }
        });

        $('select[name="template_id"]').change(function () {
            var tempid = $(this).val();
            if (tempid == "-1") {
                return false;
            } else {
                $.ajax({
                    type: 'POST',
                    url: "<?= site_url() ?>admin/sms/getTemplate/" + tempid,
                    success: function (json, textStatus, jqXHR) {
                        var data = JSON.parse(json);
                        $('#body').val(data.body);
//                        CKEDITOR.instances['editor1'].setData(data.body);
                    }
                });
            }
        });
    });
</script>