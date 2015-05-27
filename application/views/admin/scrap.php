<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/checkbox.css"/>
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">
            Twilio Number Setting
        </h1>
        <button id="addTwilio" class="btn btn-success" type="button">
            <?= (isset($twilio)) ? "Update" : "Assign" ?>
        </button> 
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Assign Twilio Number</h3>
                    </div><!-- /.box-header -->
                    <?php $method = (isset($twilio)) ? "editNumber" : "addTwilioNumber"; ?>
                    <div class="box-body">
                        <form id="twilioForm" method="post" action="<?= site_url() ?>admin/setting/<?= $method ?>">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Choose Access Class</label>
                                        <select name="class_id" id="class" class="form-control" required="">
                                            <option value="-1">--Select--</option>
                                            <?php foreach ($class as $value) { ?>
                                                <option value="<?= $value->class_id ?>"><?= $value->class_name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-sm-3">
                                    <label>Country Code</label>
                                    <select name="code" class="form-control">
                                        <option value="+1">+1</option>
                                    </select>
                                </div>
                                <?php
                                $phone = (isset($twilio)) ?
                                        substr($twilio->twilio_number, -10) : "";
                                ?>
                                <div class="col-sm-5">
                                    <label>Phone Number</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-phone"></i>
                                        </div>
                                        <input name="twilio_number" value="<?= $phone ?>" type="text" class="form-control"  placeholder="Phone Number" data-inputmask='"mask": "(999) 999-9999"' data-mask required=""/>
                                    </div><!-- /.input group -->
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                            <br/>

                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </section><!-- /.content -->
</aside><!-- /.right-side -->

<!-- InputMask -->
<script src="<?= base_url() ?>assets/dashboard/js/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/input-mask/jquery.inputmask.date.extensions.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/dashboard/js/plugins/input-mask/jquery.inputmask.extensions.js" type="text/javascript"></script>

<script type="text/javascript">
    $(function () {
        $("[data-mask]").inputmask();
        $('.default-date-picker').datepicker({
            format: "dd-mm-yyyy",
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        });
    });
</script>

<!-- /.modal -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#addTwilio').click(function () {
            $('#twilioForm').submit();
        });
<?php if (isset($twilio)): ?>
            $('select[name="class_id"]').val("<?= $twilio->class_id ?>");
<?php endif; ?>

        $('#twilioForm').submit(function () {
            if ($('#class').val() == "-1") {
                alertify.error("Please Select Admin Access Class..!");
                return false;
            }
        });
    });
</script>