<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/dashboard/css/checkbox.css"/>
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="display: none">
            Import Contact
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Import Contact</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <form id="twilioForm" method="post">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Inmport From</label>
                                        <select name="type"  class="form-control" required="">
                                            <option value="facebook" selected="">Facebook</option>
                                            <option value="linkedin">LinkedIn</option>
                                            <option value="twitter">Twitter</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-sm-8">
                                    <label id="title">Username</label>
                                    <div class="input-group">
                                        <input name="url"  type="text" class="form-control" required=""/>
                                    </div><!-- /.input group -->
                                </div>
                                <div class="col-md-2"></div>
                            </div>
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