<!-- Autocomplete Dropdown -->
<!--<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>-->
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
        <h1>
            Send New SMS
        </h1>

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
                                <div class="col-md-12">	
                                    <div class="form-group">
                                        <div class="rd" style="float: left;padding-right: 5px;cursor: pointer">
                                            <input type="radio" value="all_c"  name="assign" checked="" class="simple">                          
                                            <span class="lbl padding-8">Individual Contacts&nbsp;</span>
                                        </div>
                                        <div class="rd" style="float: left;padding:0 5px;cursor: pointer">
                                            <input type="radio" value="all_gc"  name="assign" class="simple">                          
                                            <span class="lbl padding-8">Group Contacts&nbsp;</span>
                                        </div>
                                        <div class="rd" style="float: left;padding:0 5px;cursor: pointer">
                                            <input type="radio" value="all_l"  name="assign" class="simple">                          
                                            <span class="lbl padding-8">SMS List&nbsp;</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-5">
                                    <label id="lbl_select">Choose Contact</label>
                                    <div class="form-group" id="contact-tag">
                                        <input type="text" class="form-control"  id="contacts" />
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
                                                        <textarea id="body"  name="body" rows="10" cols="80" required=""></textarea>
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
                                            <strong>{CONTACT_FIRST_NAME}</strong><br/>
                                            <strong>{CONTACT_LAST_NAME}</strong><br/>
                                            <strong>{CONTACT_EMAIL}</strong><br/>
                                            <strong>{CONTACT_PHONE}</strong><br/>
                                            <!--<strong>{CONTACT_GROUP}</strong><br/>-->
                                            <strong>{CONTACT_BIRTHDAY}</strong><br/>
                                            <strong>{CONTACT_ZODIAC}</strong><br/>
                                            <strong>{CONTACT_AGE}</strong><br/>
                                            <strong>{CONTACT_BIRTHDAYALERT}</strong><br/>
                                            <strong>{CONTACT_SOCIAL}</strong><br/>
                                            <strong>{CONTACT_CONTACT}</strong><br/>
                                            <strong>{CONTACT_COUNTRY}</strong><br/>
                                            <strong>{CONTACT_CITY}</strong><br/>
                                            <strong>{CONTACT_ADDRESS}</strong><br/>
                                            <strong>{CONTACT_RATING}</strong><br/>
                                        </div><!-- /.box-body -->
                                    </div><!-- /.box -->
                                </div><!-- /.col -->
                            </div>
                            <div class="box-footer">
                                <div class="row">
                                    <div class="col-md-1">
                                        <button type="submit" class="btn btn-primary">SEND</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="contact_id" value="" />
                    </form>
                </div><!-- /.box -->
            </div><!--/.col (left) -->
            <!-- right column -->
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->
<script>
    var ids = new Array();
    var contact = new Array();
    function BindControls() {

<?php foreach ($individual as $key => $value) { ?>
            contact[<?= $key ?>] = "<?= $value->fname . '  ' . $value->lname . ' || ' . $value->phone ?>";
            ids[<?= $key ?>] = "<?= $value->contact_id ?>";
<?php } ?>
        $('#contacts').autocomplete({
            source: contact,
            minLength: 0,
            scroll: true
        }).focus(function () {
            $(this).autocomplete("search", "");
        });
    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        BindControls();
        $('#smsForm').submit(function () {
//            if ($('select[name="template_id"]').val() == "-1") {
//                alertify.error("Template must required..!");
//                return false;
//            }
            $('input[name="contact_id"]').val(ids[contact.indexOf($('#contacts').val())]);
        });

        $('input[name="assign"]').change(function () {
            if ($(this).val() == "all_c") {
                $("#lbl_select").text("Choose Contact");
                $('#contact-tag').html('<input type="text" class="form-control"  id="contacts" />');
                BindControls();
            } else if ($(this).val() == "all_gc") {
                $.ajax({
                    type: 'POST',
                    url: "<?= site_url() ?>admin/sms/allGroup",
                    success: function (data, textStatus, jqXHR) {
                        $("#lbl_select").text("Choose Group");
                        $('#contact-tag').html(data);
                    }
                });
            } else if ($(this).val() == "all_l") {
                $.ajax({
                    type: 'POST',
                    url: "<?= site_url() ?>admin/sms/allSMSlist",
                    success: function (data, textStatus, jqXHR) {
                        $("#lbl_select").text("Choose Group");
                        $('#contact-tag').html(data);
                    }
                });
            }
            else {
                return false;
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