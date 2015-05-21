<style type="text/css">
    .title{
        color: #3c8dbc;
    }
</style>
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style=" display: none">
            Contact Profile
        </h1>
        <a href="<?= site_url() ?>admin/contacts/editContact/<?= $contact->contact_id ?>" class="create btn bg-navy">
            <i class="fa fa-edit"></i>
            Edit
        </a>
        <a href="<?= site_url() ?>admin/calender/createEvent/contact/<?= $contact->contact_id ?>" class="create btn btn-success">
            <i class="fa fa-plus"></i>
            Create Calender Event
        </a>
        <a href="<?= site_url() ?>admin/calender/createEvent/contact/<?= $contact->contact_id ?>?type=bday" class="create btn btn-warning">
            Schedule Birthday
        </a>
    </section>
    <?php
    $img_src = ($contact->contact_avatar != "") ?
            "http://mikhailkuznetsov.s3.amazonaws.com/" . $contact->contact_avatar :
            base_url() . 'assets/dashboard/img/default-avatar.png';
    ?>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12" >
<!--                <a style="margin-left: 10px" href="<?= site_url() ?>admin/contacts/editContact/<?= $contact->contact_id ?>" class="create btn bg-navy">
                    <i class="fa fa-edit"></i>
                    Edit
                </a>
                <a href="<?= site_url() ?>admin/calender/createEvent/contact/<?= $contact->contact_id ?>" class="create btn btn-success">
                    <i class="fa fa-plus"></i>
                    Create Calender Event
                </a>
                <a href="<?= site_url() ?>admin/calender/createEvent/contact/<?= $contact->contact_id ?>?type=bday" class="create btn btn-warning">
                    Schedule Birthday
                </a>-->
            </div>
        </div>
        <br/>
        <div class="box box-primary">
            <div class="box-header">
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="user-panel">
                            <div class="image" style="text-align: center">
                                <img style="width: 150px;height: 150px"  src="<?= $img_src ?>" class="img-circle" alt="User Image" />
                            </div>
                            <div class="info" style="text-align: center">
                                <h3 class="title" style="margin: 0"><?= $contact->fname . ' ' . $contact->lname ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" style="margin-top:10px ">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4"><label>Birthday</label></div>
                                <div class="col-md-8">
                                    <span class="title">
                                        <?= ($contact->birthday != NULL) ? date('d-m-Y', strtotime($contact->birthday)) : 'N/A' ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4"><label>Zodiac </label></div>
                                <div class="col-md-8">
                                    <span class="title"><?= $contact->zodiac ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4"><label>Phone</label></div>
                                <div class="col-md-8">
                                    <span class="title"><?= $contact->phone ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4"><label>E-mail</label></div>
                                <div class="col-md-8">
                                    <span class="title"><?= $contact->email ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-4"><label>Profile Rating</label></div>
                                <div class="col-md-8">
                                    <span class="title"><?= ($contact->rating != "-1") ? $contact->rating : 'N/A' ?></span>
                                </div>
                            </div>
                        </div>
                        <?php if ($contact->gender == "female"): ?>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4"><label>Crazy </label></div>
                                    <div class="col-md-8">
                                        <span class="title"><?= ($contact->crazy != "-1") ? $contact->crazy : 'N/A' ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4"><label>Hot </label></div>
                                    <div class="col-md-8">
                                        <span class="title"><?= ($contact->hot != "-1") ? $contact->hot : 'N/A' ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-md-12"><h4 style="margin-top: 5px">Contact Groups</h4></div>
                            <?php foreach ($groups as $value) { ?>
                                <?=
                                (in_array($value->group_id, $cgroup)) ?
                                        '<div class="col-md-12 title"><label>' . $value->group_name . '</label></div>' : ''
                                ?>
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- START CUSTOM TABS -->
        <div class="row">
            <div class="col-md-12">
                <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab">SMS</a></li>
                        <li><a href="#tab_2" data-toggle="tab">Email</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <form id="smsForm" role="form" action="<?= site_url() ?>admin/contacts/send_message" method="post" >
                                <div class="row">
                                    <?php $adminInfo = $this->common->getAdminInfo(); ?>
                                    <div class="col-md-3">
                                        <div class="pull-left" style="padding: 10px"><label>From</label></div>
                                        <div class="pull-left" style="padding: 10px"><span class="title"><?= ($adminInfo->twilio_number) ? $adminInfo->twilio_number : "N/A" ?></span></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="pull-left" style="padding: 10px"><label>To</label></div>
                                        <div class="pull-left" style="padding: 10px">
                                            <span class="title">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <?= $contact->phone ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Choose SMS Template</label>
                                            <select name="sms_template_id" class="form-control" required="">
                                                <option value="-1">--Select--</option>
                                                <?php foreach ($sms_template as $value) { ?>
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
                                                            <textarea id="smsbody"  name="body" rows="10" cols="80" required=""></textarea>
                                                        </div>
                                                    </div><!-- /.box -->
                                                </div>
                                            </div><!-- /.box-body -->
                                        </div>
                                    </div>
                                    <div class="col-md-3">
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
                                                <strong>{SOCIAL}</strong><br/>
                                                <strong>{COUNTRY}</strong><br/>
                                                <strong>{CITY}</strong><br/>
                                                <strong>{ADDRESS}</strong><br/>
                                                <strong>{RATING}</strong><br/>
                                            </div><!-- /.box-body -->
                                        </div><!-- /.box -->
                                    </div><!-- /.col -->
                                </div>
                                <div class="row">
                                    <div class="col-md-1">
                                        <button type="submit" class="btn btn-primary">SEND</button>
                                    </div>
                                </div>
                                <input type="hidden" name="cid" value="<?= $contact->contact_id ?>" />
                            </form>
                        </div><!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_2">
                            <form id="emailForm" role="form" action="<?= site_url() ?>admin/contacts/send_email" method="post" >
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="pull-left" style="padding: 10px"><label>From</label></div>
                                        <div class="pull-left" style="padding: 10px"><span class="title">info@mikhailkuznetsov.com</span></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="pull-left" style="padding: 10px"><label>To</label></div>
                                        <div class="pull-left" style="padding: 10px">
                                            <span class="title">
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <?= $contact->email ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Choose Email Template</label>
                                            <select name="email_template_id" class="form-control" required="">
                                                <option value="-1">--Select--</option>
                                                <?php foreach ($email_template as $value) { ?>
                                                    <option value="<?= $value->template_id ?>"><?= $value->name ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <label for="title">Email Subject</label>
                                            <input  type="text" name="subject" class="form-control" placeholder="Email Subject" required="" />
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
                                                            <textarea id="emailbody"  name="body" rows="10" cols="80" required=""></textarea>
                                                        </div>
                                                    </div><!-- /.box -->
                                                </div>
                                            </div><!-- /.box-body -->
                                        </div>
                                    </div>
                                    <div class="col-md-3">
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
                                                <strong>{SOCIAL}</strong><br/>
                                                <strong>{COUNTRY}</strong><br/>
                                                <strong>{CITY}</strong><br/>
                                                <strong>{ADDRESS}</strong><br/>
                                                <strong>{RATING}</strong><br/>
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
                                <input type="hidden" name="cid" value="<?= $contact->contact_id ?>" />
                            </form>
                        </div><!-- /.tab-pane -->
                    </div><!-- /.tab-content -->
                </div><!-- nav-tabs-custom -->
            </div><!-- /.col -->
        </div> <!-- /.row -->
        <!-- END CUSTOM TABS -->
    </section>
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<?php $msg = $this->input->get('msg'); ?>
<?php $data = $this->input->post(); ?>
<?php
switch ($msg) {
    case "T":
        $m = "Message Successfully Delivered..!";
        $t = "success";
        break;
    case "F":
        $m = "Message has not been delivered..!";
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

<script src="//cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $(function () {
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace('emailbody');
            //bootstrap WYSIHTML5 - text editor
            $(".textarea").wysihtml5();
        });

        $('select[name="sms_template_id"]').change(function () {
            var tempid = $(this).val();
            if (tempid == "-1") {
                return false;
            } else {
                $.ajax({
                    type: 'POST',
                    url: "<?= site_url() ?>admin/sms/getTemplate/" + tempid,
                    success: function (json, textStatus, jqXHR) {
                        var data = JSON.parse(json);
                        $('#smsbody').val(data.body);
                    }
                });
            }
        });
        $('select[name="email_template_id"]').change(function () {
            var tempid = $(this).val();
            if (tempid == "-1") {
                return false;
            } else {
                $.ajax({
                    type: 'POST',
                    url: "<?= site_url() ?>admin/email/getTemplate/" + tempid,
                    success: function (json, textStatus, jqXHR) {
                        var data = JSON.parse(json);
//                        $('#body').val(data.body);
                        $('input[name="subject"]').val(data.subject);
                        CKEDITOR.instances['emailbody'].setData(data.body);
                    }
                });
            }
        });
    });
</script>